<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu width-100-pc">
        <li class="list-group-item menu-title-li pl-4">
            <a href="" class="menu-title">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='coa'}" @click="link_to(ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA" class="">Chart of account</router-link>
        </li>
        <!-- <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.ACCOUNTS.OPEN_ACCOUNT_HEAD)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.OPEN_ACCOUNT_HEAD" class="">Opening Account Heads</router-link>
        </li>
        <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.ACCOUNTS.CREDIT_VOUCHERS)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.CREDIT_VOUCHERS" class="">Credit Vouchers</router-link>
        </li>
        <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.ACCOUNTS.DEBIT_VOUCHERS)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.DEBIT_VOUCHERS" class="">Debit Vouchers</router-link>
        </li>
        <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.ACCOUNTS.JOURNAL_VOUCHERS)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.JOURNAL_VOUCHERS" class="">Journal Vouchers</router-link>
        </li>
        <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.ACCOUNTS.ACCOUNT_HOLDERS)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.ACCOUNT_HOLDERS" class="">Account Holders</router-link>
        </li> -->
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