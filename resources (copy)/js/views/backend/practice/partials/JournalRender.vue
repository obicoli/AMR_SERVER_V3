<template>
    <div v-if="is_read" class="width-100-pc float-left padding-left-5 padding-right-10 bg-f4 padding-bottom-20 min-height-400">
        <table class="table banking-transaction-reports table statement-reports table-hover mg-bottom-20 mg-right-10 mg-top-15">        
            <thead>
                <tr>
                    <th style="width:15%;" class="somepad-1 fw-600 txt-uppercase fs-12">Date</th>
                    <th style="width:55%" class="somepad-1 fw-600 txt-uppercase fs-12">Account</th>
                    <th style="width:15%;" class="text-right somepad fw-600 txt-uppercase fs-12">Debit</th>
                    <th style="width:15%;" class="text-right somepad-1 fw-600 txt-uppercase fs-11">Credit</th>
                </tr>
            </thead>
            <tbody v-for="(journal,index) in localjournals" :key="'journals'+index">
                <tr v-for="(ledger,index_l) in journal" class="body" :key="'index_l'+index_l">
                    <td>
                        <a v-if="ledger.balance_type===ACCOUNTING.DEBIT">{{ledger.trans_date}}</a>
                    </td>
                    <td>
                        <a>{{ledger.custom_name}}</a>
                    </td>
                    <td class="text-right">
                        <a v-if="ledger.balance_type===ACCOUNTING.DEBIT">Ksh{{formatMoneys(ledger.amount)}}</a>
                    </td>
                    <td class="text-right">
                        <a v-if="ledger.balance_type===ACCOUNTING.CREDIT">Ksh{{formatMoneys(ledger.amount)}}</a>
                    </td>
                </tr>
                <tr class="sub-total body">
                    <td style="font-style: italic;" colspan="2" class="fw-600 fs-12">{{journal[0].trans_description}}</td>
                    <td class="sub-total text-right fs-12">Ksh{{formatMoneys( sub_total(journal,ACCOUNTING.DEBIT) )}}</td>
                    <td class="sub-total text-right fs-12">Ksh{{formatMoneys(sub_total(journal,ACCOUNTING.CREDIT))}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import {PROCESS_STATUS,ACCOUNTING, TRANSACTION_TYPES, FORM_ACTIONS} from '../../../../helpers/process_status';
import {formatMoney} from '../../../../helpers/functionmixin';
export default {
    name: "JournalRender",
    data(){
        return {
            localjournals: [],
            is_read: false,
            ACCOUNTING: ACCOUNTING,
        }
    },
    props: ['journals'],
    watch: {
        journals: function(new_data,old_data){
            this.localjournals = new_data;
        }
    },
    methods: {
        formatMoneys(money_to){
            return formatMoney(money_to);
        },
        sub_total(journal,account_side){
            let result = 0;
            for (let index = 0; index < journal.length; index++) {
                const element = journal[index];
                switch (account_side) {
                    case ACCOUNTING.DEBIT:
                        if(element.balance_type === ACCOUNTING.DEBIT){
                            result+= element.amount;
                        }
                        break;
                    default: //Credit side summation
                        if(element.balance_type === ACCOUNTING.CREDIT){
                            result+= element.amount;
                        }
                        break;
                }
            }
            return result;
        },
    },
    mounted(){
        if(this.journals){
            this.localjournals = this.journals;
            this.is_read = true;
        }
    }
}
</script>