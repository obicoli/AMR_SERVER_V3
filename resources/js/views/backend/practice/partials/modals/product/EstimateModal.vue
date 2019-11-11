<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">

                    <div class="row bg-eee">

                        <div class="col-lg-12">

                            <div class="row">

                                <div class="col-lg-8 col-md-8 padding-left-0 padding-right-0">

                                    <div class="width-100-pc bg-eee padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-5 mg-right-3">
                                                <span class="fs-13 fw-600">Customer <a class="btn-link">+ New Customer</a></span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" list="store_list" type="text" placeholder="Choose a customer">
                                                    <datalist id="store_list">
                                                        <option>AbcCorp | abc@abc.com | #0987654</option>
                                                        <option>GSK | gsk@gsk.com | #678909</option>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-50-pc mg-bottom-5 mg-right-3">
                                                <span class="fs-13 fw-600">Customer email:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" type="text" placeholder="Email (Separate emails with a comma)">
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-10-pc padding-top-25">
                                                <label class="check-container small element-inlined fs-12 cl-444">Send later
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div> 
                                        </div>
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-right-3">
                                                <span class="fs-13 fw-600">Billing address:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-20-pc mg-right-3">
                                                <span class="fs-13 fw-600">Estimate date</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" type="date">
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-20-pc">
                                                <span class="fs-13 fw-600">Expiration date</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" type="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 padding-left-0 padding-right-0">
                                    <div class="row form-group mg-top-30">
                                        <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                            <label class="fs-16 fw-600 cl-888">Amount:</label><br>
                                            <label class="fs-30 fw-600 cl-444">Ksh {{format_money(purchase_form.total_grand)}}</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                    </div>

                    <div class="row mg-top-30 justify-content-center">

                        <div class="col-lg-12">

                            <div class="row">

                                <div class="col-lg-12">

                                    <div id="inner_invoice_area">

                                        <div class="col-md-12 set-no-padding">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <search-item-field :practice_id="practice_id" v-on:itemFound="add_search_item_invoice"></search-item-field>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="float-right width-300-px">
                                                        <div class="row fullName margin-5">
                                                            <div class="inlineBlock padding-top-25">
                                                                <span class="fs-13 fw-600">Amounts are: &nbsp;&nbsp;</span>
                                                            </div>
                                                            <div class="inlineBlock width-70-pc mg-bottom-5 mg-right-3 padding-top-25">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input class="width-100-pc report-filters-inputs" list="tax_list" type="text" placeholder="Choose tax option">
                                                                    <datalist id="tax_list">
                                                                        <option>Exclusive of Tax</option>
                                                                        <option>Inclusive of Tax</option>
                                                                        <option>Out of scope of Tax</option>
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <table class="user-table invoice-table mg-top-20" role="presentation">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%" class="no-rb"></th>
                                                        <th style="width:20%">Product/Service</th>
                                                        <th style="width:28%">Description</th>
                                                        <th style="width:10%" class="text-right">Quantity</th>
                                                        <th style="width:10%" class="text-right">Rate</th>
                                                        <th style="width:15%" class="text-right">Amount</th>
                                                        <th style="width:7%">Tax(%)</th>
                                                        <th style="width:5%" class="no-lb"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                        <td>{{index+1}}</td>
                                                        <td>{{purchase_form.items[index].unit_name}}</td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].description" type="text" class="form-control product-entry-input-field height-27">
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27">
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].unit_cost" type="number" @keyup="amend_qty($event,'unit_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="purchase_form.items[index].pack_retail" @keyup="amend_qty($event,'pack_retail',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="number" @keyup="amend_qty($event,'pack_retail',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27" step="any">
                                                        </td>
                                                        <td class="no-lb">
                                                            <a title="Remove" @click="remove_item(item)" class="pointer-cursor cl-red">x</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="width-400-px mg-top-20 float-left">
                                                <!-- <textarea class="width-100-pc report-filters-inputs min-height-90" placeholder="Your message to supplier"></textarea> -->
                                                <div class="row fullName margin-5">
                                                    
                                                    <div class="inlineBlock width-80-pc">
                                                        <span class="fs-13 fw-600">Your message to supplier</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="inlineBlock width-80-pc">
                                                        <span class="fs-13 fw-600">Memo</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="inlineBlock width-100-pc">
                                                        <span class="fs-13 fw-600">Attachments</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="width-300-px mg-top-30 padding-right-30 float-right">
                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                                        <label class="fs-20 fw-600 cl-444">Subtotal: Ksh{{format_money(purchase_form.total_bill)}}</label>
                                                    </div>
                                                </div>
                                                <!-- <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                                        <label class="fs-12 fw-600 cl-444">Offered Discount%:</label>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <input v-model="purchase_form.discount_offered" @keyup="amend_qty($event,'discount','','','')" type="number" step="any" v-bind:class="{'report-filters-inputs':true,'attended_field':purchase_form.discount_offered}">
                                                    </div>
                                                </div> -->
                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                                        <label class="fs-20 fw-600 cl-444">Total: Ksh{{format_money(purchase_form.total_grand)}}</label>
                                                    </div>
                                                </div>

                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                                        <label class="fs-20 fw-600 cl-444">Estimate Total: Ksh{{format_money(purchase_form.total_grand)}}</label>
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
                    <button type="submit" class="btn btn-inventory primary">
                        <span>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory">
                        Close
                    </button>
                </div>

            </form>
        </div>

    </div>
    
</template>

<script>
    import SearchItemField from '../../modals/product/SearchItemField';
    import {createHtmlErrorString,create_item,removeElement,formatMoney} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    export default {
        props: ['modal_id','modal_title','practice_id','invoice_number'],
        components: {SearchItemField},
        data(){
            return {
                processing: false,
                source_store: false,
                source_vendor: false,
                is_bank_payment: false,
                purchase_form: {
                    practice_bank_id: '',
                    payment_method_id: '',
                    payment_date: '',
                    cheque_number: '',
                    practice_id: '',
                    supplier_id: '',
                    department_id: '',
                    store_id: '',
                    discount_offered: 0,
                    cash_paid: 0,
                    cash_balance: 0,
                    description: '',
                    bill_no: '',
                    total_bill: 0,
                    total_grand: 0,
                    status: '',
                    items: []
                },
                stock_form: {
                    batch_number: ''
                },
                hr_roles: [],
                searched_products_list: [],
            }
        },
        methods: {

            requestVendorForm(){
                this.$emit('requestVendorForm');
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            activeThis(num_){
                this.active_num = num_;
            },

            remove_item(item_to){
                this.purchase_form.items = removeElement(this.purchase_form.items, item_to);
            },

            setSource(event){
                switch(event.target.value){
                    case "vendor":
                        this.source_store = false;
                        this.source_vendor = true;
                        break;
                    case "store":
                        this.source_store = true;
                        this.source_vendor = false;
                        break;
                }
            },
            refresh_page(){
                this.form.status = "";
                this.form.role_name = "";
                this.form.address = "";
                this.form.first_name = "";
                this.form.other_name = "";
                this.form.email = "";
                this.form.mobile = "";
                this.form.gender = "";
                this.form.password = "";
                this.$emit('userAdded');
            },
            add_search_item_invoice(item_product){

                console.info(item_product);
                let add_item = true;
                for ( let i = 0; i < this.purchase_form.items.length; i++ ){
                    if (this.purchase_form.items[i].practice_product_item_id === item_product.id){
                        add_item = false;
                        break;
                    }
                }
                if (add_item){

                    let item = create_item();

                    item.generic_name = item_product.generic_name;
                    item.item_code = item_product.item_code;
                    item.item_stock = item_product.item_stock;
                    item.alert_indicator_level = item_product.alert_indicator_level;
                    item.single_unit_weight = item_product.single_unit_weight;

                    item.pack_cost = item_product.pack_cost;
                    item.pack_retail = item_product.pack_retail_price;
                    item.unit_cost = item_product.unit_cost;
                    item.unit_retail = item_product.unit_retail_price;
                    item.unit_name = item_product.item_name;
                    item.unit_weight = item_product.single_unit_weight;
                    item.unit_measure_type = item_product.product_unit_slug;
                    item.practice_product_item_id = item_product.id;
                    this.purchase_form.items.push(item);
                    //this.purchase_form.total_bill += item.unit_retail;
                    this.purchase_form.total_bill += item.qty * item.pack_cost;
                    if (this.purchase_form.discount_offered > 0){
                        this.purchase_form.total_grand = this.purchase_form.total_bill - ( (this.purchase_form.discount_offered/100)*this.purchase_form.total_bill );
                    } else {
                        this.purchase_form.total_grand = this.purchase_form.total_bill;
                    }

                }
                
            },
            amend_qty(event,type_,unit_cost,pack_cost,product_id){

                switch (type_) {
                    case "qty":
                    case "pack_cost":
                    case "unit_cost":
                    case "discount":
                        this.purchase_form.total_bill = 0;
                        for ( let i = 0; i < this.purchase_form.items.length; i++ ){
                            this.purchase_form.total_bill += this.purchase_form.items[i].qty * this.purchase_form.items[i].pack_cost;
                        }
                        if (this.purchase_form.discount_offered > 0){
                            this.purchase_form.total_grand = this.purchase_form.total_bill - ( (this.purchase_form.discount_offered/100)*this.purchase_form.total_bill );
                        } else {
                            this.purchase_form.total_grand = this.purchase_form.total_bill;
                        }
                        break;
                    case "cash_paid":
                        this.purchase_form.cash_balance = this.purchase_form.total_grand - this.purchase_form.cash_paid;
                        break;
                }

            },
            payment_method(event){
                if(event.target.value === 'Cheque'){
                    this.is_bank_payment = true;
                    this.getBanks();
                }else {
                    this.is_bank_payment = false;
                }
            },
            getBanks(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Banks')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.banks = res.data.results;
                            //console.info(this.banks);
                            this.processing = false;
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
        },
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
</style>


