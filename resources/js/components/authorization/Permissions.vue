<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-yellow font-weight-bold h3">
                            <i class="fas fa-user-lock fa-2x text-yellow"></i>
                            PERMISSIONS
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add Permission <span><i class="cap-icon ci-plus"></i></span>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="permission in permissions.permissions.data" :key="permission.id">
                                <td>{{ permission.id }}</td>
                                <td>{{ permission.name }}</td>
                                <td>{{ permission.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(permission)" class="btn btn-info btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="cap-icon ci-file-edit"></i>
                                    </button>
                                    <button  @click="deletePermission(permission)" class="btn btn-danger btn-sm"
                                             data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="cap-icon ci-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="permissions.permissions" @pagination-change-page="getResults">
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
                                Add New Permission
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i>
                                Update Permission
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updatePermission() : createPermission()"
                              @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
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

    export default {
        name: "Permissions",

        data() {
            return {
                permissions: {},
                form: new Form({
                    id: '',
                    name: '',
                    guard_name: ''
                }),
                editMode: true
            }
        },

        computed: mapGetters(['allPermissions']),

        methods: {
            ...mapActions(['fetchPermissions']),

            loadPermissions() {
                if(this.$gate.isAdmin()) {
                    this.fetchPermissions();
                    this.permissions = this.$store.state.permissions;
                }
            },

            getResults(page = 1) {
                this.fetchPermissions(page);
                this.permissions = this.$store.state.permissions;
            },

            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            editModal(permission) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(permission);
            },

            createPermission() {
                this.$Progress.start();
                this.form.post('api/permissions')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Permission added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updatePermission(id) {
                this.$Progress.start();
                this.form.put('api/permissions/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Permission updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            deletePermission(permission){
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
                        this.form.delete('api/permissions/'+permission.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Permission has been deleted.',
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
            this.loadPermissions();
            Fire.$on('AfterCreate', () => {
                this.loadPermissions();
            });
        }
    }
</script>

<style scoped>

</style>