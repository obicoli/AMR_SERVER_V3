<template>
    <form>

        <div class="modal-content">

            <div class="modal-header">
                <h4 class="cl-grey fw-600 fs-16"><i class="fa fa-check-circle"></i> Add Measure Unit:</h4>
            </div>
            <div  class="modal-body">

                <div class="bg-white border-top-0 border-bottom-0 border-radius-0">

                    <div class="row form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Name:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input type="text" required placeholder="e.g Kilogram" class="form-control product-entry-input-field">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Slug:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input type="text" required placeholder="e.g Kg" class="form-control product-entry-input-field">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Status:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input type="number" class="form-control product-entry-input-field">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i>Save</span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i>
                    Close
                </button>
            </div>

        </div>
    </form>
</template>

<script>
    export default {
        name: "AddUnitModal",
        props: [],
        data(){
            return {
                processing: false,
            }
        }
    }
</script>

<style scoped>

</style>