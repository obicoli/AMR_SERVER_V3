<template>

    <div>

        <processing-overlay :message="'Initializing. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">
                
                <div class="col-md-12 col-lg-12 col-sm-12">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-40-pc">
                                    <h5 class="fs-16 fw-600">
                                        SVS Dashboard Report
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="padding-bottom-10 padding-left-30 mg-top-15 padding-right-30 bg-foo padding-top-10">
                        <div class="location-filter width-100-pc text-right mg-top-30 mg-bottom-30">

                            <span class="indicator cl-amref fs-13 float-left">Langata Campus <i class="fa fa-arrow-right"></i> Drug <i class="fa fa-arrow-right"></i> ARV <i class="fa fa-arrow-right"></i> Expired</span>
                            
                            <div  class="btn-group float-right" role="group" aria-label="Button group">
                                <a data-toggle="modal" class="btn-link pointer-cursor cl-444">Last 30 Days</a>&nbsp;&nbsp;
                                <div class="btn-group" role="group">
                                    <a class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item pointer-cursor"> Last 15 minutes</a>
                                        <a class="dropdown-item pointer-cursor"> Last 6 hours</a>
                                        <a class="dropdown-item pointer-cursor"> Last 24 hours</a>
                                        <a class="dropdown-item pointer-cursor"> Last 7 days</a>
                                        <a class="dropdown-item pointer-cursor"> Last 30 days</a>
                                        <a class="dropdown-item pointer-cursor"> This week</a>
                                        <a class="dropdown-item pointer-cursor"> Last week</a>
                                        <a class="dropdown-item pointer-cursor"> This month</a>
                                        <a class="dropdown-item pointer-cursor"> Last month</a>
                                        <a class="dropdown-item pointer-cursor"> Select range</a>
                                    </div>
                                </div>
                            </div>

                            <div class="btn-group float-right mg-right-10" role="group" aria-label="Button group with nested dropdown" style="box-shadow: inset 0 -1px 0 #DFDFDF;">
                                <button data-toggle="modal" data-target="#filter_modal_id" type="button" class="btn combo-button combo-default">Account Selector</button>
                            </div>

                        </div>
                    </div>

                    <div class="padding-left-30 padding-right-30 bg-foo padding-bottom-30">
                        <am-draw-line v-if="data_loaded" :chart_value="chart_data"></am-draw-line>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="padding-top-10 padding-bottom-10 padding-left-30 padding-left-10 padding-right-30 padding-right-10 bg-foo">
                        <location-stock-out v-if="data_loaded" :stock_out_items="stock_out_items" :title="'Top 10 Items Reported out of Stock(Overall)'"></location-stock-out>
                    </div>
                </div>
            </div>

            <filter-modal v-if="data_loaded" :modal_id="'filter_modal_id'" :title="'Account Selector'" :categories="categories" :facilities="facilities" :product_types="product_types"></filter-modal>

        </div>
    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import AmDrawLine from '../../../../analytics/AmDrawLine';
    //import AmOutStock from '../../../../analytics/AmOutStock';
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import LocationStockOut from '../../../../maps/LocationStockOut';
    import ShowLine from '../../../../analytics/ShowLine';
    import FilterModal from '../partials/modals/FilterModal';
    import {get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config"
    import { PRODUCT_CATEGORIES_URL,FACILITY_URL,PRODUCT_TYPES_URL } from './../../../../router/api_routes'

    export default {
        name: "FacilityHome",
        components: {TopNavBar, SideBar,ShowLine,AmDrawLine,LocationStockOut,ProcessingOverlay,FilterModal},
        data(){
            return {
                practice_id: '',
                chart_data: [],
                chart_data2: [],

                categories:[],
                facilities:[],
                product_types:[],

                stock_out_items: [],
                processing: false,
                data_loaded: false,
                default_range: 'Last 30 Days',
                progress_overlay: 'hide',
            }
        },
        methods: {

            loadAnalytic(){
                this.processing = true;
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/'+'ICC')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.chart_data = res.data.results.stock_movement;
                        this.chart_data2 = res.data.results.stock_out;
                        this.stock_out_items = res.data.results.stock_out_items;
                        this.data_loaded = true;
                        //this.progress_overlay = "hide";
                        this.loadCategories();
                    }
                }).catch((err) => {
                    this.processing = false;
                    this.progress_overlay = "hide";
                });
            },

            loadCategories(){
                //this.progress_overlay = "show";
                get(PRODUCT_CATEGORIES_URL+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.categories = res.data.results;
                        //console.info(this.categories);
                        //this.data_loaded = true;
                        this.loadFacilities();
                    }
                }).catch((err) => {
                    this.processing = false;
                    this.progress_overlay = "hide";
                });
            },

            loadFacilities(){
                //this.progress_overlay = "show";
                get(FACILITY_URL+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.facilities = res.data.results;
                        //console.info(this.facilies);
                        this.loadTypes();
                    }
                }).catch((err) => {
                    this.processing = false;
                    this.progress_overlay = "hide";
                });
            },

            loadTypes(){
                //this.processing = true;
                //this.progress_overlay = "show";
                get(PRODUCT_TYPES_URL+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.product_types = res.data.results;
                        //console.info(this.product_types);
                        this.data_loaded = true;
                        this.progress_overlay = "hide";
                    }
                }).catch((err) => {
                    this.processing = false;
                    this.progress_overlay = "hide";
                });
                //this.progress_overlay = "hide";
            }
        },
        
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            console.info(this.practice_id);
            this.loadAnalytic();
        }
    }
</script>

<style scoped>
    @import "../../../../../sass/style.css";
</style>