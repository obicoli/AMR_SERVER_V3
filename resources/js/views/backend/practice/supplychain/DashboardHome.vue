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
                                                <div class="width-99-pc float-left">
                                                    <a class="fw-600 cl-34 fs-20">
                                                        Dashboard
                                                    </a>
                                                    <div class="width-30-pc float-right text-right">
                                                        <div class=" width-40-pc mg-bottom-10 float-right text-right">
                                                            <div class="btn-group float-right" role="group">
                                                                <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Dashboard Options
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a @click="toggleCollapse('add_widget')" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-cog"></i> Widget Settings</a>
                                                                    <a data-toggle="collapse" data-target=".multi-collapse" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-window-maximize"></i> Maximize/Minimize Widgets</a>
                                                                    <a class="dropdown-item pointer-cursor fs-12"><i class="fa fa-question-circle-o"></i> Help Centre</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-10">

                                                    <div v-if="enabled_widgets===0" class="alert alert-danger fs-12 width-99-pc"><strong>Add Widgets!</strong> No dashboard widget is active. Enable them by checking the boxes and then "Save Changes"</div>
                                                    
                                                    <form @submit.prevent="saveWidgets" v-if="add_widget" class="width-99-pc mg-bottom-10 float-left mg-right-10 report-card bg-white">
                                                        <div class="report-card-body width-100-pc float-left padding-10">
                                                            <div v-for="(widget,index) in widgets" class="width-25-pc float-left min-height-180" :key="'widgets_'+index">
                                                                <h4 class="fs-12 fw-600 txt-uppercase cl-43">{{widget.type}}</h4>
                                                                <label v-for="(sub_data,sub_index) in widget.data" :key="'sub_sub_pammissio'+sub_index" class="check-container small element-inlined fs-12 role-label-fw-normal width-100-pc mg-right-10">{{sub_data.name}}
                                                                    <input type="checkbox" :value="sub_data.id" v-model="form.widgets">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div v-if="processing" class="width-100-pc float-left text-center">
                                                                <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                            </div>
                                                            <div v-else class="width-100-pc float-left text-center">
                                                                <button :disabled="is_initializing || widgets.length===0" type="submit" class="btn btn-secondary banking-process-amref">Save Changes</button>
                                                                <button :disabled="is_initializing" @click="toggleCollapse('hide_widgets')" type="button" class="btn btn-secondary banking-process">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div v-for="(wid_list, index) in widget_list" :key="'widget_list'+index" class="width-49-pc mg-right-5 float-left">
                                                        <div v-if="wid_list.status" class="width-100-pc mg-bottom-5 float-left report-card bg-white">
                                                            <div class="report-card-header width-100-pc float-left height-30-px padding-left-10 padding-right-10 padding-top-5">
                                                                <div class="width-60-pc float-left"><label class="cl-43 fs-12  fw-600">{{wid_list.name}}</label></div>
                                                                <div class="width-40-pc float-right report-card-action text-right">
                                                                    <a data-toggle="collapse" :data-target="'#to_do_list_'+wid_list.id" class="mg-right-10 fs-12 pointer-cursor">
                                                                        <i title="Minimize" class="fa fa-window-maximize"></i>
                                                                    </a>
                                                                    <a class="mg-right-10 fs-12 pointer-cursor" title="Refresh"><i class="fa fa-refresh"></i></a>
                                                                    <a @click="saveWidgets(wid_list.id)" class="fs-14 pointer-cursor" title="Remove Widget">x</a>
                                                                </div>
                                                            </div>
                                                            <div class="collapse show multi-collapse report-card-body width-100-pc float-left min-height-240 max-height-240 padding-top-30" :id="'to_do_list_'+wid_list.id">
                                                                <div class="width-100-pc float-left">
                                                                    <div v-if="current_card===wid_list.id" class="text-center width-100-pc float-left"><img class="loader" src="/assets/icons/dashboard/loader.gif"></div>
                                                                    <div v-else class="text-center width-100-pc float-left">
                                                        
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

                                                    <!-- <div class="width-49-pc float-left mg-bottom-10 bg-white padding-10 min-height-270 max-height-270">
                                                        <label class="cl-43 fs-15 fw-600">Banking</label>
                                                        <apexchart width="400" type="bar" :options="options" :series="series"></apexchart>
                                                    </div>

                                                    <div class="width-49-pc float-left mg-bottom-10 bg-white padding-10 min-height-250">
                                                        <label class="cl-43 fs-15 fw-600">Sales History</label>
                                                        <apexchart width="400" type="bar" :options="options" :series="series"></apexchart>
                                                    </div>

                                                    <div class="width-49-pc float-right mg-bottom-10 bg-white padding-10 min-height-250">
                                                        <label class="cl-43 fs-15 fw-600">Top Customers by Sales</label>
                                                        <apexchart width="400" type="bar" :options="options" :series="series"></apexchart>
                                                    </div> -->

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
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import CopyRight from "../partials/CopyRight";

    import ApexBar from "../../../../analytics/apex/ApexBar";
    import ApexPie from "../../../../analytics/apex/ApexPie";
    import ApexDonut from "../../../../analytics/apex/ApexDonut";

    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import {formatMoney, createHtmlErrorString,removeElement} from "../../../../helpers/functionmixin";
    import {PROCESS_STATUS,DASHBOARD_REPORTS} from "../../../../helpers/process_status";
    import {CUSTOMERS_DASHBOARD_API,PRACTICES_DASHBOARD_API} from '../../../../router/api_routes';
    export default {
        name: "DashboardHome",
        components: {TopNavBar,SideBar,ApexBar,ApexPie,ApexDonut,ProcessingOverlay,CopyRight},
        data(){
            return {
                current_card: 0,
                enabled_widgets: 0,
                to_do_list: true,
                to_do_load: false,
                add_widget: false,
                form: {
                    widgets: [],
                },
                //
                widgets: [],
                widget_list: [],
                page_loaded: false,
                dashboard_data:{},

                customer_outstanding_balance: null,
                to_do_list_report: null,
                p_l_report: null,
                banking_report: null,
                sales_history_report: null,

                // options: {
                //     chart: {
                //     id: 'vuechart-example'
                //     },
                //     xaxis: {
                //         categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998], //This represents days
                //     }
                // },
                // series: [{
                //     name: 'Days',
                //     data: [30, 40, 45, 50, 49, 60, 70, 91] //This represents days
                // }],

                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                is_initializing: false,
                processing: false,
                DASHBOARD_REPORTS: DASHBOARD_REPORTS,
            }
        },
        methods: {

            toggleCollapse(panel_){
                switch(panel_){
                    case "to_do_list":
                        if(this.to_do_list){this.to_do_list=false}else{this.to_do_list=true}
                        break;
                    case "add_widget":
                        this.add_widget=true
                        break;
                    case "hide_widgets":
                        this.add_widget=false
                        break
                }
            },

            loadReport(){
                for (let index = 0; index < this.widget_list.length; index++) {
                    const element = this.widget_list[index];
                    this.current_card = element.id;
                    if(element.status){
                        get(PRACTICES_DASHBOARD_API+'/reports?type='+element.name)
                        .then((res) => {
                            if(res.data.status_code === 200) {
                                switch(element.name){
                                    case DASHBOARD_REPORTS.CUSTOMER_OUTSTANDING_BALANCE:
                                        console.info(res.data.results);
                                        break;
                                }
                            }
                        }).catch((err) => {
                            this.page_loaded = true;
                            this.progress_overlay = "hide";
                            this.processing = false;
                        });
                    }
                }
                this.current_card = 0;
            },

            format_Money(money_to){
                return formatMoney(money_to);
            },

            loadTodo(initialization){
                get(CUSTOMERS_DASHBOARD_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
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

            saveWidgets(widget_id=0){

                this.processing = true;
                let url_ = PRACTICES_DASHBOARD_API;
                if(widget_id){
                    this.form.widgets = removeElement(this.form.widgets,widget_id);
                }
                post(url_,this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        //this.loadWidgets('hide');
                        window.location.reload();
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
                    this.processing = false;
                    this.is_initializing = false;
                });
            },

            loadWidgets(show_overlay="show"){
                this.progress_overlay = show_overlay;
                get(PRACTICES_DASHBOARD_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.enabled_widgets = 0;
                        this.widget_list = [];
                        this.widgets = res.data.results;
                        //console.info(this.widgets);
                        for (let index = 0; index < this.widgets.length; index++) {
                            const element = this.widgets[index];
                            //console.info(this.widgets);
                            for (let i = 0; i < element.data.length; i++) {
                                const element_data = element.data[i];
                                //console.info(element_data);
                                this.widget_list.push(element_data);
                                if(element_data.status){
                                    this.enabled_widgets += 1;
                                    this.form.widgets.push(element_data.id);
                                }
                            }
                        }
                        if(this.enabled_widgets===0){
                            this.add_widget = true;
                        }else{
                            this.add_widget = false;
                        }
                        this.page_loaded = true;
                        this.progress_overlay = "hide";
                        this.processing = false;
                        this.loadReport();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    this.page_loaded = true;
                    this.progress_overlay = "hide";
                    this.processing = false;
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
            this.loadWidgets();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>