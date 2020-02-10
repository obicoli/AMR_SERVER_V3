<template>
    <header :class="classes">
        <!-- /btn_mobile-->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <nav class="main-menu">
                        <ul>
                            <li><span><router-link to="/" class="app_download"><i class="pe-7s-phone"></i> Download {{app_info.app_name}} App</router-link></span></li>
                        </ul>
                    </nav>
                    <!-- /main-menu -->
                </div>
                <div class="col-lg-9 col-6">
                    <nav id="menu" class="main-menu">
                        <ul>
                            <li><span><a href="" class=""><i class="pe-7s-video"></i> Call a Doctor on Video</a></span></li>
                            <li><span><router-link to="/chat" class=""><i class="pe-7s-chat"></i> Chat with a doctor</router-link></span></li>
                            <li><span><a href="" class=""><i class="pe-7s-date"></i> Book appointment</a></span></li>
                            <li><span><router-link to="/order/medicines" class=""><i class="pe-7s-cart"></i> Order medicine</router-link></span></li>
                            <!--<li>-->
                                <!--<span><a href="#" class="">More <i class="pe-7s-angle-down"></i></a></span>-->
                                <!--<ul>-->
                                    <!--<li><router-link to="/doctor/signup"><i class="pe-7s-eyedropper"></i> Book lab test</router-link></li>-->
                                    <!--<li><router-link to="/patient/signup"><i class="pe-7s-plus"></i> Find clinic</router-link></li>-->
                                    <!--<li><router-link to="/patient/signup"><i class="pe-7s-news-paper"></i> Read health article</router-link></li>-->
                                    <!--<li><router-link to="/patient/signup"><i class="pe-7s-note2"></i> View medical records</router-link></li>-->
                                <!--</ul>-->
                            <!--</li>-->
                        </ul>
                    </nav>
                    <!-- /main-menu -->
                </div>
            </div>
        </div>
        <!-- /container -->
    </header>
    <!-- /header -->
</template>

<script>
    import app_info from '../../../helpers/config'
    export default {
        props:['classes'],
        data(){
            return {
                app_info: app_info.app_data
            }
        }
    }
</script>

<style scoped>

</style>
