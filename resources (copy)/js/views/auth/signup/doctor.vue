<template>

    <div id="page">
        <page-header></page-header>
        <loading :is-loading="processing"></loading>


        <main>
            <div class="bg_color_2">
                <div class="container margin_60_35">
                    <div id="register">
                        <h1>It's time to find you!</h1>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form @submit.prevent="doctor_register">
                                    <div class="box_form border-radius-zero">

                                        <div class="row">
                                            <h4 class="auth-head-title">Join as a doctor <small class="pull-right"><router-link to="/patient/signup" class="forgot pull-right"><small>Not a doctor?</small></router-link></small></h4>

                                            <div class="form-group col-md-6">
                                                <label>First Name</label>
                                                <input type="text" v-model="form.first_name" required class="form-control border-radius-zero no-shadowed h-40" placeholder="Your name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last name</label>
                                                <input type="text" v-model="form.last_name" required class="form-control border-radius-zero no-shadowed h-40" placeholder="Your last name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" v-model="form.email" required class="form-control border-radius-zero no-shadowed h-40" placeholder="Your email address">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Mobile</label>
                                                <input type="number" v-model="form.mobile" required class="form-control border-radius-zero no-shadowed h-40" placeholder="254700000000">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Password</label>
                                                <input type="password" v-model="form.password" required class="form-control no-shadowed h-40 border-radius-zero" id="password1" name="password1" placeholder="Your password">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Confirm password</label>
                                                <input type="password" v-model="form.password_confirmation" required class="form-control no-shadowed h-40 border-radius-zero" id="password2" name="password2" placeholder="Confirm password">
                                                <router-link to="/login" class="forgot"><small>Already have a account?</small></router-link>
                                            </div>

                                        </div>

                                        <div id="pass-info" class="clearfix"></div>
                                        <div class="checkbox-holder text-left">
                                            <div class="checkbox_2">
                                                <input type="checkbox" required value="accept_2" id="check_2" name="check_2" checked>
                                                <label for="check_2"><span>By signing up, I agree to <strong>Terms &amp; Conditions</strong></span></label>
                                            </div>
                                        </div>
                                        <div class="form-group text-center add_top_30">
                                            <input class="btn_1" type="submit" value="Submit">
                                        </div>
                                    </div>
                                    <p class="text-center link_bright">Let patients to Find you! Easily manage <router-link to="/patient/signup"><strong>Bookings</strong></router-link>. Instantly via <router-link to="/how/it/works">Video Call</router-link>.</p>
                                </form>
                            </div>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /register -->
                </div>
            </div>
        </main>
        <!-- /main -->

        <page-footer></page-footer>
    </div>

</template>

<script type="text/javascript">

    let lat = 1;
    let lng = 38;
    let country_code = 'KE';

    import Auth from '../../../store/auth'
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
                    first_name: '',
                    last_name: '',
                    mobile: '',
                    password: '',
                    password_confirmation: '',
                    lat: 0,
                    lng: 0,
                    country_code: '0',
                },
                processing: false
            }
        },
        methods: {
            doctor_register() {
                this.getVisitorLocation();
                this.form.lat = lat;
                this.form.lng = lng;
                this.form.country_code = country_code;
                console.info(this.form);
                this.processing = true;
                post('/api/oauth/doctor/signup', this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        localStorage.setItem('user_mail',this.form.email);
                        this.$awn.success('Account Registration was successful');
                        this.$router.push('/registration/successful');
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
                })
            },
            getVisitorLocation() {
                $.get("https://api.ipdata.co?api-key=test", function (response) {
                    lat = response.latitude;
                    lng = response.longitude;
                    country_code = response.country_code;
                }, "jsonp");
            }
        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

