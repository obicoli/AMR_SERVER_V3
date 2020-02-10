<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_balance" class="modal-content bg-f4">

                <div class="modal-header width-100-pc text-left">
                    <h4 class="float-left text-left width-100-pc">{{modal_title}}</h4>
                </div>

                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-8">
                            <div class="width-100-pc float-left mg-top-20">
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Account:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <multi-select v-model="selected_account" :disable="is_initializing" :options="options" :limit="1" filterable/>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Reason:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.reason" v-bind:class="{'height-32':true,'custom-attended-field':form.reason}" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Current Opening Balance({{currency}}):&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.current_balance" disabled v-bind:class="{'height-32':true,'custom-attended-field':form.current_balance}" step="any" type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">New Opening Balance({{currency}}):&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.amount" required v-bind:class="{'height-32':true,'custom-attended-field':form.amount}" type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Opening Balance as At:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <datetime
                                                v-model="form.as_at"
                                                :input-id="'date_input_'"
                                                placeholder="select date"
                                                use12-hour
                                                :type="'date'"
                                                :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                :value="form.as_at"
                                                >
                                            </datetime>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName text-center mg-top-20">
                                    <button :disabled="processing || is_initializing" @click="save_balance(FORM_ACTIONS.SAVE_CLOSE)" type="button" class="btn banking-process-amref pointer-cursor">Save</button>
                                    <button :disabled="processing || is_initializing" @click="save_balance(FORM_ACTIONS.SAVE_NEW)" type="button" class="btn banking-process pointer-cursor">Save & New</button>
                                    <button :disabled="processing || is_initializing" type="button" data-dismiss="modal" class="btn banking-process pointer-cursor">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {post, get} from "../../../../../../helpers/api";
    import {createHtmlErrorString,formatMoney, format_lunox_date, reset_forms} from "../../../../../../helpers/functionmixin";
    import { FORM_ACTIONS,ACCOUNTING} from '../../../../../../helpers/process_status';
    import {COA_API,CHART_OF_ACCOUNT_API,CHART_OF_ACCOUNT_OPEN_BAL_API} from "../../../../../../router/api_routes";
    export default {
        name: "AccountOpeningBalance",
        props:['filters','modal_id','balance_sheet_accounts','modal_title','currency'],
        data(){
            return {
                selected_account: [],
                account: null,
                options: [],
                processing: false,
                is_initializing: false,
                form: {
                    action_taken: 'Save',
                    account_id: null,
                    reason: null,
                    current_balance: 0,
                    amount: 0,
                    as_at: null,
                },
                DEFAULT_API: CHART_OF_ACCOUNT_API,
                FORM_ACTIONS:FORM_ACTIONS,
                COA_CODES: ACCOUNTING.COA_CODES,
            }
        },
        watch: {
            selected_account: function(){
                if(this.selected_account.length){
                    this.form.account_id = this.selected_account[0];
                    this.showCoa(this.selected_account[0]);
                }
            }
        },
        methods: {
            format_money(money_to){
                return formatMoney(money_to);
            },
            setItems(){
                if(this.filters){
                    this.form.as_at = format_lunox_date(this.filters.today);
                }
                if(this.balance_sheet_accounts.length){
                    this.options = [];
                    for (let index = 0; index < this.balance_sheet_accounts.length; index++) {
                        const element = this.balance_sheet_accounts[index];
                        let item = {
                            value: element.id,
                            label: element.name,
                            group: element.account_type.name,
                        }
                        this.options.push(item);
                    }
                }
            },
            showCoa(coa_id){
                this.is_initializing = true;
                get(CHART_OF_ACCOUNT_API+'/'+coa_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.account = res.data.results.data;
                        //console.info(this.account);
                        this.form.current_balance = this.account.opening_balance;
                        this.is_initializing = false;
                        this.processing = false;
                        this.page_loaded = true;
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                    this.processing = false;
                });
            },
            save_balance: function (action_taken) {
                this.processing = true;
                this.is_initializing = true;
                if(this.account){ this.form.account_id = this.account.id; }
                post(CHART_OF_ACCOUNT_OPEN_BAL_API,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.is_initializing = false;
                            if(action_taken === FORM_ACTIONS.SAVE_NEW){
                                //this.form = reset_forms(this.form);
                                this.$awn.success(res.data.description);
                                this.$emit("adjust-account-balance-event");
                            }else{
                                this.$awn.success(res.data.description);
                                this.$emit("adjust-account-balance-event");
                                $("#"+this.modal_id+"").modal('hide');
                            }
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        console.info(err.response.data.errors);
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.is_initializing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                    this.is_initializing = false;
                });
            },
        },
        mounted() {
            this.setItems();
        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-lg {
        max-width: 800px!important;
        min-width: 800px!important;
    }
    .modal-header{
        /* border-bottom: 1px solid #fff!important; */
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .fullAdd.employeeForm .row {
        padding-bottom: 4px;
    }
    .inlineBlock {
        display: inline-block;
    }
    .inlineBlock label {
        font-weight: 600!important;
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 14px!important;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select{
        outline: none!important;
        /* height: 32px!important; */
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 5px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }

    .btn-group{
        width: 100%;
        font-size: 13px!important;
        border-radius: 5px!important;
    }

    input::placeholder, textarea::placeholder  {
        color: #babec5!important;
        font-size: 12px!important;
        font-style: italic;
        font-weight: 400!important;
    }
    .checkboxInline {
        margin-left: 5px;
    }
    input[type=checkbox]:not(.dijitCheckBoxInput):not(.idsCheckbox__input) {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        background-color: transparent;
        border: 1px solid #8D9096;
        border-radius: 2px;
        background-repeat: no-repeat;
        background-size: 124px;
        background-position: -28px -3px;
        user-select: none;
        -webkit-appearance: none;
    }
    .attended_fiel{
        background-color: #f4f4f4!important;
        font-weight: 600!important;
    }
    .form-control{
        height: 27px;
    }
    b, strong {
        font-weight: 400!important;
    }
    .dropdown-menu>li>a {
        padding: 3px 20px 3px 30px!important;
    }
</style>


