<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Customer Zone Settings</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fw-600 fs-12">
                            <input type="checkbox"> Enable your Accounting Customer Zone
                        </div>
                        <div class="inlineBlock width-100-pc padding-left-15 padding-right-15">
                            <small class="fs-12 cl-9e">This will allow your customers to view invoices online by clicking a link in their email.</small>
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fw-600 fs-12">
                            <input type="radio"> Invoices and Quotes Only
                        </div>
                        <div class="inlineBlock width-100-pc padding-left-15 padding-right-15">
                            <small class="fs-12 cl-9e">Your customers will be able to view their invoices and quotes online (you can also see
                                if your customer has viewed their invoice or quote). Your customers can print their invoices or quotes .</small>
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc fw-600 fs-12">
                            <input type="radio"> Invoices and Account History
                        </div>
                        <div class="inlineBlock width-100-pc padding-left-15 padding-right-15">
                            <small class="fs-12 cl-9e">Your customers will be able to view their invoices and quotes online, print their quotes
                                and invoices. Your customers will also be able to check their account history.</small>
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-5 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Display Name</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-50-pc text-right">
                            <label class="company-label text-right fs-12 width-100-pc">Company name displayed on your Customer Zone:&nbsp;</label>
                        </div>
                        <div class="inlineBlock width-40-pc">
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
        name: "CustomerZone",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>