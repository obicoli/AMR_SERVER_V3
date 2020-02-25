<template>
    <div class="width-100-pc float-left">
        <div class="width-100-pc float-left bg-white min-height-400">

            <div class="width-100-pc float-left padding-15">
                <div class="width-100-pc float-left">
                    <div class="row fullName mg-bottom-5 mg-left-30">
                        <div class="inlineBlock width-100-pc">
                            <label class="fullname fw-600 fs-14">Outstanding Balances</label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fs-12">
                            Ageing refers to the number of days that a Customer or a Supplier balance is outstanding.
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc width-100-pc fs-12">
                            Customer and Supplier ageing can work monthly or based on the number of days from the date of the invoice. Ageing is found on
                            the Days Outstanding Reports, Statements and the Days Outstanding Graph on the Dashboard.
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc fs-12">
                            Use the Monthly ageing option if you want to display unpaid invoices outstanding by calendar month.
                            The Current value will represent all unpaid invoices raised in the current month. The 30 Days value will
                            represent all unpaid invoices raised in the previous month, and so on.
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc">
                            Deselect this option if you want ageing to work on the actual number of days
                        </div>
                        <div class="inlineBlock width-100-pc">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Monthly
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row fullName mg-bottom-2 mg-left-30 mg-top-20">
                        <div class="inlineBlock width-100-pc mg-bottom-10">
                            The ageing option can be determined based on either the Invoice Date or the Due Date.
                        </div>
                        <div class="width-20-pc float-left text-right">
                            Run Ageing Based On:&nbsp;&nbsp;
                        </div>
                        <div class="float-left width-20-pc">
                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                <select class="width-100-pc report-filters-inputs">
                                    <option>Invoice Date</option>
                                    <option>Due Date</option>
                                </select>
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
        name: "OutstandingBalance",
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        }
    }
</script>

<style scoped>

</style>