<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <appTableOptions
                            :title="'PRODUCTS'"
                            :button-title="'Product'"
                            :at-click="newModal"
                            :button-icon="'fas fa-boxes fa-2x icolor'"
                            @pageSizeChanged="onPageSizeChanged"
                            @searchChanged="onSearchChanged"
                    ></appTableOptions>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th @click="sortBy('id')">ID
                                    <i v-if="sortKey === 'id'" :class="classe"></i>
                                </th>
                                <th>Photo</th>
                                <th @click="sortBy('name')">Name
                                    <i v-if="sortKey === 'name'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('description')">Description
                                    <i v-if="sortKey === 'description'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('created_at')">Created At
                                    <i v-if="sortKey === 'created_at'" :class="classe"></i>
                                </th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="product in repsSorted" :key="product.id">
                                <td>{{ product.id }}</td>
                                <td><img :src="'img/products/'+product.photo_id" alt="" style="height: 50px"></td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.description }}</td>
                                <td>{{ product.created_at | customDate }}</td>
                                <appTableActions
                                        :action-title="'Product'"
                                        :at-click-edit="editModal.bind(this, product)"
                                        :at-click-delete="deleteProduct.bind(this, product)"
                                ></appTableActions>
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
                        <appModalHeader
                                :title="'Product'"
                                :mode="editMode"
                        ></appModalHeader>
                        <!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateProduct() : createProduct()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <appUploadFiles
                                        :title="'Picture'"
                                        :fieldname="'photo_id'"
                                        :imgsrc="image"
                                        :imgplace="'image'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>
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
                            <appModalActions
                                    :mode="editMode"
                            ></appModalActions>
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
    import TableActions from '../shared/TableActions';
    import ModalActions from '../shared/ModalActions';
    import ModalHeader from '../shared/ModalHeader';
    import UploadFiles from '../shared/UploadFiles';
    import tableActions from '../../mixins/tableActions';
    import modalForm from '../../mixins/modalForm';

    export default {
        name: "Products",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appTableActions: TableActions,
            appModalActions: ModalActions,
            appModalHeader: ModalHeader,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm],

        data() {
            return {
                products: {},

                form: new Form({
                    id: '',
                    photo_id: '',
                    name: '',
                    description: ''
                }),

                image: ''
            }
        },

        computed: {
            ...mapGetters(['allProducts']),

            repsSorted() {
                let result = this.products.products;

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
            ...mapActions([
                'fetchProducts',
                'fetchProductsP',
                'fetchProductsS',
                'addProduct',
                'renewProduct',
                'removeProduct'
            ]),

            loadProducts() {
                if(this.$gate.isAdmin()) {
                    this.fetchProducts();
                    this.products = this.$store.state.products;
                }
            },

            onPageChange(page) {
                this.currentPage = page;
            },

            onPageSizeChanged(ps) {
                this.onPageChange(1);
                this.pageSize = ps;
            },

            onSearchChanged(s) {
                this.onPageChange(1);
                this.search = s;
            },

            imagesPlaces() {
                this.image = 'img/products/'+this.form.photo_id;
            },

            createProduct() {
                this.$Progress.start();
                this.form.post('api/product')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Product added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateProduct(id) {
                this.$Progress.start();
                this.form.put('api/product/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Product updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            deleteProduct(product){
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
                        this.form.delete('api/product/'+product.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Product has been deleted.',
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
                this.fetchProductsS(query);
            });

            this.loadProducts();

            Fire.$on('AfterCreate', () => {
                this.loadProducts();
            });
        }
    }
</script>

<style scoped>

</style>