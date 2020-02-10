<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="process_bank" class="modal-content">
                <div class="modal-header bg-ced">
                    <h4 class="width-100-pc text-left">{{title}}</h4>
                </div>
                <div class="modal-body padding-bottom-29">
                    <div class="width-100-pc float-left">
                        <div class="width-50-pc float-left">
                            <div class="row fullName mg-bottom-15 mg-left-30">
                                <div class="inlineBlock width-30-pc">
                                    <label class="company-label text-right">Name:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.name" required placeholder="e.g KCB" v-bind:class="{'height-32':true,'attended-field':form.name}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-15 mg-left-30">
                                <div class="inlineBlock width-30-pc">
                                    <label class="company-label text-right">Code:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.code" required placeholder="e.g KCBLKENX017" v-bind:class="{'height-32':true,'attended-field':form.code}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-15 mg-left-30">
                                <div class="inlineBlock width-30-pc">
                                    <label class="company-label text-right">Description:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.description" required placeholder="e.g Kenya Commercial Bank" v-bind:class="{'height-32':true,'attended-field':form.description}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-15 mg-left-30">
                                <div class="inlineBlock width-30-pc">
                                    <label class="company-label text-right">Phone:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.phone" v-bind:class="{'height-32':true,'attended-field':form.phone}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-15 mg-left-30">
                                <div class="inlineBlock width-30-pc">
                                    <label class="company-label text-right">Email:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <input v-model="form.email" v-bind:class="{'height-32':true,'attended-field':form.email}" type="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row fullName mg-bottom-15 mg-left-30">
                                <div class="inlineBlock width-30-pc">
                                    <label class="company-label text-right">Address:&nbsp;&nbsp;</label>
                                </div>
                                <div class="inlineBlock width-70-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <textarea v-model="form.address" placeholder="e.g Moi Avenue, Moi Avenue Nairobi, Nairobi, Kenya" v-bind:class="{'min-height-90':true,'attended-field':form.address}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="width-50-pc float-left padding-left-25 padding-right-20">
                            <div class="row fullName mg-bottom-15 mg-left-30">
                                <div class="inlineBlock width-100-pc">
                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                        <textarea v-model="form.comments" placeholder="Comments" v-bind:class="{'min-height-90':true,'attended-field':form.comments}"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="width-100-pc float-left padding-left-25">
                            <hr>
                            <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-inventory btn-cancel float-right">
                                Cancel
                            </button>
                            <button :hidden="user_mode==='View'" :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                <span v-else>Save</span>
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
import { createHtmlErrorString } from '../../../../../../helpers/functionmixin';
export default {
    props: ['modal_id','form_data','title','user_mode','bank_api'],
    data(){
        return {
            processing: false,
            form: {
                name: null,
                code: null,
                comments: null,
                address: null,
                email: null,
                phone: null,
                description: null,
            }
        }
    },
    methods: {
        process_bank(){
            this.processing = true;
            post(this.bank_api, this.form)
            .then((res) => {
                if(res.data.status_code === 200) {
                    this.processing = false;
                    this.$awn.success(res.data.description);
                    this.$emit("bankCreated");
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
        if(this.user_mode === "Edit" || this.user_mode==="View" ){ this.form = this.form_data}
    }
}
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-content{
        top: 30px!important;
    }
    .modal-lg {
        max-width: 800px!important;
        min-width: 800px!important;
    }
    .modal-header{
        /* border-bottom: 1px solid #fff!important; */
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .fullAdd.employeeForm .row {
        padding-bottom: 4px;
    }
    .inlineBlock {
        display: inline-block;
    }
    .inlineBlock label {
        font-weight: 600!important;
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 14px;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select{
        outline: none!important;
        /* height: 32px!important; */
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 2px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }

    input::placeholder, textarea::placeholder  {
        color: #babec5!important;
        font-size: 12px!important;
        font-style: italic;
        font-weight: 400!important;
    }
    .checkboxInline {
        margin-left: 5px;
    }
    input[type=checkbox]:not(.dijitCheckBoxInput):not(.idsCheckbox__input) {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        background-color: transparent;
        border: 1px solid #8D9096;
        border-radius: 2px;
        background-repeat: no-repeat;
        background-size: 124px;
        background-position: -28px -3px;
        user-select: none;
        -webkit-appearance: none;
    }
</style>