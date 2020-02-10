<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="add_supplier" class="modal-content">

                <div class="modal-header">
                    <h4 class="width-100-pc text-left"> {{title}}</h4>
                </div>

                <div class="modal-body padding-bottom-29">
                    <div class="row mg-right-10 mg-left-10">

                        <div class="col-lg-6 col-md-6 mg-bottom-10">
                            <div class="padding-left-15">
                                <div class="row fullName">
                                    <div class="inlineBlock width-25-pc mg-right-3">
                                        <label class="fullname ">Salutation</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-model="form.salutation" required v-bind:class="{'width-100-pc ctm-attended-field':form.salutation}">
                                                <option>-select-</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                                <option value="Miss">Dr</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-35-pc mg-right-3">
                                        <label class="fullname ">First name</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="text" v-model="form.first_name" required v-bind:class="{'width-100-pc ctm-attended-field':form.first_name}">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-35-pc mg-right-3">
                                        <label class="fullname ">Last name</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="text" v-model="form.last_name" required v-bind:class="{'width-100-pc ctm-attended-field':form.last_name}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-97-pc mg-top-4">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <vue-single-select
                                                name="maybe"
                                                placeholder="Start typing to select company"
                                                you-want-to-select-a-post="ok"
                                                v-model="company"
                                                out-of-all-these-posts="makes sense"
                                                :options="companies"
                                                a-post-has-an-id="good"
                                                the-post-has-a-title="make"
                                                option-label="name"
                                            ></vue-single-select>
                                            <!-- <input type="text" placeholder="Company" v-model="form.company" v-bind:class="{'ctm-attended-field':form.company}"> -->
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-97-pc mg-top-4">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="text" placeholder="Display name as" v-model="form.display_as" v-bind:class="{'ctm-attended-field':form.display_name}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <!-- ============================Email Panel=================== -->
                            <div class="padding-right-10 padding-left-10">
                                <div class="row fullName">
                                    <div class="inlineBlock width-97-pc">
                                        <label class="fullname ">Email</label>
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="email" placeholder="Email" required v-model="form.email" v-bind:class="{'ctm-attended-field':form.email}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName">
                                    <div class="inlineBlock width-60-pc mg-right-3 mg-top-4">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="text" v-model="form.phone" placeholder="Phone" v-bind:class="{'width-100-pc ctm-attended-field':form.phone}">
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-60-pc mg-top-4">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input type="number" placeholder="Mobile" required v-model="form.mobile" v-bind:class="{'width-100-pc ctm-attended-field':form.mobile}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================Email Panel Ends Here=================== -->
                        </div>

                        <div class="col-lg-12 col-md-12 mg-top-20">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link nav-link-modals active" id="nav-address-tab" data-toggle="tab" href="#nav-address" role="tab" aria-controls="nav-address" aria-selected="true">Address</a>
                                    <a class="nav-item nav-link nav-link-modals" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false">Notes</a>
                                    <a class="nav-item nav-link nav-link-modals" id="nav-tax-tab" data-toggle="tab" href="#nav-tax" role="tab" aria-controls="nav-tax" aria-selected="false">Tax Info</a>
                                    <a class="nav-item nav-link nav-link-modals" id="nav-payments-tab" data-toggle="tab" href="#nav-payments" role="tab" aria-controls="nav-payments" aria-selected="false">Payment&Billing</a>
                                    <a class="nav-item nav-link nav-link-modals" id="nav-attaches-tab" data-toggle="tab" href="#nav-attaches" role="tab" aria-controls="nav-attaches" aria-selected="false">Attachments</a>
                                </div>
                            </nav>
                            <div class="tab-content tab-content-modal" id="nav-tabContent">
                                <!-- =================Address Tab Starts here=================== -->
                                <div class="tab-pane fade show active" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
                                    <div class="row mg-right-10 mg-left-10">
                                        <div class="col-lg-6">
                                            <div class="padding-right-10 padding-top-30">
                                                <div class="row fullName mg-bottom-10">
                                                    <div class="inlineBlock width-100-pc">
                                                        <label class="fullname">Billing Address</label>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="form.billing.address" required placeholder="Address" v-bind:class="{'min-height-60':true,'ctm-attended-field':form.billing.address}"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <div class="dijitInline firstName dijitTextBox"  role="presentation" >
                                                            <input v-model="form.billing.city" v-bind:class="{'height-32':true,'ctm-attended-field':form.billing.city}" placeholder="City/Town/County" required type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input v-model="form.billing.region" v-bind:class="{'height-32':true,'ctm-attended-field':form.billing.region}" placeholder="Region/Province" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input v-model="form.billing.postal_code" v-bind:class="{'height-32':true,'ctm-attended-field':form.billing.postal_code}" placeholder="Postal code" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <!-- <input v-model="form.billing.country" v-bind:class="{'height-32':true,'ctm-attended-field':form.billing.country}" placeholder="Country" type="text"> -->
                                                            <vue-single-select
                                                                name="maybe"
                                                                placeholder="Country"
                                                                you-want-to-select-a-post="ok"
                                                                v-model="form.billing.country"
                                                                out-of-all-these-posts="makes sense"
                                                                :options="countries"
                                                                a-post-has-an-id="good"
                                                                the-post-has-a-title="make"
                                                                option-label="name"
                                                            ></vue-single-select>
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-100-pc mg-top-4">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input placeholder="Zip Code" v-model="form.billing.zip_code" v-bind:class="{'height-32':true,'ctm-attended-field':form.billing.zip_code}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input placeholder="Phone" v-model="form.billing.phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.billing.phone}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input placeholder="Fax" v-model="form.billing.fax" v-bind:class="{'height-32':true,'ctm-attended-field':form.billing.fax}" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="padding-left-10 padding-top-30">
                                                <div class="row fullName mg-bottom-10">
                                                    <div class="inlineBlock width-100-pc">
                                                        <label class="fullname">Shipping Address <a @click="copy_address" class="float-right cl-blue-link"><i class="fa fa-arrow-down"></i> copy billing address</a></label>
                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                            <textarea v-model="form.shipping.address" required placeholder="Address" v-bind:class="{'min-height-60':true,'ctm-attended-field':form.shipping.address}"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <div class="dijitInline firstName dijitTextBox"  role="presentation" >
                                                            <input v-model="form.shipping.city" v-bind:class="{'height-32':true,'ctm-attended-field':form.shipping.city}" placeholder="City" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <div class="dijitInline firstName dijitTextBox">
                                                            <input v-model="form.shipping.region" v-bind:class="{'height-32':true,'ctm-attended-field':form.shipping.region}" placeholder="Region" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <div class="dijitInline firstName dijitTextBox">
                                                            <input v-model="form.shipping.postal_code" v-bind:class="{'height-32':true,'ctm-attended-field':form.shipping.postal_code}" placeholder="Postal code" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <div class="dijitInline firstName dijitTextBox">
                                                            <vue-single-select
                                                                name="maybe"
                                                                placeholder="Country"
                                                                you-want-to-select-a-post="ok"
                                                                v-model="form.shipping.country"
                                                                out-of-all-these-posts="makes sense"
                                                                :options="countries"
                                                                a-post-has-an-id="good"
                                                                the-post-has-a-title="make"
                                                                option-label="name"
                                                            ></vue-single-select>
                                                            <!-- <input v-model="form.shipping.country" v-bind:class="{'height-32':true,'ctm-attended-field':form.shipping.country}" placeholder="Country" type="text"> -->
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-100-pc mg-top-4">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input placeholder="Zip Code" v-model="form.shipping.zip_code" v-bind:class="{'height-32':true,'ctm-attended-field':form.shipping.zip_code}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input placeholder="Phone" v-model="form.shipping.phone" v-bind:class="{'height-32':true,'ctm-attended-field':form.shipping.phone}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <input placeholder="Fax" v-model="form.shipping.fax" v-bind:class="{'height-32':true,'ctm-attended-field':form.shipping.fax}" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- =================Address Tab Ends here=================== -->
                                <!-- ========================Notes Tab Starts here================== -->
                                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                                    <div class="row mg-right-10 mg-left-10">
                                        <div class="col-lg-12">
                                            <div class="row fullName mg-bottom-10">
                                                <div class="inlineBlock width-100-pc">
                                                    <label class="fullname fs-12 ">Notes</label>
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <textarea v-model="form.notes" v-bind:class="{'min-height-120':true,'ctm-attended-field':form.notes}"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ========================Notes Tab Ends here================== -->

                                <!-- ========================Tax Info Tab Starts here================== -->
                                <div class="tab-pane fade min-height-120" id="nav-tax" role="tabpanel" aria-labelledby="nav-tax-tab">
                                    <div class="row mg-right-10 mg-left-10">
                                        <div class="col-lg-6">
                                            <div class="row fullName mg-bottom-10">
                                                <div class="inlineBlock width-100-pc">
                                                    <label class="fullname fs-12 ">Tax Reg No.</label>
                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                        <input v-model="form.tax_reg_number" v-bind:class="{'height-32':true,'ctm-attended-field':form.tax_reg_number}" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ========================Tax Info Tab Ends here================== -->

                                <!-- ========================Payment & Billing Info Tab Starts here================== -->
                                <div class="tab-pane fade" id="nav-payments" role="tabpanel" aria-labelledby="nav-payments-tab">
                                    <div class="row mg-right-10 mg-left-10">
                                        <div class="col-lg-6">
                                            <div class="padding-right-10 padding-top-30">
                                                <div class="row fullName mg-bottom-10">
                                                    <div class="inlineBlock width-100-pc mg-top-4 padding-right-3">
                                                        <label class="fullname">Currency</label>
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <!-- <input v-model="form.currency" v-bind:class="{'height-32':true,'ctm-attended-field':form.currency}" placeholder="Currency" type="text"> -->
                                                            <vue-single-select
                                                                name="maybe"
                                                                placeholder=""
                                                                you-want-to-select-a-post="ok"
                                                                v-model="form.currency"
                                                                out-of-all-these-posts="makes sense"
                                                                :options="countries"
                                                                a-post-has-an-id="good"
                                                                the-post-has-a-title="make"
                                                                option-label="display_as"
                                                            ></vue-single-select>
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-100-pc mg-top-4">
                                                        <label class="fullname">Payment Terms <a class="float-right cl-blue-link">+new</a> </label>
                                                        <div class="dijitInline firstName width-100-pc dijitTextBox">
                                                            <vue-single-select
                                                                name="maybe"
                                                                placeholder=""
                                                                you-want-to-select-a-post="ok"
                                                                v-model="payment_term"
                                                                out-of-all-these-posts="makes sense"
                                                                :options="accountings.supplier_terms"
                                                                a-post-has-an-id="good"
                                                                the-post-has-a-title="make"
                                                                option-label="name"
                                                            ></vue-single-select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="padding-left-10 padding-top-30">
                                                <div class="row fullName mg-bottom-10">
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <label class="fullname">Opening Balance</label>
                                                        <div class="dijitInline firstName dijitTextBox"  role="presentation" >
                                                            <input v-model="form.balance" v-bind:class="{'height-32':true,'ctm-attended-field':form.balance}" type="number">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <label class="fullname">As of</label>
                                                        <div class="dijitInline firstName dijitTextBox">
                                                            <input v-model="form.as_of" v-bind:class="{'height-32':true,'ctm-attended-field':form.as_of}" type="date">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4 padding-right-3">
                                                        <label class="fullname">Account Number</label>
                                                        <div class="dijitInline firstName dijitTextBox">
                                                            <input v-model="form.account_number" v-bind:class="{'height-32':true,'ctm-attended-field':form.account_number}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="inlineBlock width-50-pc mg-top-4">
                                                        <label class="fullname">Business ID</label>
                                                        <div class="dijitInline firstName dijitTextBox">
                                                            <input v-model="form.business_id" v-bind:class="{'height-32':true,'ctm-attended-field':form.business_id}" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ========================Payment & Billing Info Tab Ends here================== -->
                                <div class="tab-pane fade" id="nav-attaches" role="tabpanel" aria-labelledby="nav-attaches-tab">
                                    <div class="row mg-right-10 mg-left-10">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button :disabled="processing" type="submit" class="btn btn-default btn-inventory btn-amref cl-white">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                        <span v-else>Save</span>
                    </button>
                    <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-default btn-inventory btn-gray txt-uppercase">
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
    import {SUPPLIERS_URL} from '../../../../../../router/api_routes';
    import {ADDRESS_TYPES} from '../../../../../../helpers/process_status';
    export default {
        name: "SupplierModal",
        props:['form_data','initial_url','user_mode','modal_id','countries','companies','accountings','title','initializations'],
        data(){
            return {
                processing: false,
                form: {
                    salutation: null,
                    notes: null,
                    first_name: null,
                    last_name: null,
                    company: null,
                    display_name: null,
                    email: null,
                    mobile: null,
                    phone: null,
                    billing: {
                        address: null,
                        city: null,
                        region: null,
                        postal_code: null,
                        country: null,
                        zip_code: null,
                        phone: null,
                        fax: null,
                        type: ADDRESS_TYPES.BILLING,
                    },
                    shipping: {
                        address: null,
                        city: null,
                        region: null,
                        postal_code: null,
                        country: null,
                        zip_code: null,
                        phone: null,
                        fax: null,
                        type: ADDRESS_TYPES.SHIPPING,
                    },
                    currency: null,
                    payment_term: null,
                    balance: null,
                    as_of: null,
                    business_id: null,
                    account_number: null,
                    tax_reg_number: null,
                },
                currency: null,
                payment_term: null,
                country: null,
                company: null,
            }
        },
        methods: {

            copy_address(){
                this.form.shipping = this.form.billing;
                this.form.shipping.type = ADDRESS_TYPES.BILLING;
            },

            add_supplier: function () {
                this.processing = true;
                //
                if(this.currency){ this.form.currency = this.currency.id;}
                if(this.payment_term){ this.form.payment_term = this.payment_term.id; }
                if(this.company){ this.form.company = this.company.id; }

                post(this.initial_url,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                //this.form = reset_forms(this.form);
                                this.$emit('supplierAdded',res.data.results);
                                this.processing = false;
                            }else {
                                this.$emit('supplierEdited');
                                this.processing = false;
                            }
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },
        },
        mounted() {
            if(this.user_mode === "Edit"){
                this.form = this.form_data;
            }
        },
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-content{
        top: 50px!important;
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