<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu width-100-pc">
        <li class="list-group-item menu-title-li pl-4">
            <a href="" class="menu-title">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='estimates'}">
            <router-link :to="SALES.QUOTE" class="">Estimates</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='sales_orders'}">
            <router-link :to="SALES.SALES_ORDERS" class="">Sales Order</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='invoices'}">
            <router-link :to="SALES.INVOICES" class="">Invoices</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='sales_receipts'}">
            <router-link :to="SALES.SALES_RECEIPTS" class="">Sales Receipt</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='credit_notes'}">
            <router-link :to="SALES.CREDIT_NOTES" class="">Credit Note</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payments'}">
            <router-link :to="SALES.PAYMENTS" class="">Payments</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='transaction'}">
            <router-link :to="SALES.ALL_TRANSACTIONS" class="">Transactions</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
            <router-link :to="SALES.CUSTOMERS" class="">Customers</router-link>
        </li>
    </ul>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    export default {
        props: ['active_num','title'],
        data(){
            return {
                SALES: INVENTORY_WEB_ROUTES.SALES
            }
        }
    }
</script>