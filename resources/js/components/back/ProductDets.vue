<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

            <!-- Card -->
                <div class="card" data-aos="flip-up">
                    <div class="d-flex justify-content-between mt-3">

                        <div class="ml-3 mt-3">
                            <div class="">
                                <h3 class="d-inline p-2 text-blue font-weight-bold">{{ oneProduct.name }}</h3>
                            </div>
                            <div class="mt-2">
                                <h4 class="d-inline p-2">{{ oneProduct.description }}</h4>
                            </div>
                        </div>
                        <router-link to="/products" class="nav-link btn btn-outline-secondary mr-3" tag="button">
                            <span><i class="cap-icon ci-arrow-left-circled"></i> BACK</span>
                        </router-link>
                    </div>
                    <hr>
                    <div v-if="productDets.productDet.length">
                        <appTableOptions
                                :title="'DETAILS'"
                                :button-title="'Detail'"
                                :at-click="newModal"
                                :button-icon="'far fa-file-alt fa-2x icolor'"
                                @pageSizeChanged="onPageSizeChanged"
                                @searchChanged="onSearchChanged"
                        ></appTableOptions>
                <!-- /.card-header -->
                        <hr>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th @click="sortBy('id')">ID
                                            <i v-if="sortKey === 'id'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th @click="sortBy('title')">Title
                                            <i v-if="sortKey === 'title'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th @click="sortBy('description')">Description
                                            <i v-if="sortKey === 'description'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th @click="sortBy('created_at')">Created At
                                            <i v-if="sortKey === 'created_at'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th>Modify</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <tr v-for="productDet in repsSorted" :key="productDet.id">
                                        <td>{{ productDet.id }}</td>
                                        <td>{{ productDet.title }}</td>
                                        <td>
                                            <a :href="'img/products/'+productDet.photo_id" target="_blank">{{ productDet.photo_id }}</a>
                                        </td>
                                        <td>{{ productDet.created_at | customDate }}</td>
                                        <td>
                                            <button @click="editModal(productDet)"
                                                    class="btn btn-info btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Edit Company">
                                                <i class="cap-icon ci-file-edit"></i>
                                            </button>
                                            /
                                            <button  @click="deleteProduct(productDet)"
                                                     class="btn btn-danger btn-sm"
                                                     data-toggle="tooltip" data-placement="top" title="Delete Company">
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
                    <div v-else class="card m-2">
                        <h3 class="text-blue font-weight-bold m-3">
                            No files uploaded !
                        </h3>
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
                                <i class="cap-icon ci-plus icolor"></i> ADD NEW DOCUMENT
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i> UPDATE DOCUMENT
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            <!-- /.modal-header -->
                        <form enctype="multipart/form-data"
                              @submit.prevent="editMode ? updateProduct() : createProduct()"
                              @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <input v-model="form.product_id" type="hidden" name="product_id" id="product_id">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input v-model="form.title" id="title" type="text" name="title" placeholder="Title"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="doc_id" >Document</label>
                                    <input type="text" class="form-control" v-model="form.doc_id" name="doc_id" id="doc_id" disabled>
                                    <input type="file" @change="onFileChange" name="doc" class="form-input" id="doc">
                                </div>
                            </div>
            <!-- /.modal-body -->
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
            <!-- /.modal-footer -->
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
    import tableActions from '../../mixins/tableActions';
    import modalForm from '../../mixins/modalForm';
    import UploadFiles from '../shared/UploadFiles';

    export default {

        name: "ProductDets",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm],

        data() {
            return {
                productDets: {},
                product: {},
                productId: this.$route.params.id,
                selProduct: this.$route.params.selProduct,

                form: new Form({
                    id: '',
                    title: '',
                    description: '',
                    product_id: '',
                    photo_id: '',
                    doc: null
                }),
            }
        },

        computed: {

            ...mapGetters(['allProducts', 'allProductDet', 'oneProduct']),

            repsSorted() {
                let result = this.productDets.productDet;

                if (this.search) {
                    result = result.filter(item => item.title.toLowerCase().includes(this.search));
                }

                result =  _.orderBy(result, this.sortKey, this.sortOrder);

                console.log(result);

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
                'fetchProductDet',
                'fetchProduct'
            ]),

            loadProducts() {
                if(this.$gate.isAdmin()) {
                    this.fetchProduct(this.productId);
                    this.product = this.$store.state.product;
                    this.fetchProductDet(this.productId);
                    this.productDets = this.$store.state.productDet;
                }
            },

            onFileChange(e){
                let file = e.target.files[0];
                let limit = 1024 * 1024 * 2;
                let type = [
                    'application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'];

                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });
                    return false;
                }

                if(!type.includes(file['type'])) {
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You need to upload document file',
                    });
                    return false;
                }

                this.form.doc = e.target.files[0];
                this.form.doc_id = this.form.doc.name;
            },

            onPageChange(page) {
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
            },

            imagesPlaces() {
                this.logo = 'img/companies/'+this.form.logo_id;
            },

            createProduct() {
                this.$Progress.start();
                this.form.product_id = this.oneProduct.id;
                let formData = this.productData();

                axios.post('../api/products_det', formData)
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Document added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateProduct() {
                this.$Progress.start();
                let formData = this.productData(1);

                axios.post('../api/products_det/'+this.form.id, formData)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Document updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            productData(action = '') {
                let data = new FormData();
                data.append('title', this.form.title);
                data.append('product_id', this.form.product_id);
                data.append('doc_id', this.form.doc_id);
                data.append('doc', this.form.doc);
                if (action) data.append('_method', 'put');
                return data;
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
                        this.form.delete('../api/products_det/'+product.id).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'Document has been deleted.',
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
    .table-hover tbody tr:nth-of-type(odd) {
        background-color: rgb(217, 255, 251);
    }

    .table-hover tbody tr:nth-of-type(odd):hover {
        background-color: rgb(187, 215, 215);
    }

    a {
        font-weight: bold;
        color: #3a68c1;
        text-decoration: none;
    }

    a:hover {
        font-weight: bold;
        color: #4cb2e9;
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