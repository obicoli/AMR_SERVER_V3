<template>

    <div>

        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                    <side-bar-settings :scrollable="true" :width="true" :transparent="true" :billing="true"></side-bar-settings>
                </div>

                <div class="col-md-10 col-lg-10 col-sm-10 padding-left-0">
                    <div class="settings-header main-heading bg-foo">Settings | Billing</div>
                    <div class="ui fitted divider"></div>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="mg-top-20 width-40-pc float-left text-right padding-left-20 mg-right-10">
                                <div class="filter-block form-inline float-left">
                                    <div class="filter-group input-group">
                                        <span @click="toggleContent(0)" v-bind:class="{'filter':true,'filter-custom':active_tab===0}">Tax Catalog</span>
                                        <span @click="toggleContent(1)" v-bind:class="{'filter':true,'filter-custom':active_tab===1}">Payment modes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mg-top-20 width-40-pc float-right mg-right-10">

                                <div v-if="active_tab===0" class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                    <button data-toggle="modal" data-target="#taxModal" type="button" class="btn combo-button primary">Add Tax</button>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu pull-left" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item" href="#">Import taxes</a>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="active_tab===1"  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                    <button data-toggle="modal" data-target="#paymentModal" type="button" class="btn combo-button primary">Add Payment</button>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop2" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu pull-left" aria-labelledby="btnGroupDrop2">
                                            <a class="dropdown-item" href="#">Import payment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="page_loaded && active_tab===0" class="col-lg-12">

                            <div v-if="account_taxes.length===0"  class="text-center mg-top-30 place-icons">
                                <a data-toggle="modal" data-target="#taxModal">
                                    <img :src="'/assets/images/tax_icon.jpg'">
                                </a>
                                <p>You do not have any tax in your records</p>
                            </div>

                            <div v-if="account_taxes.length > 0" class="box box-primary border-top-0 border-bottom-0 no-shadowed">


                                <div class="page-content bg-white min-height-100-vh padding-right-20 padding-left-20 padding-top-20 padding-bottom-20">

                                    <div class="padding-10">

                                        <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">

                                            <div class="dgrid-header dgrid-header-row ui-widget-header sticky-header" role="row">
                                                <table class="dgrid-row-table dgrid-row-table-custom" role="presentation">
                                                    <tr>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-1 field-nameEditable" role="columnheader">
                                                            <div class="dgrid-resize-header-container">
                                                                Tax Name
                                                                <!--                                                                <div class="dgrid-resize-handle resizeNode-1"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type dgrid-sortable dgrid-focus" role="columnheader" aria-sort="none" tabindex="0">
                                                            <div class="dgrid-resize-header-container" tabindex="0">
                                                                Collected on Sales
                                                                <!--                                                                <div class="dgrid-resize-handle resizeNode-2"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-3 field-detailType" role="columnheader">
                                                            <div class="dgrid-resize-header-container">
                                                                Collected on Purchases
                                                                <!--                                                                <div class="dgrid-resize-handle resizeNode-3"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-5 field-bankBalance dgrid-sortable" role="columnheader" aria-sort="none">
                                                            <div class="dgrid-resize-header-container" tabindex="0">
                                                                Description
                                                                <!--                                                                <div class="dgrid-resize-handle resizeNode-5"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-5 field-bankBalance dgrid-sortable" role="columnheader" aria-sort="none">
                                                            <div class="dgrid-resize-header-container" tabindex="0">
                                                                <!--                                                                <div class="dgrid-resize-handle resizeNode-5"></div>-->
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="dgrid-scroller" tabindex="-1" style="user-select: text; margin-top: 36px; margin-bottom: 35px;">
                                                <div class="dgrid-content ui-widget-content">
                                                    <div role="row" class=" dgrid-row dgrid-row-even ui-state-default">
                                                        <table class="dgrid-row-table table-hover-tr table-hover" role="presentation">
                                                            <tbody>
                                                            <tr v-for="(taxes,index) in account_taxes">
                                                                <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name bottom-dotted" role="gridcell" tabindex="0">
                                                                    <div>{{taxes.name}}</div>
                                                                </td>
                                                                <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type bottom-dotted left-dotted" role="gridcell">
                                                                    <span v-if="taxes.collected_on_sales">{{taxes.sales_rate}}%</span>
                                                                    <span v-else>N/A</span>
                                                                </td>
                                                                <td class="dgrid-cell dgrid-cell-padding dgrid-column-3 field-detailType bottom-dotted left-dotted" role="gridcell">
                                                                    <span v-if="taxes.collected_on_purchase">{{taxes.purchase_rate}}%</span>
                                                                    <span v-else>N/A</span>
                                                                </td>
                                                                <td class="dgrid-cell dgrid-cell-padding dgrid-column-4 field-detailType bottom-dotted left-dotted" role="gridcell">
                                                                    <span v-if="taxes.status">Active</span>
                                                                    <span v-else>Inactive</span>
                                                                </td>
                                                                <td class="bottom-dotted left-dotted">
                                                                    <a data-toggle="modal" :data-target="'#taxModal_'+index" class="showOnHover"><i class="fa fa-edit"></i></a>
                                                                    <a data-toggle="modal" :data-target="'#delete_tax_modal_'+index" class="showOnHover"><i class="fa fa-trash-o"></i></a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div v-for="(taxesy, indexs) in account_taxes">
                                    <div class="modal fade" :id="'delete_tax_modal_'+indexs">
                                        <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                            <delete-stuff-modal :modal_title="'Delete Tax'" :confirm_message="'Are you sure?'" :item_url="initial_url_tax+'/'+taxesy.id" v-on:deletionSuccessful="load_Tax"></delete-stuff-modal>
                                        </div>
                                    </div>
                                    <tax-modal v-if="page_loaded" :form_data="taxesy" :initial_url="initial_url_tax+'/'+taxesy.id" :user_mode="'Edit'" :practice_id="practice_id" v-on:taxEdited="load_Tax" :title="'Edit Tax'" :modal_id="'taxModal_'+indexs"></tax-modal>
                                </div>



                            </div>
                        </div>

                        <div v-if="page_loaded && active_tab===1" class="col-lg-12">

                            <div v-if="account_payment_methods.length===0"  class="text-center mg-top-30">
                                <p>You dont have any payment method</p>
                                <a data-toggle="modal" data-target="#paymentModal" class="btn btn-inventory primary cl-white">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Setup here
                                </a>
                            </div>

                            <div v-if="account_payment_methods.length > 0" class="box box-primary border-top-0 border-bottom-0 no-shadowed">

                                <div class="page-content bg-white min-height-100-vh padding-right-20 padding-left-20 padding-top-20 padding-bottom-20">

                                    <div class="padding-10">

                                        <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">

                                            <div class="dgrid-header dgrid-header-row ui-widget-header sticky-header" role="row">
                                                <table class="dgrid-row-table dgrid-row-table-custom" role="presentation">
                                                    <tr>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-1 field-nameEditable" role="columnheader">
                                                            <div class="dgrid-resize-header-container">
                                                                Mode Name
