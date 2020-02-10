<template>
    <nav v-bind:class="{'navbar navbar-default navbar-fixed-top':true,'bg-auth':classes,'bg-white':classes_1}">
        <div class="container">
            <div class="col-md-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                    </a>
                </div>
                <div class="collapse navbar-collapse navbar-right" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li v-if="logged_in" class=""><a></a></li>
                        <li v-else class=""><a href="/login">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    import app_info from '../../../helpers/config'
    import Auth from '../../../store/auth'
    export default {
        props:['classes','classes_1'],
        data(){
            return {
                app_info: app_info.app_data,
                logged_in: Auth.state.api_token,
            }
        }

    }
</script>
