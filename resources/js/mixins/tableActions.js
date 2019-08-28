export default
{
    data() {
        return {
            sortKey: ['name'],
            sortOrder: ['asc'],
            currentPage: 1,
            pageSize: 3,
            totalPages: 1,
            search: '',

            editMode: true,
            classes: ''
        }
    },

    methods: {
        onPageChange(page) {
            console.log(page);
            this.currentPage = page;
        },

        OnImageSelect(imgSelected, fieldname) {
            this[fieldname] = imgSelected;
        },

        OnImageLoad(imgName, fieldname) {
            this.form[fieldname] = imgName;
        },

        sortBy: function(key) {
            if (key === this.sortKey) {
                this.sortOrder = (this.sortOrder === 'asc') ? 'desc' : 'asc';
            } else {
                this.sortKey = key;
                this.sortOrder = 'asc';
            }
        },
    }
}