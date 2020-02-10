<template>
    <div v-if="page_ready" class="width-100-pc float-left">
        <div class="width-100-pc float-left invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20 max-width-800" :id="'receipt_'+estimate.id">
            <div class="width-100-pc float-left">
                <div class="width-45-pc float-left text-center report-header">
                    <ribbon-maker :STATUS_ARRAY="estimate.status" :PROCESS_STATUS="PROCESS_STATUS"></ribbon-maker>
                    <company-logo></company-logo>
                </div>
                <div class="width-30-pc float-right">
                    <h2 class="invoice-title txt-uppercase fs-20 width-100-pc text-right"><b>Quotation</b></h2>
                    <table class="table overview-table">
                        <tbody>
                            <tr>
                                <td style="width:50%" class="text-right">Number:</td>
                                <td class="text-right fw-600">{{estimate.trans_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Reference:</td>
                                <td class="text-right fw-600">{{estimate.reference_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Date:</td>
                                <td class="text-right fw-600">{{estimate.trans_date}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Due Date:</td>
                                <td class="text-right fw-600">{{estimate.due_date}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="width-100-pc float-left"></div>
                <div class="width-30-pc float-left mg-top-15">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-left-10 txt-uppercase">Billed To:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd">
                                {{estimate.customer.legal_name}}<br>
                                {{estimate.customer.addresses.billing.address}}, {{estimate.customer.addresses.billing.postal_code}}<br>
                                {{estimate.customer.addresses.billing.phone}} | {{estimate.customer.email}}<br>
                                {{estimate.customer.addresses.billing.fax}}<br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="width-30-pc float-right mg-top-15">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-right-15 txt-uppercase width-100-pc text-right">Shipped To:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd text-right">
                                {{estimate.customer.legal_name}}<br>
                                {{estimate.customer.addresses.billing.address}}, {{estimate.customer.addresses.billing.postal_code}}<br>
                                {{estimate.customer.addresses.billing.phone}} | {{estimate.customer.email}}<br>
                                {{estimate.customer.addresses.billing.fax}}<br>
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
                            <tr v-for="(estimate_item,est_index) in estimate.items" class="info" :key="'estimate_'+est_index">
                                <td class="no-top-bottom-bd" style="width:50%;">{{estimate_item.brand.name}} | {{estimate_item.single_unit_weight}}{{estimate_item.measure_unit.slug}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(estimate_item.qty)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(estimate_item.price.pack_retail_price)}}</td>
                                <td class="no-top-bottom-bd text-right">{{formatMoneys(estimate_item.line_discount)}}</td>
                                <td class="no-top-bottom-bd text-center">
                                    <span v-if="estimate_item.taxes.length">{{formatMoneys(estimate_item.taxes[estimate_item.taxes.length-1].sales_rate)}}</span>
                                    <span v-else></span>
                                </td>
                                <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(estimate_item.amount-estimate_item.line_discount)}}</td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="txt-italic">{{estimate.notes}}</td>
                                <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{currency+' '+formatMoneys(estimate.total_discount)}} </a></td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">SubTotal:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(estimate.net_total-estimate.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Sales Tax:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(estimate.total_tax)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Shipping:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(estimate.shipping_total)}}</a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Other:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(estimate.other_total)}}</a>
                                </td>
                            </tr>
                            <tr class="title">
                                <td style="width:50%;" colspan="2" class="no-bd"></td>
                                <td class="txt-uppercase fw-600" colspan="4">
                                    <a class="float-left">Total Quote:</a>
                                    <a class="float-right">{{currency+' '+formatMoneys(estimate.net_total)}}</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="width-100-pc float-left mg-top-20">
                    <p class="fs-12 cl-444">{{estimate.terms_condition}}</p>
                </div>
                <div class="width-100-pc float-left fw-600 accepted-row">
                    <span class="cl-444 fs-12 fw-600">Customer Acceptance:</span>
                    <table class="sales-table">
                        <tr class="info">
                            <td style="width:50%" class="">.</td>
                            <td style="width:30%" class=""></td>
                            <td style="width:20%" class=""></td>
                        </tr>
                        <tr class="info">
                            <td style="width:50%" class="no-bd">Signature</td>
                            <td style="width:30%" class="no-bd">Printed name</td>
                            <td style="width:20%" class="no-bd">Date</td>
                        </tr>
                    </table>
                </div>
                <div class="width-100-pc float-left text-center accepted-row padding-top-10">
                    <hr>
                    <p class="fs-12 cl-444 fw-600">If you have any questions, please contact: [{{estimate.status[estimate.status.length-1].signatory.first_name}} {{estimate.status[estimate.status.length-1].signatory.mobile}} {{estimate.status[estimate.status.length-1].signatory.email}}]</p>
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
        name: "EstimatePreview",
        props: ['payment_made','estimate','currency','show_actions','balance'],
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
            // estimate_id: function(new_dat,old_dat){
            //     this.estimate_id = new_dat;
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
            if(this.payment_made || this.estimate ){
                this.payment = this.payment_made;
                this.page_ready = true;
            }
        }
    }
</script>