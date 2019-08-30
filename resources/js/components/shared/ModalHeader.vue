<template>
    <div class="modal-header">
        <h5 class="modal-title" v-show="!mode" id="addNewLabel">
            <i class="cap-icon ci-plus icolor"></i>
            Add New {{ title }}
        </h5>
        <h5 class="modal-title" v-show="mode" id="addNewLabel">
            <i class="cap-icon ci-file-edit icolor"></i>
            Update {{ title }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
        name: "ModalHeader",

        props: {
            title: {
                type: String,
                required: true
            },
            mode: {
                type: Boolean,
                required: true
            },
        }
    }
</script>

<style scoped>

</style>