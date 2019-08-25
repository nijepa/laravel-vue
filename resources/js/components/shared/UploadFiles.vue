<template>
    <div class="form-group">
        <label for="photo" >Photo</label>
        <div class="col-md-2">
            <img :src="imgsrc" class="img-responsive" style="max-height: 100%; max-width:100%">
        </div>
        <div class="col-sm-10">
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
            forma: {
                type: String,
                required: true
            },
            imgsrc: {
                type: String,
                required: true
            }
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
                    vm.imgsrc = e.target.result;
                };

                reader.onloadend = (file) => {
                    //this.form.forma = reader.result;
                    let imageName = reader.result;
                    this.$emit('onimageload', reader.result, this.forma);
                };

                reader.readAsDataURL(file);
            },
        }
    }
</script>

<style scoped>

</style>