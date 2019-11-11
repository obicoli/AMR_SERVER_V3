
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
                                Consume Stock |
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
                                    <span>Capsule Amoxy (250 Mg) 250 mg | aquafina | HTR43 | Stock: 4000
                                        <span class="cl-grey fs-14 fw-600 pull-right"><i class="fa fa-arrow-circle-o-right"></i></span>
                                    </span>
                                </a>
                            </div>

                        </div>
                        <div class="col-md-9">
                            <div class="row total-grid-values min-height-60">
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">Branch</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">Department</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">Store</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                        <option value="">Sub store</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group mg-top-20">
                                <div class="col-lg-6 col-md-6 col-sm-7">
                                    <label class="fs-14 cl-888">Type of consumption:</label>
                                    <select required class="form-control width-250-px selectpicker bg-white height-32 border-radius-0 border-ccc" data-live-search="true">
                                        <option value="">select</option>
                                        <option value="Sales">Sales</option>
                                        <option value="Movement">Dispense</option>
                                        <option value="Damage">Damage</option>
                                        <option value="Return">Return</option>
                                        <option value="Movement">Move stock</option>
                                        <option value="Movement">Adjustment</option>
                                        <option value="Movement">Expired</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div  id="inner_invoice_area" class="col-md-12 padding-left-0 padding-right-0">
                                    <div class="col-md-12 padding-left-0 padding-right-0">
                                        <table class="table table-striped table-bordered table_height_set">
                                            <thead>
                                            <tr>
                                                <th class="cl-444" style="width: 40%">Item</th>
                                                <th class="cl-444" style="width: 30%">Quantity</th>
                                                <th class="cl-444" style="width: 30%">Batch</th>
                                            </tr>
                                            </thead>
                                            <tbody><tr class="ng-scope">
                                                <td class="ng-binding">
                                                    Capsule Amoxy (250 Mg) 250 mg | HTR43<br>
                                                    <span class="cl-grey fs-14 fw-600 pull-left pointer-cursor"><i class="fa fa-arrow-circle-o-left cl-red"></i></span>
                                                </td>
                                                <td class="ng-binding">
                                                    <input type="number" class="product-entry-input-field width-60-pc height-32">
                                                    <small class="width-30-pc pull-right">Capsule(s)</small>
                                                </td>
                                                <td>
                                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                                        <option value="">select</option>
                                                        <option value="0" selected="selected">#ree (Quantity:500, Exp. Jun-2028)</option>
                                                        <option value="1">#uuu (Quantity:4000, Exp. Jul-2027)</option>
                                                    </select>
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
        name: "ConsumeStock",
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