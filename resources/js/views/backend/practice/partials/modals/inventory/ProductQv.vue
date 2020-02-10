<template>

    <div v-if="loded" class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content">

                <div class="modal-header bg-eee text-left">
                    <h4 class="width-100-pc text-left"><img src="/assets/icons/dashboard/bill_icon.png"> {{modal_title}}</h4>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0 bg-f4">
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="width-100-pc float-left bg-white mg-bottom-30">
                                <div v-if="is_loading" class="width-100-pc float-left padding-15 mg-top-60 text-center min-height-400">
                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                </div>
                                <div v-else class="width-100-pc float-left padding-15">
                                    <div class="width-30-pc float-left mg-top-20">
                                        <table class="table overview-table">
                                            <tbody>
                                                <tr>
                                                    <td style="width:40%" class="text-right">Item:</td>
                                                    <td class="fw-600 text-right">{{item.item_name.name}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="text-right">Category:</td>
                                                    <td class="fw-600 text-right">{{item.category.name}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="text-right">Item Type:</td>
                                                    <td class="fw-600 text-right">{{item.item_type.name}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="text-right">Qty on Hand:</td>
                                                    <td class="fw-600 text-right">{{format_money(item.stock)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="text-right">Qty on Order(PO):</td>
                                                    <td class="fw-600 text-right">{{format_money(item.stock)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:40%" class="text-right">Qty on Demand(Quotes):</td>
                                                    <td class="fw-600 text-right">{{format_money(item.stock)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="width-30-pc float-right mg-top-20">
                                        <h3 class="fs-16 fw-600 cl-yellowish width-100-pc text-right">Value On Hand: {{currency+''+format_money(0)}}</h3>
                                        <table class="table overview-table">
                                            <tbody>
                                                <tr>
                                                    <td style="width:50%" class="text-right">Last Cost:</td>
                                                    <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%" class="text-right">Average Cost:</td>
                                                    <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%" class="text-right">Inclusive Selling Price:</td>
                                                    <td class="text-right fw-600">{{format_money(0)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%" class="text-right">Exclusive Selling Price:</td>
                                                    <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%" class="text-right">GP(%):</td>
                                                    <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:50%" class="text-right">GP Amount:</td>
                                                    <td class="text-right fw-600">{{currency+''+format_money(0)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="width-100-pc float-right bg-white mg-top-30">
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">Overview</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">All Transactions</a>
                                                <!-- <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Purchase Orders</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Bills</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Payments</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Vendor Credits</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Journal</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Statement</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Mails</a>
                                                <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Comments</a> -->
                                            </div>
                                        </nav>
                                        <div class="tab-content tab-content-role" id="nav-tabContent">
                                            <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                <div class="width-100-pc float-left padding-10">
                                                    <div class="width-50-pc float-left min-height-120">
                                                        <h3 class="mg-top-20 fs-13 cl-444 fw-600">Recent Sales</h3>
                                                        <div class="width-100-pc float-left padding-top-30">
                                                            <small class="txt-italic cl-grey fs-12"> No records displayed:  No recent sales to display.</small>
                                                        </div>
                                                    </div>
                                                    <div class="width-50-pc float-left min-height-120">
                                                        <h3 class="mg-top-20 fs-13 cl-444 fw-600">Recent Purchases</h3>
                                                        <div class="width-100-pc float-left padding-top-30">
                                                            <small class="txt-italic cl-grey fs-12"> No records displayed:  No recent purchases to display.</small>
                                                        </div>
                                                    </div>
                                                    <div class="width-100-pc float-left min-height-120">
                                                        <fusion-comparison-bar></fusion-comparison-bar>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-transactions-'+'1'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'1'" :key="'tab_index_'+'1'">
                                                <div class="width-100-pc float-left min-height-120">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process">
                        Close
                    </button>
                </div>

            </form>
        </div>

    </div>
    
</template>

<script>
    import {form_address,formatMoney} from '../../../../../../helpers/functionmixin';
    import Auth from '../../../../../../store/auth';
    import { get } from '../../../../../../helpers/api';
    // import ApexBar from "../../../../../../analytics/apex/ApexBar";
    import FusionComparisonBar from "../../../../../../analytics/fussion/FusionComparisonBar";
    export default {
        props: ['modal_id','modal_title','item','currency','PRODUCT_ITEMS_URL'],
        components: {FusionComparisonBar},
        data(){
            return {
                processing: false,
                loded: false,
                is_loading: false,
                curr_tab: 0,
                local_item: null,
                options: {
                    chart: {
                    id: 'vuechart-example'
                    },
                    xaxis: {
                        categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998], //This represents days
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            colors: ['#333']
                        },
                        offsetX: 30
                    },
                },
                series: [{
                    name: 'Days',
                    data: [30, 40, 45, 50, 49, 60, 70, 91] //This represents days
                }],
            }
        },
        watch: {
            item: function(new_data,old_data){
                this.setProduct();
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            setProduct(){
                if(this.item){
                    this.loded = true;
                    this.showItem(this.item.id);
                }
            },

            showItem(item_id){
                this.is_loading = true;
                get(this.PRODUCT_ITEMS_URL+'/'+item_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.local_item = res.data.results;
                        this.is_loading = false;
                    }
                }).catch((err) => {
                    this.is_loading = false;
                });
            },
        },

        mounted(){
            this.setProduct();
        }
        
    }
</script>

<style lang="scss" scoped>
    // @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 1100px!important;
        min-width: 1000px!important;
    }
    .modal-header h4 {
        font-size: 20px!important;
    }
    .modal-content{
        // top: 100px;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select, .vdatetime-input{
        outline: none!important;
        height: 27px!important;
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 5px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 12px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }
    .active[data-v-4b50979b]:after {
        content: ""!important;
    }
</style>


