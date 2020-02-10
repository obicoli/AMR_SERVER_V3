<template>
    <div class="bg_color_1">
        <div class="container margin_120_95">
            <div class="row add_bottom_30">
                <div class="col-lg-4">
                    <div class="box_feat box_feat_customs no-bordered no-shadowed">
                        <div class="each-guide-number">1</div>
                        <span></span>
                        <h4>Request a call/chat</h4>
                        <p>You can request to see a doctor for a 15 minute virtual consultation whenever works best for you.
                            We're open from 8am to 11pm, 7 days a week, 365 days a year. We guarantee that you'll always
                            be able to see a doctor same-day. Right care when you need it most..
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box_feat box_feat_customs no-bordered no-shadowed">
                        <div class="each-guide-number">2</div>
                        <span></span>
                        <h4>Have a consultation</h4>
                        <p>Securely and privately explain your health concern. You can use your computer
                            or tablet. Once your consultation is complete, you can immediately access your doctor's
                            treatment notes, download your prescription, and more through your dashboard.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box_feat box_feat_customs no-shadowed no-bordered">
                        <div class="each-guide-number">3</div>
                        <h4>Get the right treatment</h4>
                        <p>Our doctors can provide medical advice, diagnose, treat, prescribe and even refer you onto a
                            specialist. If you need a prescription, it will be instantly sent to your inbox to take to
                            your chosen pharmacy or you can have it fufilled & delivered.
                        </p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-center txt-1-3">
                        <p><strong>Note: Free  Followups</strong> Ask your followup questions for free, upto 7 days after the chat ends.</p>
                    </div>
                </div>
            </div>
            <!-- /row -->
            <p class="text-center"><router-link to="/login" class="btn_1_custom">Call a doctor</router-link></p>

        </div>
        <!-- /container -->
    </div>
    <!-- /white_bg -->
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
