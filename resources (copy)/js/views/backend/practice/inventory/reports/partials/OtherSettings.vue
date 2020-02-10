<template>
    <form @submit.prevent="save_company" class="width-100-pc float-left">
        <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
            <h3 class="fs-14 fw-600">Other Settings</h3>
        </div>
        <div class="width-100-pc float-left padding-left-25">
            <div class="row fullName mg-bottom-10">
                <div class="inlineBlock width-30-pc float-left">
                    <label class="company-label float-left fw-600">Display Assigned User on Invoice/PO/Bills etc: </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">Yes
                        <input v-model="form.display_assigned_user" type="radio" :value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">No
                        <input v-model="form.display_assigned_user" type="radio" :value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="width-100-pc float-left mg-bottom-10">
            <hr>
        </div>

        <div class="width-100-pc float-left padding-left-25">
            <div class="row fullName mg-bottom-10">
                <div class="inlineBlock width-30-pc float-left">
                    <label class="company-label float-left fw-600">Update Inventory After (Increase): </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">Receive
                        <input type="radio" v-model="form.inventory_increase" :value="'Receive'">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="inlineBlock width-40-pc float-left">
                    <label class="radio-container">Bill (recommended & default)
                        <input type="radio" v-model="form.inventory_increase" :value="'Bill'">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div role="alert" class="alert alert-info width-95-pc">Note - if you change this to
                    'Receive' - your multi-channel sync will work only with 'Bill'. So 'Bill'
                    needs to be created in-order to reflect correct quantity to your sales-channel.
                </div>
            </div>
        </div>

        <div class="width-100-pc float-left mg-bottom-10">
            <hr>
        </div>

        <div class="width-100-pc float-left padding-left-25">
            <div class="row fullName mg-bottom-10">
                <div class="inlineBlock width-30-pc float-left">
                    <label class="company-label float-left fw-600">Update Inventory After (Decrease): </label>
                </div>
                <div class="inlineBlock width-40-pc float-left">
                    <label class="radio-container">Invoice (recommended & default)
                        <input type="radio" v-model="form.inventory_descrease" :value="'Invoice'">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">Sales Order
                        <input type="radio" v-model="form.inventory_descrease" :value="'Sales Order'">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div role="alert" class="alert alert-info width-95-pc"> Note - if you change this to 'Sales-Order' - your 
                    multi-channel sync will work only with 'Invoice'. So 'Invoice' needs to be created in-order to reflect 
                    correct quantity to your sales-channel.
                </div>
            </div>
        </div>

        <div class="width-100-pc float-left mg-bottom-10">
            <hr>
        </div>

        <div class="width-100-pc float-left padding-left-25">
            <div class="row fullName mg-bottom-10">
                <div class="inlineBlock width-30-pc float-left">
                    <label class="company-label float-left fw-600">Warehouse Configuration: </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">Enable
                        <input type="radio" v-model="form.warehouse_config" :value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">Disable
                        <input type="radio" v-model="form.warehouse_config" :value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="width-100-pc float-left mg-bottom-10">
            <hr>
        </div>

        <div class="width-100-pc float-left padding-left-25">
            <div class="row fullName mg-bottom-10">
                <div class="inlineBlock width-30-pc float-left">
                    <label class="company-label float-left fw-600">Batch Tracking: </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">Enable
                        <input type="radio" v-model="form.batch_tracking" :value="1">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="inlineBlock width-20-pc float-left">
                    <label class="radio-container">Disable
                        <input type="radio" v-model="form.batch_tracking" :value="0">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="width-100-pc float-left padding-left-25">
            <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                <span v-else>Save Changes</span>
            </button>
        </div>
    </form>
</template>

<script>
import { post } from '../../../../../../helpers/api';
    export default {
        name: "OtherSettings",
        props: ['company','company_api'],
        data(){
            return {
                processing: false,
                form: {

                }
            }
        },
        watch: {
            company: function(new_data,old_data){
                this.form = new_data;
            }
        },
        methods: {
            save_company(){
                this.processing = true;
                post(this.company_api, this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success(res.data.description);
                        this.$emit("companyChanged");
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },
        },
        mounted(){
            this.form = this.company;
        }
    }
</script>