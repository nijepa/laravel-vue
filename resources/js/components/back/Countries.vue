<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3">
                            <i class="fas fa-globe-europe fa-2x icolor"></i>
                            COUNTRIES
                        </h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add Country <span><i class="cap-icon ci-plus"></i></span>
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
                            <tr v-for="country in countries.countries.data" :key="country.id">
                                <td>{{ country.id }}</td>
                                <td>{{ country.name }}</td>
                                <td>{{ country.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(country)" class="btn btn-info btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="cap-icon ci-file-edit"></i>
                                    </button>

                                    <button  @click="deleteCountry(country)" class="btn btn-danger btn-sm"
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
                        <pagination :data="countries.countries" @pagination-change-page="getResults">
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
                                Add New Country
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i>
                                Update Country
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateCountry() : createCountry()" @keydown="form.onKeydown($event)">
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
        name: "Countries",
        data() {
            return {
                countries: {},
                form: new Form({
                    id: '',
                    name: ''
                }),
                editMode: true
            }
        },
        computed: mapGetters(['allCountries']),
        methods: {
            ...mapActions(['fetchCountries',
                'fetchCountriesP',
                'fetchCountriesS',
                'addCountry',
                'renewCountry',
                'removeCountry']),
            loadCountries() {
                if(this.$gate.isAdmin()) {
      /*              axios.get("api/user")
                        .then(({ data }) => (this.users = data))
                        .catch();*/
                    this.fetchCountriesP();
                    this.countries = this.$store.state.countries;
                }
            },
            getResults(page = 1) {
                this.fetchCountriesP(page);
                this.countries = this.$store.state.countries;
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
            editModal(country) {
                this.editMode = true;
                $('#addNew').modal('show');
                this.form.fill(country);
            },

            createCountry() {
                this.$Progress.start();
                //this.addCountry(this.form);
                this.form.post('api/country')
                     .then(({ data }) => {
                        //console.log(data);
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Country added successfully'
                        });
                        this.$Progress.finish();
                     })
                     .catch(() => {})
            },

            updateCountry(id) {
                this.$Progress.start();
                //console.log(this.form);
               //this.renewCountry(this.form);

                this.form.put('api/country/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Country updated successfully'
                        });
                        this.$Progress.finish();
                   })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            deleteCountry(country){
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
                        //this.removeCountry(country);
                        this.form.delete('api/country/'+country.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Country has been deleted.',
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
                this.fetchCountriesS(query);
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
            this.loadCountries();
            Fire.$on('AfterCreate', () => {
                this.loadCountries();
            });
        }
    }
</script>

<style scoped>

</style>