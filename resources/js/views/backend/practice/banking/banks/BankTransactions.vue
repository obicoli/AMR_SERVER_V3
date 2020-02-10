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
                                                        {{report_type}}
                                                    </a>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-20">

                                                    <div v-if="page_ready" class="width-100-pc float-left">

                                                        <div class="width-30-pc float-left">

                                                            <div class="width-100-pc float-left mg-right-15">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label text-right">Bank or Credit Card:&nbsp;</label>
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

                                                            <div class="width-100-pc float-left mg-top-15 mg-right-15">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label text-right">Bank or Credit Card:&nbsp;</label>
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

                                                            <div class="width-100-pc mg-top-5 float-left">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label text-right">Balance:&nbsp;</label>
                                                                </div>
                                                                <div class="width-60-pc float-left">
                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                        <input :value="currency+' '+format_Money(bank_account.balance)" disabled v-bind:class="{'height-30':true}" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="width-100-pc mg-top-5 float-left">
                                                                <div class="width-40-pc float-left text-right">
                                                                    <label class="company-label text-right">To Be Reviewed:&nbsp;</label>
                                                                </div>
                                                                <div class="width-60-pc float-left">
                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                        <input :value="bank_transactions.length+' Transaction(s)'" disabled v-bind:class="{'height-30':true}" type="text">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="report_type==='Banking | Bank Statement'" class="width-60-pc float-right doc-holder-2 padding-20">
                                                            <div class="width-50-pc float-left">
                                                                <div class="width-100-pc mg-top-5 float-left">
                                                                    <div class="width-40-pc float-left text-right">
                                                                        <label class="company-label text-right">Import File Type:&nbsp;</label>
                                                                    </div>
                                                                    <div class="width-60-pc float-left">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <select>
                                                                                <option>OFX</option>
                                                                                <option>CSV</option>
                                                                                <option>Historic CSV</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="width-100-pc mg-top-5 float-left">
                                                                    <div class="width-40-pc float-left text-right">
                                                                        <label class="company-label text-right">Date Format:&nbsp;</label>
                                                                    </div>
                                                                    <div class="width-60-pc float-left">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <select>
                                                                                <option>dd/mm/YYYY</option>
                                                                                <option>mm/dd/YYYY</option>
                                                                                <option>dd-mm-YYYY</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="width-100-pc mg-top-5 float-left">
                                                                    <div class="width-40-pc float-left text-right">
                                                                        <label class="company-label text-right">Import file:&nbsp;</label>
                                                                    </div>
                                                                    <div class="width-60-pc float-left">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <input type="file">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="width-100-pc mg-top-5 float-left">
                                                                    <div class="width-40-pc float-left text-right">
                                                                    </div>
                                                                    <div class="width-60-pc float-left">
                                                                        <button :disabled="true" class="btn btn-secondary banking-process-amref">
                                                                            Import
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="width-50-pc float-right">
                                                                <div class="width-100-pc mg-top-5 float-left">
                                                                    <div class="width-40-pc float-left text-right">
                                                                        <label class="company-label text-right">Date Range:&nbsp;</label>
                                                                    </div>
                                                                    <div class="width-60-pc float-left">
                                                                        <input type="radio" v-model="import_transactions.date_range" value="All Transactions"> All Transactions&nbsp;&nbsp;
                                                                        <input type="radio" v-model="import_transactions.date_range" value="Dates to Import"> Dates to Import
                                                                    </div>
                                                                </div>
                                                                <div class="width-100-pc mg-top-5 float-left">
                                                                    <div class="width-40-pc float-left text-right">
                                                                        <label class="company-label text-right">From Date:&nbsp;</label>
                                                                    </div>
                                                                    <div class="width-60-pc float-left">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <datetime 
                                                                                v-model="import_transactions.start_date"
                                                                                :input-id="'date_input_start_date'"
                                                                                placeholder="select date"
                                                                                use12-hour
                                                                                :type="'date'"
                                                                                :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                :value="import_transactions.start_date"
                                                                                >
                                                                            </datetime>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="width-100-pc mg-top-5 float-left">
                                                                    <div class="width-40-pc float-left text-right">
                                                                        <label class="company-label text-right">To Date:&nbsp;</label>
                                                                    </div>
                                                                    <div class="width-60-pc float-left">
                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                            <datetime 
                                                                                v-model="import_transactions.end_date"
                                                                                :input-id="'date_input_'"
                                                                                placeholder="select date"
                                                                                use12-hour
                                                                                :type="'date'"
                                                                                :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                :value="import_transactions.end_date"
                                                                                >
                                                                            </datetime>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- =============================TABS========================= -->
                                                    <div v-if="bank_accounts.length" class="width-100-pc float-left mg-top-45">
                                                        <nav>
                                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                <a @click="toggleTab(0)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">New Transactions</a>
                                                                <a @click="toggleTab(1)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Reviewed Transactions</a>
                                                                <!-- <a @click="toggleTab(2)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===2}" :id="'nav-transactions-tab-'+'2'" data-toggle="tab" :href="'#nav-transactions-'+'2'" role="tab" :aria-controls="'nav-transactions-'+'2'" aria-selected="true" :key="'transactions_tab'+'2'">Reconciled Transactions</a> -->
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content tab-content-role" id="nav-tabContent">
                                                            <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                                <!-- -----------------------------------------------New Transaction Starts--------------------------------------------- -->
                                                                <form @submit.prevent="process_new_transactions" class="width-100-pc float-left mg-top-10 padding-top-10 padding-left-15 padding-right-15 bg-f4">
                                                                    <div class=" width-100-pc mg-bottom-10 float-left">
                                                                        <router-link to="/" class="cl-blue-link fs-12">Go to Reconciliation</router-link>
                                                                        <button @click="process_new_transactions('Ticked')" :disabled="is_initializing || processing || form.selected_transactions.length===0" type="button" class="btn btn-secondary btn-actions">Mark as Reviewed</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Delete</button>
                                                                        <!-- <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Keep Duplicates</button> -->
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Batch Edit</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Import Bank Statement</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Export</button>
                                                                    </div>
                                                                    <table class="table banking-transaction table-hover mg-bottom-20">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width:2%;">
                                                                                    <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                                </th>
                                                                                <th style="width:8%">Date</th>
                                                                                <th>Payee</th>
                                                                                <th>Description</th>
                                                                                <th style="width:7%">Type</th>
                                                                                <th style="width:15%;">Selection</th>
                                                                                <th>Reference</th>
                                                                                <th>VAT</th>
                                                                                <th>Spent</th>
                                                                                <th>Received</th>
                                                                                <th style="width:3%;" class="text-center">Rec</th>
                                                                                <th style="width:12%;"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody v-if="is_initializing">
                                                                            <tr>
                                                                                <td class="somepad text-center" colspan="12">
                                                                                    <img src="/assets/icons/dashboard/loader.gif">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody v-else>
                                                                            <tr v-if="bank_transactions.length===0">
                                                                                <td class="somepad" colspan="11">You have no new Bank transactions to review. <a class="cl-blue-link pointer-cursor">Import your Bank Statements</a>  or manually enter banking transactions below.</td>
                                                                                <td class="text-right"><a @click="add_this(null)" class="fs-12 cl-amref mg-right-5" title="New Transaction">+New</a></td>
                                                                            </tr>
                                                                            <tr v-else>
                                                                                <td class="somepad" colspan="11">You have {{bank_transactions.length}} new Bank transactions to review and process.</td>
                                                                                <td class="text-right"><a @click="add_this(null)" class="fs-12 cl-amref mg-right-5" title="New Transaction">+New</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody v-for="(bank_transaction,index) in form.transactions" :key="'element_key_'+index">
                                                                            <tr>
                                                                                <td class="somepad">
                                                                                    <input :disabled="is_initializing || processing" v-model="form.selected_transactions" type="checkbox" class="pointer-cursor" :value="bank_transaction.id">
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <datetime 
                                                                                        v-model="form.transactions[index].transaction_date" 
                                                                                        :input-id="'date_input_'+index"
                                                                                        placeholder="select date"
                                                                                        use12-hour
                                                                                        :type="'date'"
                                                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                        :value="form.transactions[index].transaction_date"
                                                                                        >
                                                                                    </datetime>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_date" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="form.transactions[index].payee" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_payee" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="form.transactions[index].description" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_desc" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <select :disabled="is_initializing || processing" @change="reset_selection($event,index)" v-model="form.transactions[index].type" v-bind:class="{'height-30':true}">
                                                                                            <option value="" disabled selected>select</option>
                                                                                            <option :value="AC_TYPES.ACCOUNT">{{AC_TYPES.ACCOUNT}}</option>
                                                                                            <option :value="AC_TYPES.SUPPLIER">{{AC_TYPES.SUPPLIER}}</option>
                                                                                            <option :value="AC_TYPES.CUSTOMER">{{AC_TYPES.CUSTOMER}}</option>
                                                                                            <option :value="AC_TYPES.TRANSFER">{{AC_TYPES.TRANSFER}}</option>
                                                                                            <option :value="AC_TYPES.VAT">{{AC_TYPES.VAT}}</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_type" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <vue-single-select
                                                                                            name="maybe"
                                                                                            placeholder=""
                                                                                            :disabled="is_initializing || processing"
                                                                                            you-want-to-select-a-post="ok"
                                                                                            out-of-all-these-posts="makes sense"
                                                                                            :options="form.transactions[index].selections"
                                                                                            v-model="form.transactions[index].selection"
                                                                                            a-post-has-an-id="good"
                                                                                            the-post-has-a-title="make"
                                                                                            option-label="name"
                                                                                        ></vue-single-select>
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_select" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" v-model="form.transactions[index].reference" :disabled="is_initializing || processing" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_ref" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <vue-single-select
                                                                                            name="maybe"
                                                                                            placeholder=""
                                                                                            you-want-to-select-a-post="ok"
                                                                                            v-model="form.transactions[index].vat"
                                                                                            out-of-all-these-posts="makes sense"
                                                                                            :options="taxations"
                                                                                            a-post-has-an-id="good"
                                                                                            the-post-has-a-title="make"
                                                                                            option-label="name"
                                                                                        ></vue-single-select>
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_vat" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="form.transactions[index].spent" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_spent" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="form.transactions[index].received" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="form.transactions[index].error && form.transactions[index].is_received" class="fs-11 cl-amref">{{form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="text-center somepad">
                                                                                    <input type="checkbox" :disabled="is_initializing || processing" class="pointer-cursor" v-model="form.transactions[index].reconciled">
                                                                                </td>
                                                                                <td class="somepad icon-group text-right">
                                                                                    <a data-toggle="collapse" :data-target="'#transaction_details_'+index" title="More"><i class="fa fa-angle-down"></i></a>
                                                                                    <a :hidden="!form.transactions[index].id" data-toggle="modal" :data-target="'#transaction_split_modal_'+index" title="Split Transaction"><i class="fa fa-arrows-h"></i></a>
                                                                                    <a :hidden="!form.transactions[index].id" data-toggle="modal" :data-target="'#invoice_allocate_modal_'+index" title="Allocate"><i class="fa fa-sitemap"></i></a>
                                                                                    <a :hidden="!form.transactions[index].id" data-toggle="modal" :data-target="'#transaction_attachment_modal_'+index" title="Attachments"><i class="fa fa-paperclip"></i></a>
                                                                                    <a :hidden="!form.transactions[index].id" title="Copy" class="cl-success-light"><i class="fa fa-plus-circle"></i></a>
                                                                                    <a v-if="form.transactions[index].id" data-toggle="modal" :data-target="'#delete_transaction_'+form.transactions[index].id" title="Delete" class="cl-amref"><i class="fa fa-trash-o"></i></a>
                                                                                    <a v-if="!form.transactions[index].id" @click="remove_this(index)" title="Remove" class="cl-amref"><i class="fa fa-minus-circle"></i></a>
                                                                                </td>
                                                                                <delete-modal v-if="form.transactions[index].id" :modal_title="'Delete Transaction'" :bank_transactions_api="bank_transactions_api+'/'+form.transactions[index].id" :confirm_message="'Are you sure?'+form.transactions[index].id" :modal_id="'delete_transaction_'+form.transactions[index].id"></delete-modal>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="12" class="zeroPadding bg-ced">
                                                                                    <div class="collapse out width-100-pc bg-ced" style="padding-left:3%!important;" :id="'transaction_details_'+index">
                                                                                        <div class="width-100-pc float-left bg-ced padding-top-20 padding-bottom-30">
                                                                                            <h4 class="fs-11 fw-600 txt-uppercase">Transaction Detail</h4>
                                                                                            <div v-if="form.transactions[index].type===AC_TYPES.SUPPLIER || form.transactions[index].type===AC_TYPES.CUSTOMER" class="width-40-pc float-left">
                                                                                                <div class="width-100-pc float-left mg-bottom-10">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Discount amount:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-50-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <input v-model="form.transactions[index].discount" v-bind:class="{'height-27':true,'custom-attended-field':form.transactions[index].discount}" type="number">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Comment:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-60-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <textarea v-model="form.transactions[index].comment" v-bind:class="{'min-height-90':true,'custom-attended-field':form.transactions[index].comment}"></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div v-else class="width-40-pc float-left">
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Exclusive amount:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-50-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <input v-bind:class="{'height-27':true}" type="number">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">VAT amount:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-50-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <input v-bind:class="{'height-27':true}" type="number">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Comment:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-60-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <textarea v-bind:class="{'min-height-90':true}"></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <transaction-attachment-modal v-if="page_ready && form.transactions[index].id" :title="'Attachments'" :modal_id="'transaction_attachment_modal_'+index"></transaction-attachment-modal>
                                                                            <split-transaction-modal v-if="page_ready && form.transactions[index].id" :taxations="taxations" :form_data="form.transactions[index]" :bank_transactions_api="bank_transactions_api+'/'+form.transactions[index].id" :title="'Split Transaction'" :modal_id="'transaction_split_modal_'+index"></split-transaction-modal>
                                                                            <allocate-invoice-modal v-if="page_ready" :title="'Invoices'" :modal_id="'invoice_allocate_modal_'+index"></allocate-invoice-modal>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class=" width-100-pc mg-bottom-10 float-left text-center">
                                                                        <button @click="process_new_transactions('Save')" :disabled="is_initializing || processing || form.transactions.length===0" type="button" class="btn btn-secondary banking-process-amref">Save Changes</button>
                                                                        <button @click="process_new_transactions('Ticked')" :disabled="is_initializing || processing || form.selected_transactions.length===0" type="button" class="btn btn-secondary banking-process">Mark selected as Reviewed</button>
                                                                        <button @click="process_new_transactions('Ticked')" :disabled="is_initializing || processing || form.selected_transactions.length===0" type="button" class="btn btn-secondary banking-process">Mark all as Reviewed</button>
                                                                    </div>
                                                                </form>
                                                                <!-- ------------------------------------------------New Transaction Starts-------------------------------------------- -->
                                                            </div>
                                                            <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-transactions-'+'1'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'1'" :key="'tab_index_'+'1'">
                                                                <!-- -----------------------------------------------Reviewed Transaction Starts--------------------------------------------- -->
                                                                <div class="width-100-pc float-left mg-top-30">
                                                                    <div class=" width-100-pc mg-bottom-10 float-left">
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Mark as Reviewed</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Delete</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Keep Duplicates</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Batch Edit</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Import Bank Statement</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary btn-actions">Export</button>
                                                                    </div>
                                                                    <table class="table banking-transaction table-hover mg-bottom-20">
                                                                        
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width:2%;">
                                                                                    <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                                </th>
                                                                                <th style="width:6%">Date</th>
                                                                                <th>Payee</th>
                                                                                <th>Description</th>
                                                                                <th>Type</th>
                                                                                <th>Selection</th>
                                                                                <th>Reference</th>
                                                                                <th>VAT</th>
                                                                                <th>Spent</th>
                                                                                <th>Received</th>
                                                                                <th style="width:3%;" class="text-center">Rec</th>
                                                                                <th style="width:12%;"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody v-if="is_initializing">
                                                                            <tr>
                                                                                <td class="somepad text-center" colspan="12">
                                                                                    <img src="/assets/icons/dashboard/loader.gif">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody v-else>
                                                                            <tr>
                                                                                <td v-if="bank_transactions.length===0" class="somepad" colspan="12">You have no new Bank Statement transactions to review. <a class="cl-blue-link pointer-cursor">Import your Bank Statements</a>  or manually enter banking transactions below.</td>
                                                                                <td v-else class="somepad" colspan="12">You have {{bank_transactions.length}} new Bank Statement transactions to review and process.</td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tbody v-for="(reviewed_transaction,index) in reviewed_form.transactions" :key="'element_key_'+index">
                                                                            
                                                                            <tr>
                                                                                <td class="somepad">
                                                                                    <input :disabled="is_initializing || processing" v-model="reviewed_form.checked_transaction" type="checkbox" class="pointer-cursor" :value="reviewed_transaction.id">
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <datetime 
                                                                                        v-model="reviewed_form.transactions[index].transaction_date" 
                                                                                        :input-id="'date_input_'+index"
                                                                                        placeholder="select date"
                                                                                        use12-hour
                                                                                        :type="'date'"
                                                                                        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
                                                                                        :value="reviewed_form.transactions[index].transaction_date"
                                                                                        >
                                                                                    </datetime>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_date" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="reviewed_form.transactions[index].payee" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_payee" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="reviewed_form.transactions[index].description" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_desc" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <select :disabled="is_initializing || processing" @change="reset_selection($event,index)" v-model="reviewed_form.transactions[index].type" v-bind:class="{'height-30':true}">
                                                                                            <option value="" disabled selected>select</option>
                                                                                            <option :value="AC_TYPES.ACCOUNT">{{AC_TYPES.ACCOUNT}}</option>
                                                                                            <option :value="AC_TYPES.SUPPLIER">{{AC_TYPES.SUPPLIER}}</option>
                                                                                            <option :value="AC_TYPES.CUSTOMER">{{AC_TYPES.CUSTOMER}}</option>
                                                                                            <option :value="AC_TYPES.TRANSFER">{{AC_TYPES.TRANSFER}}</option>
                                                                                            <option :value="AC_TYPES.VAT">{{AC_TYPES.VAT}}</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_type" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <vue-single-select
                                                                                            name="maybe"
                                                                                            placeholder=""
                                                                                            :disabled="is_initializing || processing"
                                                                                            you-want-to-select-a-post="ok"
                                                                                            out-of-all-these-posts="makes sense"
                                                                                            :options="reviewed_form.transactions[index].selections"
                                                                                            v-model="reviewed_form.transactions[index].selection"
                                                                                            a-post-has-an-id="good"
                                                                                            the-post-has-a-title="make"
                                                                                            option-label="name"
                                                                                        ></vue-single-select>
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_select" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" v-model="reviewed_form.transactions[index].reference" :disabled="is_initializing || processing" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_ref" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <vue-single-select
                                                                                            name="maybe"
                                                                                            placeholder=""
                                                                                            you-want-to-select-a-post="ok"
                                                                                            v-model="reviewed_form.transactions[index].vat"
                                                                                            out-of-all-these-posts="makes sense"
                                                                                            :options="taxations"
                                                                                            a-post-has-an-id="good"
                                                                                            the-post-has-a-title="make"
                                                                                            option-label="name"
                                                                                        ></vue-single-select>
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_vat" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="reviewed_form.transactions[index].spent" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_spent" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="zeropad">
                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                        <input @keyup="resetErr(index)" :disabled="is_initializing || processing" v-model="reviewed_form.transactions[index].received" v-bind:class="{'height-30':true}" type="text">
                                                                                    </div>
                                                                                    <span v-if="reviewed_form.transactions[index].error && reviewed_form.transactions[index].is_received" class="fs-11 cl-amref">{{reviewed_form.transactions[index].error_msg}}</span>
                                                                                </td>
                                                                                <td class="text-center somepad">
                                                                                    <input type="checkbox" :disabled="is_initializing || processing" class="pointer-cursor" v-model="reviewed_form.transactions[index].reconciled">
                                                                                </td>
                                                                                <td class="somepad icon-group text-right">
                                                                                    <a data-toggle="collapse" :data-target="'#transaction_details_'+index" title="More"><i class="fa fa-angle-down"></i></a>
                                                                                    <a :hidden="!reviewed_form.transactions[index].id" data-toggle="modal" :data-target="'#transaction_split_modal_'+index" title="Split Transaction"><i class="fa fa-arrows-h"></i></a>
                                                                                    <a :hidden="!reviewed_form.transactions[index].id" data-toggle="modal" :data-target="'#invoice_allocate_modal_'+index" title="Allocate"><i class="fa fa-sitemap"></i></a>
                                                                                    <a :hidden="!reviewed_form.transactions[index].id" data-toggle="modal" :data-target="'#transaction_attachment_modal_'+index" title="Attachments"><i class="fa fa-paperclip"></i></a>
                                                                                    <a :hidden="!reviewed_form.transactions[index].id" title="Copy" class="cl-success-light"><i class="fa fa-plus-circle"></i></a>
                                                                                    <a v-if="reviewed_form.transactions[index].id" data-toggle="modal" :data-target="'#delete_transaction_'+reviewed_form.transactions[index].id" title="Delete" class="cl-amref"><i class="fa fa-trash-o"></i></a>
                                                                                    <a v-if="!reviewed_form.transactions[index].id" @click="remove_this(index)" title="Remove" class="cl-amref"><i class="fa fa-minus-circle"></i></a>
                                                                                </td>
                                                                                <delete-modal v-if="reviewed_form.transactions[index].id" :modal_title="'Delete Transaction'" :bank_transactions_api="bank_transactions_api+'/'+reviewed_form.transactions[index].id" :confirm_message="'Are you sure?'+reviewed_form.transactions[index].id" :modal_id="'delete_transaction_'+reviewed_form.transactions[index].id"></delete-modal>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="12" class="zeroPadding bg-ced">
                                                                                    <div class="collapse out width-100-pc bg-ced" style="padding-left:3%!important;" :id="'transaction_details_'+index">
                                                                                        <div class="width-100-pc float-left bg-ced padding-top-20 padding-bottom-30">
                                                                                            <h4 class="fs-11 fw-600 txt-uppercase">Transaction Detail</h4>
                                                                                            <!-- Record Discount Received Here from supplier Payment -->
                                                                                            <div v-if="reviewed_form.transactions[index].type===AC_TYPES.SUPPLIER || reviewed_form.transactions[index].type===AC_TYPES.CUSTOMER" class="width-40-pc float-left">
                                                                                                <div class="width-100-pc float-left mg-bottom-10">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Discount amount:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-50-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <input v-model="reviewed_form.transactions[index].discount" v-bind:class="{'height-27':true,'custom-attended-field':reviewed_form.transactions[index].discount}" type="number">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Comment:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-60-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <textarea v-model="reviewed_form.transactions[index].comment" v-bind:class="{'min-height-90':true,'custom-attended-field':reviewed_form.transactions[index].comment}"></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div v-else class="width-40-pc float-left">
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Exclusive amount:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-50-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <input v-bind:class="{'height-27':true}" type="number">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">VAT amount:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-50-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <input v-bind:class="{'height-27':true}" type="number">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="width-100-pc float-left">
                                                                                                    <div class="width-40-pc float-left text-right">
                                                                                                        <label class="company-label fs-12 text-right">Comment:&nbsp;</label>
                                                                                                    </div>
                                                                                                    <div class="width-60-pc float-left">
                                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                            <textarea v-bind:class="{'min-height-90':true}"></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>

                                                                            <!-- <transaction-attachment-modal v-if="page_ready" :title="'Attachments'" :modal_id="'transaction_attachment_modal_'+index"></transaction-attachment-modal>
                                                                            <split-transaction-modal v-if="page_ready" :title="'Split Transaction'" :modal_id="'transaction_split_modal_'+index"></split-transaction-modal>
                                                                            <allocate-invoice-modal v-if="page_ready" :title="'Invoices'" :modal_id="'invoice_allocate_modal_'+index"></allocate-invoice-modal> -->
                                                                        </tbody>
                                                                    </table>
                                                                    <div class=" width-100-pc mg-bottom-10 float-left text-center">
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary banking-process-amref">Save Changes</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary banking-process">Mark selected as Reviewed</button>
                                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary banking-process">Mark all as Reviewed</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-if="page_ready && bank_accounts.length===0" class="width-100-pc float-left mg-top-60 mg-bottom-50">
                                                        <div class="layout-footer-table">
                                                            <div class="text-center fs-12">
                                                                <span><strong>No Bank account to record transaction </strong></span>
                                                                <br>
                                                                <div class="text-center ">
                                                                    <button type="button" data-toggle="modal" data-target="#create_new_bank_account_modal" class="btn btn-secondary banking-process-amref">Add a Bank or Credit Card</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- ===============================TABS ENDS======================= -->
                                                    <bank-account-modal v-if="page_ready" v-on:successCreated="loadBankAccounts(true)" :bank_accounts_api="bank_accounts_api" :banks="banks" :bank_branches="bank_branches" :modal_id="'create_new_bank_account_modal'" :bank_account_types="bank_account_types" :title="'New Bank Account'" :user_mode="'Create'"></bank-account-modal>
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
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <copy-right></copy-right>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../partials/CopyRight';
    import DeleteModal from "../../partials/modals/DeleteModal";
    // import BankModal from "../../partials/modals/accounting/BankModal";
    import BankAccountModal from "../../partials/modals/accounting/BankAccountModal";
    import TransactionAttachmentModal from "../../partials/modals/accounting/TransactionAttachmentModal";
    import SplitTransactionModal from "../../partials/modals/accounting/SplitTransactionModal";
    import AllocateInvoiceModal from "../../partials/modals/accounting/AllocateInvoiceModal";
    // import BankBranchModal from "../../partials/modals/accounting/BankBranchModal";
    // import BankAccountModal from "../../partials/modals/accounting/BankAccountModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    // import Datepicker from 'vuejs-datepicker';
    import {removeElement,removeIndex,paginator,formatMoney,create_bank_statement_transaction, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../helpers/process_status";
    import {BANKING_BANKS_URL,SUPPLIER_URL,CUSTOMERS_API,CHART_OF_ACCOUNTS,BANKING_ACCOUNTS_URL,PRODUCT_TAX_URL,BANKING_TRANSACTIONS_URL, BANKING_BRANCHES_URL, BANKING_ACCOUNTS_TYPES_URL} from '../../../../../router/api_routes';
    export default {
        name: "BankTransactions",
        components: {TopNavBar,PaginateTemplate,SideBar,SplitTransactionModal,DeleteModal,BankAccountModal,CopyRight,
        ProcessingOverlay,TransactionAttachmentModal,AllocateInvoiceModal},
        data(){
            return {
                curr_tab: 0,
                form: {
                    selected_transactions: [],
                    transactions: [],
                    action_taken: null,
                },
                reviewed_form: {
                    transactions: [],
                },
                filters: {},
                bank: {},
                bank_account: {},

                banks: [],
                bank_branches: [],
                bank_account_types: [],
                taxations: [],
                selected_bank_account: null,
                AC_TYPES: AC_TYPES,
                bank_accounts: [],
                bank_transactions: [],
                //
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                is_initializing: false,
                processing: false,
                pagination: paginator(),
                bank_api: BANKING_BANKS_URL,
                bank_accounts_api: BANKING_ACCOUNTS_URL,
                bank_transactions_api: BANKING_TRANSACTIONS_URL,
                currency: ACCOUNTING.CURRENCY,
                report_options: null,
                import_transactions: {
                    date_range: 'All Transactions',
                    start_date: null,
                    end_date: null,
                }
            }
        },
        watch: {

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
            },

            "$route.query.type": function (id) {
                this.report_options.vat_report_name = id;
                this.report_type = id;
            },

            bank: function(){
                if(this.bank){
                    this.bank_account = this.bank;
                    this.loadBankTransactions(this.bank_account.id);
                }
            },

        },
        methods: {

            process_new_transactions(action_taken){
                this.processing = true;
                this.form.action_taken = action_taken;
                this.form.bank_account_id = this.bank_account.id;
                post(this.bank_transactions_api,this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.is_initializing = false;
                        this.$awn.success(res.data.description);
                        this.loadBankTransactions(this.bank_account.id);
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                        if(err.response.data.err_array.length){
                            this.form.transactions = [];
                            this.form.transactions = err.response.data.err_array;
                        }
                        this.processing = false;
                        this.is_initializing = false;
                    }else if (err.response.status === 500){
                        this.processing = false;
                        this.is_initializing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                    this.is_initializing = false;
                });
            },

            format_Money(money_to){
                return formatMoney(money_to);
            },
            reset_selection(event,global_index){
                this.selections_initilizer(event.target.value,global_index);
            },

            selections_initilizer(selectors,global_index){
                this.form.transactions[global_index].selections = [];
                this.form.transactions[global_index].selection = null;
                switch(selectors){
                    case AC_TYPES.CUSTOMER:
                        this.loadCustomer(global_index);
                        break;
                    case AC_TYPES.SUPPLIER:
                        this.loadSuplier(global_index);
                        break;
                    case AC_TYPES.ACCOUNT: //Load Company Chart of account
                        this.loadCoa(global_index);
                        break;
                    case AC_TYPES.TRANSFER: //Load the bank accounts
                        for (let index = 0; index < this.bank_accounts.length; index++) {
                            const element = this.bank_accounts[index];
                            if(element.id !== this.selected_bank_account.id){
                                let new_obj = {
                                    id: element.id,
                                    name: element.account_name,
                                }
                                this.form.transactions[global_index].selections.push(new_obj);
                            }
                        }
                        break;
                    case AC_TYPES.VAT:
                        break;
                }

            },

            remove_this(index_to){
                this.form.transactions.splice(index_to,1);
            },

            resetErr(global_index){
                this.form.transactions[global_index].error = false;
            },

            add_this(element_to){
                let new_element = create_bank_statement_transaction(element_to,this.filters.today)
                this.form.transactions.push(new_element);
            },

            toggleTab(cur_tab){
                this.curr_tab = cur_tab
                this.loadBankTransactions(this.bank_account.id);
            },

            check_all(event){
                this.form.selected_transactions = [];
                if(event.target.checked){
                    for (let index = 0; index < this.form.transactions.length; index++) {
                        let element = this.form.transactions[index];
                        this.form.selected_transactions.push(element.id);
                    }
                }else{
                    this.selected_banks = [];
                }
            },

            loadBankAccounts(){
                this.is_initializing = true;
                get(this.bank_accounts_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //console.info(res.data.results);
                        this.bank_accounts = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.is_initializing = false;
                        for (let index = 0; index < this.bank_accounts.length; index++) {
                            const element = this.bank_accounts[index];
                            if(element.is_default){
                                this.bank_account = element;
                                this.loadBankTransactions(this.bank_account.id);
                                break; 
                            }
                        }
                        this.page_loaded = true;
                        this.page_ready = true;
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

            showBankAccount(account_id,continue_=true){
                this.bank_transactions = [];
                this.is_initializing = true;
                this.processing = true;
                get(this.bank_accounts_api+'/'+account_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //console.info(res.data.results);
                        this.selected_bank_account = res.data.results;
                        this.bank_transactions = res.data.results.transaction.data;
                        if(!this.bank_transactions.length){
                            let empty_transaction = create_bank_statement_transaction();
                            empty_transaction.transaction_date = this.selected_bank_account.current_date;
                            this.form.transactions.push( empty_transaction );
                        }else{
                            this.form.transactions = this.bank_transactions;
                        }
                        if( continue_ ){ //No Bank Account was found to record transaction
                            //this.loadVAT();
                        }
                        // this.is_initializing = false;
                        // this.processing = false;
                        
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
                        this.is_initializing = false;
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                    this.processing = false;
                });
            },

            loadVAT(){
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results;
                        this.is_initializing = false;
                        this.processing = false;
                        //this.page_ready = true;
                        this.loadBankAccounts();
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

            loadCoa(global_index){
                get(CHART_OF_ACCOUNTS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        let chart_of_accounts = res.data.results.data;
                        for (let index = 0; index < chart_of_accounts.length; index++) {
                            const element = chart_of_accounts[index];
                            let new_obj = {
                                id: element.id,
                                name: element.name
                            }
                            this.form.transactions[global_index].selections.push(new_obj);
                        }
                    }
                }).catch((err) => {
                });
            },

            loadSuplier(global_index){
                get(SUPPLIER_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        let chart_of_accounts = res.data.results.data;
                        for (let index = 0; index < chart_of_accounts.length; index++) {
                            const element = chart_of_accounts[index];
                            let new_obj = {
                                id: element.id,
                                name: element.display_as
                            }
                            this.form.transactions[global_index].selections.push(new_obj);
                        }
                    }
                }).catch((err) => {
                });
            },

            loadCustomer(global_index){
                get(CUSTOMERS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        let chart_of_accounts = res.data.results.data;
                        for (let index = 0; index < chart_of_accounts.length; index++) {
                            const element = chart_of_accounts[index];
                            let new_obj = {
                                id: element.id,
                                name: element.display_as
                            }
                            this.form.transactions[global_index].selections.push(new_obj);
                        }
                    }
                }).catch((err) => {
                });
            },

            loadBanks(){
                get(BANKING_BANKS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.banks = res.data.results;
                        // this.is_initializing = false;
                        // this.processing = false;
                        this.loadBranches();
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

            loadBranches(){
                get(BANKING_BRANCHES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_branches = res.data.results;
                        // this.is_initializing = false;
                        // this.processing = false;
                        // this.progress_overlay = "hide";
                        // this.page_loaded = true;
                        // this.page_ready = true;
                        this.loadAccountType();
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

            loadAccountType(){
                get(BANKING_ACCOUNTS_TYPES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_account_types = res.data.results;
                        this.is_initializing = false;
                        this.processing = false;
                        this.progress_overlay = "hide";
                        this.page_loaded = true;
                        this.page_ready = true;
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
            },

            loadBankTransactions(bank_account_id){
                this.is_initializing = true;
                let new_api = BANKING_TRANSACTIONS_URL;
                if(this.curr_tab===0){
                    new_api = new_api+'?bank_account_id='+bank_account_id+'&status='+PROCESS_STATUS.REC_NOT_TICKED;
                }else if( this.curr_tab===1 ){
                    new_api = new_api+'?bank_account_id='+bank_account_id+'&status='+PROCESS_STATUS.REC_TICKED;
                }else{
                    new_api = new_api+'?bank_account_id='+bank_account_id+'&status='+PROCESS_STATUS.RECONCILED;
                }
                get(new_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_transactions = res.data.results.data;

                        if(this.curr_tab === 0){//New Transactions Tab
                            this.form.transactions = [];
                            for (let index = 0; index < this.bank_transactions.length; index++) {
                                const element = this.bank_transactions[index];
                                if(element.reference !== TRANSACTION_TYPES.OPENING_BALANCE){
                                    this.form.transactions.push( create_bank_statement_transaction(element,this.filters.today) )
                                }
                            }
                            this.form.transactions.push( create_bank_statement_transaction(null,this.filters.today) );
                        }else if(this.curr_tab === 1){
                            this.reviewed_form.transactions = [];
                            for (let index = 0; index < this.bank_transactions.length; index++) {
                                const element = this.bank_transactions[index];
                                if(element.reference !== TRANSACTION_TYPES.OPENING_BALANCE){
                                    this.reviewed_form.transactions.push( create_bank_statement_transaction(element,this.filters.today) )
                                }
                            }
                            console.info(this.reviewed_form.transactions);
                        }else{
                            this.reconciled_form.transactions = [];
                            for (let index = 0; index < this.bank_transactions.length; index++) {
                                const element = this.bank_transactions[index];
                                if(element.reference !== TRANSACTION_TYPES.OPENING_BALANCE){
                                    this.reviewed_form.transactions.push( create_bank_statement_transaction(element,this.filters.today) )
                                }
                            }
                        }
                        this.is_initializing = false;
                        this.page_ready = true;
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
            }
        },

        mounted() {
            this.report_type = this.$route.query.type;
            this.loadVAT();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>