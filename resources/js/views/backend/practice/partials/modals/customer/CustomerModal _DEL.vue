<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="add_customer" class="modal-content">

                <div class="modal-header">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{title}}</h4>
                    <!-- <a class="close float-right" @click="hideModal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a> -->
                </div>

                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="padding-right-10">
                                <div class="row fullName mg-bottom-10">
                                    <div class="inlineBlock width-20-pc mg-right-3">
                                        <label class="fullname" for="firstName">Title</label>
                                        <div class="dijitInline firstName dijitTextBox">
                                            <select v-model="form.title" required v-bind:class="{'ctm-attended-field':form.title}">
                                                <option>-select-</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-25-pc mg-right-3">
                                        <label class="fullname" for="firstName">First name</label>
                                        <div class="dijitInline firstName dijitTextBox">
                                            <input type="text" v-model="form.first_name" v-bind:class="{'ctm-attended-field':form.first_name}">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-25-pc mg-right-3">
                                        <label class="fullname" for="firstName">Middle name</label>
                                        <div class="dijitInline firstName dijitTextBox">
                                            <input type="text" v-model="form.middle_name" v-bind:class="{'ctm-attended-field':form.middle_name}">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-25-pc mg-right-3">
                                        <label class="fullname" for="firstName">Other name</label>
                                        <div class="dijitInline firstName dijitTextBox">
                                            <input v-model="form.other_name" type="text" v-bind:class="{'ctm-attended-field':form.other_name}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Company</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="text" v-model="form.company" v-bind:class="{'ctm-attended-field':form.company}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName mg-bottom-10">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Address</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="form.address" required placeholder="Street" v-bind:class="{'min-height-45':true,'ctm-attended-field':form.address}"></textarea>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                        <div class="dijitInline firstName dijitTextBox" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                                            <input v-model="form.city" v-bind:class="{'height-32':true,'ctm-attended-field':form.city}" placeholder="City/Town/County" name="firstName" required type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc mg-top-4">
                                        <div class="dijitInline firstName dijitTextBox">
                                            <input v-model="form.region" v-bind:class="{'height-32':true,'ctm-attended-field':form.region}" placeholder="Region/Province" type="text" required>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                        <div class="dijitInline firstName dijitTextBox">
                                            <input v-model="form.postal_code" v-bind:class="{'height-32':true,'ctm-attended-field':form.postal_code}" placeholder="Postal code" name="firstName" required type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc mg-top-4">
                                        <div class="dijitInline firstName dijitTextBox">
                                            <input v-model="form.country" v-bind:class="{'height-32':true,'ctm-attended-field':form.country}" placeholder="Country" type="text" required>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-100-pc mg-top-10">
                                        <label class="fullname">Notes</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="form.notes" required placeholder="Notes" v-bind:class="{'min-height-60':true,'ctm-attended-field':form.notes}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="padding-left-10">
                                <div class="row fullName">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="fullname">Email</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.email" v-bind:class="{'height-32':true,'ctm-attended-field':form.email}" type="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-30-pc padding-right-3">
                                        <label class="fullname">Phone</label>
                                        <div class="dijitInline dijitTextBox">
                                            <input v-model="form.phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.phone}" type="text">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-30-pc padding-right-3">
                                        <label class="fullname">Mobile</label>
                                        <div class="dijitInline dijitTextBox">
                                            <input v-model="form.mobile" v-bind:class="{'height-32':true,'ctm-attended-field':form.mobile}" type="number" required>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-30-pc padding-right-3">
                                        <label class="fullname">Fax</label>
                                        <div class="dijitInline dijitTextBox">
                                            <input v-model="form.fax" v-bind:class="{'height-32':true,'ctm-attended-field':form.fax}" type="number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row fullName mg-top-20">
                                    <div class="inlineBlock width-80-pc padding-right-3">
                                        <label class="fullname">Preferred Payment Method</label>
                                        <div class="dijitInline firstName dijitTextBox">
                                            <vue-single-select
                                                    name="maybe"
                                                    placeholder=""
                                                    you-want-to-select-a-post="ok"
                                                    v-model="form.payment_method"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="initializations.payment_methods"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="name"
                                                    :getOptionValue="getType"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fullName">
                                    <div class="inlineBlock width-70-pc">
                                        <label class="fullname">Terms</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <!-- <input v-model="form.terms" list="terms_list" v-bind:class="{'height-32':true,'ctm-attended-field':form.terms}" type="text">
                                            <datalist id="terms_list">
                                                <option value="Due on receipt"></option>
                                            </datalist> -->
                                            <vue-single-select
                                                    name="maybe"
                                                    placeholder=""
                                                    you-want-to-select-a-post="ok"
                                                    v-model="form.customer_term"
                                                    out-of-all-these-posts="makes sense"
                                                    :options="initializations.customer_terms"
                                                    a-post-has-an-id="good"
                                                    the-post-has-a-title="make"
                                                    option-label="name"
                                                    :getOptionValue="getTerm"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fullName">
                                    <div class="inlineBlock width-40-pc padding-right-3">
                                        <label class="fullname">Opening balance</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.balance" v-bind:class="{'height-32':true,'ctm-attended-field':form.balance}" type="number">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-50-pc">
                                        <label class="fullname">as of:</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.as_of" v-bind:class="{'height-32':true,'ctm-attended-field':form.as_of}" type="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-50-pc">
                                        <label class="fullname" for="firstName">Business ID</label>
                                        <div class="dijitInline firstName dijitTextBox">
                                            <input v-model="form.business_id" v-bind:class="{'height-32':true,'ctm-attended-field':form.business_id}" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div  class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-inventory btn-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Save
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                <a @click="add_customer('Save & Close')" class="dropdown-item pointer-cursor"> Save & Close</a>
                                <a @click="add_customer('Save & New')" class="dropdown-item pointer-cursor"> Save & New</a>
                            </div>
                        </div>
                    </div>
                    <button :disabled="processing" type="button" @click="hideModal" class="btn btn-inventory">
                        Close
                    </button>
                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {get,post} from '../../../../../../helpers/api';
    import AppInfo from '../../../../../../helpers/config';
    import {createHtmlErrorString,reset_forms} from '../../../../../../helpers/functionmixin';
    import {SUPPLIERS_URL} from '../../../../../../router/api_routes'
    export default {
        name: "CustomerModal",
        props:['form_data','initial_url','user_mode','modal_id','title','initializations'],
        data(){
            return {
                processing: false,
                form: {
                    notes: '',
                    title: '',
                    city:'',
                    first_name: '',
                    middle_name: '',
                    other_name: '',
                    company: '',
                    address: '',
                    postal_code: '',
                    payment_method: '',
                    payment_method_id: '',
                    customer_term: '',
                    customer_term_id: '',
                    city: '',
                    country: '',
                    email: '',
                    mobile: '',
                    phone: '',
                    business_id: '',
                    fax: '',
                    balance: '',
                    as_of: '',
                    action: '',
                },
            }
        },
        methods: {

            getType(){
                this.form.payment_method_id = this.form.payment_method.id;
            },
            getTerm(){
                this.form.customer_term_id = this.form.customer_term.id
            },
            hideModal(){
                $("#"+this.modal_id).modal('hide');
            },
            add_customer: function (action_taken) {
                this.processing = true;
                post(this.initial_url,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                //this.form = reset_forms(this.form);
                                this.$emit('customerAdded');
                                this.processing = false;
                                switch (action_taken) {
                                    case "Save & Close":
                                        this.hideModal();
                                        break;
                                    case "Save & New":
                                        this.form = reset_forms(this.form);
                                        break;
                                }
                            }else {
                                this.$emit('customerEdited');
                                this.processing = false;
                            }
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
        },
        mounted() {
            
            if(this.user_mode === "Edit"){
                this.form = this.form_data;
            }
        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-content{
        top: 150px!important;
    }
    .modal-lg {
        max-width: 800px!important;
        min-width: 800px!important;
    }
    .modal-header{
        border-bottom: 1px solid #fff!important;
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
</style>