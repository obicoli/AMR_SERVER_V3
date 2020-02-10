<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo content-calculated-height-wc">
                            <sidebar-customer v-if="page_ready" :customer="true" :scrollable="true" :width="true" :transparent="true" :active_num="'customers'" :title="'Customers'"></sidebar-customer>
                            <!-- <side-bar-inventory v-if="page_ready" :customer="true" :scrollable="true" :width="true" :transparent="true" :active_num="'customers'" :title="'Vendors'"></side-bar-inventory> -->
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-white content-calculated-height-wc">

                            <div class="settings-header shadowed main-heading bg-white min-height-68 bottom-border top-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div v-if="selected_suppliers.length>0" class="pull pull-left mg-top-10">
                                            <div class="padding-right-10 min-height-30 width-100-pc">
                                                <a class="btn btn-default btn-inventory btn-gray" title="Send Mail"><i class="fa fa-envelope-o"></i></a>
                                                <div class="btn-group" role="group">
                                                    <a :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-default btn-inventory btn-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        More Action
                                                    </a>
                                                    <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                        <a class="dropdown-item pointer-cursor">Mark as Inactive</a>
                                                        <a class="dropdown-item pointer-cursor">Delete</a>
                                                    </div>
                                                </div>
                                                <a class="fs-14 cl-ccc">{{selected_suppliers.length}} vendor(s) selected</a>
                                            </div>
                                        </div>
                                        <div v-else class="btn-group" role="group" aria-label="Button group">
                                            <div class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    All Customers
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a class="dropdown-item txt-uppercase cl-777 fs-12">Default Filters</a>
                                                    <a class="dropdown-item pointer-cursor">All Customers</a>
                                                    <a class="dropdown-item pointer-cursor">Active</a>
                                                    <a class="dropdown-item pointer-cursor">Inactive</a>
                                                    <a class="dropdown-item pointer-cursor">Overdue Customers</a>
                                                    <a class="dropdown-item pointer-cursor">Unpaid Customers</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull pull-left mg-top-10">
                                            <div class="padding-right-10 min-height-30 width-100-pc">
                                                <a data-toggle="modal" data-target="#new_customer_modal_f" class="btn btn-default btn-inventory btn-amref cl-white">+New</a>
                                                <a class="btn btn-default btn-inventory btn-gray" title="Vendor Preferences"><i class="fa fa-cog"></i></a>
                                                <a class="btn btn-default btn-inventory btn-gray"><i class="fa fa-list"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-68">
                                

                                <div class="page-content bg-white padding-0 mg-right-0 mg-left-0">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div v-if="suppliers.length > 0" class="row">
                                            <div class="col-md-12 padding-right-0 col-lg-12 bg-white border-bottom">
                                                <table class="table table-vendor-list table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:2%;">
                                                                <input type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                            </th>
                                                            <th style="width:20%;">Name</th>
                                                            <th style="width:28%;">Company</th>
                                                            <th style="width:15%;">Email</th>
                                                            <th style="width:15%;">Work Phone</th>
                                                            <th style="width:10%;" class="text-right">Payables</th>
                                                            <th style="width:10%;">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(supplier,index) in suppliers" :key="'supplier_'+index">
                                                            <td>
                                                                <input class="pointer-cursor" type="checkbox" v-model="selected_suppliers" :value="supplier.id">
                                                            </td>
                                                            <router-link :to="'/vendors/'+supplier.id+'/overview'" tag="td" class="padded pointer-cursor cl-blue-link">
                                                                {{supplier.salutation}} {{supplier.first_name}} {{supplier.last_name}}
                                                            </router-link>
                                                            <router-link :to="'/vendors/'+supplier.id+'/overview'" tag="td" class="padded pointer-cursor">
                                                                {{supplier.company.name}}
                                                            </router-link>
                                                            <router-link :to="'/vendors/'+supplier.id+'/overview'" tag="td" class="padded pointer-cursor">
                                                                {{supplier.email}}
                                                            </router-link>
                                                            <router-link :to="'/vendors/'+supplier.id+'/overview'" tag="td" class="padded pointer-cursor">
                                                                {{supplier.phone}}
                                                            </router-link>
                                                            <router-link :to="'/vendors/'+supplier.id+'/overview'" tag="td" class="padded pointer-cursor text-right fw-600">
                                                                {{supplier.currency.currency_sympol}}{{format_Money(supplier.account.balance)}}
                                                            </router-link>
                                                            <router-link :to="'/vendors/'+supplier.id+'/overview'" tag="td" class="padded pointer-cursor">
                                                                <span v-if="supplier.status" class="fw-600 cl-success-light fs-12 txt-uppercase">Active</span>
                                                                <span v-else class="cl-amref fs-12 fw-600 txt-uppercase">Inactive</span>
                                                            </router-link>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="10" class="bg-foo">
                                                                <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadSuppliers()" :custom="true"></paginate-template>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div v-else class="row">

                                            <div class="col-md-12 col-lg-12 bg-white text-center border-bottom">
                                                <p class="fs-20">Customers.</p><br>
                                                <small class="fs-14 cl-777">Create and manage your contacts, all in one place</small><br><br>
                                                <a data-toggle="modal" data-target="#new_customer_modal_f" class="btn btn-default btn-inventory btn-amref cl-white txt-uppercase">Create New Customer</a><br><br>
                                                <ul class="custom-list">
                                                    <li class="title">In the Customer section, you can:</li>
                                                    <li>Create your customers to the Portal</li>
                                                    <li>Run customer statement report</li>
                                                    <li>Set a currency to invoice your customers</li>
                                                    <li>View transaction history for each customer</li>
                                                </ul>
                                            </div>

                                            <!-- <div class="col-md-12 col-lg-12 bg-white text-center border-bottom bg-f7 mg-top-20 padding-bottom-10">
                                                <p class="fs-20">Types of contacts.</p><br>
                                                <img src="/assets/icons/dashboard/contacts.png">
                                            </div> -->

                                        </div>
                                    </div>
                                </div>
                                <customer-modal v-if="page_ready" :vats="taxations" :customer_api="customer_api" :countries="countries" :customer_terms="customer_terms" :title="'Customer Information'" :initializations="initializations" :user_mode="'Create'" :modal_id="'new_customer_modal_f'"></customer-modal>
                                <general-import-modal v-if="page_ready" :title="'Import Suppliers'" :modal_id="'import_supplier_modal'" :modal_min_width="1000" :sample_file="'suppliers'" :upload_type="'Suppliers'"></general-import-modal>
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
    // import SideBarSupplier from "../../partials/sidebars/SideBarSupplier";
    import SideBarInvSettings from "../../partials/sidebars/SideBarInvSettings";
    import SideBarInventory from "../../partials/sidebars/inventory/SideBarInventory";
    import SidebarCustomer from "../../partials/sidebars/supplychain/SidebarCustomer";
    import CustomerModal from "../../partials/modals/customer/CustomerModal";
    // import ImportSupplierModal from "../../partials/modals/vendors/ImportSupplierModal";
    import EditUserModal from "../../partials/modals/users/EditUserModal";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import ConfirmModal from '../../partials/modals/ConfirmModal';
    import CustomerHeader from './partials/CustomerHeader';
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    // import InviteModal from "../../partials/modals/InviteModal";
    // import MasterModal from "../../partials/modals/MasterModal";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    // import DeleteStuffModal from "../../pharmacy/patials/DeleteStuffModal";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator,formatMoney} from "../../../../../helpers/functionmixin";
    import {COUNTRIES_URL,PRODUCT_TAX_URL,CUSTOMERS_API,CUSTOMERS_TERMS_API} from '../../../../../router/api_routes';
    export default {
        name: "Customers",
        components: {TopNavBar,CommonLinks,SideBar,SideBarInvSettings,CustomerHeader,
        DeleteModal,CustomerModal,GeneralImportModal,ConfirmModal,PaginateTemplate,SidebarCustomer,
        ProcessingOverlay,SideBarInventory},
        data(){
            return {
                is_initializing: false,
                current_facility: {},
                initializations: {},
                //accountings: {},
                suppliers: [],
                customers:[],
                taxations: [],
                customer_terms:[],

                countries: [],
                //companies: [],

                selected_suppliers: [],
                msg: 'Loading. Please wait...',
                current_role_name: null,
                progress_overlay: 'hide',
                page_ready: false,
                pagination: paginator(),
                customer_api: CUSTOMERS_API,
            }
        },
        methods: {

            format_Money(money_to){
                return formatMoney(money_to);
            },

            check_all(event){
                this.selected_suppliers = [];
                if(event.target.checked){
                    for (let index = 0; index < this.suppliers.length; index++) {
                        const element = this.suppliers[index];
                        this.selected_suppliers.push(element.id);
                    }
                }else{
                    this.selected_suppliers = [];
                }
            },

            // reload_suppliers(supplier){
            //     this.suppliers.concat(supplier);
            // },

            loadCountry(){
                get(COUNTRIES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.countries = res.data.results;
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
                        //console.info(this.countries);
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

            loadTerms(){
                get(CUSTOMERS_TERMS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customer_terms = res.data.results;
                        console.info(this.customer_terms);
                        this.is_initializing = false;
                        this.progress_overlay = "hide";
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
                });
            },

            // loadAccounting(){
            //     this.progress_overlay = "show";
            //     get(ACCOUNTS_INITIALS)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.accountings = res.data.results;
            //             this.loadSuppliers();
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors));
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description);
            //         }
            //     });
            // },

            loadCustomers(state_load=false){
                if(state_load){
                    this.progress_overlay = "show";
                }
                get(this.customer_api+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customers = res.data.results.data;
                        console.info(this.customers);
                        this.pagination = res.data.results.pagination;
                        if(state_load){
                            this.loadCountry();
                        }else{
                            this.progress_overlay = "hide";
                            this.page_ready = true;
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
                });
            },

            loadVAT(){
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results;
                        // this.is_initializing = false;
                        // this.processing = false;
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
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

            // loadCompanies(){
            //     this.progress_overlay = "show";
            //     get(SUPPLIER_COMPANIES_URL)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.companies = res.data.results.data;
            //             this.progress_overlay = "hide";
            //             this.page_ready = true;
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors));
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description);
            //         }
            //     });
            // },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }

        },
        mounted() {
            this.loadCustomers(true);
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>