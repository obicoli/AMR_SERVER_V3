<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">
            <div class="width-100-pc float-left padding-15">
                <div class="width-50-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Statutory Information</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Company Tax Number:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.tax_number" class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Registered Name:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.registered_name" class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Registration Number:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.registration_number" class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Tax Station:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.tax_office" class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Entity Type:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select v-model="form.entity_type" class="width-100-pc report-filters-inputs">
                                    <option value="Co-operative Society">Co-operative Society</option>
                                    <option value="Limited Liability Company">Limited Liability Company</option>
                                    <option value="Partnership">Partnership</option>
                                    <option value="Sole Proprietorship">Sole Proprietorship</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Additional Company Information</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">City:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.city" class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Region:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.region" class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Country:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
<!--                                <input v-model="form.tax_number" class="width-100-pc report-filters-inputs" type="text">-->
                                <vue-single-select
                                    name="maybe"
                                    placeholder="Country"
                                    you-want-to-select-a-post="ok"
                                    v-model="form.country"
                                    out-of-all-these-posts="makes sense"
                                    :options="countries"
                                    a-post-has-an-id="good"
                                    the-post-has-a-title="make"
                                    option-label="name"
                                ></vue-single-select>
                            </div>
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
        name: "AdditionInfo",
        props: ['statutory','countries','api'],
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                FORM_ACTIONS: FORM_ACTIONS,
                processing: false,
                form: {
                    tax_number: null,
                    registered_name: null,
                    registration_number: null,
                    tax_office: null,
                    entity_type: 'Co-operative Society',
                    city: null,
                    region: null,
                    country_id: null,
                }
            }
        },
        watch: {
            statutory: function (new_data,old_data) {
                this.statutory = new_data;
            },
            api: function (new_data,old_data) {
                this.api = new_data;
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
            if (this.statutory){
                this.form = this.statutory;
            }
        }
    }
</script>

<style scoped>

</style>