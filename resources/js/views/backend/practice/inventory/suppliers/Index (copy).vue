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
                            <side-bar-inventory v-if="page_ready" :supplier="true" :scrollable="true" :width="true" :transparent="true" :active_num="'vendors'" :title="'Vendors'"></side-bar-inventory>
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
                                                    All Vendors
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a class="dropdown-item txt-uppercase cl-777 fs-12">Default Filters</a>
                                                    <a class="dropdown-item pointer-cursor">All Vendors</a>
                                                    <a class="dropdown-item pointer-cursor">Active</a>
                                                    <a class="dropdown-item pointer-cursor">Inactive</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull pull-left mg-top-10">
                                            <div class="padding-right-10 min-height-30 width-100-pc">
                                                <a data-toggle="modal" data-target="#new_supplier_modal" class="btn btn-default btn-inventory btn-amref cl-white">+New</a>
                                                <a class="btn btn-default btn-inventory btn-gray" title="Vendor Preferences"><i class="fa fa-cog"></i></a>
                                                <a class="btn btn-default btn-inventory btn-gray"><i class="fa fa-list"></i></a> | 
                                                <a class="fs-14 cl-blue-link"><i class="fa fa-lightbulb-o fs-15"></i> Page Tips</a>
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

                                            <div class="col-md-12 col-lg-12 bg-white text-center border-bottom mg-top-30 padding-top-30">
                                                <p class="fs-20">Business is no fun without people.</p><br>
                                                <small class="fs-14 cl-777">Create and manage your contacts, all in one place</small><br><br>
                                                <a data-toggle="modal" data-target="#new_supplier_modal" class="btn btn-default btn-inventory btn-amref cl-white txt-uppercase">Create New Vendor</a><br><br>
                                                <a data-toggle="modal" data-target="#import_supplier_modal" class="fs-14 cl-blue-link">Click here to import vendors from a file</a><br>
                                            </div>

                                            <div class="col-md-12 col-lg-12 bg-white text-center border-bottom bg-f7 mg-top-20 padding-bottom-10">
                                                <p class="fs-20">Types of contacts.</p><br>
                                                <img src="/assets/icons/dashboard/contacts.png">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <supplier-modal v-if="page_ready" v-on:supplierAdded="loadSuppliers('hide')" :companies="companies" :countries="countries" :accountings="accountings" :title="'Supplier Information'" :initializations="initializations" :user_mode="'Create'" :initial_url="SUPPLIER_URL" :modal_id="'new_supplier_modal'"></supplier-modal>
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
    import SupplierModal from "../../partials/modals/vendors/SupplierModal";
    // import ImportSupplierModal from "../../partials/modals/vendors/ImportSupplierModal";
    import EditUserModal from "../../partials/modals/users/EditUserModal";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import ConfirmModal from '../../partials/modals/ConfirmModal';
    import SupplierHeader from './partials/SupplierHeader';
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
    import {COUNTRIES_URL,SUPPLIER_URL,ACCOUNTS_INITIALS,SUPPLIER_COMPANIES_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,CommonLinks,SideBar,SideBarInvSettings,SupplierHeader,
        DeleteModal,SupplierModal,GeneralImportModal,ConfirmModal,PaginateTemplate,
        ProcessingOverlay,SideBarInventory},
        data(){
            return {
                current_facility: {},
                initializations: {},
                accountings: {},
                suppliers: [],
                countries: [],
                companies: [],
                selected_suppliers: [],
                msg: 'Loading. Please wait...',
                current_role_name: null,
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

            reload_suppliers(supplier){
                this.suppliers.concat(supplier);
            },

            loadCountry(){
              this.progress_overlay = "show";
                get(COUNTRIES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.countries = res.data.results;
                        this.loadAccounting();
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

            loadAccounting(){
                this.progress_overlay = "show";
                get(ACCOUNTS_INITIALS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.accountings = res.data.results;
                        this.loadSuppliers();
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

            loadSuppliers(state_load="show"){
                this.progress_overlay = state_load;
                get(this.SUPPLIER_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.suppliers = res.data.results.data;
                        this.pagination = res.data.results.pagination;
                        //console.info(this.suppliers);
                        // this.loadSupplier();
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
                        this.loadCompanies();
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

            loadCompanies(){
                this.progress_overlay = "show";
                get(SUPPLIER_COMPANIES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.companies = res.data.results.data;
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

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }

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