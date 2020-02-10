<template>
    <div v-if="page_ready" class="width-100-pc float-left">
        <div class="width-100-pc float-left invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20 max-width-800" :id="'component_'+salesreceip.id">
            <div class="width-100-pc float-left">
                <div class="width-45-pc float-left text-center report-header">
                    <ribbon-maker :STATUS_ARRAY="salesreceip.status" :PROCESS_STATUS="PROCESS_STATUS"></ribbon-maker>
                    <company-logo></company-logo>
                </div>
                <div class="width-30-pc float-right">
                    <h2 class="invoice-title txt-uppercase fs-20 width-100-pc text-right"><b>{{salesreceip.document_name}}</b></h2>
                    <table class="table overview-table">
                        <tbody>
                            <tr>
                                <td style="width:50%" class="text-right">Receipt#:</td>
                                <td class="text-right fw-600">{{salesreceip.trans_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Reference:</td>
                                <td class="text-right fw-600">{{salesreceip.reference_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Receipt Date:</td>
                                <td class="text-right fw-600">{{salesreceip.trans_date}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="width-100-pc float-left"></div>
                <div v-if="salesreceip.customer" class="width-30-pc float-left mg-top-15">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-left-10 txt-uppercase">Sold To:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd">
                                {{salesreceip.customer.legal_name}}<br>
                                {{salesreceip.customer.addresses.billing.address}}, {{salesreceip.customer.addresses.billing.postal_code}}<br>
                                {{salesreceip.customer.addresses.billing.phone}} | {{salesreceip.customer.email}}<br>
                                {{salesreceip.customer.addresses.billing.fax}}<br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="width-100-pc float-left">
                    <div class="width-100-pc float-left mg-top-15">
                        <table class="sales-table width-100-pc">
                            <tr class="title">
                                <td class="" style="width:50%;">Item</td>
                                <td class="text-right" style="width:10%;">Qty</td>
                                <td class="text-right" style="width:10%;">Rate</td>
                                <td class="text-right" style="width:10%;">Disc(%)</td>
                                <td class="text-center" style="width:5%;">VAT(%)</td>
                                <td class="text-right" style="width:15%;">Line Total</td>
                            </tr>
                            <tr v-for="(receipt_item,est_index) in salesreceip.items" class="info" :key="'receipt_'+est_index">
                                <td class="no-top-bottom-bd" style="width:50%;">{{receipt_item.brand.name}} | {{receipt_item.single_unit_weight}}{{receipt_item.measure_unit.slug}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(receipt_item.qty)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(receipt_item.price.pack_retail_price)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(receipt_item.line_discount)}}</td>
                                <td class="no-top-bottom-bd text-center">
                                    <span v-if="receipt_item.taxes.length">{{formatMoneys(receipt_item.taxes[receipt_item.taxes.length-1].sales_rate)}}</span>
                                </td>
                                <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(receipt_item.amount-receipt_item.line_discount)}}</td>
                            </tr>

                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="txt-italic">{{salesreceip.notes}}</td>
                                <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{currency+' '+formatMoneys(salesreceip.total_discount)}} </a></td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">SubTotal:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(salesreceip.net_total-salesreceip.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Sales Tax:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(salesreceip.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Shipping:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(salesreceip.shipping_total)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Other:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(salesreceip.other_total)}}</a>
                                </td>
                            </tr>
                            <tr class="title">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Total:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(salesreceip.net_total)}}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="width-100-pc float-left mg-top-20">
                    <span class="cl-444 fs-12 fw-600">Notes:</span>
                    <p class="fs-12 cl-444">{{salesreceip.terms_condition}}</p>
                </div>
                <div class="width-100-pc float-left">
                    <span class="cl-444 fs-12 fw-600">Terms & Conditions:</span>
                    <!-- <p class="fs-12 cl-444">{{salesreceip.payment_term.notes}}</p> -->
                </div>
                <div class="width-100-pc float-left text-center accepted-row padding-top-10">
                    <hr>
                    <p class="fs-12 cl-444 fw-600">If you have any questions, please contact: [{{salesreceip.status[salesreceip.status.length-1].signatory.first_name}} {{salesreceip.status[salesreceip.status.length-1].signatory.mobile}} {{salesreceip.status[salesreceip.status.length-1].signatory.email}}]</p>
                </div>
            </div>
        </div>
    </div>


</template>
<script>
    import CompanyLogo from "../../../CompanyLogo";
    import RibbonMaker from "../../../RibbonMaker";
    import { formatMoney, printing } from '../../../../../../../helpers/functionmixin';
    import {PROCESS_STATUS} from '../../../../../../../helpers/process_status';
    export default {
        name: "CashReceiptPreview",
        props: ['payment_made','salesreceipt','currency','show_actions','balance'],
        components: {
            CompanyLogo,RibbonMaker
        },
        data(){
            return {
                page_ready: false,
                salesreceip: null,
                PROCESS_STATUS: PROCESS_STATUS,
            }
        },
        watch: {
            salesreceipt: function(new_data,old_data){
                this.salesreceip = new_data;
            },
        },
        methods: {
            formatMoneys(money_to){
                return formatMoney(money_to);
            },
            // printReceipt(receipt_id){
            //     printing(receipt_id);
            // }
        },
        mounted(){
            if(this.salesreceipt ){
                this.salesreceip = this.salesreceipt;
                this.page_ready = true;
            }
        }
    }
</script>