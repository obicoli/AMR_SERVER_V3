<template>
    <div class=" width-100-pc float-left">
        
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