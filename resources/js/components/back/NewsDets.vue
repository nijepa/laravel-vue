<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

            <!-- Card -->
                <div class="card" data-aos="flip-up">
                    <div class="d-flex justify-content-between mt-3">

                        <div class="ml-3 mt-3">
                            <div class="">
                                <h3 class="d-inline p-2 text-blue font-weight-bold">{{ oneNews.title }}</h3>
                            </div>
                            <div class="mt-2">
                                <h4 class="d-inline p-2">{{ oneNews.description }}</h4>
                            </div>
                        </div>
                        <router-link to="/newsb" class="nav-link btn btn-outline-secondary mr-3" tag="button">
                            <span><i class="cap-icon ci-arrow-left-circled"></i> BACK</span>
                        </router-link>
                    </div>
                    <hr>
                    <div v-if="newsDets.newsDet.length">
                        <appTableOptions
                                :title="'DETAILS'"
                                :button-title="'Detail'"
                                :at-click="newModal"
                                :button-icon="'fas fa-list fa-2x icolor'"
                                @pageSizeChanged="onPageSizeChanged"
                                @searchChanged="onSearchChanged"
                        ></appTableOptions>
                <!-- /.card-header -->
<!--                        <hr>-->
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
                                        <th @click="sortBy('description')">Description
                                            <i v-if="sortKey === 'description'"
                                               :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                               class="ic">
                                            </i>
                                        </th>
                                        <th>Photo</th>
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
                                    <tr v-for="newsDet in repsSorted" :key="newsDet.id">
                                        <td>{{ newsDet.id }}</td>
                                        <td>{{ newsDet.description }}</td>
                                        <td>
                                            <a :href="'img/news/'+newsDet.photo_id" target="_blank">{{ newsDet.photo_id }}</a>
                                        </td>
                                        <td>{{ newsDet.created_at | customDate }}</td>
                                        <td>
                                            <button @click="editModal(newsDet)"
                                                    class="btn btn-info btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Edit Company">
                                                <i class="cap-icon ci-file-edit"></i>
                                            </button>
                                            /
                                            <button  @click="deleteNews(newsDet)"
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
                        <div class="d-flex justify-content-center my-3">
                            <h3 class="text-blue font-weight-bold m-3">
                                No News details !
                            </h3>
                            <button class="btn btn-success" @click="newModal">
                                Add News detail <span><i class="cap-icon ci-plus"></i></span>
                            </button>
                        </div>
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
                              @submit.prevent="editMode ? updateNews() : createNews()"
                              @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <input v-model="form.news_id" type="hidden" name="news_id" id="news_id">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input v-model="form.description" id="description" type="text" name="description" placeholder="Description"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <appUploadFiles
                                        :title="'Photo'"
                                        :fieldname="'photo_id'"
                                        :imgsrc="image"
                                        :imgplace="'image'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>
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
    import paginationActions from '../../mixins/paginationActions';
    import UploadFiles from '../shared/UploadFiles';

    export default {

        name: "NewsDets",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm, paginationActions],

        data() {
            return {
                newsDets: {},
                news: {},
                newsId: this.$route.params.id,
                selNews: this.$route.params.selNews,

                form: new Form({
                    id: '',
                    description: '',
                    news_id: '',
                    photo_id: '',
                    doc: null
                }),

                photo_id: '',
                image: '',
            }
        },
        /**
         * TODO create slugs
         * look at course how
         */
        computed: {

            ...mapGetters(['allNews', 'allNewsDet', 'oneNews']),

            repsSorted() {
                let result = this.newsDets.newsDet;

                if (this.search) {
                    result = result.filter(item => item.title.toLowerCase().includes(this.search));
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
                'fetchNews',
                'fetchNewsDet',
                'fetchNewsD'
            ]),

            loadNews() {
                if(this.$gate.isAdmin()) {
                    this.fetchNewsD(this.newsId);
                    this.news = this.$store.state.newsD;
                    this.fetchNewsDet(this.newsId);
                    this.newsDets = this.$store.state.newsDet;
                }
            },

            imagesPlaces() {
                this.logo = 'img/news/'+this.form.logo_id;
            },

            createNews() {
                this.$Progress.start();
                this.form.news_id = this.oneNews.id;
                let formData = this.newsData();

                axios.post('../api/news_dets', formData)
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

            updateNews() {
                this.$Progress.start();
                let formData = this.newsData(1);

                axios.post('../api/news_dets/'+this.form.id, formData)
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

            newsData(action = '') {
                let data = new FormData();
                data.append('description', this.form.description);
                data.append('news_id', this.form.news_id);
                data.append('photo_id', this.form.photo_id);
                //data.append('doc', this.form.doc);
                if (action) data.append('_method', 'put');
                return data;
            },

            deleteNews(news){
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
                        this.form.delete('../api/news_det/'+news.id).then(()=>{
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
                this.fetchNewsS(query);
            });

            this.loadNews();

            Fire.$on('AfterCreate', () => {
                this.loadNews();
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