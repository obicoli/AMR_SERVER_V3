<template>

    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Company</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="REPORT_CONFIG" class="">Manage Users</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="REPORT_CONFIG" class="">Control User Access</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="REPORT_CONFIG" class="">Change Password</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="REPORT_CONFIG" class="">My Profile</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="REPORT_CONFIG" class="">Logout</router-link>
                </li>
            </ul>
        </li>
    </ul>

</template>

<script>
import {BANKS_WEB_ROUTES,REPORT_CONFIG_WEB_ROUTES} from "../../../../../../router/web_routes";
    export default {
        props: ['scrollable','width','title','active_num','supplier','customer','product','taxation'],
        data(){
            return {
                BANKS_WEB_ROUTES:BANKS_WEB_ROUTES,
                REPORT_CONFIG:REPORT_CONFIG_WEB_ROUTES.CONFIG,
            }
        },
    }
</script>