<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-40-pc float-left">
                    <div class="row fullName mg-bottom-5">
                        <div class="inlineBlock width-100-pc mg-left-15">
                            <label class="fullname fw-600 fs-14">VAT System</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc">
                            <input v-model="form.vat_system" type="radio" value="Invoice Based"> Invoice Based
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc">
                            <input v-model="form.vat_system" type="radio" value="Payment Based"> Payment Based
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc">
                            <input v-model="form.vat_system" value="No VAT" type="radio"> No VAT
                        </div>
                    </div>
                </div>
                <div class="width-40-pc float-right">
                    <div class="row fullName mg-bottom-5">
                        <div class="inlineBlock width-100-pc mg-left-15">
                            <label class="fullname fw-600 fs-14">VAT Details</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">VAT Number:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.tax_number" required class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Tax agency name:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.agent_name" required class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Last VAT Period End Date:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.last_period_end" disabled class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Last VAT Submission Due:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.last_submission_due" disabled class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">VAT Reporting frequency:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select v-model="form.filling_frequency" required class="width-100-pc report-filters-inputs">
                                    <option value="1">Monthly</option>
                                    <option value="3">Quarterly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Reporting method :&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select v-model="form.reporting_method" required class="width-100-pc report-filters-inputs">
                                    <option value="Accrual Basis">Accrual Basis</option>
                                    <option value="Cash Basis">Cash Basis</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left min-height-250 mg-top-15">
                    <table class="table itemized x-panel">
                        <thead>
                        <tr>
                            <th style="width:40%;">VAT Type</th>
                            <th style="width:15%;" class="text-center">Input Rate(%)</th>
                            <th style="width:15%;" class="text-center">Output Rate(%)</th>
                            <th style="width:15%;" class="text-center">Default</th>
                            <th style="width:15%;" class="text-right"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(vat_type,index) in form.vat_types" :key="'vat_types'+index">
                                <td class="padded">{{vat_type.name}}</td>
                                <td class="padded text-center">{{vat_type.purchase_rate}}</td>
                                <td class="padded text-center">{{vat_type.sales_rate}}</td>
                                <td class="padded text-center"><input type="checkbox" v-model="vat_type.is_default" disabled></td>
                                <td class="padded">
                                    <div class="btn-group float-right" role="group" aria-label="Button group">
                                        <div class="btn-group" role="group">
                                            <a :id="'btnGroupDrop23_'+index" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </a>
                                            <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop23_'+index">
                                                <a @click="setVat(vat_type,'Edit','Edit VAT Type',PRODUCT_TAX_URL+'/'+vat_type.id)" data-toggle="modal" :data-target="'#new_tax_modal_id'" class="dropdown-item pointer-cursor">Edit</a>
                                                <a @click="deleteItem(PRODUCT_TAX_URL+'/'+vat_type.id)" data-toggle="modal" :data-target="'#delete_item_modal_0'" class="dropdown-item pointer-cursor">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="width-100-pc float-left">
                        <a @click="setVat(null,'Create','New VAT Type',PRODUCT_TAX_URL)" data-toggle="modal" data-target="#new_tax_modal_id" class="cl-blue-link fw-600 fs-12">+ Add New VAT Type</a>
                    </div>
                </div>

            </div>

        </div>
        <div class="width-100-pc float-left text-center padding-10">
            <tax-rate :user_mode="user_mode" :title="modal_title" :registration_number="registration_number" :initial_url="initial_url" :form_data="form_data" :modal_id="'new_tax_modal_id'" @vat-rate-event="reportEvent()"></tax-rate>
            <delete-modal
                :modal_title="'Delete VAT Type'"
                :item_url="delete_item_api"
                :confirm_message="'Are you sure?'"
                :modal_id="'delete_item_modal_0'"
                @delete-item-event="reportEvent()">
            </delete-modal>
            <button @click="save_company(FORM_ACTIONS.SAVE_NEW)" :disabled="processing" class="btn btn-secondary banking-process">
                <i v-if="processing" class="fa fa-ban"></i>
                <span v-else>Save</span>
            </button>
            <button @click="save_company(FORM_ACTIONS.SAVE_CLOSE)" :disabled="processing" class="btn btn-secondary banking-process-amref">
                <i v-if="processing" class="fa fa-ban"></i>
                <span v-else>Save & Close</span>
            </button>
            <router-link tag="button" :disabled="processing" :to="INVENTORY_WEB_ROUTES.SCM_WORKSPACE" class="btn btn-secondary banking-process">Cancel</router-link>
        </div>
    </div>
</template>

<script>
    import {PRODUCT_TAX_URL} from '../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    import {FORM_ACTIONS} from "../../../../../helpers/process_status";
    import {post} from "../../../../../helpers/api";
    import TaxRate from '../../partials/modals/inventory_settings/tax/TaxRate';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "VatModel",
        props: ['vat','api'],
        components: {TaxRate,DeleteModal},
        data(){
            return {
                PRODUCT_TAX_URL: PRODUCT_TAX_URL,
                user_mode: 'Create',
                modal_title: 'New VAT Type',
                form_data: null,
                initial_url: PRODUCT_TAX_URL,
                delete_item_api: PRODUCT_TAX_URL,
                processing: false,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                FORM_ACTIONS: FORM_ACTIONS,
                registration_number: null,
                form: {
                    vat_system: 'Invoice Based',
                    obligation: null,
                    tax_number: null,
                    tax_station: null,
                    agent_name: null,
                    filling_frequency: null,
                    reporting_method: null,
                    last_period_end: null,
                    last_submission_due: null,
                    vat_types: [],
                }
            }
        },
        watch: {
            vat: function () {
                if(this.vat){
                    this.registration_number = this.vat.tax_number;
                    this.form = this.vat;
                }
            }
        },
        methods: {
            deleteItem(DEL_API){
                this.delete_item_api = DEL_API;
            },
            reportEvent(){
                this.$emit('vat-settings-event');
            },
            setVat(vat_type,user_mod,title,api){
                this.registration_number = this.vat.tax_number;
                if(vat_type){
                    this.form_data = vat_type;
                    this.form_data.tax_number = this.registration_number;
                }else{
                    this.form_data = this.initializeForm();
                    this.form_data.tax_number = this.registration_number;
                }
                this.user_mode = user_mod;
                this.modal_title = title;
                this.initial_url = api;
            },

            initializeForm(){
                return {
                    collected_on_sales: false,
                    collected_on_purchase: false,
                    name: '',
                    tax_number: this.registration_number,
                    description: '',
                    purchase_rate: 0,
                    sales_rate: 0,
                    is_default: false,
                    status: 1,
                }
            },

            save_company(action_taken){
                this.processing = true;
                if (this.form.country){ this.form.country_id = this.form.country.id; }
                post(this.api,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.processing = false;
                            switch(action_taken){
                                case FORM_ACTIONS.SAVE_NEW:
                                    this.$emit('vat-settings-event');
                                    break;
                                case FORM_ACTIONS.SAVE_CLOSE:
                                    this.$router.push(INVENTORY_WEB_ROUTES.SCM_WORKSPACE);
                                    break;
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
            }
        },
        mounted() {
            if(this.vat){
                this.registration_number = this.vat.tax_number;
                this.form = this.vat;
            }
        }
    }
</script>

<style scoped>

</style>