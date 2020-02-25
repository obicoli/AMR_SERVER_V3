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
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Warn when Item quantities fall below zero
                                <input type="checkbox" v-model="form.warn_item_qty_zero">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Do not allow Item quantities below zero
                                <input type="checkbox" v-model="form.disallow_qty_zero">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Warn when Item cost is zero
                                <input type="checkbox" v-model="form.warn_item_cost_zero">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Warn when Item selling price is below cost
                                <input type="checkbox" v-model="form.warn_item_sale_below_cost">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Display inactive Items for selection on document lines
                                <input type="checkbox" v-model="form.show_inactive_items">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Sales Orders Reserve Item Quantities
                                <input type="checkbox" v-model="form.sales_order_reserve_item">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row fullName mg-bottom-2 mg-left-30">
                        <div class="inlineBlock width-100-pc fs-12">
                            <label class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">Display inactive Item Bundles for selection on document lines
                                <input type="checkbox" v-model="form.show_inactive_item_category">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="width-100-pc float-left text-center padding-10">
            <button @click="save_company(FORM_ACTIONS.SAVE_NEW)" :disabled="processing" class="btn btn-secondary banking-process">
                <i v-if="processing" class="fa fa-ban"></i>
                <span v-else>Save</span>
            </button>
            <button @click="save_company(FORM_ACTIONS.SAVE_CLOSE)" :disabled="processing" class="btn btn-secondary banking-process-amref">
                <i v-if="processing" class="fa fa-ban"></i>
                <span v-else>Save & Close</span>
            </button>
            <router-link tag="button" :disabled="processing" :to="INVENTORY_WEB_ROUTES.SCM_WORKSPACE" class="btn btn-secondary banking-process">Cancel</router-link>
        </div>
    </div>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    import {post} from "../../../../../helpers/api";
    import {FORM_ACTIONS} from "../../../../../helpers/process_status";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "ItemModel",
        props: ['api','inventory_settings'],
        data(){
            return {
                processing: false,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                FORM_ACTIONS: FORM_ACTIONS,
                form: {
                    warn_item_qty_zero: false,
                    disallow_qty_zero: false,
                    warn_item_cost_zero: false,
                    warn_item_selling_zero: false,
                    warn_item_sale_below_cost: false,
                    show_inactive_items: false,
                    show_inactive_item_category: false,
                    sales_order_reserve_item: false,
                }
            }
        },
        watch: {
            api: function (new_data,old_data) {
                if(new_data){
                    this.api = new_data;
                }
            },
            inventory_settings: function (new_data,old_data) {
                if(new_data){
                    this.inventory_settings = new_data;
                    this.form = this.inventory_settings;
                }
            }
        },
        methods: {
            save_company(action_taken){
                this.processing = true;
                post(this.api,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.processing = false;
                            switch(action_taken){
                                case FORM_ACTIONS.SAVE_NEW:
                                    this.$emit('customer-supplier-event');
                                    break;
                                case FORM_ACTIONS.SAVE_CLOSE:
                                    this.$router.push(INVENTORY_WEB_ROUTES.SCM_WORKSPACE);
                                    break;
                            }
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;

                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            }
        },
        mounted() {
            if (this.inventory_settings){
                this.form = this.inventory_settings;
            }
        }
    }
</script>

<style scoped>

</style>