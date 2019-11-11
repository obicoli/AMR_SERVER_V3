<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">

                <div class="col-lg-12">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-30-pc">
                                    <h5>
                                        Inventory | <small>Item Preview</small>&nbsp;&nbsp;&nbsp;
                                    </h5>
                                </div>
                                <div class="pull pull-right width-70-pc text-right padding-right-70">
                                    <a href="" class="top-links">Go to Stock</a>
                                    <!-- <a data-toggle="modal" data-target="#new_product_item_modal" class="btn btn-inventory">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        New Item
                                    </a>
                                    <a v-bind:href="'/inventory/stock/add'"  class="btn btn-inventory">
                                        Add Stock
                                    </a>
                                    <a v-bind:href="'/inventory/stock/consume'"  class="btn btn-inventory">
                                        Consume Stock
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <!-- pages navigates here -->
                    <section class="content bg-white mg-top-30">

                        <div class="row">

                            <div v-if="prod_loaded" class="col-xs-12 col-md-12 col-sm-12">

                                <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                                    <div class="box-header box-header-custom">
                                        <div class="pull pull-right width-100-pc">

                                            <div class="filters width-100-pc">

                                                <div class="filter-block form-inline width-50-pc pull-left">
                                                    <span class="name">Stock Level: </span>
                                                    <div class="filter-group input-group">
                                                        <span class="filter active">All</span>
                                                        <span class="filter">Low</span>
                                                        <span class="filter">Expired</span>
                                                    </div>
                                                </div>

                                                <div class="filter-block form-inline width-50-pc pull-right text-right">
                                                    <span class="name">Type: </span>
                                                    <div class="filter-group input-group">
                                                        <span @click="filter_method(0,'','All')" v-bind:class="{'filter':true,'active':active_filter===0}">All</span>
                                                        <span v-for="(prod_filter,index) in product_list_filters" @click="filter_method(index+1,prod_filter.id,prod_filter.name)" v-bind:class="{'filter':true,'active':active_filter===index+1}" :key="'index_key_'+index">{{prod_filter.name}}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="box-body bg-white padding-0">
                                        <!-- <table class="items table table-bordered table-hover more-ctm-table">
                                            <thead>
                                            <tr>
                                                <th style="width: 12%">Name</th>
                                                <th style="width: 10%">Item Code</th>
                                                <th style="width: 10%">Type</th>
                                                <th style="width: 12%">Retail Price</th>
                                                <th style="width: 12%">Total Stock</th>
                                                <th style="width: 12%">Available Stock</th>
                                                <th style="width: 12%">Expired Stock</th>
                                                <th style="width: 12%">Reorder Level</th>
                                                <th style="width: 8%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody v-if="practice_product_items.length > 1" class="noprintclass">

                                                <tr v-for="(practice_prod,index) in practice_product_items" :key="'practice_prod'+index">
                                                    <td>
                                                        {{practice_prod.item_name.substring(0,12)+"..."}}
                                                        <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" :title="practice_prod.item_name+' | '+practice_prod.generic_name+' | '+practice_prod.single_unit_weight+' '+practice_prod.product_unit_slug+' | Stock '+practice_prod.item_stock+' | Price '+practice_prod.unit_retail_price+' | Wholesale '+practice_prod.pack_retail_price"></i></small>
                                                    </td>
                                                    <td class="dotted">{{practice_prod.item_code}}</td>
                                                    <td>{{practice_prod.product_type}}</td>
                                                    <td>
                                                        <div class="ng-binding">
                                                            {{practice_prod.item_currency}} {{practice_prod.unit_retail_price}}
                                                            <i class="tax-text">
                                                                {{practice_prod.tax_charges}}
                                                            </i>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="quantity">{{practice_prod.units_per_pack * practice_prod.single_unit_weight * practice_prod.item_stock}} {{practice_prod.product_unit_slug}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="quantity">{{practice_prod.item_stock}}</span>
                                                        <span v-if="practice_prod.item_stock < practice_prod.alert_indicator_level" class="lowstocklabel">Low</span>
                                                    </td>
                                                    <td>
                                                        <span class="quantity">0</span>
                                                        <span class="expiredstocklabel noprintclass">Expired</span>
                                                    </td>
                                                    <td class="">{{format_money(practice_prod.alert_indicator_level)}}</td>
                                                    <td class="actions">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a data-toggle="modal" :data-target="'#product_item_modal_'+index" class="btn-link pointer-cursor">Edit</a>&nbsp;&nbsp;
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu right-0" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                    <a data-toggle="modal" :data-target="'#delete_product_item_modal_'+index" class="dropdown-item pointer-cursor">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    

                                                    </td>
                                                </tr>

                                            </tbody>
                                        
                                        </table> -->
                                    </div>
                                </div>

                            </div>

                        </div>

                    </section>

                    <!-- <div class="modal fade" id="view_product_item_modal">
                        <div class="modal-dialog modal-lg-custom modal-dialog-centered zoomInUp flipOutX">
                            <view-product-item-modal v-if="prod_loaded" :product_item="practice_product_item" :stocks="practice_product_item.stocks"></view-product-item-modal>
                        </div>
                    </div> -->

                    <product-modal v-if="is_page_ready" :initialization="initializations" :modal_id="'product_item_modal'" :item_url="initialUrl" v-on:productAdded="loadInitializations" v-on:taxAdded="loadInitializations" :user_mode="'Create'"></product-modal>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarHr from "../partials/sidebars/SideBarHr"
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import DeleteModal from '../../practice/partials/modals/DeleteModal'
    import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal'
    import ProductModal from '../../practice/partials/modals/product/ProductModal'
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {formatMoney,removeElement} from "../../../../helpers/functionmixin";

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,SideBarHr,ProductModal,ProcessingOverlay,DeleteModal,ViewProductItemModal},
        data(){
            return {
                initialUrl: '/api/practices/products/items',
                initializations: {},
                practice_product_items: [],
                prod_loaded: false,
                practice_id: '',
                is_page_ready: false,
                progress_overlay: 'hide',
                product_list_filters: [],
                active_filter: 0,
                search_message: 'You dont have any product item in your inventory',
            }
        },
        methods: {

            loadProducts(load_type){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/'+load_type)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //this.practice_product_items = res.data.results;
                        //this.loadProductType();
                        this.initializations.product_items = res.data.results;
                        this.practice_product_items = this.initializations.product_items;
                        this.progress_overlay = "hide";
                        if( this.practice_product_items.length < 1 ){
                            this.search_message = 'You dont have any '+load_type+' in your inventory';
                        }
                        console.info(res.data.results);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            filter_method(index_to,item_type_id,item_type_name){
                this.active_filter = index_to;
                switch(item_type_name){
                    case "All":
                        this.loadInitializations();
                        break;
                    default:
                        this.loadProducts(item_type_name);
                        break;
                }
            },

            loadInitializations(){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Items Page Initialization')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results.resources;
                        //this.loadProductType();
                        console.info(this.initializations);
                        this.practice_product_items = this.initializations.product_items;
                        this.product_list_filters = this.initializations.product_types;
                        this.is_page_ready = true;
                        this.prod_loaded = true;
                        this.progress_overlay = "hide";
                        //this.loadProducts();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },
            format_money(money_to){
                return formatMoney(money_to);
            },

            delete_item(item_to){
                this.initializations.product_items = removeElement(this.initializations.product_items,item_to);
                this.practice_product_items = this.initializations.product_items;
            }

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadInitializations();
        }
    }
</script>

<style scoped>

</style>