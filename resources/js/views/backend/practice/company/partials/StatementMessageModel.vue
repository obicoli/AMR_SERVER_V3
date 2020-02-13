<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-40-pc float-left">
                    <div class="row fullName mg-bottom-5">
                        <div class="inlineBlock width-100-pc mg-left-15">
                            <label class="fullname fw-600 fs-14">Statement Messages</label>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left min-height-250 mg-top-15">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <small class="text-right fs-12">When you print statements, each statement shows the customer's outstanding balances.
                                You can also include a message on the statement depending on the customer's overdue status</small>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Current&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">In 30 Days&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">In 60 Days&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">In 90 Days&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">In 120+ Days&nbsp;&nbsp;</label>
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
        name: "StatementMessageModel",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>