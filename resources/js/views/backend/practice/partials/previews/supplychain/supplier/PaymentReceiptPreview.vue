<template>
    <div v-if="page_ready" class="width-100-pc float-left">
        <div v-if="show_actions" class="width-100-pc float-left mg-top-20 padding-right-10">
            <a @click="printReceipt('receipt_'+payment.id)" class="cl-blue-link fs-12 showOnHover"><i class="fa fa-print"></i> Print</a> | 
            <a @click="printReceipt('receipt_'+payment.id)" class="cl-blue-link fs-12 showOnHover"><i class="fa fa-envelope-o"></i> Email</a>
        </div>
        <div class="width-100-pc float-left invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20 max-width-800" :id="'receipt_'+payment.id">
            <div class="width-100-pc float-left">
                <div class="width-45-pc float-left text-center report-header">
                    <company-logo></company-logo>
                </div>
                <div class="width-30-pc float-right">
                    <h3 class="fw-600 cl-yellowish width-100-pc text-right fs-20 txt-uppercase">Payment Receipt</h3>
                    <table class="table overview-table">
                        <tbody>
                            <tr>
                                <td style="width:50%" class="text-right">Payment Date:</td>
                                <td class="text-right fw-600">{{payment.payment_date}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Payment Number:</td>
                                <td class="text-right fw-600">{{payment.trans_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Reference:</td>
                                <td class="text-right fw-600">{{payment.reference_number}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Payment mode:</td>
                                <td class="text-right fw-600">{{payment.payment_method}}</td>
                            </tr>
                            <tr>
                                <td style="width:50%" class="text-right">Paid through:</td>
                                <td class="text-right fw-600">{{payment.payment_method}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="width-100-pc float-left"></div>
                <div class="width-30-pc float-left mg-top-20">
                    <h3 class="fw-600 cl-444 width-100-pc fs-15 mg-left-10">Payment To:</h3>
                    <table class="sales-table width-100-pc">
                        <tr class="info">
                            <td colspan="2" class="width-100-pc no-bd">
                                <!-- {{payment.vendor.display_as}}<br> -->
                                {{payment.vendor.legal_name}}<br>
                                {{payment.vendor.addresses.billing.address}}, {{payment.vendor.addresses.billing.postal_code}}<br>
                                {{payment.vendor.addresses.billing.phone}} | {{payment.vendor.email}}<br>
                                {{payment.vendor.addresses.billing.fax}}<br>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="width-100-pc float-left">
                    <div v-if="balance" class="width-100-pc float-left mg-top-20 padding-20">
                        <h3 class="width-100-pc fs-15 mg-bottom-15 fw-600">Payment for:</h3>
                        <table class="payment-receipt-table width-100-pc">
                            <tr class="title">
                                <td class="" style="width:20%;">Bill#</td>
                                <td class="text-right" style="width:20%;">Bill Date</td>
                                <td class="text-right" style="width:20%;">Total Amount</td>
                                <td class="text-right" style="width:20%;">Payment Amount</td>
                                <td class="text-right" style="width:20%;">Balance</td>
                            </tr>
                            <tr v-for="(pay_bill,index) in payment.bills" class="info" :key="'pay_bill_'+index">
                                <td class="no-top-bottom-bd no-bd-right bd-left">{{pay_bill.trans_number}}</td>
                                <td class="no-top-bottom-bd text-right no-bd-right">{{pay_bill.bill_date}}</td>
                                <td class="no-top-bottom-bd text-right no-bd-right">{{formatMoneys(pay_bill.net_total)}}</td>
                                <td class="no-top-bottom-bd text-right no-bd-right">{{formatMoneys(pay_bill.paid_amount)}}</td>
                                <td class="no-top-bottom-bd text-right fw-600 bd-right">{{formatMoneys(balance)}}</td>
                            </tr>

                            <tr class="total">
                                <td class="fw-600"></td>
                                <td colspan="2" class="fw-600 text-right">Total Receipt Amount:</td>
                                <td class="fw-600 text-right total">{{currency+' '+formatMoneys(payment.amount)}}</td>
                                <td class="fw-600"></td>
                            </tr>
                        </table>
                    </div>
                    <div v-else class="width-100-pc float-left mg-top-20">
                        <h3 class="width-100-pc fs-15 mg-bottom-15 fw-600">Payment for:</h3>
                        <table class="payment-receipt-table width-100-pc">
                            <tr class="title">
                                <td class="txt-uppercase" style="width:25%;">Bill#.</td>
                                <td class="text-right txt-uppercase" style="width:25%;">Bill Date</td>
                                <td class="text-right txt-uppercase" style="width:25%;">Bill Amount</td>
                                <td class="text-right txt-uppercase" style="width:25%;">Payment Amount</td>
                            </tr>
                            <tr v-for="(pay_bill,index) in payment.bills" class="info" :key="'pay_bill_'+index">
                                <td class="no-top-bottom-bd no-bd-right bd-left">{{pay_bill.trans_number}}</td>
                                <td class="no-top-bottom-bd text-right no-bd-right">{{pay_bill.bill_date}}</td>
                                <td class="no-top-bottom-bd text-right no-bd-right">{{formatMoneys(pay_bill.net_total)}}</td>
                                <td class="no-top-bottom-bd text-right bd-right">{{formatMoneys(pay_bill.paid_amount)}}</td>
                            </tr>
                            <tr class="total">
                                <td class="fw-600"></td>
                                <td colspan="2" class="fw-600 text-right">Total Receipt Amount:</td>
                                <td class="fw-600 text-right total">{{currency+' '+formatMoneys(payment.amount)}}</td>
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
        name: "",
        props: ['payment_made','currency','show_actions','balance'],
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
            bill_id: function(new_dat,old_dat){
                this.bill_id = new_dat;
            }
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
            if(this.payment_made){
                this.payment = this.payment_made;
                this.page_ready = true;
            }
        }
    }
</script>