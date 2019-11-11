<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <page-header></page-header>

        <div class="content-wrapper min-height-100-vh bg-white mg-bottom-30">

            <section class="content">

                <div class="row mg-top-20">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="box box-primary border-top-0 border-bottom-0 no-shadowed">
                            <div class="box-header bg-white with-border bg-white border-bottom-0">
                                <h3 class="box-title fs-15 fw-600">Latest Prescriptions: </h3>
                                <div class="box-tools pull-right">
                                    <div class="btn-group pull no-print pull-right">
                                        <button type="button" class="btn btn-inventory dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Filter prescription
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-ctm" role="menu">
                                            <li onclick=""><a><i class="fa fa-edit"></i> Unverified</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body bg-white">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="items table items-analytic-table table-bordered table-hover">
                                            <thead class="bg-eee">
                                            <tr>
                                                <th style="width: 10%"></th>
                                                <th style="width: 30%">Customers</th>
                                                <th style="width: 30%">Status</th>
                                                <th style="width: 30%">Date</th>
                                            </tr>
                                            </thead>
                                            <tbody class="noprintclass">

                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right"></td>
                                                <td class="bd-right">Collins Obonyo</td>
                                                <td class="bd-right">Pending</td>
                                                <td>May 10,2016</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padding-left-0">
                        <div class="box box-primary border-top-0 border-bottom-0 no-shadowed">
                            <div class="box-header bg-white with-border bg-white border-bottom-0">
                                <h3 class="box-title fs-15 fw-600">Transactions today: </h3>
                            </div>
                            <div class="box-body bg-white">
                                <div class="row">
                                    <div class="col-lg-3 col-xs-6 padding-right-0">
                                        <div class="small-box bordered-card">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">0</label></h3>
                                                <h4 class="paragraph cl-grey">Stock Out (Units)</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-6 padding-right-0">
                                        <div class="small-box bordered-card">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">0</label></h3>
                                                <h4 class="paragraph cl-grey">Stock In (Units)</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-6 padding-right-0">
                                        <div class="small-box bordered-card">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">0</label></h3>
                                                <h4 class="paragraph cl-grey">Returns (Units)</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box bordered-card">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">00.00</label></h3>
                                                <h4 class="paragraph cl-grey">Sales (KES)</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="col-lg-12">-->
                                    <!--                                        <table class="items table items-analytic-table table-bordered table-hover">-->
                                    <!--                                            <thead class="bg-eee">-->
                                    <!--                                            <tr>-->
                                    <!--                                                <th style="width: 25%">Stock In</th>-->
                                    <!--                                                <th style="width: 25%">Stock Out</th>-->
                                    <!--                                                <th style="width: 25%">Stock Return</th>-->
                                    <!--                                                <th style="width: 25%">Sales</th>-->
                                    <!--                                            </tr>-->
                                    <!--                                            </thead>-->
                                    <!--                                            <tbody class="noprintclass">-->

                                    <!--                                                <tr>-->
                                    <!--                                                    <td class="bd-right"></td>-->
                                    <!--                                                    <td class="bd-right">Collins Obonyo</td>-->
                                    <!--                                                    <td class="bd-right">Pending</td>-->
                                    <!--                                                    <td>May 10,2016</td>-->
                                    <!--                                                </tr>-->

                                    <!--                                            </tbody>-->
                                    <!--                                        </table>-->
                                    <!--                                    </div>-->
                                </div>
                            </div>
                        </div>

                        <div class="box box-primary border-top-0 border-bottom-0 no-shadowed">
                            <div class="box-header bg-white with-border bg-white border-bottom-0">
                                <h3 class="box-title fs-15 fw-600">Inventory </h3>
                            </div>
                            <div class="box-body bg-white">
                                <div class="row">
                                    <div class="col-lg-3 col-xs-6 padding-right-0">
                                        <table class="items table items-analytic-table table-bordered table-hover">
                                            <thead class="bg-eee">
                                            <tr>
                                                <th style="width: 20%">Category</th>
                                                <th style="width: 40%">Product</th>
                                                <th style="width: 20%">SKU</th>
                                                <th style="width: 20%">In Stock</th>
                                            </tr>
                                            </thead>
                                            <tbody class="noprintclass">
                                            <tr>
                                                <td class="bd-right">Tablet</td>
                                                <td class="bd-right">Augmentin(TM)</td>
                                                <td class="bd-right">09877654</td>
                                                <td>29000000</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right">Tablet</td>
                                                <td class="bd-right">Augmentin(TM)</td>
                                                <td class="bd-right">09877654</td>
                                                <td>29000000</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right">Tablet</td>
                                                <td class="bd-right">Augmentin(TM)</td>
                                                <td class="bd-right">09877654</td>
                                                <td>29000000</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right">Tablet</td>
                                                <td class="bd-right">Augmentin(TM)</td>
                                                <td class="bd-right">09877654</td>
                                                <td>29000000</td>
                                            </tr>
                                            <tr>
                                                <td class="bd-right">Tablet</td>
                                                <td class="bd-right">Augmentin(TM)</td>
                                                <td class="bd-right">09877654</td>
                                                <td>29000000</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="box box-primary border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-header with-border box-header-custom">
                                <h3 class="box-title fs-15 fw-600"> Stock Control Charts: Overall </h3>
                            </div>
                            <div class="box-body bg-white padding-0 min-height-427">
                                <show-line v-if="data_loaded" :labels="data_labels" :datasets="datasets3"></show-line>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="box box-primary border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-header with-border box-header-custom">
                                <h3 class="box-title fs-15 fw-600"> Top 10 Items Reported Expired: Overall </h3>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 60%">Item</th>
                                        <th style="width: 10%">VEN</th>
                                        <th style="width: 15%">Facilities</th>
                                        <th style="width: 15%">Alt</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>Amoxicillin 250mg Capsules 10's</td>
                                        <td>V</td>
                                        <td>230</td>
                                        <td>20%</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </section>

        </div>

        <page-footer></page-footer>

    </div>
    
</template>

<script>

    import {get,post} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    import ShowLine from '../../../../analytics/ShowLine'
    import PageHeader from '../patials/Header'
    import PageFooter from '../patials/Footer'
    export default {
        name: "InventoryHome",
        components: {PageHeader,PageFooter,ShowLine},
        data(){
            return {
                data_loaded: false,
                data_labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets3: [
                    {
                        label: 'Max level',
                        backgroundColor:'transparent',
                        borderColor: '#00c0ef',
                        borderWidth: 2,
                        data: [600, 600, 600, 600, 600,600,600,600,600,600,600,600]
                    },
                    {
                        label: 'Stock level',
                        backgroundColor:'transparent',
                        borderColor: '#f486b9',
                        borderWidth: 2,
                        data: [600, 500, 450, 450, 450,450,450,450,450,450,450,450]
                    },
                    {
                        label: 'Re-order level',
                        backgroundColor:'transparent',
                        borderColor: '#f486b9',
                        borderWidth: 2,
                        data: [450, 450, 450, 450, 450,450,450,450,450,450,450,450]
                    },
                    {
                        label: 'Min level',
                        backgroundColor:'transparent',
                        borderColor: '#f10',
                        borderWidth: 2,
                        data: [300, 300, 300, 300, 300,300,300,300,300,300,300,300]
                    },
                ],
            }
        },
        mounted() {
            this.data_loaded = true;
            console.info(Auth.getCurrentAccount('account'))
        }
    }
</script>

<style scoped>

</style>