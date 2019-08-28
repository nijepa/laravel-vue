<template>
    <div class="d-flex align-items-center">
        <div class="form-group ml-3 mt-3">
            <i class='cap-icon ci-search-plus'></i>
            <input @keyup="changeSearch()" type="text" class="form-control" v-model="search" placeholder="Search">
        </div>
        <div class="form-group ml-auto mr-3 mt-3">
            <label for="selPageSize">Items per page</label>
            <select v-model="selPageSize" @change="changePageSize()" name="selPageSize" class="form-control" id="selPageSize">
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TableOptions",

        data() {
            return {
                selPageSize: 3,
                search: ''
            }
        },

        props: {
  /*          search: {
                type: String,
                required: true
            },*/
     /*       pageSize: {
                type: Number,
                required: true
            }*/
        },

        methods: {
            changePageSize() {
                this.$emit("pageSizeChanged", this.selPageSize);
            },

            changeSearch() {
                this.$emit("searchChanged", this.search);
            }
        }
    }
</script>

<style scoped>

</style>