<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">List</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.CUSTOMERS" class="">List of Customers</router-link>
                </li>
            </ul>
        </li>

        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Transactions</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.QUOTE" class="">Estimates</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.INVOICES_RETAINER" class="">Retainer Invoices</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS" class="">Sales Orders</router-link>
                </li>

                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.INVOICES" class="">Invoices</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.RECUR_INVOICES" class="">Recurring Invoices</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.SALES_RECEIPTS" class="">Sales Receipts</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.CREDIT_NOTES" class="">Credit Notes</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.PAYMENTS" class="">Payments</router-link>
                </li>
                
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_OPENING_BALANCE" class="">Customer Write-Offs</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_OPENING_BALANCE" class="">Customer Adjustments</router-link>
                </li>

            </ul>
        </li>

        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Reports</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-for="(item,key) in CUSTOMER_REPORTS" v-bind:class="{'list-group-item items-lists pl-4':true}" :key="'CUSTOMER_REPORTS'+key">
                    <router-link :to="REPORTS+'?type='+item" class="">{{item}}</router-link>
                </li>
            </ul>
        </li>

        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Special</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="INVENTORY_WEB_ROUTES.SALES.CUSTOMERS" class="">Opening Balance Adjustment</router-link>
                </li>
            </ul>
        </li>

        <!-- <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='dashboard'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.CUSTOMERS_DASHBOARD" class="">Dashboard</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.CUSTOMERS" class="">Customers</router-link>
        </li> -->

        <!-- <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Estimates</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Retainer Invoices</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Sales Orders</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Invoices</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Recurring Invoices</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Payments Received</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Credit Notes</a>
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
                REPORTS: INVENTORY_WEB_ROUTES.SALES.REPORTS,
                CUSTOMER_REPORTS: TRANSACTION_TYPES.CUSTOMER_REPORTS,
            }
        }
    }
</script>