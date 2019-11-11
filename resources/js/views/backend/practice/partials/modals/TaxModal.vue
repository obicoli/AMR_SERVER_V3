<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <form @submit.prevent="save_taxes" class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">{{title}}</h4>
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
                            <label class="fs-14 cl-888">Tax agency name:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input type="text" v-model="tax_form.agent_name" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':tax_form.agent_name}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">PIN (Optional)</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input type="text" v-model="tax_form.registration_number" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':tax_form.registration_number}">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Start tax period</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <select @change="setField($event,'start_period')" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':tax_form.start_period}">
                                <option value="">-select-</option>
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
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Filling frequency</label>
                        </div>
                        <div class="col-md-7">
                            <select @change="setField($event,'filling_frequency')"  v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':tax_form.filling_frequency}">
                                <option value="">-select-</option>
                                <option>Monthly</option>
                                <option>Quarterly</option>
                                <option>Half-yearly</option>
                                <option>Yearly</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Reporting method</label>
                        </div>
                        <div class="col-md-7">
                            <select @change="setField($event,'reporting_methods')"  v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':tax_form.reporting_method}">
                                <option value="">-select-</option>
                                <option>Accrual</option>
                                <option>Cash</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group mg-top-20">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <label class="check-container element-inlined fs-14 cl-888">This tax is collected on sales:
                                <input type="checkbox" v-model="tax_form.collected_on_sales">
                                <span class="checkmark"></span>
                            </label><br>
                            <div v-if="tax_form.collected_on_sales" class="form-group ha-input-group">
                                <label>Sales rate</label>
                                <input v-model="tax_form.sales_rate" v-bind:class="{'form-control product-entry-input-field ha-input':true,'attended_field':tax_form.sales_rate > 0}" step="any" type="number">
                            </div>
                        </div>
                    </div>

                    <div class="row form-group mg-top-10">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <label class="check-container element-inlined fs-14 cl-888">This tax is collected on purchases:
                                <input type="checkbox" v-model="tax_form.collected_on_purchase">
                                <span class="checkmark"></span>
                            </label>
                            <div v-if="tax_form.collected_on_purchase" class="form-group ha-input-group">
                                <label>Purchase rate</label>
                                <input v-model="tax_form.purchase_rate" v-bind:class="{'form-control product-entry-input-field ha-input':true,'attended_field':tax_form.purchase_rate > 0}" step="any" type="number">
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
                    <button type="submit" class="btn btn-inventory primary">
                        <span v-if="user_mode==='Create'">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Creating...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Create</span>
                        </span>
                        <span v-else>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Update</span>
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

    import {post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "TaxModal",
        //props:['initial_url','practice_id','user_mode','form_data'],
        props:['practice_id','form_data','initial_url','user_mode','modal_id','title'],
        data(){
            return {
                processing: false,
                tax_form:{
                    collected_on_sales: false,
                    collected_on_purchase: false,
                    practice_id: '',
                    agent_name: '',
                    name: '',
                    registration_number: '',
                    description: '',
                    start_period: '',
                    filling_frequency: '',
                    reporting_method: '',
                    purchase_rate: 0.0,
                    sales_rate: 0.0,
                    amount: 0,
                    status: 1,
                }
            }
        },
        methods: {

            save_taxes(){
                this.processing = true;
                post(AppInfo.app_data.server_domain+this.initial_url,this.tax_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$awn.success(res.data.description);
                        if (this.user_mode === 'Edit') {
                            this.$emit('taxEdited');
                        }else {
                            this.$emit('taxAdded');
                            this.refresh_tax();
                        }
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
            closeModal(){
                this.$emit('closeTaxModal');
            },
            setField(event,field_name){
                switch (field_name) {
                    case "start_period":
                        this.tax_form.start_period = event.target.value;
                        break;
                    case "filling_frequency":
                        this.tax_form.filling_frequency = event.target.value;
                        break;
                    case "reporting_methods":
                        this.tax_form.reporting_method = event.target.value;
                        break;
                }
            },
            refresh_tax(){
                this.tax_form.collected_on_sales = false;
                this.tax_form.collected_on_purchase = false;
                this.tax_form.name = "";
                this.tax_form.agent_name = "";
                this.tax_form.registration_number = "";
                this.tax_form.description = "";
                this.tax_form.start_period = "";
                this.tax_form.filling_frequency = "";
                this.tax_form.reporting_method = "";
                this.tax_form.purchase_rate = 0;
                this.tax_form.sales_rate = 0;
                this.tax_form.amount = 0;
            },
        },
        mounted() {
            this.tax_form.practice_id = this.practice_id;
            console.info(this.user_mode);
            console.info(this.form_data);
            if (this.user_mode === 'Edit') {
                this.tax_form.collected_on_sales = this.form_data.collected_on_sales;
                this.tax_form.collected_on_purchase = this.form_data.collected_on_purchase;
                this.tax_form.name = this.form_data.name;
                this.tax_form.agent_name = this.form_data.agent_name;
                this.tax_form.registration_number = this.form_data.registration_number;
                this.tax_form.description = this.form_data.description;
                this.tax_form.start_period = this.form_data.start_period;
                this.tax_form.filling_frequency = this.form_data.filling_frequency;
                this.tax_form.reporting_method = this.form_data.reporting_method;
                this.tax_form.purchase_rate = this.form_data.purchase_rate;
                this.tax_form.sales_rate = this.form_data.sales_rate;
            }
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
        left: -320px;
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
        right: -320px;
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
        border-bottom-color: #EEEEEE;
        background-color: #FAFAFA;
    }

    .modal-body{
        height:500px;
        overflow-y: auto;
    }

</style>