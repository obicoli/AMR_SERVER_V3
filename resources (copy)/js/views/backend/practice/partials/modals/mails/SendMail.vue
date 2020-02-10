<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content bg-ced">

                <div class="modal-header">
                    <h4 class="width-100-pc text-left fs-19"> {{modal_title}}</h4>
                </div>

                <div class="modal-body padding-bottom-29">

                    <div class="width-100-pc float-left mg-top-20 padding-right-15 padding-left-15">
                        <div class="width-100-pc float-left">
                            <div class="width-100-pc float-left mg-bottom-5 mg-left-30">
                                <div class="width-10-pc float-left">
                                    <label class="company-label text-right">Send to:&nbsp;&nbsp;</label>
                                </div>
                                <div class="width-90-pc float-left">
                                    <div class="dijitInline firstName dijitTextBox width-96-pc">
                                        <input v-model="form.send_to" required v-bind:class="{'height-32':true,'custom-attended-field':form.send_to}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="width-100-pc float-left mg-bottom-5 mg-left-30">
                                <div class="width-10-pc float-left">
                                    <label class="company-label text-right">CC:&nbsp;&nbsp;</label>
                                </div>
                                <div class="width-90-pc float-left">
                                    <div class="dijitInline firstName dijitTextBox width-96-pc">
                                        <input v-model="form.cc" required v-bind:class="{'height-32':true,'custom-attended-field':form.cc}" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="width-100-pc float-left mg-bottom-5 mg-left-30">
                                <div class="width-10-pc float-left">
                                    <label class="company-label text-right">Subject:&nbsp;&nbsp;</label>
                                </div>
                                <div class="width-90-pc float-left">
                                    <div class="dijitInline firstName dijitTextBox width-96-pc">
                                        <input v-model="form.subject" required v-bind:class="{'height-32':true,'custom-attended-field':form.subject}" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="width-100-pc float-left mg-top-30 bg-white">
                            <vue-editor v-model="form.content"></vue-editor>
                        </div>
                        <div class="width-100-pc float-left bg-white mg-top-2 padding-10">
                            <div v-for="(attached,index) in form.attachment" class="file-attachment width-23-pc float-left mg-right-5" :key="'attachment_'+index">
                                <a class="cl-blue-link fs-12"><i class="fa fa-file-pdf-o cl-amref"></i> {{attached.name}}</a>
                            </div>
                            <div class="width-100-pc float-left mg-top-5">
                                <a class="fs-12 pointer-cursor cl-amref"><i class="fa fa-paperclip"></i> Attach file(s)</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button :disabled="processing" @click="send_mail" type="button" class="btn btn-secondary banking-process-amref">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Sending...</span>
                        <span v-else>Send</span>
                    </button>
                    <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</template>

<script>
    import {get,post} from '../../../../../../helpers/api';
    import AppInfo from '../../../../../../helpers/config';
    import {createHtmlErrorString,reset_forms, format_lunox_date,formatMoney} from '../../../../../../helpers/functionmixin';
    import {SUPPLIERS_URL} from '../../../../../../router/api_routes';
    import {ADDRESS_TYPES,FORM_ACTIONS} from '../../../../../../helpers/process_status';
    import ImagePreview from "../../../../../../components/images/ImagePreview";
    import MultipleFilesUpload from "../../../../../../components/images/MultipleFilesUpload";
    import { VueEditor } from "vue2-editor";
    export default {
        name: "SupplierModal",
        components: {
            ImagePreview,
            MultipleFilesUpload,
            VueEditor
        },
        props:['modal_title','mail_content','modal_id','mailing_api'],
        data(){
            return {
                processing: false,
                form: {
                    send_to: null,
                    cc: null,
                    subject: null,
                    content: null,
                    trans_number: null,
                    attachment: [],
                },
                mail_api: null,
            }
        },
        watch: {
            mail_content: function(){
                this.setMail();
            },
            mailing_api: function(new_data,old_data){
                this.mail_api = new_data;
            }
        },
        methods: {
            format_money(money_to){
                return formatMoney(money_to);
            },
            setMail(){
                this.form.send_to = this.mail_content.send_to;
                this.form.cc = this.mail_content.cc;
                this.form.subject = this.mail_content.subject;
                this.form.content = this.mail_content.content;
                this.form.trans_number = this.mail_content.trans_number;
                this.form.attachment = this.mail_content.attachment;
            },
            send_mail(){
                this.processing = true;
                post(this.mail_api,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.processing = false;
                            this.$emit('send-mail-event');
                            $('#'+this.modal_id).modal('hide');
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
            this.mail_api = this.mailing_api;
            if(this.mail_content){
                this.setMail();
            }
        },
    }
</script>

<style scoped>
    .modal {
        background: #0000009e;
        z-index: 9999;
    }
    .modal-content{
        top: 50px!important;
    }
    .modal-lg {
        max-width: 950px!important;
        min-width: 950px!important;
    }
    .modal-header{
        border-bottom: 1px solid #00000033!important;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
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
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 13px;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select, .vdatetime-input{
        outline: none!important;
        height: 27px!important;
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 5px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 12px!important;
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

    @import "~vue2-editor/dist/vue2-editor.css";
    /* Import the Quill styles you want */
    @import '~quill/dist/quill.core.css';
    @import '~quill/dist/quill.bubble.css';
    @import '~quill/dist/quill.snow.css';

</style>