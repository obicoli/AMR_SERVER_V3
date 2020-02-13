<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5">
                        <div class="inlineBlock width-100-pc mg-left-15">
                            <label class="fullname fw-600 fs-14">Email Signatures</label>
                        </div>
                    </div>
                </div>
                <div class="width-100-pc float-left min-height-250 mg-top-15">
                    <table class="table itemized x-panel">
                        <thead>
                            <tr>
                                <th style="width:35%;">Document Type</th>
                                <th style="width:35%;" class="">Email Subject</th>
                                <th style="width:15%;" class="text-center">Preview</th>
                                <th style="width:15%;" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="padded">General Rated</td>
                                <td class="padded">16</td>
                                <td class="padded text-center">16</td>
                                <td class="padded text-center"></td>
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
        name: "MailSignatureModel.vue",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>