<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">
                <div class="card">
                    <appTableOptions
                            :title="'COMPANIES'"
                            :button-title="'Company'"
                            :at-click="newModal"
                            :button-icon="'fas fa-building fa-2x icolor'"
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
                                    <th>Logo</th>
                                    <th @click="sortBy('name')">Name / Site
                                        <i v-if="sortKey === 'name'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                           class="ic">
                                        </i>
                                    </th>
                                    <th @click="sortBy('short_desc')">Description
                                        <i v-if="sortKey === 'short_desc'"
                                           :class="sortOrder === 'asc' ? 'fas fa-angle-up' : 'fas fa-angle-down'"
                                           class="ic">
                                        </i>
                                    </th>
                                    <th @click="sortBy('city')">City
                                        <i v-if="sortKey === 'city'"
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
                                <tr v-for="rep in repsSorted" :key="rep.id">
<!--                                    :to="{ name: 'repd', params: { repID: rep }}"-->
                                    <td>{{ rep.id }}</td>
                                    <td>
                                        <img :src="'img/companies/logosSmall/'+rep.logo_small_id"
                                             alt="" style="max-width:100%; max-height:100%">
                                    </td>
                                    <td>
                                        <a :href="rep.website" target="_blank"
                                           data-toggle="tooltip" :title="rep.website">{{ rep.name }}
                                        </a>
                                    </td>
                                    <td>{{ rep.short_desc }}</td>
                                    <td>{{ rep.city.name }}</td>
                                    <td>{{ rep.created_at | customDate }}</td>
                                    <td>
                                        <button @click="editModal(rep)"
                                                class="btn btn-info btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="Edit Company">
                                            <i class="cap-icon ci-file-edit"></i>
                                        </button>
                                        /
                                        <button  @click="deleteRep(rep)"
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
                <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" v-if="editMode ? classes='edit' : classes='add'" :class="classes">
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">
                                <i class="cap-icon ci-plus icolor"></i> ADD NEW COMPANY
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i> UPDATE COMPANY
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateRep() : createRep()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <appUploadFiles
                                        :title="'Logo (small)'"
                                        :fieldname="'logo_small_id'"
                                        :imgsrc="logoSmall"
                                        :imgplace="'logoSmall'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input v-model="form.name" id="name" type="text" name="name" placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="short_desc">Short Description</label>
                                    <input v-model="form.short_desc"
                                           id="short_desc" type="text" name="short_desc" placeholder="Short Description"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('short_desc') }">
                                    <has-error :form="form" field="short_desc"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <ckeditor :editor="editor" v-model="form.description" id="description" name="description"
                                              :class="{ 'is-invalid': form.errors.has('description') }">
                                    </ckeditor>
                           <!--         <textarea v-model="form.description"
                                              id="description" rows="3" name="description" placeholder="Description"
                                              class="form-control" :class="{ 'is-invalid': form.errors.has('short_desc') }">
                                    </textarea>-->
                                    <has-error :form="form" field="description"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="city_id">City</label>
                                    <select v-model="form.city_id" name="city_id" id="city_id"
                                            class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('city_id') }">
                                        <option v-bind:value="co_name.id"
                                                :key="co_name.id"
                                                v-for="co_name in cities.cities.data">{{ co_name.name }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="city_id"></has-error>
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
                                    <label for="mobile">Mobile</label>
                                    <input v-model="form.mobile" id="mobile" type="text" name="mobile" placeholder="Mobile"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                                    <has-error :form="form" field="mobile"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input v-model="form.email" id="email" type="email" name="email" placeholder="E-mail"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input v-model="form.website" id="website" type="text" name="website" placeholder="Website"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('website') }">
                                    <has-error :form="form" field="website"></has-error>
                                </div>
                                <appUploadFiles
                                        :title="'Photo'"
                                        :fieldname="'photo_id'"
                                        :imgsrc="image"
                                        :imgplace="'image'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>
                                <appUploadFiles
                                        :title="'Logo'"
                                        :fieldname="'logo_id'"
                                        :imgsrc="logo"
                                        :imgplace="'logo'"
                                        @onimageselect="OnImageSelect"
                                        @onimageload="OnImageLoad">
                                </appUploadFiles>

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
    import modalForm from '../../mixins/modalForm';
    import paginationActions from '../../mixins/paginationActions';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {

        name: "Companies",

        components: {
            appPagination: Paginations,
            appTableOptions: TableOptions,
            appUploadFiles: UploadFiles
        },

        mixins: [tableActions, modalForm, paginationActions],

        data() {
            return {
                representations: [],
                cities: {},

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
                    city_id: '',
                    category_id: '',
                    photo_id: '',
                    logo_id: '',
                    logo_small_id: '',
                    isRepresentation: ''
                }),

                editor: ClassicEditor,

                logoSmall: '',
                logo: '',
                image: '',
            }
        },

        computed: {

            ...mapGetters(['allCompanies', 'allCities']),

            repsSorted() {
                let result = this.representations.companies;

       /*         if (this.search) {
                    result = result.filter(item => item.name.toLowerCase().includes(this.search));
                }*/
                if (this.search) {
                    var self = this;
                    result = result.filter(function (users) {
                        return users.name.toLowerCase().indexOf(self.search.toLowerCase()) >= 0
                            || users.short_desc.toLowerCase().indexOf(self.search.toLowerCase()) >= 0;
                    });
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

            ...mapActions(['fetchCompanies',
                'fetchRepsP',
                'fetchRepsS',
                'fetchRep',
                'fetchRepDet',
                'fetchCities']),

            loadReps() {
                if(this.$gate.isAdmin()) {
                    this.fetchCompanies();
                    this.representations = this.$store.state.representations;
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
                this.logoSmall = 'img/companies/logosSmall/'+this.form.logo_small_id;
                this.logo = 'img/companies/'+this.form.logo_id;
                this.image = 'img/companies/'+this.form.photo_id;
            },

            createRep() {
                this.$Progress.start();
                this.form.isRepresentation = 0;
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
                this.form.isRepresentation = 0;
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
        },

        created() {
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                this.fetchRepsS(query);
            });
            this.loadReps();
            this.fetchCities();
            this.cities = this.$store.state.cities;
            Fire.$on('AfterCreate', () => {
                this.loadReps();
            });
        }
    }
</script>

<style scoped>
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