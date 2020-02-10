<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_account" class="modal-content bg-f4">

                <div class="modal-header width-100-pc text-left">
                    <h4 class="float-left text-left width-100-pc">{{modal_title}}</h4>
                </div>

                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="padding-right-10">
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-25-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Account Type:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-75-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <vue-single-select
                                                    name="maybe"
                                                    id="account_type_id"
                                                    placeholder=""
                                                    you-want-to-select-a-post="ok"
                                                    v-model="account_type"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="local_account_types"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-25-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Detail Type:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-75-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <vue-single-select
                                                name="maybe"
                                                placeholder=""
                                                id="detail_type_id"
                                                you-want-to-select-a-post="ok"
                                                v-model="default_coa"
                                                out-of-all-these-posts="makes sense"
                                                :options="accounts"
                                                a-post-has-an-id="good"
                                                the-post-has-a-title="make"
                                                option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname"></label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea disabled v-model="notes" v-bind:class="{'min-height-180 bg-eee':true,'ctm-attended-field':form.address}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="padding-left-10">

                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-30-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Account Name:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-70-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.name" v-bind:class="{'height-32':true,'ctm-attended-field':form.name}" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row fullName">
                                    <div class="inlineBlock width-80-pc">
                                        <label class="fullname"><span class="cl-red fs-14 fw-600">*</span>Account Name</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.name" v-bind:class="{'height-32':true,'ctm-attended-field':form.name}" type="text" required>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-30-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Notes:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-70-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="form.notes" v-bind:class="{'min-height-50':true,'ctm-attended-field':form.notes}"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row fullName">
                                    <div class="inlineBlock width-80-pc">
                                        <label class="fullname">Description</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.notes" v-bind:class="{'height-32':true,'ctm-attended-field':form.notes}" type="text">
                                        </div>
                                    </div>
                                </div> -->

                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-35-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Default VAT Type:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-65-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <vue-single-select
                                                    name="maybe"
                                                    placeholder=""
                                                    id="vat_type_id"
                                                    you-want-to-select-a-post="ok"
                                                    v-model="vat_type"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="vat_types"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="display_as"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row fullName mg-top-20">
                                    <div class="inlineBlock width-50-pc">
                                        <label class="fullname">Default Tax Code</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <vue-single-select
                                                    name="maybe"
                                                    placeholder=""
                                                    you-want-to-select-a-post="ok"
                                                    v-model="form.tax_code"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="tax_codes"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div> -->

                                <div v-if="user_mode==='Edit'" class="row fullName">
                                    <div v-if="!form_model.is_special" class="inlineBlock width-80-pc mg-left-15">
                                        <div class="dijitInline firstName dijitTextBox">
                                            <label class="check-container element-inlined">Is a sub-account
                                                <input type="checkbox" v-model="form.is_sub_account">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="form.is_sub_account" class="inlineBlock width-100-pc mg-top-2">
                                        <div v-if="!form_model.is_special" class="dijitInline firstName dijitTextBox width-70-pc">
                                            <vue-single-select
                                                    name="maybe"
                                                    placeholder=""
                                                    id="sub_account_id"
                                                    you-want-to-select-a-post="ok"
                                                    v-model="main_account"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="sub_accounts"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="user_mode==='Create'" class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <label class="check-container element-inlined">Is a sub-account
                                                <input type="checkbox" v-model="form.is_sub_account">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="form.is_sub_account" class="inlineBlock width-100-pc mg-top-2">
                                        <div class="dijitInline firstName dijitTextBox width-70-pc">
                                            <vue-single-select
                                                name="maybe"
                                                placeholder=""
                                                id="sub_account_id_2"
                                                you-want-to-select-a-post="ok"
                                                v-model="main_account"
                                                out-of-all-these-posts="makes sense"
                                                :options="sub_accounts"
                                                a-post-has-an-id="good"
                                                the-post-has-a-title="make"
                                                option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div v-if="user_mode==='Edit'" class="row fullName mg-top-5">
                                    <div v-if="form_model.balance_obj.state===0" class="inlineBlock width-35-pc padding-right-3 mg-right-5">
                                        <label class="fullname" for="firstName">Balance</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input type="number" step="any" min="1" v-model="form.balance" v-bind:class="{'height-32':true,'ctm-attended-fieldl':form.balance}">
                                        </div>
                                    </div>
                                    <div v-if="form_model.balance_obj.state===0" class="inlineBlock width-35-pc">
                                        <label class="fullname" for="firstName">As of:</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.as_of" v-bind:class="{'height-32':true,'ctm-attended-field':form.as_of}" type="date">
                                        </div>
                                    </div>
                                    <div v-if="form_model.balance_obj.state===1" class="inlineBlock width-100-pc padding-right-3 mg-right-5 mg-top-20">
                                        <label class="fullname fs-14" for="firstName">Balance: Ksh{{format_money(form_model.balance_obj.balance)}}</label>
                                    </div>
                                </div> -->

                                <div v-if="account_name_show && type_show" class="row fullName mg-top-5">
                                    <!-- Create -->
                                    <div v-if="user_mode==='Create'" class="inlineBlock width-35-pc padding-right-3 mg-right-5">
                                        <label v-if="selected_nature===''" class="fullname" for="firstName">Balance</label>
                                        <label v-if="selected_nature===assets || selected_nature===equity" class="fullname" for="firstName">Balance</label>
                                        <label v-if="selected_nature===liability" class="fullname" for="firstName">Unpaid Balance</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input type="number" step="any" min="1" v-model="form.balance" v-bind:class="{'height-32':true,'ctm-attended-fieldl':form.balance}">
                                        </div>
                                    </div>
                                    <div v-if="user_mode==='Create'" class="inlineBlock width-35-pc">
                                        <label class="fullname" for="firstName">As of:</label>
                                        <div class="dijitInline firstName dijitTextBox">
                                            <datetime 
                                                v-model="form.as_of"
                                                :input-id="'date_input_000000'"
                                                placeholder="select date"
                                                use12-hour
                                                :type="'date'"
                                                :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                :value="form.as_of"
                                                >
                                            </datetime>
                                            <!-- <input v-model="form.as_of" v-bind:class="{'height-32':true,'ctm-attended-field':form.as_of}" type="date"> -->
                                        </div>
                                    </div>
                                    <!-- Edit -->

                                    <!-- <div v-if="user_mode==='Edit' && form_model.total_transaction===0" class="inlineBlock width-35-pc padding-right-3 mg-right-5">
                                        <label v-if="selected_nature===''" class="fullname" for="firstName">Balance</label>
                                        <label v-if="selected_nature===assets || selected_nature===equity" class="fullname" for="firstName">Balance</label>
                                        <label v-if="selected_nature===liability" class="fullname" for="firstName">Unpaid Balance</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input type="number" step="any" min="1" v-model="form.balance" v-bind:class="{'height-32':true,'ctm-attended-fieldl':form.balance}">
                                        </div>
                                    </div> -->

                                    <!-- <div v-if="user_mode==='Edit' && form_model.total_transaction===0" class="inlineBlock width-35-pc">
                                        <label class="fullname" for="firstName">As of:</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <datetime 
                                                v-model="form.as_of"
                                                :input-id="'date_input_000'"
                                                placeholder="select date"
                                                use12-hour
                                                :type="'date'"
                                                :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                :value="form.as_of"
                                                >
                                            </datetime>
                                        </div>
                                    </div> -->
                                    <div v-if="user_mode==='Edit' && form_model.total_transaction>0" class="inlineBlock width-100-pc padding-right-3 mg-right-5 mg-top-20">
                                        <label class="fullname fs-14" for="firstName">Balance: Ksh{{format_money(form_model.balance)}}</label>
                                    </div>
                                </div>

                                <!-- <div class="row fullName mg-top-5">
                                    <div v-if="selected_nature==='' || selected_nature===assets || selected_nature===liability || selected_nature===equity" class="inlineBlock width-35-pc padding-right-3 mg-right-5">
                                        <label v-if="selected_nature===''" class="fullname" for="firstName">Balance</label>
                                        <label v-if="selected_nature===assets || selected_nature===equity" class="fullname" for="firstName">Balance</label>
                                        <label v-if="selected_nature===liability" class="fullname" for="firstName">Unpaid Balance</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input type="number" step="any" min="1" v-model="form.balance" v-bind:class="{'height-32':true,'ctm-attended-fieldl':form.balance}">
                                        </div>
                                    </div>
                                    <div v-if="selected_nature==='' || selected_nature===assets || selected_nature===liability || selected_nature===equity" class="inlineBlock width-35-pc">
                                        <label class="fullname" for="firstName">As of:</label>
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.as_of" v-bind:class="{'height-32':true,'ctm-attended-field':form.as_of}" type="date">
                                        </div>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button v-if="user_mode==='Edit'" type="submit" :disabled="processing" class="btn combo-button combo-default">
                        <span>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </span>
                    </button>
                    <div v-else  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-secondary banking-process-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> {{form.action_taken}}</span>
                                </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a @click="save_account('Save & New')" class="dropdown-item pointer-cursor"> Save & New</a>
                                <a @click="save_account('Save & Close')" class="dropdown-item pointer-cursor"> Save & Close</a>
                            </div>
                        </div>
                    </div>
                    <button type="button" :disabled="processing" data-dismiss="modal" class="btn banking-process pointer-cursor">
                        Close
                    </button>
                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {post, get} from "../../../../../../helpers/api";
    import {createHtmlErrorString,formatMoney, format_lunox_date, reset_forms} from "../../../../../../helpers/functionmixin";
    import { FORM_ACTIONS } from '../../../../../../helpers/process_status';
    import {COA_API,CHART_OF_ACCOUNT_API} from "../../../../../../router/api_routes";
    export default {
        name: "AccountModal",
        props:['form_model','vat_types','account_types','ACCOUNTING','filters','user_mode','modal_id','modal_title'],
        data(){
            return {
                processing: false,
                account_type: null,
                default_coa: null,
                main_account: null,
                local_account_types: [],
                notes: null,
                vat_type: null,
                form: {
                    action_taken: 'Save',
                    //default_coa: '',
                    default_coa_id: '',
                    account_type_id: '',
                    detail_type_id: '',
                    vat_type_id: '',
                    notes: '',
                    detail_type: '',
                    name: '',
                    tax_code: '',
                    balance: '',
                    as_of: '',
                    is_sub_account: false,
                    main_account_id: '',
                },
                assets: this.ACCOUNTING.ACCOUNT_NATURES.ASSETS,
                expense: this.ACCOUNTING.ACCOUNT_NATURES.EXPENSE,
                liability: this.ACCOUNTING.ACCOUNT_NATURES.LIABILITY,
                revenue: this.ACCOUNTING.ACCOUNT_NATURES.REVENUE,
                equity: this.ACCOUNTING.ACCOUNT_NATURES.EQUITY,
                currency: this.ACCOUNTING.CURRENCY,
                account_names: this.ACCOUNTING.COA_NAMES,
                account_name_show: false,
                type_show: false,
                selected_nature: '',
                selected_type_name: '',
                accounts_in_type: [],
                accounts: [],
                sub_accounts: [],
                DEFAULT_API: CHART_OF_ACCOUNT_API,
            }
        },
        watch: {
            account_type: function(){
                if(this.account_type){
                    this.default_coa = null;
                    if(this.user_mode === "Create"){
                        this.loadCoaByType(this.account_type.id);
                    }
                    this.getOptType(this.account_type);
                }
            },
            default_coa: function(){
                if(this.default_coa){
                    this.sub_accounts = [];
                    this.main_account = null;
                    //this.sub_accounts.push(this.default_coa);
                    this.notes = this.default_coa.notes;
                    this.loadChartOfAccountByType(this.default_coa.code);
                    this.getOptType(this.account_type);
                }
            },
            user_mode: function(new_data,old_data){
                this.user_mode = new_data;
            },
            form_model: function(new_data,old_data){
                this.form_model = new_data;
                this.setForm();
            }
        },
        methods: {

            setForm(){
                if(this.form_model){
                    this.DEFAULT_API = CHART_OF_ACCOUNT_API+'/'+this.form_model.id;
                    this.account_type = this.form_model.account_type;
                    this.form.account_type_id = this.form_model.account_type.id;
                    //this.default_coa = this.form_model.default_coa;
                    this.form.name = this.form_model.name;
                    this.form.notes = this.form_model.notes;
                    this.form.default_coa_id = this.form_model.default_coa.id;
                    this.form.is_sub_account =  this.form_model.is_sub_account;
                    this.vat_type = this.form_model.vat_type;
                    if(this.filters){this.form.as_of = format_lunox_date(this.filters.today); }
                    // if(this.form_model.total_transaction>0){
                    //     this.local_account_types = [];
                    //     this.account_type = this.form_model.account_type;
                    //     this.local_account_types.push(this.account_type);
                    //     //
                    //     this.accounts = [];
                    //     this.default_coa = this.form_model.default_coa;
                    //     this.accounts.push(this.default_coa);
                    // }else{
                    //     this.local_account_types = this.account_types;
                    // }
                    this.local_account_types = [];
                    this.account_type = this.form_model.account_type;
                    this.local_account_types.push(this.account_type);
                    //
                    this.accounts = [];
                    this.default_coa = this.form_model.default_coa;
                    this.accounts.push(this.default_coa);
                    //alert(this.accounts.length+' uuuuuuu');
                }else{
                    this.DEFAULT_API = CHART_OF_ACCOUNT_API
                    this.local_account_types = this.account_types;
                }
            },

            loadCoaByType(type_id){
                get(COA_API+'?type_id='+type_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.accounts = res.data.results.data;
                        console.info(this.accounts);
                        alert(this.accounts.length+' nnnnnnn');
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },
            loadChartOfAccountByType(default_code){
                get(CHART_OF_ACCOUNT_API+'?default_code='+default_code)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.sub_accounts = res.data.results.data;
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },
            getOptType(optiona){
                if( (this.account_type.name === this.account_names.AC_PAYABLE) || (this.account_type.name === this.account_names.AC_RECEIVABLE) ){
                    this.account_name_show = false;
                }else{
                    this.account_name_show = true;
                }
                if(optiona.accounts_nature.name===this.assets || optiona.accounts_nature.name===this.liability || optiona.accounts_nature.name===this.equity ){
                    this.type_show = true;
                }else{
                    this.type_show = false;
                }
                if(this.default_coa){
                    if(this.default_coa.code===this.ACCOUNTING.COA_CODES.INVENTORY){
                        this.type_show = false;
                    }
                }
            },
            // getOptTax(){
            //     this.form.tax_code_id = this.form.tax_code.id;
            // },
            // getOptSub(){
            //     this.form.company_main_chart_account_id = this.form.company_main_chart_account.id;
            // },
            format_money(money_to){
                return formatMoney(money_to);
            },

            save_account: function (action_taken) {
                this.processing = true;
                if(this.account_type){ this.form.account_type_id = this.account_type.id; }
                if(this.default_coa){ this.form.detail_type_id = this.default_coa.id; }
                if(this.vat_type){ this.form.vat_type_id = this.vat_type.id; }
                if(this.main_account){ this.form.main_account_id = this.main_account.id; }
                post(this.DEFAULT_API,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            if(this.user_mode === "Create"){
                                this.account_type = null;
                                this.default_coa = null;
                                this.vat_type = null;
                                this.main_account = null;
                                this.form = reset_forms(this.form);
                                this.$awn.success(res.data.description);
                                this.$emit("create-account-event");
                            }else{
                                this.$awn.success(res.data.description);
                                this.$emit("edit-account-event");
                                $("#"+this.modal_id+"").modal('hide');
                            }
                            
                            if(action_taken===FORM_ACTIONS.SAVE_CLOSE){
                                $("#"+this.modal_id+"").modal('hide');
                            }
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
        },
        mounted() {
            this.setForm();
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
        border-radius: 2px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
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
</style>


