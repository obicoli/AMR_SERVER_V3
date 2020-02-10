<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="false"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-right app-header width-80-pc">
                                    <common-link :active_link="'statements'"></common-link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <!-- <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-statement :scrollable="false" :width="true" :transparent="true" :title="'Statements'" :active_num="'journal'"></side-bar-statement>
                        </div> -->

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">

                            <report-filter :title="'Journal Report'"></report-filter>
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="mg-bottom-30 universal-grid padding-left-20 padding-right-20 max-width-1000" role="grid">

                                        <div class="padding-top-10 padding-bottom-10 mg-top-30 padding-left-20 padding-right-20 reportArea">
                                            <div class="text-center mg-top-20 mg-bottom-20">
                                                <span class="fs-12">{{facility_name}}</span><br>
                                                <div class="reportName">General Journal</div><br>
                                                <small v-if="page_loaded" class="fs-12">{{as_at}}</small>
                                            </div>
                                            <div class="">
                                                <table class="table statement-reports table-hover">
                                                    <tr>
                                                        <th style="width:14%;">Date</th>
                                                        <th style="width:10%;" class="dotted-left">Transaction</th>
                                                        <th style="width:10%;" class="dotted-left">No</th>
                                                        <th style="width:14%;" class="dotted-left">Name</th>
                                                        <!-- <th style="width:15%;" class="dotted-left">Memo/Description</th> -->
                                                        <th style="width:24%;" class="dotted-left">Account</th>
                                                        <th style="width:14%;" class="dotted-left text-right">Debit</th>
                                                        <th style="width:14%;" class="dotted-left text-right">Credit</th>
                                                    </tr>

                                                    <tbody v-for="(journal,index) in journals" :key="'journals'+index">
                                                        
                                                        <tr v-for="(ledger,index_l) in journal" class="body" :key="'index_l'+index_l">
                                                            <td>
                                                                <a v-if="ledger.balance_type===ACCOUNTING.DEBIT">{{ledger.trans_date}}</a>
                                                            </td>
                                                            <td>
                                                                <a v-if="ledger.balance_type===ACCOUNTING.DEBIT">{{ledger.trans_type}}</a>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <a>{{ledger.custom_name}}</a>
                                                            </td>
                                                            <td class="text-right">
                                                                <a v-if="ledger.balance_type===ACCOUNTING.DEBIT">Ksh{{format_money(ledger.amount)}}</a>
                                                            </td>
                                                            <td class="text-right">
                                                                <a v-if="ledger.balance_type===ACCOUNTING.CREDIT">Ksh{{format_money(ledger.amount)}}</a>
                                                            </td>
                                                        </tr>

                                                        <tr class="sub-total body">
                                                            <td style="font-style: italic;" colspan="5" class="fw-600 fs-12">{{journal[0].trans_description}}</td>
                                                            <td class="sub-total text-right">Ksh{{format_money( sub_total(journal,ACCOUNTING.DEBIT) )}}</td>
                                                            <td class="sub-total text-right">Ksh{{format_money(sub_total(journal,ACCOUNTING.CREDIT))}}</td>
                                                        </tr>
                                                    </tbody>

                                                    <tfoot>
                                                        <tr class="total">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-right fw-600 fs-14 txt-uppercase">TOTAL</td>
                                                            <td class="total text-right">Ksh{{format_money(total_values(journals,ACCOUNTING.DEBIT))}}</td>
                                                            <td class="total text-right">Ksh{{format_money(total_values(journals,ACCOUNTING.CREDIT))}}</td>
                                                        </tr>
                                                    </tfoot>

                                                </table>

                                            </div>
                                        </div>
                                        

                                        <div class="width-100-pc text-center mg-top-30">
                                            <small v-if="page_loaded" class="fs-12 cl-888">{{as_at}}</small>
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
    import SideBarStatement from "../../partials/sidebars/accounting/SideBarStatement";
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
    import CommonLink from "../../partials/sidebars/accounting/CommonLink";
    import ReportFilter from "../partials/ReportFilter";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import SupplierModal from '../../partials/modals/vendors/SupplierModal';
    import {PURCHASES_URL,PURCHASES_FACILITY_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_SUPPLY,PRODUCT_REQUISITIONS} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING} from '../../../../../helpers/process_status';
    import {ACCOUNTS_JOURNAL,ACCOUNTS_INITIALS} from "../../../../../router/api_routes";
    export default {
        name: "Journal",
        components: {TopNavBar,SideBar,SideBarStatement,ProcessingOverlay,CommonLink,ReportFilter},
        data(){
            return {
                initialUrl: ACCOUNTS_JOURNAL,
                ACCOUNTING:ACCOUNTING,
                practice_id: '',
                facility_name: '',
                progress_overlay: 'hide',
                page_loaded: false,
                journals: [],
                as_at: '',
                accounting_initials: [],
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
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

            total_values(journal,account_side){
                let total = 0;
                for (let index = 0; index < journal.length; index++) {
                    const element = journal[index];
                    for (let index = 0; index < element.length; index++) {
                        const element_child = element[index];
                        switch (account_side) {
                            case ACCOUNTING.DEBIT:
                                if(element_child.balance_type === ACCOUNTING.DEBIT){
                                    total+= element_child.amount;
                                }
                                break;
                            default: //Credit side
                                if(element_child.balance_type === ACCOUNTING.CREDIT){
                                    total+= element_child.amount;
                                }
                                break;
                        }
                    }
                }
                return total;
            },

            loadJournal(){
                this.progress_overlay = "show";
                get(this.initialUrl)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.journals = res.data.results.data;
                        //console.info(this.journals);
                        this.as_at = res.data.results.as_at;
                        this.page_loaded = true;
                        this.progress_overlay = "hide";
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            format_money(money_to){
                return formatMoney(money_to);
            }
            
        },
        mounted() {
            let facility = Auth.getCurrentAccount('clinic');
            this.branch_id = facility.id;
            this.practice_id = facility.id;
            this.facility_name = facility.name;
            this.loadJournal();
        }
    }
</script>

<style scoped>
.table td{
    vertical-align: top;
    border-top: 0px transparent solid;
}
</style>

