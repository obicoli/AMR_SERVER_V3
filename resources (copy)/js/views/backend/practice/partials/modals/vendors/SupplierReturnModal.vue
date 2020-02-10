<template>
    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_return" class="modal-content">

                <div class="modal-header bg-eee text-left">
                    <h4 class="width-100-pc text-left"><img src="/assets/icons/dashboard/bill_icon.png"> {{modal_title}}</h4>
                </div>

                <div class="modal-body bg-f4 padding-top-0 padding-bottom-0">
                    
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
                                                            <label class="company-label text-right fs-12 width-100-pc">Balance:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-80-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(selected_supplie.balance)" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">VAT Reference:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="selected_supplie.tax_reg_number" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Credit Limit:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(selected_supplie.credit_limit)" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="width-30-pc float-left mg-left-30">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc text-right">
                                                            <label class="fullname fw-600 fs-14 text-right">Return Details</label>
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
                                                    <div class="row fullName mg-bottom-5 mg-left-30 mg-top-5">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Reference:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.max_amount_to_pay" disabled v-bind:class="{'height-32':true}" id="bill_cash_paid" type="number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30 mg-top-5">
                                                        <div class="inlineBlock width-25-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">From Bill:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-75-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="bill"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="bills"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="display_as"
                                                                ></vue-single-select>
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
                                                                    v-model="purchase_form.payment_date"
                                                                    :input-id="'date_input_'"
                                                                    placeholder="select date"
                                                                    use12-hour
                                                                    :type="'date'"
                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                    :value="purchase_form.return_date"
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
                                                </div>
                                            </div>

                                            <div class="width-100-pc float-left fs-12 bg-f4 padding-10">
                                                <div class="float-left width-30-pc">
                                                    <search-item-field @item-event="add_search_item_invoice(product_items)" :product_items="product_items" :show_label="true" :barcode="true" :products="products" :tabulated_view="true" :search_result_width="1130" :field_wdth="100" :field_cover_wdth="300" :search_result_min_height="300"></search-item-field>
                                                </div>
                                                <div class="width-25-pc float-right">
                                                    <div class="row fullName">
                                                        <div class="inlineBlock padding-top-25">
                                                            <span class=" text-right">Amounts are:&nbsp;&nbsp;</span>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc mg-bottom-5 padding-top-25">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <select @change="reset_tax($event)" v-model="purchase_form.taxation_option" class="width-100-pc report-filters-inputs" >
                                                                    <option :value="TAX_OPTIONS.EXCLUSIVE">{{TAX_OPTIONS.EXCLUSIVE}}</option>
                                                                    <option :value="TAX_OPTIONS.INCLUSIVE">{{TAX_OPTIONS.INCLUSIVE}}</option>
                                                                    <option :value="TAX_OPTIONS.OUT_OF_SCOPE">{{TAX_OPTIONS.OUT_OF_SCOPE}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="width-100-pc float-left">
                                                    <table class="table itemized x-panel">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 21%;">Item</th>
                                                                <th style="width: 16%;">Description</th>
                                                                <th style="width: 4%;" class="text-center">Unit</th>
                                                                <th style="width: 5%;" class="text-center">Qty</th>
                                                                <th style="width: 5%;" class="text-center">Rate</th>
                                                                <th style="width: 6%;" class="text-center">Vat type</th>
                                                                <th style="width: 5%;" class="text-right">Disc(%)</th>
                                                                <th style="width: 8%;" class="text-right">Discount</th>
                                                                <th style="width: 10%;" class="text-right">Exclusive</th>
                                                                <th style="width: 8%;" class="text-right">VAT</th>
                                                                <th style="width: 10%;" class="text-right">Total</th>
                                                                <th style="width: 2%;" class="text-right"><a class="pointer-cursor">x</a></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                                <td class="padded">{{purchase_form.items[index].brand.name}}</td>
                                                                <td class="padded">{{purchase_form.items[index].brand_sector.name}}</td>
                                                                <td class="padded text-center">{{purchase_form.items[index].measure_unit.slug}}</td>
                                                                <td class="inp">
                                                                    <input v-model="purchase_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].qty}">
                                                                </td>
                                                                <td class="inp"><input v-model="purchase_form.items[index].price.pack_cost" disabled type="number" @keyup="amend_qty($event,'pack_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].price.pack_retail_price}" step="any"></td>
                                                                <td class="inp">
                                                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                                        <div class="btn-group" role="group">
                                                                            <button :disabled="purchase_form.taxation_option===null || purchase_form.taxation_option==='Out of scope of Tax' || purchase_form.taxation_option==='Exclusive of Tax'" :id="'btnGroupDrop'+index" type="button" class="dropdown-toggle btn btn-secondary btn-input fs-11" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <span v-if="purchase_form.items[index].applied_tax_rates.length">{{purchase_form.items[index].applied_tax_rates.length}} VAT(s)</span>
                                                                                <span v-else>Select</span>
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop'+index">
                                                                                <a v-for="(taxation,t_index) in taxations" class="dropdown-item" :key="'taxations_'+t_index"><input v-model="purchase_form.items[index].applied_tax_rates" :value="taxation.id" @change="amend_qty($event,'taxation',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" class="pointer-cursor" type="checkbox"> {{taxation.display_as}} </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="inp"><input v-model="purchase_form.items[index].discount_rate" type="number" @keyup="amend_qty($event,'discount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true}" step="any"></td>
                                                                <td class="padded text-right">{{currency+' '+format_money(purchase_form.items[index].line_discount)}}</td>
                                                                <td class="padded text-right fw-600">{{format_money(purchase_form.items[index].line_exclusive)}}</td>
                                                                <td class="padded text-right">{{currency+' '+format_money(purchase_form.items[index].line_taxation)}}</td>
                                                                <td class="padded text-right fw-600">{{format_money(purchase_form.items[index].line_total)}}</td>
                                                                <td class="padded text-right">
                                                                    <a title="Remove" @click="amend_qty($event,'remove',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" class="pointer-cursor cl-red">x</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="width-100-pc float-left fs-12 bg-f4 padding-20 mg-bottom-20">
                                                
                                                <div class="width-25-pc float-right mg-right-10">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Sub-total:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input :value="currency+' '+format_money(purchase_form.grand_total-purchase_form.total_tax)" disabled type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-if="purchase_form.taxation_option===TAX_OPTIONS.INCLUSIVE" class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Total Tax:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(purchase_form.total_tax)" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Total Discount:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(purchase_form.total_discount)" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Total:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input disabled :value="currency+' '+format_money(purchase_form.net_total)" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div v-if="is_initializing" class="width-100-pc float-left fs-12 bg-f4 padding-10 mg-bottom-20 text-center">
                                                <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                            </div> -->

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
    // import SupplierModal from '../../modals/vendors/SupplierModal';
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,form_address,format_lunox_date} from '../../../../../../helpers/functionmixin';
    //import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {SUPPLIER_PO_URL, SUPPLIER_BILL_URL} from '../../../../../../router/api_routes';
    import {SHIP_TO,FORM_ACTIONS,TAX_OPTIONS,PAYMENT_OPTIONS} from "../../../../../../helpers/process_status";
    import Auth from '../../../../../../store/auth';
    export default {
        name: "SupplierPaymentModal",
        props: ['modal_id','modal_title','taxations','returns_api','filters','currency','suppliers'],
        components: {SearchItemField},
        data(){
            return {
                processing: false,
                is_initializing: false,
                FORM_ACTIONS: FORM_ACTIONS,
                TAX_OPTIONS:TAX_OPTIONS,
                PAYMENT_OPTIONS: PAYMENT_OPTIONS,
                products: [],
                selected_supplier: null,
                selected_supplie:{
                    balance: 0,
                    credit_limit: 0,
                    tax_reg_number: null,
                },
                suppliers_list: [],
                bills: [],
                bill: {},
                returned_bill: {},
                purchase_form: {
                    bill_id: null,
                    supplier_id: null,
                    taxation_option: null,
                    return_date: null,
                    notes: null,
                    items: [],
                    total_discount: 0,
                    cash_paid: 0,
                    cash_balance: 0,
                    grand_total: 0,
                    net_total: 0,
                    total_tax: 0,
                    billed_type: null,
                    currency: null,
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
            }
        },
        
        watch: {

            bill: function(new_data,old_data){
                if(this.bill){
                    let bill_api = SUPPLIER_BILL_URL+'/'+this.bill.id;
                    this.loadBill(bill_api);
                }
            },

            selected_supplier: function(){
                this.setReturn();
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
                }else{
                    this.purchase_form.max_amount_to_pay = (this.purchase_form.max_amount_to_pay - amount);
                }
            },

            setReturn(){
                if(this.selected_supplier){
                    this.selected_supplie.balance = this.selected_supplier.balance;
                    this.selected_supplie.tax_reg_number = this.selected_supplier.tax_reg_number;
                    this.selected_supplie.credit_limit = this.selected_supplier.credit_limit;
                    let bill_api = SUPPLIER_BILL_URL+'?filter_by=Supplier&supplier_id='+this.selected_supplier.id+'&status=All';
                    this.loadBills(bill_api);
                }
                this.suppliers_list = this.suppliers;
                if(this.filters){this.purchase_form.payment_date = format_lunox_date(this.filters.today);}

                if(this.returned_bill){
                    this.purchase_form.taxation_option = this.returned_bill.taxation_option;
                    this.purchase_form.items = this.returned_bill.items;
                    this.purchase_form.total_discount = this.returned_bill.total_discount;
                    this.purchase_form.total_tax = this.returned_bill.total_tax;
                    this.purchase_form.net_total = this.returned_bill.net_total;
                    this.purchase_form.grand_total = this.returned_bill.grand_total;
                }
                if(this.filters){
                    this.purchase_form.return_date = format_lunox_date(this.filters.today);
                }
            },

            loadBill(bill_api){
                get(bill_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.returned_bill = res.data.results;
                        this.setReturn();
                    }
                }).catch((err) => {
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            loadBills(bill_api,show_loader=true){
                this.is_initializing = show_loader;
                get(bill_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bills = res.data.results.data;
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                    this.is_initializing = false;
                });
            },

            save_return(){
                this.processing = true;
                this.purchase_form.currency = this.currency;
                if(this.returned_bill){ this.purchase_form.bill_id = this.returned_bill.id; }
                if(this.selected_supplier){ this.purchase_form.supplier_id = this.selected_supplier.id;}
                post(this.returns_api,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$emit('create-return-event');
                            this.$awn.success(res.data.description);
                            $('#'+this.modal_id).modal('hide');
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
                for (let index = 0; index < product_items.length; index++) {
                    const item_product = product_items[index];
                    this.purchase_form = add_search_item(item_product, this.purchase_form);
                }
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                //this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase');
                if(type_ === 'taxation'){
                    if(event.target.checked){
                        //Push into array
                        this.purchase_form.items[index].applied_tax_rates = [];
                        this.purchase_form.items[index].applied_tax_rates.push(event.target.value);
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                    }else{
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                    }
                }else{
                    this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                }
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },
        },

        mounted(){
            if(this.purchase_return){
                this.setReturn();
            }else{
                this.setReturn();
            }
        }
        
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 1150px!important;
        min-width: 1150px!important;
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


