<template>

    <div id="progressModal" class="overlay" data-backdrop="static" data-keyboard="false">
        <div class="overlay-content">
            <img src="/assets/progress/spinner.gif">
            <a>{{message}}</a>
        </div>
    </div>
    
</template>

<script>
    export default {
        name: "ProcessingOverlay",
        props: ['message','title','status'],
        watch: {
            status: function(new_status,old_status){
                $("#progressModal").modal(new_status)
            }
        }
    }
</script>

<style scoped>
    .overlay {
        height: 100%;
        width: 100%;
        display: none;
        position: fixed;
        z-index: 10000;
        top: 0;
        left: 0;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0, 0.9);
    }

    .overlay-content {
        position: relative;
        top: 25%;
        width: 100%;
        text-align: center;
        margin-top: 30px;
    }

    .overlay a {
        padding: 8px;
        text-decoration: none;
        font-size: 17px!important;
        color: #fff!important;
        display: block;
        transition: 0.3s;
    }

    .overlay .closebtn {
        position: absolute;
        top: 20px;
        right: 45px;
        font-size: 60px;
    }

    .overlay-content img{
        width: 100px;
        height: 100px;
    }

</style>


