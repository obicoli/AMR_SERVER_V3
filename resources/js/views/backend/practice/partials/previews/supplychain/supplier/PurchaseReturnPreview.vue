<template>
    <div v-if="page_ready" class="width-100-pc float-left">
        <div v-if="show_actions" class="width-100-pc float-left mg-top-20 padding-right-10">
            <a @click="printReceipt('receipt_'+purchase_return.id)" class="cl-blue-link fs-12 showOnHover"><i class="fa fa-print"></i> Print</a> | 
            <a @click="printReceipt('receipt_'+purchase_return.id)" class="cl-blue-link fs-12 showOnHover"><i class="fa fa-envelope-o"></i> Email</a>
        </div>
        <div class="width-100-pc float-left invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20 max-width-800" :id="'receipt_'+purchase_return.id">
            <div class="width-100-pc float-left">
                <div class="width-45-pc float-left text-center report-header">
                    <company-logo></company-logo>
                </div>
                <div class="width-30-pc float-right">
                    <h2 class="invoice-title txt-uppercase fs-20 width-100-pc text-right"><b>Purchase Return</b></h2>
                    <table class="table overview-table">
                        <tbody>
                            <tr>
                                <td style="width:50%" class="text-right">Number:</td>
                                <td class="text-right fw-600">{{purchase_return.trans_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Date:</td>
                                <td class="text-right fw-600">{{purchase_return.return_date}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Due Date:</td>
                                <td class="text-right fw-600">{{purchase_return.return_date}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Reference:</td>
                                <td class="text-right fw-600">{{purchase_return.reference_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Overal Discount(%):</td>
                                <td class="text-right fw-600">{{formatMoneys(0)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="width-100-pc float-left"></div>
                <div class="width-30-pc float-left mg-top-30">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-left-10 txt-uppercase">Return From:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd">
                                {{purchase_return.vendor.legal_name}}<br>
                                {{purchase_return.vendor.addresses.billing.address}}, {{purchase_return.vendor.addresses.billing.postal_code}}<br>
                                {{purchase_return.vendor.addresses.billing.phone}} | {{purchase_return.vendor.email}}<br>
                                {{purchase_return.vendor.addresses.billing.fax}}<br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="width-30-pc float-right mg-top-30">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-right-15 txt-uppercase width-100-pc text-right">Return To:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd text-right">
                                {{purchase_return.vendor.legal_name}}<br>
                                {{purchase_return.vendor.addresses.billing.address}}, {{purchase_return.vendor.addresses.billing.postal_code}}<br>
                                {{purchase_return.vendor.addresses.billing.phone}} | {{purchase_return.vendor.email}}<br>
                                {{purchase_return.vendor.addresses.billing.fax}}<br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="width-100-pc float-left">
                    <div class="width-100-pc float-left mg-top-20">
                        <table class="sales-table width-100-pc">
                            <tr class="title">
                                <td class="" style="width:50%;">Item</td>
                                <td class="text-right" style="width:10%;">Qty</td>
                                <td class="text-right" style="width:10%;">Rate</td>
                                <td class="text-right" style="width:10%;">Disc(%)</td>
                                <td class="text-center" style="width:5%;">VAT(%)</td>
                                <td class="text-right" style="width:15%;">Line Total</td>
                            </tr>
                            <tr v-for="(po_item,est_index) in purchase_return.items" class="info" :key="'estimate_'+est_index">
                                <td class="no-top-bottom-bd" style="width:50%;">{{po_item.brand.name}} | {{po_item.single_unit_weight}}{{po_item.measure_unit.slug}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.qty)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.price.pack_cost)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.line_discount)}}</td>
                                <td class="no-top-bottom-bd text-center"><span v-if="po_item.line_taxation.length">x</span></td>
                                <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(po_item.amount-po_item.line_discount)}}</td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="txt-italic">{{purchase_return.notes}}</td>
                                <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{currency+' '+formatMoneys(purchase_return.total_discount)}} </a></td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">SubTotal:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(purchase_return.net_total-purchase_return.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Sales Tax:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(purchase_return.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Shipping:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(purchase_return.shipping_total)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Other:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(purchase_return.other_total)}}</a>
                                </td>
                            </tr>
                            <tr class="title">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Total:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(purchase_return.net_total)}}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="width-100-pc float-left text-center mg-top-35 padding-20">
                    <h4 class="fs-12 txt-italic">Thank You for Doing Business with us</h4>
                </div>
            </div>
        </div>
    </div>


</template>
<script>
    import CompanyLogo from "../../../CompanyLogo";
    import { formatMoney, printing } from '../../../../../../../helpers/functionmixin';
    export default {
        name: "PurchaseReturnPreview",
        props: ['payment_made','purchase_return','currency','show_actions','balance'],
        components: {
            CompanyLogo
        },
        data(){
            return {
                page_ready: false,
                payment: null,
            }
        },
        watch: {
            payment_made: function(new_data,old_data){
                this.payment = new_data;
            },
            // purchase_return_id: function(new_dat,old_dat){
            //     this.purchase_return_id = new_dat;
            // }
        },
        methods: {
            formatMoneys(money_to){
                return formatMoney(money_to);
            },
            printReceipt(receipt_id){
                printing(receipt_id);
            }
        },
        mounted(){
            if(this.payment_made || this.purchase_return ){
                this.payment = this.payment_made;
                this.page_ready = true;
            }
        }
    }
</script>