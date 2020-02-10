<template>
    <div class="overlay-page">
        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">
            <div class="box-body bg-white padding-top-20 padding-bottom-20 padding-left-10 padding-right-10">
                <p class="cl-444 fs-16">Phone Verification Required!</p>
                <div class="alert alert-success">{{message}}</div>
                <form @submit.prevent="sendOtp">
                    <div class="form-group">
                        <label class="cl-444">Code</label>
                        <input type="text" required v-model="form.verification_code" class="form-control border-radius-2 height-32 border-ccc" placeholder="Verification code here">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary border-radius-2">
                            <i v-if="submitting_" class="fa fa-spinner fa-spin"></i>
                            <span v-else>Submit</span>
                        </button>
                        <span class="cl-444">Did not receive code?
                            <a v-if="sending" class="cl-blue-link fs-13"><i class="fa fa-spinner fa-spin"></i> Sending. Please wait... </a>
                            <a v-else @click="resendOtp" class="cl-blue-link">Resend here</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    import {post} from "../../../../helpers/api";
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";

    export default {
        name: "MobileOtpOverlay",
        props:['message','mobile'],
        data(){
            return {
                sending: false,
                submitting_: false,
                form: {
                    verification_code: '',
                    mobile: this.mobile,
                }
            }
        },
        methods: {
            sendOtp(){
                this.submitting_ = true;
                post(AppInfo.app_data.server_domain+'/api/oauth/verify/otp', this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.submitting_ = false;
                            this.$awn.success(res.data.description);
                            // Auth.setCurrentBranch(res.data.results);
                            // window.location.reload();
                            this.$emit('otpVerificationSuccess')
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        this.$router.push('/500');
                    }
                    else{
                        this.$awn.warning(err.response.data.description)
                    }
                    this.submitting_ = false;
                });
            },
            resendOtp(){
                this.sending = true;
                let formD = new FormData();
                formD.append('mobile',this.mobile);
                formD.append('activation_type','Practice');
                post(AppInfo.app_data.server_domain+'/api/oauth/resend/otp/', formD)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.sending = false;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        this.$router.push('/500');
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.sending = false;
                });
                this.sending = false;
            }
        }
    }
</script>

<style scoped>

</style>