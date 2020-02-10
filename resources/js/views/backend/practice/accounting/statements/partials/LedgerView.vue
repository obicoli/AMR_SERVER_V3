<template>

    <div class="">
        <table v-for="(ledger,index) in ledgers" class="ledger-report-table table" :key="'ledgers_'+index">
            <thead>
                <tr>
                    <th colspan="8">{{ledger.nature_type}}</th>
                </tr>
            </thead>
            <tbody class="pd-l-10-pd-r-10" v-for="(account,index_a) in ledger.accounts" :key="'account_'+index_a">
                <tr class="account-head pointer-cursor" data-toggle="collapse" :data-target="'#collapse_gon_'+index+'_sub_'+index_a">
                    <td colspan="8">{{account.name}}</td>
                </tr>
                <tr>
                    <td colspan="8" class="zeroPadding bg-white">
                        <div class="collapse out width-100-pc padding-top-20 padding-left-10 padding-right-10" :id="'collapse_gon_'+index+'_sub_'+index_a">
                            <table class="table statement-reports">
                                <tr>
                                    <th style="width:10%;">Date</th>
                                    <th style="width:10%;" class="dotted-left">Transaction</th>
                                    <th style="width:5%;" class="dotted-left">No</th>
                                    <th style="width:15%;" class="dotted-left">Narration</th>
                                    <th style="width:25%;" class="dotted-left">Split</th>
                                    <th style="width:10%;" class="dotted-left text-right">Debit</th>
                                    <th style="width:10%;" class="dotted-left text-right">Credit</th>
                                    <th style="width:15%;" class="dotted-left text-right">Balance</th>
                                </tr>

                                <tbody v-if="ledger.nature_type === ACCOUNTING.ACCOUNT_NATURES.LIABILITY || ledger.nature_type === ACCOUNTING.ACCOUNT_NATURES.EQUITY || ledger.nature_type === ACCOUNTING.ACCOUNT_NATURES.REVENUE">
                                    <tr>
                                        <td colspan="8" class="zeroPadding bd-right-0 bd-left-0 ">
                                            <table class="transaction-table" v-for="(transact,index_t) in account.transactions" :key="'transact'+index_t">
                                                <tr v-if="transact.debit.balance_type===ACCOUNTING.DEBIT" class="body debited-transaction">
                                                    <td class="bd-top-0 bd-left-0 bd-bottom-0" style="width:10%;"></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:10%;"></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:5%;"></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:15%;"></td>
                                                    <td class="bd-top-0 bd-left-0"><a>{{transact.debit.name}}</a></td>
                                                    <td class="text-right bd-top-0 bd-left-0"><a>{{form_money(transact.debit.amount)}}</a></td>
                                                    <td class="text-right bd-top-0 bd-left-0"><a></a></td>
                                                    <td class="text-right bd-top-0 bd-left-0"><a>{{ACCOUNTING.CURRENCY}}{{form_money(transact.debit.amount)}}</a></td>
                                                </tr>
                                                <tr v-if="transact.credit.balance_type===ACCOUNTING.CREDIT" class="body credited-transaction">
                                                    <td class="bd-top-0 bd-left-0 fw-600"><a>{{transact.credit.trans_date}}</a></td>
                                                    <td class="bd-top-0 bd-left-0"><a>{{transact.credit.trans_type}}</a></td>
                                                    <td class="bd-top-0 bd-left-0"></td>
                                                    <td class="bd-top-0 bd-left-0"><a>{{transact.credit.trans_description}}</a></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:25%;"><a>{{transact.credit.name}}</a></td>
                                                    <td style="width:10%;" class="text-right bd-top-0 bd-bottom-0"></td>
                                                    <td style="width:10%;" class="text-right bd-top-0 bd-bottom-0"><a>{{form_money(transact.credit.amount)}}</a></td>
                                                    <td style="width:15%;" class="text-right bd-top-0 bd-right-0 bd-bottom-0 fw-600"><a>{{ACCOUNTING.CURRENCY}}{{form_money(cal_ledger_totals(ledger.nature_type,account.transactions,index_t))}}</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody v-if="ledger.nature_type === ACCOUNTING.ACCOUNT_NATURES.ASSETS || ledger.nature_type === ACCOUNTING.ACCOUNT_NATURES.EXPENSE">
                                    <tr>
                                        <td colspan="8" class="zeroPadding bd-right-0 bd-left-0 ">
                                            <table class="transaction-table" v-for="(transact,index_t) in account.transactions" :key="'transact'+index_t">
                                                <tr v-if="transact.credit.balance_type===ACCOUNTING.CREDIT" class="body credited-transaction">
                                                    <td class="bd-top-0 bd-left-0 bd-bottom-0" style="width:10%;"></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:10%;"></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:5%;"></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:15%;"></td>
                                                    <td class="bd-top-0 bd-bottom-0" style="width:25%;"><a>{{transact.credit.name}}</a></td>
                                                    <td style="width:10%;" class="text-right bd-top-0 bd-bottom-0"></td>
                                                    <td style="width:10%;" class="text-right bd-top-0 bd-bottom-0"><a>{{form_money(transact.credit.amount)}}</a></td>
                                                    <td style="width:15%;" class="text-right bd-top-0 bd-right-0 bd-bottom-0"><a>{{ACCOUNTING.CURRENCY}}{{form_money(transact.credit.amount)}}</a></td>
                                                </tr>
                                                <tr v-if="transact.debit.balance_type===ACCOUNTING.DEBIT" class="body debited-transaction">
                                                    <td class="bd-top-0 bd-left-0 fw-600"><a>{{transact.debit.trans_date}}</a></td>
                                                    <td class="bd-top-0 bd-left-0"><a>{{transact.debit.trans_type}}</a></td>
                                                    <td class="bd-top-0 bd-left-0"></td>
                                                    <td class="bd-top-0 bd-left-0"><a>{{transact.debit.trans_description}}</a></td>
                                                    <td class="bd-top-0 bd-left-0"><a>{{transact.debit.name}}</a></td>
                                                    <td class="text-right bd-top-0 bd-left-0"><a>{{form_money(transact.debit.amount)}}</a></td>
                                                    <td class="text-right bd-top-0 bd-left-0"><a></a></td>
                                                    <td class="text-right bd-top-0 bd-left-0 fw-600"><a>{{ACCOUNTING.CURRENCY}}{{form_money(cal_ledger_totals(ledger.nature_type,account.transactions,index_t))}}</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody>
                                    <tr class="total">
                                        <td colspan="6" class="fw-600 fs-12 txt-uppercase">Total for {{account.name}} with sub-accounts</td>
                                        <td colspan="2" class="total text-right">{{ACCOUNTING.CURRENCY}}{{form_money(cal_ledger_totals(ledger.nature_type,account.transactions,-1))}}</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

</template>
<script>
    import {formatMoney,get_ledger_totals} from "../../../../../../helpers/functionmixin";
    export default {
        props: ['ledgers','ACCOUNTING'],
        methods: {
            form_money(money_to){
                return formatMoney(money_to);
            },
            cal_ledger_totals(nature_type,ledgers,last_index=0){
                return get_ledger_totals(nature_type,ledgers,last_index)
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
