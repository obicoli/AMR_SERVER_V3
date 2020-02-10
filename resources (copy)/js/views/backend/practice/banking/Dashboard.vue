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
                                            <div class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a class="fw-600 cl-34 fs-20">
                                                        Finance Dashboard
                                                    </a>
                                                </div>
                                                <div v-if="page_loaded" class="width-100-pc float-left mg-top-20">

                                                    <div v-for="(wid_list, index) in widget_lists" :key="'widget_list'+index" class="width-49-pc mg-right-5 float-left">
                                                        <div class="width-100-pc mg-bottom-5 float-left report-card bg-white">
                                                            <div class="report-card-header width-100-pc float-left height-30-px padding-left-10 padding-right-10 padding-top-5">
                                                                <div class="width-60-pc float-left"><label class="cl-43 fs-12  fw-600">{{wid_list.name}}</label></div>
                                                                <div class="width-40-pc float-right report-card-action text-right">
                                                                </div>
                                                            </div>
                                                            <div class="collapse show multi-collapse report-card-body width-100-pc float-left min-height-240 max-height-240 padding-top-30" :id="'to_do_list_'+wid_list.id">
                                                                <div class="width-100-pc float-left">
                                                                    <!-- <div v-if="current_card===wid_list.id" class="text-center width-100-pc float-left"><img class="loader" src="/assets/icons/dashboard/loader.gif"></div> -->
                                                                    <div class="text-center width-100-pc float-left">
                                                        
                                                                        <!-- 1. Check report type here -->
                                                                        <div v-if="wid_list.name===DASHBOARD_REPORTS.CUSTOMER_OUTSTANDING_BALANCE" class="text-center width-100-pc float-left">
                                                                            <apex-pie v-if="customer_outstanding_balance" :reported_data="customer_outstanding_balance" :key="'report_render_'+wid_list.id"></apex-pie>
                                                                            <div v-else class="text-center width-100-pc float-left">
                                                                                <img  class="no-report-icon" src="/assets/icons/dashboard/reports.png"><br>
                                                                                <label class="cl-amref fs-12">No data to display report</label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Check report type here -->

                                                                        <!--2.  Check report type here -->
                                                                        <div v-else-if="wid_list.name===DASHBOARD_REPORTS.SALES_HISTORY" class="text-center width-100-pc float-left">
                                                                            <apex-pie v-if="sales_history_report" :reported_data="customer_outstanding_balance" :key="'report_render_'+wid_list.id"></apex-pie>
                                                                            <div v-else class="text-center width-100-pc float-left">
                                                                                <img  class="no-report-icon" src="/assets/icons/dashboard/reports.png"><br>
                                                                                <label class="cl-amref fs-12">No data to display report</label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Check report type here -->

                                                                        <!--3. Check report type here -->
                                                                        <div v-else-if="wid_list.name===DASHBOARD_REPORTS.BANKING" class="text-center width-100-pc float-left">
                                                                            <apex-pie v-if="banking_report" :reported_data="customer_outstanding_balance" :key="'report_render_'+wid_list.id"></apex-pie>
                                                                            <div v-else class="text-center width-100-pc float-left">
                                                                                <img  class="no-report-icon" src="/assets/icons/dashboard/reports.png"><br>
                                                                                <label class="cl-amref fs-12">No data to display report</label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Check report type here -->

                                                                        <!--4. Check report type here -->
                                                                        <div v-else-if="wid_list.name===DASHBOARD_REPORTS.PROFIT_LOSS" class="text-center width-100-pc float-left">
                                                                            <apex-pie v-if="p_l_report" :reported_data="customer_outstanding_balance" :key="'report_render_'+wid_list.id"></apex-pie>
                                                                            <div v-else class="text-center width-100-pc float-left">
                                                                                <img  class="no-report-icon" src="/assets/icons/dashboard/reports.png"><br>
                                                                                <label class="cl-amref fs-12">No data to display report</label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Check report type here -->

                                                                        <!-- Check report type here -->
                                                                        <div v-else class="text-center width-100-pc float-left">
                                                                            <apex-pie v-if="to_do_list_report" :reported_data="customer_outstanding_balance" :key="'report_render_'+wid_list.id"></apex-pie>
                                                                            <div v-else class="text-center width-100-pc float-left">
                                                                                <img  class="no-report-icon" src="/assets/icons/dashboard/reports.png"><br>
                                                                                <label class="cl-amref fs-12">No data to display report</label>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Check report type here -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="width-49-pc mg-bottom-20 float-left bg-white padding-10 min-height-250">
                                                        <label class="cl-43 fs-15 fw-600">Top Customers by Outstanding Balance</label>
                                                        <apex-pie v-if="page_loaded" :reported_data="outstanding_balance"></apex-pie>
                                                    </div>
                                                    <div class="width-49-pc float-right mg-bottom-20 bg-white padding-10 min-height-250">
                                                        <label class="cl-43 fs-15 fw-600">Customer Balances - Days Outstanding</label>
                                                        <apexchart width="400" type="bar" :options="options" :series="series"></apexchart>
                                                    </div>
                                                    <div class="width-49-pc float-left mg-bottom-20 bg-white padding-10 min-height-250">
                                                        <label class="cl-43 fs-15 fw-600">Top Customers by Sales</label>
                                                        <apexchart width="400" type="bar" :options="options" :series="series"></apexchart>
                                                    </div>
                                                    <div class="width-49-pc float-right mg-bottom-20 bg-white padding-10 min-height-250">
                                                        <label class="cl-43 fs-15 fw-600">Customer Reports</label>
                                                        <apexchart width="400" type="bar" :options="options" :series="series"></apexchart>
                                                    </div> -->

                                                </div>
                                                <div v-else class="width-100-pc float-left mg-top-20 text-center">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
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
                    <copy-right></copy-right>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import CopyRight from "../partials/CopyRight";
    import ApexBar from "../../../../analytics/apex/ApexBar";
    import ApexPie from "../../../../analytics/apex/ApexPie";
    import ApexDonut from "../../../../analytics/apex/ApexDonut";

    import {get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import {formatMoney} from "../../../../helpers/functionmixin";
    import {PROCESS_STATUS,DASHBOARD_REPORTS} from "../../../../helpers/process_status";
    import {CUSTOMERS_DASHBOARD_API,PRACTICES_DASHBOARD_API} from '../../../../router/api_routes';
    export default {
        name: "Dashboard",
        components: {TopNavBar,SideBar,ApexBar,ApexPie,ApexDonut,CopyRight},
        data(){
            return {
                page_loaded: false,
                processing: false,
                is_initializing: false,
                dashboard_data:{},
                outstanding_balance: {},
                options: {
                    chart: {
                    id: 'vuechart-example'
                    },
                    xaxis: {
                        categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998], //This represents days
                    }
                },
                series: [{
                    name: 'Days',
                    data: [30, 40, 45, 50, 49, 60, 70, 91] //This represents days
                }],

                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                widget_lists: [],
                DASHBOARD_REPORTS: DASHBOARD_REPORTS,
                to_do_list_report: null,
                customer_outstanding_balance: null,
            }
        },
        methods: {

            format_Money(money_to){
                return formatMoney(money_to);
            },

            loadWidgets(status_loader=true){
                this.processing = true;
                this.is_initializing = true;
                get(PRACTICES_DASHBOARD_API+'?report_type=Banking Widgets')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.widget_lists = res.data.results[0].data;
                        console.info(this.widget_lists);
                        this.processing = false;
                        this.is_initializing = false;
                        this.page_loaded = true;
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                    this.is_initializing = false;
                });
            },

            loadDashboard(show_progress){
                get(CUSTOMERS_DASHBOARD_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        // this.dashboard_data = res.data.results
                        //  console.info(this.dashboard_data);
                        this.outstanding_balance = res.data.results.outstanding_balance
                        this.page_loaded = true;
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
            this.loadWidgets(true);
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>