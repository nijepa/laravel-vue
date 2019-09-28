<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
       <!--             <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3"><i class="fas fa-users fa-2x icolor"></i> USERS</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add User <span><i class="fas fa-user-plus"></i></span>
                            </button>
                        </div>
                    </div>-->
                    <!-- /.card-header -->
                    <appTableOptions
                        :title="'USERS'"
                        :button-title="'User'"
                        :at-click="newModal"
                        :button-icon="'fas fa-users fa-2x icolor'"
                        @pageSizeChanged="onPageSizeChanged"
                        @searchChanged="onSearchChanged">
                    </appTableOptions>
     <!--               <div class="d-flex align-items-center">
                        <div class="form-group ml-3 mt-3">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" v-model="search" placeholder="Search">
                        </div>
                        <div class="form-group ml-auto mr-3 mt-3">
                            <label>Items per page</label>
                            <select v-model="pageSize" name="type" class="form-control" id="ps">
                                <option value="5">5</option>
                                <option value="3">3</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>-->
                    <hr>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th @click="sortBy('id')">ID
                                        <i v-if="sortKey === 'id'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic">
                                        </i>
                                    </th>
                                    <th>Photo</th>
                                    <th @click="sortBy('name')">Name
                                        <i v-if="sortKey === 'name'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic">
                                        </i>
                                    </th>
                                    <th @click="sortBy('email')">Email
                                        <i v-if="sortKey === 'email'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic">
                                        </i>
                                    </th>
                                    <th @click="sortBy('type')">Type
                                        <i v-if="sortKey === 'type'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic">
                                        </i>
                                    </th>
                                    <th @click="sortBy('created_at')">Created At
                                        <i v-if="sortKey === 'created_at'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic">
                                        </i>
                                    </th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
