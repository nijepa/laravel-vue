<template>
    <div class="form-group">
        <label for="photo" >Photo</label>
        <div class="col-md-2">
            <img :src="image" class="img-responsive" style="max-height: 100%; max-width:100%">
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
            form: {
                type: String,
                required: true
            },
        },

        methods: {
            updatePhoto(e){
                let file = e.target.files[0];
                console.log(file);
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                let type = ['image/jpeg','image/png','image/jpg','image/gif','image/svg'];
                console.log(limit);
                console.log(file['size']);
                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });

                    return false;
                }
                console.log(file['type']);
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
                    vm.image = e.target.result;
                };
                // reader.readAsDataURL(file);
                reader.onloadend = (file) => {
                    vm.this.form = reader.result;
                };
                reader.readAsDataURL(file);
            },
        }
    }
</script>

<style scoped>

</style>