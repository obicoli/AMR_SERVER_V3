<template>

    <div>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar v-if="page_ready" :reports="inventory_reports"></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">
                            
                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">
                                
                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8 col-lg-8 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <div class="width-40-pc float-left">
                                                        <div class="btn-group" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Category ({{pagination.total}})
                                                                </a>
                                                                <!-- <div v-if="categories.length" class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a v-for="(category,index) in categories" class="dropdown-item pointer-cursor" :key="'categories'+index">{{category.name}}</a>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="width-100-pc float-left bg-white mg-top-20 mg-bottom-30">
                                                    <div class="width-100-pc float-left padding-15">
                                                        <div class="width-30-pc float-left mg-top-20">
                                                            <table class="table overview-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Contact Name:</td>
                                                                        <td class="fw-600 text-right">trtrtr</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Name:</td>
                                                                        <td class="fw-600 text-right">rtrtrt</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Email:</td>
                                                                        <td class="fw-600 text-right">ff</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Telephone:</td>
                                                                        <td class="fw-600 text-right">ff</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:20%" class="text-right">Mobile:</td>
                                                                        <td class="fw-600 text-right">dd</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-30-pc float-right mg-top-20">
                                                            <h3 class="fs-16 fw-600 cl-yellowish width-100-pc text-right">Balance: {{currency+''+format_money(0)}}</h3>
                                                            <table class="table overview-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width:50%" class="text-right">Amount Outstanding:</td>
                                                                        <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
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
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 col-lg-12 padding-right-0 border-bottom">
                                                <product-qv></product-qv>
                                                <!-- <product-modal v-if="page_ready" @editedSuccessful="loadItems(true)" :user_mode="'Edit'" :inventories="inventories" :title="'Inventory Item'" :products_attributes="products_attributes"></product-modal> -->
                                                <general-import-modal v-if="page_ready" @imported="loadItems(true)" :title="'Import Items'" :modal_id="'import_items_modal_id'" :modal_min_width="1000" :sample_file="'invetory_items'" :upload_type="'Inventory Items'"></general-import-modal>
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
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../partials/CopyRight';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import ProductModal from '../../partials/modals/product/ProductModal';
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import ProductQv from "../../partials/modals/inventory/ProductQv";

    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES,REPORT_SECTIONS} from "../../../../../helpers/process_status";
    import {PRODUCT_CATEGORIES_URL,REPORTING,PRODUCT_ITEMS_URL,PRODUCT_TAX_URL,CHART_OF_ACCOUNTS, CUSTOMERS_API,CUSTOMERS_TERMS_API,CUSTOMERS_ESTIMATES_API, BANKING_ACCOUNTS_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,
        ProductModal,GeneralImportModal,ProductQv},
        data(){
            return {
                
                
                //msg: 'Loading. Please wait...',
                //progress_overlay: 'hide',
                
                //bill: {},
                
                //suppliers: [],
                //facilities: [],
                
                // accounts: [],
                //inventories: [],
                
                
                selected_salesorders: [],
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                PROCESS_STATUS: PROCESS_STATUS,
                
                customers: [],
                taxations: [],
                bank_accounts: [],
                payment_terms: [],
                inventory_reports: [],
                
                QUOTE_URL: INVENTORY_WEB_ROUTES.SALES.QUOTE,
                SALES_ORDER_URL: INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS,
                INVOICES_URL: INVENTORY_WEB_ROUTES.SALES.INVOICES,
                salesorders: [],

                bank_accounts: [],
                inventories: [],
                default_filter: 'All',
                default_api: PRODUCT_ITEMS_URL+'?page=1',
                PRODUCT_CATEGORIES_URL:PRODUCT_CATEGORIES_URL,
                categories: [],
                selected_inventories: [],
                products_attributes: null,
                page_ready: false,
                is_initializing: false,
                processing: false,
                filters: {},

                REPORT_URL:  INVENTORY_WEB_ROUTES.INVENTORIES.REPORT
            }
        },
        watch: {
            default_api: function(){
                this.loadEstimates(true);
            }
        },
        methods: {

            check_all(event){
                this.selected_salesorders = [];
                if(event.target.checked){
                    for (let index = 0; index < this.salesorders.length; index++) {
                        const element = this.salesorders[index];
                        this.selected_salesorders.push(element.id);
                    }
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            filterItems(filter_by='All'){
                switch (filter_by) {
                    case PROCESS_STATUS.CANCELLED:
                    case PROCESS_STATUS.CLOSED:
                    case PROCESS_STATUS.PARTIAL_BILLED:
                    case PROCESS_STATUS.BILLED:
                    case PROCESS_STATUS.OPEN:
                    case PROCESS_STATUS.DRAFT:
                    case PROCESS_STATUS.PENDING_APPROVAL:
                    case PROCESS_STATUS.APPROVED:
                    case PROCESS_STATUS.PAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.VOID:
                    case PROCESS_STATUS.OVERDUE:
                    case PROCESS_STATUS.PARTIAL_PAID:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page;
                        break;
                }
            },

            loadCategories(){
                get(PRODUCT_CATEGORIES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.categories = res.data.results.data;
                        this.loadReports();
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
                });
            },

            loadItems(show_progress=false){
                this.is_initializing = show_progress;
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.inventories = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        console.info(this.inventories);
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                });
            },

            loadReports(){
                get(REPORTING+'?section='+REPORT_SECTIONS.INVENTORY)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.inventory_reports = res.data.results.data;
                        this.loadItems();
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
                });
            },

        },

        mounted() {
            this.is_initializing = true;
            this.loadCategories();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>