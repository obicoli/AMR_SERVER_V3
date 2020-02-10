<template>
    <div>
        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="settings-header shadowed  main-heading bg-foo">
                        <a class="btn-link">{{default_range}}</a>&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <a id="btnGroupDrop" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu right-0-0" aria-labelledby="btnGroupDrop">
                                <a class="dropdown-item" >Last 15 Minutes</a>
                                <a class="dropdown-item" >Last 6 Hours</a>
                                <a class="dropdown-item" >Last 24 Hours</a>
                                <a class="dropdown-item separator"></a>
                                <a class="dropdown-item" >Last 7 Days</a>
                                <a class="dropdown-item" >Last 30 Days</a>
                                <a class="dropdown-item separator"></a>
                                <a class="dropdown-item" >This week</a>
                                <a class="dropdown-item" >Last week</a>
                                <a class="dropdown-item separator"></a>
                                <a class="dropdown-item" >This month</a>
                                <a class="dropdown-item" >Last month</a>
                                <a class="dropdown-item separator"></a>
                                <a class="dropdown-item" >Select range</a>
                            </div>
                        </div>
                    </div>

                    <div class="padding-top-10 padding-bottom-10 padding-left-10 mg-top-35 padding-right-10 bg-foo">
                        <am-draw-line v-if="data_loaded" :chart_value="chart_data"></am-draw-line>
                    </div>

                    <div class="padding-top-10 padding-bottom-10 padding-left-10 padding-right-10 bg-foo">
                        <am-out-stock v-if="data_loaded" :title="'Top 10 Items Reported Out of Stock: (Overall)'" :chart_value="chart_data2" :stock_out_item="stock_out_items"></am-out-stock>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "./partials/sidebars/SideBar"
    import TopNavBar from "./partials/topbars/TopNavBar"
    import AmDrawLine from '../../../analytics/AmDrawLine'
    import AmOutStock from '../../../analytics/AmOutStock'
    import ShowLine from '../../../analytics/ShowLine'
    import {get} from "../../../helpers/api";
    import Auth from "../../../store/auth";
    import AppInfo from "../../../helpers/config";

    export default {
        name: "FacilityHome",
        components: {TopNavBar, SideBar,ShowLine,AmDrawLine,AmOutStock},
        data(){
            return {
                practice_id: '',
                chart_data: [],
                chart_data2: [],
                stock_out_items: [],
                processing: false,
                data_loaded: false,
                default_range: 'Last 30 Days',
            }
        },
        methods: {
            loadAnalytic(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/'+'ICC')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.chart_data = res.data.results.stock_movement;
                            this.chart_data2 = res.data.results.stock_out;
                            this.stock_out_items = res.data.results.stock_out_items;
                            console.info(this.stock_out_items);
                            this.processing = false;
                            this.data_loaded = true;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            }
        },
        mounted() {
            this.practice_id = Auth.getCurrentBranch().id;
            console.info(this.practice_id);
            this.loadAnalytic();
        }
    }
</script>

<style scoped>
    @import "../../../../sass/style.css";
</style>