<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

            <!-- Card -->
                <div class="card" data-aos="flip-up">
                    <div class="d-flex justify-content-between mt-3">
                        <div class="mt-3 ml-3">
                            <h3 class="card-title text-blue font-weight-bold h3">
                                <i class="fas fa-project-diagram"> </i>
                                PROJECT
                            </h3>
                        </div>
                        <router-link to="/projects" class="nav-link btn btn-outline-secondary mr-3" tag="button">
                            <span><i class="cap-icon ci-arrow-left-circled"></i> BACK</span>
                        </router-link>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <div class="ml-3 mt-3">
                            <div class="">
                                <span>Title : </span><h3 class="d-inline p-2 text-blue font-weight-bold"> {{ selProject.title }}</h3>
                            </div>
                            <div class="mt-2">
                                <span>Started : </span><h4 class="d-inline p-2"> {{ selProject.project_started | customDate }}</h4>
                            </div>
                            <div class="mt-2">
                                <span>Company : </span><h4 class="d-inline p-2"> {{ selProject.representation.name }}</h4>
                            </div>
                            <div class="mt-2">
                                <span>Description : </span><h4 class="d-inline p-2"> {{ selProject.description }}</h4>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div v-if="projectDets.projectDet.length">
                        <appTableOptions
                                :title="'PROJECT DETAILS'"
                                :button-title="'Detail'"
                                :at-click="newModal"
                                :button-icon="'fas fa-tasks fa-2x icolor'"
                                @pageSizeChanged="onPageSizeChanged"
                                @searchChanged="onSearchChanged"
                        ></appTableOptions>
                <!-- /.card-header -->
<!--                        <hr>-->
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
                                    <tr v-for="projectDet in repsSorted" :key="projectDet.id">
                                        <td>{{ projectDet.id }}</td>
                                        <td>{{ projectDet.date_added | tableDate }}</td>
                                        <td>{{ projectDet.caption }}</td>
                                        <td>{{ projectDet.note }}</td>
                                        <td>
                                            <a v-if="projectDet.doc_id" :href="'../img/projects/'+projectDet.doc_id"
                                               target="_blank">{{ projectDet.doc_id }}
                                            </a>
                                        </td>
                                        <td>{{ projectDet.user.name }}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input disabled type="checkbox" class="custom-control-input"
                                                       id="customCheck1" v-model="projectDet.finished">
                                                <label class="custom-control-label" for="customCheck1"></label>
                                            </div>
                                        </td>
                                        <td>{{ projectDet.created_at | customDate }}</td>
                                        <td>
                                            <button @click="editModal(projectDet)"
                                                    class="btn btn-info btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Edit Company">
                                                <i class="cap-icon ci-file-edit"></i>
                                            </button>
                                            /
                                            <button  @click="deleteItem(projectDet)"
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
                                No project details !
                            </h3>
                            <button class="btn btn-success" @click="newModal">
                                Add Project detail <span><i class="cap-icon ci-plus"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
