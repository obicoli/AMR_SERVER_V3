<template>
    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_invoice" class="modal-content">

                <div class="modal-header bg-eee text-left">
                    <h4 class="width-100-pc text-left"><img src="/assets/icons/dashboard/bill_icon.png"> {{modal_title}}</h4>
                </div>

                <div class="modal-body bg-eee padding-top-0 padding-bottom-0">
                    
                    <div class="row mg-top-20 justify-content-center">

                        <div class="col-lg-12 col-md-12 padding-left-0 padding-right-0">

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
                                                            <label class="fullname fw-600 fs-14 text-right">Payment Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Document No.&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.trans_number" disabled type="text" class="custom-attended-field">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Date:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-70-pc">
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
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Payment Mode:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <select v-model="purchase_form.payment.payment_method">
                                                                    <option value="">-select-</option>
                                                                    <option v-for="(item,key) in PAYMENT_OPTIONS" :value="item" :key="'PAYMENT_OPTIONS'+key">{{item}}</option>
                                                                    <!-- <option :value="PAYMENT_OPTIONS.CHEQUE">{{PAYMENT_OPTIONS.CHEQUE}}</option>
                                                                    <option :value="PAYMENT_OPTIONS.CHEQUE">{{PAYMENT_OPTIONS.CHEQUE}}</option> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-if="purchase_form.payment.payment_method===PAYMENT_OPTIONS.CHEQUE" class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc mg-bottom-5">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder="Bank account deposited to."
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="bank_account"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="bank_accounts"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="account_name"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Cheque No:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.payment.cheque_number" required type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="purchase_form.payment.payment_method===PAYMENT_OPTIONS.CASH" class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc mg-bottom-5">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder="Account deposited to"
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="account"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="accounts"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="name"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Ref No:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.payment.reference_number" required type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else></div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30 mg-top-5">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Amount Received:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input @keyup="amend_qty($event,'invoice_cash_paid')" v-model="purchase_form.payment.cash_paid" required v-bind:class="{'height-32':true}" step="any" type="number">
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
                                                            <label class="company-label text-right fs-12 width-100-pc">Comment:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <textarea v-model="purchase_form.comment" v-bind:class="{'width-100-pc report-filters-inputs min-height-60':true}"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div v-if="unpaid_invoices.length>0 && is_initializing===false" class="width-100-pc float-left fs-12 bg-f4 padding-10 mg-bottom-20">
                                                <div class="width-100-pc float-left">
                                                    <label class="fw-600 fs-14">Unpaid Invoices({{unpaid_invoices.length}})</label>
                                                </div>
                                                <div class="width-100-pc float-left padding-20 border-radius-4 bg-white doc-holder">
                                                    <table class="table itemized x-panel">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%;">Allocate</th>
                                                                <th style="width: 15%;">Document No.</th>
                                                                <th style="width: 15%;">Due Date</th>
                                                                <th style="width: 15%;" class="text-right">Total</th>
                                                                <th style="width: 15%;" class="text-right">Amount Due</th>
                                                                <th style="width: 15%;" class="text-right">Amount Paid</th>
                                                                <th style="width: 15%;" class="text-right">Discount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(unpaid_invoic, index) in unpaid_invoices" :key="'item_key_'+index">
                                                                <td class="padded">
                                                                    <input v-model="purchase_form.paid_invoices" :disabled="processing" @click="allocateInvoice($event,unpaid_invoic.due_balance)" type="checkbox" :value="unpaid_invoic.id" :id="'bill_cash_paid_'+index" class="pointer-cursor">
                                                                </td>
                                                                <td class="padded">{{unpaid_invoic.trans_number}}</td>
                                                                <td class="padded">
                                                                    <span class="documentStatus overdue" v-if="unpaid_invoic.is_overdue">{{unpaid_invoic.is_overdue}}</span>
                                                                    <span v-else>{{unpaid_invoic.due_date}}</span>
                                                                </td>
                                                                <td class="padded text-right fw-600">{{currency+' '+format_money(unpaid_invoic.net_total)}}</td>
                                                                <td class="padded text-right fw-600">{{currency}}{{format_money(unpaid_invoic.due_balance)}}</td>
                                                                <td class="padded text-right fw-600">{{currency+' '+format_money(unpaid_invoic.cash_paid)}}</td>
                                                                <td class="padded text-right fw-600">{{currency+' '+format_money(unpaid_invoic.total_discount)}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div v-if="is_initializing" class="width-100-pc float-left fs-12 bg-f4 padding-10 text-center">
                                                <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                            </div>
                                            <div class="width-30-pc float-right fs-12 bg-f4 summary-total padding-10 mg-bottom-20">
                                                <div class="row fullName mg-bottom-5">
                                                    <div class="inlineBlock width-50-pc text-right">
                                                        <label class="company-label text-right fs-12 width-100-pc">Amount Received:&nbsp;</label>
                                                    </div>
                                                    <div class="inlineBlock width-45-pc text-right">
                                                        <label class="company-label text-right fs-12 txt-capitalize width-100-pc fw-600">{{currency+' '+format_money(purchase_form.payment.cash_paid)}}</label>
                                                    </div>
                                                </div>
                                                <div class="row fullName mg-bottom-5">
                                                    <div class="inlineBlock width-50-pc text-right">
                                                        <label class="company-label text-right fs-12 width-100-pc">Amount used for payments:&nbsp;</label>
                                                    </div>
                                                    <div class="inlineBlock width-45-pc text-right">
                                                        <label class="company-label text-right fs-12 width-100-pc txt-capitalize fw-600">{{currency+' '+format_money(purchase_form.payment.cash_used)}}</label>
                                                    </div>
                                                </div>
                                                <div class="row fullName mg-bottom-5">
                                                    <div class="inlineBlock width-50-pc text-right">
                                                        <label class="company-label text-right fs-12 width-100-pc">Amount Refunded:&nbsp;</label>
                                                    </div>
                                                    <div class="inlineBlock width-45-pc">
                                                        <label class="company-label text-right fs-12 width-100-pc txt-capitalize fw-600">{{currency+' '+format_money(purchase_form.payment.cash_refunded)}}</label>
                                                    </div>
                                                </div>
                                                <div class="row fullName mg-bottom-5">
                                                    <div class="inlineBlock width-50-pc text-right">
                                                        <label class="company-label text-right fs-12 width-100-pc">Unlocated Amount:&nbsp;&nbsp;</label>
                                                    </div>
                                                    <div class="inlineBlock width-45-pc">
                                                        <label class="company-label text-right fs-12 width-100-pc txt-capitalize fw-600">{{currency+' '+format_money(purchase_form.payment.cash_unlocated)}}</label>
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
                    <button :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref">
                        <span v-if="!processing">Save</span>
                        <span v-else><i class="fa fa-spinner fa-spin"></i></span>
                    </button>
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
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,form_address,format_lunox_date} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {CUSTOMERS_INVOICES_API} from '../../../../../../router/api_routes';
    import {SHIP_TO,FORM_ACTIONS,TAX_OPTIONS,PAYMENT_OPTIONS,ACCOUNTING} from "../../../../../../helpers/process_status";
    import Auth from '../../../../../../store/auth';
    export default {
        name: "CustomerReceiptModal",
        props: ['modal_id','modal_title','invoice','retainer_invoices','payment_api','filters','bank_accounts','accounts','currency','customers','customer'],
        components: {SearchItemField,SupplierModal},
        data(){
            return {
                processing: false,
                is_initializing: false,
                SHIP_TO_OPTIONS: SHIP_TO,
                FORM_ACTIONS: FORM_ACTIONS,
                TAX_OPTIONS:TAX_OPTIONS,
                PAYMENT_OPTIONS: PAYMENT_OPTIONS,
                products: [],
                payment_term:null,
                bank_account: null,
                petty_cash: null,
                inventory: null,
                selected_customer:null,
                account: null,
                vendor_balance: '',
                current_invoice: null,
                current_retainer_invoices: null,

                unpaid_invoices: [],
                customers_list: [],
                TRUST_CODE: ACCOUNTING.COA_CODES.CLIENT_TRUST_CODE,

                purchase_form: {
                    trans_date: null,
                    notes: null,
                    comment: null,
                    paid_invoices: [],
                    customer_id: null,
                    currency: null,
                    retainer_invoice_id: null,
                    payment: {
                        payment_method: '',
                        reference_number: '',
                        cheque_number: null,
                        cash_paid: 0,
                        cash_used: 0,
                        cash_refunded: 0,
                        cash_unlocated: 0,
                        bank_account_id: null,
                        ledger_account_id: null,
                        cash_balance: 0,
                        total_allocation: 0,
                    }
                },

                //product_items: [],
                selected_debtor:{
                    balance: 0,
                    credit_limit: 0,
                    tax_reg_number: null,
                },
            }
        },
        
        watch: {

            invoice: function(new_data,old_data){
                this.current_invoice = new_data;
                this.setPayment();
            },

            selected_customer: function(){
                if( this.selected_customer ){
                    let unpaid_invoices_api = CUSTOMERS_INVOICES_API+'?unpaid_customer_invoice='+this.selected_customer.id;
                    this.loadUnpaidInvoices(unpaid_invoices_api);
                    this.setPayment();
                    // if(!this.invoice){
                    //     //Load upaid invoices under this supplier
                    //     //alert(this.selected_customer.legal_name);
                    //     // let supplier_unpaid_invoices_api = SUPPLIER_BILL_URL+'?filter_by=Supplier&supplier_id='+this.selected_customer.id;
                    //     // this.loadBills(supplier_paid_invoices_api);
                    // }
                }
            },

            retainer_invoices: function(new_data,old_data){
                this.current_retainer_invoices = new_data;
                this.setPayment();
            }

        },

        methods: {

            reset_tax(event){
                if(event.target.value !== TAX_OPTIONS.INCLUSIVE){
                    for (let index = 0; index < this.purchase_form.items.length; index++) {
                        this.purchase_form.items[index].applied_tax_rates = [];
                    }
                }
                this.purchase_form = amend_totals(event,'taxation_option',0,0,0,0,this.purchase_form,'purchase',this.taxations);
            },

            allocateInvoice(event,amount){
                if(event.target.checked){
                    this.purchase_form.payment.total_allocation = (this.purchase_form.payment.total_allocation + amount);
                }else{
                    this.purchase_form.payment.total_allocation = (this.purchase_form.payment.total_allocation - amount);
                }
                this.purchase_form = amend_totals(event,'invoice_cash_paid',0,0,0,0,this.purchase_form,'sales',this.taxations);
            },

            

            setPayment(){

                if(this.current_invoice){
                    this.purchase_form.paid_invoices = [];
                    this.purchase_form.paid_invoices.push(this.current_invoice.id);
                    this.selected_customer = this.invoice.customer;
                    //this.vendor_balance = this.invoice.vendor.balance;
                    this.selected_debtor.balance = this.selected_customer.balance;
                    this.purchase_form.payment.cash_paid = this.current_invoice.net_total-this.current_invoice.cash_paid;
                    this.purchase_form.payment.cash_balance = this.current_invoice.net_total-this.current_invoice.cash_paid;
                    this.max_amount_to_pay = this.current_invoice.net_total-this.current_invoice.cash_paid;
                    this.purchase_form.invoice_number = this.current_invoice.trans_number;
                    this.purchase_form.notes = 'Payment for '+this.current_invoice.trans_number;
                    //
                    for (let index = 0; index < this.customers.length; index++) {
                        const element = this.customers[index];
                        if(element.id === this.current_invoice.vendor.id){
                            this.customers_list.push(element);
                            break;
                        }
                    }
                }

                if(this.current_retainer_invoices){
                    this.selected_customer = this.current_retainer_invoices.customer;
                    this.customers_list = [];
                    this.customers_list.push(this.selected_customer);
                    this.purchase_form.payment.cash_paid = this.current_retainer_invoices.due_balance;
                    this.purchase_form.payment.total_allocation = this.current_retainer_invoices.due_balance;
                    this.purchase_form.payment.cash_used = this.current_retainer_invoices.due_balance;
                    this.purchase_form.payment.cash_refunded = 0;
                    this.purchase_form.payment.cash_unlocated = 0;
                    for (let index = 0; index < this.accounts.length; index++) {
                        const element = this.accounts[index];
                        if(element.default_code === this.TRUST_CODE){
                            this.account = element;
                            break;
                        }
                    }
                }

                // payment_method: '',
                //         reference_number: '',
                //         cheque_number: null,
                //         cash_paid: 0,
                //         cash_used: 0,
                //         cash_refunded: 0,
                //         cash_unlocated: 0,
                //         bank_account_id: null,
                //         ledger_account_id: null,
                //         cash_balance: 0,
                //         total_allocation: 0,
                
                // else{
                //     // this.customers_list = this.customers;
                //     // if(this.selected_customer){
                //     //     this.selected_debtor.balance = this.selected_customer.balance;
                //     //     this.selected_debtor.credit_limit = this.selected_customer.credit_limit;
                //     //     this.selected_debtor.tax_reg_number = this.selected_customer.tax_reg_number;
                //     // }
                // }

                if(this.selected_customer){
                    this.selected_debtor.balance = this.selected_customer.balance;
                    this.selected_debtor.credit_limit = this.selected_customer.credit_limit;
                    this.selected_debtor.tax_reg_number = this.selected_customer.tax_reg_number;
                }
                if(this.filters){this.purchase_form.trans_date = format_lunox_date(this.filters.today);}

            },

            setinvoice(){
                if(this.invoiceable){

                }else{
                    this.purchase_form.bill_date = format_lunox_date(this.filters.today);
                    this.purchase_form.bill_due_date = format_lunox_date(this.filters.today);
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            loadUnpaidInvoices(invoice_api,show_loader=true){
                this.is_initializing = show_loader;
                get(invoice_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.unpaid_invoices = res.data.results.data;
                        console.info(this.unpaid_invoices);
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                    this.is_initializing = false;
                });
            },

            // save_invoice(msg){
            //     this.$dialog
            //     .confirm(msg)
            //     .then(function(dialog) {
            //         // console.log('Clicked store the excess amount');
            //         // this.save_invoice();
            //         this.purchase_form.currency = this.currency;
            //         if(this.payment_term){ this.purchase_form.payment_term_id = this.payment_term.id; }
            //         if(this.inventory){ this.purchase_form.ledger_account_id = this.inventory.id; }
            //         if(this.selected_customer){ this.purchase_form.customer_id = this.selected_customer.id;}
            //         if( (this.bank_account) && (this.purchase_form.payment.payment_method === PAYMENT_OPTIONS.CHEQUE) ){ 
            //             this.purchase_form.payment.bank_account_id = this.bank_account.id;
            //             this.purchase_form.payment.ledger_account_id = "";
            //         }
            //         if( (this.purchase_form.payment.payment_method === PAYMENT_OPTIONS.CASH) && (this.account) ){ 
            //             this.purchase_form.payment.ledger_account_id = this.account.id;
            //             this.purchase_form.payment.bank_account_id = "";
            //         }
            //         post(this.payment_api,this.purchase_form)
            //             .then((res) => {
            //                 if(res.data.status_code === 200) {
            //                     this.processing = false;
            //                     $("#"+this.modal_id).modal('hide');
            //                     this.$emit('create-payment-event');
            //                     this.$awn.success(res.data.description);
            //                 }
            //             }).catch((err) => {
            //             if(err.response.status === 422) {
            //                 this.$awn.warning(createHtmlErrorString(err.response.data.errors))
            //             }else if (err.response.status === 500){
            //                 this.$awn.warning(err.response.data.description);
            //             }
            //             else{
            //                 this.processing = false;
            //                 this.$awn.warning(err.response.data.description)
            //             }
            //             this.processing = false;
            //         });
            //     })
            //     .catch(function() {
            //         return;
            //     });
            // },

            pre_save_invoice(){
                if(this.purchase_form.payment.cash_unlocated>0){
                    let msg = "Would you like to store the excess amount of "+this.currency+""+this.format_money(this.purchase_form.payment.cash_unlocated)+" as over payment from this customer?"
                    //this.confirmModalDialog(msg);
                }else{
                    this.save_invoice();
                }
            },

            save_invoice(){
                this.processing = true;
                //this.purchase_form.action_taken = action_taken;
                this.purchase_form.currency = this.currency;
                if(this.payment_term){ this.purchase_form.payment_term_id = this.payment_term.id; }
                if(this.inventory){ this.purchase_form.ledger_account_id = this.inventory.id; }
                if(this.selected_customer){ this.purchase_form.customer_id = this.selected_customer.id;}
                if( (this.bank_account) && (this.purchase_form.payment.payment_method === PAYMENT_OPTIONS.CHEQUE) ){ 
                    this.purchase_form.payment.bank_account_id = this.bank_account.id;
                    this.purchase_form.payment.ledger_account_id = "";
                }
                if( (this.purchase_form.payment.payment_method === PAYMENT_OPTIONS.CASH) && (this.account) ){ 
                    this.purchase_form.payment.ledger_account_id = this.account.id;
                    this.purchase_form.payment.bank_account_id = "";
                }
                if(this.current_retainer_invoices){
                    this.purchase_form.retainer_invoice_id = this.current_retainer_invoices.id;
                }
                post(this.payment_api,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            $("#"+this.modal_id).modal('hide');
                            this.$emit('create-payment-event');
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

            // add_search_item_invoice(product_items){
            //     console.info(product_items);
            //     for (let index = 0; index < product_items.length; index++) {
            //         const item_product = product_items[index];
            //         this.purchase_form = add_search_item(item_product, this.purchase_form);
            //     }
            // },

            amend_qty(event,type_){
                if(type_ === "invoice_cash_paid"){
                    this.purchase_form = amend_totals(event,'invoice_cash_paid',0,0,0,0,this.purchase_form,'payments',this.taxations);
                }
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){

            if(this.invoice){
                this.current_invoice = this.invoice;
            }

            if(this.retainer_invoices){
                this.current_retainer_invoices = this.retainer_invoices;
            }

            if(this.customers){
                this.customers_list = this.customers;
            }


            this.setPayment();

        }
        
    }
</script>

<style lang="scss" scoped>
    // @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 1100px!important;
        min-width: 1100px!important;
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


