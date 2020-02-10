<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom">

        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Product & Services</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORIES.ITEMS" class="">List of Items</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORIES.CATEGORIES" class="">Item Categories</router-link>
                </li>
            </ul>
        </li>

        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Transactions</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS" class="">Warehouse & Transfer</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" class="">Pick, Pack & Ship</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" class="">Batch Management</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" class="">Barcode Tracking</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECUR_BILLS" class="">Stock Adjustment</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='returns'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_RETURN" class="">Adjust Prices</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS" class="">Stock Takes</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS" class="">Opening Balance Adjustment</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Inventory Alerts</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom inventory-top">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORIES.ITEMS" class="">SMS</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORIES.CATEGORIES" class="">Emails</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Reports</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-for="(item,key) in reports" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}" :key="'sub-submenu-custom'+key">
                    <router-link :to="REPORTS+'?type='+item.name" :title="item.description" class="">{{item.name}}</router-link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from '../../../../../../router/web_routes';
    import {TRANSACTION_TYPES} from '../../../../../../helpers/process_status';
    export default {
        props: ['scrollable','width','active_num','supplier','reports','customer','product','taxation'],
        data(){
            return {
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
                REPORTS: INVENTORY_WEB_ROUTES.PURCHASES.REPORTS,
                REPORT: TRANSACTION_TYPES.SUPPLIER_REPORTS,
                INVENTORIES: INVENTORY_WEB_ROUTES.INVENTORIES,
            }
        }
    }
</script>