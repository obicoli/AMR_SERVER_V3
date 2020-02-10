<template>

    <div>

        <!--banner-->
        <section>
            <div id="myCarousel" class="carousel slide " data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                    <li data-target="#myCarousel" data-slide-to="4"></li>
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img class="img-responsive slider_imgs" src="uploads/systemimgs/scroll1.jpeg" />
                    </div>
                    <div class="item ">
                        <img class="img-responsive slider_imgs"  src="uploads/systemimgs/3bd680cbfe01b350c5627b0781acd9bc.png" />
                    </div>
                    <div class="item ">
                        <img class="img-responsive slider_imgs"  src="uploads/systemimgs/9ca86106d2dca70bfb12e2d5163a4443.jpg" />
                    </div>
                    <div class="item ">
                        <img class="img-responsive slider_imgs"  src="uploads/systemimgs/86c470aaa38d95680490777667771de1.png" />
                    </div>
                    <div class="item ">
                        <img class="img-responsive slider_imgs"  src="uploads/systemimgs/9373e9594181bdcf9392d9bf9742704d.jpg" />
                    </div>


                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a  class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>

            </div>
            <div class="section_content">

                <page-header></page-header>

                <div class="container">
                    <div class="row">
                        <div class="banner-info">
                            <div class="banner-text text-center">
                                <h1 class="white">{{app_data.app_name}}</h1>
                            </div>
                            <div class="banner-text text-center">
                                <h4>{{app_data.app_description}}</h4>
                            </div>
                            <div class="row banner-text" style="margin-top:25px;" >
                                <div class="col-md-12">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select  style="color:#000; z-index:9999;" class="selectpicker form-control  col-md-12 height-36 border-radius-2" data-live-search="true"  >

                                                <option>SEARCH MEDICINES & OTHER ITEMS AVAILIBILITY</option>

<!--                                                <option data-subtext="">Panadol | Generic Paracetamol | 10 Ml | Stock 2722-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">Relief | Generic Paracetamol | 10 Ml | Stock 3439-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">Grat | Generic Gemifloxcin | 320 Kg | Stock 0-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">flunxine | Generic f.unix | 100 Kg | Stock 0-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">test product | Generic generic product | 20 ltr | Stock 3356-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">indral | Generic indral | 100 Kg | Stock 900-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">PANADOL | Generic PARACETAMOL | 250 GM | Stock 1138-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">Flaygl | Generic antamezol | 120 Kg | Stock 21-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">tsfadfadsf | Generic  | 110 Kg | Stock 45-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">tesss | Generic tessss | 110 Kg | Stock 0-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">Mohsin test | Generic Test | 1 Pcs | Stock 92-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">syp laxoberon | Generic sodium picosulphate | 120 Ml | Stock 0-->
<!--                                                </option>-->
<!--                                                <option data-subtext="">Pacomox | Generic Amoxicillin | 500 Pcs | Stock 0-->
<!--                                                </option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>
                            <div class="banner-text text-center">
                                <a data-toggle="modal" data-target="#page_model_view_data" type="button" class="btn btn-appoint">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="page_model_view_data">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content border-ccc border-radius-2">
                        <div  class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label>Email or Mobile</label>
                                    <input type="text" v-model="form.email_or_mobile" required class="form-control height-32 border-ccc border-radius-2">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" v-model="form.password" required class="form-control height-32 border-ccc border-radius-2">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default border-radius-2" data-dismiss="modal">Close</button>
                            <button @click="login" type="button" class="btn btn-primary border-radius-2">
                                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Processing...</span>
                                <span v-else>Login</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div> <!-- Bootstrap model  ends-->

        </section>
        <!--/ banner-->
        <page-footer></page-footer>

    </div>

</template>

<script>
    import PageHeader  from './partials/Header'
    import PageFooter  from './partials/Footer'
    import AppInfo from '../../helpers/config'
    import Auth from '../../store/auth'
    import {post} from "../../helpers/api";
    import {createHtmlErrorString} from "../../helpers/functionmixin";

    export default {
        components: {
            PageHeader,
            PageFooter,
        },
        data(){
            return {
                processing: false,
                app_data: AppInfo.app_data,
                form: {
                    email_or_mobile: '',
                    password: ''
                }
            }
        },
        created(){
            //Auth.remove();
        },
        methods: {
            login() {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/oauth/login', this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            console.info(res.data.results);
                            this.$awn.warning('something');
                            if ( res.data.results.length === 1 ){
                                if (res.data.results[0].account_type === 'Pharmacy') {
                                    Auth.set(res.data.access_token,res.data.token_type,res.data.expires_at,res.data.results,res.data.results[0])
                                }else if(res.data.results[0].account_type === 'Practice User'){
                                    Auth.set(res.data.access_token,res.data.token_type,res.data.expires_at,res.data.results,res.data.results[0])
                                }
                                //Auth.set(res.data.access_token,res.data.token_type,res.data.expires_at,res.data.results,res.data.results[0]);
                                window.location.href = Auth.redirect_route();
                            }
                            //Auth.set(res.data.access_token,res.data.token_type,res.data.expires_at,res.data.results);
                            //window.location.href = Auth.redirect_route();
                        }
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                        }else if (err.response.status === 500){
                            this.$awn.warning(err.response.data.description);
                            this.$router.push('/500');
                        }
                        else{
                            this.processing = false;
                            this.$awn.warning(err.response.data.description)
                        }
                        this.processing = false;
                        this.form.password = "";
                    });
            }
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
        padding-top: 190px;
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
