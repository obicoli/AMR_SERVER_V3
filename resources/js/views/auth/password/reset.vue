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
                                    <h2>Create New Password</h2>
                                </div>
                            </div>
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12"><label>New password</label></div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="password" v-model="form.password" class="form-control form-controller-input height-36 border-radius-2 no-shadowed">
                                </div>
                            </div>

                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12"><label>Confirm new password</label></div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="password" v-model="form.password_confirmation" class="form-control form-controller-input height-36 border-radius-2 no-shadowed">
                                </div>
                            </div>

                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p><button type="submit" class="thm-btn no-shadowed border-radius-2 no-bordered text-uppercase">Submit</button></p>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- Main Title -->

                </div>

            </div>

        </section>

    </div>

    <!--<div id="page">-->
        <!--<page-header></page-header>-->
        <!--<loading :is-loading="processing"></loading>-->

        <!--<main>-->
            <!--<div class="bg_color_2">-->
                <!--<div class="container margin_60_35">-->
                    <!--<div id="login">-->
                        <!--<h1>Create New Password</h1>-->
                        <!--<div class="box_form border-radius-zero">-->
                            <!--<form @submit.prevent="reset">-->
                                <!--<div class="form-group">-->
                                    <!--<input type="password" v-model="form.password" required class="form-control no-shadowed border-radius-zero h-45" placeholder="Enter password">-->
                                <!--</div>-->
                                <!--<div class="form-group">-->
                                    <!--<input type="password" v-model="form.password_confirmation" required class="form-control no-shadowed border-radius-zero h-45" placeholder="Confirm password">-->
                                <!--</div>-->
                                <!--<router-link to="/login"><small>Remembered password?</small></router-link>-->
                                <!--<div class="form-group text-center add_top_20">-->
                                    <!--<button class="btn_1 no-shadowed border-radius-zero">Submit</button>-->
                                <!--</div>-->
                            <!--</form>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--&lt;!&ndash; /login &ndash;&gt;-->
                <!--</div>-->
            <!--</div>-->
        <!--</main>-->
        <!--&lt;!&ndash; /main &ndash;&gt;-->

        <!--<page-footer></page-footer>-->
    <!--</div>-->

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
                    password: '',
                    token: this.$route.params.token,
                    password_confirmation: '',
                },
                processing: false
            }
        },
        created(){

        },
        methods: {
            reset() {
                this.processing = true;
                post('/api/oauth/create/password', this.form)
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
            },

        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

