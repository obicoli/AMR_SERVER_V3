<template>

    <div class="modal fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg-custom-90 modal-dialog-centered zoomInUp flipOutX">
            <!-- --------------------------------------------------- -->
                <div class="modal-content">

                    <form @submit.prevent="save_item">

                        <div  class="modal-header">
                            <h4>{{modal_title}}</h4>
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
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" :disabled="prog_form.processing" required v-model="item_form.item_name" list="product_list" v-bind:class="{'attended_field':item_form.item_name,'width-95-pc float-left':true}" placeholder="Start typing to select e.g Panadol">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_product"></i>
                                                <datalist id="product_list">
                                                    <option v-for="(product_list,index) in products_list" :value="product_list.name" :key="'prod_name_key_'+index">{{product_list.name}}</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row form-group mg-bottom-10">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Generic Name:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" :disabled="prog_form.processing" required v-model="item_form.generic_name" list="generics_list" v-bind:class="{'float-left width-95-pc':true,'attended_field':item_form.generic_name}" placeholder="e.g Paracetmol">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_generic"></i>
                                                <datalist id="generics_list">
                                                    <option v-for="(generic_item, index) in generics_lists" :value="generic_item.name" :key="'generic_name_'+index">{{generic_item.name}}</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row form-group mg-bottom-15">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Item Code:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" :disabled="prog_form.processing" required v-model="item_form.item_code" v-bind:class="{'float-left width-95-pc':true,'attended_field':item_form.item_code}" placeholder="e.g 0UY543">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_code"></i>
                                                <small v-if="item_code_taken" class="cl-red">Item code already in use</small>
                                            </div>
                                        </div>

                                        <div class="row form-group mg-bottom-15">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Barcode:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" v-model="item_form.barcode" v-bind:class="{'width-95-pc':true,'attended_field':item_form.barcode}" placeholder="e.g 4008500115237">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_barcode"></i>
                                                <small v-if="item_barcode_taken" class="cl-red">Item barcode already in use</small>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Manufacturer:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" :disabled="prog_form.processing" required v-model="item_form.manufacturer" list="manufacturer_list" v-bind:class="{'width-95-pc':true,'attended_field':item_form.manufacturer}" placeholder="e.g GSK">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_manufacturer"></i>
                                                <datalist id="manufacturer_list">
                                                    <option v-for="(manufactu, index) in manufacturers" :value="manufactu.name" :key="'manufactu_'+index">{{manufactu.name}}</option>
                                                </datalist>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Profile name:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <select :disabled="prog_form.processing" required v-model="item_form.item_type" @change="searchProduct($event,'drug_categories')" v-bind:class="{'width-95-pc':true,'attended_field':item_form.item_type}">
                                                    <option value="" selected disabled>-select-</option>
                                                    <option v-for="(product_typ, index) in product_types" :value="product_typ.name" :key="'prod_type_key'+index">{{product_typ.name}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group mg-bottom-15">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Image:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="file" :disabled="prog_form.processing" class="form-control product-entry-input-field width-95-pc">
                                                <small>Product scan or captured image ? </small>
                                            </div>
                                        </div>
                                        <div class="row form-group mg-bottom-15">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Note:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <textarea v-model="item_form.item_note" :disabled="prog_form.processing" required style="min-height: 70px!important;" v-bind:class="{'form-control product-entry-input-field width-95-pc':true,'attended_field':item_form.item_note}" rows="5"></textarea>
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
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" :disabled="prog_form.processing" required v-model="item_form.brand_name" list="brands_list" v-bind:class="{'width-95-pc':true,'attended_field':item_form.brand_name}" placeholder="Start typing to select e.g Priton syrup">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_brand"></i>
                                                <datalist id="brands_list">
                                                    <option v-for="(brands_lis,index) in brands_lists" :value="brands_lis.name" :key="'brands_lis'+index">{{brands_lis.name}}</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Brand Sector:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" :disabled="prog_form.processing" required v-model="item_form.brand_sector" list="brandsector_list" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.brand_sector}" placeholder="Start typing to select">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_sector"></i>
                                                <datalist id="brandsector_list">
                                                    <option v-for="(brands_liss,index) in brandsector_lists" :value="brands_liss.name" :key="'brands_liss'+index">{{brands_liss.name}}</option>
                                                </datalist>
            <!--                                    <select class="form-control bg-white height-36 border-radius-2 border-ccc" style="width: 100%;"></select>-->
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Item Category:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" required v-model="item_form.item_category" :disabled="prog_form.processing" list="category_list" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.item_category}" placeholder="Start typing to select">
                                                <datalist id="category_list">
                                                    <option v-for="(product_categorie, index) in product_categories" :value="product_categorie.name" :key="'product_categorie'+index">{{product_categorie.name}}</option>
                                                </datalist>
                                            </div>
                                        </div>

                                        <!-- <div v-if="user_mode==='Create' && is_drug" class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Drug Route:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" required v-model="item_form.product_routes_name" :disabled="prog_form.processing" list="routes_list" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.product_routes_name}" placeholder="">
                                                <datalist id="routes_list">
                                                    <option v-for="(product_rout, index) in product_routes" :value="product_rout.name" :key="'product_route_'+index">{{product_rout.name}}</option>
                                                </datalist>
                                            </div>
                                        </div>

                                        <div v-if="user_mode==='Edit' && form_data.product_type==='Drug'" class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Drug Route:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" required v-model="item_form.product_routes_name" :disabled="prog_form.processing" list="routes_list" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.product_routes_name}" placeholder="">
                                                <datalist id="routes_list">
                                                    <option v-for="(product_rout, index) in product_routes" :value="product_rout.name" :key="'product_route_'+index">{{product_rout.name}}</option>
                                                </datalist>
                                            </div>
                                        </div> -->

                                        <h4 class="purchase-heading cl-grey fw-600 fs-16 padding-left-0"><i class="fa fa-check-circle"></i> Unit and Weights:</h4>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit Type: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Product weight measurement? e.g Kg, Gm, Ml etc. NOTE: Make sure this is the same as the unit in which you dispense this item."></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <input type="text" @keydown="searchProduct($event,'units')" required v-model="item_form.unit_measure" list="product_units" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.unit_measure}" :disabled="prog_form.processing" placeholder="e.g Ml, Kg">
                                                <datalist id="product_units">
                                                    <option v-for="product_uni in product_units" :value="product_uni.name+' ('+product_uni.slug+')'">{{product_uni.name}} ({{product_uni.slug}})</option>
                                                </datalist> -->
                                                <select :disabled="prog_form.processing" required v-model="item_form.unit_measure" v-bind:class="{'width-95-pc':true,'attended_field':item_form.unit_measure}">
                                                    <option value="" disabled>-select-</option>
                                                    <option v-for="(product_uni, index) in product_units" :value="product_uni.id" :selected="item_form.unit_measure === product_uni.slug" :key="'product_uni'+index">{{product_uni.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit Weight: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Single product weight ? E.g 250 mg, 500 kg, 625 mg, 1000 ml etc"></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="prog_form.processing" required v-model="item_form.single_unit_weight" @change="setNet()" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.single_unit_weight}" placeholder="e.g 20g">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Units Per Pack: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Total number of products in each pack ? E.g 14 tablets"></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="prog_form.processing" required v-model="item_form.units_per_pack" @change="setNet()" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.units_per_pack}" placeholder="e.g 12">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Net Weight:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" disabled required v-model="item_form.net_weight" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.net_weight}">
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
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="prog_form.processing" required v-model="item_form.alert_indicator_level" v-bind:class="{'width-95-pc':true,'attended_field':item_form.alert_indicator_level}" placeholder="e.g 2000">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit cost:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="prog_form.processing" step="any" v-model="item_form.unit_cost" required v-bind:class="{'width-95-pc':true,'attended_field':item_form.unit_cost}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit retail:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" step="any" v-model="item_form.unit_retail_price" :disabled="prog_form.processing" required v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.unit_retail_price}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Pack cost:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" v-model="item_form.pack_cost" :disabled="prog_form.processing" required v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.pack_cost}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Pack retail:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" v-model="item_form.pack_retail_price" required v-bind:class="{'width-95-pc':true,'attended_field':item_form.pack_retail_price}">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Currency:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <select v-model="item_form.product_currency_id" v-bind:class="{'width-95-pc':true,'attended_field':item_form.product_currency_id}" :disabled="prog_form.processing">
                                                    <option v-for="(product_currency,index) in product_currencies" :value="product_currency.id" :key="'product_currency_'+index">{{product_currency.slug}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Tax inclusive: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Sales Tax/charges Per Unit(%). Sales tax & charges on each product in %"></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8">

                                                <label v-for="(taxes_charg,index) in taxes_charges" class="fs-13 width-100-pc mg-bottom-0" :key="'taxes_charg'+index">
                                                    <input type="checkbox" v-model="item_form.tax_per_unit" :value="taxes_charg.id"> {{taxes_charg.name}}@{{taxes_charg.amount}}%
                                                </label>

                                                <div class="add-charge">
                                                    <div v-if="add_charge" class="width-100-pc">
                                                        <input type="text" v-model="tax_form.name" placeholder="e.g VAT" class="product-entry-input-field fs-13 width-40-pc height-27 float-left">
                                                        <input type="number" v-model="tax_form.amount" placeholder="% e.g 0.5" class="product-entry-input-field fs-13 width-30-pc height-27 float-left">
                                                        <a @click="save_tax" class="btn btn-inventory height-27 width-20-pc primary float-left">
                                                            <span v-if="prog_form.processing"><i class="fa fa-spinner fa-spin"></i></span>
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
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" v-model="item_form.unit_storage_location" v-bind:class="{'width-95-pc float-left':true,'attended_field':item_form.unit_storage_location}" placeholder="e.g Top right corner">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-inventory primary">
                                <span v-if="prog_form.processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> saving...</span>
                                <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                            </button>
                            <button @click="refresh_product_form" data-dismiss="modal" class="btn btn-inventory">
                                <i class="fa fa-close" aria-hidden="true"></i> Close
                            </button>
                        </div>

                    </form>

                </div>
            <!-- --------------------------------------------------- -->
        </div>
    </div>
    
</template>

<script>

    import {get,post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import AppInfo from "../../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../../helpers/functionmixin";

    export default {
        name: "ProductModal",
        props: ['modal_id',
            'item_url','user_mode','form_data','initialization'], //ProductModal
        components: {},
        data(){
            return {
                initialUrl: '',
                modal_title: 'New Product Item:',
                product_types: [],
                product_categories: [],
                product_currencies: [],
                initializations: {},
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
                prog_form: {
                    processing: false,
                    spin_product: false,
                    spin_generic: false,
                    spin_code: false,
                    spin_barcode: false,
                    spin_manufacturer: false,
                    spin_brand: false,
                    spin_sector: false,
                },
                item_code_taken: false,
                item_barcode_taken: false,
                is_drug: false,
                practice_id: '',
                add_charge: false,
                form_disabler: false,
            }
        },
        watch: {
            initializations: function(initialization_new, old_tax){
                this.initializations = initialization_new;
            }
        },
        methods: {
            refresh_product_form(action_to){

                if(action_to === "reset"){
                    //tax form refresh
                    this.tax_form.name = "";
                    this.tax_form.amount = "";
                    //item form refresh
                    this.item_form.barcode = "";
                    this.item_form.item_name = "";
                    this.item_form.generic_name = "";
                    this.item_form.item_code = "";
                    this.item_form.manufacturer = "";
                    this.item_form.item_type = "";
                    this.item_form.item_category = "";
                    this.item_form.item_note = "";
                    this.item_form.brand_name = "";
                    this.item_form.brand_sector = "";
                    this.item_form.unit_measure = "";
                    this.item_form.single_unit_weight = "";
                    this.item_form.units_per_pack = "";
                    this.item_form.net_weight = "";
                    this.item_form.alert_indicator_level = "";
                    this.item_form.unit_cost = "";
                    this.item_form.unit_retail_price = "";
                    this.item_form.pack_cost = "";
                    this.item_form.pack_retail_price = "";
                    this.item_form.product_currency_id = "";
                    this.item_form.unit_storage_location = "";
                }else{
                    //tax form refresh
                    this.tax_form.name = "";
                    this.tax_form.amount = "";
                    //item form refresh
                    this.item_form.barcode = this.form_data.barcode;
                    this.item_form.item_name = this.form_data.item_name;
                    this.item_form.generic_name = this.form_data.generic_name;
                    this.item_form.item_code = this.form_data.item_code;
                    this.item_form.manufacturer = this.form_data.manufacturer;
                    this.item_form.item_type = this.form_data.product_type;
                    this.item_form.item_category = this.form_data.product_category;
                    this.item_form.item_note = this.form_data.item_note;
                    this.item_form.brand_name = this.form_data.product_brand;
                    this.item_form.brand_sector = this.form_data.brand_sector;
                    this.item_form.unit_measure = this.form_data.product_unit;
                    this.item_form.single_unit_weight = this.form_data.single_unit_weight;
                    this.item_form.units_per_pack = this.form_data.units_per_pack;
                    this.item_form.net_weight = this.form_data.net_weight;
                    this.item_form.alert_indicator_level = this.form_data.alert_indicator_level;
                    this.item_form.unit_cost = this.form_data.unit_cost;
                    this.item_form.unit_retail_price = this.form_data.unit_retail_price;
                    this.item_form.pack_cost = this.form_data.pack_cost;
                    this.item_form.pack_retail_price = this.form_data.pack_retail_price;
                    this.item_form.product_currency_id = this.form_data.item_currency;
                    this.item_form.unit_storage_location = this.form_data.unit_storage_location;
                    this.item_form.product_routes_name = this.form_data.product_route;
                }

            },
            manufacture_added(manufacturer){
                this.item_form.manufacturer = manufacturer.name
            },
            setNet(){
                if (this.item_form.single_unit_weight !== '' && this.item_form.units_per_pack!==''){
                    this.item_form.net_weight = this.item_form.units_per_pack * this.item_form.single_unit_weight;
                }
            },
            save_item(){
                this.prog_form.processing = true;
                let url_ = AppInfo.app_data.server_domain+this.initialUrl;
                this.item_form.practice_id = this.practice_id;
                post(url_, this.item_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.prog_form.processing = false;
                        this.$awn.success(res.data.description);
                        this.refresh_product_form("reset");
                        this.$emit("productAdded");
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.prog_form.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.prog_form.processing = false;
                });
            },
            save_tax(){
                this.prog_form.processing = true;
                let url_ = AppInfo.app_data.server_domain+'/api/practices/products/sales_charge';
                this.item_form.practice_id = this.practice_id;
                post(url_, this.tax_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.prog_form.processing = false;
                        this.add_charge = false;
                        //this.loadTaxesCharges();
                        this.$emit('taxAdded');
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
                        this.prog_form.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.prog_form.processing = false;
                });
            },
            toggleSpiners(search_type,show_hide){
                switch (search_type) {
                    case "products": //product name
                        
                        break;
                    case "product_name":
                        this.prog_form.spin_product = show_hide;
                        break;
                    case "generics":
                        this.prog_form.spin_generic = show_hide;
                        break;
                    case "item_code":
                        this.prog_form.spin_code = show_hide;
                        break;
                    case "manufacturers":
                        this.prog_form.spin_manufacturer = show_hide;
                        break;
                    case "brand_sector":
                        this.prog_form.spin_sector = show_hide;
                        break;
                    case "brands":
                        this.prog_form.spin_brand = show_hide;
                        break;
                    case "drug_categories":
                        
                        break;
                    case "units":
                        
                        break;
                    case "barcode":
                        this.prog_form.spin_barcode = show_hide;
                        break;
                }
            },
            searchProduct(event, search_type){
                //this.toggleSpiners(search_type, true);
                let url_search = AppInfo.app_data.server_domain+'/api/search/'+search_type;
                let formData = new FormData();
                formData.append('name', event.target.value);
                formData.append('practice_id', this.practice_id);
                post(url_search, formData)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        switch (search_type) {
                            case "products": //product name
                                this.products_list = res.data.results;
                                console.info(this.products_list);
                                break;
                            case "product_name":
                                this.products_list = res.data.results;
                                console.info(this.products_list);
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
                                //this.product_categories = res.data.results;
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
                            case "barcode":
                                this.item_barcode_taken = res.data.results;
                                if(res.data.results){
                                    this.item_form.barcode = "";
                                }
                                break;
                        }
                        //this.toggleSpiners(search_type, false);
                    }
                }).catch((err) => {
                    //this.toggleSpiners(search_type, true);
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
            },
        },
        mounted(){

            this.initialUrl = this.item_url;
            this.initializations = this.initialization;
            this.brandsector_lists = this.initializations.brand_sector;
            this.brands_lists = this.initializations.brands;
            this.product_categories = this.initializations.product_category;
            this.product_units = this.initializations.units;
            this.taxes_charges = this.initializations.taxes;
            this.product_currencies = this.initializations.currency;
            this.product_types = this.initializations.product_types;
            this.manufacturers = this.initializations.manufacturers;
            this.generics_lists = this.initializations.generics;
            this.products_list = this.initializations.products;
            this.practice_id = Auth.getCurrentAccount('id');
            this.tax_form.practice_id = this.practice_id;
            if( this.user_mode === "Edit" ){
                this.refresh_product_form("populate");
                //console.info(this.form_data);
                this.modal_title = "Edit Product Item"
            }

        }
    }
</script>

<style>
    .modal{
        z-index: 9999!important;
    }
    .dijitDialogTitle[data-v-71f246f8] {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select{
        outline: none!important;
        height: 32px;
        border: 1px solid #BABEC5;
        padding: 0 8px!important;
        border-radius: 2px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }
</style>

