<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card-header -->
                    <appTableOptions
                            :title="'MEETINGS'"
                            :button-title="'Meeting'"
                            :at-click="newModal"
                            :button-icon="'fas fa-handshake fa-2x icolor'"
                            @pageSizeChanged="onPageSizeChanged"
                            @searchChanged="onSearchChanged"
                    ></appTableOptions>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <!-- table -->
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th @click="sortBy('id')">ID
                                    <i v-if="sortKey === 'id'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('meeting_started')">Started At
                                    <i v-if="sortKey === 'meeting_started'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('name')">Company
                                    <i v-if="sortKey === 'name'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('title')">Title
                                    <i v-if="sortKey === 'title'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('description')">Description
                                    <i v-if="sortKey === 'description'" :class="classe"></i>
                                </th>
                                <th>File</th>
                                <th @click="sortBy('name')">User
                                    <i v-if="sortKey === 'name'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('finished')">Finished
                                    <i v-if="sortKey === 'finished'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('created_at')">Created At
                                    <i v-if="sortKey === 'created_at'" :class="classe"></i>
                                </th>
                                <th>Modify</th>
                            </tr>
                            <!-- /.table-header -->
                            <tr v-for="meeting in repsSorted" :key="meeting.id">
                                <td>
                                    <router-link
                                            :to="{name:'meet', params: {id: meeting.id, selMeeting: meeting}}"
                                            activeClass="active" tag="a" class="nav-item nav-link">
                                        {{ meeting.id }}
                                    </router-link>
                                </td>
                                <td>{{ meeting.meeting_started | tableDate }}</td>
<!--                                <td><datepicker :input-class="`qqq`" :disabled="true" :bootstrap-styling="true" v-model="meeting.meeting_started"></datepicker></td>-->
                                <td>
                                    <span class="tag tag-success">
                                        {{ meeting.representation_id ? meeting.representation.name : 'not selected'  }}
                                    </span>
                                </td>
                                <td>{{ meeting.title }}</td>
                                <td>{{ meeting.description }}</td>
                                <td>
                                    <a :href="'img/meetings/'+meeting.doc_id" target="_blank">{{ meeting.doc_id }}</a>
                                </td>
                                <td>{{ meeting.user.name }}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input disabled type="checkbox" class="custom-control-input"
                                               id="customCheck1" v-model="meeting.finished">
                                        <label class="custom-control-label" for="customCheck1"></label>
                                    </div>
                                </td>
                                <td>{{ meeting.created_at | customDate }}</td>
                                <appTableActions
                                        :action-title="'meeting'"
                                        :at-click-edit="editModal.bind(this, meeting)"
                                        :at-click-delete="deletemeeting.bind(this, meeting)"
                                ></appTableActions>
                            </tr>
                            </tbody>
                        </table>
                        <!-- /.table -->
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
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <appModalHeader
                                :title="'meeting'"
                                :mode="editMode"
                        ></appModalHeader>
                        <!-- /.modal-header -->
                        <!-- form -->
                        <form @submit.prevent="editMode ? updatemeeting() : createmeeting()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Date</label>
                                    <datepicker :format="'dd MMM yyyy'" :bootstrap-styling="true"
                                                v-model="form.meeting_started" :class="{ 'is-invalid': form.errors.has('started') }">
                                    </datepicker>
                                    <has-error :form="form" field="started"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="form.title" type="text" id="title" name="title" placeholder="Title"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="type">Company</label>
                                    <select v-model="form.representation_id" name="type" id="type"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                        <option v-bind:value="rep.id"
                                                :key="rep.id"
                                                v-for="rep in reps.reps">{{ rep.name }}</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="form.description" type="text" id="description" name="description"
                                              placeholder="Description"
                                              class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                    </textarea>
                                    <has-error :form="form" field="description"></has-error>
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
                            <appModalActions
                                    :mode="editMode"
                            ></appModalActions>
                            <!-- /.modal-body -->
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
    import TableActions from '../shared/TableActions';
    import ModalActions from '../shared/ModalActions';
    import ModalHeader from '../shared/ModalHeader';
    import UploadFiles from '../shared/UploadFiles';
    import tableActions from '../../mixins/tableActions';
    import modalForm from '../../mixins/modalForm';
    import updateFile from '../../mixins/updateFile';
    import Datepicker from 'vuejs-datepicker';

    export default {
        name: "meetings",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appTableActions: TableActions,
            appModalActions: ModalActions,
            appModalHeader: ModalHeader,
            appUploadFiles: UploadFiles,
            Datepicker
        },

        mixins: [tableActions, modalForm, updateFile],

        data() {
            return {
                meetings: {},
                reps: [],

                form: new Form({
                    id: '',
                    title: '',
                    description: '',
                    representation_id: '',
                    finished: '',
                    meeting_started: '',
                    doc_id: '',
                    doc: null
                }),
            }
        },

        computed: {
            ...mapGetters(['allMeetings', 'allReps']),

            repsSorted() {
                let result = this.meetings.meetings;

                if (this.search) {
                    result = result.filter(item => item.name.toLowerCase().includes(this.search));
                }

                result =  _.orderBy(result, this.sortKey, this.sortOrder);

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
                'fetchReps'
            ]),

            loadmeetings() {
                if(this.$gate.isAdmin()) {
                    this.fetchMeetings();
                    this.meetings = this.$store.state.meetings;
                    this.fetchReps();
                    this.reps = this.$store.state.representations;
                }
            },

            onPageChange(page) {
                this.currentPage = page;
            },

            onPageSizeChanged(ps) {
                this.onPageChange(1);
                this.pageSize = ps;
            },

            onSearchChanged(s) {
                this.onPageChange(1);
                this.search = s;
            },

            imagesPlaces() {
                this.image = 'img/meetings/'+this.form.photo_id;
            },

            createmeeting() {
                this.$Progress.start();
                let formData = this.prepareData();

                axios.post('api/meeting', formData)
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'meeting added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updatemeeting(id) {
                this.$Progress.start();
                let formData = this.prepareData(1);

                axios.post('../api/meeting/'+this.form.id, formData)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'meeting updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            prepareData(action = '') {
                let data = new FormData();
                data.append('meeting_started', this.form.meeting_started);
                data.append('title', this.form.title);
                data.append('description', this.form.description);
                data.append('representation_id', this.form.representation_id);
                data.append('doc_id', this.form.doc_id);
                data.append('doc', this.form.doc);
                let trueFalse = this.form.finished === false ? 0 : 1;
                data.append('finished', trueFalse);
                //data.append('finished', this.form.finished);

                if (action) {
                    data.append('_method', 'put');
                }
                return data;
            },

            deletemeeting(meeting){
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
                        this.form.delete('api/meeting/'+meeting.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'meeting has been deleted.',
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
            }
        },
        created() {
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                this.fetchmeetingsS(query);
            });

            this.loadmeetings();

            Fire.$on('AfterCreate', () => {
                this.loadmeetings();
            });
        }
    }
</script>

<style module>
    .qqq {
        width: 110px !important;
        background-color: white !important;
        border-color: white !important;
    }
</style>