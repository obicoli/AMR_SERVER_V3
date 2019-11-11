<template>

    <div id="page">
        <page-header></page-header>
        <loading :is-loading="processing"></loading>


        <main>
            <div class="bg_color_2">
                <div class="container margin_60_35">
                    <div id="register">
                        <h1>Signup to Book a Slot</h1>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form @submit.prevent="register">
                                    <div class="box_form border-radius-zero">

                                        <div class="row">
                                            <h4 class="auth-head-title">Join as a patient <small class="pull-right"><router-link to="/doctor/signup" class="forgot pull-right"><small>Not a patient?</small></router-link></small></h4>

                                            <div class="form-group col-md-12 m-b-5">
                                                <label>First Name</label>
                                                <input type="text" v-model="form.first_name" required class="form-control no-shadowed border-radius-2 h-35" placeholder="Your name">
                                            </div>
                                            <div class="form-group col-md-12 m-b-5">
                                                <label>Last name</label>
                                                <input type="text" v-model="form.last_name" required class="form-control no-shadowed border-radius-2 h-35" placeholder="Your last name">
                                            </div>
                                            <div class="form-group col-md-12 m-b-5">
                                                <label>Email</label>
                                                <input type="email" v-model="form.email" required class="form-control no-shadowed border-radius-2 h-35" placeholder="Your email address">
                                            </div>

                                            <div class="form-group col-md-12 m-b-5">
                                                <label>Mobile</label>
                                                <input type="number" v-model="form.mobile" required class="form-control no-shadowed border-radius-2 h-35" placeholder="254700000000">
                                            </div>

                                            <div class="form-group col-md-6 m-b-5">
                                                <label>Gender</label>
                                                <select v-model="form.gender" class="form-control no-shadowed border-radius-2 h-35">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 m-b-5">
                                                <label>Date of Birth</label>
                                                <input type="date" v-model="form.date_of_birth" required class="form-control no-shadowed border-radius-2 h-35">
                                            </div>

                                            <div class="form-group col-md-6 m-b-5">
                                                <label>Password</label>
                                                <input type="password" v-model="form.password" required class="form-control no-shadowed border-radius-2 h-35" id="password1" name="password1" placeholder="Your password">
                                            </div>
                                            <div class="form-group col-md-6 m-b-5">
                                                <label>Confirm password</label>
                                                <input type="password" v-model="form.password_confirmation" required class="form-control no-shadowed border-radius-2 h-35" id="password2" name="password2" placeholder="Confirm password">
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
                    date_of_birth: '',
                    gender: '',
                    mobile: '',
                    password: '',
                    password_confirmation: ''
                },
                processing: false
            }
        },
        methods: {
            register() {
                this.processing = true;
                post('/api/oauth/patient/signup', this.form)
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
            }
        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