<!--                            <tr v-for="user in users.users.data" :key="user.id">-->
                            <tr v-for="user in usersSorted" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td><img :src="'img/profile/'+user.photo" alt="" style="height: 50px"></td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td><span class="tag tag-success">{{ user.type | upText }}</span></td>
                                <td>{{ user.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(user)" class="btn btn-info btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="Edit User">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    /
                                    <button  @click="deleteUser(user)" class="btn btn-danger btn-sm"
                                             data-toggle="tooltip" data-placement="top" title="Delete User">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">
        <!--                <div>
                            <button @click="prevPage" class="float-left btn btn-outline-info btn-sm"><i class="fas fa-arrow-left"></i> Previous</button>
                            <button @click="nextPage" class="float-right btn btn-outline-info btn-sm">Next <i class="fas fa-arrow-right"></i></button>
                        </div>-->
<!--                        <pagination :data="users.users" @pagination-change-page="getResults">-->
<!--                            <span slot="prev-nav">&lt; Previous</span>-->
<!--                            <span slot="next-nav">Next &gt;</span>-->
<!--                        </pagination>-->
                        <appPagination
                            :maxVisibleButtons="totalPages"
                            :total-pages="totalPages"
                            :total="totalPages"
                            :per-page="3"
                            :current-page="currentPage"
                            @pagechanged="onPageChange">
                        </appPagination>
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
                                <i class="fas fa-user-plus icolor"></i> ADD NEW USER
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="fas fa-user-edit icolor"></i> UPDATE USER
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateUser() : createUser()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <appUploadFiles
                                        :title="'User photo'"
                                        :fieldname="'photo'"
                                        :imgsrc="image"
                                        :imgplace="'image'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>
         <!--                       <div class="form-group">
                                    <img :src="'img/profile/'+form.photo" style="height: 50px" alt="User Avatar">
                                </div>-->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input v-model="form.name" id="name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input v-model="form.email" id="email" type="email" name="email" placeholder="Email"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="pass">Password</label>
                                    <input v-model="form.password" id="pass" type="password" name="password" placeholder="Password"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="bio">Short bio for user (optional)</label>
                                    <input v-model="form.bio" id="bio" type="text" name="bio"
                                           placeholder="Short bio for user (optional)"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                                    <has-error :form="form" field="bio"></has-error>
                                </div>

                 <!--               <div class="form-group">
                                    <label for="photo" >Photo</label>
                                    <div class="col-md-2">
                                        <img :src="image" class="img-responsive" style="max-height: 100%; max-width:100%">
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updatePhoto" name="photo" class="form-input" id="photo">
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label for="type">User role</label>
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
    import Paginations from '../shared/Paginations';
    import TableOptions from '../shared/TableOptions';
    import UploadFiles from '../shared/UploadFiles';
    import tableActions from '../../mixins/tableActions';
    import paginationActions from '../../mixins/paginationActions';
    import modalForm from '../../mixins/modalForm';

    export default {

        name: "Users",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm, paginationActions],

        data() {
            return {
                users: [],

/*                sortKey: ['name'],
                sortOrder: ['asc'],
                currentPage: 1,
                pageSize: 3,
                totalPages: 1,
                search: '',*/

                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                }),

                image: '',
                /*editMode: true,
                classes: ''*/
            }
        },

        computed: {

            ...mapGetters(['allUsers']),

            usersSorted: function() {
                let result = this.users.users;
                //this.totalPages = Math.ceil(result.length / this.pageSize);
      /*          if (this.search) {
                    result = result.filter(item => item.name.toLowerCase().includes(this.search));
                    //this.currentPage = 1;
                }*/
                if (this.search) {
                var self = this;
                result = result.filter(function (users) {
                    return users.name.toLowerCase().indexOf(self.search.toLowerCase()) >= 0
                        || users.email.toLowerCase().indexOf(self.search.toLowerCase()) >= 0;
                });
                }
                result =  _.orderBy(result, this.sortKey, this.sortOrder);

                return result.filter((row, index) => {
                    this.totalPages = Math.ceil(result.length / this.pageSize);
                    let start = (this.currentPage - 1) * this.pageSize;
                    let end = this.currentPage * this.pageSize;
                    if (index >= start && index < end) return true;
                    //this.currentPage = 1;
                });
            },
        },

        methods: {

            ...mapActions(['fetchUsers',
                'fetchUsersP',
                'fetchUsersS',
                'addUser',
                'renewUser',
                'removeUser']),

/*            onPageChange(page) {
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

     /*       OnImageSelect(imgSelected, fieldname) {
                this[fieldname] = imgSelected;
            },

            OnImageLoad(imgName, fieldname) {
                this.form[fieldname] = imgName;
            },

            sortBy: function(key) {
                if (key === this.sortKey) {
                    this.sortOrder = (this.sortOrder === 'asc') ? 'desc' : 'asc';
                } else {
                    this.sortKey = key;
                    this.sortOrder = 'asc';
                }
            },*/

/*            fillPhoto(file, reader) {
                let vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };

                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            },*/

/*            nextPage:function() {
                if((this.currentPage*this.pageSize) < this.users.users.length) this.currentPage++;
            },
            prevPage:function() {
                if(this.currentPage > 1) this.currentPage--;
            },

            sorti:function(s) {
                if(s === this.currentSort) {
                    this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
                }
                this.currentSort = s;
            },*/

            loadUsers() {
                if(this.$gate.isAdmin()) {
                    /*              axios.get("api/user")
                                      .then(({ data }) => (this.users = data))
                                      .catch();*/
                    this.fetchUsers();
                    this.users = this.$store.state.users;
                }
            },

/*            getResults(page = 1) {
                this.fetchUsersP(page);
                this.users = this.$store.state.users;
        /!*        axios.get('api/user?page=' + page)
                    .then(response => {
                        console.log(response.data);
                        this.users = response.data;
                    });*!/
            },*/

/*            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },*/

      /*      editModal(user) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(user);
                this.image = 'img/profile/'+this.form.photo;
            },*/
            imagesPlaces() {
                this.image = 'img/profile/'+this.form.photo;
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
                        console.log('error');
                    }
                })
            },

/*            getProfilePhoto() {
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo ;
                return photo;
            },*/

           /* updatePhoto(e){
                let file = e.target.files[0];
                console.log(file);
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                let type = ['image/jpeg','image/png','image/jpg','image/gif','image/svg'];
                console.log(limit);
                console.log(file['size']);
                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });

                    return false;
                }
                console.log(file['type']);
                if(!type.includes(file['type'])){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You need to upload image file',
                    });

                    return false;
                }

                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                // reader.readAsDataURL(file);
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            },*/
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
            console.log(window.user);
            Fire.$on('AfterCreate', () => {
                this.loadUsers();
            });
        }
    }
</script>

<style scoped>
    a {
        font-weight: normal;
        color: blue;
    }

    a.active {
        font-weight: bold;
        color: black;
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