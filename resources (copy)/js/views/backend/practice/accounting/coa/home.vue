<template>

    <div>

        <loading :is-loading="processing"></loading>

        <add-account-modal v-if="account_loaded" :form_data="account_form" :user_mode="'Create'" :initial_url="initial_url" :account_types="account_types" v-on:windowClosed="toggleAccountModal('hide')" v-on:accountAdded="loadAccounts"></add-account-modal>

        <loading :is-loading="processing"></loading>

        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <div class="settings-header main-heading bg-foo">Accounts | Charts of accounts</div>
                    <div class="ui fitted divider"></div>

                    <div class="row">

                        <div v-if="!account_loaded" class="col-lg-12">
                            <div  class="intro-page text-center">
                                <img :src="'/assets/images/chart_of_accounts.svg'">
                                <h4>See how your accounting works on the inside</h4>
                                <p>This is your <a href="" class="cl-blue-link">Chart of Accounts</a>, the list of accounts we use to organise your transactions. It's already set up and customised for you.</p>
                                <a class="btn btn-inventory">See your Chart of Accounts</a>
                            </div>
                        </div>

                        <div v-if="account_loaded" class="col-lg-9 padding-right-0 bg-eee min-height-100-vh">

                            <div class="page-content bg-white min-height-100-vh padding-right-20 padding-left-20 padding-top-20 padding-bottom-20">

                                <div class="padding-10 reportArea">

                                    <div class="text-center">
                                        <div class="companyNameRow">
                                            <div class="companyName">
                                                <span>{{org_name}}</span>
                                                <div class="pencilIcon hi hi-edit" style="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="titleRow">
                                            <div class="reportName">Account List</div>
                                            <div class="dijitInline dijitTextBox dijitValidationTextBox reportNameInput" id="widget_uniqName_21_4" role="presentation" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="companyInfoHeaderRow" style="display: none">
                                            <div style="display: none;"></div>
                                            <div>Account Office Reference: <span></span></div>
                                            <div style="display: none;">Employer's PAYE Reference: <span></span></div>
                                            <div style="display: none;">UTR Number: <span></span></div>
                                        </div>
                                        <div class="dateRangeRow"></div>
                                    </div>

                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">
                                        <div class="dgrid-hider-menu" role="dialog" aria-label="Show or hide columns" id="dgrid_120-hider-menu" style="display: none;">
                                            <div class="hiderMenuConnector"></div>
                                            <div class="hiderMenuContainer">
                                                <div class="dgrid-hider-menu-row">
                                                    <input class="dgrid-hider-menu-check hider-menu-check-2" type="checkbox" id="dgrid_120-hider-menu-check-2">
                                                    <label class="dgrid-hider-menu-label hider-menu-label-2" for="dgrid_120-hider-menu-check-2">Type</label>
                                                </div>
                                                <div class="dgrid-hider-menu-row">
                                                    <input class="dgrid-hider-menu-check hider-menu-check-3" type="checkbox" id="dgrid_120-hider-menu-check-3">
                                                    <label class="dgrid-hider-menu-label hider-menu-label-3" for="dgrid_120-hider-menu-check-3">Detail Type</label>
                                                </div>
                                                <div class="dgrid-hider-menu-row">
                                                    <input class="dgrid-hider-menu-check hider-menu-check-4" type="checkbox" id="dgrid_120-hider-menu-check-4">
                                                    <label class="dgrid-hider-menu-label hider-menu-label-4" for="dgrid_120-hider-menu-check-4">QuickBooks Balance</label>
                                                </div>
                                                <div class="dgrid-hider-menu-row">
                                                    <input class="dgrid-hider-menu-check hider-menu-check-5" type="checkbox" id="dgrid_120-hider-menu-check-5">
                                                    <label class="dgrid-hider-menu-label hider-menu-label-5" for="dgrid_120-hider-menu-check-5">Bank Balance</label>
                                                </div>
                                                <div class="dgrid-hider-menu-row settings-section-label">Other</div>
                                                <div class="dgrid-hider-menu-row">
                                                    <input type="checkbox" class="" data-qbo-bind="checked: showInactive" data-dojo-attach-point="_includeDeletedCheckbox">
                                                    <label>Include inactive</label>
                                                </div>
                                                <div class="dgrid-hider-menu-row settings-section-label">Rows</div>
                                                <div class="dgrid-hider-menu-row rows-per-page">
                                                    <div class="dijitInline dijitSelect dijitValidationTextBox dijitDownArrowButton" role="listbox" aria-haspopup="true" tabindex="0" aria-expanded="false" aria-invalid="false" style="user-select: none;">
                                                        <div class="dijitReset dijitInline dijitButtonText" data-dojo-attach-point="containerNode,textDirNode" role="presentation">
                                                            <span role="option" class="dijitReset dijitInline dijitSelectLabel dijitValidationTextBoxLabel ">150</span>
                                                        </div>
                                                        <div class="dijitReset dijitButtonNode dijitArrowButton dijitDownArrowButton" role="presentation">
                                                            <div class="dropDownImage">

                                                            </div>
                                                        </div>
                                                        <input type="hidden" data-dojo-attach-point="valueNode" value="150" aria-hidden="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dgrid-header dgrid-header-row ui-widget-header sticky-header" role="row">
                                            <table class="dgrid-row-table" role="presentation" id="dgrid_120-header">
                                                <tr>
                                                    <th class="dgrid-cell dgrid-cell-padding dgrid-column-1 field-nameEditable" role="columnheader">
                                                        <div class="dgrid-resize-header-container">
                                                            Account
                                                            <div class="dgrid-resize-handle resizeNode-1"></div>
                                                        </div>
                                                    </th>
                                                    <th class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type dgrid-sortable dgrid-focus" role="columnheader" aria-sort="none" tabindex="0">
                                                        <div class="dgrid-resize-header-container" tabindex="0">
                                                            Type<div class="dgrid-resize-handle resizeNode-2"></div>
                                                        </div>
                                                    </th>
                                                    <th class="dgrid-cell dgrid-cell-padding dgrid-column-3 field-detailType" role="columnheader">
                                                        <div class="dgrid-resize-header-container">
                                                            Detail Type
                                                            <div class="dgrid-resize-handle resizeNode-3"></div>
                                                        </div>
                                                    </th>
                                                    <th class="dgrid-cell dgrid-cell-padding dgrid-column-4 field-balance dgrid-sortable sorted_div" role="columnheader" aria-sort="descending">
                                                        <div class="dgrid-resize-header-container" tabindex="0">
                                                            Description
                                                            <div class="dgrid-sort-arrow ui-icon" role="presentation">&nbsp;</div>
                                                            <div class="dgrid-resize-handle resizeNode-4"></div>
                                                        </div>
                                                    </th>
                                                    <th class="dgrid-cell dgrid-cell-padding dgrid-column-5 field-bankBalance dgrid-sortable" role="columnheader" aria-sort="none">
                                                        <div class="dgrid-resize-header-container" tabindex="0">
                                                            Balance
                                                            <div class="dgrid-resize-handle resizeNode-5"></div>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="dgrid-scroller" tabindex="-1" style="user-select: text; margin-top: 36px; margin-bottom: 35px;">
                                            <div class="dgrid-content ui-widget-content">
                                                <div role="row" class=" dgrid-row dgrid-row-even ui-state-default" id="dgrid_120-row-78">
                                                    <table class="dgrid-row-table table-hover-tr" role="presentation">
                                                        <tr v-for="(account,index) in accounts" :key="'account'+index">
                                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name" role="gridcell" tabindex="0">
                                                                <div>{{account.name}}</div>
                                                            </td>
                                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type" role="gridcell">{{account.account_type.name}}</td>
                                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-3 field-detailType" role="gridcell">{{account.account_type_details.name}}</td>
                                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-4 field-detailType" role="gridcell">{{account.description}}</td>
                                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-4 field-balance text-right" role="gridcell">{{moneyF(account.balance)}}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="footer">
                                        <div class="text-center">
                                            <div class="footerOption"></div>
                                            <div class="footerOption"></div>
                                            <div class="footerOption">Tuesday, 28 May 2019</div>
                                            <div class="footerOption">12:44 AM GMT+03:00</div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            
                        </div>

                        <div v-if="account_loaded" class="col-lg-3 padding-left-0 bg-foo min-height-100-vh">

                            <div class="quick workdone newceb fixedheight_print">
                                <div class="header">
                                    <span class="header-title">Accounts</span>
                                    <div class="d-inline dropdown rounded-0 mx-3 float-right">
                                        <a class="dropdown-toggle" id="tools" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Menu</a>
                                        <div class="dropdown-menu dropdown-menu-right rounded-0" aria-labelledby="tools">
                                            <a @click="toggleAccountModal('show')" class="dropdown-item px-2 fs-13 pointer-cursor">Add New</a>
                                            <a class="dropdown-item px-2 fs-13 pointer-cursor" href="#">Import</a>
                                            <a class="dropdown-item px-2 fs-13 pointer-cursor" href="#">All Accounts</a>
                                        </div>
                                    </div>
                                    <a class="floatright pr_blue" style="display: none;"> Search</a>
                                </div>
                                <div class="search pr_form leftborder">
                                    <input type="text" placeholder="Search" class="">
                                </div>
                                <div class="leftborder fixedheight_print" style="height: 220.75px;">
                                    <div class="inner-quick">
                                        <div class="all-treatments ng-scope">
                                            <form name="addnewtreatment" class="">
                                                <div class="items pr_form">
                                                    <span class="search pr_form leftborder" style="display: none;">
                                                        <input type="text" required="" placeholder="Name" class="category" style="width: 50%;height: 20px;">
                                                        <span class="add-new">
                                                            <button class="btn tiny" style="padding: 6px 20px;height: 33px;margin-bottom: 2px;" disabled="disabled">Save</button>
                                                        </span>
                                                    </span>
                                                </div>
                                            </form>
                                            <div v-if="accounts.length > 0 && account_loaded" v-for="(coa, index) in accounts" class="item">
                                                <span class="category fs-13">{{coa.name}}</span>
                                                <div class="d-inline dropdown rounded-0 mx-3 float-right">
                                                    <a class="dropdown-toggle cl-white" :id="'tools'+index" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"></a>
                                                    <div class="dropdown-menu dropdown-menu-right rounded-0" :aria-labelledby="'tools'+index">
                                                        <a @click="toggleAccountModal('show')" class="dropdown-item px-2 fs-13 pointer-cursor">Account statement</a>
                                                        <a class="dropdown-item px-2 fs-13 pointer-cursor" href="#">Edit</a>
                                                        <a class="dropdown-item px-2 fs-13 pointer-cursor" href="#">Make inactive</a>
                                                        <a class="dropdown-item px-2 fs-13 pointer-cursor" href="#">Run report</a>
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

    </div>

