<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">

            <form @submit.prevent="save_status" class="modal-content">
                <div class="modal-header width-100-pc">
                    <h4 class="cl-grey width-100-pc text-left">{{modal_title}}</h4>
                </div>
                <div  class="modal-body">
                    <div class="width-90-pc float-left fullName mg-bottom-5 mg-left-30">
                        <div class="float-left width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Status:&nbsp;&nbsp;</label>
                        </div>
                        <div class="float-left width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select v-model="form.status">
                                    <option value="">-select-</option>
                                    <option v-for="(key,item) in PROCESS_STATUS" :value="key" :key="'PROCESS_STATUS_'+item">{{key}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn combo-button combo-default">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                        <span v-else>Save</span>
                    </button>
                    <button type="button" :disabled="processing" data-dismiss="modal" class="btn-pending-md pointer-cursor">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    import {del, post} from "../../../../../helpers/api";
    import {BASE_API_URL} from "../../../../../router/api_routes";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS} from "../../../../../helpers/process_status";

    export default {
        name: "ChangeStatus",
        props: ['modal_title','confirm_message','item_url','item_obj','modal_id'],
        data(){
            return {
                processing: false,
                PROCESS_STATUS: PROCESS_STATUS,
                item_api: null,
                form: {
                    status: null,
                }
            }
        },
        watch: {
            item_url: function(new_data,old_data){
                this.item_api = new_data+'?action=Change Status';
            }
        },
        methods: {
            save_status(){
                this.processing = true;
                post(this.item_api,this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$emit('change-status-event',this.item_obj);
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
            this.item_api = this.item_url+'?action=Change Status';
        }
    }
</script>

<style scoped>

</style>