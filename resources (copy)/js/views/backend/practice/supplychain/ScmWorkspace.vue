<template>

    <div>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-white content-calculated-height-wc">

                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">
                                
                                <div class="page-content bg-white padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a v-if="page_loaded" class="fw-600 cl-444 fs-3 txt-uppercase">{{user_account.data.facility.name}} Workspace</a>
                                                    <div class="width-60-pc float-right text-right fs-12">
                                                    </div>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-20">

                                                    <div class="width-100-pc float-left">

                                                        <div class="width-100-pc float-left padding-top-20 padding-bottom-20">
                                                            <router-link :to="INVENTORY_WEB_ROUTES.DASHBOARD_HOME" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--dashboard"></div>
                                                                <h6 class="canvasoption__title">Dashboard</h6>
                                                                <div class="canvasoption__descr">
                                                                    An overview of how your business is performing.
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="QUOTE" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--quote"></div>
                                                                <h6 class="canvasoption__title">Create a Quote</h6>
                                                                <div class="canvasoption__descr">
                                                                    Send a quotation to your customer.
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="CUSTOMER_INVOICES" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--taxinvoice"></div>
                                                                <h6 class="canvasoption__title">Create an Invoice</h6>
                                                                <div class="canvasoption__descr">
                                                                    Sell items or services to your customer.
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="PAYMENT_RECEIVED" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--receipt"></div>
                                                                <h6 class="canvasoption__title">Payment Received</h6>
                                                                <div class="canvasoption__descr">
                                                                    Receive Money from your Customer
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="CREDIT_NOTES" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--customerreturn"></div>
                                                                <h6 class="canvasoption__title">Create a Credit Note</h6>
                                                                <div class="canvasoption__descr">
                                                                    Credit your customer for goods returned.
                                                                </div>
                                                            </router-link>

                                                            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--supplierinvoice"></div>
                                                                <h6 class="canvasoption__title">Create a Bill</h6>
                                                                <div class="canvasoption__descr">
                                                                    Purchase items from a supplier.
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--payment"></div>
                                                                <h6 class="canvasoption__title">Supplier Payment</h6>
                                                                <div class="canvasoption__descr">
                                                                    Pay your Supplier
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="BANK_TRANSACTIONS+'?type=Banking | Bank Statement'" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--bankstatement"></div>
                                                                <h6 class="canvasoption__title">Import Bank Statement</h6>
                                                                <div class="canvasoption__descr">
                                                                    Import and view bank statement transactions.
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="EXPENSES" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--banktransaction_payment"></div>
                                                                <h6 class="canvasoption__title">Record Expense</h6>
                                                                <div class="canvasoption__descr">
                                                                    Manually capture expenses into your bank.
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="BANK_TRANSACTIONS+'?type=Banking | Bank Transactions'" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--banktransaction"></div>
                                                                <h6 class="canvasoption__title">View Bank Transactions</h6>
                                                                <div class="canvasoption__descr">
                                                                    View payments, receipts and bank transfers.
                                                                </div>
                                                            </router-link>

                                                            <router-link :to="REPORT_WEB_URL+'?type='+CUSTOMER_REPORTS.STATEMENT_RUN" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--customerstatement"></div>
                                                                <h6 class="canvasoption__title">Customer Statement</h6>
                                                                <div class="canvasoption__descr">
                                                                    Email (or print) statements to all your customers.
                                                                </div>
                                                            </router-link>

                                                            <router-link :to="PL" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--profitandloss"></div>
                                                                <h6 class="canvasoption__title">Profit and Loss</h6>
                                                                <div class="canvasoption__descr">
                                                                    View your Profit and Loss report.
                                                                </div>
                                                            </router-link>
                                                            
                                                            <router-link :to="BALANCE_SHEET" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--balanceSheet"></div>
                                                                <h6 class="canvasoption__title">Balance Sheet</h6>
                                                                <div class="canvasoption__descr">
                                                                    Balance Sheet Report
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="ACCOUNTING_WEB_ROUTES.TAXATION.FILING" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--taxreturn"></div>
                                                                <h6 class="canvasoption__title">Prepare VAT Returns</h6>
                                                                <div class="canvasoption__descr">
                                                                    VAT returns and VAT reporting.
                                                                </div>
                                                            </router-link>
                                                            <router-link :to="REPORT_CONFIG_WEB_ROUTES.CONFIG" tag="div" class="float-left width-200-pxs text-center">
                                                                <div class="canvasoption__icon canvasoption__icon--companysettings"></div>
                                                                <h6 class="canvasoption__title">Company Settings</h6>
                                                                <div class="canvasoption__descr">
                                                                    Manage branding, financial years, VAT and so on.
                                                                </div>
                                                            </router-link>

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 col-lg-12 padding-right-0 border-bottom">
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
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import CopyRight from "../partials/CopyRight";
    import Auth from "../../../../store/auth";
    import {TRANSACTION_TYPES} from "../../../../helpers/process_status";
    import {REPORT_CONFIG_WEB_ROUTES,BANKS_WEB_ROUTES,INVENTORY_WEB_ROUTES,ACCOUNTING_WEB_ROUTES} from "../../../../router/web_routes";
    export default {
        name: "ScmWorkspace",
        components: {TopNavBar,SideBar,CopyRight},
        data(){
            return {
                page_loaded: false,
                user_account: {},
                REPORT_CONFIG_WEB_ROUTES: REPORT_CONFIG_WEB_ROUTES,
                BANK_TRANSACTIONS: BANKS_WEB_ROUTES.TRANSACTIONS,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                ACCOUNTING_WEB_ROUTES:ACCOUNTING_WEB_ROUTES,
                REPORT_WEB_URL: INVENTORY_WEB_ROUTES.SALES.REPORTS,
                CUSTOMER_REPORTS: TRANSACTION_TYPES.CUSTOMER_REPORTS,
                QUOTE: INVENTORY_WEB_ROUTES.SALES.QUOTE,
                CUSTOMER_INVOICES: INVENTORY_WEB_ROUTES.SALES.INVOICES,
                SALES_RECEIPTS: INVENTORY_WEB_ROUTES.SALES.SALES_RECEIPTS,
                CREDIT_NOTES: INVENTORY_WEB_ROUTES.SALES.CREDIT_NOTES,
                PAYMENT_RECEIVED: INVENTORY_WEB_ROUTES.SALES.PAYMENTS,
                EXPENSES: INVENTORY_WEB_ROUTES.PURCHASES.EXPENSES,
                TRAIL_BALANCE: ACCOUNTING_WEB_ROUTES.STATEMENTS.TRAIL_BALANCE,
                BALANCE_SHEET: ACCOUNTING_WEB_ROUTES.STATEMENTS.BALANCE_SHEET,
                PL: ACCOUNTING_WEB_ROUTES.STATEMENTS.PL,
            }
        },
        methods: {
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },
        mounted() {
            this.user_account = Auth.getCurrentAccount('account');
            this.page_loaded = true;
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>