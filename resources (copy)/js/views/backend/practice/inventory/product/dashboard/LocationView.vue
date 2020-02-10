<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo"></div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-product :scrollable="false" :width="true" :transparent="true" :active_el="'location'" :product_id="product_id"></side-bar-product>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20">
                                    <h3>Product View</h3>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">

                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">

                                        <search-item-field :practice_id="practice_id" v-on:itemFound="redirect_to_item"></search-item-field>

                                        <table class="items prod-view-table table table-bordered">
                                            
                                            <thead>

                                                <tr>
                                                    <th style="width:30%;">Facility</th>
                                                    <th style="width:70%;" colspan="4">Current Stock</th>
                                                </tr>

                                            </thead>

                                            <tbody>

                                                <tr v-for="(stocks,index) in product_item.stock" :key="'stock_id_'+index">
                                                    <td class="txt-uppercase">{{stocks.facility_name}}</td>
                                                    <td colspan="4">
                                                        <table class="table prod-view-table-child table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:10%;">Batch</th>
                                                                    <th style="width:18%;">Packs</th>
                                                                    <th style="width:18%;">Units</th>
                                                                    <th style="width:18%;">Qty</th>
                                                                    <th style="width:12%;">MFG. Date</th>
                                                                    <th style="width:12%;">Exp. Date</th>
                                                                    <th style="width:12%;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(batches,index1) in stocks.current_stocks" :key="'batch_id_'+index1">
                                                                    <td>{{batches.batch_number}}</td>
                                                                    <td>{{calc_handler('packs',batches.qty,product_item.pack_qty)}}</td>
                                                                    <td>{{calc_handler('units',batches.qty,product_item.pack_qty)}}</td>
                                                                    <td>{{batches.qty}}</td>
                                                                    <td>{{batches.mfg_date}}</td>
                                                                    <td>{{batches.exp_date}}</td>
                                                                    <td>
                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                            <a data-toggle="modal" :data-target="'#product_item_modal_'+index1" class="btn-link pointer-cursor">Action</a>&nbsp;&nbsp;
                                                                            <div class="btn-group" role="group">
                                                                                <a :id="'btnGroupDrop2_'+index1" class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                </a>
                                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index1">
                                                                                    <a data-toggle="modal" :data-target="'#delete_product_item_modal_'+index1" class="dropdown-item pointer-cursor"> Adjust</a>
                                                                                    <a data-toggle="modal" :data-target="'#delete_product_item_modal_'+index1" class="dropdown-item pointer-cursor"> Transfer</a>
                                                                                    <a data-toggle="modal" :data-target="'#delete_product_item_modal_'+index1" class="dropdown-item pointer-cursor"> Request</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="7">
                                                                        <span class="txt-uppercase fs-13 fw-600">Total Stock:</span>
                                                                        <span class="txt-uppercase fs-13 fw-600">{{ money_format(calc_handler('total_stock',stocks.current_stocks,null))}}</span>
                                                                        <span v-if="product_item.reorder_level > calc_handler('total_stock',stocks.current_stocks,null)" class="lowstocklabel">Low</span>
                                                                        <span class="fs-11">({{product_item.pack_qty}} X {{product_item.unit_weight}}{{product_item.measure_unit_symbol}})</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </td>
                                                </tr>

                                            </tbody>

                                        </table>

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
    import Auth from "../../../../../../store/auth";
    import {PRODUCT_URL} from "../../../../../../router/api_routes";
    import ProcessingOverlay from "../../../../../progress/ProcessingOverlay";
    import {calculation_handler,formatMoney} from "../../../../../../helpers/functionmixin";
    import SearchItemField from '../../../partials/modals/product/SearchItemField';
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarProduct,ProcessingOverlay,SearchItemField},
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
                        this.progress_overlay = "hide";
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },
            calc_handler(calc_type,qty=null,pack_qty=null){
                return calculation_handler(calc_type,qty,pack_qty);
            },
            money_format(amount){
                return formatMoney(amount);
            },
            redirect_to_item(item_to){
                window.location.href = "/item/"+item_to.id+"/locations_view";
            }

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadProductItem();
        }
    }
</script>

