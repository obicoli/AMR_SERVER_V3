<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom">
        <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title txt-uppercase">Accountant's Area</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='coa'}">
            <a href="#" class="">Accounts</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom">
                <li class="list-group-item pl-4">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA+'?type=Chart of Accounts'" class="">Chart of Accounts</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA+'?type=Sales and Purchase Accounts'" class="">Sales and Purchase Accounts</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.COA" class="">Opening Balance Adjustment</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Statements</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom statement-top">
                <li class="list-group-item pl-4">
                    <router-link :to="STATEMENTS.GENERAL_JOURNAL" class="">General Journal</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="STATEMENTS.GENERAL_LEDGER" class="">General Ledger</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="STATEMENTS.GENERAL_LEDGER" class="">Cash Flow</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Management</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom statement-top">
                <li class="list-group-item pl-4">
                    <router-link :to="STATEMENTS.TRAIL_BALANCE" class="">Trail Balance</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="STATEMENTS.PL" class="">Profit & Loss</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="STATEMENTS.BALANCE_SHEET" class="">Balance Sheet</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">VAT</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom vat-top">
                <li class="list-group-item pl-4">
                    <router-link :to="TAXATION.FILING" class="">VAT Returns & Reports</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="TAXATION.ADJUSTMENTS">VAT Adjustments</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="TAXATION.PAY_AND_REFUND">VAT Payments & Refunds</router-link>
                </li>
            </ul>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Reports</a>
            <ul class="list-group flex-column d-inline-block sub-submenu sub-submenu-custom vat-top">

                <li v-for="(item,key) in REPORTS" class="list-group-item pl-4" :key="'REPORTS_'+key">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.REPORTS+'?type='+item" class="">{{item}}</router-link>
                </li>
                <!-- <li class="list-group-item pl-4">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.REPORTS.ACCOUNTS_TXN" class="">Account Transaction</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.REPORTS.AUDIT_TRAIL" class="">Audit Trail</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.REPORTS.SYS_AUDIT_TRAIL" class="">System Audit Trail</router-link>
                </li>
                <li class="list-group-item pl-4">
                    <router-link :to="ACCOUNTING_WEB_ROUTES.REPORTS.BALANCE_ADJUSTMENT" class="">Balance & VAT Adjustments</router-link>
                </li> -->
            </ul>
        </li>

        <!-- <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Statements</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='journal'}">
            <router-link :to="STATEMENTS.GENERAL_JOURNAL" class="">General Journal</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='ledger'}">
            <router-link :to="STATEMENTS.GENERAL_LEDGER" class="">General Ledger</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='trail'}">
            <router-link :to="STATEMENTS.TRAIL_BALANCE" class="">Trail Balance</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='balancesheet'}">
            <router-link :to="STATEMENTS.TRAIL_BALANCE" class="">Balance Sheet</router-link>
        </li> -->
        
    </ul>
</template>

<script>
import {ACCOUNTING_WEB_ROUTES} from "../../../../../../router/web_routes";
import {ACCOUNTING} from "../../../../../../helpers/process_status";
export default {
    name: "",
    props: ['active_num','title'],
    data(){
        return {
            ACCOUNTING_WEB_ROUTES: ACCOUNTING_WEB_ROUTES,
            STATEMENTS: ACCOUNTING_WEB_ROUTES.STATEMENTS,
            TAXATION: ACCOUNTING_WEB_ROUTES.TAXATION,
            REPORTS: ACCOUNTING.ACCOUNT_REPORTS,
        }
    },
    methods:{
        
    }
}
</script>





    