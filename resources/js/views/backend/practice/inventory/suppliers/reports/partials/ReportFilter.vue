<template>
    <div v-if="is_ready" class="width-100-pc float-left">
        <div v-if="!refresh" class="width-100-pc float-left mg-top-15">
            <div class="width-100-pc float-left mg-top-15 text-center">
                <label class="fs-14 fw-600">Report Filter</label>
            </div>
        </div>
        <div class="width-100-pc float-left">
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R3" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Run At Date:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-60-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <datetime 
                            v-model="report_options.run_at_date"
                            :input-id="'date_input_11'"
                            placeholder="select date"
                            use12-hour
                            :type="'date'"
                            :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                            :value="report_options.run_at_date"
                            >
                        </datetime>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">From supplier:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder="(From supplier)"
                            you-want-to-select-a-post="ok"
                            v-model="supplier1"
                            out-of-all-these-posts="makes sense"
                            :options="suppliers"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="legal_name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">To supplier:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder="(To supplier)"
                            you-want-to-select-a-post="ok"
                            v-model="supplier2"
                            out-of-all-these-posts="makes sense"
                            :options="suppliers"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="legal_name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Status:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            <option value="">Both</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R1 || report_options.report_name===SUPPLIER_REPORTS.R4 || report_options.report_name===SUPPLIER_REPORTS.R5 || report_options.report_name===SUPPLIER_REPORTS.R6 || report_options.report_name===SUPPLIER_REPORTS.R7 || report_options.report_name===SUPPLIER_REPORTS.R8 || report_options.report_name===SUPPLIER_REPORTS.R9" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Category:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.category">
                            <option value="Local">Local</option>
                            <option value="International">International</option>
                            <option value="">Both</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R2 || report_options.report_name===SUPPLIER_REPORTS.R4 || report_options.report_name===SUPPLIER_REPORTS.R5 || report_options.report_name===SUPPLIER_REPORTS.R6 || report_options.report_name===SUPPLIER_REPORTS.R7 || report_options.report_name===SUPPLIER_REPORTS.R8 || report_options.report_name===SUPPLIER_REPORTS.R9" class="row fullName mg-bottom-5 mg-left-30">
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
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R5" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Transaction Type:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.trx_type">
                            <option value="">--select--</option>
                            <option v-for="(key,item) in SUPPLIER_TRX" :value="key" :key="''+item">{{key}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R6" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Document status:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.document_status">
                            <option value="">--status--</option>
                            <option v-for="(key,item) in PO_STATUS" :value="key" :key="'key_'+item">{{key}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R7 || report_options.report_name===SUPPLIER_REPORTS.R2" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Include:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.incl_supplier_return"> Supplier Returns
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R8" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Include:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.incl_supplier_return_and_ajustment"> Supplier Returns and Adjustments
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="width-100-pc float-left mg-top-15 text-center">
                        <label class="fs-14 fw-600">Report Options</label>
                    </div>
                </div>
            </div>

            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R3" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Exclude:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.zero_balance_supplier"> Suppliers with Zero Balances (invoices not allocated)&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R4" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Show Balance Brought Forward:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Consolidate all unallocated transactions prior to the statement date range into one balance brought forward.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R4" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Exclude Fully Allocated Invoices:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Choose this option to display unpaid transactions only.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R4" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Exclude Fully Allocated Invoices:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Choose this option to display unpaid transactions only.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R4" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc fw-600">Exclude suppliers where balances are:</label>
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R4" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Zero:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Select this option to exclude supplier that have a zero balance.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R4" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Negative:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward"> Select this option to exclude supplier that have a zero balance.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===SUPPLIER_REPORTS.R4" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Less than:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-25-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward"> Exclude balances less than.&nbsp;
                </div>
                <div class="inlineBlock width-20-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input type="text" :disabled="is_initializing" v-model="report_options.minimun_balance">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Style:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc fs-12">
                    <input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.style" value="Summary"> Summary&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.style" value="Detailed"> Detailed
                </div>
            </div>
        </div>
        <div class="width-100-pc float-left text-center mg-top-10">
            <div v-if="is_initializing" class="width-100-pc float-left text-center">
                <img class="loader" src="/assets/icons/dashboard/loader.gif">
            </div>
        </div>
        <div class="width-100-pc float-left text-center mg-top-5">
            <button v-if="refresh" @click="refreshReports()" :disabled="is_initializing" type="button" class="btn btn-secondary banking-process-amref">Refresh</button>
            <button v-if="!refresh" @click="refreshReports()" :disabled="is_initializing" type="button" class="btn btn-secondary banking-process-amref">View Report</button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">Print Report</button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">Email Report</button>
        </div>
    </div>
</template>
<script>
import {ACCOUNTS_TAX_RETURNS} from "../../../../../../../router/api_routes";
import {TRANSACTION_TYPES,PROCESS_STATUS} from "../../../../../../../helpers/process_status";
export default {
    props: ['report_options','refresh','suppliers','is_initializing'],
    data(){
        return {
            supplier1: null,
            supplier2: null,
            SUPPLIER_TRX: TRANSACTION_TYPES.SUPPLIER,
            SUPPLIER_REPORTS: TRANSACTION_TYPES.SUPPLIER_REPORTS,
            PO_STATUS: PROCESS_STATUS,
            is_ready: false,
        }
    },
    methods: {
        refreshReports(){
            if(this.supplier2){this.report_options.supplier2_id = this.supplier2.id}
            if(this.supplier1){this.report_options.supplier1_id = this.supplier1.id}
            this.$emit("report-options-event",this.report_options);
        },
    },
    mounted(){
        this.is_ready = true;
    }
}
</script>