<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu width-100-pc">
        <li class="list-group-item menu-title-li pl-4">
            <a href="" class="menu-title">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='supply'}">
            <router-link v-if="check_permissions('view.inv.supply')" :to="INVENTORY_WEB_ROUTES.INV_SUPPLY"  class="">Supply List</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='good_out_notes'}">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_SUPPLY_GON" class="">Goods Out Notes</router-link>
        </li>
        <!-- <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='driver'}">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_SUPPLY_DRIVER" class="">Driver</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='vehicle'}">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_SUPPLY_VEHICLE" class="menu-title">Vehicle</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='orders'}">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_SUPPLY_ORDERS" class="menu-title">Order List</router-link>
        </li> -->
    </ul>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    import Auth from '../../../../../store/auth';
    export default {
        props: ['active_num','title'],
        data(){
            return {
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES
            }
        },
        methods: {
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },
        }
    }
</script>