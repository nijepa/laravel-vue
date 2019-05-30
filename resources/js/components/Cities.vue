<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3"><i class="fas fa-city fa-2x icolor"></i> CITIES</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add City <span><i class="fas fa-plus"></i></span>
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
                                <th>Country</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="city in cities.cities.data" :key="city.id">
                                <td>{{ city.id }}</td>
                                <td>{{ city.name }}</td>

                                <td><span class="tag tag-success">{{ city.country_id ? city.country.name : 'not selected'  }}</span></td>
                                <td>{{ city.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(city)" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    /
                                    <button  @click="deleteCity(city)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete User">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="cities.cities" @pagination-change-page="getResults">
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
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New City</h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">Update City</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateCity() : createCity()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <select v-model="form.country_id" name="type" id="type"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                        <!--<option value="">Select country</option>
                                        <option value="admin">Admin</option>
                                        <option value="author">Author</option>
                                        <option value="user">Standar user</option>-->
                                        <option v-bind:value="co_name.id"
                                                :key="co_name.id"
                                                v-for="co_name in countries.countries.data">{{ co_name.name }}</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
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
        name: "Cities",
        data() {
            return {
                cities: {},
                countries: {},
                form: new Form({
                    id: '',
                    name: '',
                    country_id: '',

                }),
                editMode: true
            }
        },
        computed: mapGetters(['allCities', 'allCountries']),
        methods: {
            ...mapActions(['fetchCities',
                'fetchCitiesP',
                'fetchCitiesS',
                'addCity',
                'renewCity',
                'removeCity',
                'fetchCountries']),
            loadCities() {
                if(this.$gate.isAdmin()) {
      /*              axios.get("api/user")
                        .then(({ data }) => (this.users = data))
                        .catch();*/
                    this.fetchCitiesP();
                    this.cities = this.$store.state.cities;
                }
            },
            getResults(page = 1) {
                this.fetchCitiesP(page);
                this.cities = this.$store.state.cities;
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
            editModal(city) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(city);
            },
            createCity() {
                this.$Progress.start();
                this.addCity(this.form);
                // this.form.post('api/user')
                //     .then(({ data }) => {
                        //console.log(data);
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'City added successfully'
                        });
                        this.$Progress.finish();
                    // })
                    // .catch(() => {})
            },
            updateCity(id) {
                this.$Progress.start();
                //console.log(this.form);
                this.renewCity(this.form);

                //this.form.put('api/user/'+this.form.id)
                    //.then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'City updated successfully'
                        });
                        this.$Progress.finish();
            /*        })
                    .catch(() => {
                        this.$Progress.fail();
                    })*/
            },
            deleteCity(city){
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
                        this.removeCity(city);
                        //this.form.delete('api/user/'+id).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'City has been deleted.',
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
                this.fetchCitiesS(query);
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
            this.loadCities();
            this.fetchCountries();
            this.countries = this.$store.state.countries;
            console.log(this.countries);
            Fire.$on('AfterCreate', () => {
                this.loadCities();
            });
        }
    }
</script>

<style scoped>

</style>