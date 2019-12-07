export default
{
    methods: {

        onFileChange(e){
            let file = e.target.files[0];
            let limit = 1024 * 1024 * 2;
            let type = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/msword',
                'message/rfc822'];

            if(file['size'] > limit){
                swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You are uploading a large file',
                });
                return false;
            }

            if(!type.includes(file['type'])) {
                swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You need to upload document file',
                });
                return false;
            }

            this.form.doc = e.target.files[0];
            //console.log(this.form.doc);
            this.form.doc_id = this.form.doc.name;
        }
    }
}
