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
                                                    <router-link to="/"><img class="landing-logo" src="/assets/front/images/amref-logo.png"></router-link>
                                                </p>
                                                <h1 class="text-white text-center strong mt-0 fs-80">
                                                    403
                                                </h1>
                                                <p class="lead text-white text-center fs-17" style="font-family: 'Raleway', sans-serif!important!important;">
                                                    You don't have permission to access this page.
                                                </p>
                                                <p class="text-center">
                                                    <router-link to="/" class="btn btn-light btn-xl btn-rounded mr-md-4 mb-4 mb-md-0 align-top">Home</router-link>
                                                    <router-link to="/login" class="btn btn-outline-light btn-xl btn-rounded mb-4 mb-md-0 align-top">Login</router-link>
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

<script>
    import Auth from "../../store/auth"
    export default {
        data(){
            return {
                user_key: Auth.isAuth(),
            }
        },
        methods: {
            logoutUser(){
                Auth.remove();
                window.location.href = "/";
            }
        }
    }
</script>

<style scoped>

</style>
