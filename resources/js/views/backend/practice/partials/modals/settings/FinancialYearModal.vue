<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">

            <form @submit.prevent="save_company" class="modal-content">
                <div class="modal-header width-100-pc">
                    <h4 class="cl-grey width-100-pc text-left">{{modal_title}}</h4>
                </div>
                <div  class="modal-body">
                    <div class="width-90-pc float-left fullName mg-bottom-5 mg-left-30">
                        <div class="float-left width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Financial Year Start:&nbsp;&nbsp;</label>
                        </div>
                        <div class="float-left width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <datetime
                                    v-model="form.financial_year_start"
                                    :input-id="'date_input_'"
                                    placeholder="select date"
                                    use12-hour
                                    :type="'date'"
                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                    :value="form.financial_year_start">
                                </datetime>
                            </div>
                        </div>
                    </div>
                    <div class="width-90-pc float-left fullName mg-bottom-5 mg-left-30">
                        <div class="float-left width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">	Financial Year End:&nbsp;&nbsp;</label>
                        </div>
                        <div class="float-left width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <datetime
                                    v-model="form.financial_year_end"
                                    :input-id="'date_input_'"
                                    placeholder="select date"
                                    use12-hour
                                    :type="'date'"
                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                    :value="form.financial_year_end">
                                </datetime>
                            </div>
                        </div>
                    </div>
                    <div class="width-90-pc float-left fullName mg-bottom-5 mg-left-30">
                        <div class="float-left width-30-pc text-right">Current Financial Year:&nbsp;&nbsp;</div>
                        <div class="float-left width-70-pc">
                            <input type="checkbox" v-model="form.current_accounting_period">
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
    import {post} from "../../../../../../helpers/api";
    import {FORM_ACTIONS} from "../../../../../../helpers/process_status";
    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    import {createHtmlErrorString} from "../../../../../../helpers/functionmixin";

    export default {
        name: "FinancialYearModal",
        props: ['financial_year','modal_id','modal_title','filters','api'],
        data(){
            return {
                processing: false,
                form: {
                    id: null,
                    financial_year_start: null,
                    financial_year_end: null,
                    current_accounting_period: false,
                }
            }
        },
        watch: {
            financial_year: function (new_data,old_data) {
                this.financial_year = new_data;
                this.form = this.financial_year;
            },
            api: function (new_data,old_data) {
                this.api = new_data;
            }
        },
        methods: {
            save_company(action_taken){
                this.processing = true;
                if (this.form.country){ this.form.country_id = this.form.country.id; }
                post(this.api,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.processing = false;
                            this.$emit('financial-year-event');
                            $('#'+this.modal_id+'').modal('hide');
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            }
        },
        mounted() {
            if(this.financial_year){
                this.form = this.financial_year;
            }
        }
    }
</script>

<style scoped>

</style>