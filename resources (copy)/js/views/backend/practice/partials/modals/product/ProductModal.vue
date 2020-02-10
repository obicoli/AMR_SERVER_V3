<template>

    <div class="modal fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-lg-custom modal-dialog-centered zoomInUp flipOutX">
            <!-- --------------------------------------------------- -->
                <div class="modal-content">

                    <form @submit.prevent="save_item">

                        <div  class="modal-header">
                            <h4>{{title}}</h4>
                            <!-- <button data-dismiss="modal"><i class="fa fa-close"></i> </a> -->
                        </div>

                        <div  class="modal-body padding-top-0">

                            <div class="row">

                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                                        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Inventory Item</h4>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Item Name:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <div class="width-95-pc float-left padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.item_name"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.item_names"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                                <!-- <input type="text" :disabled="prog_form.processing" required v-model="item_form.item_name" list="product_list" v-bind:class="{'ctm-attended-field':item_form.item_name,'width-95-pc float-left':true}" placeholder="Start typing to select e.g Panadol">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_product"></i>
                                                <datalist id="product_list">
                                                    <option v-for="(product_list,index) in products_attributes.item_names" :value="product_list.name" :key="'prod_name_key_'+index">{{product_list.name}}</option>
                                                </datalist> -->
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Generic Name:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">

                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.generic"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.generics"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                                <!-- <input type="text" :disabled="prog_form.processing" required v-model="item_form.generic_name" list="generics_list" v-bind:class="{'float-left width-95-pc':true,'ctm-attended-field':item_form.generic_name}" placeholder="e.g Paracetmol">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_generic"></i>
                                                <datalist id="generics_list">
                                                    <option v-for="(generic_item, index) in products_attributes.generics" :value="generic_item.name" :key="'generic_name_'+index">{{generic_item.name}}</option>
                                                </datalist> -->

                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Item Code:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" :disabled="processing" required v-model="item_form.sku_code" v-bind:class="{'float-left width-95-pc':true,'ctm-attended-field':item_form.sku_code}" placeholder="e.g 0UY543">
                                                <!-- <small v-if="item_code_taken" class="cl-red">Item code already in use</small> -->
                                            </div>
                                        </div>

                                        <!-- <div class="row form-group mg-bottom-15">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Barcode:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" v-model="item_form.barcode" v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.barcode}" placeholder="e.g 4008500115237">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_barcode"></i>
                                                <small v-if="item_barcode_taken" class="cl-red">Item barcode already in use</small>
                                            </div>
                                        </div> -->

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Manufacturer:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <input type="text" :disabled="prog_form.processing" required v-model="item_form.manufacturer" list="manufacturer_list" v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.manufacturer}" placeholder="e.g GSK">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_manufacturer"></i>
                                                <datalist id="manufacturer_list">
                                                    <option v-for="(manufactu, index) in products_attributes.manufacturers" :value="manufactu.name" :key="'manufactu_'+index">{{manufactu.name}}</option>
                                                </datalist> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.manufacturer"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.manufacturers"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- <div class="row form-group mg-bottom-15">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Image:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="file" :disabled="prog_form.processing" class="form-control product-entry-input-field width-95-pc">
                                                <small>Product scan or captured image ? </small>
                                            </div>
                                        </div> -->

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Re-order level: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="The level of inventory at which new stock is ordered. (We'll send you e-mail/SMS alerts when stock level reaches or goes below the Reorder Level)"></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="processing" required v-model="item_form.alert_indicator_level" v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.alert_indicator_level}" placeholder="e.g 2000">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Tax inclusive: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Sales Tax/charges Per Unit(%). Sales tax & charges on each product in %"></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8">

                                                <label v-for="(taxes_charg,index) in products_attributes.taxes" class="fs-13 width-100-pc mg-top-5" :key="'taxes_charg_'+index">
                                                    <input type="checkbox" v-model="item_form.taxes" :value="taxes_charg" > {{taxes_charg.name}}@{{taxes_charg.sales_rate}}%
                                                </label>

                                                <div class="add-charge">
                                                    <!-- <div v-if="add_charge" class="width-100-pc">
                                                        <input type="text" v-model="tax_form.name" placeholder="e.g VAT" class="product-entry-input-field fs-13 width-40-pc height-27 float-left">
                                                        <input type="number" v-model="tax_form.amount" placeholder="% e.g 0.5" class="product-entry-input-field fs-13 width-30-pc height-27 float-left">
                                                        <a @click="save_tax" class="btn btn-inventory height-27 width-20-pc primary float-left">
                                                            <span v-if="prog_form.tax_prog"><i class="fa fa-spinner fa-spin"></i></span>
                                                            <span v-else><i class="fa fa-save"></i></span>
                                                        </a>
                                                    </div> -->
                                                    <a class="cl-blue-link pointer-cursor fs-14">+add new</a>
                                                    <!-- <a v-if="add_charge" @click="toggleBtn(false)" class="cl-blue-link pointer-cursor fs-14">Cancel</a> -->
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Instruction:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <textarea v-model="item_form.note" :disabled="processing" required style="min-height: 50px!important;" v-bind:class="{'form-control product-entry-input-field width-95-pc':true,'ctm-attended-field':item_form.note}" rows="5"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit Location: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Location where you stored this product in store."></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="text" v-model="item_form.store_location" v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.store_location}" placeholder="e.g Top right corner">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- ==================================Grouping Starts================== -->
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border-top-0 border-bottom-0 border-radius-0">
                                        <h4 class="purchase-heading"> <i class="fa fa-check-circle"></i> Grouping</h4>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Brand:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <input type="text" :disabled="prog_form.processing" required v-model="item_form.brand_name" list="brands_list" v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.brand_name}" placeholder="Start typing to select e.g Priton syrup">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_brand"></i>
                                                <datalist id="brands_list">
                                                    <option v-for="(brands_lis,index) in products_attributes.brands" :value="brands_lis.name" :key="'brands_lis'+index">{{brands_lis.name}}</option>
                                                </datalist> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.brand"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.brands"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Brand Sector:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <input type="text" :disabled="prog_form.processing" required v-model="item_form.brand_sector" list="brandsector_list" v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.brand_sector}" placeholder="Start typing to select">
                                                <i class="fa fa-spinner fa-spin fs-12 cl-grey float-right width-4-pc mg-top-5" v-if="prog_form.spin_sector"></i>
                                                <datalist id="brandsector_list">
                                                    <option v-for="(brands_liss,index) in products_attributes.brand_sectors" :value="brands_liss.name" :key="'brands_liss'+index">{{brands_liss.name}}</option>
                                                </datalist> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.brand_sector"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.brand_sectors"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Profile name:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <select :disabled="prog_form.processing" required v-model="item_form.item_type" v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.item_type}">
                                                    <option value="" selected disabled>-select-</option>
                                                    <option v-for="(product_typ, index) in products_attributes.profile_names" :value="product_typ.name" :key="'prod_type_key'+index">{{product_typ.name}}</option>
                                                </select> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.profile"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.profile_names"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Item Type:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <select :disabled="prog_form.processing" required v-model="item_form.item_type" v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.item_type}">
                                                    <option value="" selected disabled>-select-</option>
                                                    <option v-for="(product_typ, index) in products_attributes.profile_names" :value="product_typ.name" :key="'prod_type_key'+index">{{product_typ.name}}</option>
                                                </select> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.item_type"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.item_types"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Item Category:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <input type="text" required v-model="item_form.item_category" :disabled="prog_form.processing" list="category_list" v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.item_category}" placeholder="Start typing to select">
                                                <datalist id="category_list">
                                                    <option v-for="(product_categorie, index) in products_attributes.categories" :value="product_categorie.name" :key="'product_categorie'+index">{{product_categorie.name}}</option>
                                                </datalist> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.category"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.categories"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Order Category:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <input type="text" required v-model="item_form.item_category" :disabled="prog_form.processing" list="category_list" v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.item_category}" placeholder="Start typing to select">
                                                <datalist id="category_list">
                                                    <option v-for="(product_categorie, index) in products_attributes.categories" :value="product_categorie.name" :key="'product_categorie'+index">{{product_categorie.name}}</option>
                                                </datalist> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.order_category"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.order_categories"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Sub Category:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <!-- <input type="text" required v-model="item_form.item_category" :disabled="prog_form.processing" list="category_list" v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.item_category}" placeholder="Start typing to select">
                                                <datalist id="category_list">
                                                    <option v-for="(product_categorie, index) in products_attributes.categories" :value="product_categorie.name" :key="'product_categorie'+index">{{product_categorie.name}}</option>
                                                </datalist> -->
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.sub_category"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.sub_categories"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Route:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.route"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.routes"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Formulation:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.formulation"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.formulations"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Preferred/Supplier:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.supplier"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.suppliers"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <!-- ==================================Grouping Ends================== -->

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="bg-white border-top-0 border-bottom-0 border-radius-0">

                                        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Unit and Weights:</h4>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">U.O.M: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Product weight measurement? e.g Kg, Gm, Ml etc. NOTE: Make sure this is the same as the unit in which you dispense this item."></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.measure_unit"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="products_attributes.units"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit Weight: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Single product weight ? E.g 250 mg, 500 kg, 625 mg, 1000 ml etc"></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="processing" required v-model="item_form.single_unit_weight" v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.single_unit_weight}" placeholder="e.g 20g">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Units Per Pack: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="Total number of products in each pack ? E.g 14 tablets"></i></small></label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="processing" required v-model="item_form.units_per_pack" v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.units_per_pack}" placeholder="e.g 12">
                                            </div>
                                        </div>

                                        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Pricing</h4>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit cost:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" :disabled="processing" step="any" v-model="item_form.price.unit_cost" required v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.price.unit_cost}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Unit sales/rate:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" step="any" v-model="item_form.price.unit_retail_price" :disabled="processing" required v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.price.unit_retail_price}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Pack cost:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" v-model="item_form.price.pack_cost" :disabled="processing" required v-bind:class="{'width-95-pc float-left':true,'ctm-attended-field':item_form.price.pack_cost}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Pack sales/rate:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" v-model="item_form.price.pack_retail_price" required v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.price.pack_retail_price}">
                                            </div>
                                        </div>

                                        <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> Extra information</h4>
                                        <div class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Opening Stock:</label>
                                            </div>
                                            <div v-if="item_form.opening_stock === 0" class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <input type="number" v-model="item_form.initial_stock" required v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.initial_stock}">
                                            </div>
                                            <div v-else class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <label class="fs-16 fw-600 cl-444">{{format_money(item_form.opening_stock)}}</label><br>
                                                Adjust: <a class="fs-12 cl-blue-link fw-600">Quantity</a> | <a class="fs-12 cl-blue-link fw-600">Opening Stock</a>
                                            </div>
                                        </div>
                                        <div v-if="item_form.initial_stock" class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">Inventory/Account:</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="item_form.inventory"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="inventories"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                                <!-- <input type="number" v-model="item_form.initial_stock" required v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.initial_stock}"> -->
                                            </div>
                                        </div>
                                        <div v-if="item_form.initial_stock" class="row form-group">
                                            <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                <label class="fs-14 cl-888">As of</label>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-8 dijitTextBox">
                                                <div class="width-95-pc float-left mg-bottom-1 padding-bottom-0">
                                                    <input type="date" v-model="item_form.as_of" required v-bind:class="{'width-100-pc':true,'ctm-attended-field':item_form.as_of}">
                                                </div>
                                                <!-- <input type="number" v-model="item_form.initial_stock" required v-bind:class="{'width-95-pc':true,'ctm-attended-field':item_form.initial_stock}"> -->
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="modal-footer">
                            <button type="submit" class="btn combo-button primary">
                                <span v-if="prog_form.processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> saving...</span>
                                <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                            </button>
                            <button @click="refresh_product_form" data-dismiss="modal" class="btn btn-inventory">
                                <i class="fa fa-close" aria-hidden="true"></i> Close
                            </button>
                        </div> -->
                        <div class="modal-footer">
                            <div :disabled="processing"  class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-inventory btn-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span v-if="!processing">Save</span>
                                        <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                        <a @click="save_item(FORM_ACTIONS.SAVE_NEW)" class="dropdown-item pointer-cursor"> Save & New</a>
                                        <a @click="save_item(FORM_ACTIONS.SAVE_CLOSE)" class="dropdown-item pointer-cursor"> Save & Close</a>
                                    </div>
                                </div>
                            </div>
                            <button :disabled="processing" data-dismiss="modal" class="btn btn-inventory">
                                Close
                            </button>
                        </div>

                    </form>
                </div>
        </div>
    </div>
    
