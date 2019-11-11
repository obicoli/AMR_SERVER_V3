<template>
    <div v-bind:class="{'bg_color_1':false,'mt-59':mt_59,'bg_color_blue':true}">
        <div class="container margin_40_20">
            <div class="row">
                <div class="col-lg-2 col-sm-6 why_afyamkononi text-center">
                    <a>
                        <span><i class="pe-7s-chat"></i></span>
                        <h5>Chat with a doctor</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-sm-6 why_afyamkononi text-center">
                    <a>
                        <span><i class="pe-7s-cart"></i></span>
                        <h5>Order medicine</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-sm-6 why_afyamkononi text-center">
                    <a>
                        <span><i class="pe-7s-note2"></i></span>
                        <h5>View medical records</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-sm-6 why_afyamkononi text-center">
                    <a>
                        <span><i class="pe-7s-browser"></i></span>
                        <h5>Book appointment</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-sm-6 why_afyamkononi text-center">
                    <a>
                        <span><i class="pe-7s-help1"></i></span>
                        <h5>Ask a health query</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-sm-6 why_afyamkononi text-center">
                    <router-link to="/how/it/works/for-doctors">
                        <span><i class="pe-7s-eyedropper"></i></span>
                        <h5>For healthcare providers</h5>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import app_info from '../../../helpers/config'
    export default {
        props: ['mt_59'],
        data(){
            return {
                app_info: app_info.app_data
            }
        }

    }
</script>
