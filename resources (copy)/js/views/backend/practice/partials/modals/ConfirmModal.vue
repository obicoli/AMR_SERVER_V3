<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="cl-grey width-100-pc text-left">{{modal_title}}</h4>
                </div>
                <div  class="modal-body">
                    <p>{{confirm_message}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="delete_stuff" class="btn combo-button combo-default">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Processing...</span>
                        <span v-else>Yes</span>
                    </button>
                    <button :disabled="processing" data-dismiss="modal" class="btn-pending-md pointer-cursor">
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import {BASE_API_URL} from "../../../../../router/api_routes";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "ConfirmModal",
        props: ['modal_title','confirm_message','item_url','form_inputs','item_obj','status_action','modal_id'],
        data(){
            return {
                processing: false,
            }
        },
        methods: {
            delete_stuff(){
                this.processing = true;
                post(this.item_url,this.form_inputs)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$emit('successReq',this.item_obj);
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