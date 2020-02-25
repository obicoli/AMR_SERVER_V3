<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-350">
            <div class="width-100-pc float-left padding-15">
                <div class="width-50-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Regional Settings</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Quantity Decimal Places:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-50-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.qty_decimal_places" class="width-100-pc report-filters-inputs" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Value Decimal Places:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-50-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.value_decimal_places" class="width-100-pc report-filters-inputs" type="number">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Currency Symbol:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-50-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input v-model="form.currency_symbol" class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Date Format:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-50-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select class="" v-model="form.system_date_format" v-bind:class="{'height-32':true,'ctm-attended-field':form.date_format}">
                                    <option value="" disabled selected>--select format--</option>
                                    <option value="d/M/Y">d/M/Y</option>
                                    <option value="d-M-Y">d-M-Y</option>
                                    <option value="d/F/Y">d/F/Y</option>
                                    <option value="d-F-Y">d-F-Y</option>
                                    <option value="M d,Y">M d,Y</option>
                                    <option value="F d,Y">F d,Y</option>
                                    <option value="D M jS, Y">D M jS, Y</option>
                                    <option value="Y-m-d">Y-m-d</option>
                                    <option value="d-m-Y">d-m-Y</option>
                                    <option value="d/m/Y">d/m/Y</option>
                                    <option value="m/d/Y">m/d/Y</option>
                                    <option value="d.m.Y">d.m.Y</option>
                                    <option value="d.M.Y">d.M.Y</option>
                                    <option value="d.F.Y">d.F.Y</option>
                                    <option value="Y-m-d H:i:s">Y-m-d H:i:s</option>
                                </select>
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
        name: "RegionalSettings",
        props: ['api','general_settings'],
        data(){
            return {
                processing: false,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                FORM_ACTIONS: FORM_ACTIONS,
                form: {
                    system_date_format: null,
                    currency_symbol: null,
                    qty_decimal_places: null,
                    value_decimal_places: null,
                }
            }
        },
        watch: {
            general_settings: function (new_data,old_data) {
                this.general_settings = new_data;
                this.form = this.general_settings;
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
                                    this.$emit('rounding-event');
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
            if(this.general_settings){
                this.form = this.general_settings;
            }
        }
    }
</script>

<style scoped>

</style>