<template>

    <!-- Header section-->
    <header v-bind:class="{'bg-blue':blue,'cl-white':cl_while,'no-border-bottom':bordered}">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="info-outer hidden-xs">
                        <div class="info-box">
                            <div class="icon"><span class="fa fa-mobile-phone"></span></div>
                            <a v-bind:class="{'cl-white':cl_while}"><span> Download {{app_data.app_name}} App</span></a>
                        </div>
                        <div class="info-box">
                            <div class="icon"><span class="fa fa-video-camera"></span></div>
                            <a v-bind:class="{'cl-white':cl_while}" class="phone" href="#">Call a doctor on video</a>
                        </div>
                        <div class="info-box">
                            <div class="icon"><span class="fa fa-cart-plus"></span></div>
                            <a v-bind:class="{'cl-white':cl_while}" class="phone" href="#">Order medicine</a>
                        </div>
                        <div class="info-box">
                            <div class="icon"><span class="fa fa-calendar-o"></span></div>
                            <a v-bind:class="{'cl-white':cl_while}" class="phone" href="#">Book appointment</a>
                        </div>
                    </div>
                    <!--Header Social Icon -->
                    <div class="social">
                        <ul>
                            <li>
                                <!--<router-link to="/login" class="black"><i class="fa fa-lg fa-sign-in"> </i> Log In</router-link>-->
                                <a href="/cdn-cgi/l/email-protection#f89c9d9597b890978b88918c9994d69b9795"><span class="__cf_email__" data-cfemail="1b7f7e76745b7374686b726f7a7735787476">{{app_data.app_email}}</span></a>
                            </li>

                            <!--<li>-->
                                <!--<a class="phone" href="#">{{app_data.app_mobile}}</a>-->
                            <!--</li>-->

                            <li><a :href="app_data.socials.facebook" target="_blank"><i class="fa fa-lg fa-facebook"></i></a></li>

                            <li><a :href="app_data.socials.twitter"><i class="fa fa-lg fa-twitter"></i></a></li>

                            <li><a :href="app_data.socials.instagram"><i class="fa fa-lg fa-instagram"></i></a></li>

                            <!--<li><a :href="app_data.socials.vimeo"><i class="fa fa-lg fa-vimeo-square"></i></a></li>-->

                            <!--<li><a :href="app_data.socials.dribbble"><i class="fa fa-lg fa-dribbble"></i></a></li>-->

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
</template>

<script>
    import app_config from '../../../helpers/config'
    export default {
        name: "TopThinHeader",
        props: ['blue','cl_while','bordered'],
        data(){
            return {
                app_data: app_config.app_data
            }
        }
    }
</script>

<style scoped>

</style>
