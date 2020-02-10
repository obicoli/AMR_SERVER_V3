<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">{{title}}</a>
        </li>
        <!-- <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='reports'}">
            <router-link :to="REPORT_CONFIG_WEB_ROUTES.REPORTS" class="">Reports</router-link>
        </li> -->
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='config'}">
            <router-link :to="REPORT_CONFIG_WEB_ROUTES.CONFIG" class="">Configuration</router-link>
        </li>
    </ul>
</template>

<script>
import {REPORT_CONFIG_WEB_ROUTES} from "../../../../../../router/web_routes";
    export default {
        props: ['scrollable','width','title','active_num','supplier','customer','product','taxation'],
        data(){
            return {
                REPORT_CONFIG_WEB_ROUTES:REPORT_CONFIG_WEB_ROUTES,
            }
        },
    }
</script>