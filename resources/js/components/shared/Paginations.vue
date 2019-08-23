<template>
    <ul class="pagination justify-content-center mt-3">
        <li class="page-item">
            <button class="page-link"
                    type="button"
                    @click="onClickFirstPage"
                    :disabled="isInFirstPage"
                    :class="isInFirstPage"
                    aria-label="Go to first page"
            >
                First
            </button>
        </li>

        <li class="page-item">
            <button class="page-link"
                    type="button"
                    @click="onClickPreviousPage"
                    :disabled="isInFirstPage"
                    :class="isInFirstPage"
                    aria-label="Go to previous page"
            >
                Previous
            </button>
        </li>

        <li v-for="page in pages" class="page-item">
            <button class="page-link"
                    type="button"
                    @click="onClickPage(page.name)"
                    :disabled="page.isDisabled"
                    :class="{ active: isPageActive(page.name) }"
                    :aria-label="`Go to page number ${page.name}`"

            >
                {{ page.name }}
            </button>
        </li>

        <li class="page-item">
            <button class="page-link"
                    type="button"
                    @click="onClickNextPage"
                    :disabled="isInLastPage"
                    :class="isInLastPage"
                    aria-label="Go to next page"
            >
                Next
            </button>
        </li>

        <li class="page-item">
            <button class="page-link"
                    type="button"
                    @click="onClickLastPage"
                    :disabled="isInLastPage"
                    :class="isInLastPage"
                    aria-label="Go to last page"
            >
                Last
            </button>
        </li>
    </ul>
</template>

<script>

    export default {

        name: "Paginations",

        props: {
            maxVisibleButtons: {
                type: Number,
                required: false,
                default: 3
            },

            totalPages: {
                type: Number,
                required: true
            },

            total: {
                type: Number,
                required: true
            },

            perPage: {
                type: Number,
                required: true
            },

            currentPage: {
                type: Number,
                required: true
            },
        },

        computed: {

            startPage() {
                if (this.currentPage === 1) {
                    return 1;
                }

                if (this.currentPage === this.totalPages) {
                    return this.totalPages - this.maxVisibleButtons + 1;
                }

                return this.currentPage - 1;

            },

            endPage() {

                return Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);

            },

            pages() {
                const range = [];

                for (let i = this.startPage; i <= this.endPage; i+= 1 ) {
                    range.push({
                        name: i,
                        isDisabled: i === this.currentPage
                    });
                }

                return range;
            },

            isInFirstPage() {
                if(this.currentPage === 1) {
                    return 'disabled';
                }
            },

            isInLastPage() {
                if (this.currentPage === this.totalPages) {

                    return 'disabled';
                }
                //return this.currentPage === this.totalPages;
            },
        },

        methods: {

            onClickFirstPage() {
                this.$emit('pagechanged', 1);
            },

            onClickPreviousPage() {
                this.$emit('pagechanged', this.currentPage - 1);
            },

            onClickPage(page) {
                this.$emit('pagechanged', page);
            },

            onClickNextPage() {
                this.$emit('pagechanged', this.currentPage + 1);
            },

            onClickLastPage() {
                this.$emit('pagechanged', this.totalPages);
            },

            isPageActive(page) {
                return this.currentPage === page;
            },
        }
    }
</script>

<style scoped>
    .active {
        background-color: #4cb2e9;
        color: #ffffff;
    }
    .disabled {
        background-color: transparent;
        color: black;
    }
</style>