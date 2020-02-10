<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu width-100-pc">
        <li class="list-group-item menu-title-li pl-4">
            <a href="" class="menu-title">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='journal'}" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_JOURNAL)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_JOURNAL" class="">General Journal</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='ledger'}" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_LEDGER)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_LEDGER" class="">Ledger Account</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='trail'}" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.TRAIL_BALANCE)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.TRAIL_BALANCE" class="">Trail Balance</router-link>
        </li>
        <!-- <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='income'}" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.INCOME)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.INCOME" class="">Income</router-link>
        </li> -->
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='pl'}" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.PL)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.PL" class="">Profit & Loss</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='balance_sheet'}" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.BALANCE_SHEET)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.BALANCE_SHEET" class="">Balance Sheet</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='reconsiliation'}" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.BANK_RECONCILIATION)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.BANK_RECONCILIATION" class="">Bank reconciliation</router-link>
        </li>
    </ul>
</template>

<script>
    import {ACCOUNTING_WEB_ROUTES} from "../../../../../../router/web_routes";
    export default {
        props: ['active_num','title'],
        data(){
            return {
                ACCOUNTING_WEB_ROUTES:ACCOUNTING_WEB_ROUTES,
            }
        },
        methods : {
            link_to(link_to){
                this.$router.push(link_to);
            }
        }
    }
</script>