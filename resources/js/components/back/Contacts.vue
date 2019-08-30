<template>
    <div class="container" data-aos="fade-right">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <appTableOptions
                            :title="'CONTACTS'"
                            :button-title="'contact'"
                            :at-click="newModal"
                            :button-icon="'far fa-address-book fa-2x icolor'"
                            @pageSizeChanged="onPageSizeChanged"
                            @searchChanged="onSearchChanged"
                    ></appTableOptions>
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
                                <th @click="sortBy('email')">E-mail
                                    <i v-if="sortKey === 'email'" :class="classe"></i>
                                </th>
                                <th @click="sortBy('created_at')">Created At
                                    <i v-if="sortKey === 'created_at'" :class="classe"></i>
                                </th>
                                <th>Modify</th>
                            </tr>
                            <tr v-for="contact in repsSorted" :key="contact.id">
                                <td>{{ contact.id }}</td>
                                <td><img :src="'img/profile/'+contact.photo_id" alt="" style="height: 50px"></td>
                                <td>{{ contact.name }}</td>
                                <td>{{ contact.email }}</td>
                                <td>{{ contact.created_at | customDate }}</td>
                                <appTableActions
                                        :action-title="'Contact'"
                                        :at-click-edit="editModal.bind(this, contact)"
                                        :at-click-delete="deleteContact.bind(this, contact)"
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
                                :title="'Contact'"
                                :mode="editMode"
                        ></appModalHeader>
    <!--                    <div class="modal-header">
                            <h5 class="modal-title" v-show="!editMode" id="addNewLabel">
                                <i class="cap-icon ci-plus icolor"></i>
                                Add New Contact
                            </h5>
                            <h5 class="modal-title" v-show="editMode" id="addNewLabel">
                                <i class="cap-icon ci-file-edit icolor"></i>
                                Update Contact
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>-->
                        <!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateContact() : createContact()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <appUploadFiles
                                        :title="'Photo'"
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
                                    <label>Email</label>
                                    <input v-model="form.email" type="email" name="email" placeholder="E-mail"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <appModalActions
                                    :mode="editMode"
                            ></appModalActions>
              <!--              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close
                                    <span><i class="cap-icon ci-times"></i></span>
                                </button>
                                <button type="submit" v-show="!editMode" class="btn btn-success">Create
                                    <span><i class="cap-icon ci-check"></i></span>
                                </button>
                                <button type="submit" v-show="editMode" class="btn btn-success">Update
                                    <span><i class="cap-icon ci-save"></i></span>
                                </button>
                            </div>-->
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
        name: "Contacts",

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
                contacts: {},

                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    photo_id: ''
                }),

                image: ''
            }
        },

        computed: {
            ...mapGetters(['allContacts']),

            repsSorted() {
                let result = this.contacts.contacts;

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
            ...mapActions(['fetchContacts',
                'fetchContactsS',
                'addContact',
                'renewContact',
                'removeContact']),

            loadContacts() {
                if(this.$gate.isAdmin()) {
                    this.fetchContacts();
                    this.contacts = this.$store.state.contacts;
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
                this.image = 'img/profile/'+this.form.photo_id;
            },

            createContact() {
                this.$Progress.start();
                this.form.post('api/contact')
                     .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Contact added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateContact(id) {
                this.$Progress.start();
                this.form.put('api/contact/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Contact updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            deleteContact(contact){
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
                        this.form.delete('api/contact/'+contact.id)
                            .then(()=>{
                                swal.fire(
                                    'Deleted!',
                                    'Contact has been deleted.',
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
                this.fetchContactsS(query);
            });

            this.loadContacts();

            Fire.$on('AfterCreate', () => {
                this.loadContacts();
            });
        }
    }
</script>

<style scoped>

</style>