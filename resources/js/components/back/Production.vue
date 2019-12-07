<template>
    <div class="container">
        <div class="row" v-if="$gate.isAdmin()">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-blue font-weight-bold h3">
                            <i class="fas fa-tools fa-2x icolor"></i>
                            PRODUCTION
                        </h3>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button :class="classB" @click="changeAbout()">
                            {{ title }} <span><i :class="classI"></i></span>
                        </button>
                    </div>
                    <div class="mx-3" >
                        <fieldset :disabled="dis" >
                            <div class="form-group" v-for="prod in productions" :key="prod.id" >
                                <label for="body">Description</label>
                                <VueEditor v-model="prod.body" id="body" name="body" :disabled="dis" />
                                <!--<ckeditor :editor="editor" v-model="prod.body" id="body" name="body" :disabled="dis">
                                </ckeditor>-->
                            </div>
                        </fieldset>
                        <div class="d-flex justify-content-center mb-3">
                            <button v-if="!dis" class="btn btn-success" @click="saveAbout()">
                                Update <span><i class="cap-icon ci-save"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row" v-else>
            <unauthorized></unauthorized>
        </div>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import { VueEditor } from "vue2-editor";

    export default {

        name: "Productions",

        components: {
            VueEditor
        },

        data() {
            return {
                productions: {},

                title: 'Edit',
                dis: true,
                classI: 'cap-icon ci-file-edit',
                classB: 'btn btn-outline-info',
                editor: ClassicEditor,
            }
        },

        methods: {

            loadAbouts() {
                if(this.$gate.isAdmin()) {
                    axios.get("api/productions")
                        .then((response) => {
                            console.log("aaaaa");
                            this.productions = response.data;
                            })
                        .catch(() => {

                        })
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
                axios.put("api/productions/"+this.productions[0].id, this.productions[0])
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        toast.fire({
                            type: 'success',
                            title: 'Production updated successfully'
                        });
                        this.$Progress.finish();
                        this.changeAbout();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    })
            },
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
