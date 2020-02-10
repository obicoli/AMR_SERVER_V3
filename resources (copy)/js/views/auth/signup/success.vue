<template>

    <div id="page">
        <page-header></page-header>
        <loading :is-loading="processing"></loading>

        <main>

            <div id="breadcrumb">
                <div class="container">
                    <ul>
                        <li><a href="#">Book appointment</a></li>
                        <li><a href="#">Chat with a doctor</a></li>
                        <li><a href="#">Order medicines</a></li>
                        <li><a href="#">View medical records</a></li>
                        <li><a href="#">Read health article</a></li>
                    </ul>
                </div>
            </div>
            <!-- /breadcrumb -->

            <div class="container margin_120">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div id="confirm">
                            <div class="icon icon--order-success svg add_bottom_15">
                                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
                                    <g fill="none" stroke="#8EC343" stroke-width="2">
                                        <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                                        <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                                    </g>
                                </svg>
                            </div>
                            <h2>Thanks for your Registration!</h2>
                            <p>
                                <img :src="'/img/inbix.png'" class="inbox-img"><br>
                                We sent a verification email to <strong>{{user_mail}}</strong>. Click the link in it to continue
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->

            <download-app></download-app>

        </main>
        <!-- /main -->

        <page-footer></page-footer>
    </div>

</template>

<script type="text/javascript">
    import PageHeader from '../../front/partials/Header'
    import PageFooter from '../../front/partials/Footer'
    import Loading from '../../../components/loads/ProgRess'
    import app_info from '../../../helpers/config'
    import DownloadApp from '../../front/partials/downloadapp'
    export default {
        components: {
            PageHeader,
            PageFooter,
            Loading,
            DownloadApp
        },
        data() {
            return {
                app_info: app_info,
                processing: false,
                user_mail: localStorage.getItem('user_mail')
            }
        },
        methods: {
        },
    }
</script>

<style lang="scss">
    @import '~vue-awesome-notifications/dist/styles/style.scss';
</style>

