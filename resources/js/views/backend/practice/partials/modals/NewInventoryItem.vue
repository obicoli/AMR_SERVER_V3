<template>

    <div id="inventoryItemModal" class="overlay">

        <div class="overlay-content">
            <aside>
                <header class="header header-side">
                    <div class="form-header height-60 width-100-pc">
                        <h4 class="float-left width-80-pc mg-left-10 mg-top-10"><span>Add Tax</span></h4>
                        <a @click="closeModal()" class="float-right mg-right-10"><i class="fa fa-close"></i></a>
                    </div>
                </header>
                <section class="content content-sider">
                    <div class="new-tax">
                        <form class="padding-left-20">
                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-12">
                                    <p>
                                        <span>Create a name for your tax rate, and give a few details about how you track it.</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Tax name:</label>
                                    <input type="text" v-model="tax_form.name" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':tax_form.name}">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Description:</label>
                                    <textarea v-model="tax_form.description" required v-bind:class="{'form-control product-entry-input-field min-height-60':true,'attended_field':tax_form.description}"></textarea>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Tax agency name:</label>
                                    <input type="text" v-model="tax_form.agent_name" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':tax_form.agent_name}">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Registration number:(optional)</label>
                                    <input type="text" v-model="tax_form.registration_number" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':tax_form.registration_number}">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Start of the current tax period</label>
                                    <select @change="setField($event,'start_period')" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':tax_form.start_period}">
                                        <option value="">-select-</option>
                                        <option value="1">Jan</option>
                                        <option value="2">Feb</option>
                                        <option value="3">Mar</option>
                                        <option value="4">Apr</option>
                                        <option value="5">May</option>
                                        <option value="6">Jun</option>
                                        <option value="7">Jul</option>
                                        <option value="8">Aug</option>
                                        <option value="9">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Filling frequency</label>
                                    <select @change="setField($event,'filling_frequency')"  v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':tax_form.filling_frequency}">
                                        <option value="">-select-</option>
                                        <option>Monthly</option>
                                        <option>Quarterly</option>
                                        <option>Half-yearly</option>
                                        <option>Yearly</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Reporting method</label>
                                    <select @change="setField($event,'reporting_methods')"  v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':tax_form.reporting_method}">
                                        <option value="">-select-</option>
                                        <option>Accrual</option>
                                        <option>Cash</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label class="check-container element-inlined">This tax is collected on sales:
                                        <input type="checkbox" v-model="tax_form.collected_on_sales">
                                        <span class="checkmark"></span>
                                    </label><br>
                                    <div v-if="tax_form.collected_on_sales" class="padding-left-40 tax-rates col-md-8">
                                        <span>Sales rate</span>
                                        <div class="input-group" style="white-space: nowrap;">
                                            <input v-model="tax_form.sales_rate" v-bind:class="{'form-control product-entry-input-field ha-input':true,'attended_field':tax_form.sales_rate > 0}" type="number" step="any">
                                            &nbsp;<i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label class="check-container element-inlined">This tax is collected on purchases:
                                        <input type="checkbox" v-model="tax_form.collected_on_purchase">
                                        <span class="checkmark"></span>
                                    </label><br>
                                    <div v-if="tax_form.collected_on_purchase" class="padding-left-40 tax-rates col-md-8">
                                        <span>Purchase rate</span>
                                        <div class="input-group" style="white-space: nowrap;">
                                            <input v-model="tax_form.purchase_rate" v-bind:class="{'form-control product-entry-input-field ha-input':true,'attended_field':tax_form.purchase_rate > 0}" step="any" type="number">
                                            &nbsp;<i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>
                <div class="section-footer height-60">
                    <button type="button" @click="save_taxes" class="btn btn-inventory primary">Save</button>
                </div>
            </aside>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewInventoryItem",
        data(){
            return {
                processing: false,
                tax_form:{
                    collected_on_sales: false,
                    collected_on_purchase: false,
                    practice_id: '',
                    agent_name: '',
                    registration_number: '',
                    description: '',
                    start_period: '',
                    filling_frequency: '',
                    reporting_method: '',
                    purchase_rate: 0.0,
                    sales_rate: 0.0,
                    amount: 0,
                }
            }
        },
    }
</script>

<style scoped>

</style>