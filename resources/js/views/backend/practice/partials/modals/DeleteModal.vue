<template>

    <!-- <div class="modal-content">
        <div class="modal-header">
            <h4 class="cl-grey"><i class="fa fa-trash-o"></i> {{modal_title}}</h4>
        </div>
        <div  class="modal-body">
            <p>{{confirm_message}}</p>
        </div>
        <div class="modal-footer">
            <button type="button" @click="delete_stuff" class="btn btn-inventory primary">
                <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Deleting...</span>
                <span v-else><i class="fa fa-trash-o" aria-hidden="true"></i> Yes, delete</span>
            </button>
            <button :disabled="processing" data-dismiss="modal" class="btn btn-inventory">
                Close
            </button>
        </div>
    </div> -->

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="cl-grey"><i class="fa fa-trash-o"></i> {{modal_title}}</h4>
                </div>
                <div  class="modal-body">
                    <p>{{confirm_message}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="delete_stuff" class="btn btn-inventory primary">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Deleting...</span>
                        <span v-else><i class="fa fa-trash-o" aria-hidden="true"></i> Yes, delete</span>
                    </button>
                    <button :disabled="processing" data-dismiss="modal" class="btn btn-inventory">
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    import {del} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "DeleteModal",
        props: ['modal_title','confirm_message','item_url','item_obj','modal_id'],
        data(){
            return {
                processing: false,
            }
        },
        methods: {
            delete_stuff(){
                this.processing = true;
                del(AppInfo.app_data.server_domain+this.item_url)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$emit('deletionSuccessful',this.item_obj);
                        this.processing = false;
                        $('#'+this.modal_id).modal('hide');
                        //window.location.reload();
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