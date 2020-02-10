<template>
    <form @submit.prevent="open_account_head">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-id-card-o"></i>
                    Opening Balances:<br>
                    <small>Use when importing account heads</small>
                </h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Account:</label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <vue-single-select
                                        name="maybe"
                                        :required="true"
                                        placeholder=""
                                        you-want-to-select-a-post="ok"
                                        v-model="chart_item"
                                        out-of-all-these-posts="makes sense"
                                        :options="account_charts"
                                        a-post-has-an-id="good for search and display"
                                        option-key=""
                                        the-post-has-a-title="make sure to show these"
                                        option-label="name"
                                ></vue-single-select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Transaction:</label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <vue-single-select
                                        name="maybe"
                                        :required="true"
                                        placeholder=""
                                        you-want-to-select-a-post="ok"
                                        v-model="trans_item"
                                        out-of-all-these-posts="makes sense"
                                        :options="transactions"
                                        a-post-has-an-id="good for search and display"
                                        option-key=""
                                        the-post-has-a-title="make sure to show these"
                                        option-label="name"
                                ></vue-single-select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Amount:</label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="number" v-model="open_head_form.amount" required class="form-control product-entry-input-field">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Date:</label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="date" v-model="open_head_form.transaction_date" required class="form-control product-entry-input-field">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Narration:</label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <textarea v-model="open_head_form.narration" required class="form-control product-entry-input-field"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    import Auth from '../../../../../store/auth';
    import AppInfo from '../../../../../helpers/config';
    import {get,post} from "../../../../../helpers/api";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "OpenAccountHeadModal",
        data(){
            return {
                practice_id: '',
                initial_url: '/api/practices/products/accounts/opening_account_head',
                processing: false,
                account_loaded: false,
                account_charts: [],
                chart_item: {},
                transactions: [{id:"Debit",name:"Debit"},{id:"Credit",name:"Credit"}],
                trans_item: {},
                open_head_form: {
                    account_id: '',
                    transaction_type: '',
                    transaction_date: '',
                    amount: '',
                    narration: '',
                    practice_id: '',
                },
            }
        },
        methods: {
            refresh_form_(){
                this.trans_item = {};
                this.chart_item = {};
                this.open_head_form.account_id = "";
                this.open_head_form.transaction_type = "";
                this.open_head_form.transaction_date = "";
                this.open_head_form.amount = "";
                this.open_head_form.narration = "";
                this.open_head_form.practice_id = "";
            },
            loadAccounts(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Accounts')
                    .then((res) => {
                        //this.accounts = [];
                        if(res.data.status_code === 200) {
                            this.account_charts = res.data.results.resources;
                            console.info(this.account_charts);
                        }
                    }).catch((err) => {
                });
                this.processing = false;
            },
            open_account_head(){
                this.processing = true;
                this.open_head_form.practice_id = this.practice_id;
                this.open_head_form.account_id = this.chart_item.id;
                this.open_head_form.transaction_type = this.trans_item.id;
                post(AppInfo.app_data.server_domain+this.initial_url,this.open_head_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.refresh_form_();
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            }
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadAccounts();
        }
    }
</script>

<style scoped>

</style>