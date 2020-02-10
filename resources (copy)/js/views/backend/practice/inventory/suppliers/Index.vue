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
                                                    <div class="width-40-pc float-left"><a class="fw-600 cl-444 fs-20">List of Suppliers</a></div>
                                                    <div class="width-60-pc float-right text-right fs-12">
                                                        <quick-link :active_link="'suppliers'"></quick-link>
                                                    </div>
                                                </div>

                                                <div v-if="page_ready && suppliers.length===0" class="width-100-pc float-left mg-top-30 text-center padding-top-60 bg-f4 padding-bottom-30">
                                                    <p class="fs-15 txt-uppercase">Suppliers.</p><br>
                                                    <small class="fs-12">Create and manage your suppliers, all in one place</small><br><br>
                                                    <a data-toggle="modal" data-target="#new_supplier_modal_001" class="btn btn-secondary banking-process-amref">Add New Supplier</a><br><br>
                                                    <ul class="custom-list">
                                                        <li class="title">In the Suppliers section, you can:</li>
                                                        <li>Create your suppliers to the System</li>
                                                        <li>Run Suppliers statement report</li>
                                                        <li>Set a currency to invoice your Suppliers</li>
                                                        <li>View transaction history for each Suppliers</li>
                                                    </ul>
                                                </div>

                                                <div v-else class="width-100-pc float-left mg-top-30">

                                                    <div class="width-45-pc float-left mg-right-15">
                                                        <div class="width-60-pc float-left">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input placeholder="Search supplier" :disabled="is_initializing || processing" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="width-25-pc float-right">
                                                        <div class="btn-group float-right" role="group">
                                                            <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Add Supplier
                                                            </button>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                <a data-toggle="modal" data-target="#new_supplier_modal_001" class="dropdown-item pointer-cursor">Add Supplier</a>
                                                                <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor">Import Suppliers</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="width-100-pc float-left mg-top-20">
                                                        <div class=" width-100-pc mg-bottom-10 float-left">
                                                            <button :disabled="form.suppliers.length===0 || processing || is_initializing" type="button" class="btn btn-secondary btn-actions">Delete</button>
                                                            <button :disabled="form.suppliers.length===0 || processing || is_initializing" type="button" class="btn btn-secondary btn-actions">Mark as Active/Inactive</button>
                                                        </div>
                                                        <table class="table banking-transaction table-hover mg-bottom-20">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:2%;">
                                                                        <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                    </th>
                                                                    <th style="width:18%;">Name</th>
                                                                    <th style="width:24%;">Contact name</th>
                                                                    <th style="width:17%;" class="text-right">Payable</th>
                                                                    <th style="width:12%;">Telephone</th>
                                                                    <th style="width:12%;">Mobile</th>
                                                                    <th style="width:5%;" class="text-center">Active</th>
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
                                                                <tr v-for="(supplier,index) in suppliers" :key="'suppliers_'+index">
                                                                    <td class="somepad">
                                                                        <input :disabled="is_initializing || processing" type="checkbox" :value="supplier.id" class="pointer-cursor">
                                                                    </td>
                                                                    <td class="somepad">{{supplier.salutation+' '+supplier.first_name+' '+supplier.last_name}}</td>
                                                                    <td class="somepad"><router-link class="cl-blue-link pointer-cursor" :to="'/suppliers/'+supplier.id+'/profile'">{{supplier.legal_name}}</router-link> </td>
                                                                    <td class="somepad text-right">{{currency+' '+format_money(supplier.balance)}}</td>
                                                                    <td class="somepad">
                                                                        {{supplier.phone}}
                                                                    </td>
                                                                    <td class="somepad text-right">{{supplier.mobile}}</td>
                                                                    <td class="somepad text-center">
                                                                        <input v-if="supplier.status" disabled type="checkbox" checked class="pointer-cursor">
                                                                        <input v-else disabled type="checkbox" :value="supplier.status" class="pointer-cursor">
                                                                    </td>
                                                                    <td class="somepad">
                                                                        <div class="btn-group float-right" role="group">
                                                                            <a :id="'btnGroupDrop222_'+index" class="dropdown-toggle fs-12 fw-600 cl-blue-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                Actions
                                                                            </a>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop222_'+index">
                                                                                <router-link :to="'/suppliers/'+supplier.id+'/profile'" class="dropdown-item pointer-cursor fs-12">View</router-link>
                                                                                <a class="dropdown-item separator"></a>
                                                                                <a data-toggle="modal" :data-target="'#edit_supplier_modal_001_'+index" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-edit"></i> Edit</a>
                                                                                <a v-if="supplier.status" @click="editSupplier(supplier,false)" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-ban cl-amref"></i> Make Inactive</a>
                                                                                <a v-else @click="editSupplier(supplier,true)" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-check cl-success-light"></i>Make Active</a>
                                                                                <a data-toggle="modal" :data-target="'#delete_supplier_'+index" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-trash-o"></i> Delete</a>
                                                                                <a class="dropdown-item separator"></a>
                                                                                <a class="dropdown-item pointer-cursor fs-12">Add PO</a>
                                                                                <a class="dropdown-item pointer-cursor fs-12">Add Bill</a>
                                                                                <a class="dropdown-item pointer-cursor fs-12"> Add Invoice</a>
                                                                                <a class="dropdown-item pointer-cursor fs-12"> Add Payment</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <delete-modal v-on:deletionSuccessful="loadSuppliers(false)" :modal_id="'delete_supplier_'+index" :item_url="SUPPLIER_URL+'/'+supplier.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Supplier'"></delete-modal>
                                                                    <supplier-modal :form_data="supplier" :currency="currency" :vats="taxations" :supplier_terms="supplier_terms" :filters="filters" :bank_account_types="bank_account_types" :banks="banks" :bank_branches="bank_branches" :suppliers_api="SUPPLIER_URL+'/'+supplier.id" v-on:supplierEdited="loadSuppliers('hide')" :countries="countries" :title="'Edit Supplier'" :user_mode="'Edit'" :modal_id="'edit_supplier_modal_001_'+index"></supplier-modal>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class=" width-100-pc mg-bottom-10 float-left text-center">
                                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadSuppliers()" :custom="true"></paginate-template>
                                                        </div>
                                                    </div>
                                                </div>
                                                <supplier-modal v-if="page_ready" :currency="currency" :vats="taxations" :supplier_terms="supplier_terms" :filters="filters" :bank_account_types="bank_account_types" :banks="banks" :bank_branches="bank_branches" :suppliers_api="SUPPLIER_URL" v-on:supplierAdded="loadSuppliers('hide')" :countries="countries" :title="'Supplier Information'" :user_mode="'Create'" :modal_id="'new_supplier_modal_001'"></supplier-modal>
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
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import CopyRight from "../../partials/CopyRight";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import SupplierModal from "../../partials/modals/vendors/SupplierModal";
    import QuickLink from "./partials/QuickLink";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {removeElement,paginator,formatMoney,format_lunox_date, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS,ACCOUNTING} from "../../../../../helpers/process_status";
    import {SUPPLIER_URL,COUNTRIES_URL,BANKING_BANKS_URL,BANKING_BRANCHES_URL,BANKING_ACCOUNTS_TYPES_URL,PRODUCT_TAX_URL,SUPPLIER_TERMS_API} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,
        SideBar,CopyRight,SupplierModal,DeleteModal,
        ProcessingOverlay,PaginateTemplate,QuickLink
        },
        data(){
            return {
                form: {
                    suppliers: [],
                },
                suppliers: [],
                filters: {},
                
                // progress_overlay: 'hide',
                page_ready: false,
                progress_overlay: "hide",
                is_initializing: false,
                processing: false,
                currency: ACCOUNTING.CURRENCY,
                SUPPLIER_URL: SUPPLIER_URL,
                msg: 'Loading. Please wait...',
                countries: [],
                banks: [],
                bank_branches: [],
                bank_account_types: [],
                taxations: [],
                supplier_terms: [],
                pagination: paginator(),
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            editSupplier(supplier,status_){
                this.is_initializing = true;
                //let supplier_form = supplier;
                supplier.status = status_;
                post(SUPPLIER_URL+'/'+supplier.id+'?inactive_active_action='+status_,supplier)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        supplier.status = status_;
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
                    if(status_){
                        supplier.status = false;
                    }else{
                        supplier.status = true;
                    }
                    this.is_initializing = false;
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

            loadTerms(){
                get(SUPPLIER_TERMS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.supplier_terms = res.data.results.data;
                        // console.info(this.customer_terms);
                        // this.is_initializing = false;
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
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

            loadCountry(){
               //this.progress_overlay = "show";
               this.is_initializing = true;
                get(COUNTRIES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.countries = res.data.results;
                        console.info(this.countries);
                        this.progress_overlay = "hide";
                        //this.loadSuppliers();
                        this.loadBanks();
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

            loadBanks(){
                get(BANKING_BANKS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.banks = res.data.results;
                        // this.is_initializing = false;
                        // this.processing = false;
                        console.info(this.banks);
                        this.loadBranches();
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

            loadBranches(){
                get(BANKING_BRANCHES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_branches = res.data.results;
                        // this.is_initializing = false;
                        // this.processing = false;
                        // this.progress_overlay = "hide";
                        // this.page_loaded = true;
                        // this.page_ready = true;
                        console.info(this.bank_branches);
                        this.loadAccountType();
                        // this.loadSuppliers();
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

            loadAccountType(){
                get(BANKING_ACCOUNTS_TYPES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_account_types = res.data.results;
                        // this.is_initializing = false;
                        // this.processing = false;
                        // this.progress_overlay = "hide";
                        // this.page_loaded = true;
                        // this.page_ready = true;
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
                    this.is_initializing = false;
                });
            },

            check_all(event){
                // this.selected_banks = [];
                // if(event.target.checked){
                //     for (let index = 0; index < this.bank_accounts.length; index++) {
                //         const element = this.bank_accounts[index];
                //         this.selected_banks.push(element.id);
                //     }
                // }else{
                //     this.selected_banks = [];
                // }
            },

            loadSuppliers(progress = "hide"){
                this.is_initializing = true;
                get(SUPPLIER_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.suppliers = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        // this.bank_account = res.data.results;
                        // this.form.balance = this.bank_account.balance;
                        // this.bank_transactions = res.data.results.transaction.data;
                        console.info(this.suppliers);
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