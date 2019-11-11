<template>

    <div class="hold-transition skin-yellow sidebar-collapse">
        <page-header :inventory="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-40-pc">
                            <h5>
                                Inventory | <small>Medicines & Products</small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                        <div class="pull pull-right width-60-pc text-right">
                            <a data-toggle="modal" data-target="#new_product_item_modal" class="btn btn-inventory">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                New Item
                            </a>
                            <a v-bind:href="'/inventory/stock/add'"  class="btn btn-inventory">
                                Add Stock
                            </a>
                            <a v-bind:href="'/inventory/stock/consume'"  class="btn btn-inventory">
                                Consume Stock
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">

                    <div v-if="prod_loaded && practice_product_items.length < 1" class="col-xs-12 col-md-12 col-sm-12 mg-top-50">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-body bg-white padding-0">
                            </div>
                        </div>
                        <div class="text-center mg-top-30">
                            <p>You dont have any product item in your inventory</p>
                            <a data-toggle="modal" data-target="#new_product_item_modal" class="btn btn-inventory primary">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Create new Item
                            </a>
                        </div>
                    </div>

                    <div v-if="prod_loaded && practice_product_items.length > 0" class="col-xs-12 col-md-12 col-sm-12">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                            <div class="box-header box-header-custom">

                                <div class="pull-left pull width-20-pc">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">search item</option>
                                    </select>
                                </div>
                                <div class="pull pull-right width-80-pc">

                                    <div class="filters width-100-pc">

                                        <div class="filter-block form-inline width-50-pc pull-left">
<!--                                            <span class="name">Stock Level: </span>-->
                                            <div class="filter-group input-group">
                                                <span class="filter active">All</span>
                                                <span class="filter">Low</span>
                                                <span class="filter">Expired</span>
                                            </div>
                                        </div>

                                        <div class="filter-block form-inline width-50-pc pull-right text-right">
                                            <span class="name">Type: </span>
                                            <div class="filter-group input-group">
                                                <span class="filter active">All</span>
                                                <span class="filter ng-binding">Drugs</span>
                                                <span class="filter">Supplies</span>
                                                <span class="filter">Equipments</span>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 12%">Name</th>
                                        <th style="width: 12%">Item Code</th>
                                        <th style="width: 12%">Type</th>
                                        <th style="width: 12%">Retail Price</th>
                                        <th style="width: 12%">Total Stock</th>
                                        <th style="width: 12%">Available Stock</th>
                                        <th style="width: 12%">Expired Stock</th>
                                        <th style="width: 12%">Reorder Level</th>
                                        <th style="width: 4%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">

                                        <tr v-for="practice_prod in practice_product_items">
                                            <td>
                                                {{practice_prod.item_name.substring(0,12)+"..."}}
                                                <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" :title="practice_prod.item_name+' | '+practice_prod.generic_name+' | '+practice_prod.single_unit_weight+' '+practice_prod.product_unit_slug+' | Stock '+practice_prod.item_stock+' | Price '+practice_prod.unit_retail_price+' | Wholesale '+practice_prod.pack_retail_price"></i></small>
                                            </td>
                                            <td>{{practice_prod.item_code}}</td>
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
                                            <td class="">{{practice_prod.alert_indicator_level}}</td>
                                            <td class="actions">
                                                <a @click="setItemTo(practice_prod)" data-toggle="modal" data-target="#view_product_item_modal"><i class="fa fa-edit pointer-cursor"></i></a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-inventory">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                Print all items with stock
                            </button>
                            <button type="button" class="btn btn-inventory">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                Email all items with stock
                            </button>
                        </div>
                    </div>

                </div>

            </section>

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="view_product_item_modal">
                <div class="modal-dialog modal-lg-custom modal-dialog-centered zoomInUp flipOutX">
                    <view-product-item-modal v-if="prod_loaded" :product_item="practice_product_item" :stocks="practice_product_item.stocks"></view-product-item-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="new_product_item_modal">
                <div class="modal-dialog modal-lg-custom-90 modal-dialog-centered zoomInUp flipOutX">
                    <new-product-item-modal v-on:productAdded="loadProducts"></new-product-item-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

        </div>

        <page-footer></page-footer>
    </div>

</template>

<script>
    import PageHeader from '../patials/Header'
    import PageFooter from '../patials/Footer'
    import {get,post} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    import ViewProductItemModal from './partials/ViewProductItemModal'
    import NewProductItemModal from './partials/NewProductItemModal'
    export default {
        name: "Index",
        components: {
            PageFooter,PageHeader,ViewProductItemModal,NewProductItemModal
        },
        data(){
            return {
                practice_product_items: [],
                practice_product_item: {},
                //pharmacy_name: Auth.getPname(),
                pharmacy_name: '',
                branch_name: 'Main Branch',
                department_name: 'All departments',
                prod_loaded: false,
                practice_id: ''
            }
        },
        methods: {

            loadProducts(){
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Product Items')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.practice_product_items = res.data.results;
                        console.info(this.practice_product_items);
                        this.prod_loaded = true;
                    }
                }).catch((err) => {

                });
            },
            setItemTo(practice_prod){
                this.practice_product_item = practice_prod;
            }

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadProducts();
        }
    }
</script>

<style scoped>

</style>