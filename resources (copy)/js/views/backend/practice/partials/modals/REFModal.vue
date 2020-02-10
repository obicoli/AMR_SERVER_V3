<template>
    <!-- The overlay -->
    <div id="taxModal" class="overlay">
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
                                <div class="col-md-8">
                                    <p>
                                        <span>Create a name for your tax rate, and give a few details about how you track it.</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Tax name:</label>
                                    <input type="text" class="form-control product-entry-input-field">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Description:</label>
                                    <textarea class="form-control product-entry-input-field min-height-90"></textarea>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Tax agency name:</label>
                                    <input type="text" class="form-control product-entry-input-field">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Registration number:(optional)</label>
                                    <input type="text" class="form-control product-entry-input-field">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Start of the current tax period</label>
                                    <input type="text" class="form-control product-entry-input-field">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Filling frequency</label>
                                    <input type="text" class="form-control product-entry-input-field">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label>Reporting method</label>
                                    <input type="text" class="form-control product-entry-input-field">
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label class="check-container element-inlined">This tax is collected on sales:
                                        <input type="checkbox" v-model="tax_form.tax_on_sales">
                                        <span class="checkmark"></span>
                                    </label><br>
                                    <div v-if="tax_form.tax_on_sales" class="padding-left-40 tax-rates col-md-8">
                                        <span>Sales rate</span>
                                        <div style="white-space: nowrap;">
                                            <input class="ha-input" type="text">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group mg-bottom-10">
                                <div class="col-md-8">
                                    <label class="check-container element-inlined">This tax is collected on purchases:
                                        <input type="checkbox" v-model="tax_form.tax_on_purchase">
                                        <span class="checkmark"></span>
                                    </label><br>
                                    <div v-if="tax_form.tax_on_purchase" class="padding-left-40 tax-rates col-md-8">
                                        <span>Purchase rate</span>
                                        <div style="white-space: nowrap;">
                                            <input class="ha-input" type="text">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>
                <div class="section-footer height-60">
                    <button class="btn btn-inventory primary">Save</button>
                </div>
            </aside>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TaxModal",
        data(){
            return {
                tax_form:{
                    tax_on_sales: false,
                    tax_on_purchase: false,
                }
            }
        },
        methods: {
            closeModal(){
                this.$emit('closeTaxModal');
            }
        }
    }
</script>

<style scoped>
    .overlay {
        height: 100%;
        width: 0;
        position: fixed; /* Stay in place */
        z-index: 10000; /* Sit on top */
        left: 100%;
        right: 0;
        /*left: 0;*/
        top: 0;
        background-color: #f4f5f8; /* Black fallback color */
        opacity: 1;
        overflow-x: hidden; /* Disable horizontal scroll */
        transition: 0.5s; /* 0.5 second transition effect to slide in or slide down the overlay (height or width, depending on reveal) */
        border-left: 1px solid #ddd;
        /*overflow-y: scroll;*/
    }
    .overlay-content {
        position: relative;
        width: 100%;
        height: 100%;
        background: #fff;
        /*overflow-y: scroll;*/
    }
    aside {
        height: 100%;
    }
    .new-tax form input {
        /*display: block;*/
        /*height: 34px;*/
        /*padding-left: 10px;*/
        /*padding-right: 10px;*/
        /*border-radius: 2px;*/
        /*border: 1px solid #babec5;*/
        /*outline: 0;*/
        /*font-size: 14px;*/
    }
    .new-tax form label {
        font-weight: 600;
        color: #404040;
        display: block;
        margin-bottom: 4px;
        /*padding-bottom: 5px;*/
        font-family: Avenir Next forINTUIT,Arial,-apple-system,Helvetica Neue,sans-serif;
        font-size: 14px;
    }

</style>