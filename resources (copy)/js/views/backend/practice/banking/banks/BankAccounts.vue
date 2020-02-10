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
                                                    <a class="fw-600 cl-444 fs-20">
                                                        List of Banks and Credit Cards
                                                    </a>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-20">

                                                    <div class=" width-30-pc mg-bottom-10 float-left">
                                                        <input placeholder="Search by name" @keyup="searchAccount($event)" class="width-100-pc" type="text">
                                                    </div>

                                                    <div class=" width-40-pc mg-bottom-10 float-right text-right">
                                                        <div class="btn-group float-right" role="group">
                                                            <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Add an Account
                                                            </button>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                <a data-toggle="modal" data-target="#create_new_bank_account_modal" class="dropdown-item pointer-cursor">Add an Bank or Credit Card</a>
                                                                <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor">Import Bank or Credit Card</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="width-100-pc float-left mg-top-30">
                                                        <table class="table banking-transaction table-hover mg-bottom-20">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:2%;">
                                                                        <input type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                    </th>
                                                                    <th style="width:20%;">Name</th>
                                                                    <th style="width:20%;">Bank Name</th>
                                                                    <th style="width:10%;">Account Number</th>
                                                                    <th style="width:8%;">Account Type</th>
                                                                    <th style="width:10%;">Branch Code</th>
                                                                    <th class="text-right" style="width:12%;">Balance</th>
                                                                    <th class="text-center" style="width:6%;">Active</th>
                                                                    <th class="text-center" style="width:6%;">Default</th>
                                                                    <th style="width:6%;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="is_initializing">
                                                                <tr>
                                                                    <td class="somepad text-center" colspan="10">
                                                                        <img src="/assets/icons/dashboard/loader.gif">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr v-if="bank_accounts.length===0">
                                                                    <td colspan="10" class="cl-amref text-center fs-14">No bank to display! <a data-toggle="modal" data-target="#create_new_bank_modal" class="cl-blue-link pointer-cursor txt-deco-underline">Create Here</a></td>
                                                                </tr>
                                                                <tr v-for="(bank_account,index) in bank_accounts" :key="'element_key_'+index">
                                                                    <td class="somepad">
                                                                        <input type="checkbox" class="pointer-cursor" v-model="selected_banks" :value="bank_account.id">
                                                                    </td>
                                                                    <td class="somepad">
                                                                        {{bank_account.account_name}}
                                                                    </td>
                                                                    <td class="somepad">{{bank_account.bank.name}}</td>
                                                                    <td class="somepad">{{bank_account.account_number}}</td>
                                                                    <td class="somepad">{{bank_account.account_type.name}}</td>
                                                                    <td class="somepad">{{bank_account.bank_branch.code}}</td>
                                                                    <td class="text-right somepad">KES{{format_Money(bank_account.balance)}}</td>
                                                                    <td class="text-center somepad"><input type="checkbox" disabled class="pointer-cursor" v-model="bank_account.status"></td>
                                                                    <td class="text-center somepad"><input type="checkbox" disabled class="pointer-cursor" v-model="bank_account.is_default"></td>
                                                                    <td class="somepad">
                                                                        <a data-toggle="modal" :data-target="'#edit_bank_account_'+index" class="showOnHover pointer-cursor" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                        <a data-toggle="modal" :data-target="'#delete_bank_account_'+index" class="showOnHover cl-amref pointer-cursor" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                                    </td>
                                                                    <delete-modal v-on:deletionSuccessful="loadBankAccounts(false)" :modal_id="'delete_bank_account_'+index" :item_url="bank_accounts_api+'/'+bank_account.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Bank Account'"></delete-modal>
                                                                    <bank-account-modal :modal_id="'edit_bank_account_'+index" :form_data="bank_account" :user_mode="'Edit'" :banks="banks" :bank_branches="bank_branches" :bank_account_types="bank_account_types" :bank_accounts_api="bank_accounts_api+'/'+bank_account.id" v-on:successCreated="loadBankAccounts(false)" :title="'Edit Bank Account'"></bank-account-modal>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        
                                                        <bank-modal v-if="page_ready" :modal_id="'create_new_bank_modal'" :user_mode="'Create'" :bank_api="bank_api" v-on:bankCreated="loadBanks" :title="'New Bank Institution'"></bank-modal>
                                                        <bank-account-modal v-if="page_ready" v-on:successCreated="loadBankAccounts(false)" :bank_accounts_api="bank_accounts_api" :banks="banks" :bank_branches="bank_branches" :modal_id="'create_new_bank_account_modal'" :bank_account_types="bank_account_types" :title="'New Bank Account'" :user_mode="'Create'"></bank-account-modal>

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
    import SideBarInventory from "../../partials/sidebars/inventory/SideBarInventory";
    import CopyRight from "../../partials/CopyRight";
    import SidebarBanking from "../../partials/sidebars/supplychain/SidebarBanking";
    import EditUserModal from "../../partials/modals/users/EditUserModal";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import BankModal from "../../partials/modals/accounting/BankModal";
    import BankBranchModal from "../../partials/modals/accounting/BankBranchModal";
    import BankAccountModal from "../../partials/modals/accounting/BankAccountModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {removeElement,paginator,formatMoney} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS} from "../../../../../helpers/process_status";
    import {BANKING_BANKS_URL,BANKING_ACCOUNTS_URL,BANKING_BRANCHES_URL,BANKING_ACCOUNTS_TYPES_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,CommonLinks,SideBar,BankBranchModal,SidebarBanking,
        DeleteModal,DeleteModal,PaginateTemplate,BankModal,BankAccountModal,CopyRight,
        ProcessingOverlay,SideBarInventory},
        data(){
            return {
                is_initializing: false,
                processing: false,
                PROCESS_STATUS: PROCESS_STATUS,
                banks: [],
                bank_branches: [],
                bank_accounts: [],
                bank_account_types: [],
                selected_banks: [],
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                pagination: paginator(),
                bank_api: BANKING_BANKS_URL,
                branch_api: BANKING_BRANCHES_URL,
                bank_accounts_api: BANKING_ACCOUNTS_URL,
                bank_account_types_api: BANKING_ACCOUNTS_TYPES_URL,
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
                this.selected_banks = [];
                if(event.target.checked){
                    for (let index = 0; index < this.bank_accounts.length; index++) {
                        const element = this.bank_accounts[index];
                        this.selected_banks.push(element.id);
                    }
                }else{
                    this.selected_banks = [];
                }
            },

            reload_suppliers(supplier){
                this.suppliers.concat(supplier);
            },

            searchAccount(event){
                this.is_initializing = true;
                this.processing = true;
                get(this.bank_accounts_api+'?search_key='+event.target.value)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results.data;
                        this.is_initializing = false;
                        this.processing = false;
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
                    this.processing = false;
                });
            },

            loadBanks(show_progress){
                this.is_initializing = true;
                this.processing = true;
                get(this.bank_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.banks = res.data.results;
                        if(show_progress){
                            this.loadBranch(show_progress);
                        }else{
                            this.is_initializing = false;
                            this.processing = false;
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

            loadBranch(show_progress){
                //this.progress_overlay = "hide";
                if(show_progress){
                    // this.progress_overlay = "show";
                    this.is_initializing = true;
                    this.processing = true;
                }
                get(this.branch_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_branches = res.data.results;
                        //console.info(this.bank_branches);
                        if(show_progress){
                            this.loadBankAccounts(show_progress);
                        }else{
                            this.is_initializing = false;
                            this.processing = false;
                            // this.progress_overlay = "hide";
                            this.page_ready = true;
                        }
                        
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
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

            loadBankAccounts(show_progress){
                // this.progress_overlay = "hide";
                if(show_progress){
                    // this.progress_overlay = "show";
                    this.is_initializing = true;
                    this.processing = true;
                }
                get(this.bank_accounts_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results.data;
                        //console.info(this.bank_accounts);
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
                        if(show_progress){
                            this.loadAccountTypes(show_progress);
                        }else{
                            // this.progress_overlay = "hide";
                            this.is_initializing = false;
                            this.processing = false;
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

            loadAccountTypes(show_progress){
                //this.progress_overlay = "hide";
                if(show_progress){
                    this.is_initializing = true;
                    this.processing = true;
                    // this.progress_overlay = "show";
                }
                get(this.bank_account_types_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_account_types = res.data.results;
                        //console.info(this.bank_account_types);
                        if(show_progress){
                            this.is_initializing = false;
                            this.processing = false;
                            // this.progress_overlay = "hide";
                            this.page_ready = true;
                        }else{
                            this.is_initializing = false;
                            this.processing = false;
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

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }

        },
        mounted() {
            this.loadBanks(true);
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>