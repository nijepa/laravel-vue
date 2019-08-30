<template>
    <div>
        <div class="card-header">
            <h3 class="card-title text-blue font-weight-bold h3">
                <i :class="buttonIcon"> </i>
                {{ title }}
            </h3>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button class="btn btn-success" @click="atClick">
                Add {{ buttonTitle }} <span><i class="cap-icon ci-plus"></i></span>
            </button>
        </div>
        <div class="d-flex align-items-center">
            <div class="form-group ml-3 mt-3">
                <label><i class='cap-icon ci-search-plus'></i></label>
                <input @keyup="changeSearch()" type="text" class="form-control" v-model="search" placeholder="Search">
            </div>
            <div class="form-group ml-auto mr-3 mt-3">
                <label for="selPageSize"><i class='cap-icon ci-list-ol'></i></label>
                <select v-model="selPageSize" @change="changePageSize()" name="selPageSize" class="form-control" id="selPageSize">
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TableOptions",

        data() {
            return {
                selPageSize: 5,
                search: ''
            }
        },

        props: {
            title: {
                type: String,
                required: true
            },
            buttonTitle: {
                type: String,
                required: true
            },
            atClick: {
                type: Function,
                required: true
            },
            buttonIcon: {
                type: String,
                required: true
            }
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