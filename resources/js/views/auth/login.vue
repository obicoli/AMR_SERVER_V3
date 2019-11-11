<template>

    <div class="min-width-100-pc">

        <!--<top-thin-header></top-thin-header>-->

        <page-header :shadowed="false"></page-header>

        <!-- Appointment Section / Choose Us Section -->
        <loading :is-loading="processing"></loading>

        <section id="appointment" class="choose-form-inner pd-top-50 min-height-100-vh">

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-md-4 col-sm-6 col-sm-offset-3 col-md-offset-4 col-lg-offset-4">

                        <form @submit.prevent="login">

                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12 inv-group-img text-center">
                                    <img src="/assets/images/icons/user.png">
                                    <h2>Please login to {{app_info.app_data.app_name}}!</h2>
                                </div>
                            </div>
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12"><label>Email or mobile</label></div>
                                <div class="col-lg-12 col-md-12 col-sm-12"><input type="text" v-model="form.email_or_mobile" placeholder="" class="form-control form-controller-input height-36 border-radius-2 no-shadowed"></div>
                            </div>
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12"><label>Password</label></div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="password" v-model="form.password" placeholder="" class="form-control form-controller-input height-36 border-radius-2 no-shadowed">
                                    <div class="text-left">
                                        <p>Forgot <a href="/forgot/password" class="text-underlined cursor-pointer cl-dark-grey">password</a>?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group inv-group add_top_30">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <p><button type="submit" class="thm-btn no-shadowed border-radius-2 no-bordered text-uppercase">Login</button></p>
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
    import Auth from '../../store/auth'
    import StickyHeader  from '../front/partials/TopThinHeader'
    import { post } from '../../helpers/api'
    import PageHeader from '../front/partials/Header'
    import PageFooter from '../front/partials/Footer'
    import Loading from '../../components/loads/ProgRess'
    import {createHtmlErrorString} from "../../helpers/functionmixin";
    import app_info from '../../helpers/config'

    export default {
        components: {
            PageHeader,
            PageFooter,
            Loading,
            StickyHeader
        },
        data() {
            return {
                app_info: app_info,
                form: {
                    email_or_mobile: '',
                    password: ''
                },
                current_class: true,
                background_blue: true,
                processing: false,
                classes: {
                    header_sticky: true,
                    sticky: true,
                    top_thin_header: true
                }
            }
        },
        methods: {
            login() {
                this.processing = true;
                post('/api/oauth/login', this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        console.info(res.data.results);
                        window.location.href = res.data.results.redirect_url+"/oauth/login?usr="+this.form.email_or_mobile+"&passwd="+this.form.password;
                        //window.location.href = res.data.results.redirect_url;
                        // if (res.data.results.status === 'Activated') {
                        //     console.info(res.data.results);
                        //     Auth.set(res.data.access_token,res.data.token_type,res.data.expires_at,res.data.results);
                        //     this.processing = false;
                        //     if ( (localStorage.hasOwnProperty("entryUrl")) && (localStorage.getItem("entryUrl") !== null) ) {
                        //         let url_to = localStorage.getItem("entryUrl");
                        //         localStorage.removeItem("entryUrl");
                        //         window.location.href = url_to;
                        //     }else {
                        //         window.location.href = Auth.redirect_route();
                        //     }
                        //     this.$awn.success('Welcome back '+res.data.results.first_name+'!')
                        // }else if (res.data.results.status === 'Activation') {
                        //     localStorage.setItem('user_mail',this.form.email);
                        //     this.processing = false;
                        //     this.$awn.warning(res.data.results.description);
                        //     this.$router.push('/activation/required');
                        // }else {
                        //     this.$awn.warning(res.data.results.description);
                        //     this.processing = false;
                        // }
                        this.processing = false;
                        this.form.password = "";
                    }
                })
                .catch((err) => {
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
                    this.form.password = "";
                });

            }
        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

