<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu width-100-pc">
        <li class="list-group-item menu-title-li pl-4">
            <a href="" class="menu-title">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='dashboard'}">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_REQUISTION_DASHBOARD"  class="">Dashboard</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='pr'}">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_REQUISTIONS" class="">Request</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='po'}">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_PO" class="menu-title">Approvals</router-link>
        </li>
    </ul>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        props: ['active_num','title'],
        data(){
            return {
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES
            }
        }
    }
</script>