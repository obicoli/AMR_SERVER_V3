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
                                                        Adjust Supplier Opening Balances
                                                    </a>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-20">
                                                    <div class="width-100-pc float-left mg-top-60 mg-bottom-50">
                                                        <!-- ======= -->
                                                    </div>
                                                    <copy-right></copy-right>
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
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../partials/CopyRight';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    // import Datepicker from 'vuejs-datepicker';
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../helpers/process_status";
    import {BANKING_ACCOUNTS_TYPES_URL} from '../../../../../router/api_routes';
    export default {
        name: "BankTransactions",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,
        ProcessingOverlay},
        data(){
            return {
                // curr_tab: 0,
                // form: {
                //     selected_transactions: [],
                //     transactions: [],
                //     action_taken: null,
                // },
                // reviewed_form: {
                //     transactions: [],
                // },
                // filters: {},
                // bank: {},
                // bank_account: {},

                // banks: [],
                // bank_branches: [],
                // bank_account_types: [],
                // taxations: [],
                // selected_bank_account: null,
                // AC_TYPES: AC_TYPES,
                // bank_accounts: [],
                // bank_transactions: [],
                //
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                is_initializing: false,
                processing: false,
                pagination: paginator(),
                // bank_api: BANKING_BANKS_URL,
                // bank_accounts_api: BANKING_ACCOUNTS_URL,
                // bank_transactions_api: BANKING_TRANSACTIONS_URL,
                // currency: ACCOUNTING.CURRENCY
            }
        },
        methods: {

        },

        mounted() {
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>