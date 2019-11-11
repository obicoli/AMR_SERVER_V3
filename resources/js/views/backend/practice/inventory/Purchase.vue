<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">

                <div class="col-lg-12">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-60-pc">
                                    <h5>
                                        Inventory | <small>Purchases List :</small><small class="fs-13 cl-444">By default it will fetch the purchases of current month.</small>
                                    </h5>
                                </div>
                                <div class="pull pull-right width-30-pc text-right padding-right-70">
                                    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown" style="box-shadow: inset 0 -1px 0 #DFDFDF;">
                                        <button data-toggle="modal" data-target="#purchase_modal_id" type="button" class="btn combo-button primary">+ Create Purchase</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu right-0" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item" href="#"> Bill</a>
                                                <a class="dropdown-item" href="#"> Expense</a>
                                                <a class="dropdown-item" href="#"> Estimate</a>
                                                <a class="dropdown-item" href="#"> Request</a>
                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#place_order_modal_id"> Place Order</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content bg-white mg-top-30">

                        <div class="row">

                            <div class="col-xs-12 col-md-12 col-sm-12">

                                <div class="box border-top-0 border-bottom-0 border-radius-0">

                                    <div class="box-header box-header-custom">
                                        <div class="pull pull-right width-80-pc">
                                            <div class="filters width-100-pc">
                                                <div class="filter-block form-inline width-40-pc pull-left text-right">
                                                    <span class="name">Status: </span>
                                                    <div class="filter-group input-group">
                                                        <span class="filter active">All</span>
                                                        <span class="filter">Pending</span>
                                                        <span class="filter">Approved</span>
                                                    </div>
                                                </div>

                                                <div class="filter-block form-inline width-60-pc pull-right text-right">
                                                    <span class="name">Type: </span>
                                                    <div class="filter-group input-group">
                                                        <span class="filter active">All</span>
                                                        <span class="filter ng-binding">Direct Procurement</span>
                                                        <span class="filter">Competitive</span>
                                                        <span class="filter">Attach Fragment</span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="box-body bg-white padding-0">
                                        <table class="items table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th style="width: 8%">#Trans. ID</th>
                                                <th style="width: 10%">Bill No.</th>
                                                <th style="width: 10%">Date</th>
                                                <th style="width: 10%">Total</th>
                                                <th style="width: 10%">Cash Paid</th>
                                                <th style="width: 10%">Balance</th>
                                                <th style="width: 12%">Payment Date</th>
                                                <th style="width: 9%">Method</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 11%"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="noprintclass">

                                                <tr v-if="purchases.length < 1">
                                                    <td colspan="10" style="color:#f10; text-align:center;">No data to display</td>
                                                </tr>
                                                <tr v-for="(purcha,index) in purchases" :key="'purchases'+index">
                                                    <!-- <td>{{purcha.trans_id}}</td>
                                                    <td>{{purcha.bill_no}}</td>
                                                    <td>{{purcha.created_at}}</td>
                                                    <td>{{formatMoney(purcha.total,'2','.',',')}} </td>
                                                    <td>{{formatMoney(purcha.cash_paid,'2','.',',')}}</td>
                                                    <td>{{formatMoney(purcha.balance,'2','.',',')}}</td>
                                                    <td>{{purcha.payment_date}}</td>
                                                    <td>{{purcha.payment_method}}</td>
                                                    <td>{{purcha.status}}</td>
                                                    <td>
                                                        <a data-toggle="modal" data-target="#preview_purchase_modal" @click="chosed_purchase(purcha)"  title="Preview" class="pointer-cursor fs-13 cl-444 showOnHover"><i class="fa fa-picture-o"></i></a>
                                                        <a v-if="purcha.status === 'Requested'" data-toggle="modal" data-target="#forward_to_procure" @click="chosed_purchase(purcha)" title="Forward" class="pointer-cursor fs-13 cl-444 showOnHover"><i class="fa fa-mail-forward"></i></a>
                                                        <a v-if="purcha.status === 'Received'" title="Add to Stock" class="pointer-cursor fs-13 cl-444 showOnHover"><i class="fa fa-plus"></i></a>
                                                        <a v-if="purcha.status === 'Approved'" title="Order" data-toggle="modal" data-target="#order_purchase_modal" @click="chosed_purchase(purcha)" class="pointer-cursor fs-13 cl-444 showOnHover"><i class="fa fa-shopping-cart"></i></a>
                                                        <a v-if="purcha.status === 'Pending Approval'" data-toggle="modal" data-target="#approve_purchase_modal" @click="chosed_purchase(purcha)"  title="Approve" class="pointer-cursor fs-13 cl-444 showOnHover"><i class="fa fa-check-square-o"></i></a>
                                                        <a v-if="purcha.status === 'Ordered'" data-toggle="modal" data-target="#receive_purchase_modal" @click="chosed_purchase(purcha)"  title="Receive purchase" class="pointer-cursor fs-13 cl-444 showOnHover"><i class="fa fa-shopping-basket"></i></a>
                                                        <a v-if="purcha.status !== 'Received'" title="Cancel" class="pointer-cursor fs-13 cl-red showOnHover"><i class="fa fa-close"></i></a>
                                                    </td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </section>

                    <create-purchase v-if="is_page_ready" :modal_id="'purchase_modal_id'" modal_title="Create Purchase" :practice_id="practice_id"></create-purchase>
                    <po-modal v-if="is_page_ready" :modal_id="'place_order_modal_id'" :suppliers="suppliers" modal_title="Place Order" :practice_id="practice_id" :practice_list="practice_list" :po_number="'00987'" v-on:requestVendorForm="showVendor"></po-modal>
                    <supplier-modal v-if="is_page_ready" :suppliers="suppliers" :practice_id="practice_id" :modal_id="'new_vendor_modal_id'" :user_mode="'Create'" :title="'Supplier Information'" v-on:supplierAdded="load_suppliers"></supplier-modal>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarHr from "../partials/sidebars/SideBarHr"
    import Loading from "../../../../components/loads/ProgRess";
    import DeleteModal from '../partials/modals/DeleteModal'
    import CreatePurchase from '../partials/modals/product/CreatePurchase';
    import SupplierModal from '../partials/modals/vendors/SupplierModal';
    import PoModal from '../partials/modals/product/PoModal';
    import ProcessingOverlay from '../../../progress/ProcessingOverlay';
    // import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal'
    // import NewProductItemModal from '../../pharmacy/product/partials/NewProductItemModal'
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";

    // import PreviewPurchaseModal from '../../pharmacy/purchase/partials/PreviewPurchaseModal'
    // import ApprovePurchaseModal from '../../pharmacy/purchase/partials/ApprovePurchaseModal'
    // import ForwardPurchaseModal from '../../pharmacy/purchase/partials/ForwardPurchaseModal'
    // import OrderPurchaseModal from '../../pharmacy/purchase/partials/OrderPurchaseModal'
    // import ReceivePurchaseModal from '../../pharmacy/purchase/partials/ReceivePurchaseModal'
    // import CreateNewPurchaseModal from '../../pharmacy/purchase/partials/CreateNewPurchaseModal'

    export default {
        name: "Purchase",
        components: {TopNavBar, SideBar,SideBarHr,Loading,DeleteModal,
        CreatePurchase,PoModal,SupplierModal,ProcessingOverlay},
        data(){
            return {
                //purchase: {},
                purchases: [],
                suppliers: [],
                practice_list: [],
                is_purchase_chosen: false,
                modal_title_forward: 'Forward purchase',
                practice_id: '',
                is_page_ready: false,
                progress_overlay: 'hide',
            }
        },
        methods: {

            load_purchases: function () {
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Purchases')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.purchases = res.data.results;
                            //console.info(this.purchases);
                            //this.processing = false;
                            //this.is_page_ready = true;
                            this.load_suppliers();
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        //this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    //this.processing = false;
                    this.progress_overlay = "hide";
                });
            },
            load_suppliers: function () {
                //this.processing = true;
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Suppliers')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.suppliers = res.data.results.resources;
                            console.info(this.suppliers);
                            //this.processing = false;
                            this.is_page_ready = true;
                            //this.progress_overlay = "hide";
                            this.load_practices();
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        //this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    //this.processing = false;
                    this.progress_overlay = "hide";
                });
            },
            load_practices: function () {
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Practices')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.practice_list = res.data.results.resources;
                            console.info(this.practice_list);
                            this.is_page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        //this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    //this.processing = false;
                    this.progress_overlay = "hide";
                });
            },
            formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
                try {
                    decimalCount = Math.abs(decimalCount);
                    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                    const negativeSign = amount < 0 ? "-" : "";

                    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                    let j = (i.length > 3) ? i.length % 3 : 0;

                    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
                } catch (e) {
                    console.log(e)
                }
            },
            showVendor(){
                $("#new_vendor_modal_id").modal('show');
            },
        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.load_purchases();
        }
    }
</script>

<style scoped>

</style>