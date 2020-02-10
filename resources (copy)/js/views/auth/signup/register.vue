<template>

    <div class="min-width-100-pc min-height-100-vh">

        <!--<top-thin-header></top-thin-header>-->

        <page-header :shadowed="true"></page-header>

        <loading :is-loading="processing"></loading>

        <!-- Appointment Section / Choose Us Section -->
        <section id="appointment" class="choose-form-inner pd-top-40">

            <div class="container">

                <div class="row">

                    <div class="col-lg-8 min-height-100-vh">

                        <form @submit.prevent="register">

                            <p>Thank you for choosing {{app_data.app_name}}!</p>
                            <p>Please take a few minutes to tell us a little about yourself.</p>
                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>What is your name?</label>
                                    <div class="row">
                                        <div class="col-lg-6"><input type="text" v-model="form.first_name" required placeholder="First name" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                        <div class="col-lg-6"><input type="text" v-model="form.other_name" required placeholder="Other name" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>Are you registering as a doctor or as a patient?</label>
                                    <div class="form-check">
                                        <label class="radio-inline">
                                        <input type="radio" v-model="form.user_type" value="doctor" @click="doctorPref('doctor',$event)">Doctor</label>
                                        <label class="radio-inline">
                                        <input type="radio" v-model="form.user_type" value="patient" @click="doctorPref('patient',$event)">Patient</label>
                                    </div>
                                </div>
                            </div>

                            <div v-if="is_doctor" class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>Doctor registration number?</label>
                                    <div class="row">
                                        <div class="col-lg-12"><input v-model="form.registration_number" required type="text" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>When were your born?</label>
                                    <div class="row">
                                        <div class="col-lg-12"><input type="date" v-model="form.date_of_birth" required class="form-control height-32 border-radius-2 no-shadowed"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>Please select your gender?</label>
                                    <div class="form-check">
                                        <label class="radio-inline">
                                            <input type="radio" v-model="form.gender" value="Male">Male</label>
                                        <label class="radio-inline">
                                        <input type="radio" v-model="form.gender" value="Female">Female</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>What is your email address?</label>
                                    <div class="row">
                                        <div class="col-lg-12"><input v-model="form.email" required type="email" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>What is your location?</label>
                                    <div class="row">
                                        <div class="col-lg-6"><input type="text" v-model="form.country" required placeholder="Country e.g Kenya" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                        <div class="col-lg-6"><input type="text" v-model="form.city" required placeholder="City e.g Nairobi" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>What is your phone number?</label>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="number" v-model="form.mobile" required placeholder="254700000000" class="form-control height-32 border-radius-2 no-shadowed">
                                            <small>(<strong>Note:</strong> OTP will be sent to this number for verification.)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <label>Setup your password</label>
                                    <div class="row">
                                        <div class="col-lg-6"><input type="password" v-model="form.password" required placeholder="Enter your password" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                        <div class="col-lg-6"><input type="password" v-model="form.password_confirmation" required placeholder="Confirm password" class="form-control height-32 border-radius-2 no-shadowed"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pd-top-20">
                                <div class="col-lg-8">
                                    <button type="submit" class="thm-btn border-radius-2 no-shadowed">Continue</button>
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
    let lat = 1;
    let lng = 38;
    let country_code = 'KE';

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
                is_doctor: false,
                form: {
                    email: '',
                    first_name: '',
                    other_name: '',
                    mobile: '',
                    user_type: '',
                    gender: '',
                    registration_number: '',
                    password: '',
                    password_confirmation: '',
                    longitude: 0,
                    latitude: 0,
                },
            }
        },
        methods: {
            register() {
                this.getVisitorLocation();
                this.form.latitude = lat;
                this.form.longitude = lng;
                console.info(this.form);
                this.processing = true;
                post('/api/oauth/register', this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        localStorage.setItem('user_mail',this.form.email);
                        Auth.set_mobile_to_verify(this.form.mobile);
                        this.$awn.success(res.data.description);
                        this.$router.push('/registration/mobile-verification');
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
            },
            doctorPref(doc_preference,event){
                if (event.target.checked){
                    if (doc_preference === 'doctor'){
                        this.is_doctor = true;
                    }else if(doc_preference === 'patient'){
                        this.is_doctor = false;
                    }
                }
            },
        }
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
    /*https://laravelsd.com/search*/
</style>
