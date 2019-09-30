<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">
                <!-- card -->
                <div class="card">
                    <!-- card-header -->
                    <appTableOptions
                            :title="'PROJECTS'"
                            :button-title="'Project'"
                            :at-click="newModal"
                            :button-icon="'fas fa-project-diagram fa-2x icolor'"
                            @pageSizeChanged="onPageSizeChanged"
                            @searchChanged="onSearchChanged"
                    ></appTableOptions>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <!-- table -->
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th @click="sortBy('id')">ID
                                    <i v-if="sortKey === 'id'" :class="classe" class="ic"></i>
                                </th>
                                <th @click="sortBy('project_started')">Started At
                                    <i v-if="sortKey === 'project_started'" :class="classe" class="ic"></i>
                                </th>
                                <th @click="sortBy('representation.name')">Company
                                    <i v-if="sortKey === 'representation.name'" :class="classe" class="ic"></i>
                                </th>
                                <th @click="sortBy('title')">Title
                                    <i v-if="sortKey === 'title'" :class="classe" class="ic"></i>
                                </th>
                                <th @click="sortBy('description')">Description
                                    <i v-if="sortKey === 'description'" :class="classe" class="ic"></i>
                                </th>
                                <th>File</th>
                                <th @click="sortBy('name')">User
                                    <i v-if="sortKey === 'name'" :class="classe" class="ic"></i>
                                </th>
                                <th @click="sortBy('finished')">Finished
                                    <i v-if="sortKey === 'finished'" :class="classe" class="ic"></i>
                                </th>
                                <th @click="sortBy('created_at')">Created At
                                    <i v-if="sortKey === 'created_at'" :class="classe" class="ic"></i>
                                </th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <!-- /.table-header -->
                            <tbody>
                            <tr v-for="project in repsSorted" :key="project.id">
                                <td>
                                    <router-link
                                            :to="{name:'proj', params: {id: project.id, selProject: project}}"
                                            activeClass="active" tag="a" class="btn btn-secondary btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="View Details">
                                        <i class="fas fa-tasks">  {{ project.id }}</i>
                                    </router-link>
                                </td>
                                <td>{{ project.project_started | tableDate }}</td>
<!--                                <td><datepicker :input-class="`qqq`" :disabled="true" :bootstrap-styling="true" v-model="project.project_started"></datepicker></td>-->
                                <td>
                                    <span class="tag tag-success">
                                        {{ project.representation_id ? project.representation.name : 'not selected'  }}
                                    </span>
                                </td>
                                <td>{{ project.title }}</td>
                                <td>{{ project.description }}</td>
                                <td>
                                    <a v-if="project.doc_id" :href="'img/projects/'+project.doc_id" target="_blank">{{ project.doc_id }}</a>
                                </td>
                                <td>{{ project.user.name }}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input disabled type="checkbox" class="custom-control-input"
                                               id="customCheck1" v-model="project.finished">
                                        <label class="custom-control-label" for="customCheck1"></label>
                                    </div>
                                </td>
                                <td>{{ project.created_at | customDate }}</td>
                                <appTableActions
                                        :action-title="'Project'"
                                        :at-click-edit="editModal.bind(this, project)"
                                        :at-click-delete="deleteProject.bind(this, project)"
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
                                :title="'Project'"
                                :mode="editMode"
                        ></appModalHeader>
                        <!-- /.modal-header -->
                        <!-- form -->
                        <form @submit.prevent="editMode ? updateProject() : createProject()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="project_started">Date</label>
                                    <datepicker :format="'dd MMM yyyy'" :bootstrap-styling="true" id="project_started"
                                                name="project_started" placeholder="Project started date"
                                                v-model="form.project_started"
                                                :class="{ 'is-invalid': form.errors.has('project_started') }">
                                    </datepicker>
                                    <has-error :form="form" field="project_started"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="form.title" type="text" id="title" name="title" placeholder="Title"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="representation_id">Company</label>
                                    <select v-model="form.representation_id" name="representation_id" id="representation_id"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('representation_id') }">
                                        <option v-bind:value="rep.id"
                                                :key="rep.id"
                                                v-for="rep in reps.reps">{{ rep.name }}</option>
                                    </select>
                                    <has-error :form="form" field="representation_id"></has-error>
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
                                    <label for="doc_id">Document</label>
                                    <input type="text" class="form-control" v-model="form.doc_id" name="doc_id" id="doc_id" disabled>
                                    <input type="file" @change="onFileChange" name="doc" class="form-input" id="doc">
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input cur" id="customCheck2"
                                           name="finished" v-model="form.finished">
                                    <label class="custom-control-label cur" for="customCheck2">FINISHED</label>
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
        name: "Projects",

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
                projects: {},
                reps: [],

                form: new Form({
                    id: '',
                    title: '',
                    description: '',
                    representation_id: '',
                    finished: 0,
                    project_started: '',
                    doc_id: '',
                    doc: null
                }),
            }
        },

        computed: {
            ...mapGetters(['allProjects', 'allReps']),

            repsSorted() {
                let result = this.projects.projects;

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
                'fetchProjects',
                'fetchProjectsP',
                'fetchProjectsS',
                'fetchReps'
            ]),

            loadProjects() {
                if(this.$gate.isAdmin()) {
                    this.fetchProjects();
                    this.projects = this.$store.state.projects;
                    this.fetchReps();
                    this.reps = this.$store.state.representations;
                }
            },

            /*onFileChange(e){
                let file = e.target.files[0];
                let limit = 1024 * 1024 * 2;
                let type = [
                    'application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/msword',
                    'message/rfc822'];

                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });
                    return false;
                }
                //console.log(file['type']);
                if(!type.includes(file['type'])) {
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You need to upload document file',
                    });
                    return false;
                }

                this.form.doc = e.target.files[0];
                console.log(this.form.doc);
                this.form.doc_id = this.form.doc.name;
            },*/

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
                this.image = 'img/projects/'+this.form.photo_id;
            },

            createProject() {
                this.$Progress.start();
                let formData = this.prepareData();

                axios.post('api/project', formData)
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Project added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        console.log(this.form.errors)
                    })
            },

            updateProject(id) {
                this.$Progress.start();
                let formData = this.prepareData(1);

                axios.post('../api/project/'+this.form.id, formData)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Project updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            prepareData(action = '') {
                let data = new FormData();
                data.append('project_started', this.form.project_started);
                data.append('title', this.form.title);
                data.append('description', this.form.description);
                data.append('representation_id', this.form.representation_id);
                data.append('doc_id', this.form.doc_id);
                data.append('doc', this.form.doc);
                let trueFalse = this.form.finished == 0 ? 0 : 1;
                console.log(trueFalse);
                data.append('finished', trueFalse);
                //data.append('finished', this.form.finished);

                if (action) {
                    data.append('_method', 'put');
                }
                return data;
            },

            deleteProject(project){
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
                        this.form.delete('api/project/'+project.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Project has been deleted.',
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
    .qqq {
        width: 110px !important;
        background-color: white !important;
        border-color: white !important;
    }
    .cur {
        cursor: pointer;
    }
    th {
        cursor:pointer;
    }
    .ic {
        color: #4cb2e9;
    }
</style>