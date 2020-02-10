<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">

        <form @submit.prevent="delete_stuff" class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="cl-grey">{{modal_title}}</h4>
                </div>

                <div  class="modal-body padding-left-20 padding-right-20">
                    <div class="form-group">
                        <label>Reason:</label>
                        <textarea class="form-control min-height-60" required v-model="form.note"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="combo-button combo-default">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Processing...</span>
                        <span v-else> Submit</span>
                    </button>
                    <button :disabled="processing" data-dismiss="modal" class="combo-button combo-default">
                        Close
                    </button>
                </div>

            </div>

        </form>

    </div>

</template>

<script>
    import {post} from "../../../../../../helpers/api";
    import {createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    import {PRODUCT_REQUISITIONS} from "../../../../../../router/api_routes";

    export default {
        name: "DenyModal",
        props: ['modal_title','confirm_message','item_url','item_obj','modal_id'],
        data(){
            return {
                processing: false,
                form: {
                    action: 'Deny',
                    requisition_id: this.item_obj,
                    status: 'Declined',
                    note: ''
                }
            }
        },
        methods: {
            delete_stuff(){
                this.processing = true;
                post(PRODUCT_REQUISITIONS+'/'+this.item_obj, this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$emit('declined',this.item_obj);
                        this.processing = false;
                        $('#'+this.modal_id).modal('hide');
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>