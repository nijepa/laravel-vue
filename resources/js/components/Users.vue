<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>
                        <div class="card-tools">
                            <button class="btn btn-outline-success" @click="newModal()">
                                Add User <i class="fas fa-user-plus"></i>
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
                                <th>Email</th>
                                <th>Type</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td><span class="tag tag-success">{{ user.type | upText }}</span></td>
                                <td>{{ user.created_at | customDate }}</td>
                                <td>
                                    <button href="" @click="editModal(user)" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    /
                                    <button type="button" @click="deleteUser(user.id)" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete User">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New User</h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">Update User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateUser() : createUser()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input v-model="form.email" type="email" name="email" placeholder="Email"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input v-model="form.password" type="password" name="password" placeholder="Password"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Short bio for user (optional)</label>
                                    <input v-model="form.bio" type="text" name="bio" placeholder="Short bio for user (optional)"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                                    <has-error :form="form" field="bio"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>User role</label>
                                    <select v-model="form.type" name="type" id="type"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                        <option value="">Select user role</option>
                                        <option value="admin">Admin</option>
                                        <option value="author">Author</option>
                                        <option value="user">Standar user</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" v-show="!editMode" class="btn btn-success">Create</button>
                                <button type="submit" v-show="editMode" class="btn btn-success">Update</button>
                            </div>
                            <!-- /.modal-body -->
                        </form>
                        <!-- /.form -->
                    </div>
                </div>
            </div>
            <!-- /.Modal -->
        </div>
    </div>
</template>

<script>
    export default {
        name: "Users",
        data() {
            return {
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                }),
                editMode: true
            }
        },
        methods: {
            loadUsers() {
                axios.get("api/user")
                    .then(({ data }) => (this.users = data.data))
                    .catch();
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');

            },
            editModal(user) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(user);

            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                    .then(({ data }) => {
                        console.log(data);
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'User added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },
            updateUser(id) {
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'User updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
            deleteUser(id){
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
                        this.form.delete('api/user/'+id).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                            );
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            swal("Failed!", "There was something wrong.", "warning");
                        });
                    }
                })
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
                this.loadUsers();
            });
        }
    }
</script>

<style scoped>

</style>