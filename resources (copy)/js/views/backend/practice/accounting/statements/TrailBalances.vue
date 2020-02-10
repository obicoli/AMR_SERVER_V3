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
                                            <div class="col-md-8 col-lg-8 padding-right-0 border-bottom">
                                                <div class="width-99-pc float-left">
                                                    <a class="fw-600 cl-34 fs-20">
                                                        Trial Balance
                                                    </a>
                                                    <div class="width-30-pc float-right text-right">
                                                        <div class=" width-40-pc mg-bottom-10 float-right text-right">
                                                            <button type="button" @click="toggleOptions()" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2" :class="{'btn btn-secondary float-right':true,'banking-process-amref':!show_opt,'banking-process':show_opt}">
                                                                <span v-if="show_opt" class="cl-444">Hide Report Options</span>
                                                                <span v-else>Show Report Options</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="page_loaded" class="width-100-pc float-left">
                                                    <div :class="{'width-100-pc float-left collapse multi-collapse padding-10':true,'in':show_opt,'out':!show_opt}" id="multiCollapseExample2">
                                                        <div class="row justify-content-center">
                                                            <div class="col-md-7 col-lg-7">
                                                                <div class="width-100-pc float-left padding-20">
                                                                    <div class="width-100-pc float-left mg-bottom-5 mg-left-30">
                                                                        <div class="width-20-pc text-right float-left">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Report Period:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="width-25-pc float-left">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <select :disabled="is_initializing" v-model="report_options.frequency">
                                                                                    <option value="1">Today</option>
                                                                                    <option value="3">This week</option>
                                                                                    <option value="6">This week to date</option>
                                                                                    <option value="12">This month</option>
                                                                                    <option value="12">This month to date</option>
                                                                                    <option value="12">This Quarter</option>
                                                                                    <option value="12">This Quarter to date</option>
                                                                                    <option value="12">This year</option>
                                                                                    <option value="12">This year to date</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="width-25-pc float-left mg-left-5">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <datetime
                                                                                    v-model="report_options.start_date"
                                                                                    :input-id="'date_input_1111'"
                                                                                    placeholder="From date"
                                                                                    use12-hour
                                                                                    :type="'date'"
                                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                    :value="report_options.start_date"
                                                                                    >
                                                                                </datetime>
                                                                            </div>
                                                                        </div>
                                                                        <div class="width-25-pc float-left mg-left-5">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <datetime
                                                                                    v-model="report_options.end_date"
                                                                                    :input-id="'date_input_1100'"
                                                                                    placeholder="To date"
                                                                                    use12-hour
                                                                                    :type="'date'"
                                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                    :value="report_options.end_date"
                                                                                    >
                                                                                </datetime>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left mg-bottom-5 mg-left-30">
                                                                        <div class="width-20-pc text-right float-left">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Basis:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="width-50-pc float-left fs-12">
                                                                            <input type="radio" :disabled="is_initializing" value="Accrual" class="pointer-cursor" v-model="report_options.basis"> Accrual.&nbsp;
                                                                            <input type="radio" :disabled="is_initializing" value="Cash" class="pointer-cursor" v-model="report_options.basis"> Cash.&nbsp;
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left mg-bottom-5 mg-left-30">
                                                                        <div class="width-20-pc text-right float-left">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Show:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="width-50-pc float-left fs-12">
                                                                            <input type="radio" :disabled="is_initializing" value="Closing Balances" class="pointer-cursor" v-model="report_options.balance_option"> Closing Balances.&nbsp;
                                                                            <input type="radio" :disabled="is_initializing" value="Movement" class="pointer-cursor" v-model="report_options.balance_option"> Movement.&nbsp;
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left mg-bottom-5 mg-left-30">
                                                                        <div class="width-20-pc text-right float-left">
                                                                            <label class="company-label text-right fs-12 width-100-pc">Compare with:&nbsp;&nbsp;</label>
                                                                        </div>
                                                                        <div class="width-50-pc float-left fs-12">
                                                                            <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.comparison"> Last Year.&nbsp;
                                                                        </div>
                                                                        <div class="width-30-pc float-left fs-12">
                                                                            <button @click="loadTrail(true)" type="button" class="btn btn-secondary banking-process-amref float-right">Run Report</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="page_loaded" class="width-100-pc float-left">
                                                    <div v-if="processing" class="width-100-pc float-left mg-top-10 text-center">
                                                        <img class="loader mg-top-170" src="/assets/icons/dashboard/loader.gif">
                                                    </div>
                                                    <div v-else-if="ledgers.length>0 && processing===false" class="width-100-pc float-left mg-top-10">
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-100-pc float-left action-icons mg-bottom-5">
                                                                <div @click="printReport('trial_balance_id')" class="exportPDF icon pointer-cursor float-left" title="Export report to PDF"></div>
                                                                <div class="exportXLS icon pointer-cursor float-left" title="Export report to XLS"></div>
                                                                <div class="exportCSV icon pointer-cursor float-left" title="Export report to CSV"></div>
                                                                <div @click="printReport('trial_balance_id')" class="printReport icon pointer-cursor float-left" title="Print Report"></div>
                                                                <div class="emailReport icon pointer-cursor float-left" title="Email Report"></div>
                                                            </div>
                                                        </div>
                                                        <form class="width-99-pc mg-bottom-10 float-left mg-right-10 report-card bg-white" id="trial_balance_id">
                                                            <div class="report-card-body width-100-pc float-left padding-10 min-height-400">
                                                                <div class="width-90-pc mg-left-5-pc float-left text-center mg-top-20 padding-10">
                                                                    <h3 class="fw-600 txt-uppercase fs-11">AMREF ENTERPRISES | AMREF HEALTH AFRICA</h3>
                                                                    <h3 class="fw-600 txt-uppercase fs-11">Amref Wilson Airport</h3>
                                                                    <h3 class="fw-600 txt-uppercase fs-14 cl-444"><b>Trial Balance</b></h3>
                                                                    <small class="fs-11">{{as_at}}</small>
                                                                </div>
                                                                <div class="width-90-pc float-left mg-left-5-pc">
                                                                    <table class="ledger-report-table-custom table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width:50%" class="dotted">Account Title</th>
                                                                                <th style="width:25%" class="text-right dotted">Debit</th>
                                                                                <th style="width:25%" class="text-right">Credit</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr v-for="(ledger,index) in ledgers" class="reporting-table no-border" :key="'ledgers'+index">
                                                                                <td><a>{{ledger.name}}</a></td>
                                                                                <td class="text-right debited-td cl-444"><a v-if="ledger.account_type.accounts_nature.name===assets || ledger.account_type.accounts_nature.name===expense">{{format_Money(ledger.balance)}}</a></td>
                                                                                <td class="text-right credited-td cl-444"><a v-if="ledger.account_type.accounts_nature.name===liability || ledger.account_type.accounts_nature.name===revenue || ledger.account_type.accounts_nature.name===equity">{{format_Money(ledger.balance)}}</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="fw-600 cl-444">Total</td>
                                                                                <td class="text-right custom-total">{{CURRENCY}}{{format_Money(total_debit)}}</td>
                                                                                <td class="text-right custom-total">{{CURRENCY}}{{format_Money(total_credit)}}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="width-90-pc float-left mg-left-5-pc mg-top-20 text-center">
                                                                    <hr>
                                                                    <small class="fs-11 txt-italic fw-600">{{footer_title}}</small>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div v-else class="width-100-pc float-left mg-top-10 text-center">
                                                        <img class="no-data-report" src="/assets/icons/dashboard/reports.png"><br>
                                                        <p class="fs-12 cl-amref">This report does not have data to display!</p>
                                                    </div>
                                                </div>
                                                <div v-else class="width-100-pc float-left mg-top-10 text-center">
                                                    <img class="loader mg-top-20" src="/assets/icons/dashboard/loader.gif">
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
    import CopyRight from "../../partials/CopyRight";

    import ApexBar from "../../../../../analytics/apex/ApexBar";
    import ApexPie from "../../../../../analytics/apex/ApexPie";
    import ApexDonut from "../../../../../analytics/apex/ApexDonut";

    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {formatMoney, createHtmlErrorString,removeElement, format_lunox_date, printing} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS,DASHBOARD_REPORTS, ACCOUNTING} from "../../../../../helpers/process_status";
    import {ACCOUNTS_TRAIL} from '../../../../../router/api_routes';
    export default {
        name: "DashboardHome",
        components: {TopNavBar,SideBar,ApexBar,ApexPie,ApexDonut,ProcessingOverlay,CopyRight},
        data(){
            return {
                total_debit: 0,
                total_credit: 0,
                processing: false,
                is_initializing: false,
                show_opt: true,
                ACCOUNTING:ACCOUNTING,
                practice_id: '',
                facility_name: '',
                progress_overlay: 'hide',
                page_loaded: false,
                ledgers: [],
                as_at: '',
                footer_title: '',
                CURRENCY: ACCOUNTING.CURRENCY,
                assets: ACCOUNTING.ACCOUNT_NATURES.ASSETS,
                expense: ACCOUNTING.ACCOUNT_NATURES.EXPENSE,
                liability: ACCOUNTING.ACCOUNT_NATURES.LIABILITY,
                revenue: ACCOUNTING.ACCOUNT_NATURES.REVENUE,
                equity: ACCOUNTING.ACCOUNT_NATURES.EQUITY,
                report_options:{
                    frequency: null,
                    start_date: null,
                    end_date: null,
                    basis: 'Accrual',
                    balance_option: 'Closing Balances',
                    comparison: false,
                },
                filters: null,
            }
        },
        methods: {

            printReport(report_id){
                printing(report_id);
            },

            toggleOptions(){
                if(this.show_opt){
                    this.show_opt = false;
                }else{
                    this.show_opt = true;
                }
            },

            loadTrail(filtered=false){
                let trial_api = ACCOUNTS_TRAIL;
                if(filtered){
                    trial_api = trial_api+'?filters='+JSON.stringify(this.report_options);
                }
                this.processing = true;
                get(trial_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.footer_title = res.data.results.footer_title;
                        this.filters = res.data.results.filters;
                        this.ledgers = res.data.results.data.transactions;
                        this.total_credit = res.data.results.data.total_credit;
                        this.total_debit = res.data.results.data.total_debit;
                        this.as_at = res.data.results.as_at;
                        this.facility = res.data.results.facility;
                        this.report_options.start_date = format_lunox_date(this.filters.start);
                        this.report_options.end_date = format_lunox_date(this.filters.end);
                        this.show_opt = true;
                        this.page_loaded = true;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.processing = false;
                });
            },

            format_Money(money_to){
                return formatMoney(money_to);
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }

        },
        mounted() {
            this.loadTrail();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>