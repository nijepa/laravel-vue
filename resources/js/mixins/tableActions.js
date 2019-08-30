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

    computed: {

/*        sortFilterData() {

            if (this.search) {
                result = result.filter(item => item.name.toLowerCase().includes(this.search));
            }

            result =  _.orderBy(result, this.sortKey, this.sortOrder);

            return result.filter((row, index) => {
                this.totalPages = Math.ceil(result.length / this.pageSize);
                let start = (this.currentPage - 1) * this.pageSize;
                let end = this.currentPage * this.pageSize;
                if (index >= start && index < end) return true;
            });
        },*/

        classe() {
            if (this.sortOrder === 'asc') {
                return 'fas fa-angle-up ic';
            } else {
                return 'fas fa-angle-down ic'
            }
        },
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