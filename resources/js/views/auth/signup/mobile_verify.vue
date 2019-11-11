<template>

    <div class="min-width-100-pc">

        <!--<top-thin-header></top-thin-header>-->

        <!--<page-header :shadowed="true"></page-header>-->

        <!-- Appointment Section / Choose Us Section -->
        <loading :is-loading="processing"></loading>

        <section id="appointment" class="choose-form-inner pd-top-50 min-height-100-vh">

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-lg-offset-4">

                        <form @submit.prevent="verifyOtp">
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12 inv-group-img text-center">
                                    <img src="/assets/images/icons/sms.png">
                                    <h2>Phone number verification</h2>
                                    <div class="alert-success alert font-size-1-2 border-radius-2">
                                        We have sent a verification code to <strong>{{mobile}}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12"><label>Code</label></div>
                                <div class="col-lg-12 col-md-12 col-sm-12"><input type="text" v-model="form.verification_code" placeholder="Enter the verification code here" class="form-control form-controller-input height-32 border-radius-2 no-shadowed"></div>
                            </div>
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12 content-inlined">

                                    <p><button type="submit" class="thm-btn no-shadowed border-radius-2 no-bordered text-uppercase">Verify</button></p>
                                    <p>Did not receive code?</p>
                                    <p><a @click="resendOtp" class="text-underlined cursor-pointer cl-dark-grey">Resend</a></p>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- Main Title -->

                </div>

            </div>

        </section>

    </div>

</template>

<script>

    import TopThinHeader  from '../../front/partials/TopThinHeader'
    import PageHeader  from '../../front/partials/Header'
    import app_data from '../../../helpers/config'
    import {post} from "../../../helpers/api";
    import {createHtmlErrorString} from "../../../helpers/functionmixin";
    import Auth from '../../../store/auth'
    import Loading from '../../../components/loads/ProgRess'

    export default {
        name: "register",
        components: {
            TopThinHeader,
            PageHeader,
            Loading
        },
        data(){
            return {
                processing: false,
                app_data: app_data.app_data,
                mobile: Auth.get_mobile_to_verify(),
                form: {
                    verification_code: ''
                },
            }
        },
        methods: {
            verifyOtp(){
                this.processing = true;
                post('/api/oauth/verify/otp', this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            Auth.delete_mobile_to_verify();
                            this.processing = false;
                            this.$router.push('/registration/email-verification');
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
                    this.processing = false;
                });
                this.processing = false;
            },

            resendOtp(){
                this.processing = true;
                let formD = new FormData();
                formD.append('mobile',Auth.get_mobile_to_verify());
                formD.append('activation_type','User');
                post('/api/oauth/resend/otp/', formD)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
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
                    this.processing = false;
                });
                this.processing = false;
            },

        }
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
    /*https://laravelsd.com/search*/
</style>
