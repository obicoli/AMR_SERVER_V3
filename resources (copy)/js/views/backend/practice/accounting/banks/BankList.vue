<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-right app-header width-80-pc">
                                    <common-link :active_link="'coa'"></common-link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-banks :scrollable="false" :width="true" :transparent="true" :title="'Accounts'" :active_num="'banks'"></side-bar-banks>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="mg-bottom-30 universal-grid padding-left-20 padding-right-20 max-width-1000" role="grid">
                                        <report-heading :report_name="'Bank Accounts'" :as_at="''" :facility_name="facility_name"></report-heading>

                                        <div class="width-40-pc padding-top-20 padding-bottom-20 pull-left">
                                            <search-item-form-control :field_wdth="300" :placeholder="'Search by name'"></search-item-form-control>
                                        </div>
                                        <div class="width-40-pc padding-left-20 padding-top-20 padding-bottom-20 pull-right">
                                            <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#bank_account_modal" type="button" class="btn combo-button combo-default">+ New</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                        <a class="dropdown-item"> Import</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <table class="user-table employees table-hover" role="presentation" id="dgrid_120-header">
                                            <tr>
                                                <th style="width:28%" class="text-left">Account</th>
                                                <th style="width:22%;" class="left-dotted">Type</th>
                                                <th style="width:29%;" class="left-dotted">Detail Type</th>
                                                <!-- <th style="width:10%;" class="left-dotted">Tax Rate</th> -->
                                                <th style="width:13%;" class="left-dotted text-right">Balance</th>
                                                <th style="width:8%;" class="left-dotted"></th>
                                            </tr>
                                            <tr v-for="(account,index) in chart_of_accounts" :key="'chart_of_accounts'+index" class="body">
                                                <td>
                                                    <a data-toggle="modal" :data-target="'#coa_modal_'+index">{{account.name}}</a>
                                                </td>
                                                <td>
                                                    <a data-toggle="modal" :data-target="'#coa_modal_'+index">{{account.account_type.name}}</a>
                                                </td>
                                                <td>
                                                    <a data-toggle="modal" :data-target="'#coa_modal_'+index">{{account.default_coa.name}}</a>
                                                </td>
                                                <!-- <td>
                                                    <a data-toggle="modal" :data-target="'#coa_modal_'+index">{{account.tax_rate}}</a>
                                                </td> -->
                                                <td class="text-right">
                                                    <a data-toggle="modal" :data-target="'#coa_modal_'+index">{{format_money(account.balance_obj.balance)}}</a>
                                                </td>
                                                <td>
                                                    <div class="btn-group float-right" role="group" aria-label="Button group">
                                                        <div class="btn-group" role="group">
                                                            <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                <a class="dropdown-item pointer-cursor">Account History</a>
                                                                <a data-toggle="modal" :data-target="'#coa_modal_'+index" class="dropdown-item pointer-cursor">Edit</a>
                                                                <a v-if="account.status==='Active'" @click="set_status(account.status)" data-toggle="modal" :data-target="'#inactive_modal_'+index" class="dropdown-item pointer-cursor">Make inactive</a>
                                                                <a v-if="account.status==='Inactive'" @click="set_status(account.status)" data-toggle="modal" :data-target="'#inactive_modal_'+index" class="dropdown-item pointer-cursor">Make Active</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <confirm-modal :form_inputs="form_status" :modal_id="'inactive_modal_'+index" :modal_title="'Account'" v-on:successReq="loadCoa('hide')" :confirm_message="'Are you sure?'" :item_url="initialUrl+'/'+account.id"></confirm-modal>
                                                <account-modal v-if="page_loaded" :initial_url="initialUrl+'/'+account.id" :ACCOUNTING="ACCOUNTING" :form_data="account" :company_main_coa="company_main_coa" v-on:successEdited="loadCoa('hide')" :user_mode="'Edit'" :practice_id="practice_id" :accounting_initials="accounting_initials" :modal_id="'coa_modal_'+index" :title="'Account'"></account-modal>
                                            </tr>
                                            <tr v-if="chart_of_accounts.length===0">
                                                <td colspan="7" class="text-center cl-amref fs-14">No Account to display!</td>
                                            </tr>
                                        </table>
                                        <div class="width-100-pc text-center mg-top-30">
                                            <small v-if="page_loaded" class="fs-12 cl-888">{{as_at}}</small>
                                        </div>
                                    </div>
                                </div>
                                <bank-modal v-if="page_loaded" :initial_url="initialUrl" :main_accounts="company_main_coa" v-on:successCreated="loadBanks('hide')" :user_mode="'Create'" :practice_id="practice_id" :banking="banking" :modal_id="'bank_account_modal'" :title="'Bank Account'"></bank-modal>
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
    import SideBarBanks from "../../partials/sidebars/accounting/SideBarBanks";
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
    import CommonLink from "../../partials/sidebars/accounting/CommonLink";
    import ConfirmModal from "../../partials/modals/ConfirmModal";
    import BankModal from "../../partials/modals/accounting/BankModal";
    import {get} from "../../../../../helpers/api";
    import ReportHeading from "../statements/partials/ReportHeading";
    import Auth from "../../../../../store/auth";
    import SupplierModal from '../../partials/modals/vendors/SupplierModal';
    import {PURCHASES_URL,PURCHASES_FACILITY_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_SUPPLY,PRODUCT_REQUISITIONS} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING} from '../../../../../helpers/process_status';
    import {ACCOUNTS_BANK_ACCOUNTS,ACCOUNTS_INITIALS} from "../../../../../router/api_routes";
    import SearchItemFormControl from "../../partials/modals/product/SearchItemFormControl";
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,SideBarBanks,ProcessingOverlay,SearchItemFormControl,CommonLink,BankModal,ConfirmModal,ReportHeading},
        data(){
            return {
                ACCOUNTING:ACCOUNTING,
                initialUrl: ACCOUNTS_BANK_ACCOUNTS,
                practice_id: '',
                facility_name: '',
                progress_overlay: 'hide',
                page_loaded: false,
                chart_of_accounts: [],
                company_main_coa: [],
                bank_accounts: [],
                as_at: '',
                banking: [],
                form_status: {
                    status: '',
                }
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            set_status(status_){
                if(status_==="Active"){
                    this.form_status.status = "Inactive"
                }else{
                    this.form_status.status = "Active"
                }
            },

            loadBanks(load_progress="show"){
                this.progress_overlay = load_progress;
                get(this.initialUrl)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results;
                        this.page_loaded = true;
                        this.progress_overlay = "hide";
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide"
                });
            },

            format_money(money_to){
                return formatMoney(money_to);
            }
            
        },
        mounted() {
            let facility = Auth.getCurrentAccount('clinic');
            this.branch_id = facility.id;
            this.practice_id = facility.id;
            this.facility_name = facility.name;
            this.banking = Auth.getAccounting().banking;
            //console.info(this.accounting_initials);
            this.loadBanks();
        }
    }
</script>

<style scoped>

    tr th{
        padding: 6px 10px;
    }
    tr td{
        padding: 5px 10px;
        border: 1px dotted #787887;
    }
    tr td:first-child{
        border-left: 0px solid transparent;
    }
    tr:first-child td{ border-top: 2px solid #444!important; }
    tr:last-child td{
        border-bottom: 2px solid #444!important;
    }
</style>

