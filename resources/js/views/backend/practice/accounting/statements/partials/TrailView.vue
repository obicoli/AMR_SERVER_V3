<template>
    <div class="">
        <table class="ledger-report-table table table-hover">
            <thead>
                <tr>
                    <th style="width:50%">Account Title</th>
                    <th style="width:25%" class="text-right">Debit</th>
                    <th style="width:25%" class="text-right">Credit</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ledger,index) in ledgers" class="reporting-table no-border" :key="'ledgers'+index">
                    <td><a>{{ledger.name}}</a> </td>
                    <td class="text-right debited-td"><a v-if="ledger.nature_type.name===assets || ledger.nature_type.name===expense">{{form_money(cal_ledger_totals(ledger.nature_type.name,ledger.transactions,-1))}}</a></td>
                    <td class="text-right credited-td"><a v-if="ledger.nature_type.name===liability || ledger.nature_type.name===revenue || ledger.nature_type.name===equity">{{form_money(cal_ledger_totals(ledger.nature_type.name,ledger.transactions,-1))}}</a></td>
                </tr>
            </tbody>
            <tbody>
                <tr class="total">
                    <td class="total txt-uppercase">Total</td>
                    <td class="total text-right">{{ACCOUNTING.CURRENCY}}{{form_money(total_handler(ACCOUNTING.DEBIT,ledgers))}}</td>
                    <td class="total text-right">{{ACCOUNTING.CURRENCY}}{{form_money(total_handler(ACCOUNTING.DEBIT,ledgers))}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import {formatMoney,get_ledger_totals} from "../../../../../../helpers/functionmixin";
    export default {
        props: ['ledgers','ACCOUNTING'],
        data(){
            return {
                assets: this.ACCOUNTING.ACCOUNT_NATURES.ASSETS,
                expense: this.ACCOUNTING.ACCOUNT_NATURES.EXPENSE,
                liability: this.ACCOUNTING.ACCOUNT_NATURES.LIABILITY,
                revenue: this.ACCOUNTING.ACCOUNT_NATURES.REVENUE,
                equity: this.ACCOUNTING.ACCOUNT_NATURES.EQUITY,
            }
        },
        methods: {
            form_money(money_to){
                return formatMoney(money_to);
            },
            cal_ledger_totals(nature_type,ledgers,last_index=0){
                return get_ledger_totals(nature_type,ledgers,last_index)
            },
            total_handler(nature_type,ledgers){
                let tot_ = 0;
                for (let index = 0; index < ledgers.length; index++) {
                    const element = ledgers[index];
                    switch (nature_type) {
                        case this.ACCOUNTING.DEBIT:
                            if(element.nature_type.name===this.assets || element.nature_type.name===this.expense ){
                                tot_ += get_ledger_totals(element.nature_type.name,element.transactions,-1);
                            }
                            break;
                        default:
                            if( element.nature_type.name===this.revenue || element.nature_type.name===this.liability || element.nature_type.name===this.equity ){
                                tot_ += get_ledger_totals(element.nature_type.name,element.transactions,-1);
                            }
                            break;
                    }
                    
                }
                return tot_;
            }
        }
    }
</script>