<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Customer and Supplier Settings</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Warn when duplicate Customer Reference used on Customer Invoices:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Warn when duplicate Supplier Invoice number used on Supplier Invoices:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Display inactive Customers for selection when processing:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Display inactive Suppliers for selection when processing:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Display inactive Customers for selection on reports:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Display inactive Suppliers for selection on reports:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Use inclusive processing on customer/supplier documents by default:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Use Account as default document line type selection:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
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
        name: "CustomerSupplierSettings",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>