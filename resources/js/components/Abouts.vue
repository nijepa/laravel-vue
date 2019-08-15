<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3"><i class="fas fa-certificate fa-2x icolor"></i> ABOUT</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add About <span><i class="fas fa-plus"></i></span>
                            </button>
                        </div>
                        <div class="">
                            <form action="" >
                                <div class="form-group">
                                    <input class="form-control" type="text" v-model="abouts.abouts.data[0].title" >
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" type="text" v-model="abouts.abouts.data[0].description" ></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Caption</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="about in abouts.abouts.data" :key="about.id">
                                <td>{{ about.id }}</td>
                                <td>{{ about.caption }}</td>
                                <td>{{ about.description }}</td>
                                <td>{{ about.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(about)" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button  @click="deleteAbout(about)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="abouts.abouts" @pagination-change-page="getResults">
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
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New About</h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">Update About</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateAbout() : createAbout()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.title" type="text" name="title" placeholder="Title"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close <span><i class="far fa-times-circle"></i></span></button>
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
        name: "Abouts",
        data() {
            return {
                abouts: {},
                form: new Form({
                    id: '',
                    title: ''
                }),
                editMode: true
            }
        },
        computed: mapGetters(['allAbouts']),
        methods: {
            ...mapActions(['fetchAbouts',
                'fetchAboutsP',
                'fetchAboutsS',
                'addAbout',
                'renewAbout',
                'removeAbout']),
            loadAbouts() {
                if(this.$gate.isAdmin()) {
                    /*              axios.get("api/user")
                                      .then(({ data }) => (this.users = data))
                                      .catch();*/
                    this.fetchAboutsP();
                    this.abouts = this.$store.state.abouts;
                }
            },
            getResults(page = 1) {
                this.fetchAboutsP(page);
                this.abouts = this.$store.state.abouts;
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
            editModal(about) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(about);
            },
            createAbout() {
                this.$Progress.start();
                this.addAbout(this.form);
                // this.form.post('api/user')
                //     .then(({ data }) => {
                //console.log(data);
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
                toast.fire({
                    type: 'success',
                    title: 'About added successfully'
                });
                this.$Progress.finish();
                // })
                // .catch(() => {})
            },
            updateAbout(id) {
                this.$Progress.start();
                //console.log(this.form);
                this.renewAbout(this.form);

                //this.form.put('api/user/'+this.form.id)
                //.then(() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
                toast.fire({
                    type: 'success',
                    title: 'About updated successfully'
                });
                this.$Progress.finish();
                /*        })
                        .catch(() => {
                            this.$Progress.fail();
                        })*/
            },
            deleteAbout(about){
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
                        this.removeAbout(about);
                        //this.form.delete('api/user/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'About has been deleted.',
                            'success'
                        );
                        Fire.$emit('AfterCreate');
                        // }).catch(()=> {
                        //     swal("Failed!", "There was something wrong.", "warning");
                        // });
                    } else {
                        console.log('qqqqqqqqqqqq');
                    }
                })
            }
        },
        created() {
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                this.fetchAboutsS(query);
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
            this.loadAbouts();
            Fire.$on('AfterCreate', () => {
                this.loadAbouts();
            });
        }
    }
</script>

<style scoped>

</style>