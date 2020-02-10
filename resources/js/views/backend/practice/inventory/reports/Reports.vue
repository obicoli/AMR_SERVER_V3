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
                            <report-config v-if="page_ready" :reports="true" :scrollable="true" :width="true" :transparent="true" :active_num="'reports'" :title="'Report & Config'"></report-config>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-white content-calculated-height-wc">

                            <div class="settings-header shadowed main-heading bg-white min-height-68 bottom-border top-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group" role="group">
                                            <a class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase">
                                                Reports
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-68">
                                
                                <div class="page-content bg-white padding-0 mg-right-0 mg-left-0">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        
                                        <div class="row">

                                            <div class="col-md-3 col-lg-3 bg-white border-bottom mg-top-30">
                                                <ul class="reports-lista">
                                                    <li class="title">Business Overview</li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Audit Log</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Profit and Loss</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Cash Flow Statement</a></li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Balance Sheet</a> </li>
                                                </ul>
                                            </div>

                                            <div class="col-md-3 col-lg-3 bg-white border-bottom mg-top-30">
                                                <ul class="reports-lista">
                                                    <li class="title">Inventory</li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Inventory Valuation Detail</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Inventory Valuation Summary</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Stock Take Worksheet</a></li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Product Sales Report</a></li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Stock Take Worksheet</a></li>
                                                </ul>
                                            </div>

                                            <div class="col-md-3 col-lg-3 bg-white border-bottom mg-top-30">
                                                <ul class="reports-lista">
                                                    <li class="title">Sales</li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Estimate by Customer</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Income by Customer Summary</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Sales by Customer Detail</a></li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Sales by Customer Summary</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Sales by Customer Summary</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Transaction List by Customer</a> </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-3 col-lg-3 bg-white border-bottom mg-top-30">
                                                <ul class="reports-lista">
                                                    <li class="title">Receivables</li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Customer Balances</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Aging Summary</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Aging Detail</a></li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Invoice Details</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Retainer Invoice Details</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Sales Order Details</a> </li>
                                                    <li> <a class="cl-blue-link pointer-cursor">Estimate Details</a> </li>
                                                </ul>
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
    // import SideBarSupplier from "../../partials/sidebars/SideBarSupplier";
    // import SideBarInvSettings from "../../partials/sidebars/SideBarInvSettings";
    //import SideBarInventory from "../../partials/sidebars/inventory/SideBarInventory";
    import ReportConfig from "../../partials/sidebars/supplychain/ReportConfig";
    // import SupplierModal from "../../partials/modals/vendors/SupplierModal";
    // import ImportSupplierModal from "../../partials/modals/vendors/ImportSupplierModal";
    // import EditUserModal from "../../partials/modals/users/EditUserModal";
    // import CommonLinks from "../../partials/sidebars/CommonLinks";
    // import ConfirmModal from '../../partials/modals/ConfirmModal';
    //import SupplierHeader from './partials/SupplierHeader';
    // import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    // import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    // import PoModal from "../../partials/modals/purchase/PoModal";
    // import InviteModal from "../../partials/modals/InviteModal";
    // import MasterModal from "../../partials/modals/MasterModal";
    // import DeleteModal from "../../partials/modals/DeleteModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    // import DeleteStuffModal from "../../pharmacy/patials/DeleteStuffModal";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator,formatMoney} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS} from "../../../../../helpers/process_status";
    import {COUNTRIES_URL,SUPPLIER_URL,ACCOUNTS_INITIALS,SUPPLIER_COMPANIES_URL,SUPPLIER_PO_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,
        ProcessingOverlay,ReportConfig},
        data(){
            return {
                //current_facility: {},
                PROCESS_STATUS: PROCESS_STATUS,
                initializations: {},
                accountings: {},
                suppliers: [],
                countries: [],
                companies: [],
                facilities: [],
                customers: [],
                purchase_orders: [],
                selected_pos: [],
                msg: 'Loading. Please wait...',
                //current_role_name: null,
                progress_overlay: 'hide',
                page_ready: false,
                pagination: paginator(),
                SUPPLIER_URL: SUPPLIER_URL,
            }
        },
        methods: {

            format_Money(money_to){
                return formatMoney(money_to);
            },

            check_status(array_to,pin_to){
                let result = null;
                for (let index = 0; index < array_to.length; index++) {
                    const element = array_to[index];
                    if(element.status === pin_to){
                        result = element.date;
                        break;
                    }
                }
                return result;
            },

            check_all(event){
                this.selected_pos = [];
                if(event.target.checked){
                    for (let index = 0; index < this.purchase_orders.length; index++) {
                        const element = this.purchase_orders[index];
                        this.selected_pos.push(element.id);
                    }
                }else{
                    this.selected_pos = [];
                }
            },

            reload_suppliers(supplier){
                this.suppliers.concat(supplier);
            },

            loadPo(){
              this.progress_overlay = "show";
                get(SUPPLIER_PO_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.purchase_orders = res.data.results.data;
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

            // loadCountry(){
            //   this.progress_overlay = "show";
            //     get(COUNTRIES_URL)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.countries = res.data.results;
            //             this.loadAccounting();
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

            // loadSuppliers(state_load="show"){
            //     this.progress_overlay = state_load;
            //     get(this.SUPPLIER_URL+'?page='+this.pagination.current_page)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.suppliers = res.data.results.data;
            //             this.pagination = res.data.results.pagination;
            //             //console.info(this.suppliers);
            //             // this.loadSupplier();
            //             // this.progress_overlay = "hide";
            //             // this.page_ready = true;
            //             this.loadCompanies();
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
            // this.loadPo();
            this.page_ready = true;
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>