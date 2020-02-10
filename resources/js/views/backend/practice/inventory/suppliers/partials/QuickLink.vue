<template>
    <div class="width-100-pc float-right text-right fs-12">
        <router-link :to="INVENTORY_WEB_ROUTES.SCM_WORKSPACE" :class="{'pointer-cursor quick-link':true,'active':active_link==='workspace'}">Workspace</router-link> | 
        <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDORS" :class="{'pointer-cursor quick-link':true,'active':active_link==='suppliers'}">Suppliers</router-link> | 
        <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS" :class="{'pointer-cursor quick-link':true,'active':active_link==='po'}">Purchase Orders</router-link> | 
        <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.BILLS" :class="{'pointer-cursor quick-link':true,'active':active_link==='bills'}">Bills</router-link> | 
        <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS" :class="{'pointer-cursor quick-link':true,'active':active_link==='payments'}">Payments</router-link> | 
        <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.EXPENSES" :class="{'pointer-cursor quick-link':true,'active':active_link==='expenses'}">Expenses</router-link> | 
        <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.VENDOR_CREDIT" :class="{'pointer-cursor quick-link':true,'active':active_link==='credits'}">Supplier Returns</router-link> | 
        <router-link :to="INVENTORY_WEB_ROUTES.PURCHASES.REPORTS" :class="{'pointer-cursor quick-link':true,'active':active_link==='reports'}">Reports</router-link>
    </div>
</template>
<script>
import { INVENTORY_WEB_ROUTES } from '../../../../../../router/web_routes';
export default {
    name: "QuickLink",
    props: ['active_link'],
    data(){
        return {
            INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
        }
    }
}
</script>