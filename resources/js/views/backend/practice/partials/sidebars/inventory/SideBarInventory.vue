<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <!-- <li class="list-group-item items-lists pl-4">
            <router-link :to="INVENTORY_WEB_ROUTES.DASHBOARD" class="">Dashboard</router-link>
        </li> -->
        <li v-if="product" class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Inventory</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Home</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_ITEMS" class="">Product&Service</router-link>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Stock</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Warehouse Transfer</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Stock Adjustments</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Stock Take</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Write off/Expiry</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Batch Tracking</a>
        </li>
        <li v-if="product" class="list-group-item items-lists pl-4">
            <a href="#" class="">Serial Tracking</a>
        </li>
        

        <!-- Taxation -->
        <li v-if="taxation" class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Taxation</a>
        </li>
        <li v-if="taxation" class="list-group-item items-lists pl-4">
            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_TAX" class="">Tax Rate</router-link>
        </li>
        <!-- Taxation Ends Here -->

        <!-- Sales -->
        <li v-if="customer" class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Sales</a>
        </li>
        <li v-if="customer" class="list-group-item items-lists pl-4">
            <a href="#" class="">Dashboard</a>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.CUSTOMERS" class="">Customers</router-link>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='estimates'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.QUOTE" class="menu-title">Estimates</router-link>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='retainer_invoice'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.RETAINER_INVOICES" class="menu-title">Retainer Invoice</router-link>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='salesorder'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS" class="menu-title">Sales Orders</router-link>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='invoices'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.INVOICES" class="menu-title">Invoices</router-link>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='payment_reveived'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.PAYMENTS" class="">Payment Received</router-link>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='recur_invoices'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.RECUR_INVOICES" class="menu-title">Recurring Invoices</router-link>
        </li>
        <li v-if="customer" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='credit_notes'}">
            <router-link :to="INVENTORY_WEB_ROUTES.SALES.CREDIT_NOTES" class="">Credit Note</router-link>
        </li>
        <!-- Customers ends here -->

        <li v-if="supplier" class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Purchase</a>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='vendors'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDORS" class="">Vendors</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='expenses'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.EXPENSES" class="">Expenses</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='recuring_expenses'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECUR_EXPENSES" class="">Recurring Expenses</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='purchases'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASES" class="">Purchases</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='purchase_orders'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS" class="">Purchase Orders</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='receivables'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECEIVABLE" class="">Purchase Receive</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bills'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" class="">Bills</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='paymentmade'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS" class="">Payments Made</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='recurring_bills'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.RECUR_BILLS" class="">Recurring Bills</router-link>
        </li>
        <li v-if="supplier" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='VENDOR_CREDIT'}">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_CREDIT" class="">Vendor Credits</router-link>
        </li>

        <!-- Requisition -->
        <!-- <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Requisitions</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASES" class="">Manage Requisitions</router-link>
        </li> -->

    </ul>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from '../../../../../../router/web_routes';
    export default {
        props: ['scrollable','width','active_num','supplier','customer','product','taxation'],
        data(){
            return {
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES
            }
        }
    }
</script>
