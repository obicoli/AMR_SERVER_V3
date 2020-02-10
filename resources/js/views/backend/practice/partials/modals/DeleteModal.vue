<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header width-100-pc">
                    <h4 class="cl-grey width-100-pc text-left"><i class="fa fa-trash-o"></i> {{modal_title}}</h4>
                </div>
                <div  class="modal-body">
                    <p>{{confirm_message}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="delete_stuff" class="btn combo-button combo-default">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Processing...</span>
                        <span v-else><i class="fa fa-trash-o" aria-hidden="true"></i> Yes</span>
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
    import {del} from "../../../../../helpers/api";
    import {BASE_API_URL} from "../../../../../router/api_routes";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "DeleteModal",
        props: ['modal_title','confirm_message','item_url','item_obj','modal_id'],
        data(){
            return {
                processing: false,
                delete_api: null,
            }
        },
        watch: {
            modal_title: function(new_data,old_data){
                this.modal_title = new_data;
            },
            item_url: function(new_data,old_data){
                this.delete_api = new_data;
            }
        },
        methods: {
            delete_stuff(){
                this.processing = true;
                del(this.delete_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$emit('delete-item-event');
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
        },
        mounted(){
            this.delete_api = this.item_url;
        }
    }
</script>

<style scoped>

</style>