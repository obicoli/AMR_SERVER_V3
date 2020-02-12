<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Item Settings</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Warn when Item quantities fall below zero:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Do not allow Item quantities below zero:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Warn when Item cost is zero:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Warn when Item selling price is below cost:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Display inactive Items for selection on document lines:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Sales Orders Reserve Item Quantities:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-60-pc fs-12 text-right">
                            Display inactive Item Bundles for selection on document lines:&nbsp;&nbsp;
                        </div>
                        <div class="inlineBlock width-40-pc">
                            <input type="checkbox">
                        </div>
                    </div>

                </div>
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-15">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Price Lists</label>
                        </div>
                    </div>
                    <table class="table itemized x-panel">
                        <thead>
                            <tr>
                                <th style="width:80%;">Description</th>
                                <th style="width:20%;" class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" class="padded text-center">No data to display!</td>
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
        name: "ItemModel",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>