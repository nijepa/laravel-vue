<template>
    <div class="modal-footer">
        <button @click="clearErrors()" type="button" class="btn btn-danger" data-dismiss="modal">Close
            <span><i class="cap-icon ci-times"></i></span>
        </button>
        <button type="submit" v-show="!mode" class="btn btn-success">Create
            <span><i class="cap-icon ci-check"></i></span>
        </button>
        <button type="submit" v-show="mode" class="btn btn-success">Update
            <span><i class="cap-icon ci-save"></i></span>
        </button>
    </div>
</template>

<script>
    export default {
        name: "ModalActions",

        props: {
            mode: {
                type: Boolean,
                required: true
            },

            clearErrors: {
                type: Function,
                required: false
            }
        }
    }
</script>

<style scoped>

</style>
