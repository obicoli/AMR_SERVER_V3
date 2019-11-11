<template>
    <div class="cta_subscribe">
        <div class="container-fluid h-100">
            <div class="row h-100 justify-content-center align-items-center">


                <div class="col-md-6 p-0">
                    <div class="block_1 block_2_custom block_2_custom_img bg-cl-grey">
                        <img class="" :src="'/img/pract/our_app_doctor.png'">
                    </div>
                </div>

                <div class="col-md-6 p-0">
                    <div class="block_2 block_2_custom vary-height vary-height-2 text-left bg-cl-grey">
                        <h3 class="sub-title">Download {{app_info.app_name}} App</h3>
                        <ul>
                            <li><i class=" icon-ok-circled2"></i> Provide online video consultation to patients</li>
                            <li><i class=" icon-ok-circled2"></i> Easily manage your {{app_info.app_name}} profile</li>
                            <li><i class=" icon-ok-circled2"></i> Easily manage patient records from anywhere</li>
                            <li><i class=" icon-ok-circled2"></i> Track your practice’s performance</li>
                            <li><i class=" icon-ok-circled2"></i> </li>
                        </ul>
                        <div class="download-app-btn">
                            <a :href="app_info.app_store" class="fadeIn"><img :src="'/img/apple_app.png'" alt="" width="150" height="50" data-retina="true"></a>
                            <a :href="app_info.google_play" class="fadeIn"><img :src="'/img/google_play_app.png'" alt="" width="150" height="50" data-retina="true"></a>
                        </div>
                        <send-me-link></send-me-link>
                    </div>
                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /cta_subscribe -->
</template>

<script>
    import app_info from '../../../helpers/config'
    import SendMeLink from '../layouts/SendMeLink'
    export default {

        components:{
            SendMeLink
        },
        data(){
            return {
                app_info: app_info.app_data
            }
        }

    }
</script>
