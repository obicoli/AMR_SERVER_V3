<template>

<div class="invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20">
    <div class="row">
        <div class="col-md-5 col-sm-5 pull-left text-center report-header padding-left-0">
            <ribbon-maker :STATUS_ARRAY="sample_status" :PROCESS_STATUS="PROCESS_STATUS"></ribbon-maker>
            <img class="print-logo-size" src="/assets/img/amref-white.png">
            <h2 class="invoice-title txt-uppercase fs-12">
                <span class="fw-600 cl-amref fs-12">AMREF ENTERPRISE</span> | <span class="fw-600 cl-444 fs-12">AMREF HEALTH AFRICA</span>
            </h2>
        </div>
        <div class="col-md-3 col-sm-3"></div>
        <div class="col-md-4 col-sm-4 pull-right text-right">
            <h2 class="invoice-title txt-uppercase fs-20"><b>{{doc_title}}</b></h2>
            <!-- <table class="sales-table">
                <tr class="info">
                    <td style="width:50%;" class="no-bd text-right">Date:</td>
                    <td style="width:50%;" class="text-right">{{purchase_order.po_date}}</td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" class="no-bd text-right">PO Number:</td>
                    <td style="width:50%;" class="text-right">{{purchase_order.trans_number}}</td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" class="no-bd text-right">Ref:</td>
                    <td style="width:50%;" class="text-right">{{purchase_order.ref_number}}</td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" class="no-bd text-right">Due Date:</td>
                    <td style="width:50%;" class="text-right">{{purchase_order.po_due_date}}</td>
                </tr>
            </table> -->
        </div>
    </div>

    <!-- <div class="row set-border-bottom">
        <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20 mg-top-20">
            <table class="sales-table width-100-pc">
                <tr class="title">
                    <td colspan="2" class="">Vendor</td>
                </tr>
                <tr class="info">
                    <td colspan="2" class="width-100-pc no-bd">
                        {{purchase_order.vendor.display_as}}<br>
                        {{purchase_order.vendor.company.name}}<br>
                        {{purchase_order.vendor.addresses.billing.address}}, {{purchase_order.vendor.addresses.billing.postal_code}}<br>
                        {{purchase_order.vendor.addresses.billing.phone}} | {{purchase_order.vendor.email}}<br>
                        {{purchase_order.vendor.addresses.billing.fax}}<br>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-4 col-sm-4"></div>
        <div class="col-md-4 col-sm-4 pull-right to-address padding-top-20 mg-top-20 text-right">
            <table class="sales-table width-100-pc">
                <tr class="title">
                    <td colspan="2" class="">Ship To</td>
                </tr>
                <tr class="info">
                    <td colspan="2" class="width-100-pc no-bd">
                        {{purchase_order.shipping.name}}<br>
                        {{purchase_order.shipping.address}}<br>
                        {{purchase_order.shipping.postal_code}} {{purchase_order.shipping.city}}, {{purchase_order.shipping.country}}<br>
                        {{purchase_order.shipping.phone}}<br>
                        {{purchase_order.shipping.email}}<br>
                    </td>
                </tr>
            </table>
        </div>
    </div> -->

    <!-- <div class="row">
        <div class="col-md-12 mg-top-20">

            <table class="sales-table width-100-pc">
                <tr class="title">
                    <td class="" style="width:50%;">Item</td>
                    <td class="text-right" style="width:10%;">Qty</td>
                    <td class="text-right" style="width:10%;">Rate</td>
                    <td class="text-right" style="width:10%;">Disc</td>
                    <td class="text-center" style="width:5%;">Tax</td>
                    <td class="text-right" style="width:15%;">Line Total</td>
                </tr>
                <tr v-for="(po_item,est_index) in purchase_order.items" class="info" :key="'estimate_'+est_index">
                    <td class="no-top-bottom-bd" style="width:50%;">{{po_item.brand.name}} | {{po_item.single_unit_weight}}{{po_item.measure_unit.slug}}</td>
                    <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.qty)}}</td>
                    <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.price.pack_cost)}}</td>
                    <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.line_discount)}}</td>
                    <td class="no-top-bottom-bd text-center"><span v-if="po_item.line_taxation.length">x</span></td>
                    <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(po_item.amount-po_item.line_discount)}}</td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" colspan="2" class="txt-italic">{{purchase_order.notes}}</td>
                    <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{formatMoneys(purchase_order.discount_allowed)}} </a></td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" colspan="2" class="no-bd"></td>
                    <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                        <a class="float-left">SubTotal:</a>
                        <a class="float-right">{{formatMoneys(purchase_order.total_grand-purchase_order.total_tax)}}</a>
                    </td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" colspan="2" class="no-bd"></td>
                    <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                        <a class="float-left">Sales Tax:</a>
                        <a class="float-right">{{formatMoneys(purchase_order.total_tax)}}</a>
                    </td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" colspan="2" class="no-bd"></td>
                    <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                        <a class="float-left">Shipping:</a>
                        <a class="float-right">{{formatMoneys(purchase_order.shipping_total)}}</a>
                    </td>
                </tr>
                <tr class="info">
                    <td style="width:50%;" colspan="2" class="no-bd"></td>
                    <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                        <a class="float-left">Other:</a>
                        <a class="float-right">{{formatMoneys(purchase_order.other_total)}}</a>
                    </td>
                </tr>
                <tr class="title">
                    <td style="width:50%;" colspan="2" class="no-bd"></td>
                    <td class="txt-uppercase fw-600" colspan="4">
                        <a class="float-left">Total:</a>
                        <a class="float-right">{{formatMoneys(purchase_order.total_bill)}}</a>
                    </td>
                </tr>
            </table>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-12 fw-600 accepted-row mg-top-20 text-center">
            <hr>
            <p class="fs-13"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center accepted-row">
            <p class="fs-13">If you have any questions, please contact:</p>
        </div>
    </div>

</div>
    
</template>
<script>
import RibbonMaker from "../../../RibbonMaker";
import {PROCESS_STATUS} from "../../../../../../../helpers/process_status"
export default {
    name: "SalesReceiptPreview",
    props: ['doc_title'],
    components: {RibbonMaker},
    data(){
        return {
            PROCESS_STATUS:PROCESS_STATUS,
            sample_status: [
                {
                    status: "Unlocated"
                }
            ],
        }
    }
}
</script>