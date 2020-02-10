<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div  class="modal-body padding-0">
                    <section class="content padding-10" id="print_section">
                        <div class="invoice invoice-body invoice-border zero-border">
                            <div class="row">
                                <div class="col-md-9 col-sm-9 pull-left report-header">
                                    <h2 class="invoice-title txt-uppercase fs-15 cl-red"><b>{{organ_data.data.facility.app_data.name}}</b></h2>
                                    <h4 class="cl-444 fw-600">{{organ_data.data.facility.name}}({{organ_data.data.facility.category}})</h4>
                                    <h4 class="cl-787887">{{organ_data.data.facility.address}} </h4>
                                    <h4 class="cl-787887">{{organ_data.data.facility.email}}</h4>
                                    <h4 class="cl-787887">{{organ_data.data.facility.mobile}}</h4>
                                </div>
                                <div class="col-md-3 col-sm-3 pull-right">
                                    <img class="print-logo-size pull-right" :src="organ_data.data.facility.app_data.logo">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="invoice-title"><b>PURCHASE RECEIPT</b></h2>
                                </div>
                            </div>
                            <div class="row set-border-bottom">
                                <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20">
                                    <h3 class="cl-787887"><b>TO</b></h3>
                                    <h4 class="cl-444 fw-600 fs-12"> {{purchase.supplier.first_name}} {{purchase.supplier.other_name}}</h4>
                                    <h4 class="cl-444 fw-600 fs-12">{{purchase.supplier.company}}</h4>
                                    <h4 class="cl-787887 fs-12">{{purchase.supplier.email}}</h4>
                                    <h4 class="cl-787887 fs-12">{{purchase.supplier.mobile}}</h4>
                                    <h4 class="cl-787887 fs-12">{{purchase.supplier.address}}</h4>
                                </div>
                                <div class="col-md-4 col-sm-4 pull-right">
                                </div>
                                <div class="col-md-4 col-sm-4 pull-right">
                                    <span class="pull-right receipt-details">
                                        <h4 ><b class="invoice-heading"> PURCHASE NO : </b><span class="pull-right fs-12"> #{{purchase.trans_id}}</span></h4>
                                        <h4 ><b class="invoice-heading"> DATE  : </b> <span class="pull-right fs-12"> {{purchase.created_at}} </span></h4>
                                    </span>
                                </div>
                            </div>
                            <div class="row set-border-bottom">
                                <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20">
                                    <h3 ><b>PAYMENT METHOD </b></h3>
                                    <h4 class="fs-12 txt-uppercase cl-787887"> {{purchase.payment_method}}</h4>
                                </div>
                            </div>

                            <div class="row bg-white">

                                <div class="col-md-12 padding-right-0 padding-left-0">
                                    <table class="receipt-item-table table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">SKU</th>
                                                <th style="width: 55%;">Items</th>
                                                <th style="width: 13%;">Qty(Packs)</th>
                                                <th style="width: 12%;">Rate</th>
                                                <th style="width: 15%;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="noprintclass">
                                            <tr v-for="(item, index) in purchase.items" :key="'item_'+index">
                                                <td>{{index}}{{item.sku_code}}</td>
                                                <td>{{item.brand}} | {{item.brand_sector}} | {{item.unit_weight}}{{item.measure_unit_sympol}}</td>
                                                <td class="text-right">{{item.qty}}</td>
                                                <td class="text-right">{{formatMoney(item.pack_cost,'2','.',',')}}</td>
                                                <td class="text-right">{{formatMoney(item.total,'2','.',',')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="row bg-white">
                                <div class="col-md-4 col-sm-4 pull-left"></div>
                                <div class="col-md-3 col-sm-4 pull-left"></div>
                                <div class="col-md-5 col-sm-4 pull-right">
                                    <table class="table items-total-table">
                                        <tr>
                                            <td class="labs text-right" style="width:40%;">Total</td>
                                            <td class="text-right" style="width:60%;">KES: {{formatMoney(purchase.total)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="labs text-right">Discount({{purchase.discount_offered}}%)</td>
                                            <td class="text-right">
                                                KES: {{formatMoney(purchase.total-purchase.grand_total)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="labs text-right">Grand Total</td>
                                            <td class="text-right">
                                                KES: {{formatMoney(purchase.grand_total)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="labs text-right">Payment</td>
                                            <td class="text-right">KES: {{formatMoney(purchase.cash_paid)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="labs text-right">Payment Due</td>
                                            <td class="text-right">KES{{formatMoney(purchase.balance)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row bg-white">
                                <div class="col-md-12">
                                    <p>Message : {{purchase.note}}</p>
                                </div>
                            </div>
                        </div>
                    </section>    <!-- /.content -->
                </div>
                <div class="modal-footer">
                    <button type="button" @click="printReceipt('print_section')" class="btn btn-inventory">
                        <i class="fa fa-print" aria-hidden="true"></i> Print Receipt
                    </button>
                    <!-- <button class="btn btn-inventory">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i> Email Receipt
                    </button> -->
                    <button data-dismiss="modal" class="btn btn-inventory">
                        <i class="fa fa-close" aria-hidden="true"></i> Close
                    </button>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    import {formatMoney,print_divs} from '../../../../../../helpers/functionmixin';
    import Auth from '../../../../../../store/auth';
    export default {
        name: "PurchasePreviewModal",
        props: ['purchase','modal_id','organ_data'],
        methods: {
            formatMoney(amount) {
                return formatMoney(amount);
            },
            printReceipt(receipt_id){
                print_divs(receipt_id);
            }
        },
    }
</script>

<style scoped>

    .modal-content{
        min-width: 900px!important;
    }

    .report-header h3{
        text-transform: uppercase;
        font-size: 13px!important;
        font-weight: 600!important;
    }

    .report-header h4{
        font-size: 13px;
    }

    table.receipt-item-table thead tr th{
        font-size: 14px!important;
        height: 27px!important;
        box-shadow: inset 0 0 0 transparent, inset 0 0 0 transparent!important;
        text-transform: capitalize!important;
        border: 1px solid #e7461f!important;
        padding: 5px 10px!important;
        color: #fff!important;
        /* font-weight: 600!important; */
        background-color: #e7461f!important;
    }

    table.receipt-item-table tbody tr td{
        padding: 4px 10px!important;
        font-size: 12px!important;
    }
    table.items-total-table tr td{
        font-size: 12px!important;
        padding: 4px 10px!important;
        text-transform: capitalize!important;
        border: 0px solid transparent!important;
        border-bottom: 0px solid transparent!important;
    }
    table.items-total-table tr td.labs{
        font-weight: 600!important;
    }

</style>