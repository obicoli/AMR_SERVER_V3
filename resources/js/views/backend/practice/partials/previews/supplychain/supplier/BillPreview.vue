<template>
    <div class="width-100-pc float-left invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20 max-width-800" id="po_component_id_0">
        <div class="width-100-pc float-left">
            <div class="width-45-pc float-left text-center report-header">
                <!-- <ribbon-maker :STATUS_ARRAY="bill.status" :PROCESS_STATUS="PROCESS_STATUS"></ribbon-maker>
                <company-logo></company-logo> -->
            </div>
            <div class="width-40-pc float-right text-right">
                <h2 class="invoice-title txt-uppercase fs-20"><b>Bill Receipt</b></h2>
                <table class="document-title">
                    <tr>
                        <td style="width:50%;" class="no-bd text-right title">Date:</td>
                        <td style="width:50%;" class="text-right info">{{bill.bill_date}}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;" class="no-bd text-right title">Bill No.</td>
                        <td style="width:50%;" class="text-right info">{{bill.trans_number}}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;" class="no-bd text-right title">Ref:</td>
                        <td style="width:50%;" class="text-right info">{{bill.ref_number}}</td>
                    </tr>
                    <tr>
                        <td style="width:50%;" class="no-bd text-right title">Due Date:</td>
                        <td style="width:50%;" class="text-right info">{{bill.bill_due_date}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="width-100-pc float-left set-border-bottom">
            <div class="width-40-pc float-left to-address padding-top-20 mg-top-20">
                <table class="sales-table width-100-pc">
                    <tr class="title">
                        <td colspan="2" class="">Billing:</td>
                    </tr>
                    <tr class="info">
                        <td colspan="2" class="width-100-pc no-bd">
                            {{bill.vendor.display_as}}<br>
                            {{bill.vendor.legal_name}}<br>
                            {{bill.vendor.addresses.billing.address}}, {{bill.vendor.addresses.billing.postal_code}}<br>
                            {{bill.vendor.addresses.billing.phone}} | {{bill.vendor.email}}<br>
                            {{bill.vendor.addresses.billing.fax}}<br>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="width-40-pc float-right to-address padding-top-20 mg-top-20 text-right">
                <table class="sales-table width-100-pc">
                    <tr class="title">
                        <td colspan="2" class="">Shipping</td>
                    </tr>
                    <tr class="info">
                        <td colspan="2" class="width-100-pc no-bd">
                            <!-- {{bill.shipping.name}}<br>
                            {{bill.shipping.address}}<br>
                            {{bill.shipping.postal_code}} {{bill.shipping.city}}, {{bill.shipping.country}}<br>
                            {{bill.shipping.phone}}<br>
                            {{bill.shipping.email}}<br> -->
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="width-100-pc float-left">
            <div class="width-100-pc float-left mg-top-20">
                <table class="sales-table width-100-pc">
                    <tr class="title">
                        <td class="" style="width:50%;">Item</td>
                        <td class="text-right" style="width:10%;">Qty</td>
                        <td class="text-right" style="width:10%;">Rate</td>
                        <td class="text-right" style="width:10%;">Disc</td>
                        <td class="text-center" style="width:5%;">VAT(%)</td>
                        <td class="text-right" style="width:15%;">Line Total</td>
                    </tr>

                    <tr v-for="(po_item,est_index) in bill.items" class="info" :key="'estimate_'+est_index">
                        <td class="no-top-bottom-bd" style="width:50%;">{{po_item.brand.name}} | {{po_item.single_unit_weight}}{{po_item.measure_unit.slug}}</td>
                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.qty)}}</td>
                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.price.pack_cost)}}</td>
                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.line_discount)}}</td>
                        <td class="no-top-bottom-bd text-center"><span v-if="po_item.line_taxation.length">x</span></td>
                        <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(po_item.amount-po_item.line_discount)}}</td>
                    </tr>
                    <tr class="info">
                        <td style="width:50%;" colspan="2" class="txt-italic">{{bill.notes}}</td>
                        <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{currency+' '+formatMoneys(bill.total_discount)}} </a></td>
                    </tr>
                    <tr class="info">
                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                            <a class="float-left">SubTotal:</a>
                            <a class="float-right">{{currency+' '+formatMoneys(bill.net_total-bill.total_tax)}}</a>
                        </td>
                    </tr>
                    <tr class="info">
                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                            <a class="float-left">Sales Tax:</a>
                            <a class="float-right">{{currency+' '+formatMoneys(bill.total_tax)}}</a>
                        </td>
                    </tr>
                    <tr class="info">
                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                            <a class="float-left">Shipping:</a>
                            <a class="float-right">{{currency+' '+formatMoneys(bill.shipping_total)}}</a>
                        </td>
                    </tr>
                    <tr class="info">
                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                            <a class="float-left">Other:</a>
                            <a class="float-right">{{currency+' '+formatMoneys(bill.other_total)}}</a>
                        </td>
                    </tr>
                    <tr class="title">
                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                        <td class="txt-uppercase fw-600" colspan="4">
                            <a class="float-left">Total:</a>
                            <a class="float-right">{{currency+' '+formatMoneys(bill.net_total)}}</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="width-100-pc float-left">
            <div class="width-100-pc float-left fw-600 accepted-row mg-top-20 text-center">
                <hr>
                <p class="fs-13">{{bill.vendor.payment_term.notes}}</p>
            </div>
        </div>
        <div class="width-100-pc float-left">
            <div class="width-100-pc float-left text-center accepted-row">
                <p class="fs-13">If you have any questions, please contact: [{{bill.status[bill.status.length-1].signatory.first_name}} {{bill.status[bill.status.length-1].signatory.mobile}} {{bill.status[bill.status.length-1].signatory.email}}]</p>
            </div>
        </div>
    </div>
</template>
<script>
import { formatMoney } from '../../../../../../../helpers/functionmixin'
export default {
    name: "BillPreview",
    props: ['bill','currency'],
    methods: {
        formatMoneys(money_to){
            return formatMoney(money_to);
        }
    }
}
</script>

<style scoped>
table.sales-table tr.title td{
    background: #978686;
    font-size: 12px!important;
    text-transform: uppercase!important;
    font-weight: 600!important;
    padding: 4px 3px 4px 10px!important;
}
table.sales-table tr.info td{
    border: #adadad solid 1px!important;
    padding: 4px 3px 4px 10px!important;
    font-size: 12px!important;
}
table.sales-table tr td{
    border: #adadad solid 1px!important;
}

table.sales-table tr.title td.no-bd{
    border: transparent solid 0px!important;
    background: transparent!important;
}

table.sales-table tr.info td.no-bd{
    border: transparent solid 0px!important;
}

table.sales-table tr.info td.no-top-bottom-bd{
    border-bottom: transparent solid 0px!important;
    border-top: transparent solid 0px!important;
}

.txt-italic{ font-style: italic; }

table.sales-table tr.info-special td{
    border-top: 1px solid #adadad!important;
    border-right: 1px solid transparent!important;
    border-left: 1px solid transparent!important;
    border-bottom: 1px solid transparent!important;
}

table.sales-table tr.total td{
    border-top: 1px solid #444!important;
    border-bottom: 0px solid #444!important;
    border-left: 0 transparent solid!important;
    border-right: 0 transparent solid!important;
    padding: 4px 5px 5px 10px!important;
    font-size: 12px!important;
    font-weight: 600!important;
    color: #444!important;
    text-transform: uppercase!important;
}
</style>