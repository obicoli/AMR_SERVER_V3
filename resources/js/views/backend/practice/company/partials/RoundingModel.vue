<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-350">
            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Rounding</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fs-12">
                            You can set Accounting to round customer document values. To do this, choose the type of
                            rounding you wish to use and then specify the amount to round to.
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fs-12">
                            The value you are entering here is the number of cents.
                        </div>
                    </div>
                </div>
                <div class="width-50-pc float-left">
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Rounding Type:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-50-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select>
                                    <option>No Rounding</option>
                                    <option>Round Up</option>
                                    <option>Normal Rounding</option>
                                    <option>Round Down</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Round To Nearest:&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-50-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="number">
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
        name: "RoundingModel",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>