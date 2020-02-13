<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">
            <div class="width-100-pc float-left padding-15">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Company Details</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Company Name:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.name" required :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.name}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Telephone:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.phone" :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.phone}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Fax:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.fax" required :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.fax}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Mobile:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.mobile" required :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.mobile}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Contact Name:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.legal_name" required :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.legal_name}" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-45-pc float-left padding-top-30">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Email:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.email" required :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.email}" type="email">
                            </div>
                        </div>
                    </div>
<!--                    <div class="row fullName mg-bottom-10 mg-left-30">-->
<!--                        <div class="inlineBlock width-30-pc text-right">-->
<!--                            <label class="company-label text-right fs-12 width-100-pc"></label>-->
<!--                        </div>-->
<!--                        <div class="inlineBlock width-70-pc">-->
<!--                            <input type="checkbox"> Use this Email for Communication-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Website:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.website" :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.website}" type="text">
                            </div>
                        </div>
                    </div>
<!--                    <div class="row fullName mg-bottom-2 mg-left-30">-->
<!--                        <div class="inlineBlock width-30-pc text-right">-->
<!--                            <label class="company-label text-right fs-12 width-100-pc"></label>-->
<!--                        </div>-->
<!--                        <div class="inlineBlock width-70-pc">-->
<!--                            <input type="checkbox"> Always CC this Email Address-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="width-100-pc float-left padding-15">
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Postal Address</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.city" placeholder="City/Town" :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.city}" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.region" placeholder="Region/Province" type="text" :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.region}">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.postal_code" placeholder="Postal Code" type="text" :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.postal_code}">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.zip_code" placeholder="Zip Code" type="text" :class="{'width-100-pc report-filters-inputs':true,'att-grey':form.zip_code}">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Country:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
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
                <div class="width-45-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Physical Address or other Company Information</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <textarea v-model="form.address" placeholder="Address" :class="{'width-100-pc min-height-90':true,'att-grey':form.address}"></textarea>
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
    import {FORM_ACTIONS} from "../../../../../helpers/process_status";
    import {post} from "../../../../../helpers/api";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "CompanyDetailModel",
        props: ['company','countries','api'],
        data(){
            return {
                processing: false,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                FORM_ACTIONS: FORM_ACTIONS,
                country: null,
                form: {
                    name: null,
                    phone: null,
                    fax: null,
                    mobile: null,
                    legal_name: null,
                    email: null,
                    cc_email: null,
                    address: null,
                    city: null,
                    region: null,
                    postal_code: null,
                    zip_code: null,
                    country: null,
                },
            }
        },
        watch: {
            company: function (new_data,old_data) {
                this.company = new_data;
            },
            api: function (new_data,old_data) {
                this.api = new_data;
            }
        },
        methods: {
            setModel(){
                this.form = this.company;
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
                                    this.$emit('company-detail-event');
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
            if (this.company){
                this.setModel();
            }
        }
    }
</script>

<style scoped>

</style>