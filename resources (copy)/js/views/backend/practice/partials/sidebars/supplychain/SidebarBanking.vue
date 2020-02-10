<template>

    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">List</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="BANKS_WEB_ROUTES.BANKS" class="">Institutions</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="BANKS_WEB_ROUTES.BRANCHES" class="">Branches</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="BANKS_WEB_ROUTES.ACCOUNTS" class="">Banks & Credit Cards</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Transactions</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="BANK_TRANSACTIONS+'?type=Banking | Bank Transactions'" class="">Bank Transactions</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <router-link :to="RECONSILIATION" class="">Bank Reconciliation</router-link>
                </li>
                <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}">
                    <a href="#" class="">Account Balance Adjustment</a>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Reports</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li v-for="(item,key) in BANKING_REPORTS" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='customers'}" :key="'key_item'+key">
                    <router-link :to="REPORTS_URL+'?type='+item" class="">{{item}}</router-link>
                </li>
            </ul>
        </li>

    </ul>

    <!-- <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='banks'}">
            <router-link :to="BANKS_WEB_ROUTES.BANKS" class="">Institutions</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='branch'}">
            <router-link :to="BANKS_WEB_ROUTES.BRANCHES" class="">Institution Branches</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bank_account'}">
            <router-link :to="BANKS_WEB_ROUTES.ACCOUNTS" class="">Banks & Credit Cards</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='bank_transactions'}">
            <router-link :to="BANKS_WEB_ROUTES.TRANSACTIONS" class="">Transactions</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='cheques'}">
            <router-link :to="BANKS_WEB_ROUTES.RECONSILIATION" class="">Bank Reconciliation</router-link>
        </li>
    </ul> -->

</template>

<script>
import {BANKS_WEB_ROUTES} from "../../../../../../router/web_routes";
import {BANKING} from "../../../../../../helpers/process_status";
    export default {
        props: ['scrollable','width','title','active_num','supplier','customer','product','taxation'],
        data(){
            return {
                BANKS_WEB_ROUTES:BANKS_WEB_ROUTES,
                BANK_TRANSACTIONS: BANKS_WEB_ROUTES.TRANSACTIONS,
                RECONSILIATION: BANKS_WEB_ROUTES.RECONSILIATION,
                BANKING_REPORTS: BANKING.REPORTS,
                REPORTS_URL: BANKS_WEB_ROUTES.REPORTS
            }
        },
    }
</script>