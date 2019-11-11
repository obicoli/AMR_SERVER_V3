<template>
    <footer class="bg-blue-navy">
        <div class="pp-copyright short">
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-1">
                    <ul class="foot-links">
                        <li class="li-title">{{app_info.app_name}}</li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Career</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Answer</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Doctor blog</a></li>
                        <li class="sec show-for-small-only"><a href="#" class="secimg s1"><span><img src="#" alt=""></span></a></li>
                        <li class="sec show-for-small-only"><a href="#" class="secimg s2"><span><img src="#" alt=""></span></a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <ul class="foot-links">
                        <li class="li-title">Find your doctor</li>
                        <li><a href="#">Doctor name</a></li>
                        <li><a href="#">Practice name</a></li>
                        <li><a href="#">Hospital</a></li>
                        <li><a href="#">Specialist</a></li>
                        <li><a href="#">Language</a></li>
                        <li><a href="#">Location</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <ul class="foot-links">
                        <li class="li-title">Specialist</li>
                        <li><a href="#">Chiropractors</a></li>
                        <li><a href="#">Dentists</a></li>
                        <li><a href="#">Dermatologists</a></li>
                        <li><a href="#">Eye Doctors</a></li>
                        <li><a href="#">Gynecologists</a></li>
                        <li><a href="#">Primary care doctors</a></li>
                        <li><a href="#">Psychiatrists</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-2">
                    <ul class="foot-links">
                        <li><a href="#">Help &amp; Contact</a></li>
                        <li><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Security</a></li>
                        <li class="li-title">Socials</li>
                        <li><a href="#"><i class="fa fa-facebook-f"></i> Facebook </a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i> Twitter </a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i> Google </a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i> Instagram </a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="foot-links">
                        <li class="li-title">Are you a top doctor or dentist?</li>
                        <li><a href="#">Join Now </a></li>
                        <li class="li-title">{{app_info.app_name}} for health systems</li>
                        <li><a href="#">Learn more </a></li>
                    </ul>
                </div>
                <div class="column medium-12 col-md-12 text-center pb-5 cl-white">
                    ©2009-2018 {{app_info.app_name}}™, all rights reserved
                </div>
            </div>
        </div>
        <!--END COPYRIGHT-->
    </footer>
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
