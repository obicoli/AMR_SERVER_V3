<template>
    <div>
        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">
                
                <div class="col-md-12 col-lg-12 col-sm-12">

                    <div class="settings-header  main-heading bg-foo">
                        
                    </div>

                    <div class="padding-top-10 padding-bottom-10 padding-left-30 mg-top-35 padding-right-30 bg-foo">
                        <am-draw-line v-if="data_loaded" :chart_value="chart_data"></am-draw-line>
                    </div>

                    <!-- <div class="bg-foo padding-top-10 mg-top-27">
                        <am-draw-line v-if="data_loaded" :chart_value="chart_data"></am-draw-line>
                    </div> -->
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="padding-top-10 padding-bottom-10 padding-left-10 padding-right-10 bg-foo">
                        <location-stock-out v-if="data_loaded" :stock_out_items="stock_out_items" :title="'Top 10 Items Reported out of Stock(Overall)'"></location-stock-out>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import AmDrawLine from '../../../../analytics/AmDrawLine';
    //import AmOutStock from '../../../../analytics/AmOutStock';
    import LocationStockOut from '../../../../maps/LocationStockOut';
    import ShowLine from '../../../../analytics/ShowLine';
    import {get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";

    export default {
        name: "FacilityHome",
        components: {TopNavBar, SideBar,ShowLine,AmDrawLine,LocationStockOut},
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
    @import "../../../../../sass/style.css";
</style>