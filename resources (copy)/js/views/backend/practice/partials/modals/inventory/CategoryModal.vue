<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_category" class="modal-content bg-f4">

                <div class="modal-header width-100-pc text-left">
                    <h4 class="float-left text-left width-100-pc">{{modal_title}}</h4>
                </div>
                <div class="modal-body padding-bottom-29">
                    <div class="row justify-content-center">
                        <div class="col-lg-11 col-md-11">
                            <div class="width-100-pc float-left mg-top-20">
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Name:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="form.name" type="text" class="text-right-force" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Status:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc fs-12">
                                        <input v-model="form.status" type="radio" :value="true"> Active
                                        <input v-model="form.status" type="radio" :value="false"> Inactive
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName mg-bottom-5">
                                    <div class="float-left width-40-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Description&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="float-left width-50-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="form.description" class="min-height-60"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc float-left fullName text-center mg-top-20">
                                    <button :disabled="processing" type="submit" class="btn banking-process-amref pointer-cursor">
                                        <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Please wait... </span>
                                        <span>Save</span>
                                    </button>
                                    <button :disabled="processing" type="button" data-dismiss="modal" class="btn banking-process pointer-cursor cl-444">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {post, get} from "../../../../../../helpers/api";
    import {createHtmlErrorString,formatMoney, format_lunox_date, reset_forms} from "../../../../../../helpers/functionmixin";
    import { FORM_ACTIONS,ACCOUNTING} from '../../../../../../helpers/process_status';
    import {COA_API,CHART_OF_ACCOUNT_API,CHART_OF_ACCOUNT_OPEN_BAL_API} from "../../../../../../router/api_routes";
    export default {
        name: "AccountOpeningBalance",
        props:['modal_id','modal_title','category_api','form_model','user_mode'],
        data(){
            return {
                selected_account: [],
                account: null,
                options: [],
                processing: false,
                is_initializing: false,
                form: {
                    description: null,
                    status: true,
                    name: null,
                },
                DEFAULT_API: CHART_OF_ACCOUNT_API,
                FORM_ACTIONS:FORM_ACTIONS,
                COA_CODES: ACCOUNTING.COA_CODES,
            }
        },
        watch: {
        },
        methods: {
            save_category: function (action_taken) {
                this.processing = true;
                //this.is_initializing = true;
                post(this.category_api,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$awn.success(res.data.description);
                            switch (this.user_mode) {
                                case "Edit":
                                case "Create":
                                    this.$emit("category-action-event");
                                    break;
                                default:
                                    break;
                            }
                            $("#"+this.modal_id+"").modal('hide');
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        console.info(err.response.data.errors);
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.is_initializing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                    this.is_initializing = false;
                });
            },

            setItemForm(){
                if(this.user_mode === 'Edit'){
                    this.form.name = this.form_model.name;
                    this.form.description = this.form_model.description;
                    this.form.status = this.form_model.status;
                }
                
            },
        },
        mounted() {
            this.setItemForm();
        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-lg {
        max-width: 600px!important;
        min-width: 600px!important;
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
        font-size: 14px!important;
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
        border-radius: 5px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }

    .btn-group{
        width: 100%;
        font-size: 13px!important;
        border-radius: 5px!important;
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
    .attended_fiel{
        background-color: #f4f4f4!important;
        font-weight: 600!important;
    }
    .form-control{
        height: 27px;
    }
    b, strong {
        font-weight: 400!important;
    }
    .dropdown-menu>li>a {
        padding: 3px 20px 3px 30px!important;
    }
</style>


