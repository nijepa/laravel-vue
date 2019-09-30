<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <appTableOptions
                            :title="'NEWS'"
                            :button-title="'News'"
                            :at-click="newModal"
                            :button-icon="'far fa-newspaper fa-2x icolor'"
                            @pageSizeChanged="onPageSizeChanged"
                            @searchChanged="onSearchChanged"
                    ></appTableOptions>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th @click="sortBy('id')">ID
                                    <i v-if="sortKey === 'id'" :class="classe"></i>
                                </th>
                                <th>Photo</th>
                                <th @click="sortBy('title')">Name
                                    <i v-if="sortKey === 'title'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('body')">Description
                                    <i v-if="sortKey === 'body'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('created_at')">Created At
                                    <i v-if="sortKey === 'created_at'" :class="classe"></i>
                                </th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="news in repsSorted" :key="news.id">
                                <router-link
                                        :to="{name:'newsd', params: {id: news.id, selNews: news}}"
                                        activeClass="active" tag="a" class="nav-item nav-link">
                                    {{ news.id }}
                                </router-link>
<!--                                <td>{{ news.id }}</td>-->
                                <td><img :src="'img/news/'+news.pic_id" alt="" style="height: 50px"></td>
                                <td>{{ news.title }}</td>
                                <td>{{ news.body }}</td>
                                <td>{{ news.created_at | customDate }}</td>
                                <appTableActions
                                        :action-title="'News'"
                                        :at-click-edit="editModal.bind(this, news)"
                                        :at-click-delete="deleteNews.bind(this, news)"
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
                                :title="'News'"
                                :mode="editMode"
                        ></appModalHeader>
                        <!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateNews() : createNews()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <appUploadFiles
                                        :title="'Picture'"
                                        :fieldname="'pic_id'"
                                        :imgsrc="image"
                                        :imgplace="'image'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.title" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                 <!--               <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.body" type="text" name="description" placeholder="Description"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('body') }">
                                    <has-error :form="body" field="description"></has-error>
                                </div>-->
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
    import paginationActions from '../../mixins/paginationActions';
    import modalForm from '../../mixins/modalForm';

    export default {
        name: "News",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appTableActions: TableActions,
            appModalActions: ModalActions,
            appModalHeader: ModalHeader,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm, paginationActions],

        data() {
            return {
                news: {},

                form: new Form({
                    id: '',
                    pic_id: '',
                    title: '',
                    body: ''
                }),

                image: ''
            }
        },

        computed: {
            ...mapGetters(['allNews']),

            repsSorted() {
                let result = this.news.news;

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
                'fetchNews',
                'fetchNewsP',
                'fetchNewsS',
                'addNews',
                'renewNews',
                'removeNews'
            ]),

            loadNews() {
                if(this.$gate.isAdmin()) {
                    this.fetchNews();
                    this.news = this.$store.state.news;
                }
            },

  /*          onPageChange(page) {
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

            imagesPlaces() {
                this.image = 'img/news/'+this.form.photo_id;
            },

            createNews() {
                this.$Progress.start();
                this.form.post('api/news')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'News added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateNews(id) {
                this.$Progress.start();
                this.form.put('api/news/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'News updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
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
                        this.form.delete('api/news/'+news.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'News has been deleted.',
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

</style>