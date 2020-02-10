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
                                    <h2>Inventory Items</h2>
                                </div>
                                <div class="pull pull-left app-header width-80-pc">
                                    <common-links :active_link="'products'"></common-links>
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

                                                <div class="width-30-pc pull-left">
                                                    <search-item-field v-on:itemFound="add_search_result" :show_label="false" :field_wdth="250" :tabulated_view="true" :rounded_px="2" :search_result_min_height="500" :search_result_width="1150"></search-item-field>
                                                </div>

                                                <div class="width-20-pc pull-right">
                                                    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                        <button data-toggle="modal" data-target="#product_item_modal" type="button" class="btn combo-button combo-default">+ New Item</button>
                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#import_items_modal_id"> Import Items</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="width-40-pc pull-right text-right">
                                                    <div class="filter-block form-inline pull-right padding-left-10">
                                                        <span class="name fs-12 fw-600 txt-uppercase">Profile: </span>
                                                        <div class="filter-group input-group">
                                                            <span class="filter min-width-70 active txt-uppercase">Drug</span>
                                                            <span class="filter min-width-70 txt-uppercase">Pathology</span>
                                                            <span class="filter min-width-70 txt-uppercase">Surgical</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-body bg-white padding-right-20 padding-left-20 padding-top-29">

                                        <table class="items table table-bordered table-hover more-ctm-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 2%">
                                                        <label class="check-container small element-inlined mg-top-0 mg-bottom-20">
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </th>
                                                    <th style="width: 12%">Item/Code</th>
                                                    <th style="width: 33%">Item/Name</th>
                                                    <th style="width: 8%">Profile/Name</th>
                                                    <!-- <th style="width: 7%">Barcode</th> -->
                                                    <!-- <th style="width: 10%">Type</th> -->
                                                    <th style="width: 5%">Pack(size)</th>
                                                    <th style="width: 5%">U.O.M</th>
                                                    
                                                    <th style="width: 10%" class="text-right">Total Stock</th>
                                                    <!-- <th style="width: 12%">Available Stock</th> -->
                                                    <!-- <th style="width: 12%">Expired Stock</th> -->
                                                    
                                                    <th style="width: 5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="practice_product_items.length > 0">

                                                <tr v-for="(practice_prod,index) in practice_product_items" :key="'practice_prod'+index">
                                                    <td>
                                                        <label class="check-container small element-inlined mg-top-0 mg-bottom-10">
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td class="dotted">{{practice_prod.sku_code}}</td>
                                                    <td>
                                                        {{practice_prod.item_name.name}}
                                                    </td>
                                                    <td class="">{{practice_prod.profile.name}}</td>
                                                    <td>{{practice_prod.pack_qty}}</td>
                                                    <td>
                                                        <!-- {{practice_prod.measure_unit.slug}} -->
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="quantity fw-600">{{format_money(practice_prod.pack_qty * practice_prod.stock)}}</span>
                                                        <span v-if="practice_prod.stock <= practice_prod.alert_indicator_level" class="lowstocklabel">Low</span>
                                                    </td>
                                                    <td class="actions">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a data-toggle="modal" :data-target="'#product_item_modal_'+index" class="btn-link pointer-cursor fw-600 fs-12 txt-uppercase showOnHover">Edit</a>&nbsp;&nbsp;
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                    <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Make Inactive</a>
                                                                    <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Run Report</a>
                                                                    <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Duplicate</a>
                                                                    <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Adjust Quantity</a>
                                                                    <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Starting value</a>
                                                                    <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Adjust starting value</a>
                                                                    <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Reorder Level</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </td>
                                                    
                                                </tr>
                                            </tbody>
                                            <tbody v-if="practice_product_items.length < 1">
                                                <tr>
                                                    <td colspan="9" class="padding-top-20 padding-bottom-20" style="text-align: center; font-size:15px;">
                                                        You dont have any inventory item! <a data-toggle="modal" data-target="#product_item_modal" class="cl-amref pointer-cursor">+ New Item</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- <div class="btn-group float-left" role="group" aria-label="Button group with nested dropdown" style="box-shadow: inset 0 -1px 0 #DFDFDF;">
                                            <button :disabled="!practice_product_items.length" data-toggle="modal" data-target="#receive_stock_modal_id" type="button" class="btn combo-button primary">+ Bulk Action</button>
                                            <div class="btn-group" role="group">
                                                <button :disabled="!practice_product_items.length" id="btnGroupDrop" type="button" class="btn combo-button dropdown-toggle primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                    <a data-toggle="modal" data-target="#stock_adjustment_modal_id" class="dropdown-item fs-13 cl-444 pointer-cursor"> Apply Taxation</a>
                                                </div>
                                            </div>
                                        </div> -->

                                    </div>

                                    <div class="box-header box-header-custom">
                                        <div class="width-100-pc">
                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadProductItem()" :custom="true"></paginate-template>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- <product-modal-copy v-if="is_page_ready" :title="'Inventory Item'" :products_attributes="products_attributes" :initialization="initializations" :modal_id="'product_item_modal_copy'" v-on:productAdded="loadProducts" v-on:taxAdded="loadProductAttr" :user_mode="'Create'"></product-modal-copy> -->
                    <product-modal v-if="is_page_ready" :title="'Inventory Item'" v-on:savingSuccessful="loadProductItem('hide')" :initialUrl="initialUrl" :inventories="inventories" :products_attributes="products_attributes" :modal_id="'product_item_modal'" :user_mode="'Create'"></product-modal>
                    <!-- <import-item-modal :modal_id="'import_items_modal_id'" :practice_id="practice_id" :modal_title="'Import Product Items'" v-on:uploaded="loadProductItem"></import-item-modal> -->
                    <general-import-modal v-if="is_page_ready" v-on:imported="loadProductItem" :title="'Import Inventory Items'" :modal_id="'import_items_modal_id'" :modal_min_width="1000" :sample_file="'invetory_items'" :upload_type="'Inventory Items'"></general-import-modal>
                    <div v-for="(itema,indexs) in practice_product_items" :key="'practice_product_items'+indexs">
                        <product-modal v-if="is_page_ready" v-on:savingSuccessful="loadProductItem('hide')" :initialUrl="initialUrl+'/'+itema.id" :user_mode="'Edit'" :inventories="inventories" :form_data="itema" :title="'Inventory Item'" :products_attributes="products_attributes" :modal_id="'product_item_modal_'+indexs"></product-modal>
                        <confirm-modal :modal_id="'product_item_modal_inactive_'+indexs" :modal_title="'Make Inactive'" :confirm_message="'Are you sure?'" :item_url="PRODUCT_URL+'/'+itema.id"></confirm-modal>
                    </div>
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
    import ConfirmModal from '../../../practice/partials/modals/ConfirmModal';
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    // import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal';
    import ProductModal from '../../../practice/partials/modals/product/ProductModal';
    //import ProductModalCopy from '../../../practice/partials/modals/product/ProductModalCopy';
    //import ImportItemModal from '../../../practice/partials/modals/product/ImportItemModal';
    import {get} from "../../../../../helpers/api";
    //import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {formatMoney,removeElement,paginator} from "../../../../../helpers/functionmixin";
    import SearchItemField from '../../partials/modals/product/SearchItemField';
    import SearchItemFormControl from '../../partials/modals/product/SearchItemFormControl';
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import {ACCOUNTING} from "../../../../../helpers/process_status";
    import {PRODUCT_ITEMS_URL,ACCOUNTS_INITIALS} from '../../../../../router/api_routes';

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,
        SideBarHr,ProductModal,
        ProcessingOverlay,DeleteModal,ConfirmModal,PaginateTemplate,GeneralImportModal,
        SearchItemField,CommonLinks,SearchItemFormControl},
        data(){
            return {
                initialUrl: PRODUCT_ITEMS_URL,
                practice_product_items: [],
                products_attributes: [],
                accountings: {},
                inventories: [],
                prod_loaded: false,
                is_page_ready: false,
                progress_overlay: 'hide',
                pagination: paginator()
            }
        },
        methods: {

            // filter_method(index_to,item_type_id,item_type_name){
            //     this.active_filter = index_to;
            //     switch(item_type_name){
            //         case "All":
            //             //this.loadInitializations();
            //             break;
            //         default:
            //             //this.loadProducts(item_type_name);
            //             break;
            //     }
            // },

            add_search_result(items_product){
                this.practice_product_items = items_product;
            },

            // loadAccounts(){
            //     const COA_CODES = ACCOUNTING.COA_CODES;
            //     this.inventories = [];
            //     this.expenses = [];
            //     for (let index = 0; index < this.accounting_attributes.company_coas.length; index++) {
            //         const element = this.accounting_attributes.company_coas[index];
            //         if(element.default_code===ACCOUNTING.COA_CODES.INVENTORY){
            //             this.inventories.push(element);
            //         }
            //     }
            //     this.is_page_ready = true;
            //     this.prod_loaded = true;
            //     this.progress_overlay = "hide";
            // },

            loadAccounts(state_show){
                this.progress_overlay = state_show;
                get(ACCOUNTS_INITIALS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.accountings = res.data.results;
                        this.inventories = [];
                        for (let index = 0; index < this.accountings.company_coas.length; index++) {
                            const element = this.accountings.company_coas[index];
                            if(element.default_code===ACCOUNTING.COA_CODES.INVENTORY){
                                this.inventories.push(element);
                            }
                        }
                        this.loadProductItem();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadProductItem(state_show){
                this.progress_overlay = state_show;
                get(PRODUCT_ITEMS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.practice_product_items = res.data.results.data;
                        this.pagination = res.data.results.pagination;
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
        },

        mounted(){
            this.products_attributes = Auth.getProducts();
            this.loadAccounts("show");
        }

    }
</script>

<style scoped>

</style>
