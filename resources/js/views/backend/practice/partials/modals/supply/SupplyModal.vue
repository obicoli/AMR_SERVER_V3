<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="submit_request" class="modal-content">

                <div class="modal-header bg-foo">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">

                    <div class="row justify-content-center bg-foo">
                        <div class="col-lg-12">
                            <div class="alert alert-danger fs-13 mg-top-10" role="alert">
                                <strong>General details:</strong> Select Facility/Region where you are supplying.
                            </div>
                            <div class="width-40-pc float-left padding-top-10 padding-bottom-10">
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-2">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Facility:<span class="cl-amref">*</span> </label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-2">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select @change="set_variable($event,'facility')" required v-model="purchase_form.branch_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase_form.branch_id}">
                                                <option value="" selected disabled>-select-</option>
                                                <option v-for="(facility_lis, index) in initializations.facilities" :value="facility_lis.id" :key="'practice_list'+index">{{facility_lis.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Store:<span class="cl-amref">*</span></label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="purchase_form.store_id" required v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase_form.store_id}">
                                                <option selected disabled value="">-select-</option>
                                                <option v-for="(store_lis, index) in initialization.stores" :value="store_lis.id" :key="'store_list'+index">{{store_lis.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Department:<span class="cl-amref">*</span></label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select required v-model="purchase_form.department_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase_form.department_id}">
                                                <option value="">-select-</option>
                                                <option v-for="(departs, index) in initialization.departments" :value="departs.id" :key="'departs_list'+index">{{departs.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Sub-store:</label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="purchase_form.sub_store_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase_form.sub_store_id}">
                                                <option value="">-select-</option>
                                                <option v-for="(sub_store_lis, index) in initialization.sub_stores" :value="sub_store_lis.id" :key="'practice_list'+index">{{sub_store_lis.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="width-40-pc float-left padding-top-10 padding-bottom-10">
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Driver:</label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="purchase_form.driver_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase_form.driver_id}">
                                                <option value="">-select-</option>
                                                <option v-for="(driv, index) in initializations.drivers" :value="driv.id" :key="'practice_list'+index">{{driv.first_name}} {{driv.last_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Supply Vehicle:</label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="purchase_form.vehicle_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase_form.vehicle_id}">
                                                <option value="">-select-</option>
                                                <option v-for="(vehicl, index) in initializations.vehicles" :value="vehicl.id" :key="'practice_list'+index">{{vehicl.name}} | {{vehicl.number}} | {{vehicl.vid}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Supply description:</label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="purchase_form.note" v-bind:class="{'width-100-pc report-filters-inputs min-height-60':true,'ctm-attended-field':purchase_form.note}"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="row mg-top-20 justify-content-center">

                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="inner_invoice_area">
                                        <div class="col-md-12 set-no-padding">
                                            <search-item-form-control v-on:itemFound="add_search_item_invoice" :practice_id="selected_practice_id" :show_label="true" :search_result_width="1000" :search_result_min_height="400" :search_type="'Batched Product Item'"></search-item-form-control>
                                            <h4 class="fs-12 cl-787887">Create a list of items and the number to be transferred.</h4>
                                            <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 2%;"></th>
                                                        <th style="width: 10%;">Code</th>
                                                        <th style="width: 10%;">Item</th>
                                                        <th style="width: 7%;">Weight</th>
                                                        <th style="width: 7%;">Pack(size)</th>
                                                        <th style="width: 8%;">W-sale(KES)</th>
                                                        <th style="width: 8%;">Packs</th>
                                                        <th style="width: 18%;">Batch</th>
                                                        <th style="width: 11%;">Qty</th>
                                                        <th style="width: 7%;">Disc(%)</th>
                                                        <th style="width: 10%;">Amount(Kes)</th>
                                                        <th style="width: 2%;"><a title="Add Item" class="fs-14 cl-amref pointer-cursor">+</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                        <td class="padded">{{index+1}}</td>
                                                        <td class="padded">{{purchase_form.items[index].sku_code}}</td>
                                                        <td class="padded">{{purchase_form.items[index].item_name}}</td>
                                                        <td class="padded">{{purchase_form.items[index].unit_weight}}{{purchase_form.items[index].measure_unit_sympol}}</td>
                                                        <td class="padded">{{purchase_form.items[index].pack_qty}}</td>
                                                        <td class="padded">{{format_money(purchase_form.items[index].pack_retail)}}</td>
                                                        <td><input v-model="purchase_form.items[index].qty" type="number" required step="any" min="1" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index,'supply')" v-bind:class="{'form-control height-24':true,'ctm-attended-field':purchase_form.items[index].qty}"></td>
                                                        <td>
                                                            <multiselect v-model="purchase_form.items[index].default_batched_stock" tag-placeholder="Add this Batch" placeholder="Search Batch" label="name" track-by="id" :options="purchase_form.items[index].batched_stock" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                                        </td>
                                                        <td class="padded">
                                                            {{format_money(purchase_form.items[index].sub_stock_total)}}
                                                        </td>
                                                        <td><input v-model="purchase_form.items[index].discount_allowed" min="0" type="number" required step="any" @keyup="amend_qty($event,'discount_allowed',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index,'supply')" v-bind:class="{'form-control height-24':true,'ctm-attended-field':purchase_form.items[index].discount_allowed}"></td>
                                                        <td class="padded text-right">{{format_money(purchase_form.items[index].amount)}}</td>

                                                        <td class="padded">
                                                            <a title="Remove" @click="amend_qty($event,'remove',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index,'supply')" class="pointer-cursor cl-red">x</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="fw-600 text-right">Total:</td>
                                                        <td colspan="3" class="fw-600 text-right total-field">{{format_money(purchase_form.total_grand)}}</td>
                                                        <td class="total-field"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-lg-6 padding-left-30 padding-right-30">
                            <div class="width-100-pc bg-foo min-height-80 padding-10 mg-bottom-5">
                                <div class="form-group">
                                    <label class="fs-14 fw-600 cl-444">Account</label>
                                    <select class="form-control height-32">
                                        <option></option>
                                    </select>
                                    <small class="cl-787887 fs-12">Make sure to select right facility/customer whom your are suppling, to maintain his/her accounts.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-lg-6 padding-left-30 padding-right-30">
                            <div class="width-100-pc bg-foo mg-bottom-5 min-height-80">
                                <div class="width-30-pc float-left">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Gross Total(KES):</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="purchase_form.total_bill" type="number" step="any" required v-bind:class="{'width-100-pc report-filters-inputs height-32':true,'ctm-attended-field':purchase_form.total_bill}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-30-pc float-left">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Tax Total(KES):</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="number" min="0" v-model="purchase_form.total_tax" step="any" required v-bind:class="{'width-100-pc report-filters-inputs height-32':true,'ctm-attended-field':purchase_form.total_tax}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-30-pc float-left">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Total Bill(KES):</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="purchase_form.total_grand" min="0" type="number" step="any" required v-bind:class="{'width-100-pc report-filters-inputs height-32':true,'ctm-attended-field':purchase_form.total_grand}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-lg-6 padding-left-30 padding-right-30">
                            <div class="width-100-pc bg-foo mg-bottom-5 min-height-80">
                                <div class="width-30-pc float-left">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Discount(KES):</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="number" min="0" v-model="purchase_form.discount_offered" step="any" required v-bind:class="{'width-100-pc report-filters-inputs height-32':true,'ctm-attended-field':purchase_form.discount_offered}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-30-pc float-left">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Total(after dis)(KES):</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="number" min="0" v-model="purchase_form.total_grand" step="any" required v-bind:class="{'width-100-pc report-filters-inputs height-32':true,'ctm-attended-field':purchase_form.total_grand}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-30-pc float-left">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Previous(KES):</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="number" min="0" disabled step="any" required class="width-100-pc report-filters-inputs height-32">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-lg-6">
                            <div class="row bg-foo mg-bottom-5 mg-right-15 mg-left-15">
                                <div class="col-md-12">
                                    <div class="alert alert-danger fs-13 mg-top-10" role="alert">
                                        <strong>Invoice Detail:</strong> Write description or details of amount received.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Payment Method</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select @change="payment_method($event)" required v-model="purchase_form.payment_method_id" v-bind:class="{'report-filters-inputs':true,'ctm-attended-field':purchase_form.payment_method_id}">
                                                    <option selected disabled value="">select</option>
                                                    <option v-for="(item,index) in initializations.payment_methods" :value="item.id" :key="'payment_methods'+index">{{item.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Cash Paid (KES)</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="number" min="0" v-model="purchase_form.cash_paid" @keyup="amend_qty($event,'cash_paid','','','','','')" step="any" required v-bind:class="{'report-filters-inputs':true,'ctm-attended-field':purchase_form.cash_paid}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Balance (KES)</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input type="number" min="0" v-model="purchase_form.cash_balance" disabled step="any" required v-bind:class="{'report-filters-inputs':true,'ctm-attended-field':purchase_form.cash_balance}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="is_bank_payment" class="col-md-7">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Deposit/Widthdrawal account:</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select v-model="purchase_form.bank_id" v-bind:class="{'report-filters-inputs':true,'ctm-attended-field':purchase_form.bank_id}">
                                                    <option selected disabled value="">Bank account</option>
                                                    <option v-for="(banky,index) in initializations.banks" :value="banky.id" :key="'banky'+index">{{banky.name}}, {{banky.branch}} | Title: {{banky.account_title}} | Ac: {{banky.account_number}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="is_bank_payment" class="col-md-5">
                                    <div class="row fullName margin-5">
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <label class="fs-13 fw-600 width-100-pc padding-right-3">Cheque No:</label>
                                        </div>
                                        <div class="inlineBlock width-100-pc mg-bottom-2">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="purchase_form.cheque_number" v-bind:class="{'report-filters-inputs':true,'ctm-attended-field':purchase_form.cheque_number}" type="text" class="height-27">
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
                            <button id="btnGroupDrop" type="button" class="btn pointer-cursor combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> {{purchase_form.action_taken}}</span>
                                </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a v-if="check_permissions('approve.inv.supply')" @click="submit_request('Save & Print')" class="dropdown-item pointer-cursor"> Save & Print</a>
                                <a v-if="check_permissions('dispatch.inv.supply')" @click="submit_request('Save & Pick')" class="dropdown-item pointer-cursor"> Save & Pick</a>
                                <a v-if="check_permissions('dispatch.inv.supply')" @click="submit_request('Save & Pack')" class="dropdown-item pointer-cursor"> Save & Pack</a>
                                <a v-if="check_permissions('dispatch.inv.supply')" @click="submit_request('Save & Ship')" class="dropdown-item pointer-cursor"> Save & Ship</a>
                                <a v-if="check_permissions('create.inv.supply')" @click="submit_request('Save & New')" class="dropdown-item pointer-cursor"> Save & New</a>
                                <a v-if="check_permissions('create.inv.supply')" @click="submit_request('Save & Close')" class="dropdown-item pointer-cursor"> Save & Close</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop" type="submit" class="btn combo-button combo-default">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing...</span>
                                    <span v-else>Save Invoice</span>
                                </span>
                            </button>
                        </div>
                    </div> -->
                    <button data-dismiss="modal" class="btn combo-button combo-default">
                        Reset
                    </button>
                    <button data-dismiss="modal" class="btn combo-button combo-default">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</template>

<script>
    import SearchItemField from '../../modals/product/SearchItemField';
    import SearchItemFormControl from '../../search/SearchItemFormControl';
    import SupplierModal from '../../modals/vendors/SupplierModal';
    import {createHtmlErrorString,formatMoney,add_search_item,amend_totals,location_obj_setter,check_negatives} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {PURCHASES_PO_URL,PRODUCT_SUPPLY} from '../../../../../../router/api_routes';
    import Auth from '../../../../../../store/auth';
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['modal_id','modal_title','practice_id','po_number','initializations','organ_data','address_ob'],
        components: {SearchItemField,SupplierModal,SearchItemFormControl,Multiselect},
        data(){
            return {
                processing: false,
                is_bank_payment: false,
                purchase_form: {
                    action_taken: 'Save',
                    src_address: this.address_ob.staff_address,
                    branch_id: '',
                    payment_method_id: '',
                    store_id: '',
                    sub_store_id: '',
                    department_id: '',
                    driver_id: '',
                    vehicle_id: '',
                    discount_offered: 0,
                    cash_paid: 0,
                    due_date: '',
                    request_date: '',
                    cash_balance: 0,
                    total_tax: 0,
                    cheque_number: '',
                    note: '',
                    total_bill: 0,
                    total_grand: 0,
                    status: '',
                    items: []
                },
                searched_products_list: [],
                selected_practice_id: '',
                initialization: {},
            }
        },
        watch: {
            initializations: function(new_in,old_in){
                this.initializations = new_in;
            },
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },
            set_variable(event,type_){
                switch(type_){
                    case "facility":
                        this.initialization = location_obj_setter(this.initializations,event.target.value);
                        this.selected_practice_id = event.target.value;
                        break;
                }
            },
            format_money(money_to){
                return formatMoney(money_to);
            },
            submit_request(action_taken){
                this.processing = true;
                this.purchase_form.action_taken = action_taken;
                post(PRODUCT_SUPPLY,this.purchase_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success(res.data.description);
                        this.$emit("successSupply");
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                        
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },

            add_search_item_invoice(item_product){
                this.purchase_form = add_search_item(item_product, this.purchase_form);
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index,price_mode=null){
                check_negatives(event);
                if(type_ === 'cash_paid'){
                    this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,price_mode);
                }else if(this.purchase_form.items[index].qty > this.purchase_form.items[index].stock_total ){
                    this.$awn.warning("Requested quantity("+this.purchase_form.items[index].qty+") exceeds available quantity("+this.purchase_form.items[index].stock_total+")");
                    this.purchase_form.items[index].qty = 0;
                    this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,price_mode);
                }else{
                    this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,price_mode);
                }
            },
            
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            addTag (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.options.push(tag)
                this.value.push(tag)
            },

            payment_method(event){

                for (let index = 0; index < this.initializations.payment_methods.length; index++) {
                    const element = this.initializations.payment_methods[index];
                    if(element.id === event.target.value ){
                        switch(element.name){
                            case "Cash":
                                this.is_bank_payment = false;
                                break;
                            case "Cheque":
                                this.is_bank_payment = true;
                                break;
                            default:
                                this.is_bank_payment = false;
                                break;
                        }
                        break;
                    }
                }
            },

        },

        mounted(){
            this.initialization = location_obj_setter(this.initializations,null);
            this.selected_practice_id = this.practice_id;
            this.current_branch = Auth.getCurrentAccount('work_place');
            this.purchase_form.practice_id = this.practice_id;
            this.purchase_form.staff_id = Auth.getCurrentAccount('staff_id');
        }
        
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss" scoped>
    @import '../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 1250px!important;
        min-width: 1250px!important;
    }
    .modal-header h4 {
        font-size: 20px!important;
    }
    .multiselect{
        border-radius: 2px!important;
    }
    .multiselect__tags {
        min-height: 10px!important;
        display: block;
        padding: 4px 3px 0 4px!important;
        border-radius: 2px;
        border: 1px solid #e8e8e8;
        background: #fff;
        font-size: 12px!important;
        font-weight: 600!important;
    }
</style>


