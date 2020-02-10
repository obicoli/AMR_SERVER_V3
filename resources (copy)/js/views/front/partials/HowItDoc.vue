<template>
    <div class="bg_color_1">
        <div class="container margin_120_95">
            <div class="row add_bottom_30">
                <div class="col-lg-4">
                    <div class="box_feat box_feat_customs no-bordered no-shadowed">
                        <div class="each-guide-number">1</div>
                        <span></span>
                        <h4>Join Our Community</h4>
                        <p>
                            Enter your name, email id, mobile number and clinic or establishment name.
                            We bring the patients to you!
                            Get private work with zero marketing costs, no room charges and no travelling involved
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box_feat box_feat_customs no-bordered no-shadowed">
                        <div class="each-guide-number">2</div>
                        <span></span>
                        <h4>Enjoy On-Demand Income</h4>
                        <p>
                            Set your availability for scheduled and on-demand consults
                            Get notified when patients are waiting or you've been booked
                            Work as little or as much as you like anytime, any day
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box_feat box_feat_customs no-shadowed no-bordered">
                        <div class="each-guide-number">3</div>
                        <h4>Attract New Patients</h4>
                        <p>
                            We try to match you with patients in your geographic area
                            Patients are provided with your medical practice information
                            Invite them to see you physically on their next GP or consultant visit.
                        </p>
                    </div>
                </div>
            </div>
            <!-- /row -->
            <p class="text-center"><router-link to="/login" class="btn_1_custom">List your practice on {{app_info.app_name}}</router-link></p>

        </div>
        <!-- /container -->
    </div>
    <!-- /white_bg -->
</template>

<script>
    import app_data from '../../../helpers/config'
    export default {
        data(){
            return {
                app_info: app_data.app_data,
            }
        }
    }
</script>

<style scoped>

</style>
