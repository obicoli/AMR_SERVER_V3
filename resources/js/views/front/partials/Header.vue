<template>

    <!-- Navbar section-->
    <!--<nav id="mainNav" class="navbar navbar-default  navbar-fixed">-->
    <nav id="mainNav" v-bind:class="{'navbar':true,'navbar-default':true,'navbar-fixed':true,'nav-shadowed':shadowed,'bg-blue':blue}">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed border-radius-2 no-shadowed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top"></a>
                <a href="/">
                    <img :src="'/assets/images/icons/logo.png'" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a class="page-scroll fw-400"><i class="fa fa-video-camera"></i> See a doctor now</a></li>
                    <li><a class="page-scroll fw-400">How it works</a></li>
                    <li><a class="page-scroll fw-400">About</a></li>
                    <li><a class="page-scroll fw-400">Contact</a></li>
                    <li><a href="/login" class="page-scroll fw-400 text-uppercase"><i class="fa fa-lg fa-user-circle-o"></i>My Account</a></li>
                </ul>
            </div> <!-- /.navbar-collapse -->
        </div> <!--/.container -->
    </nav>
    <!-- Slider section-->
    
</template>

<script>
    export default {
        name: "Header",
        props: ['shadowed','blue']
    }
</script>

<style scoped>

</style>
