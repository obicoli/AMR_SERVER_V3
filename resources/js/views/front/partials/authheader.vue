<template>

    <nav :class="{'navbar':true,'top-navigation':true, 'border-bottom':false, 'navbar-expand-lg':true, 'navbar-light':true,'bg-yellow':true}">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav flex-wrap justify-content-center">
                <li class="nav-item">
                    <router-link to="/" class="nav-link cl-blue-navy" title="Dashboard">
                        Home
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/" class="nav-link cl-blue-navy" title="Dashboard">
                        What we treat
                    </router-link>
                </li>
                <li class="nav-item dropdown">
                    <router-link to="/login" class="nav-link cl-blue-navy" title="Layout Options">
                        Login
                    </router-link>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link btn btn-blue-outline border-zeroed" href="#" data-toggle="dropdown" title="Layout Options">
                        List your practice on {{app_info.app_name}}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link btn btn-blue-dark border-zeroed" href="#" data-toggle="dropdown" title="Layout Options">
                        Register As:
                    </a>
                    <div class="dropdown-menu">
                        <router-link to="/doctor/signup" class="dropdown-item">a Doctor</router-link>
                        <router-link to="/patient/signup" class="dropdown-item">a Patient</router-link>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
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
