<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3">
                            <i class="fas fa-certificate fa-2x icolor"></i>
                            ABOUT
                        </h3>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button :class="classB" @click="changeAbout()">
                            {{ title }} <span><i :class="classI"></i></span>
                        </button>
                    </div>
                    <div class="mx-3">
<!--                        <form action="" class="mt-3">-->
                            <fieldset :disabled="dis">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input class="form-control" type="text" v-model="about.about.title" id="title">
                                </div>
                   <!--             <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" type="text" id="description" v-model="about.about.body" rows="8"></textarea>
                                </div>-->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <ckeditor :editor="editor" v-model="about.about.body" id="description" name="description"
                                              :class="{ 'is-invalid': form.errors.has('description') }">
                                    </ckeditor>
                                    <has-error :form="form" field="description"></has-error>
                                </div>
                            </fieldset>
                            <div class="d-flex justify-content-center mb-3">
                                <button v-if="!dis" class="btn btn-success" @click="saveAbout()">
                                    Update <span><i class="cap-icon ci-save"></i></span>
                                </button>
                            </div>
<!--                        </form>-->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Caption</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="aboutD in aboutsDet.aboutDet" :key="aboutD.id">
                                <td>{{ aboutD.id }}</td>
                                <td>{{ aboutD.caption }}</td>
                                <td>{{ aboutD.description }}</td>
                                <td>{{ aboutD.created_at | customDate }}</td>
                                <td>
                                    <button @click="editModal(aboutD)" class="btn btn-info btn-sm"
                                            data-toggle="tooltip" data-placement="top" title="Edit User">
                                        <i class="cap-icon ci-file-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <appModalHeader
                                :title="'About'"
                                :mode="editMode"
                        ></appModalHeader>
                        <!-- /.modal-header -->
                        <form @submit.prevent="editMode ? updateAbout() : createAbout()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Caption</label>
                                    <input v-model="form.caption" type="text" name="title" placeholder="Caption"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('caption') }">
                                    <has-error :form="form" field="caption"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <ckeditor :editor="editor" v-model="form.description" id="description" name="description"
                                              :class="{ 'is-invalid': form.errors.has('description') }">
                                    </ckeditor>
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
    import TableActions from '../shared/TableActions';
    import ModalActions from '../shared/ModalActions';
    import ModalHeader from '../shared/ModalHeader';
    import tableActions from '../../mixins/tableActions';
    import modalForm from '../../mixins/modalForm';
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {

        name: "Abouts",

        components: {
            appTableActions: TableActions,
            appModalActions: ModalActions,
            appModalHeader: ModalHeader,
        },

        mixins: [tableActions, modalForm],

        data() {
            return {
                about: [],
                aboutID: 1,
                aboutsDet: {},

                form: new Form({
                    id: '',
                    about_id: this.aboutID,
                    caption: '',
                    description: ''
                }),

                title: 'Edit',
                dis: true,
                classI: 'cap-icon ci-file-edit',
                classB: 'btn btn-outline-info',
                editor: ClassicEditor,
            }
        },

        computed: {
            ...mapGetters(['allAbouts', 'oneAbout', 'allAboutDet']),
        },

        methods: {
            ...mapActions(['fetchAbouts',
                'fetchAbout',
                'fetchAboutsS',
                'fetchAboutDet',
                'addAbout',
                'renewAbout',
                'removeAbout']),

            loadAbouts() {
                if(this.$gate.isAdmin()) {
                    this.fetchAbout(this.aboutID);
                    this.about = this.$store.state.abouts;
                    this.fetchAboutDet(this.aboutID);
                    this.aboutsDet = this.$store.state.aboutDet;
                }
            },

            imagesPlaces() {
                this.logoSmall = 'img/companies/logosSmall/'+this.form.logo_small_id;
                this.logo = 'img/companies/'+this.form.logo_id;
                this.image = 'img/companies/'+this.form.photo_id;
            },

            changeAbout() {
                this.dis = !this.dis;
                this.title = 'Cancel';
                this.classI = 'cap-icon ci-times';
                this.classB = 'btn btn-outline-danger';
                if (this.dis === true) {
                    this.title = 'Edit';
                    this.classI = 'cap-icon ci-file-edit';
                    this.classB = 'btn btn-outline-info';
                }
            },

            saveAbout() {
                this.$Progress.start();
                axios.put("api/about/"+this.about.about.id, this.about.about)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        toast.fire({
                            type: 'success',
                            title: 'About updated successfully'
                        });
                        this.$Progress.finish();
                        this.changeAbout();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },

            createAbout() {
                this.$Progress.start();
                this.form.post('api/about_dets')
                    .then(({ data }) => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'About added successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {})
            },

            updateAbout(id) {
                this.$Progress.start();
                this.form.put('api/about_dets/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'About updated successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
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
                        this.form.delete('api/about/'+aboutD.id)
                        .then(()=>{
                            swal.fire(
                                'Deleted!',
                                'About has been deleted.',
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
            }
        },

        created() {
            this.loadAbouts();
            Fire.$on('AfterCreate', () => {
                this.loadAbouts();
            });
        }
    }
</script>

<style scoped>

</style>