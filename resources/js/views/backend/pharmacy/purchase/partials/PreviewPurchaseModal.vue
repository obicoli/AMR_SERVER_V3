<template>

    <div class="modal-content">

        <div  class="modal-body padding-0">
            <section class="content padding-10" id="print-section">
                <div class="invoice invoice-body invoice-border">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 pull-left report-header">
                            <h3>{{organ_data.practice_name}}| Branch name goes here</h3>
                            <h4>{{organ_data.practice_address}} </h4>
                            <h4>{{organ_data.practice_email}}</h4>
                            <h4>{{organ_data.practice_mobile}}</h4>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <img class="print-logo-size pull-right" :src="organ_data.practice_logo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="invoice-title"><b>PURCHASE RECEIPT</b></h2>
                        </div>
                    </div>
                    <div class="row set-border-bottom">
                        <div class="col-md-4 col-sm-4 pull-left to-address">
                            <h3 ><b>TO </b></h3>
                            <h4 class="to-name"> {{purchase.supplier.name}}</h4>
                            <h4>{{purchase.supplier.email}}</h4>
                            <h4>{{purchase.supplier.phone}}</h4>
                            <p> </p>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <span class="pull-right receipt-details">
                                <h4 ><b class="invoice-heading"> PURCHASE NO : </b><span class="pull-right" > #{{purchase.trans_id}}</span></h4>
                                <h4 ><b class="invoice-heading"> DATE  : </b> <span class="pull-right" > {{purchase.created_at}} </span></h4>
                            </span>
                        </div>
                    </div>
                    <div class="row set-border-bottom">
                        <div class="col-md-4 col-sm-4 pull-left to-address">
                            <h3 ><b>PAYMENT METHOD </b></h3>
                            <h4 > {{purchase.payment_method}}</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <table class="items table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">SNO</th>
                                        <th style="width: 40%">Items</th>
                                        <th style="width: 15%">Packs</th>
                                        <th style="width: 15%">Rate</th>
                                        <th style="width: 20%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="noprintclass">
                                    <tr v-for="(item, index) in purchase.items">
                                        <td>{{index}}{{item.trans_id}}</td>
                                        <td>{{item.name}}</td>
                                        <td>{{item.qty}}</td>
                                        <td>{{formatMoney(item.pack_cost,'2','.',',')}}</td>
                                        <td>{{formatMoney(item.total,'2','.',',')}}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 pull-left"></div>
                        <div class="col-md-4 col-sm-4 pull-left"></div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <table class="table footer-table">
                                <tr>
                                    <td>TOTAL</td>
                                    <td>{{formatMoney(purchase.total,'2','.',',')}}</td>
                                </tr>
                                <tr>
                                    <td>DISCOUNT(%)</td>
                                    <td>
                                        {{purchase.discount_offered}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>GRAND TOTAL</td>
                                    <td>
                                        {{formatMoney(purchase.grand_total,'2','.',',')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>PAYMENT</td>
                                    <td>{{formatMoney(purchase.cash_paid,'2','.',',')}}</td>
                                </tr>
                                <tr>
                                    <td>PAYMENT DUE USD</td>
                                    <td>{{formatMoney(purchase.balance,'2','.',',')}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Message : {{purchase.description}}</p>
                        </div>
                    </div>
                </div>
            </section>    <!-- /.content -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-inventory">
                <i class="fa fa-print" aria-hidden="true"></i> Print Receipt
            </button>
            <button class="btn btn-inventory">
                <i class="fa fa-envelope-o" aria-hidden="true"></i> Email Receipt
            </button>
            <button data-dismiss="modal" class="btn btn-inventory">
                <i class="fa fa-close" aria-hidden="true"></i> Close
            </button>
        </div>
    </div>

</template>

<script>
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";

    export default {
        name: "PreviewPurchaseModal",
        props: ['purchase'],
        data(){
            return {
                organ_data: {},
            }
        },
        methods: {
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
        },
        mounted() {
            this.organ_data = Auth.getCurrentAccount('account');
            //console.info(this.organ_data);
        }
    }
</script>

<style scoped>

</style>