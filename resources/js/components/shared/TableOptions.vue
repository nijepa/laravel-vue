<template>
    <div class="mb-3">
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
            <div class="d-flex justify-content-between ml-3">
                <div class=""><input @keyup="changeSearch()" type="text" class="form-control" v-model="search" placeholder="Search"></div>
                <div class="ml-2 mt-2"><label><i class="cap-icon ci-search-plus" style="font-size: 22px"></i></label></div>
            </div>
            <div class="d-flex justify-content-between ml-auto mr-3">
                <div class="mr-2 mt-2"><label for="selPageSize"><i class="cap-icon ci-list-ol" style="font-size: 22px"></i></label></div>
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