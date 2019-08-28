<template>
    <div class="container">
<!--        <div data-aos="flip-up">-->
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold">
<!--                            <img :src="'img/companies/logosSmall/'+rep.logo_small_id" alt=""> -->
                            {{ rep.name}} - DOCUMENTS
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add Document <span><i class="cap-icon ci-plus"></i></span>
                            </button>
                        </div>
                        <hr>
                        <div class="">
                            <router-link to="/reps" class="nav-link btn btn-outline-secondary" tag="button">
                                <span><i class="cap-icon ci-arrow-left-circled"></i> BACK</span>
                            </router-link>
                            <div class=" card-tools mt-3">
                                <p>{{ rep.name }}</p>
                                <p>{{ rep.short_desc }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <appTableOptions
                            @pageSizeChanged="onPageSizeChanged"
                            @searchChanged="onSearchChanged"
                    ></appTableOptions>

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
                                    <th @click="sortBy('title')">Title
                                        <i v-if="sortKey === 'title'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                           class="ic">
                                        </i>
                                    </th>
                                    <th @click="sortBy('doc_id')">Document
                                        <i v-if="sortKey === 'doc_id'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                           class="ic">
                                        </i>
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
                                <tr v-for="repDet in repsSorted" :key="repDet.id">
                                    <td>{{ repDet.id }}</td>
                                    <td>{{ repDet.title }}</td>
                                    <td>{{ repDet.doc_id }}</td>
                                    <td>{{ repDet.created_at | customDate }}</td>
                                    <td>
                                        <button @click="editModal(repDet)"
                                                class="btn btn-info btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="Edit Company">
                                            <i class="cap-icon ci-file-edit"></i>
                                        </button>
                                        /
                                        <button  @click="deleteRep(repDet)"
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
                <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" v-if="editMode ? classes='edit' : classes='add'" :class="classes">
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">
                                <i class="cap-icon ci-plus icolor"></i> ADD NEW DOCUMENT
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i> UPDATE DOCUMENT
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form enctype="multipart/form-data" @submit.prevent="editMode ? updateRep() : createRep()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <input v-model="form.rep_id" name="rep_id" id="rep_id">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="form.title" id="title" type="text" name="title" placeholder="Title"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="doc_id" >Document</label>
                                    <input type="text" class="form-control" v-model="form.doc_id" name="doc_id" id="doc_id">
                                    <div class="col-sm-12">
                                        <input type="file" @change="onFileChange" name="doc" class="form-input" id="doc">
                                    </div>
                                </div>
  <!--                              <appUploadFiles
                                        :title="'Document'"
                                        :fieldname="'doc_id'"
                                        :imgsrc="docID"
                                        :imgplace="'docID'"
                                        :filetype="'doc'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>-->
                            </div>
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
<!--        </div>-->
    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import Paginations from '../shared/Paginations';
    import TableOptions from '../shared/TableOptions';
    import UploadFiles from '../shared/UploadFiles';
    import tableActions from '../../mixins/tableActions';
    import modalForm from '../../mixins/modalForm';

    export default {

        name: "RepDets",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm],

         props:
             {repID : {
                type: Object,
                 required: true
             }
         },

        data() {
            return {
                repDets: [],
                rep: [],

                form: new Form({
                    id: '',
                    title: '',
                    rep_id: '',
                    doc_id: '',
                    doc: null
                }),

                docID: ''
            }
        },

        computed: {

            ...mapGetters(['allReps', 'allRepDet', 'oneRep', 'allCities']),

            repsSorted() {
                let result = this.repDets.repDet;

                if (this.search) {
                    result = result.filter(item => item.title.toLowerCase().includes(this.search));
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

            ...mapActions(['fetchReps',
                'fetchRepDet',
                'fetchRep',
                'fetchCities']),

            loadReps() {
                if(this.$gate.isAdmin()) {
                    let repi = this.repID;
                    this.rep = repi;
                    this.fetchRepDet(repi);
                    this.repDets = this.$store.state.repDet;
                }
            },

            onFileChange(e){
                this.form.doc = e.target.files[0];
                console.log(this.form.doc);
            },

            onPageChange(page) {
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
            },

            imagesPlaces() {
                this.docID = 'img/companies/docs/'+this.form.doc_id;
            },

            createRep() {
                this.$Progress.start();
                this.form.rep_id = this.repID.id;
                this.form.post('api/reps_det')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Document added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateRep() {
                this.$Progress.start();
                let header = 'Accept: application/x-www-form-urlencoded';
                let data = new FormData();
                data.append('title', this.form.title);
                data.append('rep_id', this.form.rep_id);
                data.append('doc_id', this.form.doc_id);
                data.append('doc', this.form.doc);
                data.append('_method', 'put'); // add this
                axios.post('api/reps_det/'+this.form.id, data)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Document updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            deleteRep(rep){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/reps_det/'+rep.id).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'Document has been deleted.',
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
                this.fetchRepsS(query);
            });
            this.loadReps();
            this.fetchCities();
            this.cities = this.$store.state.cities;
            Fire.$on('AfterCreate', () => {
                this.loadReps();
            });
        }
    }
</script>

<style scoped>
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