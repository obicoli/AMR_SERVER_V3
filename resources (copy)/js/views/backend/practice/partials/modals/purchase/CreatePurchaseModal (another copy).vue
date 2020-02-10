<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_purchase" class="modal-content">
                <div class="modal-header">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 padding-right-0 padding-left-0">
                            <div class="po-separator">
                                <span class="fw-600 fs-12 txt-uppercase">General Detail :</span>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="padding-right-10">
                                <div class="width-40-pc pull pull-left">
                                    <div class="row fullName mg-bottom-10 width-100-pc">
                                        <div class="inlineBlock width-50-pc margin-r-5">
                                            <span class="fs-13 fw-600">Supplier/vendor<small class="fs-10"></small> </span>
                                            <a @click="requestVendorForm" class="btn-link float-right">+ New supplier</a>
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select v-model="item_form.supplier_id" required v-bind:class="{'width-100-pc':true,'attended_field':item_form.supplier_id}">
                                                    <option>--select--</option>
                                                    <option v-for="(suppl,index) in initializations.suppliers" :key="'supplier_id_'+index" :value="suppl.id">{{suppl.first_name}} | {{suppl.email}} | {{suppl.company}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inlineBlock width-40-pc mg-right-3">
                                            <label class="fullname" for="firstName">Bill No.</label>
                                            <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                                <input type="text"  v-model="item_form.bill_no" required v-bind:class="{'width-100-pc':true,'attended_field':item_form.bill_no}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="width-50-pc pull pull-right">
                                    <div class="row fullName mg-bottom-10 width-100-pc">
                                        <div class="inlineBlock width-35-pc mg-right-3 float-right">
                                            <span class="fs-13 fw-600">Facility/Branch<small class="fs-10"></small> </span>
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select v-model="item_form.practice_id" required v-bind:class="{'width-100-pc':true,'attended_field':item_form.practice_id}">
                                                    <option>--select--</option>
                                                    <option v-for="(facil,index_facil) in initializations.facilities" :key="'supplier_id_'+index_facil" :value="facil.id">{{facil.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inlineBlock width-30-pc mg-right-3 float-right">
                                            <label class="fullname" for="firstName">Store</label>
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select v-model="item_form.store_id" required v-bind:class="{'width-100-pc':true,'attended_field':item_form.store_id}">
                                                    <option>--select--</option>
                                                    <option v-for="(stor,index_stores) in initializations.stores" :key="'supplier_id_'+index_stores" :value="stor.id">{{stor.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inlineBlock width-30-pc float-right">
                                            <span class="fs-13 fw-600">Sub-store<small class="fs-10"></small></span>
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select v-model="item_form.sub_store_id" required v-bind:class="{'width-100-pc':true,'attended_field':item_form.sub_store_id}">
                                                    <option>--select--</option>
                                                    <option v-for="(sub_stor,index_sub_stores) in initializations.sub_stores" :key="'supplier_id_'+index_sub_stores" :value="sub_stor.id">{{sub_stor.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 padding-right-0 padding-left-0">
                            <div class="po-separator mg-bottom-15 mg-top-20">
                                <span class="fw-600 fs-12 txt-uppercase">Create purchase items :</span>(<small>Create a purchase for purchasing purpose.</small>)
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 padding-left-0 padding-right-0">
                            <div class="">
                                <div  id="inner_invoice_area">
                                    <search-item-field :practice_id="practice_id" v-on:itemFound="add_search_item_invoice"></search-item-field>
                                    <div class="col-md-12 padding-left-0 padding-right-0">
                                        <table class="items table-hover purchase table table-striped table-bordered table_height_set">
                                            <thead>
                                            <tr>
                                                <th class="white" style="width: 2%"></th>
                                                <th class="white" style="width: 36%">Item</th>
                                                <th class="white" style="width: 12%">Weight</th>
                                                <th class="white" style="width: 6%">Qty(Pack)</th>
                                                <th class="white" style="width: 6%">Unit Cost </th>
                                                <th class="white" style="width: 6%">Unit Retail</th>
                                                <th class="white" style="width: 6%">Pack Cost</th>
                                                <th class="white" style="width: 6%">Pack Retail</th>
                                                <th class="white" style="width: 18%">Batch</th>
                                                <th class="white" style="width: 2%"><a title="Add Item" class="fs-15 cl-white pointer-cursor">+</a></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="zero-padding" v-for="(item, index) in item_form.items" :key="'item_key_'+index">
                                                    <td>{{index+1}}</td>
                                                    <td>{{item_form.items[index].brand}}(<small>{{item_form.items[index].brand_sector}}</small>)</td>
                                                    <td>{{item_form.items[index].unit_weight}} {{item_form.items[index].measure_unit_sympol}}</td>
                                                    <td class="one-padding">
                                                        <input v-model="item_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',item_form.items[index].unit_cost,item_form.items[index].pack_cost,item_form.items[index].practice_product_item_id,index)" class="form-control product-entry-input-field height-27">
                                                    </td>
                                                    <td class="one-padding">
                                                        <input v-model="item_form.items[index].unit_cost" type="number" @keyup="amend_qty($event,'qty',item_form.items[index].unit_cost,item_form.items[index].pack_cost,item_form.items[index].practice_product_item_id,index)" class="form-control product-entry-input-field height-27" step="any">
                                                    </td>
                                                    <td class="one-padding">
                                                        <input v-model="item_form.items[index].unit_retail" type="number" @keyup="amend_qty($event,'qty',item_form.items[index].unit_cost,item_form.items[index].pack_cost,item_form.items[index].practice_product_item_id,index)" class="form-control product-entry-input-field height-27" step="any">
                                                    </td>
                                                    <td class="one-padding">
                                                        <input v-model="item_form.items[index].pack_cost" type="number" @keyup="amend_qty($event,'qty',item_form.items[index].unit_cost,item_form.items[index].pack_cost,item_form.items[index].practice_product_item_id,index)" class="form-control product-entry-input-field height-27" step="any">
                                                    </td>
                                                    <td class="one-padding">
                                                        <input type="number" v-model="item_form.items[index].pack_retail" @keyup="amend_qty($event,'qty',item_form.items[index].unit_cost,item_form.items[index].pack_cost,item_form.items[index].practice_product_item_id,index)" class="form-control product-entry-input-field height-27" step="any">
                                                    </td>
                                                    <td class="one-padding">
                                                        <input type="text" v-model="item_form.items[index].batch_number" class="form-control product-entry-input-field height-27">
                                                        <div v-if="item_form.items[index].batch_number" class="expiry-content mg-top-5">
                                                            <span class="cl-444 fs-14 fw-600">Expiry:</span>
                                                            <select v-model="item_form.items[index].exp_month" required class="bg-white height-27 border-radius-2 border-ccc no-shadowed" style="width: 35%;">
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
                                                            <select v-model="item_form.items[index].exp_year" required class="bg-white height-27 border-radius-2 border-ccc no-shadowed" style="width: 35%;">
                                                                <option value="2019">2019</option>
                                                                <option value="2020">2020</option>
                                                                <option value="2021">2021</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a title="Remove" @click="amend_qty($event,'remove',item_form.items[index].unit_cost,item_form.items[index].pack_cost,item_form.items[index].practice_product_item_id,index)" class="pointer-cursor cl-red">x</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 padding-right-0 padding-left-0">
                            <div class="po-separator mg-top-20">
                                <span class="fw-600 fs-12 txt-uppercase">Payment Detail :</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="row">
                                <div class="col-md-12 padding-left-20">
                                    <h4 class="purchase-heading border-radius-0"><i class="fa fa-check-circle"></i>  Purchase Detail :</h4>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Total: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="mention the amount of total bill"></i></small></label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-6">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <label class="fs-18 fw-600 cl-444">Kes {{format_money(item_form.total_bill)}}</label>
                                            <!-- <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="number" v-model="item_form.total_bill" step="any" v-bind:class="{'height-27':true,'attended_field':item_form.total_bill}">
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Offered Discount%:</label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-6">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="item_form.discount_offered" @keyup="amend_qty($event,'discount','','','')" type="number" step="any" v-bind:class="{'height-27':true,'attended_field':item_form.discount_offered}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Grand Total: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="mention the amount of total bill"></i></small></label>
                                </div>
                                <div class="col-lg-7 col-md-6 col-sm-6">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <label class="fs-18 fw-600 cl-444">Kes {{format_money(item_form.total_grand)}}</label>
                                                <!-- <input v-model="item_form.total_grand" type="number" step="any" v-bind:class="{'height-27':true,'attended_field':item_form.total_grand}"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Upload Bill Image: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="capture or scan bill image"></i></small></label>
                                </div>
                                <div class="col-lg-7 col-md-6 col-sm-6">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="file" name="pur_picture" data-validate="required" class="" data-message-required="Value Required">
                                            </div>
                                        </div>
                                    </div>
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
                                <div class="col-lg-5 col-md-5 col-sm-5 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Payment Method: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="method of payment cash or cheque"></i></small></label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select @change="payment_method($event)" required v-model="item_form.payment_method_id" v-bind:class="{'height-27':true,'attended_field':item_form.payment_method_id}">
                                                    <option selected disabled value="">select</option>
                                                    <option v-for="(payment_type,index_payment_type) in initializations.payment_types" :key="'index_payment_type_'+index_payment_type" :value="payment_type.name">{{payment_type.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="is_bank_payment" class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-5 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-amref">Bank account:</label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select v-model="item_form.practice_bank_id" required v-bind:class="{'height-27':true,'attended_field':item_form.practice_bank_id}">
                                                    <option selected disabled value="">Bank account</option>
                                                    <option v-for="(banky,index) in initializations.banks" :value="banky.id" :key="'banky'+index">{{banky.name}}, {{banky.branch}} | Title: {{banky.account_title}} | Ac: {{banky.account_number}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="is_bank_payment" class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-5 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-amref">Cheque No:</label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="item_form.cheque_number" required type="text" v-bind:class="{'height-27':true,'attended_field':item_form.cheque_number}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-5 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Payment Date: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="date of bill paid"></i></small></label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="date" v-model="item_form.payment_date" required v-bind:class="{'height-27':true,'attended_field':item_form.payment_date}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-5 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Cash Paid: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="how much you paid against total bill."></i></small></label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="item_form.cash_paid" type="number" step="any" @keyup="amend_qty($event,'cash_paid','','','')" v-bind:class="{'height-27':true,'attended_field':item_form.cash_paid}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-5 col-md-5 col-sm-5 label-txt-right padding-right-0">
                                    <label class="fs-14 fw-600 cl-444">Balance: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="remaing amount you need to pay in future."></i></small></label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <div class="row fullName width-100-pc">
                                        <div class="inlineBlock width-100-pc mg-left-10">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <label class="fs-18 fw-600 cl-444">Kes {{format_money(item_form.cash_balance)}}</label>
                                                <!-- <input v-model="item_form.cash_balance" type="number" step="any" class="height-27"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  Note:</h4>
                                </div>
                            </div>
                            <textarea v-model="item_form.note" class="width-100-pc report-filters-inputs min-height-90" placeholder="any description you want to add for future help." v-bind:class="{'height-27':true,'attended_field':item_form.note}"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-amref btn-lg fs-15">
                        <span v-if="user_mode==='Create'">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save Purchase</span>
                        </span>
                        <span v-else>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Update</span>
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
    import {get,post} from '../../../../../../helpers/api';
    import AppInfo from '../../../../../../helpers/config';
    import SearchItemField from '../product/SearchItemField';
    import {createHtmlErrorString,reset_forms,create_item,removeElement,formatMoney} from '../../../../../../helpers/functionmixin';
    import {PURCHASES_URL} from '../../../../../../router/api_routes';
    export default {
        name: "Employee",
        components: {SearchItemField},
        props:['practice_id','form_data','user_mode','modal_id','title','initializations'],
        data(){
            return {
                processing: false,
                is_bank_payment: false,
                item_form: {
                    purchase_type: 'purchase',
                    practice_bank_id: '',
                    payment_method_id: '',
                    payment_date: '',
                    cheque_number: '',
                    practice_id: '',
                    supplier_id: '',
                    department_id: '',
                    store_id: '',
                    sub_store_id: '',
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
            }
        },
        watch: {
            initializations: function(new_in,old_in){
                this.initializations = new_in
            }
        },
        methods: {

            save_purchase(){
              this.processing = true;
              this.item_form.practice_id = this.practice_id;
                post(PURCHASES_URL,this.item_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                this.form = reset_forms(this.form);
                                this.$emit('purchaseCreated');
                                this.processing = false;
                            }else {
                                this.$emit('purchaseEdited');
                                this.processing = false;
                            }
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

            requestVendorForm(){
                this.$emit('requestVendorForm');
            },

            add_search_item_invoice(item_product){
                let add_item = true;
                for ( let i = 0; i < this.item_form.items.length; i++ ){
                    if (this.item_form.items[i].id === item_product.id){
                        add_item = false;
                        break;
                    }
                }
                if (add_item){
                    let item = create_item(item_product);
                    this.item_form.items.push(item);
                    this.item_form.total_bill += item.qty * item.pack_cost;
                    if (this.item_form.discount_offered > 0){
                        this.item_form.total_grand = this.item_form.total_bill - ( (this.item_form.discount_offered/100)*this.item_form.total_bill );
                    } else {
                        this.item_form.total_grand = this.item_form.total_bill;
                    }
                }  
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                switch (type_) {
                    case "qty":
                    case "pack_cost":
                        this.item_form.items[index].amount = this.item_form.items[index].qty * this.item_form.items[index].pack_cost;
                        //this.item_form.cash_balance = this.item_form.total_grand;
                        break;
                    case "cash_paid":
                        //this.item_form.cash_balance = this.item_form.total_grand - this.item_form.cash_paid;
                        break;
                    case "discount":

                        break;
                    case "remove":
                        this.item_form.items = removeElement(this.item_form.items, this.item_form.items[index]);
                        //this.item_form.cash_balance = this.item_form.total_grand;
                        break;
                }
                this.item_form.total_bill = 0;
                for ( let i = 0; i < this.item_form.items.length; i++ ){
                    this.item_form.total_bill += this.item_form.items[i].qty * this.item_form.items[i].pack_cost;
                    this.item_form.items[i].amount = this.item_form.items[i].qty * this.item_form.items[i].pack_cost;
                }

                if (this.item_form.discount_offered > 0){
                    this.item_form.total_grand = this.item_form.total_bill - ( (this.item_form.discount_offered/100)*this.item_form.total_bill );
                    this.item_form.cash_balance = this.item_form.total_grand - this.item_form.cash_paid;
                } else {
                    this.item_form.total_grand = this.item_form.total_bill;
                    this.item_form.cash_balance = this.item_form.total_grand - this.item_form.cash_paid;
                }
            },
            remove_item(item_to){
                this.item_form.items = removeElement(this.item_form.items, item_to);
            },
            payment_method(event){
                if(event.target.value === 'Cheque'){
                    this.is_bank_payment = true;
                    //this.getBanks();
                }else {
                    this.is_bank_payment = false;
                }
            },
        },
        mounted() {
            
        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-lg {
        max-width: 1200px!important;
        min-width: 1000px!important;
    }
    .modal-header{
        border-bottom: 1px solid #fff!important;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .fullAdd.employeeForm .row {
        padding-bottom: 4px;
    }
    .inlineBlock {
        display: inline-block;
    }
    .inlineBlock label {
        font-weight: 600!important;
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px;
        font-size: 14px;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select{
        outline: none!important;
        /* height: 32px!important; */
        border: 1px solid #BABEC5!important;
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

    input::placeholder, textarea::placeholder  {
        color: #babec5!important;
        font-size: 12px!important;
        font-style: italic;
        font-weight: 400!important;
    }
    .checkboxInline {
        margin-left: 5px;
    }
    input[type=checkbox]:not(.dijitCheckBoxInput):not(.idsCheckbox__input) {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        background-color: transparent;
        border: 1px solid #8D9096;
        border-radius: 2px;
        background-repeat: no-repeat;
        background-size: 124px;
        background-position: -28px -3px;
        user-select: none;
        -webkit-appearance: none;
    }
    .attended_fiel{
        background-color: #f4f4f4!important;
        font-weight: 600!important;
    }
</style>