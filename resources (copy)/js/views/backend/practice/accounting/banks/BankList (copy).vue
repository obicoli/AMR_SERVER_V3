<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">Banks:</div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-bank :scrollable="false" :width="true" :transparent="true" :active_el=1></side-bar-bank>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    <div class="filter-block form-inline float-left">
                                        <span>Available Banks:</span>
                                    </div>
                                    <div  class="btn-group float-right mg-left-10" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#add_bank_modal" type="button" class="btn combo-button primary">+ New Bank</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item fs-14" href="#"> Import banks</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-block form-inline float-right">
                                        <input type="text" placeholder="Search here" class="form-control product-entry-input-field height-27">
                                    </div>
                                    <bank-modal v-if="page_loaded" :modal_id="'add_bank_modal'" :initial_url="initialUrl" :user_mode="'Create'" :title="'Add Bank'"></bank-modal>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">
                                        <table class="user-table employees" role="presentation">
                                            <thead>
                                                <tr>
                                                    <th class="no-rb" style="width:5%">#ID</th>
                                                    <th style="width:20%">Name</th>
                                                    <th style="width:15%">Branch</th>
                                                    <th style="width:10%">Branch Code</th>
                                                    <th style="width:15%">Account Title</th>
                                                    <th style="width:15%">Account Number</th>
                                                    <th style="width:10%">Status</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(bank_account, indexss) in bank_accounts" :key="'bank_'+indexss" class="tb-1">
                                                    <td class="no-rb" tabindex="0">{{indexss}}</td>
                                                    <td class="">{{bank_account.bank.name}}</td>
                                                    <td class="">{{bank_account.branch.branch_name}}</td>
                                                    <td class="">{{bank_account.branch.branch_code}}</td>
                                                    <td class="">{{bank_account.account_title}}</td>
                                                    <td class="">{{bank_account.account_number}}</td>
                                                    <td class="">
                                                        <span v-if="bank_account.status">Active</span>
                                                        <span v-else>Inactive</span>
                                                    </td>
                                                    <td class="">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a data-toggle="modal" data-target="#userModal" class="btn-link">Edit</a>&nbsp;&nbsp;
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+indexss" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+indexss">
                                                                    <a class="dropdown-item">Edit</a>
                                                                    <a class="dropdown-item">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr v-if="banks.length < 1">
                                                    <td colspan="8" class="text-center cl-red">No bank to display</td>
                                                </tr>
                                            </tbody>
                                        </table>

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
    import SideBarBank from "../../partials/sidebars/SideBarBank";
    import BankModal from "../../partials/modals/banks/BankModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import DeleteModal from '../../partials/modals/DeleteModal';
    import {get} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Loading from "../../../../../components/loads/ProgRess";
    import Auth from "../../../../../store/auth";
    import {formatMoney} from "../../../../../helpers/functionmixin";
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarBank,Loading,DeleteModal,BankModal,ProcessingOverlay},
        data(){
            return {
                banks: [],
                bank_accounts: [],
                bank_branches: [],
                page_loaded: false,
                progress_overlay: "hide",
                initialUrl: "/api/accounts/banks",
            }
        },
        methods: {
            formatMoneys(money_to){
                return formatMoney(money_to)
            },
            loadBankAccounts(){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/accounts/banks/practices/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results;
                        console.info(this.bank_accounts);
                        //this.page_loaded = true;
                        //this.progress_overlay = "hide";
                        this.loadBanks();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },
            loadBanks(){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/accounts/banks')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.banks = res.data.results;
                        console.info(this.banks);
                        this.loadBranches();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },
            loadBranches(){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/accounts/banks/branches')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_branches = res.data.results;
                        console.info(this.bank_branches);
                        this.page_loaded = true;
                        this.progress_overlay = "hide";
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadBankAccounts();
        }
    }
</script>