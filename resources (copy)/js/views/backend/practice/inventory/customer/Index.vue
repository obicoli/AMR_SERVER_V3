<template>

    <div>

        <!-- <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay> -->

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
                                                    <div class="width-40-pc float-left"><a class="fw-600 cl-444 fs-20">List of Customers</a></div>
                                                </div>

                                                <div class="width-100-pc float-left mg-top-30">

                                                    <div class="width-45-pc float-left mg-right-15">
                                                        <div class="width-60-pc float-left">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input placeholder="Search customer" :disabled="is_initializing || processing" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="width-25-pc float-right">
                                                        <div class="btn-group float-right" role="group">
                                                            <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Add Customer
                                                            </button>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                <a data-toggle="modal" data-target="#new_customer_modal_001" class="dropdown-item pointer-cursor">Add Customer</a>
                                                                <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor">Import Customers</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="width-100-pc float-left mg-top-10">
                                                        <table class="table banking-transaction table-hover mg-bottom-20">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:2%;">
                                                                        <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                    </th>
                                                                    <th style="width:15%;">Name</th>
                                                                    <th style="width:27%;">Contact name</th>
                                                                    <th style="width:12%;">Telephone</th>
                                                                    <th style="width:12%;">Mobile</th>
                                                                    <th style="width:5%;" class="text-center">Active</th>
                                                                    <th style="width:17%;" class="text-right">Balance({{currency}})</th>
                                                                    <th style="width:10%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="is_initializing">
                                                                <tr>
                                                                    <td class="somepad text-center" colspan="9">
                                                                        <img src="/assets/icons/dashboard/loader.gif">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr v-for="(customer,index) in customers" :key="'customers'+index">
                                                                    <td class="somepad">
                                                                        <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor">
                                                                    </td>
                                                                    <td class="somepad">{{customer.display_as}}</td>
                                                                    <td class="somepad">{{customer.legal_name}}</td>
                                                                    <td class="somepad">
                                                                        {{customer.phone}}
                                                                    </td>
                                                                    <td class="somepad">{{customer.mobile}}</td>
                                                                    <td class="somepad text-center">
                                                                        <input disabled type="checkbox" v-model="customer.status" class="pointer-cursor">
                                                                    </td>
                                                                    <td class="somepad text-right">{{format_money(customer.balance)}}</td>
                                                                    <td class="somepad">
                                                                        <div class="btn-group float-right" role="group">
                                                                            <a :id="'btnGroupDrop222_'+index" class="dropdown-toggle fs-12 fw-600 cl-blue-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                Actions
                                                                            </a>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop222_'+index">
                                                                                <router-link :to="CUSTOMERS+'/'+customer.id+'/QuickView'" class="dropdown-item pointer-cursor fs-12">Quick View</router-link>
                                                                                <a class="dropdown-item separator"></a>
                                                                                <a data-toggle="modal" :data-target="'#edit_supplier_modal_001_'+index" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-edit"></i> Edit</a>
                                                                                <a v-if="customer.status" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-ban cl-amref"></i> Make Inactive</a>
                                                                                <a v-else class="dropdown-item pointer-cursor fs-12"><i class="fa fa-check cl-success-light"></i>Make Active</a>
                                                                                <a data-toggle="modal" :data-target="'#delete_supplier_'+index" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-trash-o"></i> Delete</a>
                                                                                <a class="dropdown-item separator"></a>
                                                                                <a class="dropdown-item pointer-cursor fs-12">Add Invoice</a>
                                                                                <a class="dropdown-item pointer-cursor fs-12">Add Quote</a>
                                                                                <a class="dropdown-item pointer-cursor fs-12"> Add Sales Order</a>
                                                                                <a class="dropdown-item pointer-cursor fs-12"> Add Receipt</a>
                                                                                <a class="dropdown-item separator"></a>
                                                                                <a class="dropdown-item pointer-cursor fs-12"> View Statement</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr v-if="!customers.length">
                                                                    <td colspan="8" class="somepad cl-amref text-center">No data to display</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class=" width-100-pc mg-bottom-10 float-left text-center">
                                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadCustomers()" :custom="true"></paginate-template>
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
                    <customer-modal v-if="page_ready" :currency="currency" :vats="taxations" :customer_terms="customer_terms" :filters="filters" :customer_api="CUSTOMERS_API" @customer-created-event="loadCustomers(false)" :countries="countries" :title="'New Customer'" :user_mode="'Create'" :modal_id="'new_customer_modal_001'"></customer-modal>
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
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {removeElement,paginator,formatMoney,format_lunox_date, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS,ACCOUNTING} from "../../../../../helpers/process_status";
    import {CUSTOMERS_API,PRODUCT_TAX_URL,COUNTRIES_URL, CUSTOMERS_TERMS_API} from '../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';

    import CustomerModal from "../../partials/modals/customer/CustomerModal";

    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,
        SideBar,CopyRight,CustomerModal,
        ProcessingOverlay
        },
        data(){
            return {
                customers: [],
                page_ready: false,
                is_initializing: false,
                processing: false,
                currency: ACCOUNTING.CURRENCY,
                taxations: [],
                customer_terms: [],
                filters: {},
                CUSTOMERS_API: CUSTOMERS_API,
                countries: [],
                pagination: paginator(),
                CUSTOMERS: INVENTORY_WEB_ROUTES.SALES.CUSTOMERS
            }
        },
        watch: {
        },
        methods: {
            check_all(event){
            },
            format_money(money_to){
                return formatMoney(money_to);
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },
            loadCountry(){
               this.is_initializing = true;
                get(COUNTRIES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.countries = res.data.results;
                        this.loadVAT();
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
            loadVAT(){
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results.data;
                        this.loadTerms();
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
                get(CUSTOMERS_API+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customers = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        //console.info(res.data.results);
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
            loadTerms(){
                get(CUSTOMERS_TERMS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customer_terms = res.data.results.data;
                        this.loadCustomers();
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
        },
        mounted() {
            this.loadCountry();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>