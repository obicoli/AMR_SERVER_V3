<template>
    <div class="pull pull-right app-header width-100-pc text-right mg-right-50">
        <!-- <router-link to="/svs/dashboard" class="btn-link cl-787887">Svs Dashboard</router-link>&nbsp;&nbsp;&nbsp; -->
        <router-link :to="INVENTORY_WEB_ROUTES.INV_INVENTORY" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='home'}">Home</router-link>&nbsp;&nbsp;
        <router-link :to="INVENTORY_WEB_ROUTES.INV_SETTINGS" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='settings'}">Initialization</router-link>&nbsp;&nbsp;
        <router-link :to="INVENTORY_WEB_ROUTES.INV_ITEMS" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='products'}">Inventory Items</router-link>&nbsp;&nbsp;
        <router-link :to="INVENTORY_WEB_ROUTES.INV_PO" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='purchases'}">Purchases</router-link>&nbsp;&nbsp;
        <router-link :to="INVENTORY_WEB_ROUTES.INV_STOCK" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='stocks'}">Stock</router-link>&nbsp;&nbsp;
        <!-- <router-link to="/supply" class="btn-link cl-787887">Supply</router-link>&nbsp;&nbsp; -->
        <!-- <router-link to="/inventory/sales" class=" btn-link cl-787887">Sales</router-link>&nbsp;&nbsp; -->
        <router-link :to="INVENTORY_WEB_ROUTES.INV_REQUISTION" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='requistions'}">Requistions</router-link>&nbsp;&nbsp;
        <router-link v-if="check_permissions('view.inv.supply')" :to="INVENTORY_WEB_ROUTES.INV_SUPPLY" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='supply'}">Supply</router-link>&nbsp;&nbsp;
        <!-- <router-link :to="INVENTORY_WEB_ROUTES.INV_SUPPLIERS" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='suppliers'}">Vendors</router-link>&nbsp;&nbsp; -->
        <router-link :to="INVENTORY_WEB_ROUTES.INV_NOTIFICATIONS" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='notifications'}">Notifications</router-link>&nbsp;&nbsp;
        <router-link :to="INVENTORY_WEB_ROUTES.INV_REPORTS" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='reports'}">Reports</router-link>&nbsp;&nbsp;
        <!-- <router-link to="/inventory/stock" class="btn-link cl-787887">Stock</router-link> -->
    </div>
</template>

<script>
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    import Auth from '../../../../../store/auth';
    export default {
        props: ['active_link'],
        data(){
            return {
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES
            }
        },
        methods: {
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .app-header a.active{
        color: #d34336!important;
        text-decoration: underline!important;
    }
</style>


