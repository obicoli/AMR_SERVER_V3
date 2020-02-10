<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="receive_po" class="modal-content">

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
                                                <span class="fs-13 fw-600 width-100-pc">Supplier</span>
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <select @change="setFields($event,'supplier')" v-bind:class="{'width-100-pc':true}">
                                                        <option value="">-select-</option>
                                                        <option  :value="purchase.supplier.id">{{purchase.supplier.company}} | {{purchase.supplier.first_name}} {{purchase.supplier.middle_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="inlineBlock width-100-pc">
                                                <div class="firstName width-100-pc">
                                                    <div v-html="supplier_str" class="div-textaread"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9 col-md-9 padding-left-0">

                                    <div class="width-40-pc float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-2">
                                                <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Branch:<span class="cl-amref">*</span> </label>
                                            </div>
                                            <div class="inlineBlock width-70-pc mg-bottom-2">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <select @change="set_variable($event,'facility')" required v-model="purchase.branch_id" class="width-100-pc report-filters-inputs">
                                                        <option value="" selected disabled>-select branch-</option>
                                                        <!-- <option v-for="(facility_lis, index) in initializations.facilities" :value="facility_lis.id" :key="'practice_list'+index">{{facility_lis.name}}</option> -->
                                                        <option :value="purchase.delivery_location.id">{{purchase.delivery_location.name}}</option>
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
                                                    <select v-model="purchase.store_id" required class="width-100-pc report-filters-inputs">
                                                        <option selected disabled value="">-select store-</option>
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
                                                    <select required v-model="purchase.department_id" class="width-100-pc report-filters-inputs">
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
                                                    <select v-model="purchase.sub_store_id" class="width-100-pc report-filters-inputs">
                                                        <option value="">-select sub store-</option>
                                                        <option v-for="(sub_store_lis, index) in initialization.sub_stores" :value="sub_store_lis.id" :key="'practice_list'+index">{{sub_store_lis.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="width-40-pc float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-2">
                                                <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Date:<span class="cl-amref">*</span> </label>
                                            </div>
                                            <div class="inlineBlock width-70-pc mg-bottom-2">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input type="date" v-model="purchase.date_received" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-5">
                                                <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Note:<span class="cl-amref">*</span></label>
                                            </div>
                                            <div class="inlineBlock width-70-pc mg-bottom-5">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <textarea v-model="purchase.advise_note" class="width-100-pc report-filters-inputs min-height-60"></textarea>
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
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="inner_invoice_area">
                                        <div class="col-md-12 set-no-padding">
                                            <table class="receipt-item-table table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;"></th>
                                                        <th style="width: 35%;" class="txt-uppercase">Goods</th>
                                                        <th style="width: 10%;" class="txt-uppercase">Pack Size</th>
                                                        <th style="width: 10%;" class="txt-uppercase">Ordered Qty</th>
                                                        <th style="width: 10%;" class="txt-uppercase">Delivered Qty</th>
                                                        <th style="width: 10%;" class="txt-uppercase">Vendor Item/No</th>
                                                        <th style="width: 20%;" class="txt-uppercase">Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase.items" :key="'item_key_'+index">
                                                        <td class="padded">{{index+1}}</td>
                                                        <td class="padded">{{purchase.items[index].brand}} | {{purchase.items[index].brand_sector}} | {{purchase.items[index].unit_weight}}{{purchase.items[index].measure_unit_sympol}}</td>
                                                        <td>
                                                            {{purchase.items[index].pack_qty}}
                                                        </td>
                                                        <td>
                                                            {{purchase.items[index].qty}}
                                                        </td>
                                                        <td>
                                                            <input v-model="purchase.items[index].delivered_qty" type="number" required v-bind:class="{'form-control height-24':true,'attended_field':purchase.items[index].delivered_qty}" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="text" required v-model="purchase.items[index].vendor_item_number" v-bind:class="{'form-control height-24':true,'attended_field':purchase.items[index].vendor_item_number}" step="any">
                                                        </td>
                                                        <td>
                                                            <input type="text" v-model="purchase.items[index].comment" v-bind:class="{'form-control height-24':true,'attended_field':purchase.items[index].comment}" step="any">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="width-400-px float-left">
                                                <div class="row fullName margin-5">

                                                    <div class="inlineBlock width-100-pc">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <label class="check-container small element-inlined mg-top-0 fs-12">
                                                                <input v-model="purchase.accounts_copy" type="checkbox"> Accounts/Finance dept. copy
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="inlineBlock width-100-pc">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <label class="check-container small element-inlined mg-top-0 fs-12">
                                                                <input v-model="purchase.supplier_copy" type="checkbox"> Supplier copy
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="inlineBlock width-100-pc">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <label class="check-container small element-inlined mg-top-0 fs-12">
                                                                <input v-model="purchase.store_copy" type="checkbox"> Stores/Goods inward copy
                                                                <span class="checkmark"></span>
                                                            </label>
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
                    <button type="submit" class="btn combo-button combo-default">
                        <span v-if="!processing">Save</span>
                        <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Processing...</span>
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
    import SupplierModal from '../../modals/vendors/SupplierModal';
    import {createHtmlErrorString,create_item,removeElement,formatMoney,add_search_item,amend_totals,reset_forms,location_obj_setter} from '../../../../../../helpers/functionmixin';
    import AppInfo from '../../../../../../helpers/config';
    import {get,post} from '../../../../../../helpers/api';
    import {PURCHASES_PO_URL} from '../../../../../../router/api_routes';
    import Auth from '../../../../../../store/auth'
    export default {
        props: ['modal_id','modal_title','practice_id','purchase','initializations','organ_data'],
        components: {SupplierModal},
        data(){
            return {
                current_branch: {},
                processing: false,
                initialization: {},
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

            set_variable(event,type_){
                switch(type_){
                    case "facility":
                        this.initialization = location_obj_setter(this.initializations,event.target.value);
                        this.selected_practice_id = event.target.value;
                        break;
                }
            },

            setFields(event,type_){
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
                                this.purchase.supplier_emails = this.initializations.suppliers[k].email;
                                this.purchase.mailing_address = this.supplier_str;
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

            receive_po(action_taken){
                this.processing = true;
                this.purchase.action_taken = action_taken;
                post(PURCHASES_PO_URL+'/grn',this.purchase)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.purchase.status = res.data.results;
                            this.$emit('poReceived');
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
                this.purchase = add_search_item(item_product, this.purchase)
            },
            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                this.purchase = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase);
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){
            this.initialization = location_obj_setter(this.initializations,null);
            this.current_branch = Auth.getCurrentAccount('work_place');
            this.purchase.staff_id = Auth.getCurrentAccount('staff_id');
            //console.info(this.purchase);
            //this.purchase.items = this.purchase.items;
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


