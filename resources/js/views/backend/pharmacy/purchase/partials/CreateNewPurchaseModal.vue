<template>

    <div class="modal-content">
        <form @submit.prevent="save_purchase">
            <div class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-info-circle"></i> Create new purchase</h4>
                <a data-dismiss="modal"><i class="fa fa-plus-square-o"></i> </a>
            </div>
            <div  class="modal-body">

                <section class="content">

                    <div class="row">
                        <div class="col-md-12 padding-left-0 padding-right-0">

                            <div class="col-md-12">
                                <h4 class="purchase-heading"><i class="fa fa-check-circle"></i> General Detail :</h4>
                            </div>

                            <div class="col-md-6">

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Branch:</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input type="text" v-model="purchase_form.practice_id" list="branch_list"  @change="set_auto_complete('branch')" class="form-control product-entry-input-field" id="selected_branch">
                                        <datalist id="branch_list">
                                            <option v-for="pharmacy_branch in pharmacy_branches" :data-value="pharmacy_branch.id" :value="pharmacy_branch.name"></option>
                                        </datalist>
                                    </div>
                                </div>

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Department:</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input type="text" v-model="purchase_form.department_id" list="department_list" @change="set_auto_complete('department')" class="form-control product-entry-input-field" id="selected_department">
                                        <datalist id="department_list">
                                            <option v-for="departmen in departments" :data-value="departmen.id" :value="departmen.name"></option>
                                        </datalist>
                                    </div>
                                </div>

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Store:</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input type="text" list="store_list" @change="set_auto_complete('store')" class="form-control product-entry-input-field" id="selected_store">
                                        <datalist id="store_list">
                                            <option v-for="stor in storesy" :data-value="stor.id" :value="stor.name"></option>
                                        </datalist>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Account Holders: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="who is the provider of puchasing items"></i></small></label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
