<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left width-40-pc">
                                    <h5 class="fs-17 fw-600">
                                        Statements
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-accounts></side-bar-accounts>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <!-- <report-filter :title="'Profit and Loss Report'"></report-filter> -->

                                <div class="page-content bg-white min-height-100-vh padding-10 mg-top-20">

                                    <div class="row">

                                        <div class="col-lg-11">

                                            <div class="btn-group">
                                                <button data-toggle="modal" data-target="#account_modal_id" type="button" class="btn btn-amref-dark">+ New</button>
                                                <button type="button" class="btn btn-amref-dark">Import</button>
                                                <button type="button" class="btn btn-amref-dark">Email</button>
                                                <button type="button" class="btn btn-amref-dark dropdown-toggle" data-toggle="dropdown">
                                                    Export
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#" class=" fs-12">to CSV</a></li>
                                                    <li><a href="#" class=" fs-12">to PDF</a></li>
                                                </ul>
                                            </div>

                                            <div class="padding-bottom-10 padding-left-20 padding-right-20 padding-top-30 mg-top-30 reportArea">

                                                <div class="text-center mg-bottom-20">
                                                    <div class="companyNameRow">
                                                        <div class="companyName">
                                                            <span class="txt-uppercase fs-13">Amref Enterprises | Amref Health Africa</span>
                                                        </div>
                                                    </div>
                                                    <div class="titleRow">
                                                        <div class="reportName">Account List</div>
                                                    </div>
                                                    <div class="dateRangeRow fs-14">1 January - 21 June, 2019</div>
                                                </div>

                                                <coa-view v-if="page_loaded" :chart_of_accounts="chart_of_accounts"></coa-view>

                                                <div class="footer">
                                                    <div class="text-center">
                                                        <div class="footerOption"></div>
                                                        <div class="footerOption">Accrual basis Friday, 21 June 2019 05:15 PM GMT+03:00</div>
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
    import SideBar from "../../partials/sidebars/SideBar"
    import TopNavBar from "../../partials/topbars/TopNavBar"
    import SideBarAccounts from "../../partials/sidebars/accounting/SideBarAccounts"
    import ReportFilter from "../partials/ReportFilter";
    import CoaView from "../partials/CoaView";
    import AccountModal from "../../partials/modals/accounting/AccountModal";
    import {get, post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString,removeElement,formatMoney} from "../../../../../helpers/functionmixin";
    import {CHART_OF_ACCOUNTS} from "../../../../../router/api_routes";
    export default {
        name: "AccountModal",
        components: {TopNavBar,AccountModal,SideBar,SideBarAccounts,ProcessingOverlay,ReportFilter,CoaView},
        data(){
            return {
                branch_id: '',
                initialUrl: CHART_OF_ACCOUNTS,
                practice_id: '',
                progress_overlay: 'hide',
                processing: false,
                page_loaded: false,
                chart_of_accounts: [],
            }
        },
        methods: {
            loadCoa(load_progress="show"){
                this.progress_overlay = load_progress;
                get(this.initialUrl+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.chart_of_accounts = res.data.results;
                        console.info(this.chart_of_accounts);
                        this.page_loaded = true;
                        this.progress_overlay = "hide"
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide"
                });
                this.processing = false;
            }
        },
        mounted() {
            let facility = Auth.getCurrentAccount('clinic');
            this.branch_id = facility.id;
            this.practice_id = facility.id;
            this.loadCoa();

        }
    }
</script>

<style scoped>

    tbody.collapse.in {
        display: table-row-group;
    }
    
    .report-filters-inputs{
        outline: none;
        height: 32px;
        border: 1px solid #BABEC5;
        padding: 0 8px;
        border-radius: 2px;
        transition-property: border;
        transition-duration: 0.35s;
        font-size: 13px;
        background-color: #FFFFFF;
        box-sizing: border-box;
        -webkit-appearance: none;
        width: 100%;
        vertical-align: middle;
    }

    .professionalreports {
        border-width: 0 0 1px;
        border-style: dotted;
        display: inline-block;
    }

    .professionalreports {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .accordion {
        /* background-color: #eee; */
        background-color: transparent!important;
        color: #444;
        cursor: pointer;
        /* padding: 18px; */
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 14px;
        font-weight: 600!important;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        /* max-height: 0; */
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        margin-bottom: 0!important;
        -webkit-box-shadow: 0 0 0 rgba(0,0,0,0);
        box-shadow: 0 0 0 rgba(0,0,0,0);
    }

</style>