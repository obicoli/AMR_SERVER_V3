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
                                <div class="pull pull-left app-header width-20-pc">
                                    <h2 class="txt-uppercase fs-12 fw-600">Available Stock List:</h2>
                                </div>
                                <div class="pull pull-right app-header width-80-pc">
                                    <common-links :active_link="'stocks'"></common-links>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content bg-white mg-top-30">

                        <div class="row justify-content-center">

                            <div v-if="prod_loaded" class="col-xs-12 col-md-12 col-sm-12 max-width-1200 min-width-1200">

                                <div class="box border-top-0 border-bottom-0 border-radius-0 mg-top-30" id="print-section">

                                    <div class="box-header box-header-custom">

                                        <div class="pull pull-right width-100-pc">

                                            <div class="filters width-100-pc">

                                                <div class="width-80-pc pull-left">
                                                    <search-item-form-control :practice_id="practice_id" :field_wdth="250" :rounded_px="10" :search_result_width="1150"></search-item-form-control>
                                                </div>

                                                <div class="width-20-pc pull-right">
                                                    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                        <button type="button" class="btn combo-button combo-default">+ New Transaction</button>
                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#receive_items_modal_id"> Receive Inventory</a>
                                                                <a class="dropdown-item pointer-cursor"> Export as CSV</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-body bg-white padding-right-20 padding-left-20 padding-top-29">

                                        <div class="width-50-pc pull-left mg-bottom-20">
                                            <a @click="setStockStatus('All')" v-bind:class="{'pointer-cursor':true,'btn-approved-md':stock_status==='All','btn-default-md':stock_status!=='All'}">Stock</a>
                                            <a @click="setStockStatus('Pending')" v-bind:class="{'pointer-cursor':true,'btn-approved-md':stock_status==='Pending','btn-default-md':stock_status!=='Pending'}">Pending</a>
                                            <!-- <router-link :to="INVENTORY_WEB_ROUTES.INV_STOCK_TRANSIT" v-bind:class="{'pointer-cursor':true,'btn-approved-md':stock_status==='Low','btn-default-md':stock_status!=='Low'}">In Transit</router-link> -->
                                            <a @click="setStockStatus('Low')" v-bind:class="{'pointer-cursor':true,'btn-approved-md':stock_status==='Low','btn-default-md':stock_status!=='Low'}">Low</a>
                                            <a @click="setStockStatus('Recent Expired')" v-bind:class="{'pointer-cursor':true,'btn-approved-md':stock_status==='Recent Expired','btn-default-md':stock_status!=='Recent Expired'}">Recent Expired</a>
                                            <a @click="setStockStatus('Expired')" v-bind:class="{'pointer-cursor':true,'btn-approved-md':stock_status==='Expired','btn-default-md':stock_status!=='Expired'}">Expired</a>
                                            <!-- <a @click="setStockStatus('Adjustment')" v-bind:class="{'pointer-cursor':true,'btn-approved-md':stock_status==='Adjustment','btn-default-md':stock_status!=='Adjustment'}">Adjustments</a> -->
                                        </div>

                                        <table class="items table table-bordered table-hover more-ctm-table">
                                            <thead>
                                                <tr v-if="stock_status==='All' || stock_status==='Expired'">
                                                    <th style="width: 2%">
                                                        <label class="check-container small element-inlined mg-top-0 mg-bottom-20">
                                                            <input v-model="form_input.check_all" @click="checkAll($event)" type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </th>
                                                    <th style="width: 6%">Item/Code</th>
                                                    <th style="width: 14%">Item/Name</th>
                                                    <th style="width: 7%">Weight</th>
                                                    <!-- <th style="width: 7%">Purchase</th> -->
                                                    <th style="width: 7%">Sold</th>
                                                    <th style="width: 7%">Return</th>
                                                    <!-- <th style="width: 6%">Pack/cost</th> -->
                                                    <th style="width: 6%">Pack/Retail</th>
                                                    <!-- <th style="width: 6%">Unit/Cost</th> -->
                                                    <th style="width: 14%">Unit/Retail</th>
                                                    <th style="width: 11%">Stock</th>
                                                    <th style="width: 8%">Worth</th>
                                                    <th style="width: 6%">P/Margin</th>
                                                    <th style="width: 2%">+</th>
                                                </tr>
                                                <tr v-if="stock_status==='Pending'">
                                                    <th style="width: 2%">
                                                        <label class="check-container small element-inlined mg-top-0 mg-bottom-20">
                                                            <input v-model="form_input.check_all" @click="checkAll($event)" type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </th>
                                                    <th style="width: 6%">Item/Code</th>
                                                    <th style="width: 10%">Item/Name</th>
                                                    <th style="width: 7%">Weight</th>
                                                    <th style="width: 7%">Purchase</th>
                                                    <!-- <th style="width: 7%">Sold</th>
                                                    <th style="width: 7%">Return</th> -->
                                                    <th style="width: 6%">Pack/cost</th>
                                                    <th style="width: 6%">Pack/Retail</th>
                                                    <th style="width: 6%">Unit/Cost</th>
                                                    <th style="width: 6%">Unit/Retail</th>
                                                    <th style="width: 7%">Stock</th>
                                                    <th style="width: 8%">Worth</th>
                                                    <th style="width: 6%">P/Margin</th>
                                                </tr>
                                                <tr v-if="stock_status==='Low'">
                                                    <th style="width: 2%">
                                                        <label class="check-container small element-inlined mg-top-0 mg-bottom-20">
                                                            <input v-model="form_input.check_all" @click="checkAll($event)" type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </th>
                                                    <th style="width: 6%">Item/Code</th>
                                                    <th style="width: 15%">Item/Name</th>
                                                    <th style="width: 17%">Category</th>
                                                    <th style="width: 7%">U.O.M</th>
                                                    <th style="width: 7%">Pack(Qty)</th>
                                                    <th style="width: 15%">Unit/Retail</th>
                                                    <th style="width: 14%">Reorder Level</th>
                                                    <th style="width: 17%">Stock(Unit)</th>
                                                </tr>
                                            </thead>
                                            <all-tr v-if="prod_loaded && stock_status==='All'" :check_all="form_input.check_all" :checked_items="form_input.items" :transactions="transactions"></all-tr>
                                            <pending-tr v-if="prod_loaded && stock_status==='Pending'" :check_all="form_input.check_all" :checked_items="form_input.items" :transactions="transactions"></pending-tr>
                                            <low-tr v-if="prod_loaded && stock_status==='Low'" :check_all="form_input.check_all" :checked_items="form_input.items" :transactions="transactions"></low-tr>
                                            <tbody v-if="transactions.length > 0">
                                                <tr>
                                                    <td colspan="14" class="padding-top-20 padding-bottom-20" style="text-align: center; font-size:15px;">
                                                        <div class="btn-group float-left" role="group" aria-label="Button group with nested dropdown" style="box-shadow: inset 0 -1px 0 #DFDFDF;">
                                                            <button :disabled="!form_input.items.length" data-toggle="modal" data-target="#receive_stock_modal_id" type="button" class="btn combo-button primary">+ Bulk Action</button>
                                                            <div class="btn-group" role="group">
                                                                <button :disabled="!form_input.items.length" id="btnGroupDrop" type="button" class="btn combo-button dropdown-toggle primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                                    <a v-if="stock_status!=='Pending'" data-toggle="modal" data-target="#stock_adjustment_modal_id" class="dropdown-item fs-13 cl-444 pointer-cursor"> Stock Adjustment</a>
                                                                    <a v-if="stock_status==='Pending'" data-toggle="modal" data-target="#update_to_stock_modal_id" class="dropdown-item fs-13 cl-444 pointer-cursor"> Update to stock</a>
                                                                    <a v-if="stock_status==='Recent Expired' || stock_status==='Expired'" data-toggle="modal" data-target="#update_to_stock_modal_id" class="dropdown-item fs-13 cl-444 pointer-cursor"> Expired</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="transactions.length < 1">
                                                <tr>
                                                    <td colspan="14" class="padding-top-20 padding-bottom-20" style="text-align: center; font-size:15px;">
                                                        No stock item to display.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="box-header box-header-custom">
                                        <div class="width-100-pc">
                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadProductStock()" :custom="true"></paginate-template>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <receive-stock-modal v-if="prod_loaded" :default_adjust="false" :purchase="form_input" :modal_title="'Receive Inventory'" :organ_data="organ_data" :initializations="initializations" :practice_id="practice_id" :modal_id="'receive_items_modal_id'"></receive-stock-modal>
                    <stock-adjustment-modal v-if="prod_loaded" :default_adjust="false" :purchase="form_input" :modal_title="'+ Stock Adjustment'" :organ_data="organ_data" :initializations="initializations" :practice_id="practice_id" :modal_id="'stock_adjustment_modal_id'"></stock-adjustment-modal>
                    <add-stock-item-modal v-if="prod_loaded" v-on:stockSaved="loadProductStock('hide')" :purchase="form_input" :modal_title="'+ Add Stock Item'" :organ_data="organ_data" :initializations="initializations" :practice_id="practice_id" :modal_id="'update_to_stock_modal_id'"></add-stock-item-modal>
                    <product-modal v-if="prod_loaded" :products_attributes="products_attributes" :initialization="initializations" :modal_id="'product_item_modal'" v-on:productAdded="loadProducts" v-on:taxAdded="loadProductAttr" :user_mode="'Create'"></product-modal>
                    <import-item-modal :modal_id="'import_items_modal_id'" :practice_id="practice_id" :modal_title="'Import Product Items'" v-on:uploaded="loadProductStock"></import-item-modal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import SideBarHr from "../../partials/sidebars/SideBarHr";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import DeleteModal from '../../../practice/partials/modals/DeleteModal';
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import SearchItemFormControl from '../../partials/modals/product/SearchItemFormControl';
    import AllTr from './partials/AllTr';
    import ExpiredTr from './partials/ExpiredTr';
    import LowTr from './partials/LowTr';
    import PendingTr from './partials/PendingTr';
    //
    import ProductModal from '../../../practice/partials/modals/product/ProductModal';
    import ImportItemModal from '../../../practice/partials/modals/product/ImportItemModal';
    import AddStockItemModal from '../../../practice/partials/modals/stocks/AddStockItemModal';
    import StockAdjustmentModal from '../../../practice/partials/modals/stocks/StockAdjustmentModal';
    import ReceiveStockModal from '../../../practice/partials/modals/stocks/ReceiveStockModal';
    import {get} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {formatMoney,removeElement,paginator} from "../../../../../helpers/functionmixin";
    import SearchItemField from '../../partials/modals/product/SearchItemField';
    import {PRODUCT_URL,PRODUCT_STOCK_URL,PURCHASES_ATTRIBUTES_URL} from '../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,
        SideBarHr,ProductModal,StockAdjustmentModal,
        ProcessingOverlay,DeleteModal,ReceiveStockModal,
        ImportItemModal,PaginateTemplate,AddStockItemModal,
        SearchItemFormControl,CommonLinks,AllTr,PendingTr,LowTr},
        data(){
            return {
                
                stock_status: 'All',
                organ_data: {},
                initializations: {},
                practice_product_items: [],
                transactions: [],
                form_input: {
                    branch_id: '',
                    store_id: '',
                    department_id: '',
                    sub_store_id: '',
                    date_received: '',
                    advise_note: '',
                    check_all: false,
                    items: [],
                    stock_source: 'Pending',
                    adjust_type: '',
                    ref_number: '',
                },
                taxes: [],
                products_attributes: [],
                manufacturers: [],
                prod_loaded: false,
                //page_loaded: false,
                practice_id: '',
                progress_overlay: 'hide',
                product_list_filters: [],
                active_filter: 0,
                search_message: 'You dont have any product item in your inventory',
                pagination: paginator(),
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES
            }
        },
        methods: {

            checkAll(event){
                this.form_input.items = [];
                if(event.target.checked){
                    this.initialize_form_items();
                }
            },

            initialize_form_items(){
                this.form_input.items = [];
                for (let index = 0; index < this.transactions.length; index++) {
                    let element = this.transactions[index];
                    this.form_input.items.push(element)
                    //console.info(element);
                }
            },

            filter_method(index_to,item_type_id,item_type_name){
                this.active_filter = index_to;
                switch(item_type_name){
                    case "All":
                        break;
                    default:
                        break;
                }
            },

            setStockStatus(type_){
                this.form_input.items = [];
                this.form_input.check_all = false;
                this.stock_status = type_;
                this.loadProductStock();
            },

            loadProducts(item_type_name){},

            redirect_to_item(item_to){
                window.location.href = "/item/"+item_to.id+"/view";
            },

            getTax(tax_array){
                let str_returned = '';
                return str_returned;
            },

            loadProductStock(progress_mode = "show"){
                this.progress_overlay = progress_mode;
                get(PRODUCT_STOCK_URL+'/practice/'+this.practice_id+'/'+this.stock_status+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.transactions = res.data.results.data;
                        this.pagination = paginator(res.data.results);
                        if(progress_mode === "hide"){
                            this.initialize_form_items()
                        }
                        console.info(this.transactions);
                        this.prod_loaded = true;
                        this.progress_overlay = "hide";
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadInitials(){
                this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
                        this.loadProductStock();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        //this.$router.push('/500');
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            loadProductAttr(){
                get(PRODUCT_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.products_attributes = res.data.results;
                        //console.info(this.products_attributes);
                        this.is_page_ready = true;
                        this.prod_loaded = true;
                        this.progress_overlay = "hide";
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
            this.organ_data = Auth.getCurrentAccount('account');
            //this.loadProductStock();
            this.loadInitials();
        }
    }
</script>

<style scoped>

</style>
