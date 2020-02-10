<template>
    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_bill" class="modal-content">

                <div class="modal-header bg-eee text-left">
                    <h4 class="width-100-pc text-left"><img src="/assets/icons/dashboard/bill_icon.png"> {{modal_title}}</h4>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">
                    
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
                                                            <label class="fullname fw-600 fs-14 text-right">Supplier Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-20-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Supplier:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-80-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="selected_supplier"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="suppliers_list"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="legal_name"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-20-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Payable:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-80-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(vendor_balance)" class="width-100-pc report-filters-inputs" type="text">
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
                                                                <input v-model="purchase_form.bill_number" disabled type="text" class="custom-attended-field">
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
                                                                    <option :value="PAYMENT_OPTIONS.CASH">{{PAYMENT_OPTIONS.CASH}}</option>
                                                                    <option :value="PAYMENT_OPTIONS.CHEQUE">{{PAYMENT_OPTIONS.CHEQUE}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-if="purchase_form.payment.payment_method===PAYMENT_OPTIONS.CHEQUE" class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc mg-bottom-5">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder="select bank account"
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
                                                                    placeholder="Paid through"
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
                                                            <label class="company-label text-right fs-12 width-100-pc">Allocated Amount:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.max_amount_to_pay" disabled v-bind:class="{'height-32':true}" id="bill_cash_paid" type="number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30 mg-top-5">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Amount Paid:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input @keyup="amend_qty($event,'bill_cash_paid',0,0,0,0)" v-model="purchase_form.payment.cash_paid" required v-bind:class="{'height-32':true}" id="bill_cash_paid" type="number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="width-35-pc float-right fs-12">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Description:&nbsp;&nbsp;</label>
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
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Date:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-70-pc">
                                                                <datetime 
                                                                    v-model="purchase_form.payment_date"
                                                                    :input-id="'date_input_'"
                                                                    placeholder="select date"
                                                                    use12-hour
                                                                    :type="'date'"
                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                    :value="purchase_form.bill_date"
                                                                    >
                                                                </datetime>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-if="unpaid_bills.length>0 && is_initializing===false" class="width-100-pc float-left fs-12 bg-f4 padding-10 mg-bottom-20">
                                                <div class="width-100-pc float-left">
                                                    <label class="fw-600 fs-14">Unpaid Bills</label>
                                                </div>
                                                <div class="width-100-pc float-left">
                                                    <table class="table itemized x-panel">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%;">Allocate</th>
                                                                <th style="width: 15%;">Document No.</th>
                                                                <th style="width: 15%;">Date</th>
                                                                <th style="width: 15%;" class="text-right">Total</th>
                                                                <th style="width: 15%;" class="text-right">Amount Due</th>
                                                                <th style="width: 15%;" class="text-right">Amount Paid</th>
                                                                <th style="width: 15%;" class="text-right">Discount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(upaid_bill, index) in unpaid_bills" :key="'item_key_'+index">
                                                                <td class="padded">
                                                                    <input v-model="purchase_form.paid_bills" :disabled="processing" @click="allocateBill($event,upaid_bill.net_total-upaid_bill.cash_paid)" type="checkbox" :value="upaid_bill.id" :id="'bill_cash_paid_'+index" class="pointer-cursor">
                                                                </td>
                                                                <td class="padded">{{upaid_bill.trans_number}}</td>
                                                                <td class="padded">{{upaid_bill.bill_date}}</td>
                                                                <td class="padded text-right fw-600">{{currency+' '+format_money(upaid_bill.net_total)}}</td>
                                                                <td class="padded text-right fw-600">{{currency}}{{format_money(upaid_bill.net_total-upaid_bill.cash_paid)}}</td>
                                                                <td class="padded text-right fw-600">{{currency+' '+format_money(upaid_bill.cash_paid)}}</td>
                                                                <td class="padded text-right fw-600">{{currency+' '+format_money(upaid_bill.total_discount)}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div v-if="is_initializing" class="width-100-pc float-left fs-12 bg-f4 padding-10 mg-bottom-20 text-center">
                                                <img class="loader" src="/assets/icons/dashboard/loader.gif">
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
    import {SUPPLIER_PO_URL, SUPPLIER_BILL_URL} from '../../../../../../router/api_routes';
    import {SHIP_TO,FORM_ACTIONS,TAX_OPTIONS,PAYMENT_OPTIONS} from "../../../../../../helpers/process_status";
    import Auth from '../../../../../../store/auth';
    export default {
        name: "SupplierPaymentModal",
        props: ['modal_id','modal_title','bill','payment_api','filters','bank_accounts','accounts','currency','suppliers'],
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
                selected_supplier:null,
                account: null,
                vendor_balance: '',
                current_bill: null,

                unpaid_bills: [],
                suppliers_list: [],

                purchase_form: {
                    bill_number: '',
                    supplier_id: null,
                    payment_date: null,
                    notes: null,
                    comment: '',
                    paid_bills: [],
                    // ledger_account_id: null,
                    // supplier_invoice_number: null,
                    // items: [],
                    // total_discount: 0,
                    // cash_paid: 0,
                    // cash_balance: 0,
                    // grand_total: 0,
                    // net_total: 0,
                    // total_tax: 0,
                    // billed_type: null,
                    max_amount_to_pay: 0,
                    currency: null,
                    payment: {
                        payment_method: '',
                        reference_number: '',
                        cheque_number: null,
                        cash_paid: 0,
                        bank_account_id: null,
                        ledger_account_id: null,
                        cash_balance: 0,
                    }
                },

                product_items: [],
            }
        },
        
        watch: {

            bill: function(new_data,old_data){
                this.current_bill = new_data;
                this.setPayment();
            },

            selected_supplier: function(){
                if( this.selected_supplier ){
                    if(!this.bill){
                        //Load upaid bills under this supplier
                        //alert(this.selected_supplier.legal_name);
                        let supplier_unpaid_bills_api = SUPPLIER_BILL_URL+'?filter_by=Supplier&supplier_id='+this.selected_supplier.id;
                        this.loadBills(supplier_unpaid_bills_api);
                    }
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
                this.purchase_form = amend_totals(event,'taxation_option',0,0,0,0,this.purchase_form,'purchase',this.taxations);
            },

            allocateBill(event,amount){
                if(event.target.checked){
                    this.purchase_form.max_amount_to_pay = (this.purchase_form.max_amount_to_pay + amount);
                    //this.max_amount_to_pay += amount;
                }else{
                    this.purchase_form.max_amount_to_pay = (this.purchase_form.max_amount_to_pay - amount);
                    //this.max_amount_to_pay -= amount;
                }
            },

            setPayment(){
                if(this.current_bill){
                    this.purchase_form.paid_bills = [];
                    this.purchase_form.paid_bills.push(this.current_bill.id);
                    this.selected_supplier = this.bill.vendor;
                    this.vendor_balance = this.bill.vendor.balance;
                    this.purchase_form.payment.cash_paid = this.current_bill.net_total-this.current_bill.cash_paid;
                    this.purchase_form.payment.cash_balance = this.current_bill.net_total-this.current_bill.cash_paid;
                    this.max_amount_to_pay = this.current_bill.net_total-this.current_bill.cash_paid;
                    this.purchase_form.bill_number = this.current_bill.trans_number;
                    this.purchase_form.notes = 'Payment for '+this.current_bill.trans_number;
                    //
                    for (let index = 0; index < this.suppliers.length; index++) {
                        const element = this.suppliers[index];
                        if(element.id === this.current_bill.vendor.id){
                            this.suppliers_list.push(element);
                            break;
                        }
                    }
                }else{
                    this.suppliers_list = this.suppliers;
                    if(this.selected_supplier){
                        this.vendor_balance = this.bill.vendor.balance;
                    }
                }
                if(this.filters){this.purchase_form.payment_date = format_lunox_date(this.filters.today);}

            },

            setBill(){
                if(this.billable){

                }else{
                    this.purchase_form.bill_date = format_lunox_date(this.filters.today);
                    this.purchase_form.bill_due_date = format_lunox_date(this.filters.today);
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            loadBills(bill_api,show_loader=true){
                this.is_initializing = show_loader;
                get(bill_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.unpaid_bills = res.data.results.data;
                        console.info(this.unpaid_bills);
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                    this.is_initializing = false;
                });
            },

            save_bill(){
                this.processing = true;
                //this.purchase_form.action_taken = action_taken;
                this.purchase_form.currency = this.currency;
                if(this.payment_term){ this.purchase_form.payment_term_id = this.payment_term.id; }
                if(this.inventory){ this.purchase_form.ledger_account_id = this.inventory.id; }
                if(this.selected_supplier){ this.purchase_form.supplier_id = this.selected_supplier.id;}
                if(this.bank_account){ this.purchase_form.payment.bank_account_id = this.bank_account.id }
                if(this.account){ this.purchase_form.payment.ledger_account_id = this.account.id }
                post(this.payment_api,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
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

            add_search_item_invoice(product_items){
                console.info(product_items);
                for (let index = 0; index < product_items.length; index++) {
                    const item_product = product_items[index];
                    this.purchase_form = add_search_item(item_product, this.purchase_form);
                }
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                if(type_ === "bill_cash_paid"){
                    if(event.target.value > this.max_amount_to_pay ){
                        this.purchase_form.payment.cash_paid = this.max_amount_to_pay;
                    }
                }
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){

            if(this.bill){
                this.current_bill = this.bill;
                this.setPayment();
            }else{
                this.setPayment();
            }

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


