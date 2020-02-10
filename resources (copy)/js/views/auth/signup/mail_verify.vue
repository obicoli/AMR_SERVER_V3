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
                                    <img src="/assets/images/icons/email.png">
                                    <h2>Email verification</h2>
                                    <div class="alert-success alert font-size-1-2 border-radius-2">
                                        Please verify your e-mail to get started
                                    </div>
                                    <div class="inv-group-div text-center mg-lg-top-20">
                                        <p>We have sent a verification link to <strong>{{email}}</strong></p>
                                        <p>Please click the link to verify your email</p>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>

    </div>

</template>

<script>

    import TopThinHeader  from '../../front/partials/TopThinHeader'
    import PageHeader  from '../../front/partials/Header'
    import app_data from '../../../helpers/config'
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
                email: localStorage.getItem('user_mail')
            }
        },
        methods: {

        }
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
    /*https://laravelsd.com/search*/
</style>
