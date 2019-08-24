<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3"><i class="fas fa-building fa-2x icolor"></i> COMPANIES</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add Company <span><i class="cap-icon ci-plus"></i></span>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <appTableOptions
                            :search.sync="search"
                            :pageSize.sync="pageSize"
                            @pageSizeChanged="pageSize = Number($event)"
                            @searchChanged="search = $event"
                    ></appTableOptions>

                    <hr>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th @click="sortBy('id')">ID <i v-if="sortKey === 'id'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
                                    <th>Photo</th>
                                    <th @click="sortBy('name')">Name <i v-if="sortKey === 'name'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
                                    <th @click="sortBy('short_desc')">Description <i v-if="sortKey === 'short_desc'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
                                    <th @click="sortBy('website')">Web Site <i v-if="sortKey === 'website'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
                                    <th @click="sortBy('created_at')">Created At <i v-if="sortKey === 'created_at'" :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'" class="ic"></i></th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                                <tbody>
                                <tr v-for="rep in repsSorted" :key="rep.id">
                                    <td>{{ rep.id }}</td>
                                    <td><img :src="'img/companies/'+rep.logo_small_id" alt="" style="max-width:100%; max-height:100%"></td>
                                    <td>{{ rep.name }}</td>
                                    <td>{{ rep.short_desc }}</td>
                                    <td><span class="tag tag-success">{{ rep.website | upText }}</span></td>
                                    <td>{{ rep.created_at | customDate }}</td>
                                    <td>
                                        <button @click="editModal(rep)" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Company">
                                            <i class="cap-icon ci-file-edit"></i>
                                        </button>
                                        /
                                        <button  @click="deleteRep(rep)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Company">
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
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel"><i class="cap-icon ci-plus icolor"></i> ADD NEW COMPANY</h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel"><i class="cap-icon ci-file-edit icolor"></i> UPDATE COMPANY</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateRep() : createRep()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div  class="form-group">
                                    <img :src="'img/companies/'+form.logo_small_id" alt="" style="max-height: 100%; max-width:100%" alt="User Avatar">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input v-model="form.name" id="name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="email">Short Description</label>
                                    <input v-model="form.short_desc" id="short_desc" type="text" name="short_desc" placeholder="Short Description"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('short_desc') }">
                                    <has-error :form="form" field="short_desc"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="email">Description</label>
                                    <textarea v-model="form.description" id="description" rows="3" name="description" placeholder="Description"
                                              class="form-control" :class="{ 'is-invalid': form.errors.has('short_desc') }"></textarea>
                                    <has-error :form="form" field="description"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input v-model="form.address" id="address" type="text" name="address" placeholder="Address"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                                    <has-error :form="form" field="address"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input v-model="form.phone" id="phone" type="text" name="phone" placeholder="Phone"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                    <has-error :form="form" field="phone"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Mobile</label>
                                    <input v-model="form.mobile" id="mobile" type="text" name="mobile" placeholder="Mobile"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                                    <has-error :form="form" field="mobile"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Email</label>
                                    <input v-model="form.email" id="email" type="email" name="email" placeholder="E-mail"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Website</label>
                                    <input v-model="form.website" id="website" type="text" name="website" placeholder="Website"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('website') }">
                                    <has-error :form="form" field="website"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="logo_small_id" class="col-sm-2 control-label">Small Logo</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updatePhoto" name="logo_small_id" class="form-input" id="logo_small_id">
                                    </div>
                                </div>
                                <div  class="form-group">
                                    <img :src="'img/companies/'+form.photo_id" alt="" style="max-height: 100%; max-width:100%" alt="User Avatar">
                                </div>
                                <div class="form-group">
                                    <label for="logo_id" class="col-sm-2 control-label">Photo</label>
                                    <div class="col-sm-12">
                                        <input type="file" @change="updatePhoto" name="logo_id" class="form-input" id="logo_id">
                                    </div>
                                </div>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <span><i class="cap-icon ci-times"></i></span></button>
                                <button type="submit" v-show="!editMode" class="btn btn-success">Create <span><i class="cap-icon ci-check"></i></span></button>
                                <button type="submit" v-show="editMode" class="btn btn-success">Update <span><i class="cap-icon ci-save"></i></span></button>
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

    export default {

        name: "Reps",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions
        },

        data() {
            return {
                representations: [],

                sortKey: ['name'],
                sortOrder: ['asc'],
                currentPage: 1,
                pageSize: 5,
                totalPages: 1,
                search: '',
                columns: ['name', 'short_desc'],
                sorting: 'name',

                form: new Form({
                    id: '',
                    name: '',
                    short_desc: '',
                    description: '',
                    address: '',
                    phone: '',
                    mobile: '',
                    email: '',
                    website: '',
                    photo_id: '',
                    logo_id: '',
                    logo_small_id: ''
                }),

                editMode: true,
                classes: ''
            }
        },

        computed: {

            ...mapGetters(['allReps']),

            repsSorted: function() {
                let result = this.representations.reps;
                //this.totalPages = Math.ceil(result.length / this.pageSize);
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

            ...mapActions(['fetchReps',
                'fetchRepsP',
                'fetchRepsS']),

            onPageChange(page) {
                console.log(page);
                this.currentPage = page;
            },

            sortBy: function(key) {
                if (key === this.sortKey) {
                    this.sortOrder = (this.sortOrder === 'asc') ? 'desc' : 'asc';
                } else {
                    this.sortKey = key;
                    this.sortOrder = 'asc';
                }
            },

            loadReps() {
                if(this.$gate.isAdmin()) {
                    this.fetchReps();
                    this.representations = this.$store.state.representations;
                }
            },

            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            editModal(rep) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(rep);
            },

            createRep() {
                this.$Progress.start();
                //this.addUser(this.form);
                this.form.post('api/representation')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Company added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateRep(id) {
                this.$Progress.start();
                //this.renewUser(this.form);
                this.form.put('api/representation/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Company updated successfully'
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
                        //this.removeUser(user);
                        this.form.delete('api/representation/'+rep.id).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'Company has been deleted.',
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
                this.fetchRepsS(query);
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
            this.loadReps();
            Fire.$on('AfterCreate', () => {
                this.loadReps();
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