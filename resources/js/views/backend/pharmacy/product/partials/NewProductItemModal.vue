<template>

    <div class="modal-content">

        <form @submit.prevent="save_item">

            <div  class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-plus-square-o"></i> New Product Item:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>

            <div  class="modal-body padding-top-0">

                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                            <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"><i class="fa fa-check-circle"></i> Inventory Item</h4>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Item Name:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" required v-model="item_form.item_name" @keydown="searchProduct($event,'products')" list="product_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.item_name}" placeholder="e.g Amoxicillin">
                                    <datalist id="product_list">
                                        <option v-for="product_list in products_list" :value="product_list.name">{{product_list.name}}</option>
                                    </datalist>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Generic Name:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" @keyup="searchProduct($event,'generics')" required v-model="item_form.generic_name" list="generics_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.generic_name}" placeholder="e.g amoxicillin">
                                    <datalist id="generics_list">
                                        <option v-for="generic_item in generics_lists" :value="generic_item.name">{{generic_item.name}}</option>
                                    </datalist>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-15">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Item Code:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" required v-model="item_form.item_code" @keyup="searchProduct($event,'item_code')" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.item_code}" placeholder="">
                                    <small v-if="item_code_taken" class="cl-red">Item code already in use</small>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Manufacturer:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" @change="searchProduct($event,'manufacturers')" required v-model="item_form.manufacturer" list="manufacturer_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.manufacturer}" placeholder="">
                                    <datalist id="manufacturer_list">
                                        <option v-for="manufacture in manufacturers" :value="manufacture.name">{{manufacture.name}}</option>
                                    </datalist>
                                </div>
<!--                                <div class="col-lg-2 padding-left-0"><a class="fs-14 pointer-cursor cl-blue-link" data-toggle="modal" data-target="#add_manufacturer_modal"> (add)</a></div>-->
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Profile name:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <select required v-model="item_form.item_type" @change="searchProduct($event,'drug_categories')" v-bind:class="{'bg-white height-36 border-radius-2 border-ccc product-entry-input-field':true,'attended_field':item_form.item_type}" style="width: 100%;">
                                        <option value="" selected disabled>-select-</option>
                                        <option v-for="product_typ in product_types" :value="product_typ.name">{{product_typ.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-15">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Barcode:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" required v-model="item_form.barcode" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.barcode}" placeholder="">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-15">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Image:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="file"  class="form-control product-entry-input-field">
                                    <small>Product scan or captured image ? </small>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-15">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Note:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <textarea v-model="item_form.item_note" required style="max-height: 70px!important;" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.item_note}" rows="5"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="bg-white border-top-0 border-bottom-0 border-radius-0 mg-top-15">
                            <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"> <i class="fa fa-check-circle"></i> Grouping</h4>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Brand:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" @keydown="searchProduct($event,'brands')" required v-model="item_form.brand_name" list="brands_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.brand_name}" placeholder="">
                                    <datalist id="brands_list">
                                        <option v-for="brands_lis in brands_lists" :value="brands_lis.name">{{brands_lis.name}}</option>
                                    </datalist>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Brand Sector:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" @keydown="searchProduct($event,'brand_sector')" required v-model="item_form.brand_sector" list="brandsector_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.brand_sector}" placeholder="">
                                    <datalist id="brandsector_list">
                                        <option v-for="brands_liss in brandsector_lists" :value="brands_liss.name">{{brands_liss.name}}</option>
                                    </datalist>
