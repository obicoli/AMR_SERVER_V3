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
                            <tr>
                                <td class="padded">01/01/2019</td>
                                <td class="padded">01/01/2019</td>
                                <td class="padded text-center"><input type="checkbox"></td>
                                <td class="padded"></td>
                            </tr>
                            <tr>
                                <td class="padded">01/01/2019</td>
                                <td class="padded">01/01/2019</td>
                                <td class="padded text-center"><input type="checkbox" checked></td>
                                <td class="padded"></td>
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
                            <input type="checkbox">
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
    </div>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";

    export default {
        name: "FinancialModel",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>