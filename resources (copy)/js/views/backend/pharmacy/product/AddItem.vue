
<template>

    <div class="hold-transition skin-yellow sidebar-collapse">
        <loading :is-loading="processing"></loading>
        <page-header :inventory="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-50-pc">
                            <h5>
                                Inventory |
                                <small>Add New Item</small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                        <div class="pull pull-right width-50-pc text-right">
                            <a v-bind:href="'/inventory/items'" class="btn btn-inventory">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back to Item
                            </a>
                            <a v-bind:href="'/inventory/stock/add'"  class="btn btn-inventory">
                                Add Stock
                            </a>
                            <a v-bind:href="'/inventory/stock/consume'"  class="btn btn-inventory">
                                Consume Stock
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- pages navigates here -->
            <section class="content bg-white">
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6 col-sm-6">
                        <div class="mg-left-30 border-top-0 border-bottom-0 border-radius-0">
                            <form @submit.prevent="save_item">
                                <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                                    <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"><i class="fa fa-check-circle"></i> Inventory Item<small class="width-78-pc bordered-small"></small></h4>
                                    <div class="row form-group mg-bottom-10">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Item Name:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="item_form.item_name" @keydown="searchProduct($event,'products')" list="product_list" class="form-control product-entry-input-field" placeholder="e.g Amoxicillin">
                                            <datalist id="product_list">
                                                <option v-for="product_list in products_list" :value="product_list.name">{{product_list.name}}</option>
                                            </datalist>
                                            <small>Name of the medicine or product? </small>
                                        </div>
                                    </div>
                                    <div class="row form-group mg-bottom-10">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Generic Name:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" @keydown="searchProduct($event,'generics')" required v-model="item_form.generic_name" list="generics_list" class="form-control product-entry-input-field" placeholder="e.g amoxicillin">
                                            <datalist id="generics_list">
                                                <option v-for="generic_item in generics_lists" :value="generic_item.name">{{generic_item.name}}</option>
                                            </datalist>
                                        </div>
                                    </div>

                                    <div class="row form-group mg-bottom-15">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Item Code:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="item_form.item_code" @keydown="searchProduct($event,'item_code')" class="form-control product-entry-input-field" placeholder="Example: INV392">
                                            <small v-if="item_code_taken" class="cl-red">Item code already taken</small>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Manufacturer:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" @keydown="searchProduct($event,'manufacturers')" required v-model="item_form.manufacturer" list="manufacturer_list" class="form-control product-entry-input-field" placeholder="">
                                            <datalist id="manufacturer_list">
                                                <option v-for="manufacture in manufacturers" :value="manufacture.name">{{manufacture.name}}</option>
                                            </datalist>
                                        </div>
                                        <div class="col-lg-2 padding-left-0"><a class="fs-14 pointer-cursor cl-blue-link" data-toggle="modal" data-target="#add_manufacturer_modal"> (add)</a></div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Profile name:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select required v-model="item_form.item_type" @change="setDrugs($event)" class="form-control bg-white height-36 border-radius-2 border-ccc" style="width: 100%;">
                                                <option value="" selected disabled>-select-</option>
                                                <option v-for="product_typ in product_types" :value="product_typ.name">{{product_typ.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div v-if="is_drug" class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Item Category:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="item_form.item_category" list="category_list" class="form-control product-entry-input-field" placeholder="">
                                            <datalist id="category_list">
                                                <option v-for="product_categorie in product_categories" :value="product_categorie.name">{{product_categorie.name}}</option>
                                            </datalist>

<!--                                            <select class="form-control selectpicker bg-white height-36 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">-->
<!--                                                <option v-for="product_type in product_types" :value="product_type.id">{{product_type.name}}</option>-->
<!--                                            </select>-->

                                        </div>
                                        <div class="col-lg-2 padding-left-0"><a class="fs-14 cl-blue-link pointer-cursor" data-toggle="modal" data-target="#add_tax_charge_modal">(add category)</a></div>
                                    </div>
                                    <div v-if="is_drug" class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Drug Route:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="item_form.product_routes_name" list="routes_list" class="form-control product-entry-input-field" placeholder="">
                                            <datalist id="routes_list">
                                                <option v-for="product_rout in product_routes" :value="product_rout.name">{{product_rout.name}}</option>
                                            </datalist>
<!--                                            <select class="form-control selectpicker bg-white height-36 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">-->
<!--                                                <option v-for="product_type in product_types" :value="product_type.id">{{product_type.name}}</option>-->
<!--                                            </select>-->
                                        </div>
                                        <div class="col-lg-2 padding-left-0"><a class="fs-14 cl-blue-link pointer-cursor" data-toggle="modal" data-target="#add_tax_charge_modal">(add category)</a></div>
                                    </div>

<!--                                    <div class="row form-group mg-bottom-15">-->
<!--                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">-->
<!--                                            <label class="fs-14 cl-888">SKU:</label>-->
<!--                                        </div>-->
<!--                                        <div class="col-lg-7 col-md-7 col-sm-7">-->
<!--                                            <input type="text" name="product_name" class="form-control product-entry-input-field" placeholder="Example: SKU">-->
<!--                                            <small>Stock keeping unit ? </small>-->
<!--                                        </div>-->
<!--                                    </div>-->

                                    <div class="row form-group mg-bottom-15">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Barcode:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="item_form.barcode" class="form-control product-entry-input-field" placeholder="e.g 000025444255658">
                                        </div>
                                    </div>
                                    <div class="row form-group mg-bottom-15">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Image:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="file"  class="form-control product-entry-input-field">
                                            <small>Product scan or captured image ? </small>
                                        </div>
                                    </div>
                                    <div class="row form-group mg-bottom-15">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Note:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <textarea v-model="item_form.item_note" required style="max-height: 70px!important;" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                                    <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"> <i class="fa fa-check-circle"></i> Grouping<small class="width-85-pc bordered-small"></small></h4>

                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Brand:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" @keydown="searchProduct($event,'brands')" required v-model="item_form.brand_name" list="brands_list" class="form-control product-entry-input-field" placeholder="">
                                            <datalist id="brands_list">
                                                <option v-for="brands_lis in brands_lists" :value="brands_lis.name">{{brands_lis.name}}</option>
                                            </datalist>
                                        </div>
                                        <div class="col-lg-2 padding-left-0"><a class="fs-14 pointer-cursor cl-blue-link" data-toggle="modal" data-target="#add_tax_charge_modal"> (add brand)</a></div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Brand Sector:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select class="form-control bg-white height-36 border-radius-2 border-ccc" style="width: 100%;">
<!--                                                <option v-for="product_type in product_types" :value="product_type.id">{{product_type.name}}</option>-->
                                            </select>
                                        </div>
                                        <div class="col-lg-2 padding-left-0"><a class="fs-14 cl-blue-link pointer-cursor" data-toggle="modal" data-target="#add_tax_charge_modal"> (add sector)</a></div>
                                    </div>

                                    <div class="row">

                                    </div>
                                </div>

                                <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                                    <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"><i class="fa fa-check-circle"></i> Unit and Weights:<small class="width-75-pc bordered-small"></small></h4>
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Unit Type:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" @keydown="searchProduct($event,'units')" required v-model="item_form.unit_measure" list="product_units" class="form-control product-entry-input-field" placeholder="e.g Kilogram (Kg)">
                                            <datalist id="product_units">
                                                <option v-for="product_uni in product_units" :value="product_uni.name+' ('+product_uni.slug+')'">{{product_uni.name}} ({{product_uni.slug}})</option>
                                            </datalist>
                                            <small>Product weight measurement? (Make sure this is the same as the unit in which you dispense this item.)</small>
                                        </div>
                                        <div class="col-lg-2 padding-left-0"><a class="fs-14 cl-blue-link pointer-cursor" data-toggle="modal" data-target="#add_unit_modal">(add unit)</a></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Unit Weight:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="number" required v-model="item_form.single_unit_weight" class="form-control product-entry-input-field" placeholder="e.g 250">
                                            <small>Single product weight ?</small>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Units Per Pack:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="number" required v-model="item_form.units_per_pack" class="form-control product-entry-input-field" placeholder="e.g 12">
                                            <small>Total number of products in each pack ?</small>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Net Weight:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="number" required v-model="item_form.net_weight" class="form-control product-entry-input-field" placeholder="e.g 1000">
                                            <small>Total weight of packsize ?</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                                    <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"><i class="fa fa-check-circle"></i> Extra information <small class="width-75-pc bordered-small"></small></h4>
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Re-order level:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="item_form.alert_indicator_level" class="form-control product-entry-input-field" placeholder="e.g 2000">
                                            <small>Product alert indicator level ?(We'll send you e-mail/SMS alerts when stock level reaches or goes below the Reorder Level)</small>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Retail Price:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="number" v-model="item_form.retail_price" required class="form-control product-entry-input-field" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Sales Tax/charges Per Unit(%):</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="item_form.tax_per_unit" required multiple class="form-control bg-white height-36 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                                <option>Tax(0.4%)</option>
                                                <option>Other charge(0.5%)</option>
                                                <option>Extra charge(0.4%)</option>
                                            </select>
                                            <small>Sales tax & charges on each product in % ?</small>
                                        </div>
                                        <div class="col-lg-2 padding-left-0"><a data-toggle="modal" data-target="#add_tax_charge_modal" class="fs-14 cl-blue-link pointer-cursor">(add)</a></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Unit Location in store:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" v-model="item_form.unit_storage_location" class="form-control product-entry-input-field" placeholder="e.g Top right corner">
                                            <small>Location where you stored this product in store.</small>
                                        </div>
                                    </div>

                                </div>
                                <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-inventory primary" type="submit">
                                                <i class="fa fa-save"></i> Save Item
                                            </button>
                                            <a class="btn btn-inventory">
                                                <i class="fa fa-refresh"></i>
                                                Reset
                                            </a>
                                            <a class="btn btn-inventory">
                                                <i class="fa fa-close"></i>
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_manufacturer_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <add-manufacturer-modal v-on:manufacturerAdded="manufacture_added"></add-manufacturer-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_tax_charge_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <tax-charge-modal></tax-charge-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_unit_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <add-unit-modal></add-unit-modal>
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
    import {get,post} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    import AddManufacturerModal from './partials/AddManufacturerModal'
    import TaxChargeModal from './partials/TaxChargeModal'
    import AddUnitModal from './partials/AddUnitModal'
    import Loading from '../../../../components/loads/ProgRess'
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";

    export default {
        name: "AddItem",
        components: {
            PageFooter,PageHeader,AddManufacturerModal,TaxChargeModal,AddUnitModal,Loading
        },
        data(){
            return {
                product_types: [],
                product_categories: [],
                product_routes: [],
                product_units: [],
                manufacturers: [],
                products_list: [],
                generics_lists: [],
                taxes_charges: [],
                brands_lists: [],
                item_form: {
                    item_name: '',
                    generic_name: '',
                    manufacturer: '',
                    item_code: '',
                    item_type: '',
                    sku: '',
                    barcode: '',
                    item_note: '',
                    brand_name: '',
                    brand_sector: '',
                    item_category: '',
                    unit_measure: '',
                    single_unit_weight: '',
                    net_weight: '',
                    alert_indicator_level: '',
                    units_per_pack: '',
                    tax_per_unit: [],
                    unit_storage_location: '',
                    practice_id: '',
                    product_routes_name: '',
                    retail_price: '',
                },
                processing: false,
                item_code_taken: false,
                is_drug: false,
            }
        },
        created(){

        },
        methods: {

            manufacture_added(manufacturer){
                console.info(manufacturer)
                this.item_form.manufacturer = manufacturer.name
            },
            save_item(){

                this.processing = true;
                let url_ = AppInfo.app_data.server_domain+'/api/branches/products/items';
                this.item_form.practice_id = Auth.getMain().id;
                post(url_, this.item_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$awn.success(res.data.description);
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });

            },
            loadManufacturer(){
                get(AppInfo.app_data.server_domain+'/api/manufacturers')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.manufacturers = res.data.results
                        //this.loadUnits();
                    }
                }).catch((err) => {

                });
            },
            loadUnits(){
                get(AppInfo.app_data.server_domain+'/api/products/units')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.product_units = res.data.results
                        }
                    }).catch((err) => {

                });
            },
            loadProductType(){
                get(AppInfo.app_data.server_domain+'/api/products/types')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.product_types = res.data.results;
                            console.info(this.product_types);
                        }
                    }).catch((err) => {

                });
            },
            loadTaxesCharges(){

            },
            searchProduct(event, search_type){
                let url_search = AppInfo.app_data.server_domain+'/api/search/'+search_type;
                let formData = new FormData();
                formData.append('name', event.target.value);
                formData.append('practice_id', Auth.getMain().id);
                post(url_search, formData)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        switch (search_type) {
                            case "products":
                                this.products_list = res.data.results;
                                break;
                            case "generics":
                                this.generics_lists = res.data.results;
                                break;
                            case "item_code":
                                this.item_code_taken = res.data.results;
                                break;
                            case "manufacturers":
                                this.manufacturers = res.data.results;
                                break;
                            case "brands":
                                this.brands_lists = res.data.results;
                                break;
                            case "units":
                                this.product_units = res.data.results;
                                break;
                        }
                    }
                }).catch((err) => {

                });
            },
            loadDrugsData(type_to){

                post(AppInfo.app_data.server_domain+'/api/search/'+type_to)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            switch (type_to) {
                                case "drug_categories":
                                    this.product_categories = res.data.results;
                                    break;
                                case "drug_routes":
                                    this.product_routes = res.data.results;
                                    console.info(this.product_routes);
                                    break;
                            }

                        }
                    }).catch((err) => {

                });

            },
            setDrugs(event){
                if (event.target.value === "Drug") {
                    this.loadDrugsData("drug_categories");
                    this.loadDrugsData("drug_routes");
                    this.is_drug = true;
                }else{
                    this.is_drug = false;
                }
            }
        },
        mounted(){
            //this.loadManufacturer();
            this.loadProductType();
            //this.product_type = Auth.getLoggedUser().product_types;
        }
    }
</script>

<style scoped>

</style>