<!--                <div v-else class="card" data-aos="flip-up" >dfghfh</div>-->
            <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" v-if="editMode ? classes='edit' : classes='add'" :class="classes">
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">
                                <i class="cap-icon ci-plus icolor"></i> ADD NEW PROJECT DETAIL
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i> UPDATE PROJECT DETAIL
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            <!-- /.modal-header -->
                        <form enctype="multipart/form-data"
                              @submit.prevent="editMode ? updateItem() : createItem()"
                              @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <input v-model="form.project_id" type="hidden" name="project_id" id="project_id">
                                <div class="form-group">
                                    <label>Date</label>
                                    <datepicker :format="'dd MM yyyy'" :bootstrap-styling="true"
                                                v-model="form.date_added" :class="{ 'is-invalid': form.errors.has('started') }">
                                    </datepicker>
                                    <has-error :form="form" field="started"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="caption">Caption</label>
                                    <input v-model="form.caption" id="caption" type="text" name="caption" placeholder="Caption"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('caption') }">
                                    <has-error :form="form" field="caption"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
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
                                    <input type="checkbox" class="custom-control-input cur" id="customCheck2"
                                           name="finished" v-model="form.finished">
                                    <label class="custom-control-label cur" for="customCheck2">FINISHED</label>
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
    import { mapGetters, mapActions, mapState } from 'vuex';
    import Paginations from '../shared/Paginations';
    import TableOptions from '../shared/TableOptions';
    import tableActions from '../../mixins/tableActions';
    import modalForm from '../../mixins/modalForm';
    import updateFile from '../../mixins/updateFile';
    import paginationActions from '../../mixins/paginationActions';
    import dataModifiers from '../../mixins/dataModifiers';
    import UploadFiles from '../shared/UploadFiles';
    import Datepicker from 'vuejs-datepicker';

    export default {

        name: "ProjectDets",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appUploadFiles: UploadFiles,
            Datepicker
        },

        mixins: [tableActions, modalForm, updateFile, paginationActions, dataModifiers],

        data() {
            return {
                projectDets: {},
                project: {},
                projectId: this.$route.params.id,
                selProject: this.$route.params.selProject,

                form: new Form({
                    id: '',
                    date_added: '',
                    caption: '',
                    note: '',
                    project_id: '',
                    finished: '',
                    doc_id: '',
                    doc: ''
                }),

                apiPath: '../api/project_dets',
                infoMessage: 'Project detail'

            }
        },
        /**
         * TODO create slugs
         * look at course how
         */
        computed: {

            loaded() {
                return this.$store.state.projects.projectLoading;
            },

            ...mapGetters(['allProjects', 'allProjectDet', 'oneProject']),

            repsSorted() {
                let result = this.projectDets.projectDet;

                if (this.search) {
                    result = result.filter(item => item.caption.toLowerCase().includes(this.search));
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
   /*     beforeRouteEnter (to, from, next) {
            if (store.state.projects.project.length === 0) {
                console.log(store.state.projects.project.length);
                store.dispatch(this.fetchProject(this.projectId))
                    .then(next);
            }
        },*/
        methods: {

            ...mapActions([
                'fetchProjects',
                'fetchProjectDet',
                'fetchProject'
            ]),

            loadProjects() {
                if(this.$gate.isAdmin()) {
                    /*this.fetchProject(this.projectId);
                    this.project = this.$store.state.projects.project;*/
                    this.fetchProjectDet(this.projectId);
                    this.projectDets = this.$store.state.projectDet;
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

/*            createProject() {
                this.$Progress.start();
                this.form.project_id = this.oneProject.id;
                let formData = this.projectData();

                axios.post('../api/project_dets', formData)
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Project detail added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },*/

 /*           updateProject() {
                this.$Progress.start();
                let formData = this.projectData(1);

                axios.post('../api/project_dets/'+this.form.id, formData)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Project detail updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },*/

            prepareData(action = '') {
                let data = new FormData();
                data.append('caption', this.form.caption);
                if (this.form.note !== null) data.append('note', this.form.note);
                data.append('date_added', this.form.date_added);
                if (this.form.doc_id !==  null) data.append('doc_id', this.form.doc_id);
                data.append('doc', this.form.doc);
                let trueFalse = this.form.finished == 0 ? 0 : 1;
                data.append('finished', trueFalse);
                if (action) {
                    data.append('project_id', this.form.project_id);
                    data.append('_method', 'put');
                } else {
                    data.append('project_id', this.selProject.id);
                }
                return data;
            },

     /*       deleteProject(project){
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
                        this.form.delete('../api/project_dets/'+project.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Project detail has been deleted.',
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
            },*/
        },

        created() {
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                this.fetchProjectsS(query);
            });

            this.loadProjects();

            Fire.$on('AfterCreate', () => {
                this.loadProjects();
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
    .cur {
        cursor: pointer;
    }
</style>
