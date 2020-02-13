<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Customer Zone Settings</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fw-600 fs-12">
                            <input v-model="form.accounting_zone" type="checkbox"> Enable your Accounting Customer Zone
                        </div>
                        <div class="inlineBlock width-100-pc padding-left-15 padding-right-15">
                            <small class="fs-12 cl-9e">This will allow your customers to view invoices online by clicking a link in their email.</small>
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fw-600 fs-12">
                            <input v-model="form.invoice_and_quotes" :value="true" type="radio"> Invoices and Quotes Only
                        </div>
                        <div class="inlineBlock width-100-pc padding-left-15 padding-right-15">
                            <small class="fs-12 cl-9e">Your customers will be able to view their invoices and quotes online (you can also see
                                if your customer has viewed their invoice or quote). Your customers can print their invoices or quotes.
                            </small>
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc fw-600 fs-12">
                            <input v-model="form.invoice_and_quotes" :value="false" type="radio"> Invoices and Account History
                        </div>
                        <div class="inlineBlock width-100-pc padding-left-15 padding-right-15">
                            <small class="fs-12 cl-9e">Your customers will be able to view their invoices and quotes online, print their quotes
                                and invoices. Your customers will also be able to check their account history.
                            </small>
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
    import {FORM_ACTIONS} from "../../../../../helpers/process_status";
    import {post} from "../../../../../helpers/api";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "CustomerZone",
        props: ['customer_zone','api'],
        data(){
            return {
                processing: false,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                FORM_ACTIONS: FORM_ACTIONS,
                form: {
                    accounting_zone: false,
                    invoice_and_quotes: false,
                }
            }
        },
        watch: {
            customer_zone: function (new_data,old_data) {
                this.customer_zone = new_data;
            },
            api: function (new_data,old_data) {
                this.api = new_data;
            }
        },
        methods: {
            save_company(action_taken){
                this.processing = true;
                post(this.api,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.processing = false;
                            switch(action_taken){
                                case FORM_ACTIONS.SAVE_NEW:
                                    this.$emit('addition-info-event');
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
            if (this.customer_zone){
                this.form = this.customer_zone;
            }
        }
    }
</script>

<style scoped>

</style>