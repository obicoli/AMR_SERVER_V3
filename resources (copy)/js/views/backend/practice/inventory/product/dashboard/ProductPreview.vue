<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">Product View</div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-product :scrollable="false" :width="true" :transparent="true" :active_el="'map'" :product_id="product_id"></side-bar-product>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
<!-- 
                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20">
                                    <h3>Product View</h3>
                                </div> -->

                                <div class="page-content bg-white min-height-100-vh">

                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">

                                        <search-item-field :practice_id="practice_id" v-on:itemFound="redirect_to_item"></search-item-field>

                                        <table class="items prod-view-table-location table table-bordered width-500-px">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%;">Priority</th>
                                                    <th style="width:15%;">Color</th>
                                                    <th style="width:75%;">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Red</td>
                                                    <td>Stock out of a product</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Blue</td>
                                                    <td>A product has been out of stock for more than 21 days</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Green</td>
                                                    <td>No stock out on any product category</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-right-20" role="grid">
                                        <stock-map-view></stock-map-view>
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
    import SideBar from "../../../partials/sidebars/SideBar";
    import TopNavBar from "../../../partials/topbars/TopNavBar";
    import SideBarProduct from "../../../partials/sidebars/SideBarProduct";
    import {get} from "../../../../../../helpers/api";
    import AppInfo from "../../../../../../helpers/config";
    import Auth from "../../../../../../store/auth";
    import {formatMoney} from "../../../../../../helpers/functionmixin";
    import {PRODUCT_URL} from "../../../../../../router/api_routes";
    import ProcessingOverlay from "../../../../../progress/ProcessingOverlay";
    import SearchItemField from '../../../partials/modals/product/SearchItemField';
    import StockMapView from '../../../../../../maps/StockMapView';
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarProduct,SearchItemField,ProcessingOverlay,StockMapView},
        data(){
            return {
                product_item: {},
                progress_overlay: 'hide',
                practice_id: '',
                product_id: this.$route.params.uuid
            }
        },

        methods: {

            loadProductItem(){
                this.progress_overlay = "show";
                get(PRODUCT_URL+'/'+this.product_id+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.product_item = res.data.results;
                        console.info(this.product_item);
                        this.progress_overlay = "hide";
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadProductItem();
        }
    }
</script>

