<template>

    <div v-if="loded" class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_retainer_invoice()" class="modal-content">

                <div class="modal-header bg-eee text-left">
                    <h4 class="width-100-pc text-left"><img src="/assets/icons/dashboard/bill_icon.png"> {{modal_title}}</h4>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0 bg-f4">
                    
                    <div class="row mg-top-20 justify-content-center">

                        <div class="col-lg-12 col-md-12">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div id="inner_invoice_area">

                                        <div class="col-md-12 set-no-padding">

                                            <div class="width-100-pc float-left fs-12 bg-f4 padding-20">
                                                <div class="width-30-pc float-left fs-12">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc text-right">
                                                            <label class="fullname fw-600 fs-14 text-right">Customer Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-20-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Customer:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-80-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="selected_customer"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="customers_list"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="legal_name"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-20-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Balance:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-80-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(selected_debtor.balance)" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">VAT Reference:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="selected_debtor.tax_reg_number" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Credit Limit:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(selected_debtor.credit_limit)" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="width-30-pc float-left mg-left-30">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc text-right">
                                                            <label class="fullname fw-600 fs-14 text-right">Retainer Invoice Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Number#:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.trans_number" disabled type="text" :class="{'custom-attended-field':purchase_form.trans_number}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30 mg-top-5">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Reference:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled v-model="purchase_form.reference_number" :class="{'custom-attended-field':purchase_form.reference_number}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Date:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <datetime 
                                                                    v-model="purchase_form.trans_date"
                                                                    :input-id="'date_input_'"
                                                                    placeholder="select date"
                                                                    use12-hour
                                                                    :type="'date'"
                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                    :value="purchase_form.trans_date"
                                                                    >
                                                                </datetime>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="width-35-pc float-right fs-12">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Notes:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <textarea v-model="purchase_form.notes" v-bind:class="{'width-100-pc report-filters-inputs min-height-60':true}"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Terms & Condition:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <textarea v-model="purchase_form.terms_condition" v-bind:class="{'width-100-pc report-filters-inputs min-height-60':true}"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="width-100-pc float-left fs-12 bg-f4 padding-10">
                                                
                                                <div class="width-100-pc float-left padding-20 border-radius-4 bg-white doc-holder">
                                                    <table class="table itemized x-panel">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 44%;">Description</th>
                                                                <th style="width: 14%;" class="">Amount</th>
                                                                <th style="width: 13%;" class="text-right">Exclusive</th>
                                                                <th style="width: 13%;" class="text-right">VAT</th>
                                                                <th style="width: 13%;" class="text-right">Total</th>
                                                                <th style="width: 4%;" class="text-right"><a class="pointer-cursor">x</a></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                                <td class="inp"><input required v-model="purchase_form.items[index].description" type="text" v-bind:class="{'form-control height-27 text-left':true}"></td>
                                                                <td class="inp"><input required v-model="purchase_form.items[index].amount" type="number" min="1" @keyup="amend_qty($event,'amount',index)" v-bind:class="{'form-control height-27':true}"></td>
                                                                <td class="padded text-right fw-600">{{format_money(purchase_form.items[index].line_exclusive)}}</td>
                                                                <td class="padded text-right">{{currency+' '+format_money(purchase_form.items[index].line_taxation)}}</td>
                                                                <td class="padded text-right fw-600">{{format_money(purchase_form.items[index].line_total)}}</td>
                                                                <td class="padded text-center">
                                                                    <a title="Remove" @click="amend_qty($event,'remove',index)" class="pointer-cursor cl-red">x</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <a @click="addItem()" class="fs-12 fw-600 cl-blue-link">+ Add a Line</a>
                                                </div>
                                            </div>

                                            <div class="width-100-pc float-left fs-12 bg-f4 padding-20 mg-bottom-20">
                                                
                                                <div class="width-30-pc float-right fs-12 bg-f4 summary-total padding-10 mg-bottom-20">
                                                    <div class="row fullName mg-bottom-5">
                                                        <div class="inlineBlock width-50-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Sub-total:&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-45-pc text-right">
                                                            <label class="company-label text-right fs-12 txt-capitalize width-100-pc fw-600">{{currency+' '+format_money(purchase_form.sub_total)}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5">
                                                        <div class="inlineBlock width-50-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">VAT:&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-45-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc txt-capitalize fw-600">{{currency+' '+format_money(purchase_form.total_tax)}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5">
                                                        <div class="inlineBlock width-50-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Total:&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-45-pc">
                                                            <label class="company-label text-right fs-12 width-100-pc txt-capitalize fw-600">{{currency+' '+format_money(purchase_form.net_total)}}</label>
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
                </div>

                <div class="modal-footer">
                    <!-- <button :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref">
                        Save
                    </button> -->
                    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-secondary banking-process-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> {{purchase_form.action_taken}}</span>
                                </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a @click="save_retainer_invoice(FORM_ACTIONS.SAVE_DRAFT)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_DRAFT}}</a>
                                <a @click="save_retainer_invoice(FORM_ACTIONS.SAVE_OPEN)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_OPEN}}</a>
                                <a @click="save_retainer_invoice(FORM_ACTIONS.SAVE_NEW)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_NEW}}</a>
                                <a @click="save_retainer_invoice(FORM_ACTIONS.SAVE_CLOSE)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_CLOSE}}</a>
                            </div>
                        </div>
                    </div>
                    <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process">
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
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,form_address,format_lunox_date, removeIndex} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {SUPPLIER_PO_URL, CUSTOMERS_ESTIMATES_API,CUSTOMERS_SALES_ORDERS_API} from '../../../../../../router/api_routes';
    import {SHIP_TO,FORM_ACTIONS,TAX_OPTIONS,PAYMENT_OPTIONS,TRANSACTION_TYPES} from "../../../../../../helpers/process_status";
    import Auth from '../../../../../../store/auth';
    export default {
        name: "RetainerInvoiceModal",
        props: ['modal_id','modal_title','customer_retainer_invoice_api','bank_accounts','taxations','estimate','salesorder','customer','customers','salespersons','currency','filters','payment_terms'],
        components: {SearchItemField,SupplierModal},
        data(){
            return {
                //current_branch: {},
                processing: false,
                loded: false,
                //SHIP_TO_OPTIONS: SHIP_TO,
                FORM_ACTIONS: FORM_ACTIONS,
                TAX_OPTIONS:TAX_OPTIONS,
                PAYMENT_OPTIONS: PAYMENT_OPTIONS,
                products: [],

                selected_debtor:{
                    balance: 0,
                    credit_limit: 0,
                    tax_reg_number: null,
                },

                purchase_form: {
                    action_taken: 'Save',
                    order_number: null,
                    credit_number: null,
                    supplier_id: null,
                    taxation_option: null,
                    trans_date: null,
                    due_date: null,
                    reference_number: null,
                    overal_discount: false,
                    overal_discount_rate: '',
                    customer_id: null,
                    payment_term_id: null,
                    salesperson_id: null,
                    estimate_id: null,
                    sales_order_id: null,
                    extracted_from: '',
                    terms: '',
                    notes: 'Looking forward for your business',
                    terms_condition: "This estimate is not a contract or a bill. It is our best guess at the total price for the service and goods described above. The customer will be billed after indicating acceptance of this estimate. Payment will be due prior to the delivery of service and goods. Please fax or mail the signed estimate to the address listed above",
                    ledger_account_id: null,
                    supplier_invoice_number: null,
                    items: [],
                    total_discount: 0,
                    cash_paid: 0,
                    cash_balance: 0,
                    grand_total: 0,
                    net_total: 0,
                    total_tax: 0,
                    sub_total: 0,
                    billed_type: null,
                    currency: null,
                    sales_basis: 'Cash',
                    payment: {
                        payment_method: '',
                        cheque_number: null,
                        cash_paid: 0,
                        bank_account_id: null,
                        ledger_account_id: null,
                        cash_balance: 0,
                    }
                },
                product_items: [],
                salesperson: null,
                detailed_estimate: null,
                detailed_salesorder: null,
                selected_customer: null,
                payment_term:null,
                selected_estimate: null,
                selected_salesorder: null,
                bank_account: null,
                estimates_list: [],
                salesorders_list: [],
                customers_list: [],
                DOC_QUOTE: TRANSACTION_TYPES.QUOTATION,
                DOC_SALES_ORDER: TRANSACTION_TYPES.SALES_ORDER,
                extractors: false,
            }
        },
        watch: {
            selected_customer: function(){
                //this.setForm();
                if(this.selected_customer && this.estimate){
                    this.setForm();
                }else if(this.selected_customer){
                    this.setForm();
                    this.loadEstimates();
                }
            },
            estimate: function(new_data,old_data){
                this.selected_estimate = new_data;
                if(this.selected_estimate){
                    //this.setForm();
                    this.loadEst(this.selected_estimate.id);
                }
            },
            salesorder: function(new_data,old_data){
                this.selected_salesorder = new_data;
                if(this.selected_salesorder){
                    this.loadSo(this.selected_salesorder.id);
                }
            }
        },
        methods: {

            reset_tax(event){
                if(event.target.value !== TAX_OPTIONS.INCLUSIVE){
                    for (let index = 0; index < this.purchase_form.items.length; index++) {
                        this.purchase_form.items[index].applied_tax_rates = [];
                    }
                }
                //this.purchase_form = amend_totals(event,'taxation_option',0,0,0,0,this.purchase_form,'wholesale',this.taxations);
            },

            setForm(){

                if(this.customer){
                    this.customers_list = [];
                    this.selected_customer = this.customer;
                    this.customers_list.push(this.customer);
                }else{
                    this.customers_list = this.customers;
                }
                if(this.filters){
                    this.purchase_form.trans_date = format_lunox_date(this.filters.today);
                    this.purchase_form.due_date = format_lunox_date(this.filters.today);
                }
                if(this.selected_customer){
                    this.selected_debtor.balance = this.selected_customer.balance;
                    this.selected_debtor.tax_reg_number = this.selected_customer.tax_reg_number;
                    this.selected_debtor.credit_limit = this.selected_customer.credit_limit;
                }
                //
                if(this.selected_estimate){
                    this.estimates_list = [];
                    this.estimates_list.push(this.selected_estimate);
                    //this.selected_estimate = this.estimate;
                    //
                    this.customers_list = [];
                    this.selected_customer = this.selected_estimate.customer;
                    this.customers_list.push(this.selected_estimate.customer);
                    //
                    this.purchase_form.reference_number = this.selected_estimate.trans_number;

                    this.purchase_form.taxation_option = this.selected_estimate.taxation_option;
                    //this.purchase_form.items = this.selected_estimate.items;
                    //console.info(this.selected_estimate.items);
                    //this.loadEst(this.selected_estimate.id);
                    if(this.detailed_estimate){
                        this.purchase_form.items = this.detailed_estimate.items;
                    }
                    // this.purchase_form.total_tax = this.selected_estimate.total_tax;
                    // this.purchase_form.total_discount = this.selected_estimate.total_discount;
                    // this.purchase_form.grand_total = this.selected_estimate.grand_total-this.selected_estimate.total_tax;
                    // this.purchase_form.net_total = this.selected_estimate.net_total;
                    this.purchase_form.sub_total = this.selected_estimate.grand_total - this.selected_estimate.total_tax - this.selected_estimate.total_discount
                    this.purchase_form.total_tax = this.selected_estimate.total_tax;
                    this.purchase_form.overal_discount = this.selected_estimate.overal_discount;
                    this.purchase_form.overal_discount_rate = this.selected_estimate.overal_discount_rate;
                    this.purchase_form.total_discount = this.selected_estimate.total_discount;
                    this.purchase_form.grand_total = this.selected_estimate.grand_total-this.selected_estimate.total_tax;
                    this.purchase_form.net_total = this.selected_estimate.net_total;
                    this.purchase_form.extracted_from = this.DOC_QUOTE;
                    this.extractors = true;
                    this.purchase_form.estimate_id = this.selected_estimate.id;
                    this.purchase_form.payment.cash_paid = this.purchase_form.net_total;
                }

                if(this.selected_salesorder){

                    this.salesorders_list = [];
                    this.salesorders_list.push(this.selected_salesorder);

                    this.customers_list = [];
                    this.selected_customer = this.selected_salesorder.customer;
                    this.customers_list.push(this.selected_salesorder.customer);

                    this.purchase_form.reference_number = this.selected_salesorder.trans_number;
                    this.purchase_form.taxation_option = this.selected_salesorder.taxation_option;
                    if(this.detailed_salesorder){
                        this.purchase_form.items = this.detailed_salesorder.items;
                    }

                    // this.purchase_form.sub_total = this.selected_salesorder.grand_total - this.selected_salesorder.total_tax - this.selected_salesorder.total_discount
                    // this.purchase_form.total_tax = this.selected_salesorder.total_tax;
                    // this.purchase_form.overal_discount = this.selected_salesorder.overal_discount;
                    // this.purchase_form.overal_discount_rate = this.selected_salesorder.overal_discount_rate;
                    // this.purchase_form.total_discount = this.selected_salesorder.total_discount;
                    // this.purchase_form.grand_total = this.selected_salesorder.grand_total-this.selected_salesorder.total_tax;

                    // this.purchase_form.extracted_from = this.DOC_SALES_ORDER;
                    // this.extractors = true;
                    // this.purchase_form.sales_order_id = this.selected_salesorder.id;
                    // this.purchase_form.payment.cash_paid = this.selected_salesorder.net_total;
                    this.purchase_form.sub_total = this.selected_salesorder.grand_total - this.selected_salesorder.total_tax - this.selected_salesorder.total_discount
                    this.purchase_form.total_tax = this.selected_salesorder.total_tax;
                    this.purchase_form.overal_discount = this.selected_salesorder.overal_discount;
                    this.purchase_form.overal_discount_rate = this.selected_salesorder.overal_discount_rate;
                    this.purchase_form.total_discount = this.selected_salesorder.total_discount;
                    this.purchase_form.grand_total = this.selected_salesorder.grand_total-this.selected_salesorder.total_tax;
                    this.purchase_form.net_total = this.selected_salesorder.net_total;
                    this.purchase_form.extracted_from = this.DOC_SALES_ORDER;
                    this.extractors = true;
                    this.purchase_form.estimate_id = this.selected_salesorder.id;
                    this.purchase_form.payment.cash_paid = this.purchase_form.net_total;
                }
                this.loded = true;
            },

            overalDisc(event,type_){
                if(type_==="checkbox"){
                    if(event.target.checked){
                        this.purchase_form.overal_discount = true;
                    }else{
                        this.purchase_form.overal_discount = false;
                    }
                    this.purchase_form = amend_totals(event,'overall_discount',0,0,0,0,this.purchase_form,'wholesale',this.taxations);
                }else{
                    this.purchase_form = amend_totals(event,'overall_discount',0,0,0,0,this.purchase_form,'wholesale',this.taxations);
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            save_retainer_invoice(action_taken){
                this.processing = true;
                this.purchase_form.action_taken = action_taken;
                this.purchase_form.currency = this.currency;
                if(this.selected_estimate){ this.purchase_form.estimate_id = this.selected_estimate.id; }
                //if(this.selected_salesorder){ this.purchase_form.sales_order_id = this.selected_salesorder.id; }
                //if(this.payment_term){ this.purchase_form.payment_term_id = this.payment_term.id; }
                //if(this.inventory){ this.purchase_form.ledger_account_id = this.inventory.id; }
                if(this.selected_customer){ this.purchase_form.customer_id = this.selected_customer.id;}
                //if(this.salesperson){ this.purchase_form.salesperson_id = this.salesperson.id }
                //if(this.bank_account){ this.purchase_form.payment.bank_account_id = this.bank_account.id }
                post(this.customer_retainer_invoice_api,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            //this.purchase_form = reset_forms(this.purchase_form);
                            this.$emit('create-retainer-event');
                            this.$awn.success(res.data.description);
                            switch(action_taken){
                                case FORM_ACTIONS.SAVE_NEW:
                                    break;
                                default:
                                    $('#'+this.modal_id).modal('hide');
                                    break;
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

            loadEstimates(show_progress=false){
                get(CUSTOMERS_ESTIMATES_API+'?customer_id='+this.selected_customer.id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.estimates_list = [];
                        this.estimates_list = res.data.results.data;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                });
            },

            loadEst(est_id){
                //alert(est_id);
                get(CUSTOMERS_ESTIMATES_API+'/'+est_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.detailed_estimate = res.data.results;
                        //console.info(this.detailed_estimate.items);
                        this.setForm();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                });
            },

            loadSo(so_id){
                //alert(est_id);
                get(CUSTOMERS_SALES_ORDERS_API+'/'+so_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.detailed_salesorder = res.data.results;
                        this.setForm();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                });
            },

            add_search_item_invoice(product_items){
                //console.info(product_items);
                for (let index = 0; index < product_items.length; index++) {
                    const item_product = product_items[index];
                    this.purchase_form = add_search_item(item_product, this.purchase_form);
                }
            },


            // amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
            //     //this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase');
            //     if(type_ === 'taxation'){
            //         if(event.target.checked){
            //             //Push into array
            //             this.purchase_form.items[index].applied_tax_rates = [];
            //             this.purchase_form.items[index].applied_tax_rates.push(event.target.value);
            //             //this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'wholesale',this.taxations);
            //         }else{
            //             //Remove from array
            //             //this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'wholesale',this.taxations);
            //         }
            //     }else{
            //         //this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'wholesale',this.taxations);
            //     }
            // },

            amend_qty(event,type_,global_index){
                this.purchase_form.net_total = 0;
                this.purchase_form.sub_total = 0;
                this.purchase_form.grand_total = 0;
                this.purchase_form.total_tax = 0;
                switch(type_){
                    case "amount":

                        break;
                    case "remove":
                        this.purchase_form.items = removeElement(this.purchase_form.items, this.purchase_form.items[global_index]);//removeIndex(this.purchase_form.items,global_index);
                        break;
                };
                //
                let nt = 0;
                let st = 0;
                let gt = 0;
                for (let index = 0; index < this.purchase_form.items.length; index++) {
                    const element = this.purchase_form.items[index];
                    nt += parseInt(parseFloat(element.amount));
                    st += parseInt(parseFloat(element.amount));
                    gt += parseInt(parseFloat(element.amount));
                }
                this.purchase_form.net_total =  nt;
                this.purchase_form.sub_total = st;
                this.purchase_form.grand_total = gt;
            },

            addItem(){
                let item = {
                    description: "",
                    amount: 0,
                    applied_tax_rates: [],
                    line_exclusive: 0,
                    line_taxation: 0,
                    line_total: 0,
                }
                this.purchase_form.items.push(item);
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){
            this.addItem();
            if(this.estimate){
                this.loadEst(this.estimate.id);
                this.selected_estimate = this.estimate;
            }
            if(this.salesorder){
                this.loadSo(this.salesorder.id);
                this.selected_salesorder = this.salesorder;
            }
            this.setForm();
        }
        
    }
</script>

<style lang="scss" scoped>
    // @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 1100px!important;
        min-width: 1000px!important;
    }
    .modal-header h4 {
        font-size: 20px!important;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select, .vdatetime-input{
        outline: none!important;
        height: 27px!important;
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 5px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 12px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }
</style>


