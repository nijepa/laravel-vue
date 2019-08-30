<template>
    <td>
        <button @click="atClickEdit"
                class="btn btn-info btn-sm"
                data-toggle="tooltip" data-placement="top" :title="'Edit ' + actionTitle">
            <i class="cap-icon ci-file-edit"></i>
        </button>
        /
        <button  @click="atClickDelete"
                 class="btn btn-danger btn-sm"
                 data-toggle="tooltip" data-placement="top" :title="'Delete ' + actionTitle">
            <i class="cap-icon ci-trash"></i>
        </button>
    </td>
</template>

<script>
    export default {
        name: "TableActions",

        props: {
            actionTitle: {
                type: String,
                required: true
            },
            atClickEdit: {
                type: Function,
                required: true
            },
            atClickDelete: {
                type: Function,
                required: true
            }
        },
    }
</script>

<style scoped>

</style>