@extends('receipt_app')

@section('content')

<!-- =========================== -->
  <section class="content padding-10" id="print_section">
    <div class="invoice invoice-body invoice-border zero-border">
        <div class="row">
            <div class="col-md-9 col-sm-9 pull-left report-header">
                <h2 class="invoice-title txt-uppercase fs-15 cl-red"><b>{{$shipping_address['name']}}</b></h2>
                <h4 class="cl-444 fw-600">{{$shipping_address['name']}}({{$shipping_address['category']}})</h4>
                <h4 class="cl-787887">{{$shipping_address['address']}} </h4>
                <h4 class="cl-787887">{{$shipping_address['email']}}</h4>
                <h4 class="cl-787887">{{$shipping_address['mobile']}}</h4>
                <h4 class="cl-787887">{{$shipping_address['city']}}, {{$shipping_address['country']}}</h4>
            </div>
            <div class="col-md-3 col-sm-3 pull-right">
                <img class="print-logo-size pull-right" :src="organ_data.data.facility.app_data.logo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2 class="invoice-title"><b>PURCHASE ORDER</b></h2>
            </div>
        </div>
        <div class="row set-border-bottom">
            <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20">
                <h3 class="cl-787887"><b>TO</b></h3>
                <h4 class="cl-444 fw-600 fs-12"> {{$mailing_address['first_name']}} {{$mailing_address['other_name']}}</h4>
                <h4 class="cl-444 fw-600 fs-12">{{$mailing_address['company']}}</h4>
                <h4 class="cl-787887 fs-12">{{$mailing_address['email']}}</h4>
                <h4 class="cl-787887 fs-12">{{$mailing_address['mobile']}}</h4>
                <h4 class="cl-787887 fs-12">{{$mailing_address['address']}}</h4>
                <h4 class="cl-787887 fs-12">{{$mailing_address['city']}}, {{$mailing_address['country']}}</h4>
            </div>
            <div class="col-md-4 col-sm-4 pull-right">
            </div>
            <div class="col-md-4 col-sm-4 pull-right">
                <span class="pull-right receipt-details">
                    <h4 class="fs-12"><b class="invoice-heading"> PO NO : </b><span class="pull-right fs-12"> #{{$order_data['po_number']}}</span></h4>
                    <h4 class="fs-12"><b class="invoice-heading"> PO DATE  : </b> <span class="pull-right fs-12"> {{$order_data['po_date']}} </span></h4>
                    <h4 class="fs-12"><b class="invoice-heading"> PO DUE DATE  : </b> <span class="pull-right fs-12"> {{$order_data['po_due_date']}} </span></h4>
                </span>
            </div>
        </div>

        <div class="row bg-white">

            <div class="col-md-12 padding-right-0 padding-left-0">
                <table class="receipt-item-table table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%;">SKU</th>
                            <th style="width: 55%;">Product/Service</th>
                            <th style="width: 13%;">Qty(Packs)</th>
                            <th style="width: 12%;">Rate</th>
                            <th style="width: 15%;">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="noprintclass">

                      <?php
                        for( $h=0; $h<sizeof($order_data['items']); $h++){

                          ?>
                            <tr>
                                <td>{{$order_data['items'][$h]['sku_code']}}</td>
                                <td>{{$order_data['items'][$h]['brand']}} | {{$order_data['items'][$h]['brand_sector']}} | {{$order_data['items'][$h]['unit_weight']}}{{$order_data['items'][$h]['measure_unit_sympol']}}</td>
                                <td class="text-right">{{$order_data['items'][$h]['qty']}}</td>
                                <td class="text-right">{{$order_data['items'][$h]['pack_cost']}}</td>
                                <td class="text-right">{{$order_data['items'][$h]['qty']*$order_data['items'][$h]['pack_cost']}}</td>
                            </tr>
                          <?php

                        }
                      ?>



                    </tbody>
                </table>

            </div>
        </div>

        <div class="row bg-white">
            <div class="col-md-4 col-sm-4 pull-left"></div>
            <div class="col-md-3 col-sm-4 pull-left"></div>
            <div class="col-md-5 col-sm-4 pull-right">
                <table class="table items-total-table">
                    <tr>
                        <td class="labs text-right" style="width:40%;">Total: Kes</td>
                        <td class="text-right" style="width:60%;">{{$order_data['total']}}</td>
                    </tr>
                    <tr>
                        <td class="labs text-right">Grand Total: Kes</td>
                        <td class="text-right">
                            KES: {{$order_data['grand_total']}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-12">
                <p class="fs-13">Message : {{$order_data['message']}}</p>
                <p class="fs-13">Memo : {{$order_data['memo']}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center accepted-row">
                <p class="fs-13"><span>Accepted By ___________________ </span> <span> Accepted Date ___________________ </span></p>
            </div>
        </div>
    </div>
  </section>
<!-- ================================= -->
    
@endsection