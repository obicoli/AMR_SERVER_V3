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
                                                    <strong v-if="expired_link" class="cl-red txt-uppercase">Expired Link!</strong>
                                                    <strong v-else class="cl-white txt-uppercase">Create a Password</strong>
                                                </p>
                                                <form @submit.prevent="accept_invitation" class="login-container">
                                                    <div class="form-group">
                                                        <label>Email address:</label>
                                                        <input type="email" v-model="form.email" required disabled class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Enter your password</label>
                                                        <input type="password" v-model="form.password" :disabled="expired_link" required class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Confirm password</label>
                                                        <input type="password" v-model="form.password_confirmation" :disabled="expired_link" required class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" :disabled="expired_link" class="btn btn-primary btn-xl">
                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Please wait...</span>
                                                            <span v-else>Accept Invitation</span>
                                                        </button>
                                                    </div>
                                                </form>
                                                <p class="text-center cl-white login-logo-s">
                                                    <router-link to="/"><img src="/assets/front/images/amref-logo.png"></router-link><br>
                                                    Electronic Dispensing & Inventory Tracking Tool<br>
                                                    <strong>EDITT V1</strong>
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
    import PageHeader  from '../../front/partials/Header';
    import PageFooter  from '../../front/partials/Footer';
    import AppInfo from '../../../helpers/config';
    import Auth from '../../../store/auth';
    import {post,get} from "../../../helpers/api";
    import {createHtmlErrorString} from "../../../helpers/functionmixin";
    import {USER_ACCEPT_INVITATION_URL,USER_INVITED_LOAD_URL} from "../../../router/api_routes";
    export default {
        name: "AcceptInvite",
        components: {
            PageHeader,
            PageFooter,
        },
        data(){
            return {
                expired_link: false,
                processing: false,
                accept_invite: true,
                user_data: {},
                app_data: AppInfo.app_data,
                form: {
                    user_uuid: this.$route.params.user_uuid,
                    practice_id: this.$route.params.uuid,
                    email: '',
                    password: '',
                    password_confirmation: '',
                }
            }
        },
        created(){
            this.loadUser();
        },
        methods: {

            accept_invitation() {
                this.processing = true;
                post(USER_ACCEPT_INVITATION_URL, this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success("Successful! You can now login");
                        window.location.href = "/login";
                    }
                })
                .catch((err) => {
                    if(err.response.status === 422) {
                        this.expired_link = false;
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        this.$router.push('/500');
                    }else if(err.response.status === 401){
                        this.expired_link = true;
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                    this.form.password = "";
                    this.form.password_confirmation = "";
                });
            },
            sign_out(){
                Auth.remove();
                window.location.href = "/";
            },
            sign_in(){
                window.location.href = Auth.redirect_route();
            },
            
            loadUser(){
                get(USER_INVITED_LOAD_URL+'/'+this.form.user_uuid+'/'+this.form.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.user_data = res.data.results;
                        this.form.email = this.user_data.email;
                    }
                }).catch((err) => {

                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        this.$router.push('/500');
                    }else if(err.response.status === 401){
                        this.expired_link = true;
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                    this.form.password = "";
                    this.form.password_confirmation = "";

                });
            },

        },
        mounted() {

        }
    }
</script>

