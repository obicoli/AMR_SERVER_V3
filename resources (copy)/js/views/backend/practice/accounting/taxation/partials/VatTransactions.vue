<template>
    <div class="width-100-pc float-left bg-white padding-10">
        <table class="table banking-transaction-vat-reports">        
            <thead>
                <tr>
                    <th style="width:10%;" class="somepad-1 fw-600">Date</th>
                    <th style="width:17%" class="somepad-1 fw-600">Bank/Customer/Supplier</th>
                    <th style="width:10%" class="somepad-1 fw-600">Reference</th>
                    <th style="width:15%" class="somepad-1 fw-600">Description</th>
                    <th style="width:10%;" class="somepad-1 fw-600">VAT Period</th>
                    <th style="width:13%;" class="text-right somepad fw-600">Exclusive({{currency}})</th>
                    <th style="width:13%;" class="text-right somepad-1 fw-600">Inclusive({{currency}})</th>
                    <th style="width:12%;" class="text-right somepad-1 fw-600">VAT({{currency}})</th>
                </tr>
            </thead>
            <!-- Output Tax Block -->
            <tbody v-if="tax_return.total_output_transactions">
                <tr>
                    <td class="somepad cl-amref txt-uppercase" colspan="8">Sales and Output Tax on Sales for the Period</td>
                </tr>
                <tr>
                    <td class="somepad">bb</td>
                    <td class="somepad">b</td>
                    <td class="somepad">b</td>
                    <td class="somepad">g</td>
                    <td class="somepad">f</td>
                    <td class="somepad text-right">b</td>
                    <td class="somepad text-right">tt</td>
                    <td class="somepad text-right fw-600">tt</td>
                </tr>
            </tbody>
            <tbody v-if="tax_return.total_output_transactions">
                <tr>
                    <td class="somepad cl-amref txt-uppercase" colspan="8">Puchase and Input Tax on Purchase for the period</td>
                </tr>
                <tr>
                    <td class="somepad">bb</td>
                    <td class="somepad">b</td>
                    <td class="somepad">b</td>
                    <td class="somepad">g</td>
                    <td class="somepad">f</td>
                    <td class="somepad text-right">b</td>
                    <td class="somepad text-right">tt</td>
                    <td class="somepad text-right fw-600">tt</td>
                </tr>
            </tbody>

            <!-- Inputs Tax Block | Detailed -->
            <tbody v-if="tax_return.total_input_transactions">
                <tr>
                    <td class="somepad cl-amref fw-600 fs-16" colspan="8">Input Tax</td>
                </tr>
            </tbody>
            <tbody v-for="(transaction,index) in tax_return.transactions" :key="'transactions_'+index">
                <tr v-if="transaction.input_tax.length && index>0">
                    <td class="somepad cl-444 fw-600 tr-separator" colspan="8"></td>
                </tr>
                <tr v-if="transaction.input_tax.length">
                    <td class="somepad cl-444 fw-600 sub-header-dark bd-right bd-left" colspan="8">{{transaction.display_as}} - Input Tax</td>
                </tr>
                <!-- <tr v-for="(input_transaction,index_trs) in transaction.input_tax" :key="'index_trs_'+index_trs">
                    <td v-bind:class="{'somepad bd-left':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_date}}</td>
                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.creditor_debtor_account.legal_name}}</td>
                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_number}}</td>
                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.description}}</td>
                    <td v-bind:class="{'somepad bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.vat_period}}</td>
                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.exclusive)}}</td>
                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.inclusive)}}</td>
                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.vat_amount)}}</td>
                </tr> -->
                <tr v-if="!check_array_element(report_options.includes,'No VAT Transactions')">
                    <td colspan="8">
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width:10%;" class="somepad bd-left no-bottom-bd sub-header cl-636872 fw-600">Date</td>
                                    <td style="width:17%" class="somepad no-bottom-bd sub-header cl-636872 fw-600">Bank/Customer/Supplier</td>
                                    <td style="width:10%" class="somepad no-bottom-bd sub-header cl-636872 fw-600">Reference</td>
                                    <td style="width:15%" class="somepad no-bottom-bd sub-header cl-636872 fw-600">Description</td>
                                    <td style="width:10%;" class="somepad no-bottom-bd sub-header cl-636872 fw-600">VAT Period</td>
                                    <td style="width:13%;" class="text-right somepad no-bottom-bd sub-header cl-636872 fw-600">Exclusive(KES)</td>
                                    <td style="width:13%;" class="text-right somepad no-bottom-bd sub-header cl-636872 fw-600">Inclusive(KES)</td>
                                    <td style="width:12%;" class="text-right somepad bd-right no-bottom-bd sub-header cl-636872 fw-600">VAT(KES)</td>
                                </tr>
                                <tr v-for="(input_transaction,index_trs) in transaction.input_tax" :key="'index_trs_'+index_trs">
                                    <td style="width:10%;" class="somepad bd-left no-bottom-bd">{{input_transaction.trans_date}}</td>
                                    <td style="width:17%" class="somepad no-bottom-bd">{{input_transaction.creditor_debtor_account.legal_name}}</td>
                                    <td style="width:10%" class="somepad no-bottom-bd">{{input_transaction.trans_number}}</td>
                                    <td style="width:15%" class="somepad no-bottom-bd">{{input_transaction.description}}</td>
                                    <td style="width:10%;" class="somepad no-bottom-bd bd-right">{{input_transaction.vat_period}}</td>
                                    <td style="width:13%;" class="text-right somepad no-bottom-bd bd-right">{{format_money(input_transaction.exclusive)}}</td>
                                    <td style="width:13%;" class="text-right somepad no-bottom-bd bd-right">{{format_money(input_transaction.inclusive)}}</td>
                                    <td style="width:12%;" class="text-right somepad bd-right no-bottom-bd">{{format_money(input_transaction.vat_amount)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr class="notes" v-if="transaction.input_tax.length">
                    <td class="somepad cl-636872 fw-600 bd-left" colspan="5">
                        Puchase and Input Tax on Purchase for the period {{tax_return.vat_period+' ( '+transaction.display_as+' )'}}
                    </td>
                    <td class="somepad cl-444 fw-600 text-right bd-right" colspan="3"></td>
                </tr>
                <tr v-if="transaction.input_tax.length">
                    <td class="somepad cl-444 no-bottom-bd bd-right bd-left" colspan="5">Total purchases from Suppliers registered for VAT(Local):</td>
                    <td class="somepad cl-444 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_supplier_excl_total)}}</td>
                    <td class="somepad cl-444 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_supplier_incl_total)}}</td>
                    <td class="somepad cl-444 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_supplier_vat_total)}}</td>
                </tr>
                <tr v-if="transaction.input_tax.length">
                    <td class="somepad cl-444 no-bottom-bd bd-left" colspan="5">Total purchases from Suppliers not registered for VAT(Import):</td>
                    <td class="somepad cl-444 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_supplier_excl_total)}}</td>
                    <td class="somepad cl-444 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_supplier_incl_total)}}</td>
                    <td class="somepad cl-444 text-right bd-right no-bottom-bd">{{format_money(transaction.int_supplier_vat_total)}}</td>
                </tr>
                <tr v-if="transaction.input_tax.length">
                    <td class="somepad cl-636872 fw-600 bd-left" colspan="5">Total for {{transaction.name+' '+transaction.category}}:</td>
                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{currency+' '+format_money(transaction.excl_total)}}</td>
                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{currency+' '+format_money(transaction.incl_total)}}</td>
                    <td class="somepad cl-444 fw-600 text-right bd-right">{{currency+' '+format_money(transaction.vat_total)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { formatMoney } from '../../../../../../helpers/functionmixin';
export default {
    props: ['tax_return','currency','report_options'],
    methods: {
        format_money(money_to){
            return formatMoney(money_to);
        },
        check_array_element(array_to,element_to){
            if(array_to.includes(element_to)){
                return true;
            }
            return false;
        }
    },
    watch: {
        tax_return: function(new_data,old_data){
            this.tax_return = new_data;
        },
        report_options: function(new_data,old_data){
            this.report_options = new_data;
        }
    }
}
</script>