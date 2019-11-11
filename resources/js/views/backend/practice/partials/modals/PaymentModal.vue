<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <form @submit.prevent="save_payments" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">{{title}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row form-group mg-top-20">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Name:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input v-model="payment_form.name" type="text" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':payment_form.name}">
                        </div>
                    </div>
                    <div class="row form-group mg-top-20">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Payment Type:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <select v-model="payment_form.payment_type" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':payment_form.payment_type}" required >
                                <option value="">--select--</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="cheque">Cheque</option>
                                <option value="netbanking">Netbanking</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group mg-top-20">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Vendor Fee:(%)</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input v-model="payment_form.vendor_fee" type="number" step="any" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':payment_form.vendor_fee}">
                        </div>
                    </div>
                    <div v-if="user_mode === 'Edit'" class="row form-group mg-top-20">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Status:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <select v-model="payment_form.status" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':payment_form.status}" required >
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-inventory primary">
                        <span v-if="user_mode==='Create'">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Creating...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Create</span>
                        </span>
                        <span v-else>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Update</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory">
                        Close
                    </button>
                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "PaymentModal",
        props:['practice_id','form_data','initial_url','user_mode','modal_id','title'],
        data(){
            return {
                processing: false,
                payment_form: {
                    name: '',
                    payment_type: '',
                    vendor_fee: '',
                    practice_id: '',
                    status: 1,
                }
            }
        },
        methods: {
            save_payments(){
                this.processing = true;
                post(AppInfo.app_data.server_domain+this.initial_url,this.payment_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                this.$emit('payEdited');
                            }else {
                                this.$emit('payAdded');
                                this.refresh_pay();
                            }
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });

            },
            refresh_pay(){
                this.payment_form.name = "";
                this.payment_form.vendor_fee = 0;
                this.payment_form.payment_type = "";
            },
        },
        mounted() {
            this.payment_form.practice_id = this.practice_id;
            if (this.user_mode === 'Edit') {
                this.payment_form.payment_type = this.form_data.payment_type;
                this.payment_form.status = this.form_data.status;
                this.payment_form.vendor_fee = this.form_data.vendor_fee;
                this.payment_form.name = this.form_data.name;
            }
        }
    }
</script>

<style scoped>

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        /*width: 320px;*/
        width: 40%!important;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
        top: 0!important;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog{
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog{
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    .modal-header {
        border-bottom-color: #EEEEEE;
        background-color: #FAFAFA;
    }

</style>