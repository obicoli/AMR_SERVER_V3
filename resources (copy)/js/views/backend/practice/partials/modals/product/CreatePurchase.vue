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

                        <div class="col-lg-5 col-md-5 padding-left-0 padding-right-0">
                            <div class="width-100-pc bg-eee padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-350-px padding-right-5 mg-right-10">
                                        <span class="fs-13 fw-600">Vendor/Supplier</span>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select class="width-100-pc report-filters-inputs">
                                                <option disabled selected value="">-who is the provider of puchasing items-</option>
                                                <option>AbcCorp | abc@abc.com | #0987654</option>
                                                <option>GSK | gsk@gsk.com | #678909</option>
                                            </select>
                                            <a class="btn-link btn-link-blue">+ New Vendor</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-7 padding-left-0 padding-right-0">

                            <div class="width-400-px bg-eee float-right padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-100-pc mg-bottom-1">
                                        <span class="fs-13 fw-600">Ship to:</span>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input class="width-100-pc report-filters-inputs" list="store_list" type="text" placeholder="for which store you are purchasing">
                                            <datalist id="store_list">
                                                <option>Amref UpperHill | Sub Store | #0987654</option>
                                                <option>Amref Langata | Main Store | #678909</option>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-30-pc mg-bottom-2">
                                        <span class="fs-13 fw-600">Date:</span>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-2">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input class="width-100-pc report-filters-inputs" type="date">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-100-pc mg-bottom-2">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input class="width-100-pc report-filters-inputs" type="text" placeholder="mention the bill no provided by supplier">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mg-top-30">

                        <div class="col-lg-12">

                            <div  id="inner_invoice_area">

                                <div class="col-md-12 set-no-padding">

                                    <!-- -----------SearchItemField------------ -->
                                    <search-item-field :practice_id="practice_id" v-on:itemFound="add_search_item_invoice"></search-item-field>

                                    <table class="items table-hover purchase table table-striped table-bordered table_height_set">
                                        <thead>
                                        <tr>
                                            <th style="width: 20%">Item</th>
                                            <th style="width: 8%">Weight</th>
                                            <th style="width: 10%">Qty(Pack)</th>
                                            <th style="width: 10%">Unit Cost </th>
                                            <th style="width: 10%">Unit Retail</th>
                                            <th style="width: 10%">Pack Cost</th>
                                            <th style="width: 10%">Pack Retail</th>
                                            <th style="width: 18%">Batch</th>
                                            <th style="width: 4%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">

                                            <td>{{purchase_form.items[index].unit_name}}</td>
                                            <td>{{purchase_form.items[index].unit_weight}} {{purchase_form.items[index].unit_measure_type}}</td>
                                            <td>
                                                <input v-model="purchase_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27">
                                            </td>
                                            <td>
                                                <input v-model="purchase_form.items[index].unit_cost" type="number" @keyup="amend_qty($event,'unit_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27" step="any">
                                            </td>
                                            <td>
                                                <input v-model="purchase_form.items[index].unit_retail" type="number" @keyup="amend_qty($event,'unit_retail',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27" step="any">
                                            </td>
                                            <td>
                                                <input v-model="purchase_form.items[index].pack_cost" type="number" @keyup="amend_qty($event,'pack_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27" step="any">
                                            </td>
                                            <td>
                                                <input type="number" v-model="purchase_form.items[index].pack_retail" @keyup="amend_qty($event,'pack_retail',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)" class="form-control product-entry-input-field height-27" step="any">
                                            </td>
                                            <td>
                                                <input type="text" v-model="purchase_form.items[index].batch_number" class="form-control product-entry-input-field height-27">
                                                <div v-if="purchase_form.items[index].batch_number !==''" class="expiry-content mg-top-5">
                                                    <span class="cl-444 fs-14 fw-600">Expiry:</span>
                                                    <select v-model="purchase_form.items[index].exp_month" required class="bg-white height-27 border-radius-2 border-ccc no-shadowed" style="width: 35%;">
                                                        <option value="1">Jan</option>
                                                        <option value="2">Feb</option>
                                                        <option value="3">Mar</option>
                                                        <option value="4">Apr</option>
                                                        <option value="5">May</option>
                                                        <option value="6">Jun</option>
                                                        <option value="7">Jul</option>
                                                        <option value="8">Aug</option>
                                                        <option value="9">Sep</option>
                                                        <option value="10">Oct</option>
                                                        <option value="11">Nov</option>
                                                        <option value="12">Dec</option>
                                                    </select>
                                                    <select v-model="purchase_form.items[index].exp_year" required class="bg-white height-27 border-radius-2 border-ccc no-shadowed" style="width: 35%;">
                                                        <option value="2019">2019</option>
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <a title="Remove" @click="remove_item(item)" class="pointer-cursor cl-red">x</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="row">
                                <div class="col-md-12 padding-left-20">
                                    <h4 class="purchase-heading border-radius-0"><i class="fa fa-check-circle"></i>  Purchase Detail :</h4>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Total: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="mention the amount of total bill"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="number" v-model="purchase_form.total_bill" step="any" v-bind:class="{'report-filters-inputs':true,'attended_field':purchase_form.total_bill}">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Offered Discount%:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.discount_offered" @keyup="amend_qty($event,'discount','','','')" type="number" step="any" v-bind:class="{'report-filters-inputs':true,'attended_field':purchase_form.discount_offered}">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Grand Total: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="mention the amount of total bill"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.total_grand" type="number" step="any" v-bind:class="{'report-filters-inputs':true,'attended_field':purchase_form.total_grand}">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Upload Bill Image: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="capture or scan bill image"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="file" name="pur_picture" data-validate="required" class="report-filters-inputs attended_field" data-message-required="Value Required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  Payment Detail :</h4>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Payment Method: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="method of payment cash or cheque"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <select @change="payment_method($event)" required v-model="purchase_form.payment_method_id" class="report-filters-inputs attended_field">
                                        <option selected disabled value="">select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="is_bank_payment" class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-amref">Bank account:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <select v-model="purchase_form.practice_bank_id" class="report-filters-inputs attended_field">
                                        <option selected disabled value="">Bank account</option>
                                        <option v-for="(banky,index) in banks" :value="banky.id" :key="'banky'+index">{{banky.bank_name}}, {{banky.state}} | Title: {{banky.account_name}} | Ac: {{banky.account_number}} | Branch: {{banky.branch_name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div v-if="is_bank_payment" class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-amref">Cheque No:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.cheque_number" type="text" class="report-filters-inputs attended_field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Payment Date: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="date of bill paid"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="date" v-model="purchase_form.payment_date" required class="report-filters-inputs attended_field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Cash Paid: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="how much you paid against total bill."></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.cash_paid" type="number" step="any" @keyup="amend_qty($event,'cash_paid','','','')" class="report-filters-inputs attended_field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-12 fw-600 cl-444">Balance: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="remaing amount you need to pay in future."></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.cash_balance" type="number" step="any" class="report-filters-inputs attended_field">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  Note:</h4>
                                </div>
                            </div>
                            <textarea class="width-100-pc report-filters-inputs min-height-90" placeholder="Your message to supplier"></textarea>
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
    import {createHtmlErrorString,create_item,removeElement} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    export default {
        props: ['modal_id','modal_title','practice_id'],
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


