<template>

    <div class="row">
        <div class="col-md-12">

            <div v-if="server_data.data.length > 0" class="width-100-pc mg-top-20 padding-bottom-10">
                <div class="filter-block form-inline pull-left mg-right-10">
                    <div class="filter-group input-group">
                        <span class="filter active">Date:</span>
                        <span class="filter">{{server_data.selected_dates}}</span>
                    </div>
                </div>
                <div class="filter-block form-inline pull-left mg-right-10">
                    <div class="filter-group input-group">
                        <span class="filter active">Total in Qty:</span>
                        <span class="filter">{{server_data.total_inward}}</span>
                    </div>
                </div>
                <div class="filter-block form-inline pull-left mg-right-10">
                    <div class="filter-group input-group">
                        <span class="filter active">Total Out Qty:</span>
                        <span class="filter">{{server_data.total_outward}}</span>
                    </div>
                </div>
                
            </div>

            <table v-if="server_data.data.length > 0" class="table ledgers-table table-hover">
                <thead>
                    <tr>
                        <th class="zeroPadding" style="width:45%;">
                            <table>
                                <tr>
                                    <th style="width:20%">In/Date</th>
                                    <th style="width:15%">In/Origin</th>
                                    <th style="width:50%">In/Product</th>
                                    <th style="width:15%" class="text-right">In/Qty</th>
                                </tr>
                            </table>
                        </th>
                        <th class="zeroPadding" style="width:55%;">
                            <table>
                                <tr>
                                    <th class="text-left">Out/Qty</th>
                                    <th>Out/Date</th>
                                    <th>Out/Origin</th>
                                    <th>Out/Location</th>
                                    <th>Out/Product</th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(stock_trans,index) in server_data.data" :key="'index'+index" class="zeroPadding">
                        <td style="width:45%;padding:0!important;">
                            <table>
                                <tr :key="'key_'+index">
                                    <td style="width:20%">{{stock_trans.trans_date}}</td>
                                    <td style="width:15%" class="fs-12 fw-600 cl-amref">{{stock_trans.inwards.trans_number}}</td>
                                    <td style="width:50%">{{stock_trans.inwards.product.item_name}} | {{stock_trans.inwards.product.brand}} | {{stock_trans.inwards.product.unit_weight}}{{stock_trans.inwards.product.measure_unit_sympol}}</td>
                                    <td style="width:15%" class="text-right fs-12 fw-600 cl-amref">{{stock_trans.inwards.qty}}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:55%;padding:0!important;">
                            <table>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table v-if="server_data.data.length === 0" class="table ledgers-table table-hover">
                <tbody>
                    <tr>
                        <td colspan="2" class="text-center fs-12 fw-600 cl-amref">No data to generate report</td>
                    </tr>
                </tbody>
            </table>
            
            <h5 class="text-center cl-787887">{{report_description}}</h5>  
        </div>
    </div>
    
</template>

<script>
    export default {
        name: "SfsReport",
        props: ['server_data','report_name','report_description'],
        data(){
            return {
                //transactions: [],
            }
        },
        watch: {
            // transactionReport:function(new_trans){
            //     this.transactions = new_trans;
            //     console.info('this.transactions');
            //     console.info(this.transactions);
            //     console.info('this.transactions');
            // },
            // selected_date: function(new_date){
            //     this.selected_date = new_date;
            // },
            server_data: function(new_data){
                this.server_data = new_data;
            }
        },
        mounted(){
            //this.transactions = this.transactionReport
        }
    }
</script>