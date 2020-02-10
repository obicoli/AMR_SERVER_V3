<template>
    <div id="app_section">
        <div class="container margin_40_20">

            <div class="row">
                <div class="col-md-12">
                    <p class="text-center"><router-link to="/doctor/profiles" class="btn_1 medium">Find Doctor</router-link></p>
                </div>
            </div>

        </div>
        <!-- /container -->
    </div>
    <!-- /app_section -->
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
