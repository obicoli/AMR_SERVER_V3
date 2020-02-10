<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom">

        <!-- <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Suppliers</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDORS" class="">List of Suppliers</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_OPENING_BALANCE" class="">Opening Balances</router-link>
        </li> -->

        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Supplier</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDORS" class="">List of Suppliers</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_OPENING_BALANCE" class="">Opening Balance Adjustment</router-link>
                </li>
            </ul>
        </li>

        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Transactions</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS" class="">Purchase Order</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" class="">Bills</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECUR_BILLS" class="">Recurring Bills</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='returns'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_RETURN" class="">Purchase Returns</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS" class="">Payments</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.EXPENSES" class="">Expenses</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECUR_EXPENSES" class="">Recurring Expenses</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_CREDIT" class="">Supplier Credits</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Reports</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-for="(key,item) in REPORT" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}" :key="'sub-submenu-custom'+item">
                    <router-link :to="REPORTS+'?type='+key" class="">{{key}}</router-link>
                </li>
            </ul>
        </li>

        <!-- <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS" class="">Purchase Order</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" class="">Bills</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECUR_BILLS" class="">Recurring Bills</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='returns'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_RETURN" class="">Purchase Returns</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS" class="">Payments</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.EXPENSES" class="">Expenses</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECUR_EXPENSES" class="">Recurring Expenses</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_CREDIT" class="">Supplier Credits</router-link>
        </li> -->
    </ul>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from '../../../../../../router/web_routes';
    import {TRANSACTION_TYPES} from '../../../../../../helpers/process_status';
    export default {
        props: ['scrollable','width','active_num','supplier','customer','product','taxation'],
        data(){
            return {
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
                REPORTS: INVENTORY_WEB_ROUTES.PURCHASES.REPORTS,
                REPORT: TRANSACTION_TYPES.SUPPLIER_REPORTS,
            }
        }
    }
</script>