<!--                                    <select class="form-control bg-white height-36 border-radius-2 border-ccc" style="width: 100%;"></select>-->
                                </div>
                            </div>
                            <div v-if="is_drug" class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Item Category:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" required v-model="item_form.item_category" list="category_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.item_category}" placeholder="">
                                    <datalist id="category_list">
                                        <option v-for="product_categorie in product_categories" :value="product_categorie.name">{{product_categorie.name}}</option>
                                    </datalist>
                                </div>
                            </div>
                            <div v-if="is_drug" class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Drug Route:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" required v-model="item_form.product_routes_name" list="routes_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.product_routes_name}" placeholder="">
                                    <datalist id="routes_list">
                                        <option v-for="product_rout in product_routes" :value="product_rout.name">{{product_rout.name}}</option>
                                    </datalist>
                                </div>
                            </div>

                            <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"><i class="fa fa-check-circle"></i> Unit and Weights:</h4>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Unit Type: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Product weight measurement? e.g Kg, Gm, Ml etc. NOTE: Make sure this is the same as the unit in which you dispense this item."></i></small></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" @keydown="searchProduct($event,'units')" required v-model="item_form.unit_measure" list="product_units" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.unit_measure}" placeholder="">
                                    <datalist id="product_units">
                                        <option v-for="product_uni in product_units" :value="product_uni.name+' ('+product_uni.slug+')'">{{product_uni.name}} ({{product_uni.slug}})</option>
                                    </datalist>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Unit Weight: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Single product weight ? E.g 250 mg, 500 kg, 625 mg, 1000 ml etc"></i></small></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="number" required v-model="item_form.single_unit_weight" @change="setNet()" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.single_unit_weight}" placeholder="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Units Per Pack: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Total number of products in each pack ? E.g 14 tablets"></i></small></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="number" required v-model="item_form.units_per_pack" @change="setNet()" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.units_per_pack}" placeholder="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Net Weight:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="number" disabled required v-model="item_form.net_weight" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.net_weight}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                            <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"><i class="fa fa-check-circle"></i> Extra information</h4>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Re-order level: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="The level of inventory at which new stock is ordered. (We'll send you e-mail/SMS alerts when stock level reaches or goes below the Reorder Level)"></i></small></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" required v-model="item_form.alert_indicator_level" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.alert_indicator_level}" placeholder="e.g 2000">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Unit cost:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="number" step="any" v-model="item_form.unit_cost" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.unit_cost}" placeholder="">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Unit retail:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="number" step="any" v-model="item_form.unit_retail_price" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.unit_retail_price}" placeholder="">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Pack cost:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="number" v-model="item_form.pack_cost" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.pack_cost}" placeholder="">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Pack retail:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="number" v-model="item_form.pack_retail_price" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.pack_retail_price}">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Currency:</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <select v-model="item_form.product_currency_id" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':item_form.product_currency_id}">
                                        <option v-for="product_currency in product_currencies" :value="product_currency.id">{{product_currency.slug}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Sales Tax: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Sales Tax/charges Per Unit(%). Sales tax & charges on each product in %"></i></small></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">

                                    <label v-for="taxes_charg in taxes_charges" class="fs-13 width-100-pc mg-bottom-0">
                                        <input type="checkbox" v-model="item_form.tax_per_unit" :value="taxes_charg.id"> {{taxes_charg.name}}@{{taxes_charg.amount}}%
                                    </label>

                                    <div class="add-charge">
                                        <div v-if="add_charge" class="width-100-pc">
                                            <input type="text" v-model="tax_form.name" placeholder="e.g VAT" class="product-entry-input-field fs-13 width-40-pc height-27 float-left">
                                            <input type="number" v-model="tax_form.amount" placeholder="% e.g 0.5" class="product-entry-input-field fs-13 width-30-pc height-27 float-left">
                                            <a @click="save_tax" class="btn btn-inventory height-27 width-20-pc primary float-left">
                                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i></span>
                                                <span v-else><i class="fa fa-save"></i></span>
                                            </a>
                                        </div>
                                        <a v-if="!add_charge" @click="toggleBtn(true)" class="cl-blue-link pointer-cursor fs-14">Create new</a>
                                        <a v-if="add_charge" @click="toggleBtn(false)" class="cl-blue-link pointer-cursor fs-14">Cancel</a>
                                    </div>

                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Unit Location: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Location where you stored this product in store."></i></small></label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" v-model="item_form.unit_storage_location" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':item_form.unit_storage_location}" placeholder="e.g Top right corner">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
            </div>

        </form>

    </div>
    
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "NewProductItemModal",
        components: {},
        data(){
            return {
                product_types: [],
                product_categories: [],
                product_currencies: [],
                product_routes: [],
                product_units: [],
                manufacturers: [],
                products_list: [],
                generics_lists: [],
                taxes_charges: [],
                brands_lists: [],
                brandsector_lists: [],
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
                    unit_retail_price: '',
                    pack_cost: 0,
                    unit_cost: 0,
                    pack_retail_price: 0,
                    product_currency_id: '',
                },
                tax_form: {
                    practice_id: '',
                    name: '',
                    amount: '',
                },
                processing: false,
                item_code_taken: false,
                is_drug: false,
                practice_id: '',
                add_charge: false,
            }
        },
        created(){

        },
        methods: {

            manufacture_added(manufacturer){
                console.info(manufacturer);
                this.item_form.manufacturer = manufacturer.name
            },
            setNet(){
                if (this.item_form.single_unit_weight !== '' && this.item_form.units_per_pack!==''){
                    this.item_form.net_weight = this.item_form.units_per_pack * this.item_form.single_unit_weight;
                }
            },
            save_item(){

                this.processing = true;
                let url_ = AppInfo.app_data.server_domain+'/api/practices/products/items';
                this.item_form.practice_id = this.practice_id;
                post(url_, this.item_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$awn.success(res.data.description);
                            this.$emit("productAdded");
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
            save_tax(){

                this.processing = true;
                let url_ = AppInfo.app_data.server_domain+'/api/practices/products/sales_charge';
                this.item_form.practice_id = this.practice_id;
                post(url_, this.tax_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.add_charge = false;
                            this.loadTaxesCharges();
                            this.tax_form.amount = '';
                            this.tax_form.name = '';
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
            loadCurrency(){
                get(AppInfo.app_data.server_domain+'/api/products/currencies')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.product_currencies = res.data.results
                        }
                    }).catch((err) => {

                });
            },
            loadProductType(){
                get(AppInfo.app_data.server_domain+'/api/products/types')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.product_types = res.data.results;
                            //console.info(this.product_types);
                        }
                    }).catch((err) => {

                });
            },
            loadTaxesCharges(){
                get(AppInfo.app_data.server_domain+'/api/practices/products/sales_charge/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxes_charges = res.data.results;
                        //console.info(this.taxes_charges);
                    }
                }).catch((err) => {

                });
            },
            searchProduct(event, search_type){
                let url_search = AppInfo.app_data.server_domain+'/api/search/'+search_type;
                let formData = new FormData();
                formData.append('name', event.target.value);
                formData.append('practice_id', this.practice_id);
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
                                    if(res.data.results){
                                        this.item_form.item_code = "";
                                    }
                                    break;
                                case "manufacturers":
                                    this.manufacturers = res.data.results;
                                    break;
                                case "brand_sector":
                                    this.brandsector_lists = res.data.results;
                                    break;
                                case "brands":
                                    this.brands_lists = res.data.results;
                                    break;
                                case "drug_categories":
                                    this.product_categories = res.data.results;
                                    if (event.target.value === "Drug") {
                                        //this.loadDrugsData("drug_categories");
                                        this.loadDrugsData("drug_routes");
                                        this.is_drug = true;
                                    }else{
                                        this.is_drug = false;
                                    }
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
            },
            toggleBtn(status_){
                this.add_charge = status_;
            }
        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.tax_form.practice_id = this.practice_id;
            this.loadProductType();
            this.loadTaxesCharges();
            this.loadCurrency();
        }
    }
</script>

<style scoped>

</style>