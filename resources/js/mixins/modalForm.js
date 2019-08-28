export default
{
    methods: {

        newModal() {
            this.editMode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        editModal(user) {
            this.editMode = true;
            $('#addNew').modal('show');
            this.form.fill(user);
            this.imagesPlaces()
        }

    }
}