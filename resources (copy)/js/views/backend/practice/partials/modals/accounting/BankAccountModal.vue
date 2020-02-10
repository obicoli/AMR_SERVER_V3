<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="process_bank_account" class="modal-content">
                <div class="modal-header bg-ced">
                    <h4 class="width-100-pc text-left">{{title}}</h4>
                </div>
                <div class="modal-body padding-bottom-29 bg-ced">
                    <div class="width-100-pc float-left">
                        <div class="width-50-pc float-left">
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Account Name:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.account_name" required v-bind:class="{'height-32':true}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Account Number:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.account_number" v-bind:class="{'height-32':true}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Account Type:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <vue-single-select
                                            name="maybe"
                                            placeholder=""
                                            you-want-to-select-a-post="ok"
                                            v-model="form.account_type"
                                            out-of-all-these-posts="makes sense"
                                            :options="bank_account_types"
                                            a-post-has-an-id="good"
                                            the-post-has-a-title="make"
                                            option-label="name"
                                        ></vue-single-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Bank Name:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <vue-single-select
                                            name="maybe"
                                            placeholder=""
                                            you-want-to-select-a-post="ok"
                                            v-model="form.bank"
                                            out-of-all-these-posts="makes sense"
                                            :options="banks"
                                            a-post-has-an-id="good"
                                            the-post-has-a-title="make"
                                            option-label="name"
                                        ></vue-single-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Branch Name:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <vue-single-select
                                            name="maybe"
                                            placeholder=""
                                            you-want-to-select-a-post="ok"
                                            v-model="form.bank_branch"
                                            out-of-all-these-posts="makes sense"
                                            :options="bank_branches"
                                            a-post-has-an-id="good"
                                            the-post-has-a-title="make"
                                            option-label="name"
                                        ></vue-single-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Description:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <textarea v-model="form.description" v-bind:class="{'min-height-90':true}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="width-50-pc float-left padding-left-25 padding-right-20">
                            <div class="row fullName mg-bottom-5 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Active:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <label class="check-container">
                                        <input v-model="form.status" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row fullName mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Default:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <label class="check-container">
                                        <input v-model="form.is_default" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div v-if="user_mode==='Create'" class="row fullName mg-bottom-50 mg-left-30">
                                <div class="inlineBlock width-30-pc text-right">
                                    <label class="company-label text-right">Is sub-account:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <label class="check-container">
                                        <input v-model="form.is_sub_account" type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div v-if="user_mode==='Create'" class="width-100-pc float-left">

                                <div class="row fullName mg-bottom-5 mg-left-30">
                                    <div class="inlineBlock width-40-pc text-right">
                                        <label class="company-label text-right">Opening Balance:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="inlineBlock width-60-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.opening_balance" v-bind:class="{'height-32':true}" type="number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName mg-bottom-5 mg-left-30">
                                    <div class="inlineBlock width-30-pc text-right">
                                        <label class="company-label text-right">As at:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="inlineBlock width-70-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.as_at" v-bind:class="{'height-32':true}" type="date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="width-100-pc float-left">
                                <div class="row fullName mg-bottom-5 mg-left-30">
                                    <div class="inlineBlock width-100-pc">
                                        <label class="company-label">Balance:</label>
                                    </div>
                                    <div class="inlineBlock width-100-pc">
                                        <label class="company-label float-left">KES</label><label class="company-label fs-20 fw-600 float-left">{{format_money(form.balance)}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="width-100-pc float-left padding-left-25">
                            <hr>
                            <!-- <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-inventory btn-cancel float-right">
                                Cancel
                            </button>
                            <button :hidden="user_mode==='View'" :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                <span v-else>Save</span>
                            </button> -->
                            <button v-if="user_mode==='Edit'" type="submit" :disabled="processing" class="btn combo-button combo-default">
                                <span>
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                                </span>
                            </button>
                            <div v-else  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button :disabled="processing" id="btnGroupDrop" type="button" class="btn btn-secondary banking-process-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>
                                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> {{form.action_taken}}</span>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                        <a @click="process_bank_account('Save & New')" class="dropdown-item pointer-cursor"> Save & New</a>
                                        <a @click="process_bank_account('Save & Close')" class="dropdown-item pointer-cursor"> Save & Close</a>
                                    </div>
                                </div>
                            </div>
                            <button type="button" :disabled="processing" data-dismiss="modal" class="btn banking-process pointer-cursor">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { post } from '../../../../../../helpers/api';
import { createHtmlErrorString,formatMoney } from '../../../../../../helpers/functionmixin';
export default {
    name: "BankAccountModal",
    props: ['user_mode','modal_id','title','form_data','bank_accounts_api','bank_account_types','banks','bank_branches'],
    data(){
        return{
            processing: false,
            form: {
                account_name: null,
                account_type: null,
                bank: null,
                bank_branch: null,
                account_number: null,
                status: true,
                is_default: false,
                opening_balance: 0,
                as_at: null,
                balance: 0,
                is_sub_account: true,
            }
        }
    },
    methods: {
        format_money(money_to){
            return formatMoney(money_to);
        },
        process_bank_account(){
            //this method is used to create new account and also updating the existing accounts
            this.processing = true;
            if(this.form.bank){ this.form.bank_id = this.form.bank.id;  }
            if(this.form.account_type){ this.form.account_type_id = this.form.account_type.id;  }
            if(this.form.bank_branch){ this.form.branch_id = this.form.bank_branch.id;  }
            post(this.bank_accounts_api, this.form)
            .then((res) => {
                if(res.data.status_code === 200) {
                    this.processing = false;
                    this.$awn.success(res.data.description);
                    this.$emit("successCreated");
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
        }
    },
    mounted(){
        if( this.user_mode==="Edit" || this.user_mode==="View"){
            this.form = this.form_data
        }
    }
}
</script>

<style scoped>
    .modal-header{
        border-bottom: 1px solid #0000001a!important;
    }
</style>