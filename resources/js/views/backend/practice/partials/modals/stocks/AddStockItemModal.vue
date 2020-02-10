<template>

    <div class="modal right fade" :id="modal_id" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="add_stock_item" class="modal-content">

                <div class="modal-header bg-eee">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{modal_title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body padding-top-0 padding-bottom-0">
                    <div class="row bg-eee justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-lg-9 col-md-9 padding-left-0">

                                    <div class="width-40-pc float-left padding-top-10 padding-bottom-10">
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-2">
                                                <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Branch:<span class="cl-amref">*</span> </label>
                                            </div>
                                            <div class="inlineBlock width-70-pc mg-bottom-2">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <select @change="set_variable($event,'facility')" required v-model="purchase.branch_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase.branch_id}">
                                                        <option value="" selected disabled>-select branch-</option>
                                                        <option :value="organ_data.data.facility.id">{{organ_data.data.facility.name}}</option>
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
                                                    <select v-model="purchase.store_id" required v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase.store_id}">
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
                                                    <select required v-model="purchase.department_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase.department_id}">
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
                                                    <select v-model="purchase.sub_store_id" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':purchase.sub_store_id}">
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
                                                <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Date:</label>
                                            </div>
                                            <div class="inlineBlock width-70-pc mg-bottom-2">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <input type="date" v-model="purchase.date_received" required v-bind:class="{'ctm-attended-field':purchase.date_received}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row fullName margin-5">
                                            <div class="inlineBlock width-30-pc mg-bottom-5">
                                                <label class="fs-13 fw-600 width-100-pc text-right padding-right-3">Note:</label>
                                            </div>
                                            <div class="inlineBlock width-70-pc mg-bottom-5">
                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                    <textarea v-model="purchase.advise_note" v-bind:class="{'width-100-pc report-filters-inputs min-height-60':true,'ctm-attended-field':purchase.advise_note}"></textarea>
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
                                                        <th style="width: 2%;"></th>
                                                        <th style="width: 21%;" class="txt-uppercase">ItemName</th>
                                                        <th style="width: 8%;" class="txt-uppercase">ItemCode</th>
                                                        <th style="width: 8%;" class="txt-uppercase">Pack/Size</th>
                                                        <th style="width: 8%;" class="txt-uppercase">Weight</th>
                                                        <th style="width: 8%;" class="txt-uppercase">UnitCost</th>
                                                        <th style="width: 8%;" class="txt-uppercase">Stock(Packs)</th>
                                                        <th style="width: 7%;" class="txt-uppercase">Qty(Packs)</th>
                                                        <th style="width: 11%;" class="txt-uppercase">Barcode</th>
                                                        <th style="width: 17%;" class="txt-uppercase">Batch/Serial No.</th>
                                                        <th style="width: 2%;" class="pointer-cursor">+</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in purchase.items" :key="'item_key_'+index" v-if="purchase.items[index].stock > 0">
                                                        <td class="padded">{{index+1}}</td>
                                                        <td class="padded">{{purchase.items[index].item_name}}</td>
                                                        <td class="padded">{{purchase.items[index].sku_code}}</td>
                                                        <td class="padded">{{purchase.items[index].pack_qty}}</td>
                                                        <td class="padded">{{purchase.items[index].unit_weight}}{{purchase.items[index].measure_unit_sympol}}</td>
                                                        <td class="padded">{{purchase.items[index].unit_cost}}</td>
                                                        <td class="padded">{{purchase.items[index].stock}}</td>
                                                        <td>
                                                            <input type="number" step="any" v-model="purchase.items[index].qty" @keyup="amend_qty($event,'qty',purchase.items[index].unit_cost,purchase.items[index].pack_cost,purchase.items[index].practice_product_item_id,index)" required v-bind:class="{'form-control height-24':true,'ctm-attended-field':purchase.items[index].qty}">
                                                        </td>
                                                        <td class="padded">
                                                            <input type="text" v-model="purchase.items[index].barcode" required v-bind:class="{'form-control height-24':true,'ctm-attended-field':purchase.items[index].barcode}">
                                                        </td>
                                                        <td>
                                                            <input type="text" v-model="purchase.items[index].batch_number" required v-bind:class="{'form-control height-24':true,'ctm-attended-field':purchase.items[index].batch_number}" placeholder="Batch Number">
                                                            <div v-if="purchase.items[index].batch_number" class="expiry-content mg-top-5">
                                                                <span class="fs-14 fw-600 cl-787887">Expiry:</span>
                                                                <select v-if="purchase.items[index].batch_number" v-model="purchase.items[index].exp_month" required v-bind:class="{'bg-white height-24 border-radius-2 border-ccc no-shadowed':true,'ctm-attended-field':purchase.items[index].exp_month}" style="width: 35%;">
                                                                    <option disabled selected value="">Month</option>
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
                                                                <select v-if="purchase.items[index].batch_number" v-model="purchase.items[index].exp_year" required v-bind:class="{'bg-white height-24 border-radius-2 border-ccc no-shadowed':true,'ctm-attended-field':purchase.items[index].exp_year}" style="width: 35%;">
                                                                    <option disabled selected value="">Year</option>
                                                                    <option :value="current_year">{{current_year}}</option>
                                                                    <option v-for="(item,index) in 10" :value="current_year+item" :key="'current_year'+index">{{current_year+item}}</option>
                                                                </select>
                                                            </div>
                                                            <small v-if="purchase.items[index].expired" class="cl-red fs-12 width-100-pc">Expired stock item!</small>
                                                        </td>
                                                        <td class="padded cl-amref pointer-cursor">x</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn combo-button combo-default">
                        Save
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
    import {PRODUCT_STOCK_URL} from '../../../../../../router/api_routes';
    import Auth from '../../../../../../store/auth'
    export default {
        props: ['modal_id','modal_title','practice_id','purchase','initializations','organ_data','stock_source'],
        components: {SupplierModal},
        data(){
            return {
                current_branch: {},
                processing: false,
                initialization: {},
                supplier_str: '',
                facility_str: '',
                current_year: new Date().getFullYear(),
            }
        },
        watch: {
            initializations: function(new_in,old_in){
                this.initializations = new_in;
            },
            // purchase: function(new_p,old_p){
            //     this.purchase = new_p;
            // }
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

            amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
                console.info(this.purchase.items[index].stock);
                if(this.purchase.items[index].qty > this.purchase.items[index].stock ){
                    this.$awn.warning("Quantity("+this.purchase.items[index].qty+") exceeds available stock("+this.purchase.items[index].stock+")");
                    this.purchase.items[index].qty = "";
                    //this.purchase = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase);
                }else{
                    //this.purchase = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase);
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

            add_stock_item(action_taken){
                this.processing = true;
                this.purchase.action_taken = action_taken;
                post(PRODUCT_STOCK_URL,this.purchase)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            for (let s = 0; s < this.purchase.items.length; s++) {
                                this.purchase.items[s].exp_month = "";
                                this.purchase.items[s].exp_year = "";
                                this.purchase.items[s].barcode = "";
                                this.purchase.items[s].qty = "";
                                this.purchase.items[s].batch_number = "";
                            }
                            this.processing = false;
                            this.$emit('stockSaved',this.purchase);
                            this.$awn.success(res.data.description);
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                        if(err.response.data.errors[0]==="Expired stock item detected!"){
                            for (let s = 0; s < this.purchase.items.length; s++) {
                                if(this.purchase.items[s].id === err.response.data.expired ){
                                    this.purchase.items[s].expired = true;
                                }else{
                                    this.purchase.items[s].expired = false;
                                }
                            }
                        }
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

            // amend_qty(event,type_,unit_cost,pack_cost,product_id,index){
            //     this.purchase = amend_totals(event,type_,unit_cost,pack_cost,product_id,index,this.purchase);
            // },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted(){
            this.initialization = location_obj_setter(this.initializations,null);
            this.current_branch = Auth.getCurrentAccount('work_place');
            this.purchase.staff_id = Auth.getCurrentAccount('staff_id');
            console.info(this.organ_data);
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


