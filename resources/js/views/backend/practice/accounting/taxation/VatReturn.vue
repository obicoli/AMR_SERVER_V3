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
                                            <div v-if="page_ready && tax_returns.length>0" class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left mg-top-30">
                                                    <div class="width-100-pc float-left"><a class="fw-600 cl-444 fs-13 txt-uppercase">VAT Returns & Reports</a></div>
                                                    <div class="width-100-pc float-left">
                                                        <div class="width-30-pc float-left mg-top-15">
                                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                                <div class="btn-group" role="group">
                                                                    <button :disabled="processing || is_initializing" id="btnGroupDrop" type="button" class="dropdown-toggle btn btn-secondary banking-process" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Transactions
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                                        <router-link :to="TAXATION.ADJUSTMENTS" class="dropdown-item pointer-cursor"> VAT Adjustments</router-link>
                                                                        <router-link :to="TAXATION.PAY_AND_REFUND" class="dropdown-item pointer-cursor"> VAT Payments and Refunds</router-link>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group mg-left-15" role="group" aria-label="Button group with nested dropdown">
                                                                <div class="btn-group" role="group">
                                                                    <button :disabled="processing || is_initializing" id="btnGroupDrop" type="button" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Reports
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                                        <router-link :to="TAXATION.REPORTS+'?type=VAT Report'" class="dropdown-item pointer-cursor">VAT Report</router-link>
                                                                        <router-link :to="TAXATION.REPORTS+'?type=VAT Summary Report'" class="dropdown-item pointer-cursor">VAT Summary Report</router-link>
                                                                        <router-link :to="TAXATION.REPORTS+'?type=VAT Transactions Report'" class="dropdown-item pointer-cursor">VAT Transactions Report</router-link>
                                                                        <router-link :to="TAXATION.REPORTS+'?type=VAT Payments and Refunds Report'" class="dropdown-item pointer-cursor">VAT Payments and Refunds Report</router-link>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-40-pc float-right mg-top-15">
                                                            <div class="width-30-pc float-right mg-left-3">
                                                                <div class="inlineBlock width-100-pc">
                                                                    <label class="company-label fs-12 width-100-pc fw-600">Next</label>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                    <div class="input-labeled">{{vat_period_summary.next_period_end_date}}</div>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                    <div class="input-labeled">{{vat_period_summary.next_submission_due_date}}</div>
                                                                </div>
                                                            </div>
                                                            <div class="width-30-pc float-right">
                                                                <div class="inlineBlock width-100-pc">
                                                                    <label class="company-label fs-12 width-100-pc fw-600">Previous</label>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                    <div class="input-labeled">{{vat_period_summary.last_period_end_date}}</div>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                    <div class="input-labeled">{{vat_period_summary.last_submission_due_date}}</div>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right mg-bottom-3">
                                                                    <div class="input-labeled">
                                                                        <span v-if="vat_period_summary.frequency===1">Monthly</span>
                                                                        <span v-else-if="vat_period_summary.frequency===3">Quarterly</span>
                                                                        <span v-else-if="vat_period_summary.frequency===6">Halfly</span>
                                                                        <span v-else-if="vat_period_summary.frequency===12">Yearly</span>
                                                                        <span v-else></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="width-35-pc float-right">
                                                                <div class="inlineBlock width-100-pc text-right">
                                                                    <label class="company-label text-right fs-12 width-100-pc">.&nbsp;&nbsp;</label>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right">
                                                                    <label class="company-label text-right fs-12 width-100-pc">VAT Period End Date:&nbsp;&nbsp;</label>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right">
                                                                    <label class="company-label text-right fs-12 width-100-pc">VAT Submission Due:&nbsp;&nbsp;</label>
                                                                </div>
                                                                <div class="inlineBlock width-100-pc text-right">
                                                                    <label class="company-label text-right fs-12 width-100-pc">VAT Reporting Frequency:&nbsp;&nbsp;</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-100-pc float-left mg-top-15"><a class="cl-444 fs-12 fw-600">Current VAT Period and Return</a></div>
                                                            <div class="width-100-pc float-left mg-top-10">
                                                                <button type="button" :disabled="processing || is_initializing" class="btn btn-secondary banking-process-amref">
                                                                    Close VAT Period
                                                                </button>
                                                                <table class="table itemized x-panel mg-top-10">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 10%;">Status</th>
                                                                            <th style="width: 10%;">Ref</th>
                                                                            <th style="width: 20%;">VAT Period</th>
                                                                            <th style="width: 10%;">Submitted</th>
                                                                            <th style="width: 15%;" class="text-right">VAT Payable</th>
                                                                            <th style="width: 15%;" class="text-right">VAT Refundable</th>
                                                                            <th style="width: 10%;" class="text-right">VAT Report</th>
                                                                            <th style="width: 10%;" class="text-right">Out of Period</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="(tax_return,index) in tax_returns" :key="'tax_returns'+index">
                                                                            <td class="padd">{{tax_return.status}}</td>
                                                                            <td class="padd">{{tax_return.reference_number}}</td>
                                                                            <td class="padd">{{tax_return.vat_period}}</td>
                                                                            <td class="padd">{{tax_return.submission_date}}</td>
                                                                            <td class="text-right padd">{{currency+' '+format_money(tax_return.vat_payable)}}</td>
                                                                            <td class="text-right padd">{{currency+' '+format_money(tax_return.vat_refundable)}}</td>
                                                                            <td class="padd text-right">
                                                                                <router-link v-if="tax_return.vat_payable>0 || tax_return.vat_refundable" :to="TAXATION.FILING+'/'+tax_return.id+'/reports'" class="fs-12 fw-600 cl-blue-link">View</router-link>
                                                                            </td>
                                                                            <td class="padd text-right"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left mg-top-15">
                                                            <div class="width-100-pc float-left mg-top-15"><a class="cl-444 fs-12 fw-600">Previous VAT Periods and Returns</a></div>
                                                            <div class="width-100-pc float-left mg-top-5">
                                                                <table class="table itemized x-panel">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 10%;">Status</th>
                                                                            <th style="width: 10%;">Ref</th>
                                                                            <th style="width: 20%;" class="text-center">VAT Period</th>
                                                                            <th style="width: 10%;" class="text-center">Submitted</th>
                                                                            <th style="width: 15%;" class="text-center">VAT Payable</th>
                                                                            <th style="width: 15%;" class="text-center">VAT Refundable</th>
                                                                            <th style="width: 10%;" class="text-right">VAT Report</th>
                                                                            <th style="width: 10%;" class="text-right">Out of Period</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else-if="page_ready && tax_returns.length===0" class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left mg-top-30">
                                                    <div class="width-100-pc float-left"><a class="fw-600 cl-444 fs-13 txt-uppercase">VAT Returns and Reports</a></div>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-15">
                                                    <small class="fs-12 fw-600">View your VAT reports and manage your VAT returns</small><br>
                                                    <form @submit.prevent="fileReturn(0)" class="width-100-pc float-left mg-top-30 mg-bottom-30">
                                                        <div v-bind:class="{'width-33-pc wiz-item-ctm float-left':true,'active':wizards.tab===0}">
                                                            <div v-bind:class="{'float-left wizard-circle-amref text-center':true}">1</div>
                                                            <small class="fs-12 mg-left-5 padding-top-10">Overview</small>
                                                        </div>
                                                        <div v-bind:class="{'width-33-pc wiz-item-ctm float-left':true,'active':wizards.tab===1}">
                                                            <div v-bind:class="{'float-left wizard-circle-amref text-center':true}">2</div>
                                                            <small class="fs-12 mg-left-5 padding-top-10">VAT Period and Submission Date</small>
                                                        </div>
                                                        <div v-bind:class="{'width-33-pc wiz-item-ctm float-left':true,'active':wizards.tab===2}">
                                                            <div v-bind:class="{'float-left wizard-circle-amref text-center':true}">3</div>
                                                            <small class="fs-12 mg-left-5 padding-top-10">Close your Previous VAT Period</small>
                                                        </div>
                                                        <div v-if="wizards.tab===0" class="width-100-pc float-left mg-top-15 mg-bottom-30">
                                                            <small class="fs-12 fw-600">Create and manage your VAT returns, view your VAT reports and process your VAT payments and refunds</small><br>
                                                            <small class="fs-12">Accounting will manage everything there is around your VAT submissions. You will be able to view reports, 
                                                                process VAT transactions like payments or refunds and more importantly, 
                                                                close each VAT Period as you submit your return</small><br>
                                                            <small class="fs-12 fw-600">Is this the first time you are running your VAT reports from here?</small><br>
                                                            <small class="fs-12">You will need to enter your last VAT period end date as well as your last VAT submission date. This information is only required once! Thereafter, 
                                                                Accounting will take care of your VAT dates.</small>
                                                        </div>
                                                        <div v-else-if="wizards.tab===1" class="width-100-pc float-left mg-top-15 mg-bottom-20">
                                                            <div class="width-100-pc float-left">
                                                                <div class="width-100-pc float-left">
                                                                    <small class="fs-12 fw-600">Please provide the following VAT information:</small><br>
                                                                </div>
                                                                <div class="width-40-pc float-left">
                                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                                        <div class="inlineBlock width-50-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Select your VAT Number:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="inlineBlock width-50-pc">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <vue-single-select
                                                                                    name="maybe"
                                                                                    placeholder=""
                                                                                    you-want-to-select-a-post="ok"
                                                                                    v-model="vat_pin"
                                                                                    out-of-all-these-posts="makes sense"
                                                                                    :options="vat_pins"
                                                                                    a-post-has-an-id="good"
                                                                                    the-post-has-a-title="make"
                                                                                    option-label="registration_number"
                                                                                ></vue-single-select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                                        <div class="inlineBlock width-50-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Last VAT Period End Date:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="inlineBlock width-50-pc">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <datetime 
                                                                                    v-model="tax_form.last_period_end_date"
                                                                                    :input-id="'date_input_'"
                                                                                    placeholder="select date"
                                                                                    use12-hour
                                                                                    :type="'date'"
                                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                    :value="tax_form.last_period_end_date"
                                                                                    >
                                                                                </datetime>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                                        <div class="inlineBlock width-50-pc text-right">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Last VAT Submission Due Date:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="inlineBlock width-50-pc">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <datetime 
                                                                                    v-model="tax_form.last_submission_due_date"
                                                                                    :input-id="'date_input_dd'"
                                                                                    placeholder="select date"
                                                                                    use12-hour
                                                                                    :type="'date'"
                                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                    :value="tax_form.last_submission_due_date"
                                                                                    >
                                                                                </datetime>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="width-100-pc float-left mg-top-10">
                                                                <small class="fs-12">Each VAT period requires a submission and typically ends on the last day of the
                                                                 month with the submission typically due on the 25th of the following month.
                                                                  Enter your last <strong>VAT Period End Date</strong> and your last <strong>VAT Submission Due Date.</strong>
                                                                  We will use these dates to determine your next VAT Period End Date and when 
                                                                  your next VAT return is due.</small><br>
                                                                <small class="fs-12"><strong>Submitting VAT for the first time?</strong> If this is the first time you are 
                                                                    preparing to submit a VAT return, set your VAT Period End Date to the last day of the 
                                                                    month preceding your first VAT Period and your VAT Submission Due Date to the 25th or 
                                                                    end of the following month.</small><br>
                                                                <small class="fs-12"><strong>For example:</strong> If your first VAT Period is March and April, set your
                                                                    Last VAT Period End Date to 28 February and your Last VAT Submission Due Date to 25 
                                                                    March. Any additional references to your previous VAT period and VAT submission dates
                                                                    in this wizard can be ignored.</small><br>
                                                            </div>
                                                        </div>
                                                        <div v-else class="width-100-pc float-left mg-top-15 mg-bottom-30">
                                                            <div class="fs-12 alert alert-success"><strong>Congratulations!</strong> - you are one step away!</div>
                                                            <small class="fs-12 fw-600">Summary:</small><br>
                                                            <small class="fs-12">Your previous VAT period ended on <strong>{{vat_period_summary.last_period_end_date}}</strong> and based on your reporting frequency, your next VAT period will end on <strong>{{vat_period_summary.next_period_end_date}}</strong>.</small><br>
                                                            <small class="fs-12">Your previous VAT submission was due on <strong>{{vat_period_summary.last_submission_due_date}}</strong> Your next VAT submission will be due on <strong>{{vat_period_summary.next_submission_due_date}}</strong>.</small><br>
                                                            <small class="fs-12 fw-600">What does this mean?</small><br>
                                                            <small class="fs-12">You will not be able to edit these transactions.</small><br>
                                                            <small class="fs-12">If you back date any transactions into a VAT Period for which a VAT 
                                                                return has been submitted, these transactions will be included in your next VAT return. 
                                                                Note: Your financial reports will still display any transactions in the correct financial 
                                                                period, but for VAT purposes they will be included in the next VAT return.</small><br>
                                                            <small class="fs-12">Any transactions that you process from now on will form part of your next VAT submission.</small><br>
                                                        </div>
                                                        <div class="width-100-pc float-left text-center">
                                                            <button v-if="wizards.tab>0" type="button" :disabled="is_initializing" @click="setWiz(wizards.tab-1,true)" class="btn btn-secondary banking-process">Previous</button>
                                                            <button v-if="wizards.tab<2" type="button" :disabled="is_initializing" @click="setWiz(wizards.tab+1)" class="btn btn-secondary banking-process-amref">
                                                                <span v-if="is_initializing"><i class="fa fa-spinner fa-spin"></i> Wait...</span>
                                                                <span v-else>Next</span>
                                                            </button>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <copy-right></copy-right>
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
    import {ACCOUNTS_TAXATIONS,ACCOUNTS_TAX_RETURNS} from '../../../../../router/api_routes';
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

                wizards: {
                    tab: 0,
                },
                tax_returns: [],
                vat_pin: {},
                vat_pins: [],
                tax_form: {
                    frequency: 1,
                    vat_pin: null,
                    last_period_end_date: null,
                    last_submission_due_date: null,
                },
                currency: ACCOUNTING.CURRENCY,
                filters: {},
                vat_period_summary: null,
                TAXATION: ACCOUNTING_WEB_ROUTES.TAXATION,
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            setWiz(wiz_tab,back_action=false){
                if(this.wizards.tab===1){
                    if(back_action){
                        this.wizards.tab = wiz_tab;
                    }else{
                        this.fileReturn(wiz_tab);
                    }
                }else{
                    this.wizards.tab = wiz_tab;
                }
            },

            fileReturn(wiz_tab = 0){
                this.is_initializing = true;
                let api_ = ACCOUNTS_TAX_RETURNS;
                if(wiz_tab>0){ api_ = ACCOUNTS_TAX_RETURNS+'?return_opening=Ok';}
                if(this.vat_pin){ this.tax_form.vat_pin = this.vat_pin.registration_number; }
                post(api_,this.tax_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        if(wiz_tab>0){
                            this.$awn.success(res.data.description);
                            this.vat_period_summary = res.data.results;
                            console.info(this.vat_period_summary);
                            this.wizards.tab = wiz_tab;
                        }else{
                            this.$awn.success(res.data.description);
                            this.loadReturns();
                        }
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
                        this.page_ready  = true;
                        this.is_initializing = false;
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

            loadVATPins(){
                this.is_initializing = true;
                get(ACCOUNTS_TAXATIONS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.vat_pins = res.data.results.data;
                        console.info(this.vat_pins);
                        this.loadReturns();
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