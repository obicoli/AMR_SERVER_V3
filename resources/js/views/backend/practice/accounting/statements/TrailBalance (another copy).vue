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

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <!-- <side-bar-statement :scrollable="false" :width="true" :transparent="true" :title="'Statements'" :active_num="'trail'"></side-bar-statement> -->
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">

                            <report-filter :title="'Ledger Report'"></report-filter>
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="mg-bottom-30 universal-grid padding-left-20 padding-right-20 max-width-900" role="grid">
                                        <div class="padding-top-10 padding-bottom-10 mg-top-30 padding-left-20 padding-right-20 reportArea">
                                            <report-heading v-if="page_loaded" :report_name="'Trail Balance'" :as_at="as_at" :facility_name="facility_name"></report-heading>
                                            <trail-view v-if="page_loaded" :ledgers="ledgers" :ACCOUNTING="ACCOUNTING"></trail-view>
                                        </div>
                                        <div class="width-100-pc text-center mg-top-30">
                                            <small v-if="page_loaded" class="fs-12 cl-888">Accrual basis {{as_at}}</small>
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
    import TrailView from "./partials/TrailView";
    import ReportHeading from "./partials/ReportHeading";
    import ReportFilter from "../partials/ReportFilter";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import SupplierModal from '../../partials/modals/vendors/SupplierModal';
    import {PURCHASES_URL,PURCHASES_FACILITY_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_SUPPLY,PRODUCT_REQUISITIONS} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING} from '../../../../../helpers/process_status';
    import {ACCOUNTS_TRAIL,ACCOUNTS_INITIALS} from "../../../../../router/api_routes";
    export default {
        name: "TrailBalance",
        components: {TopNavBar,SideBar,SideBarStatement,ProcessingOverlay,CommonLink,ReportFilter,TrailView,ReportHeading},
        data(){
            return {
                initialUrl: ACCOUNTS_TRAIL,
                ACCOUNTING:ACCOUNTING,
                practice_id: '',
                facility_name: '',
                progress_overlay: 'hide',
                page_loaded: false,
                ledgers: [],
                as_at: '',
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            loadTrail(){
                this.progress_overlay = "show";
                get(this.initialUrl)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.ledgers = res.data.results.data;
                        console.info(this.ledgers);
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
            this.loadTrail();
        }
    }
</script>

<style scoped>
.table td{
    vertical-align: top;
    border-top: 0px transparent solid;
}
</style>

