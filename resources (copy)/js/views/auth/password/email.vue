<template>

    <!-- <div id="page">
        <page-header></page-header>
        <loading :is-loading="processing"></loading>

        <main>
            <div class="bg_color_2">
                <div class="container margin_60_35">
                    <div id="login">
                        <h1>Password Problem!</h1>
                        <div class="box_form border-radius-zero">
                            <form @submit.prevent="reset">
                                <div class="alert alert-info border-radius-zero">
                                    Enter the email address associated with your account, and we’ll
                                    email you a link to reset your password.
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="form.email" required class="form-control no-shadowed border-radius-zero h-45" placeholder="Your email address">
                                </div>
                                <router-link to="/login"><small>Remembered password?</small></router-link>
                                <div class="form-group text-center add_top_20">
                                    <button class="btn_1 no-shadowed border-radius-zero">Send Reset Link</button>
                                </div>
                            </form>
                        </div>
                        <p class="text-center link_bright">Do not have an account yet? <router-link to="/patient/signup"><strong>Register now!</strong></router-link></p>
                    </div>
                </div>
            </div>
        </main>

        <page-footer></page-footer>
    </div> -->

        <div class="wrap">
        <section id="home" class="p-0">
            <div class="owl-carousel owl-theme main-slider">
                <div class=" item">
                    <div class="item-content">
                        <section class="parallax-fixed main-banner" data-stellar-background-ratio="0.5">
                            <div class="content-table">
                                <div class="content-middle">
                                    <div class="container main-slider-container">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-7 col-lg-7 text-center text-md-left animate_slide landing-content">
                                                <p class="text-center">
                                                    <strong class="cl-white txt-uppercase">Password Problem!</strong>
                                                </p>
                                                <form @submit.prevent="reset" class="login-container">

                                                    <div class="alert alert-info border-radius-zero fs-13">
                                                        Enter the email address associated with your account, and we’ll
                                                        email you a link to reset your password.
                                                    </div>
                                                    <div class="form-group">
                                                        <input v-model="form.email" type="email" required class="form-control" placeholder="Enter email here">
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <router-link to="/login">Remembered password?</router-link>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-xl">
                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Please wait...</span>
                                                            <span v-else>Send Reset Link</span>
                                                        </button>
                                                    </div>
                                                </form>
                                                <p class="text-center cl-white login-logo-s">
                                                    <router-link to="/"><img src="/assets/front/images/amref-logo.png"></router-link><br>
                                                    Electronic Dispensing & Inventory Tracking Tool<br>
                                                    <strong>EDITT V1</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
        
        <div class="footer">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <span class="copyright text-center" style="color:#fff;font-size:14px;">
                            © Copyright Amref 2019 All Rights Reserved. Designed by <a href="https://virtualglobal.net" target="_blank">Virtual Global</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script type="text/javascript">

    import { post } from '../../../helpers/api'
    import PageHeader from '../../front/partials/Header'
    import PageFooter from '../../front/partials/Footer'
    import Loading from '../../../components/loads/ProgRess'
    import {createHtmlErrorString} from "../../../helpers/functionmixin";
    import AppInfo from '../../../helpers/config'

    export default {
        components: {
            PageHeader,
            PageFooter,
            Loading
        },
        data() {
            return {
                form: {
                    email: '',
                },
                processing: false
            }
        },
        methods: {
            reset() {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/oauth/reset/password', this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success(res.data.description)
                    }
                })
                .catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                })
            }
        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

