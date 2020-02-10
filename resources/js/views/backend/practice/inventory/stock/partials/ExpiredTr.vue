<template>
    <tbody v-if="transactions.length > 0">
        <tr v-for="(transaction,index) in transactions" v-if="transaction.status!=='Pending'" :key="'transactions'+index">
            <td>{{index}}</td>
            <td>{{transaction.sku_code}}</td>
            <td>
                {{transaction.item_name.substring(0,10)+"..."}}
                <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" :title="transaction.item_name"></i></small>
            </td>
            <td>{{transaction.unit_weight}}{{transaction.measure_unit_sympol}}</td>
            <td>{{format_money(transaction.purchase)}}</td>
            <td>{{format_money(transaction.sold)}}</td>
            <td>{{format_money(transaction.returns)}}</td>
            <td>{{format_money(transaction.pack_cost)}}</td>
            <td>{{format_money(transaction.pack_retail)}}</td>
            <td>{{format_money(transaction.unit_cost)}}</td>
            <td>{{format_money(transaction.unit_retail)}}</td>
            <td>{{format_money(transaction.stock)}}</td>
            <td>{{format_money(transaction.purchase*transaction.unit_retail*transaction.pack_qty)}}</td>
            <td>{{format_money(transaction.unit_retail-transaction.unit_cost)}}</td>
        </tr>
    </tbody>
</template>

<script>
    import {formatMoney} from "../../../../../../helpers/functionmixin";
    export default {
        props:['transactions'],
        methods: {
            format_money(money_to){
                return formatMoney(money_to);
            },
        }
    }
</script>