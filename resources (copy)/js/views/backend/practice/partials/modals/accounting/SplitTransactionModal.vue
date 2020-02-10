<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="process_bank" class="modal-content">
                <div class="modal-header bg-ced">
                    <h4 class="width-100-pc text-left fs-20">{{title}}</h4>
                </div>
                <div v-if="is_set" class="modal-body padding-bottom-29 bg-ced">
                    <div v-if="form.type===AC_TYPES.SUPPLIER" class="width-100-pc float-left">
                        <div class="width-100-pc float-left mg-top-20">
                            <table class="table banking-transaction table-hover mg-bottom-20">
                                <thead>
                                    <tr>
                                        <th style="width:25%;">Date</th>
                                        <th style="width:10%;">Payee</th>
                                        <th style="width:20%;">Description</th>
                                        <th style="width:8%;">Reference</th>
                                        <th style="width:10%;">VAT</th>
                                        <th style="width:10%;">Payment Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="zeropad">
                                            <datetime 
                                                v-model="form.transaction_date" 
                                                :input-id="'date_input_'"
                                                use12-hour
                                                :type="'date'"
                                                :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                :value="form.transaction_date"
                                                >
                                            </datetime>
                                        </td>
                                        <td class="somepad">{{form.payee}}</td>
                                        <td class="somepad">{{form.description}}</td>
                                        <td class="somepad">{{form.reference}}</td>
                                        <td class="somepad">KES{{format_money(form.amount)}}</td>
                                        <td class="somepad">KES{{format_money(form.spent)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="width-100-pc float-left mg-top-20">
                            <table class="table banking-transaction table-hover mg-bottom-20">
                                <thead>
                                    <tr>
                                        <th style="width:25%;">Description</th>
                                        <th style="width:10%;">Type</th>
                                        <th style="width:20%;">Selection</th>
                                        <th style="width:8%;">VAT Type</th>
                                        <th style="width:10%;">Exclusive</th>
                                        <th style="width:10%;">Inclusive</th>
                                        <th style="width:7%;">VAT</th>
                                        <th style="width:10%;"></th>
                                    </tr>
                                </thead>
                                <!-- Loopable tbody Starts -->
                                <tbody>
                                    <tr>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="form.description" v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <select v-model="form.type" v-bind:class="{'height-30':true}">
                                                    <option value="" disabled selected>select</option>
                                                    <option :value="AC_TYPES.ACCOUNT">{{AC_TYPES.ACCOUNT}}</option>
                                                    <option :value="AC_TYPES.SUPPLIER">{{AC_TYPES.SUPPLIER}}</option>
                                                    <option :value="AC_TYPES.CUSTOMER">{{AC_TYPES.CUSTOMER}}</option>
                                                    <option :value="AC_TYPES.TRANSFER">{{AC_TYPES.TRANSFER}}</option>
                                                    <option :value="AC_TYPES.VAT">{{AC_TYPES.VAT}}</option>
                                                </select>
                                                <!-- <input v-bind:class="{'height-30':true}" type="date"> -->
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <vue-single-select
                                                    name="maybe"
                                                    placeholder=""
                                                    you-want-to-select-a-post="ok"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="form.selections"
                                                    v-model="form.selection"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="name"
                                                ></vue-single-select>
                                                <!-- <input v-bind:class="{'height-30':true}" type="text"> -->
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <vue-single-select
                                                    name="maybe"
                                                    placeholder=""
                                                    you-want-to-select-a-post="ok"
                                                    v-model="form.vat"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="taxations"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="name"
                                                ></vue-single-select>
                                                <!-- <input v-bind:class="{'height-30':true}" type="text"> -->
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="form.spent" v-bind:class="{'height-30':true}" type="number">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="form.spent" v-bind:class="{'height-30':true}" type="number">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-model="form.vat.amount" v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="somepad icon-group">
                                            <a data-toggle="collapse" :data-target="'#transaction_details_'" title="Detail"><i class="fa fa-angle-down"></i></a>&nbsp;&nbsp;
                                            <a title="Copy" class="cl-success-light"><i class="fa fa-plus-circle"></i></a>&nbsp;&nbsp;
                                            <a title="Delete" class="cl-amref"><i class="fa fa-minus-circle"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="zeroPadding bg-ced">
                                            <!-- <div class="collapse out width-100-pc bg-ced" style="padding-left:3%!important;" :id="'transaction_details_'">
                                                <div class="width-100-pc float-left bg-ced padding-top-20 padding-bottom-10">
                                                    <h4 class="fs-11 fw-600 txt-uppercase">Transaction Detail</h4>
                                                    <div class="width-40-pc float-left">
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Exclusive amount:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input v-bind:class="{'height-27':true}" type="number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">VAT amount:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input v-bind:class="{'height-27':true}" type="number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="somepad text-right bg-ced no-border">
                                            Split Total:
                                        </td>
                                        <td class="zeropad bg-ced no-border">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc mg-top-2">
                                                <input v-model="form.spent" disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                            </div>
                                        </td>
                                        <td colspan="2" class="somepad bg-ced no-border">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="somepad text-right bg-ced no-border">
                                            Remainder:
                                        </td>
                                        <td class="zeropad bg-ced no-border">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc mg-top-2">
                                                <input v-model="form.spent" disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                            </div>
                                        </td>
                                        <td colspan="2" class="somepad bg-ced no-border">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="somepad text-right bg-ced no-border">
                                            Payment Total:
                                        </td>
                                        <td class="zeropad bg-ced no-border">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc mg-top-2">
                                                <input v-model="form.spent" disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                            </div>
                                        </td>
                                        <td colspan="2" class="somepad bg-ced no-border">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="width-100-pc float-left padding-left-25 mg-top-45">
                            <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process float-right">
                                Close
                            </button>
                            <button :hidden="user_mode==='View'" :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref float-right mg-right-5">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                <span v-else>Save</span>
                            </button>
                        </div>

                    </div>

                    <div v-else class="width-100-pc float-left">
                        <div class="width-100-pc float-left mg-top-20">
                            <table class="table banking-transaction table-hover mg-bottom-20">
                                <thead>
                                    <tr>
                                        <th style="width:25%;">Date</th>
                                        <th style="width:10%;">Payee</th>
                                        <th style="width:20%;">Description</th>
                                        <th style="width:8%;">Reference</th>
                                        <th style="width:10%;">VAT</th>
                                        <th style="width:10%;">Receipt Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="somepad">{{form.transaction_date}}</td>
                                        <td class="somepad">{{form.transaction_date}}</td>
                                        <td class="somepad">{{form.transaction_date}}</td>
                                        <td class="somepad">{{form.transaction_date}}</td>
                                        <td class="somepad">{{form.transaction_date}}</td>
                                        <td class="somepad">{{form.transaction_date}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="width-100-pc float-left mg-top-20">
                            <table class="table banking-transaction table-hover mg-bottom-20">
                                <thead>
                                    <tr>
                                        <th style="width:25%;">Description</th>
                                        <th style="width:10%;">Type</th>
                                        <th style="width:20%;">Selection</th>
                                        <th style="width:8%;">VAT Type</th>
                                        <th style="width:10%;">Exclusive</th>
                                        <th style="width:10%;">Inclusive</th>
                                        <th style="width:7%;">VAT</th>
                                        <th style="width:10%;"></th>
                                    </tr>
                                </thead>
                                <!-- Loopable tbody Starts -->
                                <tbody>
                                    <tr>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-bind:class="{'height-30':true}" type="date">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="zeropad">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input v-bind:class="{'height-30':true}" type="text">
                                            </div>
                                        </td>
                                        <td class="somepad icon-group">
                                            <a data-toggle="collapse" :data-target="'#transaction_details_'" title="Detail"><i class="fa fa-angle-down"></i></a>&nbsp;&nbsp;
                                            <a title="Copy" class="cl-success-light"><i class="fa fa-plus-circle"></i></a>&nbsp;&nbsp;
                                            <a title="Delete" class="cl-amref"><i class="fa fa-minus-circle"></i></a>&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" class="zeroPadding bg-ced">
                                            <div class="collapse out width-100-pc bg-ced" style="padding-left:3%!important;" :id="'transaction_details_'">
                                                <div class="width-100-pc float-left bg-ced padding-top-20 padding-bottom-10">
                                                    <h4 class="fs-11 fw-600 txt-uppercase">Transaction Detail</h4>
                                                    <div class="width-40-pc float-left">
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Exclusive amount:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input v-bind:class="{'height-27':true}" type="number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">VAT amount:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input v-bind:class="{'height-27':true}" type="number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="somepad text-right bg-ced no-border">
                                            Split Total:
                                        </td>
                                        <td class="zeropad bg-ced no-border">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                            </div>
                                        </td>
                                        <td colspan="2" class="somepad bg-ced no-border">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="somepad text-right bg-ced no-border">
                                            Remainder:
                                        </td>
                                        <td class="zeropad bg-ced no-border">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                            </div>
                                        </td>
                                        <td colspan="2" class="somepad bg-ced no-border">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="somepad text-right bg-ced no-border">
                                            Payment Total:
                                        </td>
                                        <td class="zeropad bg-ced no-border">
                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                <input disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                            </div>
                                        </td>
                                        <td colspan="2" class="somepad bg-ced no-border">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="width-100-pc float-left padding-left-25 mg-top-45">
                            <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process float-right">
                                Close
                            </button>
                            <button :hidden="user_mode==='View'" :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref float-right mg-right-5">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                <span v-else>Save</span>
                            </button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { post } from '../../../../../../helpers/api';
import {AC_TYPES} from "../../../../../../helpers/process_status";
import { createHtmlErrorString, formatMoney,create_bank_statement_transaction } from '../../../../../../helpers/functionmixin';
export default {
    props: ['modal_id','form_data','title','user_mode','bank_transactions_api','taxations'],
    data(){
        return {
            processing: false,
            is_set: false,
            form: create_bank_statement_transaction(null),
            AC_TYPES: AC_TYPES,
        }
    },
    watch: {
        form_data: function(new_data,old_data){
            this.form = new_data;
        },
        taxations: function(new_data,old_data){
            this.taxations = new_data;
        }
    },
    methods: {
        format_money(money_to){
            return formatMoney(money_to);
        }
    },
    mounted(){
        this.form = this.form_data;
        this.is_set = true;
    }
}
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-header{
        border-bottom: 1px solid #ccc!important;
    }
    .modal-content{
        top: 30px!important;
    }
    .modal-lg {
        max-width: 1150px!important;
        min-width: 1150px!important;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
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
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 14px;
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
</style>