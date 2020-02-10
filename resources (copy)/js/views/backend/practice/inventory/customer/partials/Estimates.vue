<template>

    <div class="">

        <div  class="width-100-pc action-header padding-left-20 padding-top-10 padding-bottom-10">

            <button v-if="!view_toggler" @click="toggleView(true)" type="button" class="btn btn-inventory btn-amref mg-right-5"><i class="fa fa-bars" aria-hidden="true"></i></button>
            <div class="filter-block form-inline">
                <div class="filter-group input-group">
                    <span class="filter"><i class="fa fa-pencil"></i></span>
                    <span class="filter"><i class="fa fa-file-pdf-o"></i></span>
                    <span class="filter"><i class="fa fa-print"></i></span>
                    <span class="filter"><i class="fa fa-envelope-o"></i></span>
                </div>
            </div>

            <button class="btn btn-default btn-inventory btn-gray mg-left-10"><i class="fa fa-paperclip"></i></button>

            <button class="btn btn-default btn-inventory btn-amref">Convert to Invoice</button>

            <div  class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop" type="button" class="btn btn-default btn-inventory btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </button>
                    <div class="dropdown-menu right-0" aria-labelledby="btnGroupDrop">
                        <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Share Estimate Link</a>
                        <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Create Retainer Invoice</a>
                        <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Convert to Sales Order</a>
                        <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Mark As Declined</a>
                        <a class="dropdown-item separator"></a>
                        <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Delete</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="page-content bg-white padding-left-0 height-scrollable">
            <section class="padding-right-0 padding-left-0 padding-top-20" id="print_section">
                <div class="invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border width-900-px padding-20">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 pull-left text-center report-header padding-left-0">
                            <img class="print-logo-size" src="/assets/img/amref-white.png">
                            <h2 class="invoice-title txt-uppercase fs-12">
                                <span class="fw-600 cl-amref fs-12">AMREF ENTERPRISE</span> | <span class="fw-600 cl-444 fs-12">AMREF HEALTH AFRICA</span>
                            </h2>
                        </div>
                        <div class="col-md-4 col-sm-4"></div>
                        <div class="col-md-4 col-sm-4 pull-right text-right">
                            <h2 class="invoice-title txt-uppercase fs-20"><b>Quotation</b></h2>
                            <table class="sales-table">
                                <tr class="title">
                                    <td class="text-center">Quote#</td>
                                    <td class="text-center">Date</td>
                                </tr>
                                <tr class="info">
                                    <td class="text-center">{{estimate.trans_number}}</td>
                                    <td class="text-center">{{estimate.estimate_date}}</td>
                                </tr>
                                <tr class="title">
                                    <td class="text-center">Customer ID</td>
                                    <td class="text-center">Valid Until</td>
                                </tr>
                                <tr class="info">
                                    <td class="text-center">{{estimate.customer.business_id}}</td>
                                    <td class="text-center txt-uppercase">{{estimate.expiry_date}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row set-border-bottom">
                        <div class="col-md-5 col-sm-5 pull-left to-address padding-top-20 mg-top-20">
                            <table class="sales-table width-100-pc">
                                <tr class="title">
                                    <td colspan="2" class="">Customer Info</td>
                                </tr>
                                <tr class="info">
                                    <td colspan="2" class="width-100-pc no-bd">
                                        {{estimate.customer.first_name}} {{estimate.customer.middle_name}}<br>
                                        {{estimate.customer.company}}<br>
                                        {{estimate.customer.address}}<br>
                                        {{estimate.customer.postal_code}} {{estimate.customer.city}} {{estimate.customer.country}}<br>
                                        {{estimate.customer.mobile}}, {{estimate.customer.email}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5 col-sm-5 pull-right to-address padding-top-20 mg-top-20">
                            <span class="pull-right receipt-details">
                                <h5 class="fs-12 cl-444"><label class="fs-13 fw-600 cl-787887 txt-italic">Prepared By:</label> <small class="fs-12 cl-444 fw-600">{{estimate.trans_status[estimate.trans_status.length-1].signatory.first_name}}</small></h5>
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mg-top-20">

                            <table class="sales-table width-100-pc">
                                <tr class="title">
                                    <td class="" style="width:60%;">Itemized Costs</td>
                                    <td class="text-right" style="width:10%;">Qty</td>
                                    <td class="text-right" style="width:15%;">Unit Price</td>
                                    <td class="text-right" style="width:15%;">Amount</td>
                                </tr>
                                <tr v-for="(est_item,est_index) in estimate.items" class="info" :key="'estimate_'+est_index">
                                    <td class="no-top-bottom-bd" style="width:60%;">{{est_item.product_item.brand.name}} | {{est_item.product_item.brand_sector.name}} | {{est_item.product_item.single_unit_weight}}{{est_item.product_item.measure_unit.slug}}</td>
                                    <td class="no-top-bottom-bd text-right">{{formatMoneys(est_item.qty)}}</td>
                                    <td class="no-top-bottom-bd text-right">{{formatMoneys(est_item.pricing.pack_retail_price)}}</td>
                                    <td class="no-top-bottom-bd text-right">{{formatMoneys(est_item.qty * est_item.pricing.pack_retail_price)}}</td>
                                </tr>
                                <tr class="info">
                                    <td style="width:60%;" class="txt-italic">{{estimate.notes}}</td>
                                    <td class="txt-uppercase fw-600" colspan="3"><a class="float-left">SubTotal:</a><a class="float-right">{{ACCOUNTING.CURRENCEY}} {{formatMoneys(estimate.total-estimate.taxe_collected)}}</a></td>
                                </tr>
                                <tr v-if="estimate.taxe_collected" class="info">
                                    <td style="width:60%;" class="no-bd"></td>
                                    <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="3">
                                        <a class="float-left">Sales Tax:</a>
                                        <a class="float-right">{{ACCOUNTING.CURRENCY}} {{formatMoneys(estimate.taxe_collected)}}</a>
                                    </td>
                                </tr>
                                <tr v-if="estimate.discount_allowed" class="info">
                                    <td style="width:60%;" class="no-bd"></td>
                                    <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="3">
                                        <a class="float-left">Discount:</a>
                                        <a class="float-right">{{ACCOUNTING.CURRENCY}} {{formatMoneys(estimate.discount_allowed)}}</a>
                                    </td>
                                </tr>
                                <tr v-if="estimate.shipping_charges" class="info">
                                    <td style="width:60%;" class="no-bd"></td>
                                    <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="3">
                                        <a class="float-left">Shipping Charges:</a>
                                        <a class="float-right">{{ACCOUNTING.CURRENCY}} {{formatMoneys(estimate.shipping_charges)}}</a>
                                    </td>
                                </tr>
                                <tr class="title">
                                    <td style="width:60%;" class="no-bd"></td>
                                    <td class="txt-uppercase fw-600" colspan="3">
                                        <a class="float-left">Total Quote:</a>
                                        <a class="float-right">{{ACCOUNTING.CURRENCY}} {{formatMoneys(estimate.total+estimate.shipping_charges-estimate.discount_allowed)}}</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 fw-600 accepted-row mg-top-20">
                            <p class="fs-13">{{estimate.terms_condition}}</p>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 fw-600 accepted-row padding-top-10">
                            Customer Acceptance:
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
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12 text-center accepted-row padding-top-10">
                            <p class="fs-13">If you have any questions, please contact: [{{estimate.trans_status[estimate.trans_status.length-1].signatory.first_name}} {{estimate.trans_status[estimate.trans_status.length-1].signatory.mobile}} {{estimate.trans_status[estimate.trans_status.length-1].signatory.email}}]</p>
                        </div>
                    </div>

                </div>
            </section>
        </div>

    </div>
    
</template>

<script>
    import {createHtmlErrorString,formatMoney} from '../../../../../../helpers/functionmixin';
    export default {
        props: ['view_toggler','estimate','ACCOUNTING'],
        watch:{
            estimate: function(new_estimate,old_estimate){
                this.estimate = new_estimate;
            }
        },
        methods: {
            toggleView(state_){
                this.$emit("toggleView",state_)
            },
            formatMoneys(money_to){
                return formatMoney(money_to);
            },
        },
    }
</script>