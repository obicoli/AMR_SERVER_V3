<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">

                    <div class="row">
                        <div class="col-lg-3 padding-left-0 padding-right-0 bd-right bg-eee" style="height:570px;overflow-y:auto; border-right: 1px sold ##787887;">
                            
                            <div class="width-100-pc padding-10" style="background-color: #f7f7f7!important;">
                                <div class="filter-block form-inline">
                                    <div class="filter-group input-group">
                                        <span @click="activeThis(1)" v-bind:class="{'filter':true,'active':active_num===1}">Drugs</span>
                                        <span @click="activeThis(2)" v-bind:class="{'filter':true,'active':active_num===2}">Supplies</span>
                                        <span @click="activeThis(3)" v-bind:class="{'filter':true,'active':active_num===3}">Equipments</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group mg-top-20">
                                        <label><i class="fa fa-barcode" aria-hidden="true"></i> SCAN BARCODE OR SEARCH ITEMS</label>
                                        <input type="text" class="form-control width-200-px" @keyup="search_things($event,'practice_product_item')" autofocus="autofocus" />
                                        <div id="search_id_result_manual">
                                        <ul v-if="searched_products_list.length > 0" class="search_result">
                                            <li @click="close_search_result()" class="cross_search_result"><i class="fa fa-times" aria-hidden="true"></i></li>
                                            <li v-for="(searched_products_li,index) in searched_products_list" @click="add_search_item_invoice(searched_products_li)" :key="'searched_products_li'+index">{{searched_products_li.item_name}} | {{searched_products_li.generic_name}} | {{searched_products_li.item_code}} | {{searched_products_li.single_unit_weight}} {{searched_products_li.product_unit_slug}} | Stock {{searched_products_li.item_stock}}  | Price {{searched_products_li.unit_retail_price}}  | Whole sale {{searched_products_li.pack_cost}}</li>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div v-for="(item, index) in purchase_form.items" class="width-100-pc item-search-list" :key="'items_right_list'+index">
                                <a>
                                    <span>{{purchase_form.items[index].unit_name}} | {{purchase_form.items[index].single_unit_weight}}{{purchase_form.items[index].unit_measure_type}} | {{purchase_form.items[index].generic_name}} | {{purchase_form.items[index].item_code}} | Stock: {{purchase_form.items[index].item_stock}}
                                        <span v-if="purchase_form.items[index].item_stock <= purchase_form.items[index].alert_indicator_level" class="cl-red fs-14 fw-600">Low</span>
                                        <span class="cl-red fs-15 pull-right">x</span>
                                    </span>
                                </a>
                            </div>

                        </div>
                        <div class="col-lg-9">
                            <div class="row">

                                <div class="col-lg-4 bg-greenish padding-10 mg-left-10 mg-top-10">
                                    <div class=" width-100-pc">
                                        <label>From Location:</label>
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc">
                                                <label class="fullname" for="firstName">Branch</label>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                                    <select class="width-100-pc height-27">
                                                        <option disabled selected value="">-select-</option>
                                                        <option>Amref Upper Hill</option>
                                                        <option>Amref Westlands</option>
                                                        <option>Amref Lang'ata</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-50-pc padding-right-3">
                                                <label class="fullname" for="firstName">Store</label>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                                    <select class="width-100-pc height-27">
                                                        <option disabled selected value="">-select-</option>
                                                        <option>KMO Main Store</option>
                                                        <option>Westlands Stores</option>
                                                        <option>Upper Hill Store</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-50-pc">
                                                <label class="fullname" for="firstName">Sub store</label>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                                    <select class="width-100-pc height-27">
                                                        <option disabled selected value="">-select-</option>
                                                        <option>KMO Main Store</option>
                                                        <option>Westlands Stores</option>
                                                        <option>Upper Hill Store</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 bg-greenish padding-10 mg-left-10 mg-top-10">
                                    <div class=" width-100-pc">
                                        <label>To Location:</label>
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc">
                                                <label class="fullname" for="firstName">Branch</label>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                                    <select class="width-100-pc height-27">
                                                        <option disabled selected value="">-select-</option>
                                                        <option>Amref Upper Hill</option>
                                                        <option>Amref Westlands</option>
                                                        <option>Amref Lang'ata</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-50-pc padding-right-3">
                                                <label class="fullname" for="firstName">Store</label>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                                    <select class="width-100-pc height-27">
                                                        <option disabled selected value="">-select-</option>
                                                        <option>KMO Main Store</option>
                                                        <option>Westlands Stores</option>
                                                        <option>Upper Hill Store</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-50-pc">
                                                <label class="fullname" for="firstName">Sub store</label>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                                    <select class="width-100-pc height-27">
                                                        <option disabled selected value="">-select-</option>
                                                        <option>KMO Main Store</option>
                                                        <option>Westlands Stores</option>
                                                        <option>Upper Hill Store</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 padding-10 mg-left-10 mg-top-10">
                                    <div class=" width-100-pc">
                                        <label>Date Transfered:</label>
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-100-pc">
                                                <input type="date" class="width-100-pc height-27 form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row padding-left-20 padding-right-20">
                                <div  id="inner_invoice_area" class="col-md-12 padding-left-0 padding-right-0">
                                    <div class="col-md-12 padding-left-0 padding-right-0">
                                        <table class="table table-striped table-bordered table_height_set">
                                            <thead>
                                                <tr>
                                                    <th class="cl-444 bg-greenish" style="width: 37%">Item</th>
                                                    <th class="cl-444 bg-greenish" style="width: 15%">Qty Available</th>
                                                    <th class="cl-444 bg-greenish" style="width: 30%">Batch/Lot No</th>
                                                    <th class="cl-444 bg-greenish" style="width: 15%">Quantity</th>
                                                    <th class="cl-444 bg-greenish" style="width: 3%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in purchase_form.items" :key="'items_'+index">
                                                    <td class="ng-binding">
                                                        {{purchase_form.items[index].unit_name}} | {{purchase_form.items[index].single_unit_weight}}{{purchase_form.items[index].unit_measure_type}}
                                                    </td>
                                                    <td class="ng-binding">
                                                        <input type="number" disabled step="any" v-model="purchase_form.items[index].item_stock" class="form-control product-entry-input-field height-27">
                                                    </td>
                                                    <td>
                                                        <select required class="bg-white height-27 border-radius-2 border-ccc no-shadowed">
                                                            <option value="">-Batch-</option>
                                                            <option value="2019">#6TY4E | Exp:Aug 2020 | Stock 2000</option>
                                                            <option value="2019">#6TY90 | Exp:Apr 2021 | Stock 4000</option>
                                                            <option value="2019">#6TY87 | Exp:Sep 2022 | Stock 1000</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" v-model="purchase_form.items[index].qty" class="form-control product-entry-input-field height-27">
                                                    </td>
                                                    <td>
                                                        <span class="cl-red pointer-cursor">x</span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

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
    import {get,post} from "../../../../../../helpers/api";
    import AppInfo from "../../../../../../helpers/config";
    import Auth from "../../../../../../store/auth";
    import {formatMoney,removeElement} from "../../../../../../helpers/config";
    import SupplierModal from '../vendors/SupplierModal'

    export default {
        props:['practice_id','form_data','initial_url','modal_id','modal_title'],
        components: {SupplierModal},
        data(){
            return {
                active_num: 1,
                processing: false,
                source_store: false,
                source_vendor: false,
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
                                    console.info(this.searched_products_list);
                                    break;
                            }
                        }
                    }).catch((err) => {

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
                this.$emit('userAdded')
            },
            close_search_result(){
                this.searched_products_list = [];
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
                        generic_name: '', //from this
                        item_code: '',
                        item_stock: '',
                        alert_indicator_level: '',
                        single_unit_weight: '',
                        vendor_item_number: '',
                        qty_available: 3000,
                    };
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
                this.close_search_result();

            },
        },
        mounted() {
            // this.hr_roles = this.hr_role;
            // this.form.mobile = this.form_data.mobile;
            // this.form.email = this.form_data.email;
            // this.form.password = this.form_data.password;
            // this.form.role_name = this.form_data.role_name;
            // this.form.first_name = this.form_data.first_name;
            // this.form.other_name = this.form_data.other_name;
            // this.form.gender = this.form_data.gender;
            // this.form.password = this.form_data.password;
            // this.form.status = this.form_data.status;
            // this.form.address = this.form_data.address;
            // this.form.branch_id = this.branch_id;
        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-lg {
        /* max-width: 800px!important;
        min-width: 800px!important; */
    }
        .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 100%!important;
        height: 100%;
        max-width: 100%!important;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
        top: 0!important;
        border-radius: 0!important;
    }
    .modal.left.fade.in .modal-dialog{
        left: 0;
    }
    .modal-header{
        /* background-color: #787887!important; */
        border-bottom: 1px solid #eee!important;
        height: 50px;
    }
    .modal-body{
        height: 80%;
        overflow-y: auto;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        /* line-height: 50px!important; */
        line-height: 20px!important;
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
        color: #787887!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 14px!important;
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
    .item-search-list {
        font-weight: 400!important;
    }
</style>
