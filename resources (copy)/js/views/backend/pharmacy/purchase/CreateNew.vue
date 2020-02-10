<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <page-header :purchases="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-50-pc">
                            <h5>
                                Purchases | <small>Create new purchase</small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                        <div class="pull pull-right width-50-pc text-right">
                            <a v-bind:href="'/purchases'" class="btn btn-inventory">
                                <i class="fa fa-arrow-left"></i>
                                Back to purchase
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">

                    <div class="col-xs-12 col-md-12 col-sm-12">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                            <div class="box-header box-header-custom">

                                <div class="pull pull-right width-100-pc">

                                    <div class="filters">
                                        <div class="filter-block form-inline pull-right text-right">
                                            <span class="name">Type: </span>
                                            <div class="filter-group input-group">
                                                <a class="filter active">Direct procurement</a>
                                                <span class="filter">Competitive</span>
                                                <span class="filter">Attach Fragment</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="box-body bg-white padding-0">

                                <div class="padding-left-20 padding-right-20 padding-top-20">
                                    <direct-procurement-form></direct-procurement-form>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </section>

            <!-- pages navigates here -->
            <section class="content bg-white">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <div class="mg-left-30 border-top-0 border-bottom-0 border-radius-0">
<!--                            <direct-procurement-form></direct-procurement-form>-->
                        </div>
                    </div>
                </div>

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_manufacturer_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >

                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_tax_charge_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >

                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_unit_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
            </section>
            <!-- Bootstrap model  -->

        </div>

        <page-footer></page-footer>

    </div>
    
</template>

<script>
    import PageHeader from '../patials/Header'
    import PageFooter from '../patials/Footer'
    import DirectProcurementForm from './partials/DirectProcurementForm'
    export default {
        name: "CreateNew",
        components: {PageHeader,PageFooter,DirectProcurementForm}
    }
</script>

<style scoped>

</style>