<!--                                        <input type="text" list="supplier_list" @change="set_auto_complete('supplier')" placeholder="Start typing to select" class="form-control product-entry-input-field" id="selected_supplier">-->
                                        <input type="text" v-model="purchase_form.supplier_id" list="supplier_list" @change="set_auto_complete('supplier')" placeholder="Start typing to select" class="form-control product-entry-input-field" id="selected_supplier">
                                        <datalist id="supplier_list">
                                            <option v-for="account_holder in account_holders" :data-value="account_holder.id" :value="account_holder.company_name"></option>
                                        </datalist>
                                    </div>
                                </div>

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Bill number:</label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input type="text" v-model="purchase_form.bill_no" class="form-control product-entry-input-field">
                                    </div>
                                </div>

                                <div class="row form-group mg-bottom-10">
                                    <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                        <label class="fs-14 cl-888">Any description: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="any description you want to add for future help."></i></small></label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <textarea v-model="purchase_form.description" class="form-control product-entry-input-field"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padding-left-0 padding-right-0">
                            <div class="col-md-12">
                                <h4 class="purchase-heading mg-top-10"><i class="fa fa-check-circle"></i> Create purchase items :
                                    <small >Create a purchase for purchasing purpose.</small>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mg-bottom-10">
                                    <label><i aria-hidden="true" class="fa fa-barcode"></i> SCAN BARCODE OR SEARCH ITEMS</label>
                                    <input type="text" class="form-control input-lg" @keyup="search_things($event,'practice_product_item')" id="barcode_scan_area" name="search_area" autofocus="autofocus"/>
                                    <div id="search_id_result_manual">
                                        <ul v-if="searched_products_list.length > 0" class="search_result">
                                            <li @click="close_search_result()" class="cross_search_result"><i class="fa fa-times" aria-hidden="true"></i></li>
                                            <li v-for="searched_products_li in searched_products_list" @click="add_search_item_invoice(searched_products_li)">{{searched_products_li.item_name}} | {{searched_products_li.generic_name}} | {{searched_products_li.item_code}} | {{searched_products_li.single_unit_weight}} {{searched_products_li.product_unit_slug}} | Stock {{searched_products_li.item_stock}}  | Price {{searched_products_li.unit_retail_price}}  | Whole sale {{searched_products_li.pack_cost}}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padding-left-0 padding-right-0">
                            <div  id="inner_invoice_area">

                                <div class="col-md-12 set-no-padding">
                                    <table class="items table-hover table table-striped table-bordered table_height_set">
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
                                        <tr v-for="(item, index) in purchase_form.items">

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
                                                <input type="number" v-model="purchase_form.items[index].pack_retail" @keyup="amend_qty($event,'pack_retail',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id)"class="form-control product-entry-input-field height-27" step="any">
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
                                                <a title="Remove" ><i class="fa fa-trash-o" aria-hidden='true'></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="purchase-heading border-radius-0"><i class="fa fa-check-circle"></i>  Purchase Detail :</h4>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Total: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="mention the amount of total bill"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="number" v-model="purchase_form.total_bill" step="any" class="form-control product-entry-input-field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Offered Discount%:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.discount_offered" @keyup="amend_qty($event,'discount','','','')" type="number" step="any" class="form-control product-entry-input-field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Grand Total: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="mention the amount of total bill"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.total_grand" type="number" step="any" class="form-control product-entry-input-field">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Upload Bill Image: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="capture or scan bill image"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="file" name="pur_picture" data-validate="required" class="form-control product-entry-input-field" data-message-required="Value Required">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="purchase-heading"><i class="fa fa-check-circle"></i>  Payment Detail :</h4>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Payment Method: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="method of payment cash or cheque"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <select @change="payment_method($event)" required v-model="purchase_form.payment_method_id" class="form-control product-entry-input-field">
                                        <option selected disabled value="">select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Payment Date: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="date of bill paid"></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="date" v-model="purchase_form.payment_date" required class="form-control product-entry-input-field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Cash Paid: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="how much you paid against total bill."></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.cash_paid" type="number" step="any" @keyup="amend_qty($event,'cash_paid','','','')" class="form-control product-entry-input-field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Balance: <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" title="remaing amount you need to pay in future."></i></small></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.cash_balance" type="number"step="any" class="form-control product-entry-input-field">
                                </div>
                            </div>

                            <div v-if="is_bank_payment" class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Bank account:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <select v-model="purchase_form.practice_bank_id" class="form-control product-entry-input-field">
                                        <option selected disabled value="">Bank account</option>
                                        <option v-for="banky in banks" :value="banky.id">{{banky.bank_name}}, {{banky.state}} | Title: {{banky.account_name}} | Ac: {{banky.account_number}} | Branch: {{banky.branch_name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div v-if="is_bank_payment" class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Cheque No:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input v-model="purchase_form.cheque_number" type="text" class="form-control product-entry-input-field">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </section>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Processing...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save purchase </span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    Close
                </button>
            </div>
        </form>
    </div>
    
</template>

<script>
    import {post,get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "CreateNewPurchaseModal",
        props: ['branch_id'],
        data(){
            return {
                products_list: [],
                searched_products_list: [],
                pharmacy_branches: [],
                departments: [],
                account_holders: [],
                storesy: [],
                banks: [],
                pharmacy_branch: {},
                practice_id: '',
                is_bank_payment: false,
                processing: false,
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
            }
        },
        methods: {

            save_purchase(){

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

            search_things(event, things_type){
                let url_search = AppInfo.app_data.server_domain+'/api/search/'+things_type;
                let formData = new FormData();
                formData.append('name',event.target.value);
                formData.append('practice_id',this.practice_id);
                post(url_search, formData)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            switch (things_type) {
                                case "practice_product_item":
                                    this.searched_products_list = res.data.results;
                                    //console.info(this.searched_products_list);
                                    break;
                            }
                        }
                    }).catch((err) => {

                });
            },

            loadBranches: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/branches/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.pharmacy = res.data.results;
                            this.pharmacy_branches = res.data.results;
                            //console.info(res.data.results);
                            //this.initializers();
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

            loadBranch: function (branch_id) {

                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+branch_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.pharmacy = res.data.results;
                            this.pharmacy_branch = res.data.results;
                            //console.info(res.data.results);
                            //this.initializers();
                            this.departments = this.pharmacy_branch.departments;
                            this.storesy = this.pharmacy_branch.stores;
                            //storesy: [],
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

            load_suppliers: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Account Holders')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.account_holders = res.data.results;
                            console.info(this.account_holders);
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

            close_search_result(){
                this.searched_products_list = [];
            },
            add_search_item_invoice(item_product){

                //console.info(item_product.id);
                let add_item = true;
                for ( let i = 0; i < this.purchase_form.items.length; i++ ){
                    if (this.purchase_form.items[i].practice_product_item_id === item_product.id){
                        add_item = false;
                        break;
                    }
                }
                if (add_item){

                    let item = {
                        batch_number: '',
                        exp_month: '',
                        exp_year: '',
                        man_month: '',
                        man_year: '',
                        status: '',
                        practice_product_item_id: '',
                        product_purchase_id: '',
                        practice_id: '',
                        qty: 0,
                        unit_name: '',
                        unit_cost: 0,
                        unit_retail: '',
                        pack_cost: '',
                        pack_retail: '',
                        unit_weight: '',
                        unit_measure_type: '',
                    };
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
                this.close_search_result();

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
            set_auto_complete(type_){

                switch (type_) {
                    case "supplier":
                        let value = $('#selected_supplier').val();
                        let supplier_id = $('#supplier_list [value="' + value + '"]').data('value');
                        if (supplier_id !== "") {
                            this.purchase_form.supplier_id = supplier_id;
                        }
                        break;
                    case "branch":
                        let value1 = $('#selected_branch').val();
                        let branch_id = $('#branch_list [value="' + value1 + '"]').data('value');
                        if (branch_id !== "") {
                            this.purchase_form.practice_id = branch_id;
                            this.loadBranch(branch_id);
                        }
                        break;
                    case "department": //department_list
                        let value2 = $('#selected_department').val();
                        let department_id = $('#department_list [value="' + value2 + '"]').data('value');
                        if (department_id !== "") {
                            this.purchase_form.department_id = department_id;
                        }
                        break;
                    case "store":
                        let value3 = $('#selected_store').val();
                        let store_id = $('#store_list [value="' + value3 + '"]').data('value');
                        if (store_id !== "") {
                            this.purchase_form.store_id = store_id;
                        }
                        break;
                }
            },

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadBranches();
            this.load_suppliers();
        }
    }
</script>

<style scoped>
    .purchase-heading
    {
        background-color: #787887;
        color: #fff!important;
        font-size: 15px!important;
        font-weight: 600!important;
        padding-top: 5px!important;
        padding-bottom: 5px!important;
        border-radius: 2px!important;
        min-height: 40px!important;
    }
    .purchase-heading small{
        color: #fff!important;
    }
    .header_row a
    {
        color: #4a6984;
    }

    .btn-info,
    .bg-aqua,
    .callout.callout-info,
    .alert-info,
    .label-info,
    .modal-info .modal-body,
    .stellarnav.light,
    .stellarnav.light ul ul,
    .stellarnav.mobile.light ul,
    .username-bg,
    ::-webkit-scrollbar,
    ::-webkit-scrollbar-thumb
    {
        background-color: #4a6984	}
    .btn-info
    {
        background-color: #4a6984;
        border-color: #1f5788;
    }
    .btn-info:hover
    {
        background-color: #1f5788;
    }
    .box.box-info
    {
        border-top-color: #4a6984	}
    .box
    {
        border-top: 3px solid #4a6984;
    }
    .pagination>.active>a,
    .pagination>.active>a:focus,
    .pagination>.active>a:hover,
    .pagination>.active>span,
    .pagination>.active>span:focus,
    .pagination>.active>span:hover
    {
        background-color: #4a6984;
        border-color: #1f5788;
    }
</style>