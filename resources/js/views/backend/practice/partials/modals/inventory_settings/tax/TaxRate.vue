<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <form @submit.prevent="save_taxes" class="modal-content">

                <div class="modal-header width-100-pc text-left">
                    <h4 class="modal-title width-100-pc">{{title}}</h4>
                </div>
                <div class="modal-body">

                    <p class="fs-13">Create a name for your tax rate, and give a few details about how you track it.</p>

                    <div class="row form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Tax name:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input v-model="tax_form.name" type="text" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':tax_form.name}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Description:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <textarea v-model="tax_form.description" required v-bind:class="{'form-control product-entry-input-field min-height-60':true,'attended_field':tax_form.description}"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">PIN (Optional)</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input type="text" disabled v-model="tax_form.tax_number" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':tax_form.tax_number}">
                        </div>
                    </div>

                    <div class="row form-group mg-top-10">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <label class="check-container element-inlined small fs-14 cl-888">Is Default
                                <input type="checkbox" v-model="tax_form.is_default">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row form-group mg-top-20">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <label class="check-container element-inlined small fs-14 cl-888">This tax is collected on sales:
                                <input type="checkbox" v-model="tax_form.collected_on_sales">
                                <span class="checkmark"></span>
                            </label>
                            <div v-if="tax_form.collected_on_sales" class="width-100-pc float-left">
                                <div class="width-40-pc float-left">
                                    <label class="company-label fs-12 width-100-pc">Sales rate(%)&nbsp;&nbsp;</label>
                                </div>
                                <div class="width-40-pc float-left">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="tax_form.sales_rate" v-bind:class="{'form-control product-entry-input-field ha-input':true,'attended_field':tax_form.sales_rate > 0}" step="any" type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group mg-top-10">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <label class="check-container element-inlined small fs-14 cl-888">This tax is collected on purchases:
                                <input type="checkbox" v-model="tax_form.collected_on_purchase">
                                <span class="checkmark"></span>
                            </label>
                            <div v-if="tax_form.collected_on_purchase" class="width-100-pc float-left">
                                <div class="width-40-pc float-left">
                                    <label class="company-label fs-12 width-100-pc">Purchase rate(%)&nbsp;&nbsp;</label>
                                </div>
                                <div class="width-40-pc float-left">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="tax_form.purchase_rate" v-bind:class="{'form-control product-entry-input-field ha-input':true,'attended_field':tax_form.purchase_rate > 0}" step="any" type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="user_mode === 'Edit'" class="row form-group mg-top-20">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Status:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <select v-model="tax_form.status" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':tax_form.status}" required >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div v-if="user_mode==='Create'" class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-secondary banking-process-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a @click="save_taxes('Save & Close')" class="dropdown-item pointer-cursor"> Save & Close</a>
                                <a @click="save_taxes('Save & New')" class="dropdown-item pointer-cursor"> Save & New</a>
                            </div>
                        </div>
                    </div>
                    <button v-else @click="save_taxes('Save & Close')" :disabled="processing" data-dismiss="modal" class="btn btn-secondary banking-process-amref">
                        Save Changes
                    </button>
                    <button :disabled="processing" data-dismiss="modal" class="btn btn-secondary banking-process">
                        Close
                    </button>
                </div>

            </form>
        </div>
    </div>

</template>

<script>

    import {post} from "../../../../../../../helpers/api";
    import AppInfo from "../../../../../../../helpers/config";
    import {createHtmlErrorString,reset_forms} from "../../../../../../../helpers/functionmixin";
    import {PRODUCT_TAX_URL} from "../../../../../../../router/api_routes";
    import {FORM_ACTIONS} from "../../../../../../../helpers/process_status";

    export default {
        name: "TaxModal",
        props:['form_data','initial_url','user_mode','modal_id','title','registration_number'],
        data(){
            return {
                processing: false,
                tax_form:{
                    collected_on_sales: false,
                    collected_on_purchase: false,
                    name: '',
                    tax_number: '',
                    description: '',
                    purchase_rate: 0,
                    sales_rate: 0,
                    amount: 0,
                    status: 1,
                }
            }
        },
        watch: {
            user_mode: function (new_data,old_data) {
                this.user_mode = new_data;
                this.setTax();
            },
            initial_url: function (new_data,old_data) {
                this.initial_url = new_data;
                this.setTax();
            },
            form_data: function (new_data,old_data) {
                if(new_data){
                    this.form_data = new_data;
                    this.setTax();
                }
            },
        },
        methods: {

            save_taxes(action_taken){
                this.processing = true;
                post(this.initial_url,this.tax_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        if (this.user_mode === 'Edit') {
                            $("#"+this.modal_id).modal('hide');
                        }else {
                            switch (action_taken) {
                                case FORM_ACTIONS.SAVE_NEW:
                                    //this.$emit('taxChanged');
                                    //this.refresh_tax();
                                    //this.tax_form = reset_forms(this.tax_form);
                                    break;
                                case FORM_ACTIONS.SAVE_CLOSE:
                                    //this.$emit('taxChanged');
                                    //this.tax_form = reset_forms(this.tax_form);
                                    //this.refresh_tax();
                                    $("#"+this.modal_id).modal('hide');
                                    break;
                            }
                        }
                        this.$emit('vat-rate-event');
                    }
                    this.processing = false;
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
            setTax(){
                this.tax_form = this.form_data;
            },
            refresh_tax(){
                this.tax_form.collected_on_sales = false;
                this.tax_form.collected_on_purchase = false;
                this.tax_form.name = "";
                this.tax_form.registration_number = "";
                this.tax_form.description = "";
                this.tax_form.purchase_rate = 0;
                this.tax_form.sales_rate = 0;
                this.tax_form.amount = 0;
            },
        },
        mounted() {
            this.setTax();

        }
    }
</script>

<style scoped>
    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        /*width: 320px;*/
        width: 40%!important;
        height: 100%;
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
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog{
        /* left: -320px; */
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog{
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: 0;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    .modal-header {
        border-bottom-color: #f4f4f4!important;
        background-color: #f4f4f4!important;
        color: #636872!important;
    }

    .modal-body{
        height:500px;
        overflow-y: auto;
    }

</style>