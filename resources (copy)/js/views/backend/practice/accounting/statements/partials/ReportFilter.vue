<template>
    <div v-if="is_ready" class="width-100-pc float-left">
        <div class="width-100-pc float-left">
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right cl-444 fs-12 width-100-pc fw-600">Customers to run statements:&nbsp;&nbsp;</label>
                </div>
            </div>
            <div v-else class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right cl-444 fs-12 width-100-pc fw-600">Report Filter:&nbsp;&nbsp;</label>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">From Account:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder="(Select Account)"
                            you-want-to-select-a-post="ok"
                            v-model="chart_of_account1"
                            out-of-all-these-posts="makes sense"
                            :options="chart_of_accounts"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">To Account:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder="(Select Account)"
                            you-want-to-select-a-post="ok"
                            v-model="chart_of_account2"
                            out-of-all-these-posts="makes sense"
                            :options="chart_of_accounts"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Active:&nbsp;&nbsp;</label>
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
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">From Category:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder="(Select Category)"
                            you-want-to-select-a-post="ok"
                            v-model="category1"
                            out-of-all-these-posts="makes sense"
                            :options="categories"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">To Category:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder="(Select Category)"
                            you-want-to-select-a-post="ok"
                            v-model="category2"
                            out-of-all-these-posts="makes sense"
                            :options="categories"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="name"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <!-- ----------------------------------------------------- -->
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right cl-444 fs-12 width-100-pc fw-600">Customers to run statements:&nbsp;&nbsp;</label>
                </div>
            </div>
            <div v-else class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right cl-444 fs-12 width-100-pc fw-600">Report Options:&nbsp;&nbsp;</label>
                </div>
            </div>
            <!-- ----------------------------------------------------- -->
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN || report_options.report_name===CUSTOMER_REPORTS.SALES_BY_CUST || report_options.report_name===CUSTOMER_REPORTS.MAIL_SENT" class="row fullName mg-bottom-5 mg-left-30">
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
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.UNLOC_RCPT" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Include:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.incl_credit_notes_and_ajustment"> Credit Notes, Adjustments, Write-offs&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.CUST_TRX" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Transaction Type:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.trx_type">
                            <option value="">--select--</option>
                            <option v-for="(item,key) in CUSTOMER_TRX" :value="item" :key="''+key">{{item}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.CUST_QUOT || report_options.report_name===CUSTOMER_REPORTS.CUST_SORDER || report_options.report_name===CUSTOMER_REPORTS.CUST_INV" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Document status:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.document_status">
                            <option value="">--status--</option>
                            <option v-for="(item,key) in PROCESS_STATUS" :value="item" :key="'key_'+key">{{item}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.SALES_BY_CUST || report_options.report_name===CUSTOMER_REPORTS.CUST_INV" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Include:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.include_credit_note"> Credit Notes.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.OUTST_BALANCE" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Exclude:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.zero_balance_supplier"> Customers with Zero Balances (invoices not allocated)&nbsp;
                </div>
            </div>

            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Show Balance Brought Forward:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Consolidate all unallocated transactions prior to the statement date range into one balance brought forward.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Exclude Fully Allocated Invoices:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Choose this option to display unpaid transactions only.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Exclude Fully Allocated Invoices:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Choose this option to display unpaid transactions only.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc fw-600">Exclude customers where balances are:</label>
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Zero:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward" value="VAT Adjustments"> Select this option to exclude supplier that have a zero balance.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Negative:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.balance_brought_forward"> Select this option to exclude supplier that have a zero balance.&nbsp;
                </div>
            </div>
            <div v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN" class="row fullName mg-bottom-5 mg-left-30">
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
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.style">
                            <option value="Detailed">Detailed</option>
                            <option value="Summary">Summary</option>
                        </select>
                    </div>
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
            <button v-if="!refresh" @click="refreshReports()" :disabled="is_initializing" type="button" class="btn btn-secondary banking-process-amref">
                <span v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN">View Statement</span>
                <span v-else>View Report</span>
            </button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">
                <span v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN">Print Statement</span>
                <span v-else>Print Report</span>
            </button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">
                <span v-if="report_options.report_name===CUSTOMER_REPORTS.STATEMENT_RUN">Email Statement</span>
                <span v-else>Email Report</span>
            </button>
        </div>
    </div>
</template>
<script>
import {ACCOUNTS_TAX_RETURNS} from "../../../../../../router/api_routes";
import {TRANSACTION_TYPES,PROCESS_STATUS} from "../../../../../../helpers/process_status";
export default {
    props: ['refresh','report_options','customers','categories','chart_of_accounts','is_initializing'],
    data(){
        return {
            customer2: null,
            category1: null,
            category2: null,
            customer1: null,
            chart_of_account1: null,
            chart_of_account2: null,
            is_ready: false,
            CUSTOMER_REPORTS: TRANSACTION_TYPES.CUSTOMER_REPORTS,
            CUSTOMER_TRX: TRANSACTION_TYPES.CUSTOMER_TRX,
            PROCESS_STATUS: PROCESS_STATUS,
        }
    },
    methods: {
        refreshReports(){

        }
    },
    mounted(){
        this.is_ready = true;
    }
}
</script>