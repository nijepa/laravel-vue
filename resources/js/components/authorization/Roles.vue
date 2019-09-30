<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-yellow font-weight-bold h3">
                            <i class="fas fa-user-tag fa-2x icolor"> </i>
                            ROLES
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add Role <span><i class="cap-icon ci-plus"></i></span>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Permission</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="role in roles.roles.data" :key="role.id">
                                <td>{{ role.id }}</td>
                                <td>{{ role.name }}</td>
                                <td>
                                    <multiselect v-model="role.permissions" :options="options" :multiple="true"
                                                 placeholder="none selected" track-by="name" label="name" disabled>
                                    </multiselect>
                                </td>
                                <td>{{ role.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(role)" class="btn btn-info btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="Edit User">
                                        <i class="cap-icon ci-file-edit"></i>
                                    </button>
                                    /
                                    <button  @click="deleteRole(role)" class="btn btn-danger btn-sm"
                                             data-toggle="tooltip" data-placement="top" title="Delete User">
                                        <i class="cap-icon ci-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="roles.roles" @pagination-change-page="getResults">
                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">
                                <i class="cap-icon ci-plus icolor"></i>
                                Add New Role
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i>
                                Update Role
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateRole() : createRole()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label class="typo__label">Permissions</label>
                                    <multiselect v-model="form.permissions"
                                                 :options="options"
                                                 :multiple="true"
                                                 placeholder="Type to search"
                                                 track-by="name"
                                                 label="name"
                                                 :class="{ 'is-invalid': form.errors.has('type') }">
                                        <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
                                    </multiselect>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
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
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import Multiselect from 'vue-multiselect'

    export default {
        name: "Roles",

        components: {Multiselect},

        data() {
            return {
                roles: {},
                permissions: [],
                value: [],
                options: [],
                form: new Form({
                    id: '',
                    name: '',
                    permissions: [],
                }),
                editMode: true
            }
        },

        computed: mapGetters(['allRoles', 'allPermissions']),

        methods: {
            ...mapActions([
                'fetchRoles',
                'fetchPermissions'
            ]),

            loadRoles() {
                if(this.$gate.isAdmin()) {
                    this.fetchRoles();
                    this.roles = this.$store.state.roles;
                }
            },

            getResults(page = 1) {
                this.fetchRoles(page);
                this.roles = this.$store.state.roles;
            },

            newModal() {
                this.options = this.permissions.permissions.data;
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            editModal(role) {
                this.options = this.permissions.permissions.data;
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(role);
            },

            createRole() {
                this.$Progress.start();
                this.form.post('api/roles')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Role added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateRole(id) {
                this.$Progress.start();
                this.form.put('api/roles/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Role updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            deleteRole(role){
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
                        //this.removeCity(city);
                        this.form.delete('apis/roles/'+role.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Role has been deleted.',
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
            this.loadRoles();
            this.fetchPermissions();
            this.permissions = this.$store.state.permissions;
            Fire.$on('AfterCreate', () => {
                this.loadRoles();
            });
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css">

</style>