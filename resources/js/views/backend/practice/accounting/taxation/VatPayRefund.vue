<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">

                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">
                                
                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div v-if="page_ready" class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left mg-top-30">
                                                    <div class="width-100-pc float-left"><a class="fw-600 cl-444 fs-13 txt-uppercase">VAT Payments and Refunds</a></div>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-15">
                                                    <small class="fs-12 fw-600">Calculate and process your VAT payments or refund</small><br>
                                                    <form @submit.prevent="makePayment(0)" class="width-100-pc float-left mg-top-30 mg-bottom-30">
                                                        <div v-bind:class="{'width-33-pc wiz-item-ctm float-left':true,'active':wizards.tab===0}">
                                                            <div v-bind:class="{'float-left wizard-circle-amref text-center':true}">1</div>
                                                            <small class="fs-12 mg-left-5 padding-top-10">Summary</small>
                                                        </div>
                                                        <div v-bind:class="{'width-33-pc wiz-item-ctm float-left':true,'active':wizards.tab===1}">
                                                            <div v-bind:class="{'float-left wizard-circle-amref text-center':true}">2</div>
                                                            <small class="fs-12 mg-left-5 padding-top-10">Details</small>
                                                        </div>
                                                        <div v-bind:class="{'width-33-pc wiz-item-ctm float-left':true,'active':wizards.tab===2}">
                                                            <div v-bind:class="{'float-left wizard-circle-amref text-center':true}">3</div>
                                                            <small class="fs-12 mg-left-5 padding-top-10">Finish</small>
                                                        </div>
                                                        <div v-if="wizards.tab===0" class="width-100-pc float-left mg-top-15 mg-bottom-30">
                                                            <small class="fs-12 fw-600">Welcome to the VAT Payment and Refund Wizard</small><br>
                                                            <small class="fs-12">You can process VAT payments and refunds that will automatically create
                                                                 a payment or receipt to your selected bank account.</small><br><br>
                                                            <small class="fs-12">Below is a VAT summary for the VAT Period you have selected. 
                                                                To view any payments or refunds already processed print the VAT Payments and 
                                                                Refunds report. Any payment or refund processed in the VAT Period you have selected
                                                                 will be excluded from this summary as they are considered to be payments or 
                                                                 refunds pertaining to a previous VAT period.</small><br>
                                                            <div class="width-100-pc float-left">
                                                                <div class="width-40-pc float-left mg-top-15">
                                                                    <div class="width-50-pc float-right">
                                                                        <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <vue-single-select
                                                                                    name="maybe"
                                                                                    placeholder=""
                                                                                    you-want-to-select-a-post="ok"
                                                                                    v-model="selected_vat_return"
                                                                                    out-of-all-these-posts="makes sense"
                                                                                    :options="tax_returns"
                                                                                    a-post-has-an-id="good"
                                                                                    the-post-has-a-title="make"
                                                                                    option-label="reference_number"
                                                                                ></vue-single-select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                            <div class="input-labeled text-right">{{currency+format_money(vat_return.total_output_tax)}}</div>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                            <div class="input-labeled text-right">{{currency+format_money(vat_return.total_input_tax)}}</div>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                            <div class="input-labeled text-right">{{currency+format_money(vat_return.vat_refundable)}}</div>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                            <div class="input-labeled text-right">{{currency+format_money(vat_return.vat_payable)}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-45-pc float-right">
                                                                        <div class="inlineBlock width-100-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">VAT Period:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Total Output VAT:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Total Input VAT:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Total VAT Refundable:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="inlineBlock width-100-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Total VAT Payable:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else-if="wizards.tab===1" class="width-100-pc float-left mg-top-15 mg-bottom-20">
                                                            <div class="width-100-pc float-left">
                                                                <div class="width-100-pc float-left">
                                                                    <small class="fs-12 fw-600">Details:</small><br>
                                                                </div>
                                                            </div>
                                                            <div class="width-100-pc float-left mg-top-10">
                                                                <small class="fs-12">Specify the date of the VAT payment or claim. You will need to select
                                                                    the bank account and enter a reference and description for the payment or refund. 
                                                                    You can change the payment or refund amount if necessary.</small><br>
                                                            </div>
                                                            <div class="width-40-pc float-left mg-top-15">
                                                                <div class="width-50-pc float-right">
                                                                    <div class="inlineBlock width-100-pc mg-bottom-3 fs-12">
                                                                        <input type="radio" v-model="pay_form.type" value="Payment"> Payment&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" v-model="pay_form.type" value="Refund"> Refund
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <datetime 
                                                                                v-model="pay_form.trans_date"
                                                                                :input-id="'date_input_'"
                                                                                placeholder="select date"
                                                                                use12-hour
                                                                                :type="'date'"
                                                                                :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                :value="pay_form.trans_date"
                                                                                >
                                                                            </datetime>
                                                                        </div>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <vue-single-select
                                                                                name="maybe"
                                                                                placeholder=""
                                                                                you-want-to-select-a-post="ok"
                                                                                v-model="bank"
                                                                                out-of-all-these-posts="makes sense"
                                                                                :options="banks"
                                                                                a-post-has-an-id="good"
                                                                                the-post-has-a-title="make"
                                                                                option-label="account_name"
                                                                            ></vue-single-select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <input v-model="pay_form.reference_number" class="width-100-pc report-filters-inputs" type="text">
                                                                        </div>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <input v-model="pay_form.amount" class="width-100-pc report-filters-inputs" type="number">
                                                                        </div>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <input v-model="pay_form.notes" class="width-100-pc report-filters-inputs" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="width-45-pc float-right">
                                                                    <div class="inlineBlock width-100-pc text-right">
                                                                        <label class="company-label text-right fs-12 width-100-pc">Type:&nbsp;&nbsp;</label>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right">
                                                                        <label class="company-label text-right fs-12 width-100-pc">Date:&nbsp;&nbsp;</label>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right">
                                                                        <label class="company-label text-right fs-12 width-100-pc">Bank Account:&nbsp;&nbsp;</label>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right">
                                                                        <label class="company-label text-right fs-12 width-100-pc">Reference:&nbsp;&nbsp;</label>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right">
                                                                        <label class="company-label text-right fs-12 width-100-pc">Amount:&nbsp;&nbsp;</label>
                                                                    </div>
                                                                    <div class="inlineBlock width-100-pc text-right">
                                                                        <label class="company-label text-right fs-12 width-100-pc">Description:&nbsp;&nbsp;</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else class="width-100-pc float-left mg-top-15 mg-bottom-30">
                                                            <small class="fs-12 fw-600">Accounting now has all the information required to process your VAT Payment</small><br><br>
                                                            <small class="fs-12">To process the VAT Payment, click the Finish button.</small><br><br>
                                                            <small class="fs-12">To review your changes click the Back button.</small><br>
                                                        </div>
                                                        <div class="width-100-pc float-left text-center">
                                                            <button :disabled="wizards.tab<1 || is_initializing" type="button" @click="setWiz(wizards.tab-1,true)" class="btn btn-secondary banking-process">Back</button>
                                                            <a v-if="wizards.tab<2" :hidden="tax_returns.length===0" @click="setWiz(wizards.tab+1)" class="btn btn-secondary banking-process-amref">
                                                                Next
                                                            </a>
                                                            <button v-if="wizards.tab===2" :disabled="is_initializing" type="submit" class="btn btn-secondary banking-process-amref">
                                                                <span v-if="is_initializing"><i class="fa fa-spinner fa-spin"></i> Wait...</span>
                                                                <span v-else>Finish</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div v-else class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                <div class="width-100-pc text-center mg-top-85">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                <copy-right></copy-right>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import CopyRight from "../../partials/CopyRight";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import SupplierModal from "../../partials/modals/vendors/SupplierModal";
    // import QuickLink from "./partials/QuickLink";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {removeElement,paginator,formatMoney,format_lunox_date, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS,ACCOUNTING} from "../../../../../helpers/process_status";
    import {ACCOUNTS_TAXATIONS,ACCOUNTS_TAX_RETURNS,BANKING_ACCOUNTS_URL,ACCOUNTS_TAX_RETURNS_PAYMENTS} from '../../../../../router/api_routes';
    import {ACCOUNTING_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "Index",
        components: {TopNavBar,
        SideBar,CopyRight,SupplierModal,DeleteModal,
        ProcessingOverlay,PaginateTemplate
        },
        data(){
            return {
                page_ready: false,
                progress_overlay: "hide",
                is_initializing: false,
                processing: false,
                
                msg: 'Loading. Please wait...',
                pagination: paginator(),


                
                vat_pin: {},
                vat_pins: [],
                
                // tax_form: {
                //     frequency: 1,
                //     vat_pin: null,
                //     last_period_end_date: null,
                //     last_submission_due_date: null,
                // },


                //Start here
                vat_payments: [],
                banks: [],
                bank: null,
                selected_vat_return: null,
                vat_return: {
                    total_output_tax: null,
                    total_input_tax: null,
                    vat_refundable: null,
                    vat_payable: null,
                },
                tax_returns: [],
                pay_form: {
                    type: null,
                    bank_account_id: null,
                    amount: 0,
                    reference_number: null,
                    trans_date: null,
                    notes: null,
                    vat_return_id:null
                },
                wizards: {
                    tab: 0,
                },
                currency: ACCOUNTING.CURRENCY,
                filters: {},
                vat_period_summary: null,
                TAXATION: ACCOUNTING_WEB_ROUTES.TAXATION,
            }
        },

        watch: {
            selected_vat_return: function(){
                if(this.selected_vat_return){
                    this.loadReturn(ACCOUNTS_TAX_RETURNS+'/'+this.selected_vat_return.id);
                }
            }
        },

        methods: {
            format_money(money_to){
                return formatMoney(money_to);
            },

            setWiz(wiz_tab,back_action=false){
                this.wizards.tab = wiz_tab;
            },

            makePayment(wiz_tab = 0){
                this.is_initializing = true;
                if(this.selected_vat_return){ this.pay_form.vat_return_id = this.selected_vat_return.id; }
                if(this.bank){ this.pay_form.bank_account_id = this.bank.id; }
                post(ACCOUNTS_TAX_RETURNS_PAYMENTS,this.pay_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        this.$router.push(ACCOUNTING_WEB_ROUTES.TAXATION.FILING);
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.is_initializing = false;
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        this.is_initializing = false;
                    }
                    this.is_initializing = false;
                });
            },

            loadReturns(){
                this.is_initializing = true;
                get(ACCOUNTS_TAX_RETURNS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.tax_returns = res.data.results.data;
                        this.vat_period_summary = res.data.results.vat_period_summary;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.pay_form.trans_date = format_lunox_date(this.filters.today);
                        if(this.tax_returns.length){
                            let id_ = this.tax_returns[this.tax_returns.length-1].id;
                            this.loadReturn(ACCOUNTS_TAX_RETURNS+'/'+id_);
                        }else{
                            this.page_ready  = true;
                            this.is_initializing = false;
                            this.processing = false;
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            loadReturn(api_){
                this.is_initializing = true;
                get(api_)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.vat_return = res.data.results;
                        this.pay_form.reference_number = this.vat_return.reference_number;
                        if(this.vat_return.total_output_tax>0){
                            this.pay_form.type = "Payment";
                            this.pay_form.amount = this.vat_return.total_output_tax;
                        }else if(this.vat_return.total_input_tax>0){
                            this.pay_form.type = "Refund"
                            this.pay_form.amount = this.vat_return.total_input_tax;
                        }else{
                            this.pay_form.amount = 0;
                            this.pay_form.type = ""
                        }
                        this.page_ready  = true;
                        this.is_initializing = false;
                        this.processing = false;
                        console.info(this.vat_return);
                    }
                }).catch((err) => {
                    this.page_loaded = false;
                    this.is_initializing = false;
                });
            },

            loadVATPins(){
                this.is_initializing = true;
                get(ACCOUNTS_TAXATIONS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.vat_pins = res.data.results.data;
                        //console.info(this.vat_pins);
                        this.loadBankAccounts(true);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            loadBankAccounts(show_progress=false){
                get(BANKING_ACCOUNTS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.banks = res.data.results.data;
                        console.info(this.banks);
                        if(show_progress){
                            this.loadReturns();
                        }
                    }
                }).catch((err) => {
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },
        mounted() {
            this.loadVATPins();
        }
    }
</script>

<style lang="scss">
    .dijitTextBox input, .dijitTextBox select{
        border-radius: 5px!important;
        font-size: 12px!important;
    }
    .dijitTextBox input.labeled, .dijitTextBox select.labeled{
        background-color: #ebeced!important;
    }
</style>