<template>

    <div class="modal-content">

        <div  class="modal-header">
            <h4 class="cl-grey"><i class="fa fa-edit"></i> View Product Item:</h4>
            <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
        </div>

        <div  class="modal-body padding-top-0">

            <div class="row">

                <div class="col-xs-12 col-md-6 col-lg-6 col-sm-6">
                    <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-0"><i class="fa fa-check-circle"></i> Inventory Item</h4>
                    <div class="item-info half mg-top-1">
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Item name:</div>
                            <div class="value">{{product_item.item_name}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Generic name:</div>
                            <div class="value">{{product_item.generic_name}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Code:</div>
                            <div class="value">{{product_item.item_code}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Manufacturer:</div>
                            <div class="value">
                                {{product_item.manufacturer}}
                            </div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Profile name:</div>
                            <div class="value">
                                {{product_item.product_type}}
                            </div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Barcode:</div>
                            <div class="value">{{product_item.barcode}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Note:</div>
                            <div class="value tax-value">{{product_item.item_note}}</div>
                        </div>
                    </div>
                    <div class="item-info half mg-top-1">
                        <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-0"><i class="fa fa-check-circle"></i> Grouping</h4>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Brand:</div>
                            <div class="value">{{product_item.product_brand}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Brand sector:</div>
                            <div class="value">{{product_item.product_brand}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Profile name:</div>
                            <div class="value">{{product_item.product_type}}</div>
                        </div>
                        <div v-if="product_item.product_type==='Drug'" class="info-block mg-bottom-1">
                            <div class="name width-150-px">Category:</div>
                            <div class="value">{{product_item.product_category}}</div>
                        </div>
                        <div v-if="product_item.product_type==='Drug'" class="info-block mg-bottom-1">
                            <div class="name width-150-px">Route:</div>
                            <div class="value">{{product_item.product_route}}</div>
                        </div>
                    </div>
                    <div class="item-info half mg-top-1">
                        <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-0"><i class="fa fa-check-circle"></i> Unit and Weights:</h4>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Unit of Measure:</div>
                            <div class="value">{{product_item.product_unit}} ({{product_item.product_unit_slug}})</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px"> Product weight:</div>
                            <div class="value">{{product_item.single_unit_weight}} {{product_item.product_unit_slug}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Units Per Pack:</div>
                            <div class="value">{{product_item.units_per_pack}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Net Weight:</div>
                            <div class="value">{{product_item.single_unit_weight * product_item.units_per_pack}} {{product_item.product_unit_slug}}</div>
                        </div>
                    </div>
                    <div class="item-info half mg-top-1">
                        <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-0"><i class="fa fa-check-circle"></i>  Extra information:</h4>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Re-order level:</div>
                            <div class="value">{{product_item.alert_indicator_level}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Retail Price:</div>
                            <div class="value">KES {{product_item.retail_price}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Tax & Charges:</div>
                            <div class="value">{{product_item.tax_charges}}</div>
                        </div>
                        <div class="info-block mg-bottom-1">
                            <div class="name width-150-px">Unit Location:</div>
                            <div class="value">{{product_item.unit_storage_location}}</div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-sm-6">
                    <div class="box-body bg-white padding-0 mg-top-30">
                        <table class="items table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 33.33%">Batch number</th>
                                    <th style="width: 33.33%">Quantity</th>
                                    <th style="width: 33.33%">Expiry date</th>
                                </tr>
                            </thead>
                            <tbody>
<!--                                <tr v-if="stocks.length > 0">-->
<!--                                    <td></td>-->
<!--                                    <td></td>-->
<!--                                    <td></td>-->
<!--                                </tr>-->
<!--                                <tr v-if="stocks.length < 1">-->
<!--                                    <td colspan="3" style="text-align: center; color: #f10;">No stock recorded on this product item</td>-->
<!--                                </tr>-->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-inventory">
                <i class="fa fa-close" aria-hidden="true"></i> Close
            </button>
        </div>
    </div>
    
</template>

<script>
    export default {
        name: "ViewProductItemModal",
        props: ['product_item','stocks'],
        data(){
            return {
                product_item_data: {},
            }
        },
        mounted(){
        },
    }
</script>

<style scoped>

</style>