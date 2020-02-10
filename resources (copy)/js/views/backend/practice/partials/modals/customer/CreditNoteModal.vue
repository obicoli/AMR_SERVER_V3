<template>

    <div v-if="loded" class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content">

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
                                                            <label class="fullname fw-600 fs-14 text-right">Credit Note Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Credit Note#.&nbsp;&nbsp;</label>
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
                                                            <label class="company-label text-right fs-12 width-100-pc">Credit Note Date:&nbsp;&nbsp;</label>
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
                                                    <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Sales Order Due Date:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <datetime 
                                                                    v-model="purchase_form.due_date"
                                                                    :input-id="'date_input_'"
                                                                    placeholder="select date"
                                                                    use12-hour
                                                                    :type="'date'"
                                                                    :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                    :value="purchase_form.due_date"
                                                                    >
                                                                </datetime>
                                                            </div>
                                                        </div>
                                                    </div> -->

                                                    <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">From Quote:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="selected_estimate"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="estimates_list"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="display_as"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-50-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Use an overral Discount:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-50-pc">
                                                            <input type="checkbox" @click="overalDisc($event,'checkbox')" v-model="purchase_form.overal_discount" class="pointer-cursor">
                                                        </div>
                                                    </div>
                                                    <div v-if="purchase_form.overal_discount" class="row fullName mg-bottom-5 mg-left-30 mg-top-5">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Discount(%):&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-30-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.overal_discount_rate" @keyup="overalDisc($event,'input')" v-bind:class="{'height-32':true}" step="any" type="number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Salesperson:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="salesperson"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="salespersons"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="legal_name"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>

                                                <div class="width-35-pc float-right fs-12">
                                                    <!-- <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Payment Terms:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="payment_term"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="payment_terms"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="name"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                    </div> -->
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
                                                <div class="width-40-pc float-left">
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
                                                                    <input v-model="purchase_form.items[index].qty" type="number" min="1" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].qty}">
                                                                </td>
                                                                <td class="inp"><input v-model="purchase_form.items[index].price.pack_retail_price" disabled type="number" @keyup="amend_qty($event,'pack_sp',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'ctm-attended-field':purchase_form.items[index].price.pack_retail_price}" step="any"></td>
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
                                                                <td class="inp"><input v-model="purchase_form.items[index].discount_allowed" type="number" @keyup="amend_qty($event,'discount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true}" step="any"></td>
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
                                                                <input :value="currency+' '+format_money(purchase_form.sub_total)" disabled type="text">
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-secondary banking-process-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> {{purchase_form.action_taken}}</span>
                                </span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a @click="save_credit_note(FORM_ACTIONS.SAVE_DRAFT)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_DRAFT}}</a>
                                <a @click="save_credit_note(FORM_ACTIONS.SAVE_OPEN)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_OPEN}}</a>
                                <a @click="save_credit_note(FORM_ACTIONS.SAVE_NEW)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_NEW}}</a>
                                <a @click="save_credit_note(FORM_ACTIONS.SAVE_CLOSE)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_CLOSE}}</a>
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
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,form_address,format_lunox_date} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {SUPPLIER_PO_URL, CUSTOMERS_ESTIMATES_API} from '../../../../../../router/api_routes';
    import {SHIP_TO,FORM_ACTIONS,TAX_OPTIONS,PAYMENT_OPTIONS} from "../../../../../../helpers/process_status";
    import Auth from '../../../../../../store/auth';
    export default {
        name: "CreditNoteModal",
        props: ['modal_id','modal_title','credit_note_api','taxations','estimate','customer','customers','salespersons','currency','filters','payment_terms'],
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
                
                // bank_account: null,
                // petty_cash: null,
                // inventory: null,
                // selected_supplier:null,
                // account: null,
                // suppliers_list:[],
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
                    //bill_due_date: null,
                    //bill_type: null,
                    terms: '',
                    notes: 'Looking forward for your business',
                    terms_condition: "This estimate is not a contract or a bill. It is our best guess at the total price for the service and goods described above. The customer will be billed after indicating acceptance of this estimate. Payment will be due prior to the delivery of service and goods. Please fax or mail the signed estimate to the address listed above",
                    ledger_account_id: null,
                    supplier_invoice_number: null,
                    items: [],
                    total_discount: 0,
                    cash_paid: 0,
                    cash_balance: 0,
                    sub_total: 0,
                    //total_bill: 0,
                    //total_grand: 0,
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
                salesperson: null,
                detailed_estimate: null,
                selected_customer: null,
                payment_term:null,
                selected_estimate: null,
                estimates_list: [],
                customers_list: [],
                //estimates_list: [],
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
            selected_estimate: function(){
                // console.info('===================');
                // console.info(this.selected_estimate);
                // console.info('===================');
                if(this.selected_estimate){
                    //this.setForm();
                    this.loadEst(this.selected_estimate.id);
                }
            },
            estimate: function(new_data,old_data){
                this.selected_estimate = new_data;
                this.loadEst(new_data.id);
            }
        },
        methods: {

            reset_tax(event){
                if(event.target.value !== TAX_OPTIONS.INCLUSIVE){
                    for (let index = 0; index < this.purchase_form.items.length; index++) {
                        this.purchase_form.items[index].applied_tax_rates = [];
                    }
                }
                this.purchase_form = amend_totals(event,'taxation_option',0,0,0,0,this.purchase_form,'wholesale',this.taxations);
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
                    this.purchase_form.sub_total = this.selected_estimate.grand_total - this.selected_estimate.total_tax - this.selected_estimate.total_discount
                    this.purchase_form.total_tax = this.selected_estimate.total_tax;
                    this.purchase_form.overal_discount = this.selected_estimate.overal_discount;
                    this.purchase_form.overal_discount_rate = this.selected_estimate.overal_discount_rate;
                    this.purchase_form.total_discount = this.selected_estimate.total_discount;
                    // this.purchase_form.grand_total = this.selected_estimate.grand_total-this.selected_estimate.total_tax;
                    this.purchase_form.grand_total = this.selected_estimate.grand_total
                    this.purchase_form.net_total = this.selected_estimate.net_total;
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

            save_credit_note(action_taken){
                this.processing = true;
                this.purchase_form.action_taken = action_taken;
                this.purchase_form.currency = this.currency;
                if(this.selected_estimate){ this.purchase_form.estimate_id = this.selected_estimate.id; }
                if(this.payment_term){ this.purchase_form.payment_term_id = this.payment_term.id; }
                //if(this.inventory){ this.purchase_form.ledger_account_id = this.inventory.id; }
                if(this.selected_customer){ this.purchase_form.customer_id = this.selected_customer.id;}
                if(this.salesperson){ this.purchase_form.salesperson_id = this.salesperson.id }
                //if(this.account){ this.purchase_form.payment.ledger_account_id = this.account.id }
                post(this.credit_note_api,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            //this.purchase_form = reset_forms(this.purchase_form);
                            this.$emit('create-credit_note-event');
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
                        console.info(this.detailed_estimate.items);
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
            //     this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase');
            // },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                //this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase');
                if(type_ === 'taxation'){
                    if(event.target.checked){
                        //Push into array
                        this.purchase_form.items[index].applied_tax_rates = [];
                        this.purchase_form.items[index].applied_tax_rates.push(event.target.value);
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'wholesale',this.taxations);
                    }else{
                        //Remove from array
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'wholesale',this.taxations);
                    }
                }else{
                    this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'wholesale',this.taxations);
                }
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){
            if(this.estimate){
                this.loadEst(this.estimate.id);
                this.selected_estimate = this.estimate;
                
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
        max-width: 1200px!important;
        min-width: 1000px!important;
    }
    .modal-header h4 {
        font-size: 20px!important;
    }
    .modal-content{
        top: 100px;
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


