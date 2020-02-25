<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Customer and Supplier Settings</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Warn when duplicate Customer Reference used on Customer Invoices
                                <input type="checkbox" v-model="form.warn_dup_reference">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Warn when duplicate Supplier Invoice number used on Supplier Invoices
                                <input type="checkbox" v-model="form.warn_dup_invoice_number">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Display inactive Customers for selection when processing
                                <input type="checkbox" v-model="form.inactive_customer_processing">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Display inactive Suppliers for selection when processing
                                <input type="checkbox" v-model="form.inactive_suppliers_processing">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Display inactive Customers for selection on reports
                                <input type="checkbox" v-model="form.inactive_customer_reports">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Display inactive Suppliers for selection on reports
                                <input type="checkbox" v-model="form.inactive_suppliers_reports">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Use inclusive processing on customer documents by default
                                <input type="checkbox" v-model="form.use_inclusive_customer_docs">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Use inclusive processing on supplier documents by default
                                <input type="checkbox" v-model="form.use_inclusive_suppliers_docs">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Use Account as default document line type selection
                                <input type="checkbox" v-model="form.account_as_default_selection">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="width-100-pc float-left text-center padding-10">
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
    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    import {post} from "../../../../../helpers/api";
    import {FORM_ACTIONS} from "../../../../../helpers/process_status";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "CustomerSupplierSettings",
        props: ['customer_supplier_setting','api'],
        data(){
            return {
                processing: false,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                FORM_ACTIONS: FORM_ACTIONS,
                form: {
                    warn_dup_reference: false,
                    warn_dup_invoice_number: false,
                    inactive_customer_processing: false,
                    inactive_customer_reports: false,
                    inactive_suppliers_processing: false,
                    inactive_suppliers_reports: false,
                    use_inclusive_suppliers_docs: false,
                    use_inclusive_customer_docs: false,
                    account_as_default_selection: false,
                }
            }
        },
        watch: {
            customer_supplier_setting: function () {
                if(this.customer_supplier_setting){
                    this.form = this.customer_supplier_setting;
                }
            }
        },
        methods: {
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
                                    this.$emit('customer-supplier-event');
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
            if(this.customer_supplier_setting){
                this.form = this.customer_supplier_setting;
            }
        }
    }
</script>

<style scoped>

</style>