<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">
        <li class="list-group-item items-lists pl-4">
            <router-link :to="ACCOUNTING_WEB_ROUTES.DASHBOARD" class="">Dashboard</router-link>
        </li>

        <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Banks</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks" class="">Banks</router-link>
        </li>
        <!-- <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/written_cheque" class="">Cheques</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/deposit_list" class="">Bank Deposits</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/bank_book" class="">Bank Book</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/payment_collection" class="">Bank Collection</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/add_bank_expense" class="">Bank Expenses</router-link>
        </li> -->

        <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Accounts</a>
        </li>
        <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA)">
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
        <li class="list-group-item menu-title-li pl-4">
            <a href="" class="menu-title">Statements</a>
        </li>
        <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_JOURNAL)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_JOURNAL" class="">General Journal</router-link>
        </li>
        <li class="list-group-item items-lists pl-4" @click="link_to(ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_LEDGER)">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.LEDGER_ACCOUNTS" class="">Ledger Account</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.TRAIL_BALANCE" class="">Trail Balance</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.INCOME" class="">Income</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.BALANCE_SHEET" class="">Balance Sheet</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.PL" class="">Profit & Loss</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.BANK_RECONCILIATION" class="">Bank Reconciliation</router-link>
        </li>
    </ul>
</template>

<script>
    import {ACCOUNTING_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        props: ['scrollable','width'],
        data(){
            return {
                ACCOUNTING_WEB_ROUTES:ACCOUNTING_WEB_ROUTES
            }
        },
        methods : {
            link_to(link_to){
                this.$router.push(link_to);
            }
        }
    }
</script>
