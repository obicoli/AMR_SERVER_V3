<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="submit_request" class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">
                    <div class="row bg-eee justify-content-center">
                        <div class="col-lg-12">

                            <div class="width-40-pc float-left padding-top-10 padding-bottom-10">
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-2">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Branch:<span class="cl-amref">*</span> </label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-2">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select @change="set_variable($event,'facility')" required v-model="purchase_form.branch_id" class="width-100-pc report-filters-inputs">
                                                <option value="" selected disabled>-select branch-</option>
                                                <option v-for="(facility_lis, index) in initializations.facilities" :value="facility_lis.id" :key="'practice_list'+index">{{facility_lis.name}}</option>
                                            </select>
                                            <!-- <select v-if="!check_permissions('view.branch')" required class="width-100-pc report-filters-inputs">
                                                <option value="">-select-</option>
                                            </select> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Store:<span class="cl-amref">*</span></label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="purchase_form.store_id" required class="width-100-pc report-filters-inputs">
                                                <option selected disabled value="">-select store-</option>
                                                <option v-for="(store_lis, index) in initialization.stores" :value="store_lis.id" :key="'store_list'+index">{{store_lis.name}}</option>
                                            </select>
                                            <!-- <select v-if="!check_permissions('view.branch')" required class="width-100-pc report-filters-inputs">
                                                <option value="">-select-</option>
                                                <option :value="current_branch.id">{{current_branch.name}}</option>
                                            </select> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Department:<span class="cl-amref">*</span></label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-5">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select required v-model="purchase_form.department_id" class="width-100-pc report-filters-inputs">
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
                                            <select v-model="purchase_form.sub_store_id" class="width-100-pc report-filters-inputs">
                                                <option value="">-select sub store-</option>
                                                <option v-for="(sub_store_lis, index) in initialization.sub_stores" :value="sub_store_lis.id" :key="'practice_list'+index">{{sub_store_lis.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="width-40-pc float-left padding-top-10 padding-bottom-10">
                                <!-- <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-2">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Date:</label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-2">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="date" v-model="purchase_form.request_date" required v-bind:class="{'ctm-attended-field':purchase_form.request_date}">
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-2">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Due Date:</label>
                                    </div>
                                    <div class="inlineBlock width-70-pc mg-bottom-2">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="date" v-model="purchase_form.due_date" required v-bind:class="{'ctm-attended-field':purchase_form.due_date}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName margin-5">
                                    <div class="inlineBlock width-30-pc mg-bottom-5">
                                        <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Note:</label>
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
                        
                        <!-- <div class="col-lg-12 col-md-12">
                            <div class="po-separator bg-red mg-bottom-15 mg-top-20">
                                <span class="fw-600 fs-12 txt-uppercase">Create PO items:</span>(<small>Create PO for your vendor.</small>)
                            </div>
                        </div> -->

                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="inner_invoice_area">
                                        <div class="col-md-12 set-no-padding">
                                            <!-- <search-item-field :practice_id="practice_id" v-on:itemFound="add_search_item_invoice"></search-item-field> -->
                                            <search-item-form-control v-on:itemFound="add_search_item_invoice" :practice_id="selected_practice_id" :show_label="true" :search_result_width="1000" :search_result_min_height="400"></search-item-form-control>
                                            <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 2%;"></th>
                                                        <th style="width: 18%;">Item/Name</th>
                                                        <th style="width: 10%;">Item/Code</th>
                                                        <!-- <th style="width: 10%;">Barcode</th> -->
                                                        <th style="width: 10%;">Pack(size)</th>
                                                        <!-- <th style="width: 5%;">U.o.m</th> -->
                                                        <th style="width: 8%;">Pack/Cost</th>
                                                        <th style="width: 8%;">Unit/cost</th>
                                                        <th style="width: 8%;">Packs</th>
                                                        <th style="width: 12%;">Qty</th>
                                                        <th style="width: 12%;">In/Stock</th>
                                                        <th style="width: 10%;">Amount(Kes)</th>
                                                        <th style="width: 2%;"><a title="Add Item" class="fs-14 cl-amref pointer-cursor">+</a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase_form.items" :key="'item_key_'+index">
                                                        <td class="padded">{{index+1}}</td>
                                                        <td class="padded">{{purchase_form.items[index].item_name}}</td>
                                                        <td class="padded">{{purchase_form.items[index].sku_code}}</td>
                                                        <!-- <td class="padded">{{purchase_form.items[index].barcode}}</td> -->
                                                        <td class="padded">{{purchase_form.items[index].pack_qty}} x {{purchase_form.items[index].unit_weight}}{{purchase_form.items[index].measure_unit_sympol}}</td>
                                                        <!-- <td class="padded">{{purchase_form.items[index].measure_unit_sympol}}</td> -->
                                                        <td class="padded">{{format_money(purchase_form.items[index].pack_cost)}}</td>
                                                        <td class="padded">{{format_money(purchase_form.items[index].unit_cost)}}</td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].qty" type="number" required step="any" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-24':true,'attended_field':purchase_form.items[index].qty}">
                                                        </td>
                                                        <td class="padded">{{format_money(purchase_form.items[index].sub_stock_total)}}</td>
                                                        <td class="padded">{{format_money(purchase_form.items[index].stock)}}</td>
                                                        <td class="padded text-right">{{format_money(purchase_form.items[index].amount)}}</td>
<!-- 
                                                        <td>
                                                            <input v-model="purchase_form.items[index].qty" type="number" @keyup="amend_qty($event,'qty',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'attended_field':purchase_form.items[index].qty}">
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase_form.items[index].pack_cost" type="number" @keyup="amend_qty($event,'pack_cost',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'attended_field':purchase_form.items[index].pack_cost}" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="number" v-model="purchase_form.items[index].amount" @keyup="amend_qty($event,'amount',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" v-bind:class="{'form-control height-27':true,'attended_field':purchase_form.items[index].amount}" step="any">
                                                        </td> -->

                                                        <td class="padded">
                                                            <a title="Remove" @click="amend_qty($event,'remove',purchase_form.items[index].unit_cost,purchase_form.items[index].pack_cost,purchase_form.items[index].practice_product_item_id,index)" class="pointer-cursor cl-red">x</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="fw-600 text-right">Total:</td>
                                                        <td colspan="3" class="fw-600 text-right total-field">{{format_money(purchase_form.total_grand)}}</td>
                                                        <td class="total-field"></td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <!-- <div class="float-left width-250-px">
                                                <div class="row fullName margin-5">
                                                    <div class="inlineBlock width-100-pc">
                                                        <span class="fs-12 fw-600">Note:</span>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="purchase_form.note" class="width-100-pc report-filters-inputs min-height-60"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <!-- <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop" type="submit" class="btn combo-button combo-default">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing...</span>
                                    <span v-else>Submit</span>
                                </span>
                            </button>
                        </div>
                    </div> -->
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
    import SearchItemFormControl from '../../modals/product/SearchItemFormControl';
    import SupplierModal from '../../modals/vendors/SupplierModal';
    import {createHtmlErrorString,formatMoney,add_search_item,amend_totals,location_obj_setter} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {PURCHASES_PO_URL,PRODUCT_REQUISITIONS} from '../../../../../../router/api_routes';
    import Auth from '../../../../../../store/auth'
    export default {
        props: ['modal_id','modal_title','practice_id','po_number','initializations','organ_data','address_ob'],
        components: {SearchItemField,SupplierModal,SearchItemFormControl},
        data(){
            return {
                //current_branch: {},
                processing: false,
                purchase_form: {
                    action_taken: 'Save',
                    src_address: this.address_ob.staff_address,
                    branch_id: '',
                    store_id: '',
                    sub_store_id: '',
                    department_id: '',
                    discount_offered: 0,
                    cash_paid: 0,
                    due_date: '',
                    request_date: '',
                    cash_balance: 0,
                    note: '',
                    //po_no: '',
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
                post(PRODUCT_REQUISITIONS,this.purchase_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success(res.data.description);
                        this.$emit("successRequested");
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                        
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
                //this.$emit('requistionReady',this.purchase_form);
            },

            add_search_item_invoice(item_product){
                this.purchase_form = add_search_item(item_product, this.purchase_form)
            },

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){

                // if(this.purchase_form.items[index].qty > this.purchase_form.items[index].stock_total ){
                //     this.$awn.warning("Requested quantity("+this.purchase_form.items[index].qty+") exceeds available quantity("+this.purchase_form.items[index].stock_total+")");
                //     this.purchase_form.items[index].qty = 0;
                //     this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form);
                // }else{
                //     //sub_stock_total
                //     this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form);
                // }
                this.purchase_form = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase_form);
            },
            
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
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

<style lang="scss" scoped>
    // @import '../../../../../../../sass/fulllengthmodals.scss';
    @import '../../../../../../../sass/transaction_docs.scss';
    .modal.left .modal-content,
    .modal-lg {
        max-width: 1150px!important;
        min-width: 1150px!important;
    }
    .modal-header h4 {
        font-size: 20px!important;
    }
</style>


