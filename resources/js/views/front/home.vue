<template>

    <div class="min-width-100-pc min-height-100-vh">

        <top-thin-header></top-thin-header>

        <page-header></page-header>


        <div id="home">
            <div id="owl-slider" class="owl-carousel owl-theme">

                <div class="item" style="background-image: url(assets/images/slider/sl_1.jpg)">
                    <div class="item-text-inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h4>Online</h4>
                                    <h1><span>Video</span> Consultation</h1>
                                    <ul class="mg-lg-bottom-10">
                                        <li class="pd-left-20 pd-top-10">See a doctor now with {{app_data.app_name}}, no appointment necessary</li>
                                        <li class="pd-left-20 pd-top-10">Signup today for individual or family subscription</li>
                                        <li class="pd-left-20 pd-top-10">Save money with KES. 500 consultation</li>
                                        <li class="pd-left-20 pd-top-10">Skip the waiting room. Chat with a doctor</li>
                                        <li class="pd-left-20 pd-top-10">Get all your medicines. Everytime. On time</li>
                                        <li class="pd-left-20 pd-top-10">All your medical records In one secure app</li>
                                    </ul>
                                    <div class="content-inlined">
                                        <a href="/login" class="app_icons no-bordered no-shadowed text-transformed-none"><img src="/assets/images/app_store/google_play_app.png"></a>
                                        <a href="/login" class="app_icons no-bordered no-shadowed text-transformed-none"><img src="/assets/images/app_store/apple_app.png"></a>
                                    </div>
                                    <!--<a href="/login" class="thm-btn border-radius-2 no-bordered no-shadowed text-transformed-none">See a GP now</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item" style="background-image: url(assets/images/slider/sl_2.jpg)">
                    <div class="item-text-inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h4>Welcome! </h4>
                                    <h1><span>Order</span> Medicine</h1>
                                    <ul class="mg-lg-bottom-10">
                                        <li class="pd-left-20 pd-top-10">Get all your medicines. On time.</li>
                                        <li class="pd-left-20 pd-top-10">Guaranteed availability</li>
                                        <li class="pd-left-20 pd-top-10">Genuine, verifiable medicines</li>
                                        <li class="pd-left-20 pd-top-10">Home delivery in 24hrs</li>
                                    </ul>
                                    <div class="content-inlined">
                                        <a href="#" class="thm-btn border-radius-2 no-bordered no-shadowed">Order Medicines</a>
                                        <a href="#" class="app_icons no-bordered no-shadowed text-transformed-none"><img src="/assets/images/app_store/google_play_app.png"></a>
                                        <a href="#" class="app_icons no-bordered no-shadowed text-transformed-none"><img src="/assets/images/app_store/apple_app.png"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item" style="background-image: url(assets/images/slider/sl_3.jpg)">
                    <div class="item-text-inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <h4>Download</h4>
                                    <h1>
                                        <span>{{app_data.app_name}} </span>App
                                    </h1>
                                    <ul class="mg-lg-bottom-10">
                                        <li class="pd-left-20 pd-top-10">Consult a doctors on video</li>
                                        <li class="pd-left-20 pd-top-10">Book appointments and lab tests</li>
                                        <li class="pd-left-20 pd-top-10">Order medicines</li>
                                        <li class="pd-left-20 pd-top-10">Set treatment reminders</li>
                                        <li class="pd-left-20 pd-top-10">View health records across all clinics</li>
                                        <li class="pd-left-20 pd-top-10">Read health tips</li>
                                    </ul>
                                    <div class="content-inlined">
                                        <a href="#" class="app_icons no-bordered no-shadowed text-transformed-none"><img src="/assets/images/app_store/google_play_app.png"></a>
                                        <a href="#" class="app_icons no-bordered no-shadowed text-transformed-none"><img src="/assets/images/app_store/apple_app.png"></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--<div class="item" style="background-image: url(assets/images/slider/sl_3.jpg)">-->
                    <!--<div class="item-text-inner">-->
                        <!--<div class="container">-->
                            <!--<div class="row">-->
                                <!--<div class="col-md-10 col-md-offset-1">-->
                                    <!--<h4>Lorem Ipsum is simply dummy text of the printing </h4>-->
                                    <!--<h1>-->
                                        <!--<span>Lorem</span>Ipsum is simply dummy text of the printing                             </h1>-->
                                    <!--<p>Lorem Ipsum is simply dummy text of the printingLorem Ipsum is simply dummy text of the printing Lorem Ipsum is simply dummy text of the printing Lorem Ipsum is simply dummy text of the printing Lorem Ipsum is simply dummy text of the printing Lorem Ipsum is simply dummy text of the printing</p>-->
                                    <!--<a href="slider/1/Lorem-Ipsum-is-simply-dummy-text-of-the-printing" class="thm-btn">Read More</a>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->

            </div>
        </div>

    </div>

</template>

<script>

    import TopThinHeader  from './partials/TopThinHeader'
    import PageHeader  from './partials/Header'
    import PageFooter  from './partials/Footer'
    import app_data from '../../helpers/config'
    export default {
        components: {
            PageHeader,
            PageFooter,
            TopThinHeader,
        },
        data(){
            return {
                app_data: app_data.app_data,
            }
        }
    }
</script>