<!--                                                                <div class="dgrid-resize-handle resizeNode-1"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type dgrid-sortable dgrid-focus" role="columnheader" aria-sort="none" tabindex="0">
                                                            <div class="dgrid-resize-header-container" tabindex="0">
                                                                Type
<!--                                                                <div class="dgrid-resize-handle resizeNode-2"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-3 field-detailType" role="columnheader">
                                                            <div class="dgrid-resize-header-container">
                                                                Vendor Fee (%)
<!--                                                                <div class="dgrid-resize-handle resizeNode-3"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-5 field-bankBalance dgrid-sortable" role="columnheader" aria-sort="none">
                                                            <div class="dgrid-resize-header-container" tabindex="0">
                                                                Status
<!--                                                                <div class="dgrid-resize-handle resizeNode-5"></div>-->
                                                            </div>
                                                        </th>
                                                        <th class="dgrid-cell dgrid-cell-padding dgrid-column-5 field-bankBalance dgrid-sortable" role="columnheader" aria-sort="none">
                                                            <div class="dgrid-resize-header-container" tabindex="0">
<!--                                                                <div class="dgrid-resize-handle resizeNode-5"></div>-->
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="dgrid-scroller" tabindex="-1" style="user-select: text; margin-top: 36px; margin-bottom: 35px;">
                                                <div class="dgrid-content ui-widget-content">
                                                    <div role="row" class=" dgrid-row dgrid-row-even ui-state-default">
                                                        <table class="dgrid-row-table table-hover-tr table-hover" role="presentation">
                                                            <tbody>
                                                                <tr v-for="(pay_meth,index) in account_payment_methods">
                                                                    <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name bottom-dotted" role="gridcell" tabindex="0">
                                                                        <div>{{pay_meth.name}}</div>
                                                                    </td>
                                                                    <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type bottom-dotted left-dotted" role="gridcell">
                                                                        {{pay_meth.payment_type}}
                                                                    </td>
                                                                    <td class="dgrid-cell dgrid-cell-padding dgrid-column-3 field-detailType bottom-dotted left-dotted" role="gridcell">
                                                                        {{pay_meth.vendor_fee}}
                                                                    </td>
                                                                    <td class="dgrid-cell dgrid-cell-padding dgrid-column-4 field-detailType bottom-dotted left-dotted" role="gridcell">
                                                                        <span v-if="pay_meth.status">Active</span>
                                                                        <span v-else>Inactive</span>
                                                                    </td>
                                                                    <td class="bottom-dotted left-dotted">
                                                                        <a data-toggle="modal" :data-target="'#paymentModal_'+index" class="showOnHover"><i class="fa fa-edit"></i></a>
                                                                        <a data-toggle="modal" :data-target="'#delete_payment_modal_'+index" class="showOnHover"><i class="fa fa-trash-o"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div v-for="(pays, indexs) in account_payment_methods">
                                    <div class="modal fade" :id="'delete_payment_modal_'+indexs">
                                        <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                            <delete-stuff-modal :modal_title="'Delete Payment'" :confirm_message="'Are you sure?'" :item_url="initial_url_payment+'/'+pays.id" v-on:deletionSuccessful="load_Pay"></delete-stuff-modal>
                                        </div>
                                    </div>
                                    <payment-modal v-if="page_loaded" :modal_id="'paymentModal_'+indexs" :initial_url="initial_url_payment+'/'+pays.id" :user_mode="'Edit'" :practice_id="practice_id" :form_data="pays" :title="'Edit Payment Mode'" v-on:payEdited="load_Pay"></payment-modal>
                                </div>


                            </div>
                        </div>
                    </div>

                    <payment-modal v-if="page_loaded" :modal_id="'paymentModal'" :title="'Add New Payment Mode'" :initial_url="initial_url_payment" :user_mode="'Create'" :practice_id="practice_id" v-on:payAdded="load_Pay"></payment-modal>

                    <tax-modal v-if="page_loaded" :initial_url="initial_url_tax" :user_mode="'Create'" :practice_id="practice_id" v-on:taxAdded="load_Tax" :title="'Add New Tax'" :modal_id="'taxModal'"></tax-modal>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarSettings from "../partials/sidebars/SideBarSettings";
    import DeleteStuffModal from "../../pharmacy/patials/DeleteStuffModal";
    import TaxModal from "../partials/modals/TaxModal";
    import PaymentModal from "../partials/modals/PaymentModal";
    import {get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";

    export default {
        name: "Billing",
        components: {PaymentModal, TopNavBar, SideBar,SideBarSettings,TaxModal,DeleteStuffModal},
        data(){
            return {
                default_mode: 'Create',
                tax: {},
                account_taxes: [],
                account_payment_methods: [],
                current_branch: {},
                initial_url_tax: '/api/products/taxes',
                initial_url_payment: '/api/products/payment_methods',
                practice_id: '',
                processing: false,
                page_loaded: false,
                active_tab: 0,
            }
        },
        methods: {

            toggleContent(num_){
                this.active_tab = num_;
            },

            edit_tax(tax_){
                this.tax = {};
                this.tax = tax_;
                this.default_mode = "Edit";
                this.toggleModals('tax_modal','show')
            },

            // toggleModals(modal_name,modal_action){
            //     switch(modal_action){
            //         case "show":
            //             if(modal_name==="tax_modal"){
            //                 document.getElementById("taxModal").style.width = "100%";
            //                 document.getElementById("taxModal").style.left = "0";
            //             }else{
            //
            //             }
            //             break;
            //         case "hide":
            //             if(modal_name==="tax_modal"){
            //                 document.getElementById("taxModal").style.width = "0%";
            //                 document.getElementById("taxModal").style.left = "100%";
            //                 document.getElementById("taxModal").style.right = "0%";
            //             }else{
            //
            //             }
            //             break;
            //     }
            // },

            load_Tax: function () {
                this.default_mode = "";
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Taxes')
                    .then((res) => {
                        this.account_taxes = [];
                        if(res.data.status_code === 200) {
                            this.account_taxes = res.data.results.resources;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },

            load_Pay: function () {
                this.default_mode = "";
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Payment Methods')
                    .then((res) => {
                        this.account_payment_methods = [];
                        if(res.data.status_code === 200) {
                            this.account_payment_methods = res.data.results.resources;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },

        },
        mounted() {
            this.practice_id = Auth.getCurrentBranch().id;
            this.load_Tax();
            this.load_Pay();
            this.page_loaded = true;
        }
    }
</script>

<style scoped>

    table tbody tr td {
        padding: 6px 8px!important;
        font-size: 13px!important;
    }

</style>