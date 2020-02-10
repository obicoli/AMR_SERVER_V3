<template>
    <div class="pull pull-right app-header width-100-pc text-right mg-right-50">
        <router-link :to="ACCOUNTING_WEB_ROUTES.DASHBOARD" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='home'}">Dashboard</router-link>&nbsp;&nbsp;
        <router-link :to="ACCOUNTING_WEB_ROUTES.BANKS.BANK" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='banks'}">Banks</router-link>&nbsp;&nbsp;
        <router-link :to="ACCOUNTING_WEB_ROUTES.ACCOUNTS.INTRO" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='coa'}">Accounts</router-link>&nbsp;&nbsp;
        <router-link :to="ACCOUNTING_WEB_ROUTES.STATEMENTS.GENERAL_LEDGER" v-bind:class="{'btn-link cl-787887':true,'active':active_link==='statements'}">Statements</router-link>&nbsp;&nbsp;
    </div>
</template>

<script>
    import {ACCOUNTING_WEB_ROUTES} from '../../../../../../router/web_routes';
    import Auth from '../../../../../../store/auth';
    export default {
        props: ['active_link'],
        data(){
            return {
                ACCOUNTING_WEB_ROUTES: ACCOUNTING_WEB_ROUTES
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