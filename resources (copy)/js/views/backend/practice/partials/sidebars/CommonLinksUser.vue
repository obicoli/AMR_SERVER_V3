<template>
    <div class="pull pull-right app-header width-100-pc text-right mg-right-50">
        <!-- <router-link to="/svs/dashboard" class="btn-link cl-787887">Svs Dashboard</router-link>&nbsp;&nbsp;&nbsp; -->
        <router-link :to="ADMINSTRATIVE_WEB_ROUTES.USERS" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='users'}">Users</router-link>&nbsp;&nbsp;
        <router-link :to="ADMINSTRATIVE_WEB_ROUTES.ROLES" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='roles'}">Roles</router-link>&nbsp;&nbsp;
    </div>
</template>

<script>
    import {ADMINSTRATIVE_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        props: ['active_link'],
        data(){
            return {
                ADMINSTRATIVE_WEB_ROUTES: ADMINSTRATIVE_WEB_ROUTES
            }
        }
    }
</script>

<style lang="scss" scoped>
    .app-header a.active{
        color: #d34336!important;
        text-decoration: underline!important;
    }
</style>


