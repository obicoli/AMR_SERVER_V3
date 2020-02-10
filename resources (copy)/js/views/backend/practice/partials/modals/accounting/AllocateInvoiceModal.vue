<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="process_bank" class="modal-content">
                <div class="modal-header bg-ced">
                    <h4 class="width-100-pc text-left fs-20">Allocate {{title}}</h4>
                </div>
                <div class="modal-body padding-bottom-29 bg-ced">

                    <div class="width-100-pc float-left">

                        <div class="width-100-pc float-left mg-top-20">
                            <div class="width-40-pc float-left">
                                <div class="width-100-pc float-left">
                                    <div class="width-40-pc float-left text-right">
                                        <label class="company-label fs-13 text-right fw-600">Customer:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="width-50-pc float-left">
                                        <label class="company-label fs-12">WholeCycle Wholesales</label>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left">
                                    <div class="width-40-pc float-left text-right">
                                        <label class="company-label fs-13 text-right fw-600">Ref. & Description:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="width-50-pc float-left">
                                        <label class="company-label fs-12">WholeCycle Wholesales</label>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left">
                                    <div class="width-40-pc float-left text-right">
                                        <label class="company-label fs-13 text-right fw-600">Receipt Amount:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="width-50-pc float-left">
                                        <label class="company-label fs-12">KES20,000</label>
                                    </div>
                                </div>
                            </div>
                            <div class="width-40-pc float-right">
                                <div class="width-100-pc float-left">
                                    <div class="width-50-pc float-left text-right">
                                        <label class="company-label fs-13 text-right fw-600">Discount Amount:&nbsp;</label>
                                    </div>
                                    <div class="width-50-pc float-left">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-bind:class="{'height-30':true}" type="number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="width-100-pc float-left mg-top-15">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a @click="toggleTab(0)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===0}" :id="'nav-invoices-tab-'+'0'" data-toggle="tab" :href="'#nav-invoices-'+'0'" role="tab" :aria-controls="'nav-invoices-'+'0'" aria-selected="true" :key="'invoicess_tab'+'0'">Paid</a>
                                    <a @click="toggleTab(1)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===1}" :id="'nav-invoices-tab-'+'1'" data-toggle="tab" :href="'#nav-invoices-'+'1'" role="tab" :aria-controls="'nav-invoices-'+'1'" aria-selected="true" :key="'invoicess_tab'+'1'">Partially Paid</a>
                                    <a @click="toggleTab(2)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===2}" :id="'nav-invoices-tab-'+'2'" data-toggle="tab" :href="'#nav-invoices-'+'2'" role="tab" :aria-controls="'nav-invoices-'+'2'" aria-selected="true" :key="'invoicess_tab'+'2'">Unpaid</a>
                                </div>
                            </nav>
                            <div class="tab-content tab-content-role" id="nav-tabContent">
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-invoices-'+'0'" role="tabpanel" :aria-labelledby="'nav-invoices-tab-'+'0'" :key="'tab_index_'+'0'">
                                    <!-- -----------------------------------------------Paid Tab Starts--------------------------------------------- -->
                                    <div class="width-100-pc float-left mg-top-20">
                                        <table class="table banking-transaction table-hover mg-bottom-20">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%;">Allocate</th>
                                                    <th style="width:20%;">Document Number</th>
                                                    <th style="width:20%;">Customer Reference</th>
                                                    <th style="width:10%;">Date</th>
                                                    <th style="width:10%;">Total</th>
                                                    <th style="width:10%;">Amount Due</th>
                                                    <th style="width:10%;">Amount Received</th>
                                                    <th style="width:10%;">Allocated Discount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,index) in 10" :key="'invoices_'+index">
                                                    <td class="somepad no-border">
                                                        <input type="checkbox" v-model="invoice_form.located_invoices" :value="'invoice_form'+index">
                                                    </td>
                                                    <td class="somepad no-border">{{index+'INV'}}</td>
                                                    <td class="somepad no-border">{{index+'INV'}}</td>
                                                    <td class="somepad no-border">{{index+'INV'}}</td>
                                                    <td class="somepad no-border">{{index+'INV'}}</td>
                                                    <td class="somepad no-border">{{index+'INV'}}</td>
                                                    <td class="zeropad1 no-border">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <input v-bind:class="{'height-30':true}" type="text">
                                                        </div>
                                                    </td>
                                                    <td class="zeropad1 no-border">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <input v-bind:class="{'height-30':true}" type="text">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- Loopable tbody Ends -->

                                            <!-- Total tbody Starts -->
                                            <tbody>
                                                <tr>
                                                    <td colspan="6" class="somepad text-right bg-ced no-border">
                                                        Receipt Amount:
                                                    </td>
                                                    <td class="zeropad bg-ced no-border">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <input disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                                        </div>
                                                    </td>
                                                    <td colspan="1" class="somepad bg-ced no-border">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="somepad text-right bg-ced no-border">
                                                        Allocated Amount:
                                                    </td>
                                                    <td class="zeropad bg-ced no-border">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <input disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                                        </div>
                                                    </td>
                                                    <td colspan="1" class="somepad bg-ced no-border">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="somepad text-right bg-ced no-border">
                                                        Unallocated Amount:
                                                    </td>
                                                    <td class="zeropad bg-ced no-border">
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <input disabled v-bind:class="{'height-30':true}" type="text" value="R 200,000.00">
                                                        </div>
                                                    </td>
                                                    <td colspan="1" class="somepad bg-ced no-border">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- Total tbody Ends -->

                                        </table>
                                    </div>
                                    <!-- ------------------------------------------------Paid Tab Ends Here-------------------------------------------- -->
                                </div>
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-invoices-'+'1'" role="tabpanel" :aria-labelledby="'nav-invoices-tab-'+'1'" :key="'tab_index_'+'1'"></div>
                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===2}" :id="'nav-invoices-'+'2'" role="tabpanel" :aria-labelledby="'nav-invoices-tab-'+'2'" :key="'tab_index_'+'2'"></div>
                            </div>
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
import { createHtmlErrorString } from '../../../../../../helpers/functionmixin';
export default {
    props: ['modal_id','form_data','title','user_mode','bank_api'],
    data(){
        return {
            curr_tab: 0,
            processing: false,
            invoice_form: {
                located_invoices: [],
            }
        }
    },
    methods: {
        toggleTab(toggle_index){
            this.curr_tab = toggle_index;
        },
        process_bank(){
            this.processing = true;
            post(this.bank_api, this.invoice_form)
            .then((res) => {
                if(res.data.status_code === 200) {
                    this.processing = false;
                    this.$awn.success(res.data.description);
                    this.$emit("bankCreated");
                }
            }).catch((err) => {
                if(err.response.status === 422) {
                    this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                }else if (err.response.status === 500){
                    this.$awn.warning(err.response.data.description);
                }
                else{
                    this.processing = false;
                    this.$awn.warning(err.response.data.description);
                }
                this.processing = false;
            });

        }
    },
    mounted(){
        if(this.user_mode === "Edit" || this.user_mode==="View" ){ this.form = this.form_data}
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