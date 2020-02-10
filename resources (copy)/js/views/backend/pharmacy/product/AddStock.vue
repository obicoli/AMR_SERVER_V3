<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <page-header :inventory="true"></page-header>

        <div class="content-wrapper bg-white mg-bottom-50">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header">
                            <h5>
                                Add Stock |
                                <small>Store Name</small>&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-inventory small">Show me how this works</a>
                            </h5>
                        </div>
                        <div class="pull pull-right">
                            <a v-bind:href="'/inventory/items'"  class="btn btn-inventory">
                                <i class="fa fa-close" aria-hidden="true"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- pages navigates here -->
            <section class="invoice bg-white">

                <form id="invoice_form">

                    <div class="row">
                        <div class="col-md-3 overflow-y-scrollable min-height-400 padding-right-0 padding-left-0">

                            <div class="width-100-pc padding-10" style="background-color: #f7f7f7!important;">
                                <div class="filter-block form-inline">
                                    <div class="filter-group input-group">
                                        <span class="filter active">Drugs</span>
                                        <span class="filter">Supplies</span>
                                        <span class="filter">Equipments</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group mg-top-20">
                                        <label><i class="fa fa-barcode" aria-hidden="true"></i> SCAN BARCODE OR SEARCH ITEMS</label>
                                        <input type="text" class="form-control width-200-px" @keyup="" autofocus="autofocus" />
                                    </div>
                                </div>
                            </div>

                            <div class="width-100-pc item-search-list">
                                <a>
                                    <span>Capsule Amoxy (250 Mg) 250 mg | aquafina | HTR43 | Stock: 400
                                        <span class="cl-red fs-14 fw-600">Low</span>
                                        <span class="cl-grey fs-14 fw-600 pull-right"><i class="fa fa-arrow-circle-o-right"></i></span>
                                    </span>
                                </a>
                            </div>
                            <div class="width-100-pc item-search-list">
                                <a>
                                    <span>Capsule Amoxy (250 Mg) 250 mg | aquafina | HTR43 | Stock: 400
                                        <span class="cl-red fs-14 fw-600">Low</span>
                                        <span class="cl-grey fs-14 fw-600 pull-right"><i class="fa fa-arrow-circle-o-right"></i></span>
                                    </span>
                                </a>
                            </div>

<!--                            <ul>-->
<!--                                <li>-->
<!--                                    <span>Capsule Amoxy (250 Mg) 250 mg | aquafina | HTR43 | Stock: 400 <span class="cl-red fs-14 fw-600">Low</span></span>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <span>Capsule Amoxy (250 Mg) 250 mg | aquafina | HTR43 | Stock: 400 <span class="cl-red fs-14 fw-600">Low</span></span>-->
<!--                                </li>-->
<!--                            </ul>-->

                        </div>
                        <div class="col-md-9">
                            <div class="row total-grid-values min-height-60">
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">-select branch-</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">-select department-</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">-select store-</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">-select store-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mg-bottom-5 mg-top-10">
                                <span class="cl-blue-link pointer-cursor fs-14"><input type="checkbox" value="1"> I have a supplier</span>
                            </div>
                            
                            <div class="row">
                                <div  id="inner_invoice_area" class="col-md-12 padding-left-0 padding-right-0">
                                    <div class="col-md-12 padding-left-0 padding-right-0">
                                        <table class="table table-striped table-bordered table_height_set">
                                            <thead>
                                            <tr>
                                                <th class="cl-444" style="width: 30%">Item</th>
                                                <th class="cl-444" style="width: 15%">Quantity</th>
                                                <th class="cl-444" style="width: 23%">Batch</th>
                                                <th class="cl-444" style="width: 15%">Unit Cost(KES)</th>
                                                <th class="cl-444" style="width: 17%">Total Cost</th>
                                            </tr>
                                            </thead>
                                            <tbody><tr class="ng-scope">
                                                <td class="ng-binding">
                                                    Capsule Amoxy (250 Mg) 250 mg | aquafina | HTR43<br>
                                                    <span class="cl-grey fs-14 fw-600 pull-left pointer-cursor"><i class="fa fa-arrow-circle-o-left cl-red"></i></span>
                                                </td>
                                                <td class="ng-binding">
                                                    <input type="number" class="form-control product-entry-input-field height-32">
                                                    <small>Capsule(s)</small>
                                                </td>
                                                <td>
                                                    <input type="text" v-model="stock_form.batch_number" required class="form-control product-entry-input-field height-32" placeholder="Batch Number">
                                                    <div v-if="stock_form.batch_number !==''" class="expiry-content mg-top-5">
                                                        <span class="cl-444 fs-14 fw-600">Expiry:</span>
                                                        <select required class="bg-white height-27 border-radius-2 border-ccc no-shadowed" style="width: 35%;">
                                                            <option value="1">Jan</option>
                                                            <option value="2">Feb</option>
                                                            <option value="3">Mar</option>
                                                            <option value="4">Apr</option>
                                                            <option value="5">May</option>
                                                            <option value="6">Jun</option>
                                                            <option value="7">Jul</option>
                                                            <option value="8">Aug</option>
                                                            <option value="9">Sep</option>
                                                            <option value="10">Oct</option>
                                                            <option value="11">Nov</option>
                                                            <option value="12">Dec</option>
                                                        </select>
                                                        <select required class="bg-white height-27 border-radius-2 border-ccc no-shadowed" style="width: 35%;">
                                                            <option value="2019">2019</option>
                                                            <option value="2020">2020</option>
                                                            <option value="2021">2021</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control product-entry-input-field">
                                                </td>
                                                <td>
                                                    <input type="number" disabled class="form-control product-entry-input-field height-32">
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>

                                        <div class="text-center">
                                            <button  type="button" class="btn btn-inventory">
                                                <i class="fa fa-arrow-left" aria-hidden="true"></i>RETURN ITEMS
                                            </button>
                                            <button type="submit"  id="submit_btn" class="btn btn-inventory primary">
                                                <i class="fa fa-save"></i>  SAVE
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

            </form>
        </section>
        <!-- Bootstrap model  -->

        </div>

        <page-footer></page-footer>
    </div>

</template>

<script>
    import PageHeader from '../patials/Header'
    import PageFooter from '../patials/Footer'
    export default {
        name: "AddStock",
        components: {
            PageFooter,PageHeader
        },
        data(){
            return {
                stock_form: {
                    batch_number: ''
                }
            }
        },
    }
</script>

<style scoped>

</style>