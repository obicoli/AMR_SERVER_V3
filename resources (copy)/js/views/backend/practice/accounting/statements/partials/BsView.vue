<template>
    <div class="">
        <table class="ledger-report-table table">

            <tbody>
                <tr>
                    <td class="bs-component-title txt-uppercase bd-r" style="width:50%;">Assets</td>
                    <td class="bs-component-title txt-uppercase bd-l" style="width:50%;">Liabilities</td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td class="zeroPadding bd-r" style="width:50%;">
                        <table v-for="(asset_account,index) in asset_accounts" class="component-table table-hover" :key="'asset_accounts_'+index">
                            <tr>
                                <td colspan="2" class="fw-600 fs-13 bg-eee component-table-title">{{asset_account.name}}</td>
                            </tr>
                            <tr v-for="(account,index_a) in asset_account.accounts" class="component-data" :key="'accounts'+index_a">
                                <td style="width:65%">{{account.name}}</td>
                                <td style="width:35%" class="text-right"><a>{{form_money(cal_ledger_totals(account.nature_type.name,account.transactions,-1))}}</a></td>
                            </tr>
                            <tr class="component-total">
                                <td style="width:65%">Total {{asset_account.name}}</td>
                                <td style="width:35%" class="sub-total text-right">{{currency}}{{form_money(total_handler(assets,asset_account.accounts))}}</td>
                            </tr>
                        </table>
                    </td>
                    <!-- -------------------Right Side--------------------- -->
                    <td class="zeroPadding bd-l" style="width:50%;">

                        <table v-for="(liability_account,index) in liability_accounts" class="component-table table-hover" :key="'liability_account_'+index">
                            <tr>
                                <td colspan="2" class="fw-600 fs-13 bg-eee component-table-title">{{liability_account.name}}</td>
                            </tr>
                            <tr v-for="(accountr,index_a) in liability_account.accounts" class="component-data" :key="'accounts_eq'+index_a">
                                <td style="width:65%">{{accountr.name}}</td>
                                <td style="width:35%" class="text-right"><a>{{form_money(cal_ledger_totals(accountr.nature_type.name,accountr.transactions,-1))}}</a></td>
                            </tr>
                            <tr class="component-total">
                                <td style="width:65%">Total {{liability_account.name}}</td>
                                <td style="width:35%" class="sub-total text-right">{{currency}}{{form_money(total_handler(liability,liability_account.accounts))}}</td>
                            </tr>
                        </table>

                        <table class="component-table table-hover">
                            <tr class="component-total">
                                <td style="width:65%">Total liabilities</td>
                                <td style="width:35%" class="sub-total text-right">{{currency}}00.00</td>
                            </tr>
                        </table>

                        <table>
                            <tr>
                                <td colspan="2" class="bs-component-title txt-uppercase bd-l" style="width:100%;">Stakeholder's Equity</td>
                            </tr>
                        </table>
                        <table v-for="(equit_account,index) in equit_accounts" class="component-table table-hover" :key="'equit_accounts_'+index">
                            <tr>
                                <td colspan="2" class="fw-600 fs-13 bg-eee component-table-title">{{equit_account.name}}</td>
                            </tr>
                            <tr v-for="(eaccount,index_a) in equit_account.accounts" class="component-data" :key="'accounts_eq'+index_a">
                                <td style="width:65%">{{eaccount.name}}</td>
                                <td style="width:35%" class="text-right"><a>{{form_money(cal_ledger_totals(eaccount.nature_type.name,eaccount.transactions,-1))}}</a></td>
                            </tr>
                            <tr class="component-total">
                                <td style="width:65%">Total {{equit_account.name}}</td>
                                <td style="width:35%" class="sub-total text-right">{{currency}}{{form_money(total_handler(equity,equit_account.accounts))}}</td>
                            </tr>
                        </table>

                    </td>
                    <!-- ------------------------Right Side Ends Here--------------- -->
                </tr>

                <tr>
                    <td class="zeroPadding bd-r" style="width:50%;">
                        <table>
                            <tr>
                                <td style="width:65%" class="fw-600 fs-12 txt-uppercase bd-top-0 bd-bottom-0 text-right">Total Assets</td>
                                <td style="width:55%" class="bs-total fw-600 fs-13 text-right">{{currency}}{{form_money(total_assets)}}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="zeroPadding bd-l" style="width:50%;">
                        <table>
                            <tr>
                                <td class="fw-600 fs-12 txt-uppercase bd-top-0 bd-bottom-0 text-right" style="width:65%">Total liabilities & Stockholder's equity</td>
                                <td style="width:55%" class="bs-total fw-600 fs-13 text-right">{{currency}}{{form_money(total_liablity + total_equity)}}</td>
                            </tr>
                        </table>
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
        data(){
            return {
                assets: this.ACCOUNTING.ACCOUNT_NATURES.ASSETS,
                expense: this.ACCOUNTING.ACCOUNT_NATURES.EXPENSE,
                liability: this.ACCOUNTING.ACCOUNT_NATURES.LIABILITY,
                revenue: this.ACCOUNTING.ACCOUNT_NATURES.REVENUE,
                equity: this.ACCOUNTING.ACCOUNT_NATURES.EQUITY,
                currency: this.ACCOUNTING.CURRENCY,
                asset_accounts: [],
                equit_accounts: [],
                liability_accounts: [],
                total_assets: 0,
                total_liablity: 0,
                total_equity: 0,
            }
        },
        methods: {
            form_money(money_to){
                return formatMoney(money_to);
            },
            cal_ledger_totals(nature_type,ledgers,last_index=0){
                return get_ledger_totals(nature_type,ledgers,last_index)
            },
            total_handler(nature_type,ledgers=[]){
                //This function takes two parameters
                //Argument 1 nature_type is Account nature type e.g. Assets, Liability, Expense, Equity, Revenue, Debit, Credit
                //Argument 2 ledgers is the array containing Chart of accounts, this accounts have the transactions performed on the
                //It returns a total of all transactions in all accounts
                let tot_ = 0;
                for (let index = 0; index < ledgers.length; index++) {
                    const element = ledgers[index];
                    switch (nature_type) {
                        case this.assets:
                            if(element.nature_type.name===this.assets ){
                                tot_ += get_ledger_totals(element.nature_type.name,element.transactions,-1);
                            }
                            break;
                        case this.liability:
                            if(element.nature_type.name===this.liability ){
                                tot_ += get_ledger_totals(element.nature_type.name,element.transactions,-1);
                            }
                            break;
                        case this.equity:
                            if(element.nature_type.name===this.equity ){
                                tot_ += get_ledger_totals(element.nature_type.name,element.transactions,-1);
                            }
                            break;
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
        },
        mounted(){
            for (let index = 0; index < this.ledgers.length; index++) {
                const ledger = this.ledgers[index];
                if(ledger.nature_type === this.assets){
                    this.asset_accounts = ledger.account_types;
                    for (let i = 0; i < ledger.account_types.length; i++) {
                        const element = ledger.account_types[i];
                        this.total_assets += this.total_handler(this.assets,element.accounts);
                    }
                }
                
                else if(ledger.nature_type === this.equity){
                    this.equit_accounts = ledger.account_types;
                    for (let i = 0; i < ledger.account_types.length; i++) {
                        const element = ledger.account_types[i];
                        this.total_equity += this.total_handler(this.equity,element.accounts);
                    }
                }

                else if(ledger.nature_type === this.liability){
                    this.liability_accounts = ledger.account_types;
                    for (let i = 0; i < ledger.account_types.length; i++) {
                        const element = ledger.account_types[i];
                        this.total_liablity += this.total_handler(this.liability,element.accounts);
                    }
                }
            }
        }
    }
</script>
<style scoped>
    .table td, .table th {
        border-top: 0px solid transparent;
    }
    table.ledger-report-table tbody tr td.zeroPadding{
        border-bottom: transparent solid 0px;
    }
</style>