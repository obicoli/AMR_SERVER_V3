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
                                    <h4 class="cl-444 fw-600">{{organ_data.data.facility.name}}</h4>
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
                                    <h2 class="invoice-title"><b>SUPPLY RECEIPT</b></h2>
                                </div>
                            </div>
                            <div class="row set-border-bottom">
                                <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20">
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Bill To:</label> <small class="fs-13 cl-787887">{{purchase.destination_facility.facility_name}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Dept:</label> <small class="fs-13 cl-787887">{{purchase.destination_facility.department.name}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Store:</label> <small class="fs-13 cl-787887">{{purchase.destination_facility.store.name}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Sub-store:</label> <small class="fs-13 cl-787887">{{purchase.destination_facility.sub_store.name}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Bill No:</label> <small class="fs-13 cl-787887">{{purchase.bill_no}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Bill Date:</label> <small class="fs-13 cl-787887">{{purchase.bill_date}}</small></h5>
                                </div>
                                <div class="col-md-4 col-sm-4 pull-right">
                                </div>
                                <div class="col-md-4 col-sm-4 pull-right">
                                    <span class="pull-right receipt-details">
                                        <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Agent:</label> <small class="fs-13 cl-787887">{{purchase.trans_status[0].signatory.first_name}}({{purchase.trans_status[0].signatory.role.name}})</small></h5>
                                        <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Driver:</label> <small class="fs-13 cl-787887">{{purchase.driver.first_name}} {{purchase.driver.last_name}}</small></h5>
                                        <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Mode:</label> <small class="fs-13 cl-787887">{{purchase.supply_mode}}</small></h5>
                                        <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Vehicle:</label> <small class="fs-13 cl-787887">{{purchase.vehicle.name}} {{purchase.vehicle.number}}</small></h5>
                                        <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Ref No:</label> <small class="fs-13 cl-787887">{{purchase.trans_number}}</small></h5>
                                    </span>
                                </div>
                            </div>

                            <div class="row bg-white">
                                <div class="col-md-12 padding-right-0 padding-left-0">
                                    <table class="receipt-item-table table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 2%;">#No.</th>
                                                <th style="width: 5%;">SKU</th>
                                                <th style="width: 50%;">Name</th>
                                                <th style="width: 5%;">Weight</th>
                                                <th style="width: 7%;">Price</th>
                                                <th style="width: 8%;">Packs</th>
                                                <th style="width: 10%;">Discount(%)</th>
                                                <th style="width: 13%;">Sub-total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="noprintclass">
                                            <tr v-for="(item, index) in purchase.items" :key="'item_'+index">
                                                <td>{{index+1}}</td>
                                                <td>{{item.sku_code}}</td>
                                                <td>{{item.item_name}} | {{item.brand}} | {{item.brand_sector}}</td>
                                                <td>{{item.unit_weight}}{{item.measure_unit_sympol}}</td>
                                                <td class="text-right">{{formatMoney(item.pack_retail,'2','.',',')}}</td>
                                                <td class="text-right">{{formatMoney(item.qty,'2','.',',')}}</td>
                                                <td class="text-right">{{formatMoney(item.disc_in_perc,'2','.',',')}}</td>
                                                <td class="text-right">{{formatMoney(item.amount,'2','.',',')}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row bg-white">
                                <div class="col-md-4 col-sm-4 pull-left"></div>
                                <div class="col-md-3 col-sm-2 pull-left"></div>
                                <div class="col-md-5 col-sm-6 pull-right mg-top-20 padding-top-20 bg-foo">
                                    <table class="table items-total-table table-striped bg-foo">
                                        <tr>
                                            <td class="labs text-right" style="width:35%;">Subtotal (KES):</td>
                                            <td class="text-right" style="width:65%;">{{formatMoney(purchase.total_without_discount)}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width:35%;" class="labs text-right">Total Discount(KES):</td>
                                            <td style="width:65%;" class="text-right">
                                                {{formatMoney(purchase.total-purchase.discount)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:35%;" class="labs text-right">After Discount(KES):</td>
                                            <td style="width:65%;" class="text-right">
                                                {{formatMoney(purchase.total_amount)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:35%;" class="labs text-right">Tax(KES):</td>
                                            <td style="width:65%;" class="text-right">{{formatMoney(purchase.total_tax)}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width:35%;" class="labs text-right">Total( KES):</td>
                                            <td style="width:65%;" class="text-right">{{formatMoney(purchase.total_amount-purchase.total_tax)}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width:100%;" colspan="2" class="labs text-right">Description:</td>
                                        </tr>
                                        <tr>
                                            <td style="width:100%;" colspan="2" class="labs text-right">[ Payment Method: {{purchase.payment_type.name}} ] [ Cash recieved: {{formatMoney(purchase.paid_amount)}} /- ] [ Cash balance: {{formatMoney(purchase.balance)}} /- ]</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center accepted-row padding-top-10">
                                    <p class="fs-13">Receipt was created on a computer and is valid without the signature and seal.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn-pending-md pointer-cursor">
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
        name: "SupplyPreview",
        props: ['purchase','modal_id','organ_data'],
        created(){
            this.calculates();
        },
        methods: {
            formatMoney(amount) {
                return formatMoney(amount);
            },
            printReceipt(receipt_id){
                print_divs(receipt_id);
            },
            calculates(){
                let tot_ = 0;
                let gra_tot = 0;
                for( let k = 0; k < this.purchase.items.length; k++ ){
                    tot_ = this.purchase.items[k].qty * this.purchase.items[k].pack_cost;
                    this.purchase.total += tot_;
                    this.purchase.grand_total += tot_;
                }
            }
        },
    }
</script>

<style scoped>

    .modal-content{
        min-width: 1000px!important;
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