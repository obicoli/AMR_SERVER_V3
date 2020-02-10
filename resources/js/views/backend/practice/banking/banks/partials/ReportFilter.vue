<template>
    <div v-if="is_ready" class="width-100-pc float-left">
        <div v-if="!refresh" class="width-100-pc float-left mg-top-15">
            <div class="width-100-pc float-left mg-top-15 text-center">
                <label class="fs-16 fw-600">Report Options</label>
            </div>
        </div>
        <div class="width-100-pc float-left">
            <div v-if="report_options.report_name===BANK_REPORTS.BANK_TRANSACTIONS || report_options.report_name===BANK_REPORTS.CASH_MOVEMENT || report_options.report_name===BANK_REPORTS.CASH_FLOW || report_options.report_name===BANK_REPORTS.BANK_FEED" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Date Range:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-20-pc mg-right-5">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <select :disabled="is_initializing" v-model="report_options.date_frequency">
                            <option value="1">Monthly</option>
                            <option value="3">Quarterly</option>
                            <option value="6">Halfly</option>
                            <option value="12">Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="inlineBlock width-20-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <select :disabled="is_initializing" v-model="report_options.trans_month">
                            <option value="1">Current Month</option>
                            <option value="3">Last Month</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">From Bank Account:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder=""
                            you-want-to-select-a-post="ok"
                            v-model="start_bank"
                            out-of-all-these-posts="makes sense"
                            :options="banks"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="account_name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">To Bank Account:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder=""
                            you-want-to-select-a-post="ok"
                            v-model="end_bank"
                            out-of-all-these-posts="makes sense"
                            :options="banks"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="account_name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>

            <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <small v-if="report_options.view_by===VIEW_BY.VAT_PERIOD" class="fs-11">{{VIEW_BY.PERIOD_DESC}}</small>
                        <small v-else class="fs-11">{{VIEW_BY.DATE_DESC}}</small>
                    </div>
                </div>
            </div> -->

            <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">VAT Period:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder=""
                            you-want-to-select-a-post="ok"
                            v-model="tax_return"
                            out-of-all-these-posts="makes sense"
                            :options="tax_returns"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="reference_number"
                        ></vue-single-select>
                    </div>
                </div>
            </div> -->

            <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">VAT Period End Date:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <datetime 
                            v-model="report_options.period_end_date"
                            :input-id="'date_input_'"
                            placeholder="select date"
                            use12-hour
                            :type="'date'"
                            :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                            :value="report_options.period_end_date"
                            >
                        </datetime>
                    </div>
                </div>
            </div> -->

            <!-- <div v-if="report_options.view_by===VIEW_BY.DATE" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Date Range:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.date_range">
                            <option :value="1">1 Month</option>
                            <option :value="2">2 Months</option>
                            <option :value="3">3 Months</option>
                            <option :value="4">4 Months</option>
                            <option :value="5">5 Months</option>
                            <option :value="6">6 Months</option>
                            <option :value="12">12 Months</option>
                        </select>
                    </div>
                </div>
            </div> -->
            

            <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">VAT Type:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder=""
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
            </div> -->

            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Status:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc fs-12">
                    <input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.style" value="Summary"> Summary&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.style" value="Detailed"> Detailed
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">From Account Type:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.date_range">
                            <option disabled selected value="">--select--</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">To Account Type:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.date_range">
                            <option disabled selected value="">--select--</option>
                        </select>
                    </div>
                </div>
            </div>

            <div v-if="report_options.report_name===BANK_REPORTS.BANK_TRANSACTIONS" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Transaction Type:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.date_range">
                            <option disabled selected value="">--select--</option>
                            <option :value="OB">{{OB}}</option>
                            <option v-for="(item,key) in CUSTOMER_TRX" :value="item" :key="'cust_'+key">{{item}}</option>
                            <option v-for="(item,key) in ACCOUNT_TRX" :value="item" :key="'account_'+key">{{item}}</option>
                            <option v-for="(item,key) in SUPPLIER_TRX" :value="item" :key="'supplier_'+key">{{item}}</option>
                            <option v-for="(item,key) in TRANSFER_TRX" :value="item" :key="'transfer_'+key">{{item}}</option>
                            <option v-for="(item,key) in VAT_TRX" :value="item" :key="'vats_'+key">{{item}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Basis:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc fs-12">
                    <input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.basis" value="Cash"> Cash&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.basis" value="Accrual"> Accrual
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Include:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.includes" value="VAT Adjustments"> VAT Adjustments&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.includes" value="No VAT Transactions"> No VAT Transactions&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.includes" value="VAT Payments and Refunds Total on Summary"> VAT Payments and Refunds Total on Summary&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div> -->

        </div>
        <div class="width-100-pc float-left text-center mg-top-10">
            <div v-if="is_initializing" class="width-100-pc float-left text-center">
                <img class="loader" src="/assets/icons/dashboard/loader.gif">
            </div>
        </div>
        <div class="width-100-pc float-left text-center mg-top-5">
            <!-- <button v-if="refresh" @click="loadReports()" :disabled="is_initializing" type="button" class="btn btn-secondary banking-process-amref">Refresh</button> -->
            <button v-if="!refresh" @click="loadReports()" :disabled="is_initializing" type="button" class="btn btn-secondary banking-process-amref">View Report</button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">Print Report</button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">Email Report</button>
        </div>
    </div>
</template>
<script>
import {VAT_OPTIONS,TRANSACTION_TYPES,BANKING} from "../../../../../../helpers/process_status";
import {get} from "../../../../../../helpers/api";
import {ACCOUNTS_TAX_RETURNS} from "../../../../../../router/api_routes";
export default {
    props: ['report_opt','report_type','refresh','tax_returns','vat_types','reported_data','banks'],
    data(){
        return {
            is_initializing: false,
            vat_type:null,
            tax_return: null,
            is_ready: false,
            report_data: [],
            VIEW_BY: VAT_OPTIONS.VIEW_BY,
            report_options: null,
            end_bank: null,
            start_bank: null,
            OB: TRANSACTION_TYPES.OPENING_BALANCE,
            CUSTOMER_TRX: TRANSACTION_TYPES.CUSTOMER_TRX,
            SUPPLIER_TRX: TRANSACTION_TYPES.SUPPLIER_TRX,
            TRANSFER_TRX: TRANSACTION_TYPES.TRANSFER_TRX,
            VAT_TRX: TRANSACTION_TYPES.VAT_TRX,
            BANK_REPORTS: BANKING.REPORTS,
            ACCOUNT_TRX: TRANSACTION_TYPES.ACCOUNT_TRX
        }
    },
    methods: {
        loadReports(){
            this.$emit("report-options-event",this.report_options);
            this.is_initializing = true;
            if(this.tax_return){this.report_options.vat_return_id = this.tax_return.id;}
            if(this.vat_type){this.report_options.vat_type_id = this.vat_type.id;}
            get(ACCOUNTS_TAX_RETURNS+'/reports?filters='+JSON.stringify(this.report_options))
            .then((res) => {
                if(res.data.status_code === 200) {
                    this.reported_data.push(res.data.results);
                    console.info(res.data.results);
                    this.is_initializing = false;
                    this.$emit("report-data-event",this.reported_data);
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
    },
    mounted(){
        if(this.report_opt){
            this.report_options = this.report_opt;
            this.is_ready = true;
        }
    }
}
</script>