</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import SideBarHr from "../../partials/sidebars/SideBarHr";
    import Loading from "../../../../../components/loads/ProgRess";
    import DeleteStuffModal from '../../../pharmacy/patials/DeleteStuffModal';
    import {get,post} from "../../../../../helpers/api";
    import {createHtmlErrorString,print_divs,exportToCsv,formatMoney} from "../../../../../helpers/functionmixin";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import AddAccountModal from "../partials/AddAccountModal";

    export default {
        name: "home",
        components: {TopNavBar, SideBar,SideBarHr,Loading,DeleteStuffModal,AddAccountModal},
        data(){
            return {
                org_name: '',
                practice_id: '',
                initial_url: '/api/products/accounts/charts',
                processing: false,
                account_loaded: false,
                accounts: [],
                account_natures: [],
                account_types: [],
                nature_item: {},
                current_branch: {},
                type_item: {},
                account_form: {
                    name: '',
                    description: '',
                    balance: 0,
                    as_at: '',
                    is_sub_account: false,
                    account_type_id: '',
                    account_details_id: '',
                    practice_id: '',
                },
            }
        },
        methods: {
            toggleAccountModal(action_type){
                switch (action_type) {
                    case "show":
                        document.getElementById("myNav").style.height = "100%";
                        break;
                    case "hide":
                        document.getElementById("myNav").style.height = "0%";
                        break;
                }
            },
            add_head(){
                this.processing = true;
                this.account_form.nature_id = this.nature_item.id;
                this.account_form.type_id = this.type_item.id;
                this.account_form.practice_id = this.practice_id;
                post(AppInfo.app_data.server_domain+this.initial_url,this.account_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.refresh_form();
                            this.loadAccounts();
                            this.$awn.success(res.data.description);
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.refresh_form();
                    this.processing = false;
                });
            },
            edit_head(account,subject_){
                this.processing = true;
                let url_ = this.initial_url+'/'+subject_;
                post(AppInfo.app_data.server_domain+url_,account)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.loadAccounts();
                            this.$awn.success(res.data.description);
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },

            refresh_form(){
                this.account_form.name = "";
                this.account_form.type_id = "";
                this.account_form.nature_id = "";
                this.account_form.practice_id = "";
                this.type_item = {};
                this.nature_item = {};
            },

            printThis(ele_id){
                print_divs(ele_id)
            },
            export_to_csv(){
                exportToCsv(this.categories,'Brand List')
            },
            loadAccounts(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Accounts')
                    .then((res) => {
                        //this.accounts = [];
                        if(res.data.status_code === 200) {
                            this.accounts = res.data.results.resources;
                            //console.info(this.accounts);
                            this.account_loaded = true;
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            loadAccountNature(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Account Nature')
                    .then((res) => {
                        //this.accounts = [];
                        if(res.data.status_code === 200) {
                            this.account_natures = res.data.results.resources;
                            //console.info(this.account_natures);
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            loadAccountType(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/products/accounts/types')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.account_types = res.data.results;
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            moneyF(balance){
                return formatMoney(balance,2,".",",");
            }
        },
        mounted(){
            this.current_branch = Auth.getCurrentBranch();
            this.account_form.practice_id = this.current_branch.id;
            this.practice_id = Auth.getCurrentAccount('id');
            this.org_name = Auth.jobData('org_name');
            this.loadAccounts();
            this.loadAccountNature();
            this.loadAccountType();
            this.account_loaded = true;
        }
    }
</script>

<style scoped>

</style>