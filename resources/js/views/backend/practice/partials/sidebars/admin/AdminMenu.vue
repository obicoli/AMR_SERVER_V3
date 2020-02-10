<template>

    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Adminstration</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-if="permCheck(ADMIN_PERM.USERS.VIEW)" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="ADMINSTRATIVE.USERS" class="">Manage Users</router-link>
                </li>
                <li v-if="permCheck(ADMIN_PERM.USERS.VIEW)" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="ADMINSTRATIVE.USER_ACCESS" class="">Control User Access</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="ADMINSTRATIVE.CHANGE_PASSWORD" class="">Change Password</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="ADMINSTRATIVE.MY_ACCOUNT" class="">My Profile</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <a @click="logoutUser()" class="">Logout</a>
                </li>
            </ul>
        </li>
    </ul>

</template>

<script>
    import {BANKS_WEB_ROUTES,REPORT_CONFIG_WEB_ROUTES,ADMINSTRATIVE} from "../../../../../../router/web_routes";
    import {ADMIN_PERM} from "../../../../../../helpers/permissions";
    import Auth from "../../../../../../store/auth";
    export default {
        props: ['scrollable','width','title','active_num','supplier','customer','product','taxation'],
        data(){
            return {
                BANKS_WEB_ROUTES:BANKS_WEB_ROUTES,
                REPORT_CONFIG:REPORT_CONFIG_WEB_ROUTES.CONFIG,
                ADMINSTRATIVE:ADMINSTRATIVE,
                ADMIN_PERM:ADMIN_PERM,
            }
        },
        methods: {
            permCheck(perm_){
                return Auth.hasPermission(perm_);
            },
            logoutUser(){
                Auth.remove();
                window.location.href = "/";
            }
        }
    }
</script>