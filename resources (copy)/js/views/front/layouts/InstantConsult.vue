<template>
    <div class="bg_color_1">
        <div class="container margin_120_95">
            <div class="main_title">
                <h2>Most Viewed doctors</h2>
                <p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri.</p>
            </div>
            <div class="row justify-content-around">
                <div class="col-md-5">
                    <p><img :src="'/img/app_img.svg'" alt="" class="img-fluid" width="500" height="433"></p>
                </div>
                <div class="col-md-6">
                    <small>Your home for health is one tap away.</small>
                    <h3>Download <strong>{{app_info.app_name}} App</strong> Now!</h3>
                    <p class="lead">Video call a doctor, Book appointments, Order health products, Chat with a doctor online, Book health chekups, store health records & read health tips.</p>
                    <a href="#0" class="fadeIn"><img :src="'/img/apple_app.png'" alt="" width="150" height="50" data-retina="true"></a>
                    <a href="#0" class="fadeIn"><img :src="'/img/google_play_app.png'" alt="" width="150" height="50" data-retina="true"></a>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /white_bg -->
</template>

<script>
    import app_info from '../../../helpers/config'
    export default {

        data(){
            return {
                app_info: app_info.app_data
            }
        }

    }
</script>

<style scoped>

</style>
