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
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Registered Name:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Registration Number:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Tax Office:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-40-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Entity Type:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-60-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
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
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Region:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-30-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Country:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
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
        name: "AdditionInfo",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>