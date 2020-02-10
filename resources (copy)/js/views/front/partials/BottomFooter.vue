<template>
    <footer style="background-color: #00234b!important;">
        <div class="container margin_30_15">
            <div class="row">
                <div class="col-md-8">
                    <ul id="additional_links">
                        <li><a href="#0" style="color: #fff!important;">Terms and conditions</a></li>
                        <li><a href="#0" style="color: #fff!important;">Privacy</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div id="copy" style="color: #fff!important;">© 2017 {{app_info.app_name}}</div>
                </div>
            </div>
        </div>
    </footer>
    <!--/footer-->
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
