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
                                            <div class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a class="fw-600 cl-444 fs-17">Customer Quick View</a>
                                                </div>
                                                <div class="width-30-pc float-left mg-top-20">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <vue-single-select
                                                            name="maybe"
                                                            placeholder="Customer"
                                                            you-want-to-select-a-post="ok"
                                                            v-model="customer"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="customers"
                                                            a-post-has-an-id="good"
                                                            the-post-has-a-title="make"
                                                            option-label="legal_name"
                                                        ></vue-single-select>
                                                    </div>
                                                </div>
                                                <div class="width-100-pc float-left bg-white mg-top-20 mg-bottom-30">
                                                    <div class="width-100-pc float-left padding-15">
                                                        <div class="width-30-pc float-left mg-top-20">
                                                            <table class="table overview-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Contact Name:</td>
                                                                        <td class="fw-600 text-right">{{customer.legal_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Name:</td>
                                                                        <td class="fw-600 text-right">{{customer.display_as}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Email:</td>
                                                                        <td class="fw-600 text-right">{{customer.email}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Telephone:</td>
                                                                        <td class="fw-600 text-right">{{customer.phone}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Mobile:</td>
                                                                        <td class="fw-600 text-right">{{customer.mobile}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-30-pc float-right mg-top-20">
                                                            <h3 class="fs-16 fw-600 cl-yellowish width-100-pc text-right">Balance: {{currency+''+format_money(customer.balance)}}</h3>
                                                            <table class="table overview-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:50%" class="text-right">Amount Outstanding:</td>
                                                                        <td class="text-right fw-600">{{currency+''+format_money(customer.balance)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:50%" class="text-right">Sales this year:</td>
                                                                        <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:50%" class="text-right">Total Pending Quotes:</td>
                                                                        <td class="text-right fw-600">{{format_money(0)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:50%" class="text-right">Value of Pending Quotes:</td>
                                                                        <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:50%" class="text-right">Total Expired Quotes:</td>
                                                                        <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-100-pc float-right bg-white mg-top-30">
                                                            <nav>
                                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">Overview</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Invoices</a>
                                                                    <!-- <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Purchase Orders</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Bills</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Payments</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Vendor Credits</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Journal</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Statement</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Mails</a>
                                                                    <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Comments</a> -->
                                                                </div>
                                                            </nav>
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
            </div>
            <div class="row justify-content-center">
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
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../partials/CopyRight';
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    // import Datepicker from 'vuejs-datepicker';
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../helpers/process_status";
    import {CUSTOMERS_API} from '../../../../../router/api_routes';
    export default {
        name: "SupplierView",
        components: {TopNavBar,PaginateTemplate,SideBar,CopyRight,
        ProcessingOverlay},
        data(){
            return {
                curr_tab: 0,
                customer: {},
                customers: [],
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                is_initializing: false,
                processing: false,
                pagination: paginator(),
                // bank_api: BANKING_BANKS_URL,
                // bank_accounts_api: BANKING_ACCOUNTS_URL,
                // bank_transactions_api: BANKING_TRANSACTIONS_URL,
                currency: ACCOUNTING.CURRENCY
            }
        },
        methods: {
            showCustomer(customer_id){
                get(CUSTOMERS_API+'/'+customer_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customer = res.data.results;
                        console.info(this.customer)
                        this.is_initializing = false;
                        this.processing = false;
                        this.page_ready = true;
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
            loadCustomers(progress = true){
                this.is_initializing = progress;
                get(CUSTOMERS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customers = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        //console.info(res.data.results);
                        // this.page_ready  = true;
                        // this.is_initializing = false;
                        this.showCustomer(this.$route.params.uuid);
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
            format_money(money_to){
                return formatMoney(money_to);
            }
        },

        mounted() {
            this.loadCustomers();
        }
    }
</script>

<style lang="scss">
    .search-input[data-v-27213e1d] {
        padding: 4px 6px!important;
        font-size: 12px;
        line-height: 20px!important;
        color: #444!important;
        background-color: #fff!important;
        border: 1px solid #cccccc!important;
        border-radius: 5px!important;
    }
</style>