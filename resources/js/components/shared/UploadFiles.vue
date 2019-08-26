<template>
    <div class="form-group row">
        <label class="col-3" for="photo">{{ title }}</label>
        <div class="col-3 inline-block">
            <img :src="imgsrc" class="img-responsive" alt="" style="max-height: 100%; max-width:100%">
        </div>
        <div class="col-6 inline-block">
            <input type="file" @change="updatePhoto" name="photo" class="form-input" id="photo">
        </div>
    </div>
</template>

<script>
    export default {
        name: "UploadFiles",

        data(){
            return {
                image: ''
            }
        },

        props: {
            title: {
                type: String,
                required: true
            },

            fieldname: {
                type: String,
                required: true
            },

            imgsrc: {
                type: String,
                required: true
            },

            imgplace: {
                type: String,
                required: true
            },
        },

        methods: {
            updatePhoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                let type = ['image/jpeg','image/png','image/jpg','image/gif','image/svg'];

                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });

                    return false;
                }

                if(!type.includes(file['type'])){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You need to upload image file',
                    });

                    return false;
                }

                let vm = this;
                reader.onload = (e) => {
                    //vm.imgsrc = e.target.result;
                    let imageSelected = e.target.result;
                    this.$emit('onimageselect', imageSelected, this.imgplace);
                };

                reader.onloadend = (file) => {
                    //this.form.forma = reader.result;
                    let imageName = reader.result;
                    this.$emit('onimageload', reader.result, this.fieldname);
                };

                reader.readAsDataURL(file);
            },
        }
    }
</script>

<style scoped>

</style>