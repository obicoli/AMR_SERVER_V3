<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_po" class="modal-content">

                <div class="modal-header bg-eee text-left">
                    <h4 class="width-100-pc text-left">{{modal_title}}</h4>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">
                    <div class="row bg-eee justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 padding-left-0 padding-right-0">
                                    <div class="width-100-pc padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600 width-100-pc">Vendor</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="selected_vendor"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="suppliers"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="legal_name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-100-pc">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <div v-html="supplier_str" class="div-textaread"></div>
                                                    <!-- <textarea v-model="purchase_form.supplier_emails" v-bind:class="{'width-100-pc min-height-60':true}" placeholder="or enter Email (Separate emails with a comma)"></textarea> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-9 padding-left-0">
                                    <div class="width-30-pc float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">Deliver to:&nbsp;&nbsp;<input v-model="purchase_form.ship_to" class="pointer-cursor" type="radio" :value="SHIP_TO_OPTIONS.ORGANIZATION"> <small class="fw-400 fs-13">Facility</small>&nbsp;&nbsp;<input v-model="purchase_form.ship_to" type="radio" class="pointer-cursor" :value="SHIP_TO_OPTIONS.CUSTOMER"> <small class="fw-400 fs-13">Customer</small></span>
                                                <div v-if="purchase_form.ship_to===SHIP_TO_OPTIONS.ORGANIZATION" class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder="Select a facility"
                                                        you-want-to-select-a-post="ok"
                                                        v-model="facility"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="facilities"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                                <div v-if="purchase_form.ship_to===SHIP_TO_OPTIONS.CUSTOMER" class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder="Select a customer"
                                                        you-want-to-select-a-post="ok"
                                                        v-model="customer"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="customers"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="display_as"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-100-pc">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <div v-html="facility_str" class="div-textaread"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="width-30-pc padding-top-10 padding-bottom-10 float-left">
                                        <div class="row fullName mg-right-5 mg-left-5 mg-top-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">PO Date:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <datetime 
                                                        v-model="purchase_form.po_date"
                                                        :input-id="'date_input_'"
                                                        placeholder="select date"
                                                        use12-hour
                                                        :type="'date'"
                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                        :value="purchase_form.po_date"
                                                        >
                                                    </datetime>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fullName mg-right-5 mg-left-5 mg-top-5">
                                            <div class="inlineBlock width-100-pc">
                                                <span class="fs-13 fw-600 width-100-pc">PO Number:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input v-model="purchase_form.trans_number" class="width-100-pc report-filters-inputs" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-30-pc padding-top-10 padding-bottom-10 float-left">
                                        <div class="row fullName mg-right-5 mg-left-5 mg-top-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">PO Due Date:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <datetime 
                                                        v-model="purchase_form.po_due_date"
                                                        :input-id="'date_input_'"
                                                        placeholder="select date"
                                                        use12-hour
                                                        :type="'date'"
                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                        :value="purchase_form.po_due_date"
                                                        >
                                                    </datetime>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fullName mg-right-5 mg-left-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">Shipment Preference:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <select v-model="purchase_form.shipment_preference" class="width-100-pc report-filters-inputs">
                                                        <option value="" disabled selected>-select-</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mg-top-20 justify-content-center">
                        
                        <!-- <div class="col-lg-12 col-md-12">
                            <div class="po-separator bg-red">
                                <span class="fw-600 fs-12 txt-uppercase">Create PO items:</span>(<small>Create PO for your vendor.</small>)
                            </div>
                        </div> -->

                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="inner_invoice_area">

                                        <div class="col-md-6 col-lg-6 set-no-padding">
                                            <search-item-field @item-event="add_search_item_invoice(product_items)" :product_items="product_items" :show_label="true" :barcode="true" :products="products" :tabulated_view="true" :search_result_width="1130" :field_wdth="400" :field_cover_wdth="450" :search_result_min_height="300"></search-item-field>
                                        </div>

                                        <div class="col-md-6 col-lg-6 set-no-padding">
                                            <div class="float-right width-300-px">
                                                <div class="row fullName">
                                                    <div class="inlineBlock padding-top-25">
                                                        <span class="fs-13 fw-600">Amounts are: &nbsp;&nbsp;</span>
                                                    </div>
                                                    <div class="inlineBlock width-70-pc mg-bottom-5 mg-right-3 padding-top-25">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <!-- <input v-model="purchase_form.taxation_option"  list="tax_list" type="text" placeholder="Choose tax option"> -->
                                                            <select @change="reset_tax($event)" v-model="purchase_form.taxation_option" class="width-100-pc report-filters-inputs" >
                                                                <option value="Exclusive of Tax">Exclusive of Tax</option>
                                                                <option value="Inclusive of Tax">Inclusive of Tax</option>
                                                                <option value="Out of scope of Tax">Out of scope of Tax</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 set-no-padding">
                                            
                                            <table class="receipt-item-table-2 table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 52%;">Item Details</th>
                                                        <th style="width: 10%;" class="text-right">Quantity</th>
                                                        <th style="width: 10%;" class="text-right">Rate</th>
                                                        <th style="width: 15%;" class="text-right">Tax</th>
                                                        <th style="width: 10%;" class="text-right">Amount</th>
                                                        <th style="width: 3%;"><a class="fs-14 cl-amref pointer-cursor">+</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                        <td class="padded">{{purchase_form.items[index].brand.name}}</td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].qty}">
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].price.pack_cost" disabled type="number" @keyup="amend_qty($event,'pack_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].price.pack_retail_price}" step="any">
                                                        </td>
                                                        <td>
                                                            <div class="btn-group width-100-pc" role="group" aria-label="Button group with nested dropdown">
                                                                <div class="btn-group" role="group">
                                                                    <button :disabled="purchase_form.taxation_option===null || purchase_form.taxation_option==='Out of scope of Tax' || purchase_form.taxation_option==='Exclusive of Tax'" :id="'btnGroupDrop'+index" type="button" class="dropdown-toggle btn btn-secondary btn-input" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span v-if="purchase_form.items[index].applied_tax_rates.length">{{purchase_form.items[index].applied_tax_rates.length}} tax applied</span>
                                                                        <span v-else>Select tax</span>
                                                                    </button>
                                                                    <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop'+index">
                                                                        <a v-for="(taxation,t_index) in taxations" class="dropdown-item" :key="'taxations_'+t_index"><input v-model="purchase_form.items[index].applied_tax_rates" :value="taxation.id" @change="amend_qty($event,'taxation',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" class="pointer-cursor" type="checkbox"> {{taxation.display_as}} </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="purchase_form.items[index].line_total" disabled @keyup="amend_qty($event,'amount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].line_total}" step="any">
                                                        </td>
                                                        <td class="padded">
                                                            <a title="Remove" @click="amend_qty($event,'remove',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" class="pointer-cursor cl-red">x</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="width-400-px mg-top-10 float-left">
                                                <div class="row fullName margin-5">
                                                    
                                                    <div class="inlineBlock width-100-pc">
                                                        <span class="fs-13 fw-600">Terms & Conditions</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="purchase_form.terms" v-bind:class="{'width-100-pc report-filters-inputs min-height-90':true,'ctm-attended-field':purchase_form.terms}" placeholder="Enter the terms and conditions of your business to be displayed in your transaction"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="inlineBlock width-100-pc">
                                                        <span class="fs-13 fw-600">Notes</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="purchase_form.notes" v-bind:class="{'width-100-pc report-filters-inputs min-height-90':true,'ctm-attended-field':purchase_form.notes}" placeholder="Will be displayed on purchase order"></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="width-300-px mg-top-10 padding-right-30 float-right">
                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                                        <label class="fs-20 fw-600 cl-444">Subtotal: {{format_money(purchase_form.total_bill)}}</label>
                                                    </div>
                                                </div>
                                                <div v-if="purchase_form.taxation_option===TAX_OPTIONS.INCLUSIVE" class="row form-group mg-bottom-10">
                                                    <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                                        <label class="fs-20 fw-600 cl-444">Tax: {{format_money(purchase_form.total_tax)}}</label>
                                                    </div>
                                                </div>
                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                                        <label class="fs-20 fw-600 cl-444">Total: {{format_money(purchase_form.total_grand)}}</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div v-if="user_mode==='Create'" class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button :disabled="processing" id="btnGroupDrop" type="button" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> {{purchase_form.action_taken}}</span>
                                </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a @click="save_po(FORM_ACTIONS.SAVE_DRAFT)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_DRAFT}}</a>
                                <a @click="save_po(FORM_ACTIONS.SAVE_SEND)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_SEND}}</a>
                                <a @click="save_po(FORM_ACTIONS.SAVE_NEW)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_NEW}}</a>
                                <a @click="save_po(FORM_ACTIONS.SAVE_CLOSE)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_CLOSE}}</a>
                            </div>
                        </div>
                    </div>
                    <button v-else type="button" @click="save_po(FORM_ACTIONS.SAVE_CLOSE)" class="btn btn-secondary banking-process-amref">
                        <span v-if="processing">Saving...</span>
                        <span v-else>Save Changes</span>
                    </button>
                    <button :disabled="processing" data-dismiss="modal" class="btn btn-secondary banking-process">
                        Close
                    </button>
                </div>

            </form>
        </div>

    </div>
    
</template>

<script>
    import SearchItemField from '../../modals/product/SearchItemField';
    import SupplierModal from '../../modals/vendors/SupplierModal';
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,form_address, format_lunox_date,create_mail_content} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {SUPPLIER_PO_URL} from '../../../../../../router/api_routes';
    import {SHIP_TO,FORM_ACTIONS,TAX_OPTIONS, TRANSACTION_TYPES} from "../../../../../../helpers/process_status";
    import Auth from '../../../../../../store/auth';
    export default {
        props: ['modal_id','user_mode','taxations','currency','supplier_po_api','form_data','modal_title','supplier','filters','facilities','customers','suppliers','organ_data'],
        components: {SearchItemField,SupplierModal},
        data(){
            return {
                current_branch: {},
                processing: false,
                SHIP_TO_OPTIONS: SHIP_TO,
                FORM_ACTIONS: FORM_ACTIONS,
                TAX_OPTIONS:TAX_OPTIONS,
                products: [],
                purchase_form: {
                    action_taken: 'Save',
                    ship_to: 'Organization',
                    facility_id: null,
                    customer_id: null,
                    supplier_id: null,
                    shipment_preference: null,
                    taxation_option: null,
                    currency: null,
                    //
                    po_date: null,
                    po_due_date: null,
                    terms: null,
                    trans_number: null,
                    notes: "Please ship as soon as possible for repeat business. Thank you!",
                    items: [],
                    //
                    discount_offered: 0,
                    cash_paid: 0,
                    cash_balance: 0,
                    //
                    total_bill: 0,
                    total_grand: 0,
                    total_tax: 0,
                },
                searched_products_list: [],
                supplier_str: '',
                facility_str: '',
                selected_vendor: null,
                facility: null,
                customer: null,
                product_items: [],
            }
        },

        watch:{
            selected_vendor: function(){
                if(this.selected_vendor){
                    this.purchase_form.terms = this.selected_vendor.payment_term.notes;
                    this.purchase_form.supplier_id = this.selected_vendor.id;
                }
            },
            form_data: function(new_data,old_data){
                this.initializePO(new_data);
            },
            supplier_po_api: function(new_data,old_data){
                this.supplier_po_api = new_data;
            }
        },

        methods: {

            requestVendorForm(){
                this.$emit('requestVendorForm');
            },

            getSuppl(){
                if(this.selected_vendor){
                    this.supplier_str = form_address(this.selected_vendor);
                    this.purchase_form.terms = this.selected_vendor.supplier_term.notes;
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            initializePO(new_po){
                //this.purchase_form = new_po;
                this.selected_vendor = new_po.vendor;
                this.purchase_form.items = [];
                for (let index = 0; index < new_po.items.length; index++) {
                    const element = new_po.items[index];
                    this.purchase_form.items.push(element);
                }
                this.purchase_form.taxation_option = new_po.taxation_option;
                //this.selected_supplier = new_po.vendor;
                this.purchase_form.total_grand = new_po.total_grand;
                this.purchase_form.total_bill = new_po.total_bill;
                this.purchase_form.trans_number = new_po.trans_number;
                this.facility = new_po.shipping;
                this.purchase_form.po_date = format_lunox_date(new_po.po_date);
                this.purchase_form.po_due_date = format_lunox_date(new_po.po_due_date);
                this.purchase_form.terms = new_po.vendor.payment_term.notes;
            },
            save_po(action_taken){
                this.processing = true;
                this.purchase_form.action_taken = action_taken;

                if(this.facility){ this.purchase_form.facility_id = this.facility.id; }
                if(this.selected_vendor){ this.purchase_form.supplier_id = this.selected_vendor.id; }
                if(this.customer){ this.purchase_form.customer_id = this.customer.id; }
                this.purchase_form.currency = this.currency;

                post(this.supplier_po_api,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            let new_po = res.data.results;
                            if(this.user_mode==='Create'){
                                if(action_taken===FORM_ACTIONS.SAVE_SEND){
                                    let mail_content = create_mail_content(TRANSACTION_TYPES.PURCHASE_ORDER,new_po,this.currency);
                                    let api_ = SUPPLIER_PO_URL+'/'+new_po.id+'?action='+FORM_ACTIONS.SEND_MAIL;
                                    this.send_mail(api_,mail_content);
                                }else{
                                    this.$emit('po-create-event',new_po);
                                    this.$awn.success(res.data.description);
                                }
                                //
                            }else{
                                this.$emit('po-edit-event');
                                $('#'+this.modal_id+'').modal('hide');
                                this.$awn.success(res.data.description);
                            }
                            
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

            send_mail(mail_api,form){
                this.processing = true;
                post(mail_api,form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.processing = false;
                            //this.$emit('po-create-event',new_po);
                            this.$emit('po-create-event');
                            $('#'+this.modal_id).modal('hide');
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },

            add_search_item_invoice(product_items){
                //console.info(product_items)
                for (let index = 0; index < product_items.length; index++) {
                    let item_product = product_items[index];
                    this.purchase_form = add_search_item(item_product, this.purchase_form);
                }
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){

                //this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase');
                
                if(type_ === 'taxation'){
                    if(event.target.checked){
                        //Push into array
                        //this.purchase_form.items[index].applied_tax_rates.push(event.target.value);
                        //alert(this.purchase_form.items[index].applied_tax_rates.length);
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                    }else{
                        //Remove from array
                        //this.purchase_form.items[index].applied_tax_rates = removeElement(this.purchase_form.items[index].applied_tax_rates,event.target.value)
                        //alert(this.purchase_form.items[index].applied_tax_rates.length);
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                    }
                }else{
                    this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                }
                
            },

            reset_tax(event){
                this.purchase_form = amend_totals(event,'taxation_option',0,0,0,0,this.purchase_form,'purchase',this.taxations);
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){
            if( this.supplier ){
                this.selected_vendor = this.supplier;
                this.getSuppl();
            }
            if(this.user_mode==="Create"){
                this.purchase_form.po_date = format_lunox_date(this.filters.today);
                this.purchase_form.po_due_date = format_lunox_date(this.filters.today);
            }else{
                console.info(this.form_data);
                //this.purchase_form = this.form_data;
                this.initializePO(this.form_data);
            }
        }
        
    }
</script>

<style lang="scss" scoped>
    // @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 1200px!important;
        min-width: 1000px!important;
    }
    .modal-header h4 {
        font-size: 20px!important;
    }
</style>


