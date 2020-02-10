<!--<template>-->
<!--    -->
<!--</template>-->

<!--<script>-->
<!--    export default {-->
<!--        name: "LedgerAccount"-->
<!--    }-->
<!--</script>-->

<!--<style scoped>-->

<!--</style>-->

<template>

    <div class="hold-transition skin-yellow sidebar-collapse">
        <page-header :statements="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left width-20-pc app-header">
                            <h5>
                                General ledger
                            </h5>
                        </div>
                        <div class="pull pull-right width-80-pc">
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">

                    <div class="col-xs-12 col-md-12 col-sm-12">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                            <div class="box-header box-header-custom">

                                <div class="pull pull-right inlined-content width-100-pc text-right">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc width-170-px" data-live-search="true" style="width: 100%;">
                                        <option value="">-Branch-</option>
                                    </select>
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc width-170-px" data-live-search="true" style="width: 100%;">
                                        <option value="">-Department-</option>
                                    </select>
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc width-170-px" data-live-search="true" style="width: 100%;">
                                        <option value="">-Store-</option>
                                    </select>
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc width-170-px" data-live-search="true" style="width: 100%;">
                                        <option value="">-Sub Store-</option>
                                    </select>
                                    <button class="btn btn-inventory navy">Create ledger</button>
                                </div>

                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 12%">Name</th>
                                        <th style="width: 12%">Item Code</th>
                                        <th style="width: 12%">Type</th>
                                        <th style="width: 12%">Retail Price(KES)</th>
                                        <th style="width: 12%">Total Stock</th>
                                        <th style="width: 12%">Available Stock</th>
                                        <th style="width: 12%">Expired Stock</th>
                                        <th style="width: 12%">Reorder Level</th>
                                        <th style="width: 4%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">

                                    <tr class="ng-scope">
                                        <td class="ng-binding">
                                            Capsule Amoxy (250 Mg) 250 mg
                                            <i title="Migrated from Drug Catalog" class="floatright icon icon-share-alt" style="display: none;"></i>
                                        </td>
                                        <td class="ng-binding">NHD</td>
                                        <td class="ng-binding">Drug</td>
                                        <td>
                                            <div class="ng-binding">
                                                200.00
                                                <i class="tax-text">
                                                    Tax@0.50%
                                                </i>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="quantity ng-binding">4500 Capsule(s)</span>
                                        </td>
                                        <td>
                                            <span class="quantity ng-binding">450</span>
                                            <span class="lowstocklabel">Low</span>
                                        </td>
                                        <td>
                                            <span class="quantity ng-binding">0</span>
                                            <span class="expiredstocklabel noprintclass">Expired</span>
                                        </td>
                                        <td class="ng-binding">200</td>
                                        <td class="actions">
                                            <i class="fa fa-edit pointer-cursor"></i>
                                        </td>
                                    </tr>

                                    <tr class="ng-scope">
                                        <td class="ng-binding">
                                            Capsule Amoxy (250 Mg) 250 mg
                                            <i title="Migrated from Drug Catalog" class="floatright icon icon-share-alt" style="display: none;"></i>
                                        </td>
                                        <td class="ng-binding">NHD</td>
                                        <td class="ng-binding">Drug</td>
                                        <td>
                                            <div class="ng-binding">
                                                200.00
                                                <i class="tax-text">
                                                    Tax@0.50%, ExtraCharge@0.50%
                                                </i>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="quantity ng-binding">4500 Capsule(s)</span>
                                        </td>
                                        <td>
                                            <span class="quantity ng-binding">4500</span>
                                        </td>
                                        <td>
                                            <span class="quantity ng-binding">0</span>
                                            <span class="expiredstocklabel noprintclass">Expired</span>
                                        </td>
                                        <td width="10%" class="ng-binding">1000</td>
                                        <td class="actions">
                                            <i class="fa fa-edit pointer-cursor"></i>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-inventory">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                Print all items with stock
                            </button>
                            <button type="button" class="btn btn-inventory">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                Email all items with stock
                            </button>
                        </div>
                    </div>

                </div>

            </section>

        </div>

        <page-footer></page-footer>
    </div>

</template>

<script>
    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    export default {
        name: "LedgerAccount",
        components: {
            PageFooter,PageHeader
        }
    }
</script>

<style scoped>

</style>