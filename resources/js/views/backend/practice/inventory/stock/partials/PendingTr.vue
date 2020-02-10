<template>
    <tbody v-if="transactions.length > 0">
        <tr v-for="(transaction,index) in transactions" :key="'transactions'+index" class="pointer-cursor">
            <td>
                <label class="check-container small element-inlined mg-top-0 mg-bottom-15">
                    <input v-model="selected_items" :value="transaction.id" type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td>{{transaction.sku_code}}</td>
            <td>
                {{transaction.item_name.substring(0,10)+"..."}}
                <small> <i class="fa fa-question-circle cl-grey pointer-cursor fs-16" :title="transaction.item_name"></i></small>
            </td>
            <td>{{transaction.unit_weight}}{{transaction.measure_unit_sympol}}</td>
            <td>{{format_money(transaction.purchase)}}</td>
            <!-- <td>{{format_money(transaction.sold)}}</td> -->
            <!-- <td>{{format_money(transaction.returns)}}</td> -->
            <td>{{format_money(transaction.pack_cost)}}</td>
            <td>{{format_money(transaction.pack_retail)}}</td>
            <td>{{format_money(transaction.unit_cost)}}</td>
            <td>{{format_money(transaction.unit_retail)}}</td>
            <td class="fs-12 fw-600 cl-amref">{{format_money(transaction.stock)}}</td>
            <td>{{format_money(transaction.purchase*transaction.unit_retail*transaction.pack_qty)}}</td>
            <td>{{format_money(transaction.unit_retail-transaction.unit_cost)}}</td>
        </tr>
    </tbody>
</template>

<script>
    import {formatMoney} from "../../../../../../helpers/functionmixin";
    export default {
        props:['transactions','check_all','checked_items'],
        data(){
            return {
                selected_items: [],
                checked_items_holder: []
            }
        },
        watch: {
            checked_items: function(new_checked_items,old_checked_items){
                this.checked_items_holder = new_checked_items;
                if(this.checked_items_holder.length){
                    for (let i = 0; i < this.checked_items_holder.length; i++) {
                        const elemen = this.checked_items_holder[i];
                        this.selected_items.push(elemen.id);
                    }
                }else{
                    this.selected_items = [];
                }
            }
        },
        methods: {
            format_money(money_to){
                return formatMoney(money_to);
            },
        }
    }
</script>