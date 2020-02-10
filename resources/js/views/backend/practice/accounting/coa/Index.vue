<template>

    <div>

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
                                                        {{account_type}}
                                                    </a>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-20">
                                                    <div class="width-45-pc float-left mg-right-15">
                                                        <div class="width-50-pc float-left">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input placeholder="Search by name" @keyup="searchCoa($event)" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="width-20-pc float-left mg-left-10">
                                                            <button type="button" @click="loadCoa(true)" :disabled="is_initializing || processing" class="btn banking-process pointer-cursor height-27">
                                                                Reset
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="width-25-pc float-right">
                                                        <div class="btn-group float-right" role="group">
                                                            <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Add an Account
                                                            </button>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                <a @click="setMode('Create')" data-toggle="modal" data-target="#coa_modal" class="dropdown-item pointer-cursor">Chart of Account</a>
                                                                <a data-toggle="modal" data-target="#sale_purchase_modal" class="dropdown-item pointer-cursor">Sales & Purchase</a>
                                                                <a data-toggle="modal" data-target="#adjust_account_modal" class="dropdown-item pointer-cursor">Opening balance adjustment</a>
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
                                                                    <th style="width:28%">Account</th>
                                                                    <th style="width:22%">Type</th>
                                                                    <th style="width:27%;">Detail Type</th>
                                                                    <th style="width:13%">Balance</th>
                                                                    <th style="width:8%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="is_initializing">
                                                                <tr>
                                                                    <td class="somepad text-center" colspan="6">
                                                                        <img src="/assets/icons/dashboard/loader.gif">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-for="(chart_of_account,index) in chart_of_accounty" :key="'chart_of_accounts_'+index">
                                                                <tr>
                                                                    <td class="somepad">
                                                                        <span v-if="chart_of_account.is_special" title="System Account" class="fs-13 pointer-cursor"><i class="fa fa-lock"></i></span>
                                                                        <input v-else :disabled="is_initializing || processing" v-model="selected_chart_of_account" type="checkbox" class="pointer-cursor" :value="chart_of_account.id">
                                                                    </td>
                                                                    <td class="somepad">
                                                                        <router-link :to="'/accounts/'+chart_of_account.id+'/transactions/list'">{{chart_of_account.name}}</router-link>
                                                                    </td>
                                                                    <td class="somepad">{{chart_of_account.account_type.name}}</td>
                                                                    <td class="somepad">{{chart_of_account.default_coa.name}}</td>
                                                                    <td class="somepad text-right">
                                                                        <router-link :to="'/accounts/'+chart_of_account.id+'/transactions/list'" v-if="chart_of_account.balance" class="cl-blue-link fw-600">KES{{format_money(chart_of_account.balance)}}</router-link>
                                                                        <a v-else data-toggle="modal" :data-target="'#coa_modal_'+index">KES{{format_money(chart_of_account.balance)}}</a>
                                                                    </td>
                                                                    <td class="somepad icon-group text-right">
                                                                        <div class="btn-group" role="group">
                                                                            <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                Action
                                                                            </a>
                                                                            <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                                <router-link :to="'/accounts/'+chart_of_account.id+'/transactions/list'" class="dropdown-item pointer-cursor">History</router-link>
                                                                                <a v-if="chart_of_account.is_special===0 && chart_of_account.total_transaction===0" class="dropdown-item separator"></a>
                                                                                <a v-if="chart_of_account.is_special===0" @click="setMode('Edit',chart_of_account)" data-toggle="modal" data-target="#coa_modal" class="dropdown-item pointer-cursor">Edit</a>
                                                                                <a v-if="chart_of_account.is_special===0 && chart_of_account.total_transaction===0" @click="deleteCoa(chart_of_account)" data-toggle="modal" data-target="#delete_transaction" class="dropdown-item pointer-cursor">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <account-modal :initial_url="initialUrl" :form_data="chart_of_account" :vat_types="vat_types" :filters="filters" :ACCOUNTING="ACCOUNTING" :CHART_OF_ACCOUNT_API="CHART_OF_ACCOUNT_API" :user_mode="'Edit'" :account_types="account_types" :accounts="chart_of_accounty" :modal_id="'coa_modal_'+index" :title="'New Account'" @create-account-event="loadCoa(true)" :key="'asasa_'+index"></account-modal> -->
                                                                        <!-- <a class="showOnHover" data-toggle="collapse" :data-target="'#transaction_details_'+index" title="Quick View"><i class="fa fa-eye"></i></a>
                                                                        <a class="showOnHover" data-toggle="modal" :data-target="'#transaction_split_modal_'+index" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                                                        <a class="showOnHover cl-amref" data-toggle="modal" :data-target="'#delete_transaction_'+index" title="Delete"><i class="fa fa-trash-o"></i></a> -->
                                                                    </td>
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class=" width-100-pc mg-bottom-10 float-left text-center">
                                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadCoa()" :custom="true"></paginate-template>
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
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <sales-purchase-modal v-if="page_loaded" 
                        :ACCOUNTING="ACCOUNTING" 
                        :modal_id="'sale_purchase_modal'" 
                        :modal_title="'New Sales or Purchases Account'" 
                        @create-account-event="loadCoa(true)">
                    </sales-purchase-modal>
                    <account-modal v-if="page_loaded"
                        :user_mode="user_mode"
                        :form_model="form_model"
                        :vat_types="vat_types"
                        :filters="filters"
                        :ACCOUNTING="ACCOUNTING"
                        :CHART_OF_ACCOUNT_API="CHART_OF_ACCOUNT_API"
                        :account_types="account_types"
                        :accounts="chart_of_accounty"
                        :modal_id="'coa_modal'"
                        :modal_title="modal_title"
                        @create-account-event="loadCoa(true)" 
                        @edit-account-event="loadCoa(true)">
                    </account-modal>
                    <account-opening-balance v-if="page_loaded"
                        :modal_title="'Adjust Account Opening Balances'" 
                        :balance_sheet_accounts="balance_sheet_accounts"
                        :filters="filters"
                        :currency="currency"
                        :modal_id="'adjust_account_modal'"
                        @adjust-account-balance-event="loadCoa(true)"
                        @delete-item-event="loadCoa(true)">
                    </account-opening-balance>
                    <delete-modal :modal_title="'Delete Account'" :item_url="item_url" :confirm_message="'Are you sure?'" @delete-item-event="loadCoa(true)" :modal_id="'delete_transaction'"></delete-modal>
                    <!-- <bank-account-modal v-if="page_loaded" v-on:successCreated="loadCoa(true)" :bank_accounts_api="BANKING_ACCOUNTS_URL" :banks="banks" :bank_branches="bank_branches" :modal_id="'create_new_bank_account_modal'" :bank_account_types="bank_account_types" :title="'New Bank Account'" :user_mode="'Create'"></bank-account-modal> -->
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
    import DeleteModal from "../../partials/modals/DeleteModal";
    import CopyRight from "../../partials/CopyRight";
    import BankAccountModal from "../../partials/modals/accounting/BankAccountModal";
    import AccountModal from "../../partials/modals/accounting/AccountModal";
    import SalesPurchaseModal from "../../partials/modals/accounting/SalesPurchaseModal";
    import AccountOpeningBalance from "../../partials/modals/accounting/AccountOpeningBalance";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post, del} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {removeElement,removeIndex,formatMoney,create_bank_statement_transaction, createHtmlErrorString,paginator} from "../../../../../helpers/functionmixin";
    import {AC_TYPES,ACCOUNTING} from "../../../../../helpers/process_status";
    import {BANKING_BANKS_URL,CHART_OF_ACCOUNTS_TYPES,CHART_OF_ACCOUNT_API,PRODUCT_TAX_URL,CHART_OF_ACCOUNTS,BANKING_ACCOUNTS_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,BankAccountModal,
        ProcessingOverlay,CopyRight,AccountModal,SalesPurchaseModal,AccountOpeningBalance},
        data(){
            return {
                user_mode: 'Create',
                modal_title: 'New Account',
                form_model:null,
                account_types: [],
                vat_types: [],
                balance_sheet_accounts: [],
                initialUrl: CHART_OF_ACCOUNTS,
                filters: null,
                form: {
                    bank_account: null,
                    selected_transactions: [],
                    transactions: [],
                    action_taken: null,
                },
                banks: [],
                bank_branches: [],
                bank_account_types: [],
                selected_chart_of_account: [],
                AC_TYPES: AC_TYPES,
                bank_accounts: [],
                bank_transactions: [],
                chart_of_accounty: [],
                accounts: [],
                //
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_loaded: false,
                is_initializing: false,
                processing: false,
                pagination: paginator(),
                BANKING_ACCOUNTS_URL: BANKING_ACCOUNTS_URL,
                account_type: null,
                ACCOUNTING: ACCOUNTING,
                CHART_OF_ACCOUNT_API:CHART_OF_ACCOUNT_API,
                item_url: CHART_OF_ACCOUNT_API,
                currency: ACCOUNTING.CURRENCY,
            }
        },
        watch: {
            "$route.query.type": function (id) {
                this.account_type = id;
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },
            setMode(user_mode,form_datas=null){
                this.user_mode = user_mode;
                if(form_datas){
                    this.modal_title = "Edit Account";
                    this.form_model = form_datas;
                }
            },
            searchCoa(event){
                this.is_initializing = true;
                get(CHART_OF_ACCOUNT_API+'?search_key='+event.target.value)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.chart_of_accounty = res.data.results.data;
                        this.pagination = res.data.results.pagination;
                        this.filters = res.data.filters;
                        this.is_initializing = false;
                        this.page_loaded = true;
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },

            deleteCoa(coa){
                this.item_url = CHART_OF_ACCOUNT_API+'/'+coa.id;
            },

            check_all(event){
                this.form.selected_transactions = [];
                if(event.target.checked){
                    for (let index = 0; index < this.form.transactions.length; index++) {
                        this.form.selected_transactions.push(index);
                    }
                }else{
                    this.selected_banks = [];
                }
            },

            loadCoa(state_ = false){
                this.is_initializing = true;
                get(CHART_OF_ACCOUNT_API+'?page='+this.pagination.current_page+'&account_type='+this.account_type)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.chart_of_accounty = res.data.results.data;
                        this.pagination = res.data.results.pagination;
                        this.filters = res.data.results.filters;
                        this.is_initializing = false;
                        this.page_loaded = true;
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },

            loadBalancesheetaccounts(){
                this.is_initializing = true;
                get(CHART_OF_ACCOUNT_API+'?balance_sheet_accounts=all')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        console.info(res.data.results);
                        this.balance_sheet_accounts = res.data.results.data;
                        this.loadCoa();
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },

            loadVatType(state_ = false){
                this.is_initializing = true;
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.vat_types = res.data.results.data;
                        //this.loadCoa(true);
                        this.loadBalancesheetaccounts(true);
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },

            loadAccountType(state_ = false){
                this.is_initializing = true;
                get(CHART_OF_ACCOUNTS_TYPES)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.account_types = res.data.results.data;
                        //console.info(this.account_types);
                        this.loadVatType();
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            delete_stuff(item_id){
                this.is_initializing = true;
                let item_url = CHART_OF_ACCOUNT_API+'/'+item_id;
                del(item_url)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.is_initializing = false;
                        this.$awn.success(res.data.description);
                        this.loadCoa(true);
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },
        },

        mounted() {
            this.account_type = this.$route.query.type;
            this.loadAccountType(true);
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>