</template>

<script>

    import {get,post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import AppInfo from "../../../../../../helpers/config";
    import {createHtmlErrorString,reset_forms,formatMoney} from "../../../../../../helpers/functionmixin";
    import {PRODUCT_TAX_URL,PRODUCT_ITEM_URL} from "../../../../../../router/api_routes";
    import {FORM_ACTIONS} from "../../../../../../helpers/process_status"

    export default {
        name: "ProductModal",
        props: ['modal_id','user_mode','initialUrl',
            'form_data', 'products_attributes',
            'title','inventories'
        ],
        data(){
            return {
                FORM_ACTIONS:FORM_ACTIONS,
                processing: false,
                item_form: {
                    id: null,
                    generic: null,
                    manufacturer: null,
                    brand:null,
                    brand_sector: null,
                    category: null,
                    profile: null,
                    order_category: null,
                    sub_category: null,
                    formulation: null,
                    supplier: null,
                    item_name: null,
                    note: null,
                    manufacturer: null,
                    item_code: null,
                    item_type: null,
                    sku: null,
                    barcode: null,
                    item_note: null,
                    note: null,
                    measure_unit: null,
                    single_unit_weight: null,
                    alert_indicator_level: null,
                    units_per_pack: null,
                    taxes: [],
                    unit_storage_location: null,
                    practice_id: null,
                    route: null,
                    price: {
                        id: null,
                        unit_cost: null,
                        pack_cost: null,
                        unit_retail_price: null,
                        pack_retail_price: null,
                    },
                    opening_stock: null,
                    as_of: null,
                    inventory: null,
                    expense: null,
                },
            }
        },

        watch: {
            products_attributes: function(new_attr, old_attr){
                this.products_attributes = new_attr;
            },
            form_data: function(new_form_data, old_form_data){
                this.item_form = new_form_data;
            }
        },

        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            save_item(action_taken){
                this.processing = true;
                post(this.initialUrl, this.item_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success(res.data.description);
                        //let new_item = res.data.results;
                        if(this.user_mode === "Edit"){
                            //this.item_form = new_item;
                            this.$emit("editedSuccessful");
                        }else{
                            this.$emit("createdSuccessful");
                        }
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },
        },
        mounted(){
            if( this.user_mode === "Edit" ){
                this.item_form = this.form_data;
                // this.item_form.initial_stock = this.form_data.opening_stock;
                // this.modal_title = "Edit Product Item"
            }
        }
    }
</script>

<style>
    .modal{
        z-index: 9999!important;
    }
    .form-group {
        margin-bottom: 4px!important;
    }
    .dijitDialogTitle[data-v-71f246f8] {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
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

    .search-input {
        font-size: 12px!important;
    }
</style>

