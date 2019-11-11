<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_po" class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}} no. {{po_number}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">

                    <div class="row bg-eee justify-content-center">

                        <div class="col-lg-12">

                            <div class="row">
                                <div class="col-lg-3 col-md-3 padding-left-0 padding-right-0">
                                    <div class="width-100-pc bg-eee padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600 width-100-pc">Supplier <a @click="requestVendorForm" class="btn-link float-right">+ New Vendor</a></span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <!-- <input  list="supplier_list" type="text" placeholder="Choose a supplier"> -->
                                                    <select @change="setSupplier($event)" v-bind:class="{'width-100-pc report-filters-inputs':true,'purchase_form':true}">
                                                        <option value="">-select-</option>
                                                        <option v-for="(supply,index) in supplierss" :key="'supply_'+index" :value="supply.email">{{supply.company}} | {{supply.first_name}} {{supply.middle_name}}</option>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-100-pc">
                                                <!-- <span class="fs-13 fw-600">Email</span> -->
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <textarea v-model="purchase_form.supplier_emails" class="width-100-pc report-filters-inputs min-height-60" placeholder="or enter Email (Separate emails with a comma)"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-9 padding-left-0 padding-right-0">

                                    <div class="width-25-pc bg-eee float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">Ship to:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <select id="store_list" @change="setLocation($event)" class="width-100-pc report-filters-inputs">
                                                        <option value="">-select-</option>
                                                        <option v-for="(practice_lis, index) in practice_list" :value="practice_lis.id" :key="'practice_list'+index">{{practice_lis.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-100-pc">
                                                <!-- <span class="fs-13 fw-600">Email</span> -->
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <textarea v-model="purchase_form.shipping_address" class="width-100-pc report-filters-inputs min-height-60" placeholder="Shipping address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-25-pc bg-eee float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc">
                                                <span class="fs-13 fw-600">Billing address</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <textarea v-model="purchase_form.shipping_address" class="width-100-pc report-filters-inputs min-height-60" placeholder="Billing address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-20-pc bg-eee padding-top-10 padding-bottom-10 float-left">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">Purchase Order Date:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" type="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-20-pc bg-eee padding-top-10 padding-bottom-10 float-left">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">PO Due Date:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" type="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row mg-top-30 justify-content-center">

                        <div class="col-lg-11">

                            <div class="row">

                                <div class="col-lg-12">

                                    <div id="inner_invoice_area">

                                        <div class="col-md-12 set-no-padding">

                                            <!-- -----------SearchItemField------------ -->
                                            <search-item-field :practice_id="practice_id" v-on:itemFound="add_search_item_invoice"></search-item-field>

                                            <table class="user-table normal-table" role="presentation">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%"></th>
                                                        <th style="width:25%">Product/Service</th>
                                                        <th style="width:25%">Description</th>
                                                        <th style="width:15%">Quantity</th>
                                                        <th style="width:12%">Rate</th>
                                                        <th style="width:15%">Amount</th>
                                                        <th style="width:3%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                        <td>{{index+1}}</td>
                                                        <td>{{purchase_form.items[index].unit_name}}</td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].description" type="text" v-bind:class="{'form-control height-27':true,'attended_field':purchase_form.items[index].description}">
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'attended_field':purchase_form.items[index].qty}">
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].pack_cost" type="number" @keyup="amend_qty($event,'pack_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'attended_field':purchase_form.items[index].pack_cost}" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="purchase_form.items[index].amount" @keyup="amend_qty($event,'amount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'attended_field':purchase_form.items[index].amount}" step="any">
                                                        </td>
                                                        <td>
                                                            <a title="Remove" @click="amend_qty($event,'remove',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" class="pointer-cursor cl-red">x</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="width-400-px mg-top-20 float-left">
                                                <div class="row fullName margin-5">
                                                    
                                                    <div class="inlineBlock width-100-pc">
                                                        <span class="fs-13 fw-600">Your message to supplier</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="inlineBlock width-100-pc">
                                                        <span class="fs-13 fw-600">Memo</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="width-300-px mg-top-30 padding-right-30 float-right">
                                                <div class="row form-group mg-bottom-10">
                                                    <div class="col-lg-12 col-md-12 label-txt-right padding-right-0">
                                                        <label class="fs-20 fw-600 cl-444">Subtotal: {{format_money(purchase_form.total_bill)}}</label>
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
    import SupplierModal from '../../modals/vendors/SupplierModal';
    import {createHtmlErrorString,create_item,removeElement,formatMoney} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    export default {
        props: ['modal_id','modal_title','practice_id','po_number','suppliers','practice_list'],
        components: {SearchItemField,SupplierModal},
        data(){
            return {
                processing: false,
                // source_store: false,
                // source_vendor: false,
                // is_bank_payment: false,
                purchase_form: {
                    purchase_type: 'LPO',
                    practice_id: '',
                    supplier_emails: '',
                    mailing_address: '',
                    shipping_address: '',
                    delivery_facility_id: '',
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
                // stock_form: {
                //     batch_number: ''
                // },
                // hr_roles: [],
                searched_products_list: [],
                supplierss: [],
            }
        },
        watch: {
            suppliers: function(new_supplier,old_supplier){
                this.supplierss = new_supplier;
            }
        },
        methods: {

            requestVendorForm(){
                this.$emit('requestVendorForm');
            },

            setLocation(event){
                console.info(event.target.value.id);
                this.purchase_form.shipping_address = event.target.value;
                this.purchase_form.delivery_facility_id = event.target.value;
            },

            setSupplier(event){
                this.purchase_form.supplier_emails = event.target.value;
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            // remove_item(item_to){
            //     this.purchase_form.items = removeElement(this.purchase_form.items, item_to);
            // },

            save_po(){
                this.processing = true;
                let url_ = AppInfo.app_data.server_domain+'/api/products/purchases';
                post(url_,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
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
                    let item = create_item(item_product);
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

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){

                switch (type_) {
                    case "qty":

                    case "pack_cost":
                        
                        this.purchase_form.items[index].amount = this.purchase_form.items[index].qty * this.purchase_form.items[index].pack_cost;
                        break;
                    case "cash_paid":
                        this.purchase_form.cash_balance = this.purchase_form.total_grand - this.purchase_form.cash_paid;
                        break;
                    case "discount":

                        break;
                    case "remove":
                        this.purchase_form.items = removeElement(this.purchase_form.items, this.purchase_form.items[index]);
                        break;
                }
                this.purchase_form.total_bill = 0;
                for ( let i = 0; i < this.purchase_form.items.length; i++ ){
                    this.purchase_form.total_bill += this.purchase_form.items[i].qty * this.purchase_form.items[i].pack_cost;
                    this.purchase_form.items[i].amount = this.purchase_form.items[i].qty * this.purchase_form.items[i].pack_cost;
                }

                if (this.purchase_form.discount_offered > 0){
                    this.purchase_form.total_grand = this.purchase_form.total_bill - ( (this.purchase_form.discount_offered/100)*this.purchase_form.total_bill );
                } else {
                    this.purchase_form.total_grand = this.purchase_form.total_bill;
                }
            },
        },

        mounted(){
            this.supplierss = this.suppliers;
            this.purchase_form.practice_id = this.practice_id;
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
</style>


