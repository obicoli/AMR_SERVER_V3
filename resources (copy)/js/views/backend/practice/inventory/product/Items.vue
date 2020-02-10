<template>

    <div>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar v-if="page_ready" :reports="inventory_reports"></side-bar>

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
                                                <div class="width-100-pc float-left">
                                                    <div class="width-40-pc float-left">
                                                        <div class="btn-group" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    List of Items ({{pagination.total}})
                                                                </a>
                                                                <div v-if="categories.length" class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a v-for="(category,index) in categories" class="dropdown-item pointer-cursor" :key="'categories'+index">{{category.name}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="width-100-pc float-left mg-top-30 mg-bottom-50">
                                                    <div v-if="page_ready" class="width-100-pc float-left mg-top-30 mg-bottom-50">
                                                        <div class="width-45-pc float-left mg-right-15 mg-bottom-15">
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input placeholder="Search..." :disabled="is_initializing || processing" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-25-pc float-right mg-bottom-15">
                                                            <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    New Item
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a data-toggle="modal" data-target="#item_qv_modal_1" class="dropdown-item pointer-cursor">Add Item</a>
                                                                    <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Items</a>
                                                                </div>
                                                            </div>
                                                            <div class="btn-group mg-right-5 float-right" role="group">
                                                                <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Quick Reports
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <router-link :to="REPORT_URL+'?section='+item.name" v-for="(item,index) in inventory_reports" class="dropdown-item pointer-cursor" :key="'inventory_item'+index">{{item.name}}</router-link>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div id="po_list_id_0" class="width-100-pc float-left">
                                                            <table class="table banking-transaction table-hover mg-bottom-5">        
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:2%;">
                                                                            <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                        </th>
                                                                        <th style="width:10%">Code</th>
                                                                        <th style="width:30%">Description</th>
                                                                        <th style="width:18%;">Category</th>
                                                                        <th style="width:8%;" class="text-right">Price Excl</th>
                                                                        <th style="width:8%;" class="text-right">Price Incl</th>
                                                                        <th style="width:8%;" class="text-right">Avg Cost</th>
                                                                        <th style="width:8%;" class="text-right">Qty on Hand</th>
                                                                        <th style="width:8%;" class="text-right">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody v-if="processing || is_initializing">
                                                                    <tr>
                                                                        <td class="somepad text-center" colspan="9">
                                                                            <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-if="inventories.length">
                                                                    <tr v-for="(inventory,index) in inventories" :key="'list_of_items_'+index">
                                                                        <td class="somepad">
                                                                            <input :disabled="is_initializing || processing" v-model="selected_inventories" type="checkbox" class="pointer-cursor" :value="inventory.id">
                                                                        </td>
                                                                        <td class="somepad">{{inventory.sku_code}}</td>
                                                                        <td class="somepad">{{inventory.item_name.name}}</td>
                                                                        <td class="somepad">{{inventory.category.name}}</td>
                                                                        <td class="somepad text-right"></td>
                                                                        <td class="somepad text-right"></td>
                                                                        <td class="somepad text-right"></td>
                                                                        <td class="somepad text-right">{{format_money(inventory.pack_qty * inventory.stock)}}</td>
                                                                        <td class="somepad actions">
                                                                            <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                <!-- <a data-toggle="modal" :data-target="'#product_item_modal_'+index" class="pointer-cursor fw-600 fs-11 showOnHover">Edit</a>&nbsp;&nbsp; -->
                                                                                <div class="btn-group" role="group">
                                                                                    <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        Action
                                                                                    </a>
                                                                                    <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                                        <a @click="setItem(inventory)" data-toggle="modal" data-target="#item_qv_modal_1" class="dropdown-item pointer-cursor">Quick View</a>
                                                                                        <a class="dropdown-item separator"></a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Make Inactive</a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Duplicate</a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Adjust Quantity</a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Starting value</a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Adjust starting value</a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Reorder Level</a>
                                                                                        <a class="dropdown-item separator"></a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Edit</a>
                                                                                        <a data-toggle="modal" :data-target="'#product_item_modal_inactive_'+index" class="dropdown-item pointer-cursor">Delete</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-else>
                                                                    <tr>
                                                                        <td class="somepad text-center cl-amref" colspan="9">
                                                                            No Item to display!
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-20-pc float-left">
                                                            <div class="btn-group" role="group">
                                                                <button :disabled="is_initializing || processing || selected_inventories.length===0 " :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span v-if="selected_inventories.length">{{selected_inventories.length}} item(s) selected</span>
                                                                    <span v-else>Batch Action</span>
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <!-- <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Add Bill</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Update status</a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Copy Purchase Order</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Delete</a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-80-pc float-right text-right">
                                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadItems()" :custom="true"></paginate-template>
                                                        </div>
                                                    </div>
                                                    <div v-else class="width-100-pc float-left mg-top-60 text-center">
                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 col-lg-12 padding-right-0 border-bottom">
                                                <product-qv :item="item" :PRODUCT_ITEMS_URL="PRODUCT_ITEMS_URL" :currency="currency" :modal_id="'item_qv_modal_1'" :modal_title="'Item Quick View'"></product-qv>
                                                <general-import-modal v-if="page_ready" @imported="loadItems(true)" :title="'Import Items'" :modal_id="'import_items_modal_id'" :modal_min_width="1000" :sample_file="'invetory_items'" :upload_type="'Inventory Items'"></general-import-modal>
                                                <copy-right></copy-right>
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
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../partials/CopyRight';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import ProductModal from '../../partials/modals/product/ProductModal';
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import ProductQv from "../../partials/modals/inventory/ProductQv";

    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES,REPORT_SECTIONS} from "../../../../../helpers/process_status";
    import {PRODUCT_CATEGORIES_URL,REPORTING,PRODUCT_ITEMS_URL,PRODUCT_TAX_URL,CHART_OF_ACCOUNTS, CUSTOMERS_API,CUSTOMERS_TERMS_API,CUSTOMERS_ESTIMATES_API, BANKING_ACCOUNTS_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,
        ProductModal,GeneralImportModal,ProductQv},
        data(){
            return {
                
                selected_salesorders: [],
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                PROCESS_STATUS: PROCESS_STATUS,
                
                customers: [],
                taxations: [],
                bank_accounts: [],
                payment_terms: [],
                inventory_reports: [],
                QUOTE_URL: INVENTORY_WEB_ROUTES.SALES.QUOTE,
                SALES_ORDER_URL: INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS,
                INVOICES_URL: INVENTORY_WEB_ROUTES.SALES.INVOICES,
                salesorders: [],
                bank_accounts: [],
                inventories: [],
                default_filter: 'All',
                default_api: PRODUCT_ITEMS_URL+'?page=1',
                PRODUCT_CATEGORIES_URL:PRODUCT_CATEGORIES_URL,
                categories: [],
                selected_inventories: [],
                products_attributes: null,
                page_ready: false,
                is_initializing: false,
                processing: false,
                filters: {},
                REPORT_URL:  INVENTORY_WEB_ROUTES.INVENTORIES.REPORT,
                item: null,
                PRODUCT_ITEMS_URL: PRODUCT_ITEMS_URL,
            }
        },
        watch: {
            default_api: function(){
                this.loadEstimates(true);
            }
        },
        methods: {
            check_all(event){
                this.selected_salesorders = [];
                if(event.target.checked){
                    for (let index = 0; index < this.salesorders.length; index++) {
                        const element = this.salesorders[index];
                        this.selected_salesorders.push(element.id);
                    }
                }
            },
            setItem(inventory){
                this.item = inventory;
            },

            format_money(money_to){
                return formatMoney(money_to);
            },
            filterItems(filter_by='All'){
                switch (filter_by) {
                    case PROCESS_STATUS.CANCELLED:
                    case PROCESS_STATUS.CLOSED:
                    case PROCESS_STATUS.PARTIAL_BILLED:
                    case PROCESS_STATUS.BILLED:
                    case PROCESS_STATUS.OPEN:
                    case PROCESS_STATUS.DRAFT:
                    case PROCESS_STATUS.PENDING_APPROVAL:
                    case PROCESS_STATUS.APPROVED:
                    case PROCESS_STATUS.PAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.VOID:
                    case PROCESS_STATUS.OVERDUE:
                    case PROCESS_STATUS.PARTIAL_PAID:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_SALES_ORDERS_API+'?page='+this.pagination.current_page;
                        break;
                }
            },

            loadCategories(){
                get(PRODUCT_CATEGORIES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.categories = res.data.results.data;
                        this.loadReports();
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

            loadItems(show_progress=false){
                this.is_initializing = show_progress;
                get(this.default_api+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.inventories = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        //console.info(this.inventories);
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                });
            },

            loadReports(){
                get(REPORTING+'?section='+REPORT_SECTIONS.INVENTORY)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.inventory_reports = res.data.results.data;
                        this.loadItems();
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

        },

        mounted() {
            this.is_initializing = true;
            this.loadCategories();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>