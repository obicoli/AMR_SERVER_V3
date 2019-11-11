<template>

    <!-- Footer  -->
    <div class="row footer-row">
        <div class="col-md-12">
            <footer class="main-footer  text-center">
                <p>
                    © Copyright {{pharmacy_name}} v1.0 2019 developed by <a href="https://www.virtualglobal.net" target="_blank">Virtual Global</a>. All Rights Reserved.
                </p>
            </footer>
        </div>
    </div>  <!-- Footer Ends -->
    
</template>

<script>
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    export default {
        name: "Footer",
        data(){
            return {
                pharmacy_name: ""
            }
        },
    }
</script>

<style scoped>

</style>