export default
{
    methods: {
        createItem() {
            this.$Progress.start();
            let formData = this.prepareData();

            axios.post(this.apiPath, formData)
                .then(({ data }) => {
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: this.infoMessage + ' added successfully'
                    });
                    this.$Progress.finish();
                })
                .catch((error) => {
                    console.log('error', Object.assign({}, error.response.data.errors));
                    this.errors = Object.assign({}, error.response.data.errors)
                })
        },

        updateItem(id) {
            this.$Progress.start();
            let formData = this.prepareData(1);

            axios.post(this.apiPath+'/'+this.form.id, formData)
                .then(() => {
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: this.infoMessage + ' updated successfully'
                    });
                    this.$Progress.finish();
                })
                .catch((error) => {
                    this.$Progress.fail();
                    this.errors = Object.assign({}, error.response.data.errors)
                })
        },

        deleteItem(item){
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
                    this.form.delete(this.apiPath+'/'+item.id)
                        .then(()=>{
                            swal.fire(
                                'Deleted!',
                                this.infoMessage + ' has been deleted.',
                                'success'
                            );
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                        swal("Failed!", "There was something wrong.", "warning");
                    });
                } else {
                    console.log('error');
                }
            }).catch((error) => {
                console.log('error', Object.assign({}, error.response.data.errors));
            })
        }
    }
}
