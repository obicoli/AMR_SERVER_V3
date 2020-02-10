<template>

    <div class="hold-transition skin-yellow sidebar-collapse">
        <page-header :inventory="true"></page-header>

        <div class="content-wrapper">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left width-50-pc app-header">
                            <h5>
                                Inventory |
                                <small>Medicine Category</small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                        <div class="pull pull-right text-right width-50-pc">
                            <a v-bind:href="'/inventory/items/add'" class="btn btn-inventory">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Go to New Item
                            </a>
                            <a v-bind:href="'/inventory/stock/add'"  class="btn btn-inventory">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Go to Add Stock
                            </a>
                            <a v-bind:href="'/inventory/stock/consume'"  class="btn btn-inventory">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Go to Consume Stock
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <page-footer></page-footer>
    </div>

</template>

<script>
    import PageHeader from '../patials/Header'
    import PageFooter from '../patials/Footer'
    export default {
        name: "ProdCategory",
        components: {
            PageFooter,PageHeader
        }
    }
</script>

<style scoped>

</style>