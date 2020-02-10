<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
        <li class="list-group-item items-lists pl-4">
            <router-link :to="DASHBOARD" class="menu-title">Dashboard</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="INVENTORY" class="menu-title">Inventory Dashboard</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="SUPPLIER" class="menu-title">Supplier Dashboard</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="CUSTOMER" class="menu-title">Customer Dashboard</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="FINANCIAL" class="menu-title">Financial Dashboard</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="WORKSPACE" class="menu-title">Workspace</router-link>
        </li>
    </ul>
</template>

<script>
    import {INVENTORY_WEB_ROUTES,BANKS_WEB_ROUTES} from '../../../../../../router/web_routes';
    import {TRANSACTION_TYPES} from '../../../../../../helpers/process_status';
    export default {
        props: ['scrollable','width','active_num','supplier','reports','customer','product','taxation'],
        data(){
            return {
                DASHBOARD: INVENTORY_WEB_ROUTES.DASHBOARD_HOME,
                CUSTOMER: INVENTORY_WEB_ROUTES.SALES.CUSTOMERS_DASHBOARD,
                SUPPLIER: INVENTORY_WEB_ROUTES.PURCHASES.DASHBOARD,
                INVENTORY: INVENTORY_WEB_ROUTES.INVENTORIES.DASHBOARD,
                FINANCIAL: BANKS_WEB_ROUTES.DASHBOARD,
                WORKSPACE: INVENTORY_WEB_ROUTES.SCM_WORKSPACE,
            }
        }
    }
</script>