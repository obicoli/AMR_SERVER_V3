<template>
    <div class="bg_color_1">
        <div class="container margin_30_15">
            <div class="row">
                <div class="col-lg-3 why_afyamkononi text-center">
                    <span><i class="icon-wheelchair"></i></span>
                    <h3>Get new patients</h3>
                    <p>Most <strong>{{app_info.app_name}}</strong> providers received between 26 and 119 new patient bookings in 2017.</p>
                </div>
                <div class="col-lg-3 why_afyamkononi text-center">
                    <span><i class="icon-calendar-6"></i></span>
                    <h3>Fill last minute openings</h3>
                    <p>Almost half of <strong>{{app_info.app_name}}</strong> appointments occur within 72 hours of booking.</p>
                </div>
                <div class="col-lg-3 why_afyamkononi text-center">
                    <span><i class="icon-star-empty-2"></i></span>
                    <h3>Strengthen your reputation</h3>
                    <p>Get verified reviews from real patients. After just one year, the average provider has 40 ratings.</p>
                </div>
                <div class="col-lg-3 why_afyamkononi text-center">
                    <span><i class="icon-th-list-2"></i></span>
                    <h3>Diversify your payor mix</h3>
                    <p>82% of <strong>{{app_info.app_name}}</strong> bookings are from commercially insured or cash-pay patients.</p>
                </div>
            </div>
        </div>
    </div>
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
