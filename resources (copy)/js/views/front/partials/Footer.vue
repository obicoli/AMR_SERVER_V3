<template>
    <!--footer-->
    <footer id="footer" v-bind:class="{'bg-auth':classes,'bg-white':classes_1}">
        <div class="footer-line">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center fs-14">
                        © Copyright {{app_info.app_name}} 2019  All Rights Reserved. Designed by <a href="https://virtualglobal.net/" target="_blank"> Virtual Global </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--/ footer-->
</template>

<script>
    import app_info from '../../../helpers/config'
    export default {
        props: ['classes','classes_1'],
        data(){
            return {
                app_info: app_info.app_data
            }
        }

    }
</script>
