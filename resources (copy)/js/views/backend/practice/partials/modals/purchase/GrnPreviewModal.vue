<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div  class="modal-body padding-0">

                    <section class="content padding-10 mg-bottom-1" id="print_section">
                        <div class="invoice invoice-body invoice-border zero-border">
                            <div class="row">
                                <div class="col-md-9">
                                    <h2 class="invoice-title txt-uppercase"><b>Goods Received Note(s)</b></h2>
                                </div>
                                <div class="col-md-3 col-sm-3 pull-right">
                                    <img class="print-logo-size pull-right" :src="organ_data.data.facility.app_data.logo">
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="content padding-10" id="print_section">
                        <div v-for="(grn_note,index) in purchase.grn_notes" :key="'grn_notes'+index" class="invoice invoice-body invoice-border zero-border">
                            <div class="row set-border-bottom">
                                <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20">
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Supplier:</label> <small class="cl-787887 fs-13">{{grn_note.advise_note}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Order number:</label> <small class="cl-787887 fs-13">{{grn_note.advise_note}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Delivery Location:</label> <small class="cl-787887 fs-13">{{grn_note.advise_note}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Advise Note:</label> <small class="cl-787887 fs-13">{{grn_note.advise_note}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">GRN NO:</label> <small class="cl-787887 fs-13">{{grn_note.grn_number}}</small></h5>
                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">GRN DATE:</label> <small class="cl-787887 fs-13">{{grn_note.date_received}}</small></h5>
                                </div>
                                <div class="col-md-4 col-sm-4 pull-right">
                                </div>
                                <div class="col-md-4 col-sm-4 pull-right">
                                </div>
                            </div>

                            <div class="row bg-white">

                                <div class="col-md-12 padding-right-0 padding-left-0">
                                    <table class="receipt-item-table table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%;"></th>
                                                <th style="width: 50%;">Goods</th>
                                                <th style="width: 8%;">Pack(size)</th>
                                                <th style="width: 8%;">Price</th>
                                                <th style="width: 8%;">Ordered</th>
                                                <th style="width: 8%;">Delivered</th>
                                                <th style="width: 15%;">Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody class="noprintclass">
                                            <tr v-for="(item, index) in grn_note.items" :key="'item_'+index">
                                                <td>{{index+1}}</td>
                                                <td>{{item.item_name}} | {{item.brand}} | {{item.brand_sector}} | {{item.unit_weight}}{{item.measure_unit_sympol}}</td>
                                                <td class="text-right">{{item.pack_qty}}</td>
                                                <td class="text-right">{{formatMoney(item.pack_cost,'2','.',',')}}</td>
                                                <td class="text-right">{{formatMoney(item.ordered_qty,'2','.',',')}}</td>
                                                <td class="text-right">
                                                    <span v-if="item.delivered_qty < item.ordered_qty" class="fs-12 fw-600 cl-amref">{{formatMoney(item.delivered_qty,'2','.',',')}}</span>
                                                    <span v-else class="fs-12 fw-600">{{formatMoney(item.delivered_qty,'2','.',',')}}</span>
                                                </td>
                                                <td class="text-right">{{item.comment}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center accepted-row padding-top-10">
                                    <p class="fs-13"><span>Received By ___________________ </span> <span> Checked By ___________________ </span></p>
                                </div>
                            </div>

                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-inventory">
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
        name: "PurchasePreviewModal",
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
        min-width: 950px!important;
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
        /* font-weight: 600!important; */
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