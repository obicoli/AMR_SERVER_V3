<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-40-pc float-left">
                    <div class="row fullName mg-bottom-5">
                        <div class="inlineBlock width-100-pc mg-left-15">
                            <label class="fullname fw-600 fs-14">Document Messages</label>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left min-height-250 mg-top-15">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Quote&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Sales Orders&nbsp;&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-70-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <input class="width-100-pc report-filters-inputs" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-20-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Customer Invoice&nbsp;&nbsp;</label>
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
        name: "DocMessageModel",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>