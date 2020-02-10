<template>

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
                                                    <strong class="cl-white txt-uppercase">Create New Password</strong>
                                                </p>
                                                <form @submit.prevent="reset" class="login-container">

                                                    <div class="form-group">
                                                        <label>Enter new password</label>
                                                        <input type="password" v-model="form.password" required class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Confirm password</label>
                                                        <input type="password" v-model="form.password_confirmation" required class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-xl">
                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Please wait...</span>
                                                            <span v-else>Submit</span>
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
                    password: '',
                    token: this.$route.params.token,
                    password_confirmation: '',
                },
                processing: false
            }
        },
        methods: {
            reset() {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/oauth/create/password', this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$awn.success(res.data.description);
                            this.$router.push('/login')
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
                        this.form.password = "";
                        this.form.password_confirmation = "";
                    });

            }
        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

