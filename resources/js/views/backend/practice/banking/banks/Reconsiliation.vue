<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">

                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">
                                
                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-11 col-lg-11 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a class="fw-600 cl-444 fs-20">
                                                        Reconcile Banks and Credit Cards
                                                    </a>
                                                </div>
                                                <form @submit.prevent="process_reconciliation" class="width-100-pc float-left mg-top-20">
                                                    <div class="width-40-pc float-left mg-top-15 mg-right-15">
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Bank Account:&nbsp;</label>
                                                            </div>
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <vue-single-select
                                                                        name="maybe"
                                                                        placeholder=""
                                                                        you-want-to-select-a-post="ok"
                                                                        v-model="bank"
                                                                        out-of-all-these-posts="makes sense"
                                                                        :options="bank_accounts"
                                                                        a-post-has-an-id="good"
                                                                        the-post-has-a-title="make"
                                                                        option-label="account_name"
                                                                    ></vue-single-select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left mg-top-4">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Balance:&nbsp;</label>
                                                            </div>
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input :value="currency+' '+format_Money(form.balance)" disabled v-bind:class="{'height-30':true}" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left mg-top-4">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Statement Balance:&nbsp;</label>
                                                            </div>
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input @keyup="reconc($event)" v-model="form.statement_balance" :disabled="is_initializing" v-bind:class="{'height-30':true}" type="number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left mg-top-4">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Statement Date:&nbsp;</label>
                                                            </div>
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <datetime 
                                                                        v-model="filters.today" 
                                                                        :input-id="'date_input_end'"
                                                                        placeholder="select date"
                                                                        use12-hour
                                                                        :type="'date'"
                                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                        :value="filters.today"
                                                                        >
                                                                    </datetime>
                                                                    <!-- <input v-model="form.statement_date" :disabled="is_initializing" v-bind:class="{'height-30':true}" type="text"> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="width-40-pc float-left mg-top-15 mg-right-15">
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">From Date:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <!-- <input v-model="filters.start" :disabled="is_initializing" v-bind:class="{'height-30':true}" type="date"> -->
                                                                    <datetime 
                                                                        v-model="filters.start" 
                                                                        :input-id="'date_input_start'"
                                                                        placeholder="select date"
                                                                        use12-hour
                                                                        :type="'date'"
                                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                        :value="filters.start"
                                                                        >
                                                                    </datetime>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left mg-top-4">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">To Date:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <datetime 
                                                                        v-model="filters.end" 
                                                                        :input-id="'date_input_end'"
                                                                        placeholder="select date"
                                                                        use12-hour
                                                                        :type="'date'"
                                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                        :value="filters.end"
                                                                        >
                                                                    </datetime>
                                                                    <!-- <input v-model="filters.end" :disabled="is_initializing" v-bind:class="{'height-30':true}" type="date"> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div :hidden="bank_accounts.length===0" class="width-100-pc float-left mg-top-4">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Display Reconciled Transactions:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <input v-model="show_reconciled" @click="showReconciled($event)" type="checkbox" class="pointer-cursor">
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left mg-top-4">
                                                            <div class="width-40-pc float-left text-right">
                                                                <label class="company-label fs-12 text-right">Last Reconciliation Date:&nbsp;</label>
                                                            </div>
                                                            <div class="width-50-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <datetime 
                                                                        v-model="previous_reconciliation.end_date"
                                                                        :input-id="'date_input_end'"
                                                                        placeholder="select date"
                                                                        use12-hour
                                                                        :type="'date'"
                                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                        :value="previous_reconciliation.end_date"
                                                                        >
                                                                    </datetime>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="width-100-pc float-left mg-top-30">
                                                        <table class="table banking-transaction table-hover mg-bottom-20">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:2%;"></th>
                                                                    <th style="width:10%;">Reference</th>
                                                                    <th style="width:8%;">Date</th>
                                                                    <th style="width:18%;">Selection</th>
                                                                    <th style="width:14%;">Document Type</th>
                                                                    <th style="width:7%;">Reconciled</th>
                                                                    <th style="width:12%;" class="text-right">Total</th>
                                                                    <th style="width:19%;">Description</th>
                                                                    <th style="width:10%;">Cust/Supp Ref.</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="is_initializing">
                                                                <tr>
                                                                    <td class="somepad text-center" colspan="9">
                                                                        <img src="/assets/icons/dashboard/loader.gif">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr v-for="(bank_transaction,index) in bank_transactions" :key="'bank_transactions_key_'+index">
                                                                    <td class="somepad">
                                                                        <a><i class="fa fa-file-o"></i></a>
                                                                    </td>
                                                                    <td class="somepad">{{bank_transaction.reference}}</td>
                                                                    <td class="somepad">{{bank_transaction.transaction_date}}</td>
                                                                    <td class="somepad">{{bank_transaction.selection.name}}</td>
                                                                    <td class="somepad">{{bank_transaction.name}}</td>
                                                                    <td class="somepad text-center">
                                                                        <input v-if="bank_transaction.reconciled_status[bank_transaction.reconciled_status.length-1].status===PROCESS_STATUS.RECONCILED" disabled type="checkbox" checked :value="bank_transaction.id" class="pointer-cursor">
                                                                        <input v-else type="checkbox" @click="reconcileTransaction($event)" checked v-model="form.reconcile" :value="bank_transaction.id" class="pointer-cursor">
                                                                    </td>
                                                                    <td class="somepad text-right">{{currency+''+format_Money(bank_transaction.amount)}}</td>
                                                                    <td class="somepad">{{bank_transaction.description}}</td>
                                                                    <td class="somepad">{{bank_transaction.account_number}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <div class="width-40-pc float-right">
                                                            <div class="width-100-pc float-left">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label fs-12 text-right">Reconciled Previously:&nbsp;</label>
                                                                </div>
                                                                <div class="width-50-pc float-left">
                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                        <input :value="currency+' '+format_Money(form.reconciled_previous)" disabled v-bind:class="{'height-30':true}" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="width-100-pc float-left mg-top-4">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label fs-12 text-right">Reconciled Now:&nbsp;</label>
                                                                </div>
                                                                <div class="width-50-pc float-left">
                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                        <input :value="currency+' '+format_Money(form.reconciled_amount)" disabled v-bind:class="{'height-30':true}" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="width-100-pc float-left mg-top-4">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label fs-12 text-right">Reconciled Total:&nbsp;</label>
                                                                </div>
                                                                <div class="width-50-pc float-left">
                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                        <input :value="currency+' '+format_Money(form.reconciled_total)" disabled v-bind:class="{'height-30':true}" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="width-100-pc float-left mg-top-4">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label fs-12 text-right">Difference:&nbsp;</label>
                                                                </div>
                                                                <div class="width-50-pc float-left">
                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                        <input :value="currency+' '+format_Money(form.difference)" disabled v-bind:class="{'height-30':true}" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class=" width-40-pc mg-bottom-10 float-left">
                                                            <button @click="process_reconciliation('Save')" :disabled="is_initializing || form.reconcile.length===0" type="submit" class="btn btn-secondary banking-process-amref">Save</button>
                                                            <button @click="process_reconciliation('Save & New')" :disabled="is_initializing || form.reconcile.length===0" type="button" class="btn btn-secondary banking-process">Save & New</button>
                                                            <button @click="process_reconciliation('Print')" :disabled="is_initializing || form.reconcile.length===0" type="button" class="btn btn-secondary banking-process">Print</button>
                                                        </div>

                                                        <copy-right></copy-right>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import CopyRight from "../../partials/CopyRight";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {removeElement,paginator,formatMoney,format_lunox_date, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS,ACCOUNTING} from "../../../../../helpers/process_status";
    import {BANKING_ACCOUNTS_URL,BANKING_RECONCILIATIONS_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,
        SideBar,CopyRight,
        ProcessingOverlay
        },
        data(){
            return {
                form: {
                    bank_account_id: null,
                    //transactions: [],
                    balance: 0,
                    statement_balance: 0,
                    statement_date: null,
                    start_date: null,
                    end_date: null,
                    bank_reconciliation_id: null,
                    last_reconciliation_id: null,
                    reconciled_amount: 0,
                    reconciled_previous: 0,
                    reconciled_total: 0,
                    difference: 0,
                    reconciled: [], //Reconciled Previous
                    reconcile: [], //Reconciled Now
                    notes: null,
                },

                show_reconciled: false,
                bank: {},
                filters: {},
                bank_account: {},
                previous_reconciliation: {},
                current_reconciliation: {},

                PROCESS_STATUS: PROCESS_STATUS,
                bank_accounts: [],
                bank_transactions: [],
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                pagination: paginator(),
                //bank_api: BANKING_BANKS_URL,
                //branch_api: BANKING_BRANCHES_URL,
                bank_accounts_api: BANKING_ACCOUNTS_URL,
                bank_reconciliations_api: BANKING_RECONCILIATIONS_URL,
                //bank_account_types_api: BANKING_ACCOUNTS_TYPES_URL,
                is_initializing: false,
                currency: ACCOUNTING.CURRENCY,
            }
        },
        watch: {
            bank: function(){
                if(this.bank){
                    this.form.balance = this.bank.balance;
                    this.show_reconciled = false;
                    this.loadReconciliations(this.bank.id);
                }
            },
            bank_accounts: function(){
                if(this.bank_accounts.length){
                    //Here this for loop is to search for the default account
                    for (let index = 0; index < this.bank_accounts.length; index++) {
                        const element = this.bank_accounts[index];
                        if(element.is_default){ 
                            this.bank = element;
                            break; 
                        }
                    }
                }
            }
        },
        methods: {

            reconc(event){
                this.reconcile_calc_point("statement_balance",event.target.value);
                //this.form.difference = this.form.statement_balance - this.form.reconciled_total;
            },

            reconcile_calc_point(action_point,amount_to){

                switch(action_point){
                    case "statement_balance":
                            this.form.difference = amount_to - this.form.reconciled_total;
                        break;
                    case "initialization":
                        this.form.reconciled_amount = 0;
                        this.form.reconciled_previous = this.previous_reconciliation.reconciled_total;
                        this.form.reconciled_total = this.previous_reconciliation.reconciled_total + this.form.reconciled_amount;
                        this.form.difference = this.form.statement_balance - this.form.reconciled_total;
                        break;
                    case "add_reconcile":
                        this.form.reconciled_amount = this.form.reconciled_amount + amount_to;
                        this.form.reconciled_previous = this.previous_reconciliation.reconciled_total;
                        this.form.reconciled_total = this.previous_reconciliation.reconciled_total + this.form.reconciled_amount;
                        this.form.difference = this.form.statement_balance - this.form.reconciled_total;
                        break;
                    case "subtract_reconcile":
                        this.form.reconciled_amount = this.form.reconciled_amount - amount_to;
                        this.form.reconciled_previous = this.previous_reconciliation.reconciled_total;
                        this.form.reconciled_total = this.previous_reconciliation.reconciled_total + this.form.reconciled_amount;
                        this.form.difference = this.form.statement_balance - this.form.reconciled_total;
                        break;
                }
            },

            reconcileTransaction(event){
                let amount = 0;
                for (let index = 0; index < this.bank_transactions.length; index++) {
                    const element = this.bank_transactions[index];
                    if(element.id === event.target.value ){
                        amount = element.amount;
                        break;
                    }
                }
                if(event.target.checked){
                    this.reconcile_calc_point('add_reconcile',amount);
                }else{
                    this.reconcile_calc_point('subtract_reconcile',amount)
                }
            },

            format_Money(money_to){
                return formatMoney(money_to);
            },

            showReconciled(event){
                //let new_filter = ["eeeee","dddddd"];
                if(event.target.checked){
                    if(this.bank){
                        this.loadReconciliations(this.bank.id,true);
                    }else{ return; }
                }else{
                    if(this.bank){ this.loadReconciliations(this.bank.id,false); }else{ return }
                }
            },

            check_status(array_to,pin_to){
                let result = null;
                for (let index = 0; index < array_to.length; index++) {
                    const element = array_to[index];
                    if(element.status === pin_to){
                        result = element.date;
                        break;
                    }
                }
                return result;
            },

            check_all(event){
                this.selected_banks = [];
                if(event.target.checked){
                    for (let index = 0; index < this.bank_accounts.length; index++) {
                        const element = this.bank_accounts[index];
                        this.selected_banks.push(element.id);
                    }
                }else{
                    this.selected_banks = [];
                }
            },

            process_reconciliation(action_taken){

                this.is_initializing = true;
                if(this.bank){ this.form.bank_account_id = this.bank.id }
                if( this.filters.start ){ this.form.start_date = format_lunox_date(this.filters.start); }
                if( this.filters.end ){ this.form.end_date = format_lunox_date(this.filters.end); }
                if( this.current_reconciliation ){ this.form.bank_reconciliation_id = this.current_reconciliation.id; }
                if( this.previous_reconciliation ) { this.form.last_reconciliation_id = this.previous_reconciliation.id }

                post(this.bank_reconciliations_api+'?action_taken='+action_taken,this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.is_initializing = false;
                        this.$awn.success(res.data.description);
                        if(this.bank){
                            this.loadReconciliations(this.bank.id);
                        }
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                        this.is_initializing = false;
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                    this.is_initializing = false;
                });
            },

            loadBankAccounts(){
                this.is_initializing = true;
                get(this.bank_accounts_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results.data;
                        this.filters = res.data.results.filters;
                        // console.info(this.bank_accounts);
                        // console.info(this.filters);
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            loadReconciliations(account_id,show_reconciled=false,filtered=[]){
                /*
                    Here this function will alway return Atleast an Array of one Bank Reconciliations and Atmost an Array of Two
                    1. Previously Reconciled(Closed) and the latest "Not Ticked"(Open)
                        (At index [0] is "Not Ticked", at index [1] is "Reconciled")
                */
                this.is_initializing = true;
                let new_api = this.bank_reconciliations_api+'/'+account_id+'/'+account_id;
                if(show_reconciled){
                    new_api = new_api+'?show_reconciled=show'
                }else{
                    new_api = new_api+'?show_reconciled=hide'
                }

                get(new_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        if(res.data.results.data.length===2){
                            this.previous_reconciliation = res.data.results.data[1];
                            this.previous_reconciliation.end_date = format_lunox_date(this.previous_reconciliation.end_date);
                            this.current_reconciliation = res.data.results.data[0];
                            this.bank_transactions = res.data.results.data[0].reconciled_transactions;
                            this.reconcile_calc_point('initialization',0);
                        }else{
                            this.current_reconciliation = res.data.results.data[0];
                        }
                        //
                        this.filters.start = format_lunox_date(res.data.results.filters.start);
                        this.filters.end = format_lunox_date(res.data.results.filters.end);
                        this.filters.today = format_lunox_date(res.data.results.filters.today);
                        //
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            loadBankAccount(account_id){
                this.is_initializing = true;
                get(this.bank_accounts_api+'/'+account_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_account = res.data.results;
                        this.form.balance = this.bank_account.balance;
                        this.bank_transactions = res.data.results.transaction.data;
                        //console.info(this.bank_account);
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }

        },
        mounted() {
            this.loadBankAccounts();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>