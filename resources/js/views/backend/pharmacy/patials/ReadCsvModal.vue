<template>

    <div class="modal-content">
        <div class="modal-header">
            <h4 class="cl-grey"><i class="fa fa-trash-o"></i></h4>
            <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
        </div>
        <div  class="modal-body">

        </div>
        <div class="modal-footer">
            <button type="button" @click="delete_stuff" class="btn btn-inventory primary">
                <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Deleting...</span>
                <span v-else><i class="fa fa-trash-o" aria-hidden="true"></i> Yes, delete</span>
            </button>
            <button data-dismiss="modal" class="btn btn-inventory">
                Close
            </button>
        </div>
    </div>
    
</template>

<script>
    export default {
        name: "ReadCsvModal"
    }
</script>

<style scoped>

</style>