<style scoped>

    body {
        /*font-family: 'Open Sans', sans-serif;*/
        line-height: 20px;
        color: #999999;
        font-size: 16px;
    }
    ol, ul {
        list-style: none;
    }
    blockquote, q {
        quotes: none;
    }
    blockquote:before, blockquote:after,
    q:before, q:after {
        content: '';
        content: none;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }
    h1, h2, h3, h4, h5, h6
    {
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        color: #222222;
    }
    a, a:hover, a:focus, a:active{
        outline: none;
    }

    .section-padding{
        padding: 60px 0px;

    }
    h2 {
        line-height: 20px;
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        text-transform: uppercase;
    }
    hr.botm-line {
        height: 3px;
        width: 60px;
        background: #ffb737;
        position: relative;
        border: 0;
        margin: 20px 0 20px 0;
    }

    /***************************************
    banner
    ***************************************/
    .navbar {
        margin-bottom: 0px;
        border: 0px;
    }
    .navbar {
        border-radius: 0px;
    }
    .navbar-default {
        background-color: #fff;
        padding-top: 4px;
        transition: all 0.3s;
    }
    .navbar-default {
        background-color: transparent;
        border: 0px;
    }
    .navbar {
        border-radius: 0px;
        z-index: 99;
    }

    .navbar-brand
    {
        font-family: 'Chewy', cursive;
        font-size: 32px;
    }

    .navbar-brand img {
        padding-top: 2px;
        width: 120px !important;
    }

    .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
        color: #EA6045;
    }

    .top-nav-collapse {
        padding: 0;
        background: rgba(66, 202, 249, 0.9);
    }

    .white, .white:hover, .white:focus
    {
        color: #fff;
        width: 100% !important;
    }
    .block
    {
        display: block;
    }
    .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover {
        color: #fff;
        text-transform: uppercase;
        background-color: #00c0ef;
    }
    .navbar-default .navbar-nav > li > a
    {
        color: #fff;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: 300;
    }
    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus
    {
        color: #fff;
        text-transform: uppercase;
        background-color: #00c0ef;
    }
    .affix {
        background-color: #ffffff !important;
    }
    .affix .navbar-nav > li > a:hover, .affix .navbar-nav > li > a:focus
    {
        /*background-color: rgba(12, 184, 182) !important;*/
    }

    .bg-color{

        min-height: 650px;
    }
    .banner-info{
        background-color: #fff;
        max-height: 400px;
        min-width: 350px;
        margin-top:50px;
        border-radius: 5px;
        padding: 20px;
    }
    .banner-logo img{
        display: inline-block;
    }
    .banner-text{
        color: #fff;
    }
    .banner-text h1{
        font-family: 'Candal', sans-serif;
        font-size: 35px;
        text-transform: uppercase;
        padding-bottom:15px;
    }
    .btn-appoint, .btn-appoint:hover, .btn-appoint:focus{
        margin-top: 30px;
        padding: 10px 20px;
        font-size: 12px;
        background-color: #00c0ef;
        border-radius: 3px;
        color: #fff;
    }
    .overlay-detail a i {
        text-align: center;
        position: absolute;
        bottom: 25px;
        font-size: 38px;
        color: #fff;
        margin: 0 auto;
    }
    .text-primary i{
        padding-top: 8px;
        display: inline-block;
    }
    /***************************************
    services
    ***************************************/
    .icon i{
        color: #00c0ef;
        font-size: 45px;
        margin-bottom: 25px;
    }
    .service-info{
        margin-bottom: 20px;
    }
    .icon-info h4{
        padding-bottom: 15px;
    }
    .icon-info p{
        font-size: 15px !important;
    }
    /***************************************
    cta-1
    ***************************************/
    .schedule-tab {
        background-color: #00c0ef;
        float: left;
    }
    .medi-info{
        border-right: 1px solid #fff;
    }
    .medi-info, .time-info{
        padding: 20px;
        color: #fff;
    }
    .medi-info h3, .time-info h3{
        padding-bottom: 16px;
        color: #fff;
        font-weight: 600;
    }
    .medi-info-btn, .medi-info-btn:hover, .medi-info-btn:focus {
        margin: 15px 0px 5px;
        display: inline-block;
        border: solid white 2px;
        padding: 3px 8px;
        font-size: 12px;
        color: #fff;
        font-weight: 400 !important;
        cursor: pointer;
    }
    td {
        border: 0px solid #ededed;
        border-top: 1px solid rgba(216, 216, 216, 0.5);
        padding: 6px 10px 6px 0;
    }
    .medi-info, .time-info{
        font-size: 14px;
    }
    /***************************************
    about
    ***************************************/
    #about{
        background-color: rgba(238, 238, 238, 0.15);
    }
    .lg-line{
        line-height: 1.4;
        font-size: 28px;
    }
    .more-features-box-text-icon {
        float: left;
        width: 40px;
        height: 40px;
        padding-top: 6px;
        background: #00c0ef;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        color: #fff;
        text-align: center;
    }
    .more-features-box-text-description h3{
        padding-bottom: 15px;
    }
    .more-features-box-text-icon i {
        font-size: 18px;
        line-height: 26px;
    }
    .more-features-box-text-description{
        margin-left: 80px;
        margin-bottom: 35px;
    }
    .sec-para{
        padding-bottom: 10px;
    }
    /***************************************
    doctor team
    ***************************************/
    .thumbnail {
        border-radius: 0px;
    }
    .caption h3{
        padding-bottom: 5px;
    }
    .caption p{
        padding-bottom: 10px;
    }
    /***************************************
    testimonial
    ***************************************/
    #testimonial{
        background-color: #eee;
    }
    .testi-details {
        background: #fff;
        padding: 14px 24px;
        margin-bottom: 20px;
        box-shadow: 3px 3px 2px 0px rgba(0,0,0,0.18);
        position: relative;
    }
    .testi-info a {
        display: block;
        width: 50px;
        height: 50px;
        background-color: #fff;
        border-radius: 50%;
        float: left;
        margin-right: 10px;
    }
    .testi-info a img{
        border-radius: 50%;
    }
    .testi-info h3 {
        display: inline-block;
        line-height: 22px;
        font-weight: 600;
        color: #000;
        margin-top: 8px;
    }
    .testi-info h3 > span {
        display: block;
        line-height: 16px;
        font-weight: 400;
    }
    .testi-details::after {
        content: "";
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
        border-color: transparent;
        border-left: 0;
        bottom: -40px;
        left: 56px;
        border-top-color: #fff;
        border-width: 20px;
    }
    .testi-details::before {
        content: '';
        position: absolute;
        transform: rotate(45deg);
        width: 0px;
        height: 0px;
        bottom: -30px;
        left: 45px;
        border-style: solid;
        border-width: 15px;
        border-color: transparent;
        z-index: -1;
        box-shadow: 3px -13px 5px 0px rgba(0, 0, 0, 0.18);
        border-left: 0;
    }
    /***************************************
    cta -2
    ***************************************/
    #cta-2{
        background-color: rgb(41, 48, 46);
    }
    .white{
        color: #fff;
    }
    .icon-play, .icon-play:hover, .icon-play:focus{
        background-color: #00c0ef;
        padding: 5px 10px;
        color: #fff;
        text-decoration: none;
        padding: 5px 17px;
        margin-top: 26px;
        display: block;
    }
    .text-primary {
        color: #00c0ef;
    }
    .icon-mar
    {
        margin-right: 7px;
    }
    /***************************************
    contact us
    ***************************************/
    .space {
        margin-top: 40px;
    }
    .btn-form, .btn-form:hover, .btn-form:focus {
        background-color: #00c0ef;
        color: #fff;
        border-radius: 0px;
        padding: 10px 20px;
    }
    .br-radius-zero {
        border-radius: 0px;
    }
    .form-control{
        height: 40px;
    }

    .validation {
        color: red;
        display:none;
        margin: 0 0 20px;
        font-weight:400;
        font-size:13px;
    }

    #sendmessage {
        color: green;
        border:1px solid green;
        display:none;
        text-align:center;
        padding:15px;
        font-weight:600;
        margin-bottom:15px;
    }

    #errormessage {
        color: red;
        display:none;
        border:1px solid red;
        text-align:center;
        padding:15px;
        font-weight:600;
        margin-bottom:15px;
    }

    #sendmessage.show, #errormessage.show, .show {
        display:block;
    }


    /***************************************
    footer
    ***************************************/
    #footer{
        background-color: #04698c;
        color: #fff!important;
    }
    .ftr-tle {
        height: 50px;
    }
    .info-sec {
        color: #fff;
    }
    .quick-info li i {
        font-size: 8px;
        width: 15px;
        height: 15px;
        line-height: 15px;
        text-align: left;
    }
    .social-icon li {
        float: left;
        width: 50px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        margin-right: 5px;
    }
    .bglight-blue {
        background-color: #3498DB;
    }
    .bgred {
        background-color: #E74C3C;
    }
    .bgdark-blue {
        background-color: #2C3E50;
    }
    .bglight-blue {
        background-color: #3498DB;
    }
    .top-footer {
        padding: 40px 0px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }
    .footer-line {
        /*padding: 30px 0px;*/
        padding: 15px 0!important;
        color: #fff;
        font-size: 13px!important;
    }

    .footer-line a {
        color: #00c0ef;
    }

    .quick-info li a{
        color: #fff;
    }
    .site-link, .site-link:hover, .site-link:focus
    {
        color: #00c0ef;
        text-transform: none;
    }
    @media (min-width: 551px) and (max-width: 980px){

    }
    @media (min-width: 220px) and (max-width: 551px){
        .testi-info{
            margin-bottom: 20px;
        }
        .marb20{
            margin-top: 30px;
        }
        h2{
            font-size: 24px;
            line-height: 1.2;
        }
        .section-title{
            margin-bottom: 30px;
        }
        .medi-info {
            border: 0px;
            border-bottom: 1px solid #fff;
        }
        .service-info{
            margin-top: 20px;
            margin-bottom: 0px;
        }
        .caption h3 {
            font-size: 14px;
        }
        .caption p{
            font-size: 12px;
            padding-bottom: 5px;
        }
        .caption ul li a i{
            font-size: 14px;
        }
        .banner-text h1{
            font-size: 24px;
        }
    }

    .no-results{
        color:#000;
    }

    .dropdown-toggle{
        padding:3% !important;
    }
    .modal-title{
        color:#00c0ef;

        font-size:14px;
    }

    .btn-set{
        background-color:#00c0ef;
        border-radius:0;
    }
    .label{
        color:#000;
    }
    .link-set{
        font-size:12px;
    }

    .model-alignment{
        left:-9px;
    }
    .color-set{
        color:#fff;
    }
    .testamonials{
        margin-top:30px;
    }
    .thumbnail>img{
        display:inline;
    }
    .carousel-control
    {
        z-index: 1;
    }
    .carousel-control.right
    {
        background-image:none;
    }
    .carousel-control.left
    {
        background-image:none;
    }
    .slider_imgs
    {
        width:100%;
        height: 640px !important;
    }
    .section_content
    {
        position: absolute ;
        top: 0 ;
        width:100%;
    }
    .navbar
    {
        background-color: rgba(66, 202, 249, 0.9);
    }

    .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        height: 36px!important;
    }

</style>