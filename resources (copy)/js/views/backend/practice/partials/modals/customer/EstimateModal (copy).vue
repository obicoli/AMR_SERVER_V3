<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_estimate" class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">

                    <div class="row bg-eee">

                        <div class="col-lg-12">

                            <div class="row">

                                <div class="col-lg-7 col-md-7 padding-left-0 padding-right-0">

                                    <div class="width-100-pc bg-eee padding-left-20 padding-right-20 padding-top-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-80-pc mg-right-3">
                                                <span class="fs-13 fw-600 width-100-pc">Customer <a @click="show_customer_modal" class="btn-link float-right cl-blue-link">+ New Customer</a></span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="customer"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="customers"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="display_as"
                                                        :getOptionValue="getCustomer"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-40-pc mg-right-3">
                                                <span class="fs-13 fw-600">Billing address:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <div v-html="customer_str" class="div-textaread"></div>
                                                </div>
                                            </div>
                                            <div class="row fullName margin-5 width-40-pc">
                                                <div class="inlineBlock width-100-pc mg-right-3">
                                                    <span class="fs-13 fw-600">Estimate date</span>
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="purchase_form.estimate_date" class="width-100-pc report-filters-inputs" type="date">
                                                    </div>
                                                </div>
                                                <div class="inlineBlock width-100-pc">
                                                    <span class="fs-13 fw-600">Expiration date</span>
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="purchase_form.expiry_date" class="width-100-pc report-filters-inputs" type="date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-md-5">
                                    <div class="label-txt-right mg-top-120 mg-right-30">
                                        <label class="fs-16 fw-600 cl-888">Total Estimate:</label><br>
                                        <label class="fs-30 fw-600 cl-444">{{purchase_form.currency}} {{format_money(purchase_form.total_bill)}}</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                    </div>

                    <div class="row mg-top-20 justify-content-center">

                        <div class="col-lg-12">

                            <div class="row">

                                <div class="col-lg-12">

                                    <div id="inner_invoice_area">

                                        <div class="col-md-12 set-no-padding">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <search-item-field v-on:itemFound="add_search_item_invoice" :show_label="true" :barcode="true" :products="products" :tabulated_view="true" :search_result_width="1200" :field_wdth="400" :field_cover_wdth="450" :search_result_min_height="300"></search-item-field>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="float-right width-100-pc">
                                                        <div class="row fullName margin-5">
                                                            <div class="inlineBlock width-40-pc float-left text-right">
                                                                <span class="fs-13 fw-600">Ref No. &nbsp;&nbsp;</span>
                                                            </div>
                                                            <div class="inlineBlock width-60-pc mg-bottom-5 float-right">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input v-model="purchase_form.ref_number" class="width-100-pc report-filters-inputs" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="receipt-item-table-2 table table-bordered table-hover" role="presentation">
                                                <thead>
                                                    <tr class="bd-top">
                                                        <th style="width:3%" class="no-rb"></th>
                                                        <th style="width:30%">Product/Service</th>
                                                        <th style="width:8%" class="text-right">Qty</th>
                                                        <th style="width:10%" class="text-right">Rate({{purchase_form.currency}})</th>
                                                        <th style="width:10%" class="text-right">Amount({{purchase_form.currency}})</th>
                                                        <th style="width:10%" class="text-right">Discount(%)</th>
                                                        <th style="width:15%" class="text-right">Tax(%)</th>
                                                        <th style="width:12%" class="text-right">Total({{purchase_form.currency}})</th>
                                                        <th style="width:2%" class="no-lb">
                                                            <a @click="remove_all($event)" title="Remove all" class="pointer-cursor fw-600 cl-amref fs-12">x</a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                        <td class="padded">{{index+1}}</td>
                                                        <td class="padded">{{purchase_form.items[index].brand.name}}</td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].qty}">
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].price.pack_retail_price" disabled type="number" @keyup="amend_qty($event,'pack_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].price.pack_retail_price}" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="purchase_form.items[index].amount" disabled @keyup="amend_qty($event,'amount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].amount}" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="purchase_form.items[index].discount_allowed" @keyup="amend_qty($event,'amount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].discount_allowed}" step="any">
                                                        </td>
                                                        <td>
                                                            <select class="form-control height-27">
                                                                <option v-for="(taxation,index_tax) in item.taxes" :key="'taxation_'+index_tax">{{taxation.name}}@{{taxation.sales_rate}}</option>
                                                            </select>
                                                            <!-- <input type="number" v-model="purchase_form.items[index].amount" @keyup="amend_qty($event,'amount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].amount}" step="any"> -->
                                                        </td>
                                                        <td>
                                                            <input type="number" disabled v-model="purchase_form.items[index].sub_stock_total" @keyup="amend_qty($event,'amount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].sub_stock_total}" step="any">
                                                        </td>
                                                        <td class="padded">
                                                            <a title="Remove" @click="amend_qty($event,'remove',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" class="pointer-cursor cl-red">x</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="mg-top-20 float-left width-450-px">
                                                
                                                <div class="row fullName margin-5">
                                                    <div class="inlineBlock width-80-pc float-left mg-right-5">
                                                        <span class="fs-13 fw-600">Customer Notes</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="purchase_form.notes" v-bind:class="{'width-100-pc report-filters-inputs min-height-90':true,'ctm-attended-field':purchase_form.notes}"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-80-pc float-left">
                                                        <span class="fs-13 fw-600">Terms&Conditions</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="purchase_form.terms_condition" v-bind:class="{'width-100-pc report-filters-inputs min-height-90':true,'ctm-attended-field':purchase_form.terms_condition}"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-80-pc float-left">
                                                        <span class="fs-13 fw-600">Attachments</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <input type="file" class="width-100-pc report-filters-inputs">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mg-top-30 padding-right-30 float-right width-450-px">

                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-5 col-md-5 label-txt-right padding-right-0">
                                                        <label class="fw-600 cl-444 fs-16">Subtotal:</label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 label-txt-right padding-right-0">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 label-txt-right padding-right-0">
                                                        <label class="fs-14 fw-600 cl-444">{{purchase_form.currency}}{{format_money(purchase_form.total_grand)}}</label>
                                                    </div>
                                                </div>

                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-5 col-md-5 label-txt-right padding-right-0">
                                                        <label class="fw-600 cl-444 fs-16">Sales Tax:</label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 label-txt-right padding-right-0 padding-left-0">
                                                        <input type="number" v-model="purchase_form.discount_offered" step="any" v-bind:class="{'width-80-pc report-filters-inputs height-27':true,'ctm-attended-field':purchase_form.discount_offered}">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 label-txt-right padding-right-0">
                                                        <label class="fs-14 fw-600 cl-444">{{purchase_form.currency}}{{format_money(purchase_form.discount_offered)}}</label>
                                                    </div>
                                                </div>

                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-5 col-md-5 label-txt-right padding-right-0">
                                                        <label class="fw-600 cl-444 fs-16">Discount:</label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 label-txt-right padding-right-0 padding-left-0">
                                                        <input type="number" v-model="purchase_form.discount_offered" step="any" v-bind:class="{'width-80-pc report-filters-inputs height-27':true,'ctm-attended-field':purchase_form.discount_offered}">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 label-txt-right padding-right-0">
                                                        <label class="fs-14 fw-600 cl-444">{{purchase_form.currency}}{{format_money(purchase_form.discount_offered)}}</label>
                                                    </div>
                                                </div>

                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-5 col-md-5 label-txt-right padding-right-0">
                                                        <label class="fw-600 cl-444 fs-16">Shipping Charges:</label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 label-txt-right padding-right-0 padding-left-0">
                                                        <input type="number" v-model="purchase_form.shipping_charges" step="any" v-bind:class="{'width-80-pc report-filters-inputs height-27':true,'ctm-attended-field':purchase_form.shipping_charges}">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 label-txt-right padding-right-0">
                                                        <label class="fs-14 fw-600 cl-444">{{purchase_form.currency}}{{format_money(purchase_form.shipping_charges)}}</label>
                                                    </div>
                                                </div>

                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-5 col-md-5 label-txt-right padding-right-0">
                                                        <label class="fw-600 cl-444 fs-16">Adjustments:</label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 label-txt-right padding-right-0 padding-left-0">
                                                        <input type="number" step="any" v-model="purchase_form.adjustment_charges" v-bind:class="{'width-80-pc report-filters-inputs height-27':true,'ctm-attended-field':purchase_form.adjustment_charges}">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 label-txt-right padding-right-0">
                                                        <label class="fs-14 fw-600 cl-444">{{purchase_form.currency}}{{format_money(purchase_form.adjustment_charges)}}</label>
                                                    </div>
                                                </div>

                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-9 col-md-9 padding-right-0">
                                                        <label class="check-container small element-inlined fs-12 cl-444">Create a retainer invoice for this estimate automatically
                                                            <input type="checkbox" v-model="purchase_form.retainer_invoice">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 text-right padding-right-0 padding-left-0">
                                                        <input v-if="purchase_form.retainer_invoice" type="number" placeholder="percentage" max="100" min="0" step="any" v-model="purchase_form.retainer_percentage" v-bind:class="{'width-80-pc report-filters-inputs height-27':true,'ctm-attended-field':purchase_form.retainer_percentage}">
                                                    </div>
                                                </div>

                                                <div class="row form-group mg-bottom-10 bg-foo">
                                                    <div class="col-lg-5 col-md-5 label-txt-right padding-right-0">
                                                        <label class="fw-600 cl-444 fs-16">Total Estimate:</label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 label-txt-right padding-right-0">
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 label-txt-right padding-right-10">
                                                        <label class="fs-14 fw-600 cl-444">{{purchase_form.currency}}{{format_money(purchase_form.total_bill)}}</label>
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
                    <div  class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-inventory btn-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span v-if="!processing">Save</span>
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving. Please wait...</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a @click="save_estimate(FORM_ACTIONS.SAVE_SEND)" class="dropdown-item pointer-cursor"> Save & Send</a>
                                <a @click="save_estimate(FORM_ACTIONS.SAVE_CLOSE)" class="dropdown-item pointer-cursor"> Save & Close</a>
                                <a @click="save_estimate(FORM_ACTIONS.SAVE_NEW)" class="dropdown-item pointer-cursor"> Save & New</a>
                                <a @click="save_estimate(FORM_ACTIONS.SAVE_DRAFT)" class="dropdown-item pointer-cursor"> Save As Draft</a>
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
    
</template>

<script>
    import SearchItemField from '../../modals/product/SearchItemField';
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,form_address} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post,postFile} from '../../../../../../helpers/api';
    import {CUSTOMERS_ESTIMATES_API} from "../../../../../../router/api_routes";
    import {ACCOUNTING,FORM_ACTIONS} from "../../../../../../helpers/process_status";
    export default {
        props: ['modal_id','modal_title','initializations','products'],
        components: {SearchItemField},
        data(){
            return {
                customers:[],
                customer: {},
                processing: false,
                //source_store: false,
                //source_vendor: false,
                //is_bank_payment: false,
                customer_str: '',
                purchase_form: {
                    customer_id: '',
                    //practice_bank_id: '',
                    //payment_method_id: '',
                    //payment_method: '',
                    //payment_date: '',
                    //cheque_number: '',
                    estimate_date: '',
                    expiry_date: '',
                    action_taken: '',
                    currency: ACCOUNTING.CURRENCY,
                    retainer_invoice: false,
                    retainer_percentage: 0,
                    notes: 'Looking forward for your business',
                    terms_condition: "This quotation is not a contract or a bill. It is our best guess at the total price for the service and goods described above. The customer will be billed after indicating acceptance of this quote. Payment will be due prior to the delivery of service and goods. Please fax or mail the signed quote to the address listed above",
                    discount_offered: 0,
                    //cash_paid: 0,
                    //cash_balance: 0,
                    //description: '',
                    //bill_no: '',
                    total_bill: 0,
                    total_grand: 0,
                    shipping_charges: 0,
                    adjustment_charges: 0,
                    ref_number: '',
                    status: '',
                    items: []
                },
                INITIAL_URL: CUSTOMERS_ESTIMATES_API,
                FORM_ACTIONS:FORM_ACTIONS
                // stock_form: {
                //     batch_number: ''
                // },
                // hr_roles: [],
                // searched_products_list: [],
            }
        },
        watch: {
            initializations: function(new_in,old_in){
                this.initializations = new_in;
                this.customers = this.initializations.customers;
                if(this.customers.length){
                    this.customer = this.customers[0];
                    this.customer_str = form_address(this.customer);
                }
            }
        },
        methods: {

            save_estimate: function (action_taken) {
                this.processing = true;
                this.purchase_form.action_taken = action_taken;
                post(this.INITIAL_URL,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                //this.$emit('customerAdded');
                                this.processing = false;
                                switch (action_taken) {
                                    case this.FORM_ACTIONS.SAVE_CLOSE:
                                        this.form = reset_forms(this.form);
                                        this.hideModal();
                                        break;
                                    case this.FORM_ACTIONS.SAVE_NEW:
                                        this.form = reset_forms(this.form);
                                        break;
                                    case this.FORM_ACTIONS.SAVE_DRAFT:
                                    case this.FORM_ACTIONS.SAVE_SEND:
                                        this.form = reset_forms(this.form);
                                        this.hideModal();
                                        break;
                                }
                            }else {
                                //this.$emit('customerEdited');
                                this.processing = false;
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

            show_customer_modal(){
                this.$emit('customerForm');
            },

            hideModal(){
                $("#"+this.modal_id).modal('hide');
            },

            remove_all(event){
                 for (let index = 0; index < this.purchase_form.items.length; index++) {
                    this.purchase_form.items[index].qty = 0;
                    this.purchase_form.items[index].discount_allowed = 0;
                    this.purchase_form.items[index].amount = this.purchase_form.items[index].qty * this.purchase_form.items[index].price.pack_retail_price;
                    this.purchase_form.items[index].sub_stock_total = this.purchase_form.items[index].amount;
                 }
                this.purchase_form.items = [];
            },

            getCustomer(){
                this.purchase_form.customer_id = this.customer.id;
                this.customer_str = form_address(this.customer);
            },

            // getType(){

            // },

            format_money(money_to){
                return formatMoney(money_to);
            },

            add_search_item_invoice(items_product){
                //console.info(items_product);
                for (let index = 0; index < items_product.length; index++) {
                    const item_product = items_product[index];
                    this.purchase_form = add_search_item(item_product, this.purchase_form);
                }
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'wholesale');
            },

            // payment_method(event){
            //     for (let index = 0; index < this.initializations.payment_methods.length; index++) {
            //         const element = this.initializations.payment_methods[index];
            //         if(element.id === event.target.value ){
            //             switch(element.name){
            //                 case "Cash":
            //                     this.is_bank_payment = false;
            //                     break;
            //                 case "Cheque":
            //                     this.is_bank_payment = true;
            //                     break;
            //                 default:
            //                     this.is_bank_payment = false;
            //                     break;
            //             }
            //             break;
            //         }
            //     }
            // },
        },
        mounted(){
            this.customers = this.initializations.customers;
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
</style>


