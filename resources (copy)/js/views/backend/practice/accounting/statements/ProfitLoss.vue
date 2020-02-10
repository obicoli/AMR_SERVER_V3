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
                                                        Profit & Loss
                                                    </a>
                                                    <div class="width-30-pc float-right text-right">
                                                        <div class=" width-40-pc mg-bottom-10 float-right text-right">
                                                            <div class="btn-group float-right" role="group">
                                                                <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Report Options
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <!-- <a @click="toggleCollapse('add_widget')" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-cog"></i> Widget Settings</a>
                                                                    <a data-toggle="collapse" data-target=".multi-collapse" class="dropdown-item pointer-cursor fs-12"><i class="fa fa-window-maximize"></i> Maximize/Minimize Widgets</a>
                                                                    <a class="dropdown-item pointer-cursor fs-12"><i class="fa fa-question-circle-o"></i> Help Centre</a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-10">

                                                    <div v-if="enabled_widgets===0" class="alert alert-danger fs-12 width-99-pc"><strong>Coming soon...</strong> </div>
                                                    
                                                    <form @submit.prevent="saveWidgets" v-if="add_widget" class="width-99-pc mg-bottom-10 float-left mg-right-10 report-card bg-white">
                                                        <div class="report-card-body width-100-pc float-left padding-10 min-height-400">
                                                            
                                                        </div>
                                                    </form>

                                                    

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
    import {formatMoney, createHtmlErrorString,removeElement} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS,DASHBOARD_REPORTS} from "../../../../../helpers/process_status";
    import {CUSTOMERS_DASHBOARD_API,PRACTICES_DASHBOARD_API} from '../../../../../router/api_routes';
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