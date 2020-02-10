<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">Inventory | Sales Transactions</div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35 justify-content-center">
                        <!-- <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-bill v-if="page_loaded" :scrollable="false" :width="true" :transparent="true" :hr_role="hr_roles" :active_num="10"></side-bar-bill>
                        </div> -->
                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    <div class="pull pull-left width-80-pc">
                                        <div class="filters width-100-pc">
                                            <!-- <div class="filter-block form-inline width-40-pc pull-left text-right">
                                                <span class="name">Status: </span>
                                                <div class="filter-group input-group">
                                                    <span class="filter active">All</span>
                                                    <span class="filter">Pending</span>
                                                    <span class="filter">Open</span>
                                                    <span class="filter">Partial</span>
                                                    <span class="filter">Closed</span>
                                                </div>
                                            </div> -->
                                            <div class="filter-block form-inline width-100-pc pull-left text-right">
                                                <span class="name">Type: </span>
                                                <div class="filter-group input-group">
                                                    <span class="filter active">All</span>
                                                    <span class="filter ng-binding">Estimate</span>
                                                    <span class="filter">Invoice</span>
                                                    <span class="filter">Payment</span>
                                                    <span class="filter">Receipt</span>
                                                    <span class="filter">Credit Note</span>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#add_bill_modal" type="button" class="btn combo-button primary">+ New Transaction</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu right-0" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#invoice_modal_id"> Invoice</a>
                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#payment_modal_id"> Payment</a>
                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#estimate_modal_id"> Estimate</a>
                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#sale_receipt_modal_id"> Sales Receipt</a>
                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#credit_note_modal_id"> Credit Note</a>
                                            </div>
                                        </div>
                                    </div>
                                    <invoice-modal :modal_id="'invoice_modal_id'" :modal_title="'Invoice'" :practice_id="practice_id"></invoice-modal>
                                    <estimate-modal :modal_id="'estimate_modal_id'" :modal_title="'Estimate'" :practice_id="practice_id"></estimate-modal>
                                    <sales-receipt-modal :modal_id="'sale_receipt_modal_id'" :modal_title="'Sales Receipt'" :practice_id="practice_id"></sales-receipt-modal>
                                    <credit-note-modal :modal_id="'credit_note_modal_id'" :modal_title="'Credit Note'" :practice_id="practice_id"></credit-note-modal>
                                    <payment-modal :modal_id="'payment_modal_id'" :modal_title="'Receive Payment'" :practice_id="practice_id"></payment-modal>
                                    <supplier-modal v-if="is_page_ready" :modal_id="'new_vendor_modal_id'" :user_mode="'Create'" :title="''"></supplier-modal>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">


                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">

                                        <sales-table></sales-table>

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
    import SideBarBill from "../../partials/sidebars/SideBarBill";
    import {get} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import DeleteModal from '../../partials/modals/DeleteModal';
    import InvoiceModal from '../../partials/modals/product/InvoiceModal';
    import EstimateModal from '../../partials/modals/product/EstimateModal';
    import SalesReceiptModal from '../../partials/modals/product/SalesReceiptModal';
    import CreditNoteModal from '../../partials/modals/product/CreditNoteModal';
    import PaymentModal from '../../partials/modals/product/PaymentModal';
    import SalesTable from '../../partials/tables/SalesTable';
    import SupplierModal from '../../partials/modals/vendors/SupplierModal';
    import {formatMoney} from "../../../../../helpers/functionmixin";
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarBill,DeleteModal,SalesTable,InvoiceModal,
        EstimateModal,SalesReceiptModal,CreditNoteModal,PaymentModal,SupplierModal},
        data(){
            return {
                employees_list: [],
                initial_url: '/api/practices/departments',
                branch_id: '',
                practice_id: '',
                processing: false,
                page_loaded: false,
                hr_roles: [],
                system_permissions: [],
                department_form: {
                    name: '',
                    description: '',
                    branch_id: '',
                    status: '',
                },
                user_form: {
                    role_name: '',
                    first_name: '',
                    other_name: '',
                    email: '',
                    mobile: '',
                    gender: '',
                    password: '',
                    status: '',
                    address: '',
                    branch_id: '',
                },
                role_form: {
                    name: '',
                    description: '',
                    branch_id: '',
                    status: '',
                },
            }
        },
        methods: {

            loadUsers() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.branch_id+'/'+'Human Resource')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.employees_list = res.data.results.resources;
                            this.processing = false;
                            //console.info(this.employees_list )
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
            loadHrs() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/roles/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.hr_roles = res.data.results;
                            this.processing = false;
                            console.info(this.hr_roles);
                            this.page_loaded = true;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
            load_Hr() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/roles/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.hr_roles = res.data.results;
                            this.processing = false;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.branch_id = Auth.getCurrentAccount('id');
            this.user_form.branch_id = this.branch_id;
            this.page_loaded = true;
        }
    }
</script>

