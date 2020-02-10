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

                                <div class="col-lg-12 col-md-12 padding-left-0 padding-right-0">

                                    <div class="width-100-pc bg-eee padding-left-20 padding-right-20 padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-5 mg-right-5">
                                                <span class="fs-13 fw-600">Customer <a class="btn-link">+ New Customer</a></span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="payment_form.customer"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="initializations.customers"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="display_as"
                                                        :getOptionValue="getCustomer"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-20-pc mg-bottom-5 mg-right-5">
                                                <span class="fs-13 fw-600">Email:</span><a class="btn-link float-right">Cc/Bcc</a>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input v-model="payment_form.email" class="width-100-pc report-filters-inputs" type="email">
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
                                            <div class="inlineBlock width-20-pc mg-right-5">
                                                <span class="fs-13 fw-600">Payment date</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input v-model="payment_form.payment_date" class="width-100-pc report-filters-inputs" type="date">
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-20-pc float-right">
                                                <span class="fs-13 fw-600">Amount received:</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input v-model="payment_form.amount" class="width-100-pc report-filters-inputs" type="number" step="any">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-10-pc mg-bottom-5 mg-right-5">
                                                <span class="fs-13 fw-600">Payment method</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="payment_form.payment_method"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="initializations.payment_methods"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                        :getOptionValue="payment_method"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-20-pc mg-bottom-5 mg-right-5">
                                                <span class="fs-13 fw-600">Reference no.</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" type="text">
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-30-pc mg-right-5">
                                                <span class="fs-13 fw-600">Deposit to</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="payment_form.account"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="initializations.company_coas"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-if="payment_form.is_bank_payment" class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-5 mg-right-5">
                                                <span class="fs-13 fw-600">Bank Account</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <vue-single-select
                                                        name="maybe"
                                                        placeholder=""
                                                        you-want-to-select-a-post="ok"
                                                        v-model="payment_form.bank"
                                                        out-of-all-these-posts="makes sense"
                                                        :options="initializations.banks"
                                                        a-post-has-an-id="good"
                                                        the-post-has-a-title="make"
                                                        option-label="name"
                                                    ></vue-single-select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-20-pc mg-bottom-5 mg-right-5">
                                                <span class="fs-13 fw-600">Cheque No.</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input class="width-100-pc report-filters-inputs" type="text">
                                                </div>
                                            </div>
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

                                        
                                            <div class="width-400-px mg-top-20 float-left">
                                                <!-- <textarea class="width-100-pc report-filters-inputs min-height-90" placeholder="Your message to supplier"></textarea> -->
                                                <div class="row fullName margin-5">
                                                    
                                                    <div class="inlineBlock width-80-pc">
                                                        <span class="fs-13 fw-600">Your message to customer</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="inlineBlock width-80-pc">
                                                        <span class="fs-13 fw-600">Memo</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea class="width-100-pc report-filters-inputs min-height-90"></textarea>
                                                        </div>
                                                    </div> -->

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
        props: ['modal_id','modal_title','practice_id','user_mode','customer','initializations'],
        components: {SearchItemField},
        data(){
            return {
                processing: false,
                customers: [],
                payment_form: {
                    is_bank_payment: false,
                    practice_bank_id: '',
                    payment_method_id: '',
                    payment_date: '',
                    cheque_number: '',
                    amount: 0,
                    payment_date: '',
                    customer: {},
                    account: {},
                    payment_method: {},
                    bank: {}
                },
                stock_form: {
                    batch_number: ''
                },
                hr_roles: [],
                searched_products_list: [],
            }
        },
        watch: {
            initializations: function(new_in,old_in){
                this.initializations = new_in;
                this.customers = this.initializations.customers;
                if(this.customers.length){
                    this.customer = this.customers[0];
                    this.customer_str = form_address(this.customer);
                }
            }
        },
        methods: {

            // requestVendorForm(){
            //     this.$emit('requestVendorForm');
            // },

            getCustomer(){

            },

            // getType(){
            //     this.purchase_form.payment_method_id = this.form.payment_method.id;
            // },

            format_money(money_to){
                return formatMoney(money_to);
            },

            // activeThis(num_){
            //     this.active_num = num_;
            // },

            // remove_item(item_to){
            //     this.purchase_form.items = removeElement(this.purchase_form.items, item_to);
            // },

            // setSource(event){
            //     switch(event.target.value){
            //         case "vendor":
            //             this.source_store = false;
            //             this.source_vendor = true;
            //             break;
            //         case "store":
            //             this.source_store = true;
            //             this.source_vendor = false;
            //             break;
            //     }
            // },

            // refresh_page(){
            //     this.form.status = "";
            //     this.form.role_name = "";
            //     this.form.address = "";
            //     this.form.first_name = "";
            //     this.form.other_name = "";
            //     this.form.email = "";
            //     this.form.mobile = "";
            //     this.form.gender = "";
            //     this.form.password = "";
            //     this.$emit('userAdded');
            // },

            // add_search_item_invoice(item_product){

            //     console.info(item_product);
            //     let add_item = true;
            //     for ( let i = 0; i < this.purchase_form.items.length; i++ ){
            //         if (this.purchase_form.items[i].practice_product_item_id === item_product.id){
            //             add_item = false;
            //             break;
            //         }
            //     }
            //     if (add_item){

            //         let item = create_item();

            //         item.generic_name = item_product.generic_name;
            //         item.item_code = item_product.item_code;
            //         item.item_stock = item_product.item_stock;
            //         item.alert_indicator_level = item_product.alert_indicator_level;
            //         item.single_unit_weight = item_product.single_unit_weight;

            //         item.pack_cost = item_product.pack_cost;
            //         item.pack_retail = item_product.pack_retail_price;
            //         item.unit_cost = item_product.unit_cost;
            //         item.unit_retail = item_product.unit_retail_price;
            //         item.unit_name = item_product.item_name;
            //         item.unit_weight = item_product.single_unit_weight;
            //         item.unit_measure_type = item_product.product_unit_slug;
            //         item.practice_product_item_id = item_product.id;
            //         this.purchase_form.items.push(item);
            //         //this.purchase_form.total_bill += item.unit_retail;
            //         this.purchase_form.total_bill += item.qty * item.pack_cost;
            //         if (this.purchase_form.discount_offered > 0){
            //             this.purchase_form.total_grand = this.purchase_form.total_bill - ( (this.purchase_form.discount_offered/100)*this.purchase_form.total_bill );
            //         } else {
            //             this.purchase_form.total_grand = this.purchase_form.total_bill;
            //         }

            //     }
                
            // },

            // amend_qty(event,type_,unit_cost,pack_cost,product_id){

            //     switch (type_) {
            //         case "qty":
            //         case "pack_cost":
            //         case "unit_cost":
            //         case "discount":
            //             this.purchase_form.total_bill = 0;
            //             for ( let i = 0; i < this.purchase_form.items.length; i++ ){
            //                 this.purchase_form.total_bill += this.purchase_form.items[i].qty * this.purchase_form.items[i].pack_cost;
            //             }
            //             if (this.purchase_form.discount_offered > 0){
            //                 this.purchase_form.total_grand = this.purchase_form.total_bill - ( (this.purchase_form.discount_offered/100)*this.purchase_form.total_bill );
            //             } else {
            //                 this.purchase_form.total_grand = this.purchase_form.total_bill;
            //             }
            //             break;
            //         case "cash_paid":
            //             this.purchase_form.cash_balance = this.purchase_form.total_grand - this.purchase_form.cash_paid;
            //             break;
            //     }

            // },
            payment_method(){

                if(this.payment_form.payment_method && this.payment_form.payment_method.name === "Cheque" ){
                    this.payment_form.is_bank_payment = true;
                }else{
                    this.payment_form.is_bank_payment = false;
                }

            },
            // getBanks(){
            //     this.processing = true;
            //     get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Banks')
            //         .then((res) => {
            //             if(res.data.status_code === 200) {
            //                 this.banks = res.data.results;
            //                 //console.info(this.banks);
            //                 this.processing = false;
            //             }
            //         }).catch((err) => {
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors))
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description)
            //         }
            //         this.processing = false;
            //     });
            // },
        },

        mounted(){
            if(this.user_mode === "Existing"){
                this.payment_form.customer = this.customer;
                this.payment_form.amount = this.customer.balance;
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
</style>


