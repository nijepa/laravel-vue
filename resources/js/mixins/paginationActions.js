export default
{
    methods: {

        onPageChange(page) {
            this.currentPage = page;
        },

        onPageSizeChanged(ps) {
            this.onPageChange(1);
            this.pageSize = ps;
        },

        onSearchChanged(s) {
            this.onPageChange(1);
            this.search = s;
        },

    }
}