<template>
    <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">
        
        <div class="dgrid-header dgrid-header-row ui-widget-header sticky-header" role="row">
            <table class="account-report-table table-hover" role="presentation" id="dgrid_120-header">
                <tr>
                    <th style="width:25%" class="text-left">Account</th>
                    <th style="width:15%;" class="left-dotted">Type</th>
                    <th style="width:20%;" class="left-dotted">Detail Type</th>
                    <th style="width:25%;" class="left-dotted">Description</th>
                    <th style="width:15%;" class="left-dotted">Balance</th>
                </tr>
                <tr v-for="(account,index) in chart_of_accounts" :key="'chart_of_accounts'+index" class="body">
                    <td>{{account.custom_name}}</td>
                    <td>{{account.type}}</td>
                    <td>{{account.name}}</td>
                    <td>{{account.description}}</td>
                    <td>{{format_money(account.balance)}}</td>
                </tr>
                <tr v-if="chart_of_accounts.length===0">
                    <td colspan="5" class="text-center cl-amref fs-14">No Account to display!</td>
                </tr>
            </table>
        </div>

    </div>
</template>

<script>
import { formatMoney } from '../../../../../helpers/functionmixin'
    export default {
        props: ['chart_of_accounts'],
        methods: {
            format_money(money_to){
                return formatMoney(money_to);
            }
        },
    }
</script>

<style scoped>

    tbody.collapse.in {
        display: table-row-group;
    }
    
    .report-filters-inputs{
        outline: none;
        height: 32px;
        border: 1px solid #BABEC5;
        padding: 0 8px;
        border-radius: 2px;
        transition-property: border;
        transition-duration: 0.35s;
        font-size: 13px;
        background-color: #FFFFFF;
        box-sizing: border-box;
        -webkit-appearance: none;
        width: 100%;
        vertical-align: middle;
    }

    .professionalreports {
        border-width: 0 0 1px;
        border-style: dotted;
        display: inline-block;
    }

    .professionalreports {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .accordion {
        /* background-color: #eee; */
        background-color: transparent!important;
        color: #444;
        cursor: pointer;
        /* padding: 18px; */
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 14px;
        font-weight: 600!important;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        margin-bottom: 0!important;
        -webkit-box-shadow: 0 0 0 rgba(0,0,0,0);
        box-shadow: 0 0 0 rgba(0,0,0,0);
    }

    td {
        padding: 3px 10px!important;
        color: #444;
    }

</style>
