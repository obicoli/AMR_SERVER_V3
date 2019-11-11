<template>

    <div class="min-width-100-pc">

        <!--<top-thin-header></top-thin-header>-->

        <page-header :shadowed="false"></page-header>

        <!-- Appointment Section / Choose Us Section -->
        <loading :is-loading="processing"></loading>

        <section id="appointment" class="choose-form-inner pd-top-50 min-height-100-vh">

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-lg-offset-4">

                        <form @submit.prevent="reset">
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12 inv-group-img text-center">
                                    <img src="/assets/images/icons/key.png">
                                    <h2>Password Problem!</h2>
                                    <div class="alert alert-info border-radius-2 font-size-1-2">
                                        Enter the email address associated with your account, and we’ll email you a link to reset your password.
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12"><label>Email address</label></div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="text" v-model="form.email" placeholder="Enter email here" class="form-control form-controller-input height-36 border-radius-2 no-shadowed">
                                    <div class="text-left">
                                        <p>Remembered <a href="/login" class="text-underlined cursor-pointer cl-dark-grey">password</a>?</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p><button type="submit" class="thm-btn no-shadowed border-radius-2 no-bordered text-uppercase">Send Reset Link</button></p>
                                    <div class="text-right">
                                        <p>Do not have an <a href="/register" class="text-underlined cursor-pointer cl-dark-grey">account</a> yet?</p>
                                    </div>
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

<script type="text/javascript">

    import { post } from '../../../helpers/api'
    import PageHeader from '../../front/partials/Header'
    import PageFooter from '../../front/partials/Footer'
    import Loading from '../../../components/loads/ProgRess'
    import {createHtmlErrorString} from "../../../helpers/functionmixin";
    import app_info from '../../../helpers/config'

    export default {
        components: {
            PageHeader,
            PageFooter,
            Loading
        },
        data() {
            return {
                app_info: app_info,
                form: {
                    email: '',
                },
                processing: false
            }
        },
        methods: {
            reset() {
                this.processing = true;
                post('/api/oauth/reset/password', this.form)
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

