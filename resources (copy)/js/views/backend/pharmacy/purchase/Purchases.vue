<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <page-header :purchases="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-50-pc">
                            <h5>
                                Purchases | <small></small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                        <div class="pull pull-right width-50-pc text-right">
                            <a v-bind:href="'/inventory/items'" class="btn btn-inventory">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Go to Items
                            </a>
                            <button type="button" data-toggle="modal" data-target="#create_new_purchase_modal"  class="btn btn-inventory">
                                Create purchase
                            </button>
<!--                            <a v-bind:href="'/purchases/create'"  class="btn btn-inventory">-->
<!--                                Create purchase-->
<!--                            </a>-->
                            <a v-bind:href="'/inventory/stock/consume'"  class="btn btn-inventory">
                                Return purchase
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">

                    <div class="col-xs-12 col-md-12 col-sm-12">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                            <div class="box-header box-header-custom">

                                <div class="pull-left pull width-20-pc">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">search</option>
                                    </select>
                                </div>
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
                                        <tr v-if="purchases.length > 0" v-for="purcha in purchases">
                                            <td>{{purcha.trans_id}}</td>
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
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="preview_purchase_modal">
                <div class="modal-dialog modal-lg modal-dialog-centered zoomInUp flipOutX">
                    <preview-purchase-modal v-if="is_purchase_chosen" :purchase="purchase"></preview-purchase-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="forward_to_procure">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <forward-purchase-modal v-if="is_purchase_chosen" :purchase="purchase" :modal_title="modal_title_forward" :use_type="'Forward'" v-on:purchaseForwarded="load_purchases"></forward-purchase-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="approve_purchase_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <approve-purchase-modal v-if="is_purchase_chosen" :purchase="purchase" :modal_title="'Approve purchase'" :use_type="'Approve'" v-on:purchaseApproved="load_purchases"></approve-purchase-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="order_purchase_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <order-purchase-modal v-if="is_purchase_chosen" :purchase="purchase" :modal_title="'Order purchase'" :use_type="'Approve'" v-on:purchaseOrder="load_purchases"></order-purchase-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="receive_purchase_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <receive-purchase-modal v-if="is_purchase_chosen" :purchase="purchase" :modal_title="'Order purchase'" :use_type="'Approve'" v-on:purchaseReceived="load_purchases"></receive-purchase-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->


            <!-- (Ajax Modal)-->
            <div class="modal fade" id="create_new_purchase_modal">
                <div class="modal-dialog modal-lg-custom-90 modal-dialog-centered zoomInUp flipOutX">
                    <create-new-purchase-modal v-on:purchaseCreated="load_purchases"></create-new-purchase-modal>
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
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";
    import PreviewPurchaseModal from './partials/PreviewPurchaseModal'
    import ApprovePurchaseModal from './partials/ApprovePurchaseModal'
    import ForwardPurchaseModal from './partials/ForwardPurchaseModal'
    import OrderPurchaseModal from './partials/OrderPurchaseModal'
    import ReceivePurchaseModal from './partials/ReceivePurchaseModal'
    import CreateNewPurchaseModal from './partials/CreateNewPurchaseModal'
    export default {
        name: "Purchases",
        components: {PageHeader,PageFooter,PreviewPurchaseModal,ForwardPurchaseModal,
            ApprovePurchaseModal,OrderPurchaseModal,ReceivePurchaseModal,CreateNewPurchaseModal},
        data(){
            return {
                purchase: {},
                purchases: [],
                is_purchase_chosen: false,
                modal_title_forward: 'Forward purchase',
            }
        },
        methods: {

            load_purchases: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Purchases')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.purchases = res.data.results;
                            console.info(this.purchases);
                            this.processing = false;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
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
            chosed_purchase(purchase_){
                this.purchase = purchase_;
                this.is_purchase_chosen = true;
            }
        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.load_purchases();
        }
    }
</script>

<style scoped>

</style>