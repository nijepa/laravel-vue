<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3"><i class="fas fa-users fa-2x icolor"></i> USERS</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add User <span><i class="fas fa-user-plus"></i></span>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="user in users.users.data" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td><img :src="'img/profile/'+user.photo" alt="" style="height: 50px"></td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td><span class="tag tag-success">{{ user.type | upText }}</span></td>
                                <td>{{ user.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(user)" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    /
                                    <button  @click="deleteUser(user)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete User">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="users.users" @pagination-change-page="getResults">
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
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel"><i class="fas fa-plus icolor"></i> Add New User</h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel"><i class="fas fa-edit icolor"></i> Update User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateUser() : createUser()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div  class="form-group">
                                    <img :src="'img/profile/'+form.photo" alt="" style="height: 50px" alt="User Avatar">
                                </div>
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
                                    <label for="photo" class="col-sm-2 control-label">Photo</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updatePhoto" name="photo" class="form-input">
                                    </div>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <span><i class="far fa-window-close"></i></span></button>
                                <button type="submit" v-show="!editMode" class="btn btn-success">Create <span><i class="far fa-check-circle"></i></span></button>
                                <button type="submit" v-show="editMode" class="btn btn-success">Update <span><i class="far fa-save"></i></span></button>
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

        computed: {
            ...mapGetters(['allUsers']),
        },

        methods: {

            ...mapActions(['fetchUsers',
                'fetchUsersP',
                'fetchUsersS',
                'addUser',
                'renewUser',
                'removeUser']),

            loadUsers() {
                if(this.$gate.isAdmin()) {
                    /*              axios.get("api/user")
                                      .then(({ data }) => (this.users = data))
                                      .catch();*/
                    this.fetchUsersP();
                    this.users = this.$store.state.users;
                }
            },

            getResults(page = 1) {
                this.fetchUsersP(page);
                this.users = this.$store.state.users;
        /*        axios.get('api/user?page=' + page)
                    .then(response => {
                        console.log(response.data);
                        this.users = response.data;
                    });*/
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
                //this.addUser(this.form);
                 this.form.post('api/user')
                     .then(({ data }) => {
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
                //this.renewUser(this.form);
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

            deleteUser(user){
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
                        //this.removeUser(user);
                        this.form.delete('api/user/'+user.id).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'User has been deleted.',
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
            },

            getProfilePhoto() {
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },

            updatePhoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            },
        },

        created() {
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                this.fetchUsersS(query);
        /*        axios.get('api/findUser?q=' + query)
                    .then((data) => {
                        console.log(data);
                        this.users = data.data
                    })
                    .catch(() => {

                    })*/
            });
            // this.fetchUsers();
            // this.users = this.$store.state.users;
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
                this.loadUsers();
            });
        }
    }
</script>

<style scoped>

</style>