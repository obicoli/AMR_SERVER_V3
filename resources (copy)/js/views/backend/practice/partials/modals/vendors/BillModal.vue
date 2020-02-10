<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_bill" class="modal-content">

                <div class="modal-header bg-eee text-left">
                    <h4 class="width-100-pc text-left"><img src="/assets/icons/dashboard/bill_icon.png"> {{modal_title}}</h4>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">
                    
                    <div class="row mg-top-20 justify-content-center">

                        <div class="col-lg-12 col-md-12">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div id="inner_invoice_area">

                                        <div class="col-md-12 set-no-padding">

                                            <div class="width-100-pc float-left fs-12 bg-f4 padding-20">

                                                <div class="width-30-pc float-left fs-12">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Supplier:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="selected_supplier"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="suppliers"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="legal_name"
                                                                ></vue-single-select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
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
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Bill Number#:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.bill_number" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Order No:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input v-model="purchase_form.order_number" class="width-100-pc report-filters-inputs" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="width-30-pc float-right fs-12">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Bill Date:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
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
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Bill Due Date:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-70-pc">
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
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Bill Type:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-70-pc">
                                                                <select  v-model="purchase_form.bill_type">
                                                                    <option value="">-select-</option>
                                                                    <option :value="PAYMENT_OPTIONS.CASH">{{PAYMENT_OPTIONS.CASH}}</option>
                                                                    <option :value="PAYMENT_OPTIONS.CREDIT">{{PAYMENT_OPTIONS.CREDIT}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-if="purchase_form.bill_type===PAYMENT_OPTIONS.CASH" class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Invoice No&nbsp;&nbsp;<i class="fa fa-info-circle pointer-cursor" title="Invoice number provided by supplier"></i>.&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-70-pc">
                                                                <input v-model="purchase_form.supplier_invoice_number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-30-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Inventory:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-70-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <vue-single-select
                                                                    name="maybe"
                                                                    placeholder=""
                                                                    you-want-to-select-a-post="ok"
                                                                    v-model="inventory"
                                                                    out-of-all-these-posts="makes sense"
                                                                    :options="inventories"
                                                                    a-post-has-an-id="good"
                                                                    the-post-has-a-title="make"
                                                                    option-label="name"
                                                                ></vue-single-select>
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
                                                <div class="width-100-pc float-left fs-12 bg-f4 padding-20 mg-bottom-20">
                                                    <a class="fs-12">Include <span class="cl-blue-link">2 open Purchase Orders</span></a>
                                                </div>
                                            </div>

                                            <div class="width-100-pc float-left fs-12 bg-f4 padding-20 mg-bottom-20">
                                                <div v-if="purchase_form.bill_type===PAYMENT_OPTIONS.CASH" class="width-25-pc float-left mg-right-20">
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc text-right">
                                                            <label class="fullname fw-600 fs-14 text-right">Payment Details</label>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-2 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Payment Method:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <select  v-model="purchase_form.payment.payment_method">
                                                                    <option value="">-select-</option>
                                                                    <option :value="PAYMENT_OPTIONS.CASH">{{PAYMENT_OPTIONS.CASH}}</option>
                                                                    <option :value="PAYMENT_OPTIONS.CHEQUE">{{PAYMENT_OPTIONS.CHEQUE}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div v-if="purchase_form.payment.payment_method===PAYMENT_OPTIONS.CHEQUE" class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-100-pc mg-bottom-2">
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
                                                                    placeholder="select account"
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
                                                    </div>
                                                    <div v-else></div>

                                                    <div class="row fullName mg-bottom-5 mg-left-30 mg-top-20">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Amount Paid:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input @keyup="amend_qty($event,'cash_paid',0,0,0,index)" v-model="purchase_form.payment.cash_paid" required v-bind:class="{'height-32':true,'custom-attended-field':purchase_form.payment.payment_method}" type="number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fullName mg-bottom-5 mg-left-30">
                                                        <div class="inlineBlock width-40-pc text-right">
                                                            <label class="company-label text-right fs-12 width-100-pc">Balance:&nbsp;&nbsp;</label>
                                                        </div>
                                                        <div class="inlineBlock width-60-pc">
                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                <input :value="currency+' '+format_money(purchase_form.payment.cash_balance)" disabled type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else></div>

                                                <div v-if="purchase_form.bill_type===PAYMENT_OPTIONS.CASH" class="width-25-pc float-left padding-top-30">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <textarea v-model="purchase_form.notes" placeholder="Payment description" v-bind:class="{'width-100-pc report-filters-inputs min-height-60':true}"></textarea>
                                                    </div>
                                                </div>
                                                <div v-else class="width-25-pc float-left padding-top-30">
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <textarea v-model="purchase_form.notes" placeholder="Notes" v-bind:class="{'width-100-pc report-filters-inputs min-height-60':true}"></textarea>
                                                    </div>
                                                </div>

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
                                <a v-if="purchase_form.bill_type===PAYMENT_OPTIONS.CREDIT" @click="save_bill(FORM_ACTIONS.SAVE_DRAFT)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_DRAFT}}</a>
                                <a v-if="purchase_form.bill_type===PAYMENT_OPTIONS.CREDIT" @click="save_bill(FORM_ACTIONS.SAVE_OPEN)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_OPEN}}</a>
                                <a v-if="purchase_form.bill_type===PAYMENT_OPTIONS.CASH" @click="save_bill(FORM_ACTIONS.SAVE_NEW)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_NEW}}</a>
                                <a v-if="purchase_form.bill_type===PAYMENT_OPTIONS.CASH" @click="save_bill(FORM_ACTIONS.SAVE_CLOSE)" class="dropdown-item pointer-cursor"> {{FORM_ACTIONS.SAVE_CLOSE}}</a>
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
    import {SUPPLIER_PO_URL} from '../../../../../../router/api_routes';
    import {SHIP_TO,FORM_ACTIONS,TAX_OPTIONS,PAYMENT_OPTIONS} from "../../../../../../helpers/process_status";
    import Auth from '../../../../../../store/auth';
    export default {
        props: ['modal_id','modal_title','bill_api','taxations','bank_accounts','accounts','inventories','petty_cashes','currency','billable','order','filters','billable_type','supplier','suppliers','payment_terms'],
        components: {SearchItemField,SupplierModal},
        data(){
            return {
                //current_branch: {},
                processing: false,
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

                purchase_form: {
                    action_taken: 'Save',
                    order_number: null,
                    bill_number: null,
                    supplier_id: null,
                    taxation_option: null,
                    trans_date: null,
                    due_date: null,
                    bill_type: null,
                    terms: null,
                    notes: null,
                    ledger_account_id: null,
                    supplier_invoice_number: null,
                    items: [],
                    total_discount: 0,
                    cash_paid: 0,
                    cash_balance: 0,
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

            setBill(){
                if(this.billable){

                }else{
                    this.purchase_form.trans_date = format_lunox_date(this.filters.today);
                    this.purchase_form.due_date = format_lunox_date(this.filters.today);
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            save_bill(action_taken){

                this.processing = true;
                this.purchase_form.action_taken = action_taken;
                this.purchase_form.currency = this.currency;
                //if(this.supplier){ this.purchase_form.supplier_id = this.supplier.id; }
                if(this.payment_term){ this.purchase_form.payment_term_id = this.payment_term.id; }
                if(this.inventory){ this.purchase_form.ledger_account_id = this.inventory.id; }
                if(this.selected_supplier){ this.purchase_form.supplier_id = this.selected_supplier.id;}
                if(this.bank_account){ this.purchase_form.payment.bank_account_id = this.bank_account.id }
                if(this.account){ this.purchase_form.payment.ledger_account_id = this.account.id }

                post(this.bill_api,this.purchase_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            //this.purchase_form = reset_forms(this.purchase_form);
                            this.$emit('create-bill-event');
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
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                    }else{
                        //Remove from array
                        this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                    }
                }else{
                    this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form,'purchase',this.taxations);
                }
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){
            this.setBill();
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


