<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <form @submit.prevent="save_status" class="modal-content bg-f4">
                <div class="modal-header width-100-pc">
                    <h4 class="cl-grey width-100-pc text-left">{{modal_title}}</h4>
                </div>
                <div  class="modal-body">
                    <div class="width-90-pc float-left fullName mg-bottom-5 mg-left-30">
                        <div class="float-left width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Name:&nbsp;&nbsp;</label>
                        </div>
                        <div class="float-left width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input type="text" v-model="form.name">
                            </div>
                        </div>
                    </div>
                    <div class="width-90-pc float-left fullName mg-bottom-5 mg-left-30">
                        <div class="float-left width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Report Group Type:&nbsp;&nbsp;</label>
                        </div>
                        <div class="float-left width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select v-model="form.group_type">
                                    <option selected disabled value="">-select-</option>
                                    <option :value="COA_CODES.COS">Sales</option>
                                    <option :value="COA_CODES.INVENTORY">Purchase</option>
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
    import {del, post} from "../../../../../../helpers/api";
    import {CHART_OF_ACCOUNT_API} from "../../../../../../router/api_routes";
    import {createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    import {PROCESS_STATUS,ACCOUNTING} from "../../../../../../helpers/process_status";

    export default {
        name: "SalesPurchaseModal",
        props: ['modal_title','confirm_message','item_url','item_obj','modal_id'],
        data(){
            return {
                processing: false,
                PROCESS_STATUS: PROCESS_STATUS,
                item_api: null,
                form: {
                    group_type: null,
                    name: null,
                },
                COA_CODES: ACCOUNTING.COA_CODES,
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
                post(CHART_OF_ACCOUNT_API+'?sales_purchase=Sales and Purchase Accounts',this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$emit('create-account-event',this.item_obj);
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