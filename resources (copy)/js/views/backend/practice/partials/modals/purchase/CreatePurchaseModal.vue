<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_po" class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">
                    <div class="row bg-eee justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 padding-left-0 padding-right-0">
                                    <div class="width-100-pc padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600 width-100-pc">Supplier 
                                                    <!-- <a @click="requestVendorForm" class="btn-link float-right">+ New Vendor</a> -->
                                                </span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <select @change="setFields($event,'supplier')" v-model="purchase_form.supplier_id" v-bind:class="{'width-100-pc':true}">
                                                        <option value="">-select-</option>
                                                        <option v-for="(supply,index) in initializations.suppliers" :key="'supply_'+index" :value="supply.id">{{supply.company}} | {{supply.first_name}} {{supply.middle_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-100-pc">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <textarea v-model="purchase_form.supplier_emails" v-bind:class="{'width-100-pc min-height-60':true}" placeholder="or enter Email (Separate emails with a comma)"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-9 padding-left-0">
                                    <div class="width-25-pc float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc">
                                                <span class="fs-13 fw-600">Mailing address</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <div v-html="supplier_str" class="div-textaread"></div>
                                                    <!-- <textarea v-model="purchase_form.mailing_address" class="width-100-pc report-filters-inputs min-height-60" placeholder="Billing address"></textarea> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-25-pc float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">Ship to:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <select v-if="check_permissions('view.branch')" @change="setFields($event,'facility')" v-model="purchase_form.delivery_id" required class="width-100-pc report-filters-inputs">
                                                        <option value="">-select-</option>
                                                        <option v-for="(practice_lis, index) in initializations.facilities" :value="practice_lis.id" :key="'practice_list'+index">{{practice_lis.name}}</option>
                                                    </select>
                                                    <select v-if="!check_permissions('view.branch')" @change="setFields($event,'facility')" v-model="purchase_form.delivery_id" required class="width-100-pc report-filters-inputs">
                                                        <option value="">-select-</option>
                                                        <option :value="current_branch.id">{{current_branch.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="width-30-pc padding-top-10 padding-bottom-10 float-left">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc">
                                                <span class="fs-13 fw-600">Shipping address</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <div v-html="facility_str" class="div-textaread"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-20-pc padding-top-10 padding-bottom-10 float-left">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">PO Date:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input v-model="purchase_form.po_date" class="width-100-pc report-filters-inputs" type="date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc mg-bottom-5">
                                                <span class="fs-13 fw-600">PO Due Date:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input v-model="purchase_form.po_due_date" class="width-100-pc report-filters-inputs" type="date">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mg-top-20 justify-content-center">
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="po-separator bg-red mg-bottom-15 mg-top-20">
                                <span class="fw-600 fs-12 txt-uppercase">Create PO items:</span>(<small>Create PO for your vendor.</small>)
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="inner_invoice_area">
                                        <div class="col-md-12 set-no-padding">
                                            <search-item-field :practice_id="practice_id" v-on:itemFound="add_search_item_invoice"></search-item-field>
                                            <table class="receipt-item-table-2 table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;"></th>
                                                        <th style="width: 35%;">Product/Service</th>
                                                        <th style="width: 22%;">Description</th>
                                                        <th style="width: 10%;">Qty(Packs)</th>
                                                        <th style="width: 10%;">Rate</th>
                                                        <th style="width: 18%;">Amount</th>
                                                        <th style="width: 5%;"><a class="fs-14 cl-amref">+</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                        <td class="padded">{{index+1}}</td>
                                                        <td class="padded">{{purchase_form.items[index].brand}} | {{purchase_form.items[index].brand_sector}} | {{purchase_form.items[index].unit_weight}}{{purchase_form.items[index].measure_unit_sympol}}</td>
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
                                                        <td class="padded">
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
                                                            <textarea v-model="purchase_form.message" class="width-100-pc report-filters-inputs min-height-60"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="inlineBlock width-100-pc">
                                                        <span class="fs-13 fw-600">Memo</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="purchase_form.memo" class="width-100-pc report-filters-inputs min-height-60"></textarea>
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
                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> {{purchase_form.action_taken}}</span>
                                </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a v-if="check_permissions('approve.purchase')" @click="save_po('Save & Send')" class="dropdown-item"> Save & Send</a>
                                <a v-if="!check_permissions('approve.purchase')" @click="save_po('Save & Forward')" class="dropdown-item"> Save & Forward</a>
                                <a @click="save_po('Save & New')" class="dropdown-item"> Save & New</a>
                                <a @click="save_po('Save & Close')" class="dropdown-item"> Save & Close</a>
                            </div>
                        </div>
                    </div>
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
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {PURCHASES_PO_URL} from '../../../../../../router/api_routes';
    import Auth from '../../../../../../store/auth'
    export default {
        props: ['modal_id','modal_title','practice_id','po_number','initializations','organ_data'],
        components: {SearchItemField,SupplierModal},
        data(){
            return {
                current_branch: {},
                processing: false,
                purchase_form: {
                    action_taken: 'Save',
                    source_type: 'web',
                    purchase_type: 'LPO',
                    practice_id: '',
                    delivery_id: '',
                    staff_id: '',
                    supplier_emails: '',
                    mailing_address: '',
                    shipping_address: '',
                    po_date: '',
                    po_due_date: '',
                    message: '',
                    memo: '',
                    supplier_id: '',
                    discount_offered: 0,
                    cash_paid: 0,
                    cash_balance: 0,
                    description: '',
                    po_no: '',
                    total_bill: 0,
                    total_grand: 0,
                    status: '',
                    facility_id: this.practice_id,
                    items: []
                },
                searched_products_list: [],
                supplier_str: '',
                facility_str: '',
            }
        },
        watch: {
            initializations: function(new_in,old_in){
                this.initializations = new_in;
            }
        },
        methods: {

            requestVendorForm(){
                this.$emit('requestVendorForm');
            },

            setFields(event,type_){
                console.info(this.organ_data);
                switch(type_){
                    case "supplier":
                        for( let k = 0; k < this.initializations.suppliers.length; k++ ){
                            if(this.initializations.suppliers[k].id === event.target.value){

                                this.supplier_str = this.initializations.suppliers[k].title+' '+
                                this.initializations.suppliers[k].first_name+' '+
                                this.initializations.suppliers[k].other_name+',<br>'+
                                this.initializations.suppliers[k].company+',<br>'+this.initializations.suppliers[k].address+',<br>'
                                +this.initializations.suppliers[k].postal_code+' '+this.initializations.suppliers[k].city+' '+
                                this.initializations.suppliers[k].country;
                                this.purchase_form.supplier_emails = this.initializations.suppliers[k].email;
                                this.purchase_form.mailing_address = this.supplier_str;
                                break;
                            }
                        }
                        break;
                    case "facility":
                        for( let k = 0; k < this.initializations.facilities.length; k++ ){
                            if(this.initializations.facilities[k].id === event.target.value){
                                this.facility_str = '<span class="txt-uppercase fs-11 fw-600">'+this.organ_data.data.facility.name+'</span>'+',<br>'
                                +'<span class="fw-600 cl-444">'+this.initializations.facilities[k].name+'</span>,<br>'+
                                ''+this.initializations.facilities[k].address+',<br>'
                                +this.initializations.facilities[k].postal_code+' '+this.initializations.facilities[k].city+' '+
                                this.initializations.facilities[k].country;
                                break;
                            }
                        }
                        break;
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            save_po(action_taken){
                this.processing = true;
                this.purchase_form.action_taken = action_taken;
                post(PURCHASES_PO_URL,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            //this.purchase_form = reset_forms(this.purchase_form);
                            this.$emit('poAdded');
                            if(this.purchase_form.action_taken==="Save & Close"){
                                $("#"+this.modal_id).modal('hide');
                            }
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
            add_search_item_invoice(item_product){
                this.purchase_form = add_search_item(item_product, this.purchase_form)
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form);
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){
            this.current_branch = Auth.getCurrentAccount('work_place');
            this.purchase_form.practice_id = this.practice_id;
            this.purchase_form.staff_id = Auth.getCurrentAccount('staff_id');
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


