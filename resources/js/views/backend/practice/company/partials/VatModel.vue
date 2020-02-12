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
                            <input type="radio"> Invoice Based
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc">
                            <input type="radio"> Payment Based
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc">
                            <input type="radio"> No VAT
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
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Last VAT Period End Date:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Last VAT Submission Due:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">VAT Reporting frequency:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left min-height-250 mg-top-15">
                    <table class="table itemized x-panel">
                        <thead>
                        <tr>
                            <th style="width:50%;">Name</th>
                            <th style="width:15%;" class="text-center">Purchase Rate(%)</th>
                            <th style="width:15%;" class="text-center">Sales Rate(%)</th>
                            <th style="width:10%;" class="text-center">Default</th>
                            <th style="width:10%;" class="text-right"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="padded">General Rated</td>
                                <td class="padded text-center">16</td>
                                <td class="padded text-center">16</td>
                                <td class="padded text-center"><input type="checkbox"></td>
                                <td class="padded"></td>
                            </tr>
                            <tr>
                                <td class="padded">Other Rate</td>
                                <td class="padded text-center">8</td>
                                <td class="padded text-center">8</td>
                                <td class="padded text-center"><input type="checkbox"></td>
                                <td class="padded"></td>
                            </tr>
                            <tr>
                                <td class="padded">Zero Rated</td>
                                <td class="padded text-center">0</td>
                                <td class="padded text-center">0</td>
                                <td class="padded text-center"><input type="checkbox"></td>
                                <td class="padded"></td>
                            </tr>
                            <tr>
                                <td class="padded">Exempt</td>
                                <td class="padded text-center">0</td>
                                <td class="padded text-center">0</td>
                                <td class="padded text-center"><input type="checkbox"></td>
                                <td class="padded"></td>
                            </tr>
                        </tbody>
                    </table>
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
        name: "VatModel",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>