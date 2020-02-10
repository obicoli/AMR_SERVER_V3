<template>
    <div v-if="page_ready" class="width-100-pc float-left">
        <div class="width-100-pc float-left invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20 max-width-800" :id="'receipt_'+customer_invoice.id">
            <div class="width-100-pc float-left">
                <div class="width-45-pc float-left text-center report-header">
                    <ribbon-maker :STATUS_ARRAY="customer_invoice.status" :PROCESS_STATUS="PROCESS_STATUS"></ribbon-maker>
                    <company-logo></company-logo>
                </div>
                <div class="width-30-pc float-right">
                    <h2 class="invoice-title txt-uppercase fs-20 width-100-pc text-right"><b>Tax Invoice</b></h2>
                    <table class="table overview-table">
                        <tbody>
                            <tr>
                                <td style="width:50%" class="text-right">Invoice#:</td>
                                <td class="text-right fw-600">{{customer_invoice.trans_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Reference:</td>
                                <td class="text-right fw-600">{{customer_invoice.reference_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Date:</td>
                                <td class="text-right fw-600">{{customer_invoice.trans_date}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Due Date:</td>
                                <td class="text-right fw-600">{{customer_invoice.due_date}}</td>
                            </tr>
                            <tr v-if="customer_invoice.overal_discount">
                                <td style="width:50%" class="text-right">Customer ID:</td>
                                <td class="text-right fw-600"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="width-100-pc float-left"></div>
                <div class="width-30-pc float-left mg-top-15">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-left-10 txt-uppercase">Billing Address:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd">
                                {{customer_invoice.customer.legal_name}}<br>
                                {{customer_invoice.customer.addresses.billing.address}}, {{customer_invoice.customer.addresses.billing.postal_code}}<br>
                                {{customer_invoice.customer.addresses.billing.phone}} | {{customer_invoice.customer.email}}<br>
                                {{customer_invoice.customer.addresses.billing.fax}}<br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="width-30-pc float-right mg-top-15">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-right-15 txt-uppercase width-100-pc text-right">Shipping Address:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd text-right">
                                {{customer_invoice.customer.legal_name}}<br>
                                {{customer_invoice.customer.addresses.billing.address}}, {{customer_invoice.customer.addresses.billing.postal_code}}<br>
                                {{customer_invoice.customer.addresses.billing.phone}} | {{customer_invoice.customer.email}}<br>
                                {{customer_invoice.customer.addresses.billing.fax}}<br>
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
                            <tr v-for="(customer_invoice_item,est_index) in customer_invoice.items" class="info" :key="'customer_invoice_'+est_index">
                                <td class="no-top-bottom-bd" style="width:50%;">{{customer_invoice_item.brand.name}} | {{customer_invoice_item.single_unit_weight}}{{customer_invoice_item.measure_unit.slug}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(customer_invoice_item.qty)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(customer_invoice_item.price.pack_retail_price)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(customer_invoice_item.line_discount)}}</td>
                                <td class="no-top-bottom-bd text-center">
                                    <span v-if="customer_invoice_item.taxes.length">{{formatMoneys(customer_invoice_item.taxes[customer_invoice_item.taxes.length-1].sales_rate)}}</span>
                                </td>
                                <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(customer_invoice_item.amount-customer_invoice_item.line_discount)}}</td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="txt-italic">{{customer_invoice.notes}}</td>
                                <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{currency+' '+formatMoneys(customer_invoice.total_discount)}} </a></td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">SubTotal:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(customer_invoice.net_total-customer_invoice.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Sales Tax:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(customer_invoice.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Shipping:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(customer_invoice.shipping_total)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Other:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(customer_invoice.other_total)}}</a>
                                </td>
                            </tr>
                            <tr class="title">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Total:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(customer_invoice.net_total)}}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="width-100-pc float-left mg-top-20">
                    <span class="cl-444 fs-12 fw-600">Notes:</span>
                    <p class="fs-12 cl-444">{{customer_invoice.terms_condition}}</p>
                </div>
                <div class="width-100-pc float-left">
                    <span class="cl-444 fs-12 fw-600">Terms & Conditions:</span>
                    <!-- <p class="fs-12 cl-444">{{customer_invoice.payment_term.notes}}</p> -->
                </div>
                <div class="width-100-pc float-left text-center accepted-row padding-top-10">
                    <hr>
                    <p class="fs-12 cl-444 fw-600">If you have any questions, please contact: [{{customer_invoice.status[customer_invoice.status.length-1].signatory.first_name}} {{customer_invoice.status[customer_invoice.status.length-1].signatory.mobile}} {{customer_invoice.status[customer_invoice.status.length-1].signatory.email}}]</p>
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
        name: "InvoicePreview",
        props: ['payment_made','customer_invoice','currency','show_actions','balance'],
        components: {
            CompanyLogo,RibbonMaker
        },
        data(){
            return {
                page_ready: false,
                payment: null,
                PROCESS_STATUS: PROCESS_STATUS,
            }
        },
        watch: {
            payment_made: function(new_data,old_data){
                this.payment = new_data;
            },
            // customer_invoice_id: function(new_dat,old_dat){
            //     this.customer_invoice_id = new_dat;
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
            if(this.payment_made || this.customer_invoice ){
                this.payment = this.payment_made;
                this.page_ready = true;
            }
        }
    }
</script>