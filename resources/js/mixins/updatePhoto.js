export default
{

    methods: {

        updatePhoto(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            let limit = 1024 * 1024 * 2;
            let type = ['image/jpeg','image/png','image/jpg','image/gif','image/svg'];
            let errorType = null;

            if(file['size'] > limit) {
                errorType = 'You are uploading a large file';
            }

            if(!type.includes(file['type'])){
                errorType = 'You need to upload image file';
            }

            if(errorType) {
                swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: errorType,
                });

                return false;
            }

            this.fillPhoto(file, reader)
        },
    }
}