<template>
    <div class=" width-100-pc float-left">
        <!-- =============================OUTPUT - TABS========================= -->
        <div class="width-100-pc float-left mg-top-45 bg-white padding-20">
            <table class="table banking-transaction-vat-reports table-hover mg-bottom-20">        
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
                <tbody v-if="tax_return.total_output_transactions">
                    <tr>
                        <td class="somepad cl-amref fw-600 no-bottom-bd fs-16" colspan="8">Output Tax</td>
                    </tr>
                </tbody>
                <tbody v-for="(transaction,index) in tax_return.transactions" :key="'transactions_output_'+index">
                    <tr v-if="transaction.output_tax.length && index>0">
                        <td class="somepad cl-444 fw-600 tr-separator" colspan="8"></td>
                    </tr>
                    <tr v-if="transaction.output_tax.length">
                        <td class="somepad cl-444 fw-600 sub-header-dark bd-right bd-left" colspan="8">{{transaction.display_as}} - Output Tax</td>
                    </tr>
                    <tr v-for="(output_transaction,index_trs) in transaction.output_tax" :key="'index_trs_'+index_trs">
                        <td v-bind:class="{'somepad bd-left':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.trans_date}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">
                            <span>{{output_transaction.creditor_debtor_account.legal_name}}</span>
                        </td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.trans_number}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.description}}</td>
                        <td v-bind:class="{'somepad bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.vat_period}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{format_money(output_transaction.exclusive)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{format_money(output_transaction.inclusive)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{format_money(output_transaction.vat_amount)}}</td>
                    </tr>
                    <tr class="notes" v-if="transaction.output_tax.length">
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="5">
                            Sales and Output Tax on Sales for the period {{tax_return.vat_period+' ( '+transaction.display_as+' )'}}
                        </td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="3"></td>
                    </tr>
                    <tr v-if="transaction.output_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd bd-right" colspan="5">Total Sales and VAT to customers registered for VAT:&nbsp;&nbsp;{{currency}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_customer_excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_customer_incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_customer_vat_total)}}</td>
                    </tr>
                    <tr v-if="transaction.output_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total Sales and VAT to customers not registered for VAT:&nbsp;&nbsp;{{currency}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_customer_excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_customer_incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right no-bottom-bd">{{format_money(transaction.int_customer_vat_total)}}</td>
                    </tr>
                    <tr v-if="transaction.output_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total for {{transaction.name+' '+transaction.category}}:&nbsp;&nbsp;{{currency}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(transaction.excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(transaction.incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right">{{format_money(transaction.vat_total)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- =============================INPUT - TABS========================= -->
        <div class="width-100-pc float-left mg-top-20 bg-white padding-20">
            <table class="table banking-transaction-vat-reports table-hover mg-bottom-20">        
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
                <!-- ------------ -->
                <!-- Inputs Tax Block | Detailed -->
                <tbody v-if="tax_return.total_input_transactions">
                    <tr>
                        <td class="somepad cl-amref fw-600 no-bottom-bd fs-16" colspan="8">Input Tax</td>
                    </tr>
                </tbody>
                <tbody v-for="(transaction,index) in tax_return.transactions" :key="'transactions_input_'+index">
                    <tr v-if="transaction.input_tax.length && index>0">
                        <td class="somepad cl-444 fw-600 tr-separator" colspan="8"></td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 fw-600 sub-header-dark bd-right bd-left" colspan="8">{{transaction.display_as}} - Input Tax</td>
                    </tr>
                    <tr v-for="(input_transaction,index_trs) in transaction.input_tax" :key="'index_trs_'+index_trs">
                        <td v-bind:class="{'somepad bd-left':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_date}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.creditor_debtor_account.legal_name}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_number}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.description}}</td>
                        <td v-bind:class="{'somepad bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.vat_period}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.exclusive)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.inclusive)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.vat_amount)}}</td>
                    </tr>
                    <tr class="notes" v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="5">
                            Puchase and Input Tax on Purchase for the period {{tax_return.vat_period+' ( '+transaction.display_as+' )'}}
                        </td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="3"></td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd bd-right" colspan="5">Total purchases from Suppliers registered for VAT(Local):&nbsp;&nbsp;</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{currency+' '+format_money(transaction.loc_supplier_excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{currency+' '+format_money(transaction.loc_supplier_incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{currency+' '+format_money(transaction.loc_supplier_vat_total)}}</td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total purchases from Suppliers not registered for VAT(Import):&nbsp;&nbsp;{{currency}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{currency+' '+format_money(transaction.int_supplier_excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{currency+' '+format_money(transaction.int_supplier_incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right no-bottom-bd">{{currency+' '+format_money(transaction.int_supplier_vat_total)}}</td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total for {{transaction.name+' '+transaction.category}}:&nbsp;&nbsp;</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{currency+' '+format_money(transaction.excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{currency+' '+format_money(transaction.incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right">{{currency+' '+format_money(transaction.vat_total)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- =============================OUTPUT SUMMARY - TABS========================= -->
        <div class="width-100-pc float-left mg-top-20 bg-white padding-20">
            <table class="table banking-transaction-vat-reports table-hover mg-bottom-20">        
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
                <!-- ------------ -->
                <!-- Inputs Tax Block | Detailed -->
                <tbody v-if="tax_return.total_input_transactions">
                    <tr>
                        <td class="somepad cl-amref fw-600 no-bottom-bd fs-16" colspan="8">Input Tax</td>
                    </tr>
                </tbody>
                <tbody v-for="(transaction,index) in tax_return.transactions" :key="'transactions_input_'+index">
                    <tr v-if="transaction.input_tax.length && index>0">
                        <td class="somepad cl-444 fw-600 tr-separator" colspan="8"></td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 fw-600 sub-header-dark bd-right bd-left" colspan="8">{{transaction.display_as}} - Input Tax</td>
                    </tr>
                    <tr v-for="(input_transaction,index_trs) in transaction.input_tax" :key="'index_trs_'+index_trs">
                        <td v-bind:class="{'somepad bd-left':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_date}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.creditor_debtor_account.legal_name}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_number}}</td>
                        <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.description}}</td>
                        <td v-bind:class="{'somepad bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.vat_period}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.exclusive)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.inclusive)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.vat_amount)}}</td>
                    </tr>
                    <tr class="notes" v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="5">
                            Puchase and Input Tax on Purchase for the period {{tax_return.vat_period+' ( '+transaction.display_as+' )'}}
                        </td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="3"></td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd bd-right" colspan="5">Total purchases from Suppliers registered for VAT(Local):&nbsp;&nbsp;</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{currency+' '+format_money(transaction.loc_supplier_excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{currency+' '+format_money(transaction.loc_supplier_incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{currency+' '+format_money(transaction.loc_supplier_vat_total)}}</td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total purchases from Suppliers not registered for VAT(Import):&nbsp;&nbsp;{{currency}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{currency+' '+format_money(transaction.int_supplier_excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{currency+' '+format_money(transaction.int_supplier_incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right no-bottom-bd">{{currency+' '+format_money(transaction.int_supplier_vat_total)}}</td>
                    </tr>
                    <tr v-if="transaction.input_tax.length">
                        <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total for {{transaction.name+' '+transaction.category}}:&nbsp;&nbsp;</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{currency+' '+format_money(transaction.excl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{currency+' '+format_money(transaction.incl_total)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right">{{currency+' '+format_money(transaction.vat_total)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ============================= SALES SUMMARY - TABS========================= -->
        <div class="width-100-pc float-left mg-top-20 bg-white padding-20">
            <table v-if="tax_return.total_output_transactions" class="table banking-transaction-vat-reports table-hover mg-bottom-20">
                <thead>
                    <tr>
                        <th colspan="4" class="somepad cl-444 fw-600 sub-header-amref text-center">Sales(Goods and Services)</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style="width:55%;" class="somepad-1 fw-600 text-right">Details of Sales</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Exclusive(KES)</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Inclusive(KES)</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Output VAT(KES)</th>
                    </tr>
                </thead>
                <tbody v-for="(transa,indexs) in tax_return.transactions" :key="'indexs_'+indexs">
                    <tr v-if="transa.output_tax.length">
                        <td v-bind:class="{'somepad bd-left text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">
                            <span v-if="transa.sales_rate > 0">Taxable Sales ({{transa.name}})</span>
                            <span v-else>Sales ({{transa.name}})</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.excl_total)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.incl_total)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.vat_total)}}</td>
                        
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td class="somepad cl-444 text-right no-bottom-bd fw-600">Total Output VAT</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_sales_excl)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_sales_incl)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right">{{format_money(tax_return.total_output_tax)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ============================= PURCHASE SUMMARY - TABS========================= -->
        <div class="width-100-pc float-left mg-top-20 bg-white padding-20">
            <table v-if="tax_return.total_input_transactions" class="table banking-transaction-vat-reports table-hover mg-bottom-20">
                <thead>
                    <tr>
                        <th colspan="4" class="somepad cl-444 fw-600 sub-header-amref text-center">Purchases(Goods and Services)</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style="width:55%;" class="somepad-1 fw-600 text-right">Details of Purchases</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Exclusive(KES)</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Inclusive(KES)</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Input VAT (KES)</th>
                    </tr>
                </thead>
                <tbody v-for="(transa,indexs) in tax_return.transactions" :key="'indexs_'+indexs">
                    <tr v-if="transa.input_tax.length">
                        <td v-bind:class="{'somepad bd-left text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">
                            <span v-if="transa.purchase_rate > 0">Taxable Purchases ({{transa.name}})</span>
                            <span v-else>Purchases ({{transa.name}})</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.excl_total)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.incl_total)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.vat_total)}}</td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td class="somepad cl-444 text-right no-bottom-bd fw-600">Total Input VAT</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_purchases_excl)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_purchases_incl)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right">{{format_money(tax_return.total_input_tax)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ============================= SUMMARY - TABS========================= -->
        <div class="width-100-pc float-left mg-top-20 bg-white padding-20">
            
            <table v-if="tax_return.total_input_transactions" class="table banking-transaction-vat-reports table-hover mg-bottom-20">
                <thead>
                    <tr>
                        <th colspan="4" class="somepad cl-444 fw-600 sub-header-amref text-center">VAT Summary</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style="width:55%;" class="somepad-1 fw-600 text-right">Summary of VAT Due</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Exclusive(KES)</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Inclusive(KES)</th>
                        <th style="width:15%" class="somepad-1 fw-600 text-right">Input VAT (KES)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Output VAT</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.vat_output)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Input VAT</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.vat_input)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>VAT Claimable on service imported into Kenya</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.vat_claimable_on_import)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Input VAT attributable to Only Exempt Supplies</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.input_vat_on_exempt_supply)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Input VAT attributable to Taxable and Exempt Supplies</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.input_vat_on__taxable_and_exempt_supply)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd fw-600':true}">
                            <span>Non-Deductible Input VAT</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd fw-600':true}">{{format_money(tax_return.period_summary.vat_input_non_deductible)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd fw-600':true}">
                            <span>Deductible Input VAT</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd fw-600':true}">{{format_money(tax_return.period_summary.vat_input_deductible)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd fw-600':true}">
                            <span>VAT Payable/Credit Due for the Period</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd fw-600':true}">{{format_money(tax_return.period_summary.vat_payable_credit_due)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Credit Brought forward from Previous month</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.credit_brought_forward)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Total Withholding VAT Credit</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.total_vat_withholding)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Refund Claim Logged</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(tax_return.period_summary.refund_claim_logged)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd fw-600':true}">
                            <span>Total VAT Payable</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd fw-600':true}">{{currency+' '+format_money(tax_return.period_summary.vat_payable)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Total VAT Paid</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{currency+' '+format_money(tax_return.period_summary.total_vat_paid)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right no-bottom-bd':true}">
                            <span>Total Credit Adjustment/Inventory Approval Order/Adjustment Voucher</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right no-bottom-bd':true}">{{currency+' '+format_money(tax_return.period_summary.total_adjustments)}}</td>
                    </tr>
                    <tr>
                        <td v-bind:class="{'somepad bd-left text-right bd-right':true}">
                            <span>Total Debit Adjustment Voucher</span>
                        </td>
                        <td v-bind:class="{'somepad text-right bd-right fw-600':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right fw-600':true}">{{format_money(0)}}</td>
                        <td v-bind:class="{'somepad text-right bd-right fw-600':true}">{{currency+' '+format_money(tax_return.period_summary.total_debit_adjustments)}}</td>
                    </tr>
                </tbody>

                <tbody>
                    <tr>
                        <td class="somepad cl-444 text-right no-bottom-bd fw-600">Net VAT Payable / Credit Carried Forward</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_purchases_excl)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_purchases_incl)}}</td>
                        <td class="somepad cl-444 fw-600 text-right bd-right">{{currency+' '+format_money(tax_return.period_summary.net_vat_payable)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
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