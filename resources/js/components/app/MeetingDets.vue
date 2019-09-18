<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

            <!-- Card -->
                <div class="card" data-aos="flip-up">
                    <div class="d-flex justify-content-between mt-3">
                        <div class="ml-3 mt-3">
                            <div class="">
                                <h3 class="d-inline p-2 text-blue font-weight-bold">{{ oneMeeting.title }}</h3>
                            </div>
                            <div class="mt-2">
                                <h4 class="d-inline p-2">{{ oneMeeting.description }}</h4>
                            </div>
                        </div>
                        <router-link to="/meetings" class="nav-link btn btn-outline-secondary mr-3" tag="button">
                            <span><i class="cap-icon ci-arrow-left-circled"></i> BACK</span>
                        </router-link>
                    </div>
                    <hr>
                    <div v-if="meetingDets.meetingDet.length">
                        <appTableOptions
                                :title="'MEETING DETAILS'"
                                :button-title="'Detail'"
                                :at-click="newModal"
                                :button-icon="'far fa-handshake fa-2x icolor'"
                                @pageSizeChanged="onPageSizeChanged"
                                @searchChanged="onSearchChanged"
                        ></appTableOptions>
                <!-- /.card-header -->
                        <hr>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th @click="sortBy('id')">ID
                                            <i v-if="sortKey === 'id'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th @click="sortBy('date_added')">Started At
                                            <i v-if="sortKey === 'date_added'" :class="classe"></i>
                                        </th>
                                        <th @click="sortBy('caption')">Caption
                                            <i v-if="sortKey === 'caption'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th @click="sortBy('note')">Note
                                            <i v-if="sortKey === 'note'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th>File</th>
                                        <th @click="sortBy('name')">User
                                            <i v-if="sortKey === 'name'" :class="classe"></i>
                                        </th>
                                        <th @click="sortBy('finished')">Finished
                                            <i v-if="sortKey === 'finished'" :class="classe"></i>
                                        </th>
                                        <th @click="sortBy('created_at')">Created At
                                            <i v-if="sortKey === 'created_at'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <tr v-for="meetingDet in repsSorted" :key="meetingDet.id">
                                        <td>{{ meetingDet.id }}</td>
                                        <td>{{ meetingDet.date_added | tableDate }}</td>
                                        <td>{{ meetingDet.caption }}</td>
                                        <td>{{ meetingDet.note }}</td>
                                        <td >
                                            <a v-if="meetingDet.doc_id" :href="'../img/meetings/'+meetingDet.doc_id" target="_blank">{{ meetingDet.doc_id }}</a>
                                        </td>
                                        <td>{{ meetingDet.user.name }}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input disabled type="checkbox" class="custom-control-input" id="customCheck1" v-model="meetingDet.finished">
                                                <label class="custom-control-label" for="customCheck1"></label>
                                            </div>
                                        </td>
                                        <td>{{ meetingDet.created_at | customDate }}</td>
                                        <td>
                                            <button @click="editModal(meetingDet)"
                                                    class="btn btn-info btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Edit Company">
                                                <i class="cap-icon ci-file-edit"></i>
                                            </button>
                                            /
                                            <button  @click="deleteMeeting(meetingDet)"
                                                     class="btn btn-danger btn-sm"
                                                     data-toggle="tooltip" data-placement="top" title="Delete Company">
                                                <i class="cap-icon ci-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                <!-- /.card-body -->
                        <div class="card-footer">
                            <appPagination
                                    :maxVisibleButtons="totalPages"
                                    :total-pages="totalPages"
                                    :total="totalPages"
                                    :per-page="3"
                                    :current-page="currentPage"
                                    @pagechanged="onPageChange"
                            ></appPagination>
                        </div>
                    </div>
                    <div v-else class="card m-2">
                        <div class="d-flex justify-content-center my-3">
                            <h3 class="text-blue font-weight-bold m-3">
                                No meeting details !
                            </h3>
                            <button class="btn btn-success" @click="newModal">
                                Add Meeting detail <span><i class="cap-icon ci-plus"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" v-if="editMode ? classes='edit' : classes='add'" :class="classes">
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">
                                <i class="cap-icon ci-plus icolor"></i> ADD NEW MEETING DETAIL
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i> UPDATE MEETING DETAIL
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            <!-- /.modal-header -->
                        <form enctype="multipart/form-data"
                              @submit.prevent="editMode ? updateMeeting() : createMeeting()"
                              @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <input v-model="form.meeting_id" type="hidden" name="meeting_id" id="meeting_id">
                                <div class="form-group">
                                    <label>Date</label>
                                    <datepicker :format="'dd MM yyyy'" :bootstrap-styling="true"
                                                v-model="form.date_added" :class="{ 'is-invalid': form.errors.has('started') }">
                                    </datepicker>
                                    <has-error :form="form" field="started"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="representation_id">Company</label>
                                    <select v-model="form.representation_id" name="representation_id" id="representation_id"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                        <option v-bind:value="rep.id"
                                                :key="rep.id"
                                                v-for="rep in reps.reps">{{ rep.name }}</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="caption">Caption</label>
                                    <input v-model="form.caption" id="caption" type="text" name="caption" placeholder="Caption"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('caption') }">
                                    <has-error :form="form" field="caption"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea v-model="form.note" type="text" id="note" name="note" placeholder="Note"
                                              class="form-control" :class="{ 'is-invalid': form.errors.has('note') }"></textarea>
                                    <has-error :form="form" field="note"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="doc_id" >Document</label>
                                    <input type="text" class="form-control" v-model="form.doc_id" name="doc_id" id="doc_id" disabled>
                                    <input type="file" @change="onFileChange" name="doc" class="form-input" id="doc">
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck2"
                                           name="finished" v-model="form.finished">
                                    <label class="custom-control-label" for="customCheck2">FINISHED</label>
                                </div>
                            </div>
            <!-- /.modal-body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close
                                    <span><i class="cap-icon ci-times"></i></span>
                                </button>
                                <button type="submit" v-show="!editMode" class="btn btn-success">Create
                                    <span><i class="cap-icon ci-check"></i></span>
                                </button>
                                <button type="submit" v-show="editMode" class="btn btn-success">Update
                                    <span><i class="cap-icon ci-save"></i></span>
                                </button>
                            </div>
            <!-- /.modal-footer -->
                        </form>
            <!-- /.form -->
                    </div>
                </div>
            </div>
            <!-- /.Modal -->
        </div>
        <div class="row" v-else>
            <unauthorized></unauthorized>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import Paginations from '../shared/Paginations';
    import TableOptions from '../shared/TableOptions';
    import tableActions from '../../mixins/tableActions';
    import modalForm from '../../mixins/modalForm';
    import updateFile from '../../mixins/updateFile';
    import paginationActions from '../../mixins/paginationActions';
    import UploadFiles from '../shared/UploadFiles';
    import Datepicker from 'vuejs-datepicker';

    export default {

        name: "MeetingDets",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appUploadFiles: UploadFiles,
            Datepicker
        },

        mixins: [tableActions, modalForm, updateFile, paginationActions],

        data() {
            return {
                meetingDets: {},
                meeting: {},
                reps: [],
                meetingId: this.$route.params.id,
                selMeeting: this.$route.params.selMeeting,

                form: new Form({
                    id: '',
                    date_added: '',
                    caption: '',
                    note: '',
                    meeting_id: '',
                    representation_id: '',
                    finished: '',
                    doc_id: '',
                    doc: null
                }),
            }
        },
        /**
         * TODO create slugs
         * look at course how
         */
        computed: {

            ...mapGetters(['allMeetings', 'allMeetingDet', 'oneMeeting', 'allReps']),

            repsSorted() {
                let result = this.meetingDets.meetingDet;

                if (this.search) {
                    result = result.filter(item => item.title.toLowerCase().includes(this.search));
                }

                result =  _.orderBy(result, this.sortKey, this.sortOrder);

                console.log(result);

                return result.filter((row, index) => {
                    this.totalPages = Math.ceil(result.length / this.pageSize);
                    let start = (this.currentPage - 1) * this.pageSize;
                    let end = this.currentPage * this.pageSize;
                    if (index >= start && index < end) return true;
                });
            },
        },

        methods: {

            ...mapActions([
                'fetchMeetings',
                'fetchMeetingDet',
                'fetchMeeting',
                'fetchReps',
            ]),

            loadMeetings() {
                if(this.$gate.isAdmin()) {
                    this.fetchMeeting(this.meetingId);
                    this.meeting = this.$store.state.meeting;
                    this.fetchMeetingDet(this.meetingId);
                    this.meetingDets = this.$store.state.meetingDet;
                    this.fetchReps();
                    this.reps = this.$store.state.representations;
                }
            },

           /* onPageChange(page) {
                console.log(page);
                this.currentPage = page;
            },

            onPageSizeChanged(ps) {
                this.onPageChange(1);
                this.pageSize = ps;
            },

            onSearchChanged(s) {
                this.onPageChange(1);
                this.search = s;
            },*/

            imagesPlaces() {
                this.logo = 'img/companies/'+this.form.logo_id;
            },

            createMeeting() {
                this.$Progress.start();
                this.form.meeting_id = this.oneMeeting.id;
                let formData = this.meetingData();

                axios.post('../api/meeting_dets', formData)
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Meeting detail added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateMeeting() {
                this.$Progress.start();
                let formData = this.meetingData(1);

                axios.post('../api/meeting_dets/'+this.form.id, formData)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Meeting detail updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            meetingData(action = '') {
                let data = new FormData();
                data.append('caption', this.form.caption);
                data.append('note', this.form.note);
                data.append('date_added', this.form.date_added);
                let trueFalse = this.form.finished === false ? 0 : 1;
                data.append('finished', trueFalse);
                data.append('meeting_id', this.form.meeting_id);
                data.append('representation_id', this.form.representation_id);
                data.append('doc_id', this.form.doc_id);
                data.append('doc', this.form.doc);
                if (action) data.append('_method', 'put');
                return data;
            },

            deleteMeeting(meeting){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('../api/meeting_dets/'+meeting.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Meeting detail has been deleted.',
                                    'success'
                                );
                                Fire.$emit('AfterCreate');
                            }).catch(()=> {
                                swal("Failed!", "There was something wrong.", "warning");
                            });
                    } else {
                        console.log('error');
                    }
                })
            },
        },

        created() {
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                this.fetchMeetingsS(query);
            });

            this.loadMeetings();

            Fire.$on('AfterCreate', () => {
                this.loadMeetings();
            });
        }
    }
</script>

<style scoped>
    .table-hover tbody tr:nth-of-type(odd) {
        background-color: rgb(217, 255, 251);
    }

    .table-hover tbody tr:nth-of-type(odd):hover {
        background-color: rgb(187, 215, 215);
    }

    a {
        font-weight: bold;
        color: #3a68c1;
        text-decoration: none;
    }

    a:hover {
        font-weight: bold;
        color: #4cb2e9;
    }

    td, th {
        padding: 5px;
    }

    th {
        cursor:pointer;
    }

    .ic {
        color: #4cb2e9;
    }

    .edit {
        background-color: #4cb2e9;
    }

    .add {
        background-color: #34c67d;
    }
</style>