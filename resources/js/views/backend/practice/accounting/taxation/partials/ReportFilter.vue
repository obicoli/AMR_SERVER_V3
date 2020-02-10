<template>
    <div v-if="is_ready" class="width-100-pc float-left">
        <div v-if="!refresh" class="width-100-pc float-left mg-top-15">
            <div class="width-100-pc float-left mg-top-15 text-center">
                <label class="fs-16 fw-600">Report Options</label>
            </div>
        </div>
        <div class="width-100-pc float-left">
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">View Report By:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.view_by">
                            <option :value="VIEW_BY.VAT_PERIOD">{{VIEW_BY.VAT_PERIOD}}</option>
                            <option :value="VIEW_BY.DATE">{{VIEW_BY.DATE}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <small v-if="report_options.view_by===VIEW_BY.VAT_PERIOD" class="fs-11">{{VIEW_BY.PERIOD_DESC}}</small>
                        <small v-else class="fs-11">{{VIEW_BY.DATE_DESC}}</small>
                    </div>
                </div>
            </div>
            <div v-if="report_options.view_by===VIEW_BY.VAT_PERIOD" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">VAT Period:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder=""
                            you-want-to-select-a-post="ok"
                            v-model="tax_return"
                            out-of-all-these-posts="makes sense"
                            :options="tax_returns"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="reference_number"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div v-else class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">VAT Period End Date:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <datetime 
                            v-model="report_options.period_end_date"
                            :input-id="'date_input_'"
                            placeholder="select date"
                            use12-hour
                            :type="'date'"
                            :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                            :value="report_options.period_end_date"
                            >
                        </datetime>
                    </div>
                </div>
            </div>
            <div v-if="report_options.view_by===VIEW_BY.DATE" class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Date Range:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <select :disabled="is_initializing" v-model="report_options.date_range">
                            <option :value="1">1 Month</option>
                            <option :value="2">2 Months</option>
                            <option :value="3">3 Months</option>
                            <option :value="4">4 Months</option>
                            <option :value="5">5 Months</option>
                            <option :value="6">6 Months</option>
                            <option :value="12">12 Months</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">VAT Type:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-40-pc">
                        <vue-single-select
                            name="maybe"
                            placeholder=""
                            you-want-to-select-a-post="ok"
                            v-model="vat_type"
                            out-of-all-these-posts="makes sense"
                            :options="vat_types"
                            a-post-has-an-id="good"
                            the-post-has-a-title="make"
                            option-label="display_as"
                        ></vue-single-select>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Style:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc fs-12">
                    <input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.style" value="Summary"> Summary&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.style" value="Detailed"> Detailed
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Basis:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc fs-12">
                    <input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.basis" value="Cash"> Cash&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.basis" value="Accrual"> Accrual
                </div>
            </div>
            <div class="row fullName mg-bottom-5 mg-left-30">
                <div class="inlineBlock width-30-pc text-right">
                    <label class="company-label text-right fs-12 width-100-pc">Include:&nbsp;&nbsp;</label>
                </div>
                <div class="inlineBlock width-70-pc mg-bottom-3 fs-12 padding-top-5 fs-12">
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.includes" value="VAT Adjustments"> VAT Adjustments&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.includes" value="No VAT Transactions"> No VAT Transactions&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" :disabled="is_initializing" class="pointer-cursor" v-model="report_options.includes" value="VAT Payments and Refunds Total on Summary"> VAT Payments and Refunds Total on Summary&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
            </div>
        </div>
        <div class="width-100-pc float-left text-center mg-top-10">
            <div v-if="is_initializing" class="width-100-pc float-left text-center">
                <img class="loader" src="/assets/icons/dashboard/loader.gif">
            </div>
        </div>
        <div class="width-100-pc float-left text-center mg-top-5">
            <button v-if="refresh" @click="loadReports()" :disabled="is_initializing" type="button" class="btn btn-secondary banking-process-amref">Refresh</button>
            <button v-if="!refresh" @click="loadReports()" :disabled="is_initializing" type="button" class="btn btn-secondary banking-process-amref">View Report</button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">Print Report</button>
            <button v-if="!refresh" type="button" :disabled="is_initializing" class="btn btn-secondary banking-process">Email Report</button>
        </div>
    </div>
</template>
<script>
import {VAT_OPTIONS} from "../../../../../../helpers/process_status";
import {get} from "../../../../../../helpers/api";
import {ACCOUNTS_TAX_RETURNS} from "../../../../../../router/api_routes";
export default {
    props: ['report_opt','report_type','refresh','tax_returns','vat_types','reported_data'],
    data(){
        return {
            is_initializing: false,
            vat_type:null,
            tax_return: null,
            is_ready: false,
            report_data: [],
            VIEW_BY: VAT_OPTIONS.VIEW_BY,
            report_options: null
        }
    },
    methods: {
        loadReports(){
            this.$emit("report-options-event",this.report_options);
            this.is_initializing = true;
            if(this.tax_return){this.report_options.vat_return_id = this.tax_return.id;}
            if(this.vat_type){this.report_options.vat_type_id = this.vat_type.id;}
            get(ACCOUNTS_TAX_RETURNS+'/reports?filters='+JSON.stringify(this.report_options))
            .then((res) => {
                if(res.data.status_code === 200) {
                    this.reported_data.push(res.data.results);
                    console.info(res.data.results);
                    this.is_initializing = false;
                    this.$emit("report-data-event",this.reported_data);
                }
            }).catch((err) => {
                this.progress_overlay = "hide";
                this.page_loaded = false;
                if(err.response.status === 422) {
                    this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                }else if (err.response.status === 500){
                    this.$awn.warning(err.response.data.description);
                }
                else{
                    this.processing = false;
                    this.$awn.warning(err.response.data.description);
                }
                this.is_initializing = false;
            });
        },
    },
    mounted(){
        if(this.report_opt){
            this.report_options = this.report_opt;
            this.is_ready = true;
        }
    }
}
</script>