<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <appTableOptions
                            :title="'PROJECTS'"
                            :button-title="'Project'"
                            :at-click="newModal"
                            :button-icon="'fas fa-boxes fa-2x icolor'"
                            @pageSizeChanged="onPageSizeChanged"
                            @searchChanged="onSearchChanged"
                    ></appTableOptions>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th @click="sortBy('id')">ID
                                    <i v-if="sortKey === 'id'" :class="classe"></i>
                                </th>
                                <th>Photo</th>
                                <th @click="sortBy('title')">Name
                                    <i v-if="sortKey === 'name'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('description')">Description
                                    <i v-if="sortKey === 'description'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('created_at')">Created At
                                    <i v-if="sortKey === 'created_at'" :class="classe"></i>
                                </th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="project in repsSorted" :key="project.id">
                                <router-link
                                        :to="{name:'proj', params: {id: project.id, selProject: project}}"
                                        activeClass="active" tag="a" class="nav-item nav-link">
                                    {{ project.id }}
                                </router-link>
<!--                                <td>{{ project.id }}</td>-->
                                <td></td>
                                <td>{{ project.name }}</td>
                                <td>{{ project.description }}</td>
                                <td>{{ project.created_at | customDate }}</td>
                                <appTableActions
                                        :action-title="'Project'"
                                        :at-click-edit="editModal.bind(this, project)"
                                        :at-click-delete="deleteProject.bind(this, project)"
                                ></appTableActions>
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
                        <appModalHeader
                                :title="'Project'"
                                :mode="editMode"
                        ></appModalHeader>
                        <!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateProject() : createProject()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <appUploadFiles
                                        :title="'Picture'"
                                        :fieldname="'photo_id'"
                                        :imgsrc="image"
                                        :imgplace="'image'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.description" type="text" name="description" placeholder="Description"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                    <has-error :form="form" field="description"></has-error>
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

    export default {
        name: "Projects",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appTableActions: TableActions,
            appModalActions: ModalActions,
            appModalHeader: ModalHeader,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm],

        data() {
            return {
                projects: {},

                form: new Form({
                    id: '',
                    photo_id: '',
                    name: '',
                    description: ''
                }),

                image: ''
            }
        },

        computed: {
            ...mapGetters(['allProjects']),

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
                'addProject',
                'renewProject',
                'removeProject'
            ]),

            loadProjects() {
                if(this.$gate.isAdmin()) {
                    this.fetchProjects();
                    this.projects = this.$store.state.projects;
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
                this.image = 'img/projects/'+this.form.photo_id;
            },

            createProject() {
                this.$Progress.start();
                this.form.post('api/project')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Project added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateProject(id) {
                this.$Progress.start();
                this.form.put('api/project/'+this.form.id)
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
                        console.log('qqqqqqqqqqqq');
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

</style>