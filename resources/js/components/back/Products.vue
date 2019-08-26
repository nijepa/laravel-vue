<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3"><i class="fas fa-boxes fa-2x icolor"></i> PRODUCTS</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">
                                Add Product <span><i class="fas fa-plus"></i></span>
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
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="product in products.products.data" :key="product.id">
                                <td>{{ product.id }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.description }}</td>
                                <td>{{ product.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(product)" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button  @click="deleteCountry(product)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="products.products" @pagination-change-page="getResults">
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
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New Product</h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">Update Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div><!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateProduct() : createProduct()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
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
        name: "Products",
        data() {
            return {
                products: {},
                form: new Form({
                    id: '',
                    name: '',
                    description: ''
                }),
                editMode: true
            }
        },
        computed: mapGetters(['allProducts']),
        methods: {
            ...mapActions(['fetchProducts',
                'fetchProductsP',
                'fetchProductsS',
                'addProduct',
                'renewProduct',
                'removeProduct']),
            loadProducts() {
                if(this.$gate.isAdmin()) {
                    /*              axios.get("api/user")
                                      .then(({ data }) => (this.users = data))
                                      .catch();*/
                    this.fetchProductsP();
                    this.products = this.$store.state.products;
                }
            },
            getResults(page = 1) {
                this.fetchProductsP(page);
                this.products = this.$store.state.products;
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
            createProduct() {
                this.$Progress.start();
                this.addProduct(this.form);
                // this.form.post('api/user')
                //     .then(({ data }) => {
                //console.log(data);
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
                toast.fire({
                    type: 'success',
                    title: 'Product added successfully'
                });
                this.$Progress.finish();
                // })
                // .catch(() => {})
            },
            updateProduct(id) {
                this.$Progress.start();
                //console.log(this.form);
                this.renewProduct(this.form);

                //this.form.put('api/user/'+this.form.id)
                //.then(() => {
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide');
                toast.fire({
                    type: 'success',
                    title: 'Product updated successfully'
                });
                this.$Progress.finish();
                /*        })
                        .catch(() => {
                            this.$Progress.fail();
                        })*/
            },
            deleteCountry(product){
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
                        this.removeProduct(product);
                        //this.form.delete('api/user/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Product has been deleted.',
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
                this.fetchProductsS(query);
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
            this.loadProducts();
            Fire.$on('AfterCreate', () => {
                this.loadProducts();
            });
        }
    }
</script>

<style scoped>

</style>