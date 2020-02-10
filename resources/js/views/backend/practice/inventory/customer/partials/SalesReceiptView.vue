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
                        <div class="col-md-4 col-sm-4 pull-right text-center">
                            <h2 class="invoice-title txt-uppercase fs-20"><b>Receipt</b></h2>
                            <table class="sales-table">
                                <tr class="info">
                                    <td class="no-bd txt-uppercase text-right">Receipt:</td>
                                    <td class="no-bd txt-uppercase text-left cl-787887">{{estimate.trans_number}}</td>
                                </tr>
                                <tr class="info">
                                    <td class="no-bd txt-uppercase text-right">Receipt Date:</td>
                                    <td class="txt-uppercase no-bd text-left cl-787887">{{estimate.estimate_date}}</td>
                                </tr>
                                <tr class="info">
                                    <td class="no-bd txt-uppercase text-right">S.O#:</td>
                                    <td class="txt-uppercase no-bd text-left cl-787887">{{estimate.trans_number}}</td>
                                </tr>
                                <tr class="info">
                                    <td class="no-bd txt-uppercase text-right">Due Date:</td>
                                    <td class="txt-uppercase no-bd text-left cl-787887">{{estimate.expiry_date}}</td>
                                </tr>
                            </table>
                        </div>
                        
                    </div>
                    <div class="row set-border-bottom">
                        <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20 mg-top-20">
                            <table class="sales-table width-100-pc">
                                <tr class="title">
                                    <td colspan="2" class="">From:</td>
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
                        <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20 mg-top-20">
                            <table class="sales-table width-100-pc">
                                <tr class="title">
                                    <td colspan="2" class="">Ship To:</td>
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
                        <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20 mg-top-20">
                            <table class="sales-table width-100-pc">
                                <tr class="title">
                                    <td colspan="2" class="">Bill To:</td>
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
                    </div>

                    <div class="row">
                        <div class="col-md-12 mg-top-20">

                            <table class="sales-table width-100-pc">
                                <tr class="title">
                                    <td class="" style="width:10%;">ProductID</td>
                                    <td class="" style="width:50%;">Item</td>
                                    <td class="text-right" style="width:10%;">Qty</td>
                                    <td class="text-right" style="width:10%;">Unit Price</td>
                                    <td class="text-right" style="width:20%;">Line Total</td>
                                </tr>
                                <tr v-for="(est_item,est_index) in estimate.items" class="info" :key="'estimate_'+est_index">
                                    <td class="no-top-bottom-bd" style="width:10%;">{{est_item.product_item.sku_code}}</td>
                                    <td class="no-top-bottom-bd" style="width:50%;">{{est_item.product_item.brand.name}} | {{est_item.product_item.brand_sector.name}} | {{est_item.product_item.single_unit_weight}}{{est_item.product_item.measure_unit.slug}}</td>
                                    <td class="no-top-bottom-bd text-right">{{formatMoneys(est_item.qty)}}</td>
                                    <td class="no-top-bottom-bd text-right">{{formatMoneys(est_item.pricing.pack_retail_price)}}</td>
                                    <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(est_item.line_total-est_item.line_discount)}}</td>
                                </tr>
                                
                                <tr class="info info-special">
                                    <td class=""></td>
                                    <td colspan="2" class=" text-right txt-uppercase fw-600">Total Discount:</td>
                                    <td class="txt-uppercase fw-600" colspan="2"><a class="float-right"> {{formatMoneys(estimate.discount_allowed)}} {{ACCOUNTING.CURRENCEY}} </a></td>
                                </tr>

                                <tr class="info">
                                    <td class="no-bd"></td>
                                    <td colspan="2" class="no-bd fw-600 txt-uppercase text-right">SubTotal:</td>
                                    <td class="no-bd txt-uppercase fw-600" colspan="2">
                                        <a class="float-right">{{formatMoneys(estimate.total-estimate.discount_allowed)}}</a>
                                    </td>
                                </tr>

                                <tr class="info">
                                    <td class="no-bd"></td>
                                    <td colspan="2" class="no-bd fw-600 txt-uppercase text-right">Sales Tax:</td>
                                    <td class="no-bd txt-uppercase fw-600" colspan="2">
                                        <a class="float-right">{{formatMoneys(estimate.taxe_collected)}}</a>
                                    </td>
                                </tr>

                                <tr class="info">
                                    <td class="no-bd"></td>
                                    <td colspan="2" class="no-bd fw-600 txt-uppercase text-right">Shipping Charges:</td>
                                    <td class="no-bd txt-uppercase fw-600" colspan="2">
                                        <a class="float-right">{{formatMoneys(estimate.shipping_charges)}}</a>
                                    </td>
                                </tr>
                                <tr class="info">
                                    <td class="no-bd"></td>
                                    <td colspan="2" class="no-bd fw-600 txt-uppercase text-right">Adjustments:</td>
                                    <td class="no-bd txt-uppercase fw-600" colspan="2">
                                        <a class="float-right">{{formatMoneys(estimate.adjustments)}}</a>
                                    </td>
                                </tr>

                                <!-- <tr class="title">
                                    <td class="no-bd"></td>
                                    <td colspan="2" class="no-bd text-right fw-600 txt-uppercase">Total:</td>
                                    <td class="txt-uppercase fw-600 no-bd" colspan="2">
                                        <a class="float-right">{{ACCOUNTING.CURRENCY}} {{formatMoneys(estimate.total+estimate.shipping_charges-estimate.discount_allowed-estimate.taxe_collected)}}</a>
                                    </td>
                                </tr> -->

                                <!-- <tr class="title">
                                    <td class="no-bd"></td>
                                    <td colspan="2" class="no-bd text-right fw-600 txt-uppercase">Paid:</td>
                                    <td class="txt-uppercase fw-600 no-bd" colspan="2">
                                        <a class="float-right">{{formatMoneys(estimate.paid_amount)}}</a>
                                    </td>
                                </tr>
                                <tr class="title">
                                    <td class="no-bd"></td>
                                    <td colspan="2" class="no-bd text-right fw-600 txt-uppercase">Total Due:</td>
                                    <td class="txt-uppercase fw-600 no-bd" colspan="2">
                                        <a class="float-right">{{ACCOUNTING.CURRENCY}} {{formatMoneys(estimate.total+estimate.shipping_charges-estimate.discount_allowed-estimate.taxe_collected)}}</a>
                                    </td>
                                </tr> -->
                                <tr class="title">
                                    <td colspan="3" class="text-right">Total</td>
                                    <td colspan="2" class="text-right">{{ACCOUNTING.CURRENCY}} {{formatMoneys(estimate.total+estimate.shipping_charges-estimate.discount_allowed-estimate.taxe_collected)}}</td>
                                </tr>
                            </table>
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