<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left min-height-250">
                    <div class="row fullName mg-bottom-5">
                        <div class="inlineBlock width-100-pc mg-left-15">
                            <label class="fullname fw-600 fs-14">Financial Years</label>
                        </div>
                    </div>
                    <table class="table itemized x-panel">
                        <thead>
                        <tr>
                            <th style="width:30%;">Financial Year Start</th>
                            <th style="width:30%;">Financial Year End</th>
                            <th style="width:30%;">Current Financial Year</th>
                            <th style="width:10%;"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(financial_year,index) in financial_years">
                                <td class="padded">{{financial_year.financial_year_start}}</td>
                                <td class="padded">{{financial_year.financial_year_end}}</td>
                                <td class="padded text-center"><input type="checkbox" v-model="financial_year.current_accounting_period"></td>
                                <td class="padded">
                                    <div class="btn-group float-right" role="group" aria-label="Button group">
                                        <div class="btn-group" role="group">
                                            <a :id="'btnGroupDrop23_'+index" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </a>
                                            <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop23_'+index">
                                                <a @click="setFinancial(financial_year)" data-toggle="modal" :data-target="'#financial_year_modal'" class="dropdown-item pointer-cursor">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-15">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Lockdown Date</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-15">
                        <div class="inlineBlock width-100-pc padding-left-15 padding-right-15">
                            <small class="fs-12 cl-9e">Setting a Lockdown Date means that no transaction can be processed or edited with a date up to and including this date</small>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Set a Lockdown Date&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-10-pc">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Lockdown Date&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-20-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="date">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="width-100-pc float-left text-center padding-10">
            <a class="btn btn-secondary banking-process">Save</a>
            <a class="btn btn-secondary banking-process-amref">Save & Close</a>
            <router-link :to="INVENTORY_WEB_ROUTES.SCM_WORKSPACE" class="btn btn-secondary banking-process">Cancel</router-link>
        </div>
        <financial-year-modal :modal_id="'financial_year_modal'" :api="api" :financial_year="financial_yr" :modal_title="'Financial Years'" @financial-year-event="reportEvent"></financial-year-modal>
    </div>
</template>

<script>

    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    import FinancialYearModal from "../../partials/modals/settings/FinancialYearModal";

    export default {
        name: "FinancialModel",
        props: ['financial_years','api'],
        components: {FinancialYearModal},
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                financial_yr: null,
            }
        },
        watch: {
            api: function (new_data,old_data) {
                this.api = new_data;
            },
            financial_years: function (new_data,old_data) {
                this.financial_years = new_data;
            }
        },
        methods: {
            reportEvent(){
                this.$emit('financial-year-event')
            },
            setFinancial(financial_year){
                this.financial_yr = financial_year;
            }
        }
    }
</script>

<style scoped>

</style>