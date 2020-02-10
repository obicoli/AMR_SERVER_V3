<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content content-calculated-height-wc">

            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0 content-calculated-height-50">

                    <div v-if="page_loaded" class="settings-header shadowed main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-50-pc">
                                    <search-database-form-control :field_wdth="300" :placeholder="'Search here'"></search-database-form-control>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div v-if="page_loaded" class="row mg-top-35">

                        <div class="col-md-4 col-lg-4 col-sm-4 padding-right-0 padding-left-20 bg-white content-calculated-height-50">
                            <div class="estimate-list width-100-pc content-calculated-height-50">
                                <div class="estimate-list-head">
                                    <div class="float-left width-10-pc">
                                        <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor float-left" @click="check_all($event)">
                                    </div>
                                    <div class="float-left width-70-pc">
                                        <div  class="btn-group" role="group" aria-label="Button group">
                                            <div v-if="selected_estimates.length" class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_100'" class="dropdown-toggle pointer-cursor fw-600 cl-444 fs-14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{selected_estimates.length}} Estimates selected
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_100'">
                                                    <a data-toggle="modal" data-target="#payment_bill_id" class="dropdown-item pointer-cursor fs-12">Record Payment</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Update status</a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Copy Purchase Order</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Delete</a>
                                                </div>
                                            </div>
                                            <div v-else class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle pointer-cursor fw-600 cl-444 fs-14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{default_filter}} Estimates({{pagination.total}})
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <!-- <a @click="filterItems('All')" class="dropdown-item pointer-cursor">All</a>
                                                    <a @click="filterItems(PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.DRAFT}}</a>
                                                    <a @click="filterItems(PROCESS_STATUS.PENDING_APPROVAL)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                    <a @click="filterItems(PROCESS_STATUS.OPEN)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OPEN}}</a>
                                                    <a @click="filterItems(PROCESS_STATUS.OVERDUE)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OVERDUE}}</a>
                                                    <a @click="filterItems(PROCESS_STATUS.UNPAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.UNPAID}}</a>
                                                    <a @click="filterItems(PROCESS_STATUS.PARTIAL_PAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PARTIAL_PAID}}</a>
                                                    <a @click="filterItems(PROCESS_STATUS.PAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PAID}}</a>
                                                    <a @click="filterItems(PROCESS_STATUS.VOID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.VOID}}</a> -->
                                                    <a class="dropdown-item pointer-cursor">All</a>
                                                    <a class="dropdown-item pointer-cursor">Draft</a>
                                                    <a class="dropdown-item pointer-cursor">Pending Approval</a>
                                                    <a class="dropdown-item pointer-cursor">Approved</a>
                                                    <a class="dropdown-item pointer-cursor">Sent</a>
                                                    <a class="dropdown-item pointer-cursor">Client Viewed</a>
                                                    <a class="dropdown-item pointer-cursor">Accepted</a>
                                                    <a class="dropdown-item pointer-cursor">Invoiced</a>
                                                    <a class="dropdown-item pointer-cursor">Declined</a>
                                                    <a class="dropdown-item pointer-cursor">Expired</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor">+ New Custom view</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-20-pc float-right">
                                        <button type="button" data-toggle="modal" title="New Estimate" data-target="#new_estimate_modal" class="float-right btn btn-secondary banking-process-amref">+</button>
                                    </div>
                                </div>
                                <div class="estimate-list-body height-scrollable-body">
                                    <table class="width-100-pc">
                                        <tbody v-if="is_initializing">
                                            <tr class="parent">
                                                <td colspan="3" class="text-center">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-if="!estimates.length">
                                            <tr class="parent">
                                                <td colspan="3" class="text-center cl-amref">
                                                    No estimate to display!
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-for="(estimat,index) in estimates" v-bind:class="{'active':active_po===index}" :key="'po_list_'+index">
                                            <tr class="parent">
                                                <td style="width:10%"><input v-model="selected_estimates" :value="estimat.id" type="checkbox"> </td>
                                                <td style="width:55%" class="fs-12">{{estimat.customer.legal_name}}</td>
                                                <td style="width:35%" class="text-right fs-12 cl-444 fw-600">{{currency+' '+formatMoneys(estimat.net_total)}}</td>
                                            </tr>
                                            <tr class="child">
                                                <td style="width:10%" class="text-right"></td>
                                                <td style="width:55%">
                                                    <a @click="setEstimate(estimat,index)" class="txt-uppercase fs-12 cl-blue-link fw-600">{{estimat.trans_number}}</a> | <a class="fs-12 cl-787887 fw-600">{{estimat.trans_date}}</a>
                                                </td>
                                                <td style="width:35%" class="text-right">
                                                    <a @click="setPo(estimat,index)" v-if="check_status(estimat.status,PROCESS_STATUS.ACCEPTED)" class="documentStatus accepted">Accepted</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.DRAFT)" class="documentStatus draft">Draft</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.DECLINED)" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.EXPIRED)" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.SENT)" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.PAID)" class="documentStatus paid">{{PROCESS_STATUS.PAID}}</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.PARTIAL_PAID)" class="documentStatus paid">{{PROCESS_STATUS.PARTIAL_PAID}}</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.INVOICED)" class="documentStatus invoiced">{{PROCESS_STATUS.INVOICED}}</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.OPEN)" class="documentStatus open">Open</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.CLOSED)" class="txt-uppercase fs-12 fw-600 cl-success-light">{{PROCESS_STATUS.CLOSED}}</a>
                                                    <a @click="setPo(estimat,index)" v-else-if="check_status(estimat.status,PROCESS_STATUS.PENDING_APPROVAL)" class="documentStatus pending">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                    <a @click="setPo(estimat,index)" v-else="" class="documentStatus pending">Pending</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="padding-left-0 bg-ced padding-right-0 content-calculated-height-50 col-md-8 col-lg-8 col-sm-8">
                            
                            <div class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height-50 border-bottom-0 no-shadowed">
                                 <div  class="width-100-pc action-header padding-left-20 padding-top-10 padding-bottom-10">
                                    <div class="float-left width-20-pc">
                                        <h3 class="fs-14 cl-777 fw-600">{{estimate.trans_number}}</h3>
                                    </div>
                                    <div class="float-right width-80-pc text-right padding-right-30">
                                        <button v-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.DRAFT" type="button" data-toggle="modal" title="Edit Estimate" data-target="#edit_po_modal_00" class="btn btn-default btn-inventory btn-gray mg-left-2"><i class="fa fa-pencil"></i></button>
                                        <button type="button" @click="printDocs('receipt_'+estimate.id,'Loading estimate '+estimate.trans_number)" class="btn btn-default btn-inventory btn-gray mg-left-2">
                                            <span v-if="printing"><i class="fa fa-spinner fa-spin"></i> Wait...</span>
                                            <i v-else class="fa fa-print"></i>
                                        </button>
                                        <button type="button" data-toggle="modal" data-target="#send_estimate_mail_00" title="Send Mail" class="btn btn-default btn-inventory btn-gray mg-left-2"><i class="fa fa-envelope-o"></i></button>
                                        <button type="button" data-toggle="modal" data-target="#attach_files_000" title="Attach file(s)" class="btn btn-default btn-inventory btn-gray mg-left-2 mg-right-20"><i class="fa fa-paperclip"></i></button>

                                        <button v-if="page_loaded && check_status(estimate.status,PROCESS_STATUS.DRAFT)" type="button" data-toggle="modal" data-target="#change_status_modal" class="btn btn-secondary banking-process">Mark as Sent</button>
                                        <button v-if="page_loaded && check_status(estimate.status,PROCESS_STATUS.INVOICED) || check_status(estimate.status,PROCESS_STATUS.ACCEPTED) || check_status(estimate.status,PROCESS_STATUS.OPEN)" type="button" data-toggle="modal" data-target="#create_invoice_modal" class="btn btn-secondary banking-process-amref">Create Invoice</button>
                                        
                                        <div v-if="page_loaded" class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDropwww" type="button" class="btn btn-secondary banking-process dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    More
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDropwww">
                                                    <a class="dropdown-item pointer-cursor">Copy Estimate</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <!-- <a v-if="check_status(estimate.status,PROCESS_STATUS.OPEN) || check_status(estimate.status,PROCESS_STATUS.PARTIAL_PAID)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#payment_estimate_id">Record Payment</a>
                                                    <a v-if="check_status(estimate.status,PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#send_po_mail_00">Send Mail</a>
                                                    <a v-if="check_status(estimate.status,PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#change_status_modal">Change status</a> -->
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#send_po_mail_00">Create Retainer Invoice</a>
                                                    <a v-if="check_status(estimate.status,PROCESS_STATUS.ACCEPTED) || check_status(estimate.status,PROCESS_STATUS.INVOICED)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#create_salesorder_modal">Create Sales Order</a>
                                                    <a v-else class="dropdown-item pointer-cursor" @click="confirmModalDialog('Please note that by clicking continue, this '+DOC_NAME+' will be marked as Accepted','create_salesorder_modal')">Create Sales Order</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#create_invoice_modal">Create Invoice</a>
                                                    <a v-if="check_status(estimate.status,PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#send_po_mail_00">Mark as Sent</a>

                                                    <a v-if="check_status(estimate.status,PROCESS_STATUS.SENT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#send_po_mail_00">Mark as Accepted</a>
                                                    <a v-if="check_status(estimate.status,PROCESS_STATUS.SENT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#send_po_mail_00">Mark as Declined</a>

                                                    <a class="dropdown-item separator"></a>
                                                    <a v-if="check_status(estimate.status,PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <router-link :to="QUOTE" tag="i" class="btn btn-default btn-inventory btn-gray"><i class="fa fa-arrow-circle-left"></i> Back to Estimates</router-link>
                                    </div>
                                    <div class="width-100-pc mg-top-45 content-links">
                                    </div>
                                </div>

                                <div class="page-content bg-white padding-left-0 height-scrollable">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row">
                                            <div class="col-lg-12 padding-right-0">
                                                <div class="width-100-pc float-left">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <a v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">{{estimate.trans_number}}</a>
                                                            <a v-if="estimate.salesorders.length" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Sales Order({{estimate.salesorders.length}})</a>
                                                            <a v-if="estimate.invoices.length" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===2}" :id="'nav-transactions-tab-'+'2'" data-toggle="tab" :href="'#nav-transactions-'+'2'" role="tab" :aria-controls="'nav-transactions-'+'2'" aria-selected="true" :key="'transactions_tab'+'2'">Invoices({{estimate.invoices.length}})</a>
                                                            <a v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===3}" :id="'nav-transactions-tab-'+'3'" data-toggle="tab" :href="'#nav-transactions-'+'3'" role="tab" :aria-controls="'nav-transactions-'+'3'" aria-selected="true" :key="'transactions_tab'+'3'">Comment&History</a>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content tab-content-role" id="nav-tabContent">
                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-right-10 bg-f4 padding-bottom-20">
                                                                <section v-if="page_loaded" class="padding-right-0 padding-left-0 padding-top-20" id="print_section">
                                                                    <div v-if="po_loading" class="float-left width-100-pc text-center mg-top-30">
                                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                                    </div>
                                                                    <estimate-preview v-else :estimate="estimate" :currency="currency"></estimate-preview>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-transactions-'+'1'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'1'" :key="'tab_index_'+'1'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-right-10 bg-f4 padding-bottom-20">
                                                                <section v-if="page_ready" class="padding-right-0 padding-left-0 padding-top-20" id="print_section">
                                                                    <div v-if="po_loading" class="float-left width-100-pc text-center mg-top-30">
                                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                                    </div>
                                                                    <div v-else class="float-left width-100-pc">
                                                                        <salesorder-preview v-for="(sales_ord,index) in estimate.salesorders" :salesorder="sales_ord" :currency="currency" :key="'qoute'+index"></salesorder-preview>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===2}" :id="'nav-transactions-'+'2'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'2'" :key="'tab_index_'+'2'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-right-10 bg-f4 padding-bottom-20">
                                                                <section v-if="page_ready" class="padding-right-0 padding-left-0 padding-top-20" id="print_section">
                                                                    <div v-if="po_loading" class="float-left width-100-pc text-center mg-top-30">
                                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                                    </div>
                                                                    <div v-else class="float-left width-100-pc">
                                                                        <invoice-preview v-for="(invoice,index) in estimate.invoices" :customer_invoice="invoice" :currency="currency" :key="'invoices_'+index"></invoice-preview>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>

                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===3}" :id="'nav-transactions-'+'3'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'3'" :key="'tab_index_'+'3'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-top-20 padding-right-10 bg-f4 padding-bottom-20 min-height-427">
                                                                <audit-timeline v-if="page_loaded" :audit_trails="estimate.audit_trails"></audit-timeline>
                                                                <div class="width-100-pc float-left mg-top-20">
                                                                    <form @submit.prevent="addComment" v-if="add_comment" class="width-100-pc float-left padding-20">
                                                                        <div class="width-100-pc float-left">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <textarea v-model="comment_form.comment" required placeholder="" v-bind:class="{'min-height-60':true,'custom-attended-field':comment_form.comment}"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-secondary banking-process-amref mg-top-5">
                                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin"></i></span>
                                                                            <span v-else>+ add</span>
                                                                        </button>
                                                                        <button type="button" class="btn btn-secondary banking-process mg-top-5">x close</button>
                                                                    </form>
                                                                    <a v-if="!add_comment" @click="toggleAddComment(true)" class="cl-blue-link fs-12 pointer-cursor float-left">+ Add comment</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                 <!-- <send-mail v-if="page_loaded" :mailing_api="mailing_api" :modal_id="'send_bill_mail_00'" :mail_content="mail_content" :modal_title="'Send Mail'" @send-mail-event="loadBills(true)"></send-mail>
                                 <bill-modal v-if="page_loaded" :taxations="taxations" :inventories="inventories" :accounts="accounts" :bank_accounts="bank_accounts" :filters="filters" :billable="false" :payment_terms="payment_terms" :currency="currency" :bill_api="CUSTOMERS_ESTIMATES_API" :billable_type="'PO'" :suppliers="suppliers" :order="bill" :modal_id="'new_bill_id'" :modal_title="'New Bill'" @create-bill-event="loadBills"></bill-modal>
                                 <file-attach-modal v-if="page_loaded" @upload-success-event="loadBills(true)" @delete-file-event="loadBill" :attachable="bill" :upload_api="SUPPLIER_BILL_ASSETS_API" :title="'File Attachment | '+bill.trans_number" :modal_id="'attach_files_000'" :info="'Individual files may not exceed 2.00 MB in size. A maximum of 5 attachments per bill can be added'"></file-attach-modal>
                                 <supplier-payment-modal v-if="page_loaded" :bill="bill" :accounts="accounts" :bank_accounts="bank_accounts" :filters="filters" :currency="currency" :payment_api="SUPPLIER_PAYMENTS_API" :suppliers="suppliers" :modal_id="'payment_bill_id'" :modal_title="'Payment for '+bill.trans_number" @create-payment-event="loadBills(true)"></supplier-payment-modal>
                                 <change-status v-if="page_loaded" @change-status-event="loadBills(true)" :modal_title="'Change Status'" :item_url="CUSTOMERS_ESTIMATES_API+'/'+bill.id" :modal_id="'change_status_modal'"></change-status> -->

                            </div>
                        </div>
                    </div>

                    <div v-else class="row">
                        <div class=" col-md-12 col-lg-12 text-center bg-ced min-height-100-vh">
                            <img class="loader mg-top-170" src="/assets/icons/dashboard/loader.gif">
                        </div>
                    </div>

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <invoice-modal v-if="page_ready" :modal_title="'Create Tax Invoice'" :bank_accounts="bank_accounts" :estimate="selected_estimate" :customers="customers" :modal_id="'create_invoice_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :customer_invoice_api="CUSTOMERS_INVOICES_API" @create-invoice-event="loadEstimates(true)"></invoice-modal>
                    <sales-order-modal v-if="page_ready" :modal_title="'New Sales Order'" :customers="customers" :estimate="selected_estimate" :modal_id="'create_salesorder_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :sales_order_api="CUSTOMERS_SALES_ORDERS_API" @create-salesorder-event="loadEstimates(true)"></sales-order-modal>
                    <estimate-modal v-if="page_ready" :modal_title="'New Estimate'" :customers="customers" :modal_id="'new_estimate_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :estimate_api="CUSTOMERS_ESTIMATES_API" @create-estimate-event="loadEstimates(true)"></estimate-modal>
                    <copy-right></copy-right>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import SideBar from "../../../partials/sidebars/SideBar";
    import TopNavBar from "../../../partials/topbars/TopNavBar";
    import SideBarSupply from "../../../partials/sidebars/SideBarSupply";
    //import SideBarRequisitions from "../../partials/sidebars/SideBarRequisitions";
    //import SideBarCustomer from "../../partials/sidebars/customer/SideBarCustomer";
    import PurchasesFilters from "../../../partials/filters/PurchasesFilters";
    import PurchasesTable from "../../../partials/tables/PurchasesTable";
    import CreatePurchaseModal from "../../../partials/modals/purchase/CreatePurchaseModal";
    import SideBarInventory from "../../../partials/sidebars/inventory/SideBarInventory";
    //import SupplyModal from "../../partials/modals/supply/SupplyModal";
    import ConfirmModal from "../../../partials/modals/ConfirmModal";
    import ChangeStatus from "../../../partials/modals/ChangeStatus";
    //import EstimateModal from '../../partials/modals/customer/EstimateModal';
    import PaginateTemplate from '../../../partials/pagination/PaginateTemplate';
    //import SupplyPreview from "../../partials/modals/supply/SupplyPreview";
    //import RequistionModal from '../../partials/modals/product/RequistionModal';
    //import ProcessingOverlay from '../../../../../progress/ProcessingOverlay';
    import SearchDatabaseFormControl from '../../../partials/search/SearchDatabaseFormControl';
    import CommonLinks from "../../../partials/sidebars/CommonLinks";
    import {get, post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    // import SupplierHeader from '../partials/SupplierHeader';
    //import PoModal from "../../../partials/modals/purchase/PoModal";
    //import CompanyLogo from "../../../partials/CompanyLogo";
    //import RibbonMaker from "../../../partials/RibbonMaker";
    import CopyRight from "../../../partials/CopyRight";
    import EstimateModal from "../../../partials/modals/customer/EstimateModal";
    import SalesOrderModal from "../../../partials/modals/customer/SalesOrderModal";
    import InvoiceModal from "../../../partials/modals/customer/InvoiceModal";
    //import BillModal from "../../../partials/modals/vendors/BillModal";
    //import SupplierPaymentModal from "../../../partials/modals/vendors/SupplierPaymentModal";
    //import PaymentReceiptPreview from "../../../partials/previews/supplychain/supplier/PaymentReceiptPreview";
    import SendMail from "../../../partials/modals/mails/SendMail";
    import FileAttachModal from "../../../partials/modals/attachment/FileAttachModal";
    import AuditTimeline from "../../../partials/AuditTimeline";
    import EstimatePreview from "../../../partials/previews/supplychain/customer/EstimatePreview";
    import SalesorderPreview from "../../../partials/previews/supplychain/customer/SalesorderPreview";
    import InvoicePreview from "../../../partials/previews/supplychain/customer/InvoicePreview";
    // import EstimateView from './partials/Estimates'
    // import CustomerModal from '../../partials/modals/customer/CustomerModal';
    import {CUSTOMERS_ESTIMATES_API,CUSTOMERS_SALES_ORDERS_API,CUSTOMERS_INVOICES_API,SUPPLIER_PAYMENTS_API,SUPPLIER_TERMS_API,BANKING_ACCOUNTS_URL,CHART_OF_ACCOUNTS,PRODUCT_ITEMS_URL,PRODUCT_TAX_URL,SUPPLIER_URL,ACCOUNTS_ACCOUNT,PRACTICES_API,SUPPLIER_PO_URL,SUPPLIER_BILL_ASSETS_API, CUSTOMERS_TERMS_API, CUSTOMERS_API} from '../../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney,paginator,printing, format_lunox_date,create_mail_content} from '../../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING, TRANSACTION_TYPES, FORM_ACTIONS} from '../../../../../../helpers/process_status';
    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    import print from "print-js";
    import printJS from "print-js";
    export default {
        name: "EstimateView",
        components: {TopNavBar,SideBar,InvoiceModal,PaginateTemplate,ConfirmModal,SendMail,AuditTimeline,CopyRight,SalesOrderModal,
        SideBarInventory,SearchDatabaseFormControl,ChangeStatus,EstimateModal,FileAttachModal,InvoicePreview,SalesorderPreview,EstimatePreview},
        data(){
            return {
                curr_tab: 0,
                initializations: {},
                products: [],
                estimate_list: [],
                
                
                //purchase_order: {},
                //bill: null,

                
                //suppliers: [],
                
                
                //progress_overlay: 'hide',
                

                comment_form: {
                    comment: null,
                },

                active_po: -1,
                PROCESS_STATUS : PROCESS_STATUS,
                CUSTOMERS_ESTIMATES_API:CUSTOMERS_ESTIMATES_API,
                //initial_api: SUPPLIER_PO_URL,
                
                //SUPPLIER_PO_URL: SUPPLIER_PO_URL,
                //SUPPLIER_BILL_ASSETS_API: SUPPLIER_BILL_ASSETS_API,
                //SUPPLIER_PAYMENTS_API: SUPPLIER_PAYMENTS_API,
                //Please note that only an accepted '+DOC_NAME+' can be converted to a Sales Order

                is_initializing: false,
                processing: false,
                default_filter: 'All',
                default_api: CUSTOMERS_ESTIMATES_API+'?page=1',
                po_list_ready: false,
                po_loading: false,
                mail_content: null,
                mailing_api: null,
                printing: false,
                add_comment: false,
                //
                
                //suppliers: [],
                //facilities: [],
                
                //inventories: [],
                //accounts: [],
                //bank_accounts: [],
                currency: ACCOUNTING.CURRENCY,
                ACCOUNTING: ACCOUNTING,
                BILLS_URL: INVENTORY_WEB_ROUTES.PURCHASES.BILLS,
                estimates: [],
                estimate: null,
                selected_estimates: [],
                selected_estimate: null,
                pagination: paginator(),
                customers: [],
                payment_terms: [],
                taxations: [],
                filters: {},
                initial_estimate_api: CUSTOMERS_ESTIMATES_API+'/'+this.$route.params.uuid,
                CUSTOMERS_ESTIMATES_API: CUSTOMERS_ESTIMATES_API,
                page_loaded: false,
                page_ready: false,
                QUOTE: INVENTORY_WEB_ROUTES.SALES.QUOTE,
                SALES_ORDER_URL: INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS,
                CUSTOMERS_SALES_ORDERS_API: CUSTOMERS_SALES_ORDERS_API,
                CUSTOMERS_INVOICES_API:CUSTOMERS_INVOICES_API,
                bank_accounts: [],
                DOC_NAME: "Quotation",
            }
        },

        watch: {
            default_api: function(){
                this.loadEstimates(false);
            }
        },

        methods: {

            toggleAddComment(toggle_comment){
                this.add_comment = toggle_comment;
            },

            goTo(url_link){
                this.$router.push(url_link);
            },

            confirmModalDialog(msg,modal_id=null){
                this.$dialog
                .confirm(msg)
                .then(function(dialog) {
                    if(modal_id){
                        //console.info(modal_id);
                        //$('#'.modal_id+'').modal('show');
                        $('#create_salesorder_modal').modal('show');
                    }
                })
                .catch(function() {
                    console.log('Clicked on cancel');
                });
            },

            addComment(){
                this.processing = true;
                let api_ = CUSTOMERS_ESTIMATES_API+'/'+this.estimate.id+'?action='+FORM_ACTIONS.COMMENT;
                post(api_,this.comment_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.loadBill();
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },

            calc_balance(net_total,payments,global_index){
                let balance = 0 + net_total;
                for (let index = 0; index < payments.length; index++) {
                    const element = payments[index];
                    balance -= element.amount;
                    if(global_index === index){
                        break;
                    }
                }
                return balance;
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

            check_status(array_to,pin_to){
                let result = false;
                if( array_to[array_to.length-1].status === pin_to ){
                    result = true;
                }
                return result;
            },

            setEstimate(bill_obj,index=-1){
                this.active_po = index;
                this.po_loading = true;
                this.initial_estimate_api = CUSTOMERS_ESTIMATES_API+'/'+bill_obj.id;
                this.loadEstimate();
            },

            printDocs(element_id,msg=null) {
                //printing(element_id,msg);
                printing(element_id,msg);
                //this.log_print(element_id,msg);
            },

            log_print(element_id,msg){
                this.printing = true;
                let api_ = CUSTOMERS_ESTIMATES_API+'/'+this.estimate.id+'?action='+FORM_ACTIONS.PRINT;
                let form_ = {};
                post(api_,form_)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.loadBill();
                            printing(element_id,msg);
                            this.printing = false;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                    this.printing = false;
                });
            },

            check_all(event){
                this.selected_bills = [];
                if(event.target.checked){
                    for (let index = 0; index < this.estimates.length; index++) {
                        const element = this.bills[index];
                        this.selected_bills.push(element.id);
                    }
                }
            },

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadEstimates(show_progress=false){
                if(show_progress){
                    this.processing = true;
                }
                this.is_initializing = true;
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.estimates = res.data.results.data;
                        this.pagination = res.data.results.pagination;
                        this.filters = res.data.results.filters;
                        if(show_progress){
                            this.loadEstimate();
                        }else{
                            this.page_loaded = true;
                            this.processing = false;
                            this.page_ready = true;
                            this.is_initializing = false;
                        }
                    }
                }).catch((err) => {
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
                });
            },

            loadBankAccount(){
                get(BANKING_ACCOUNTS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results.data;
                        this.loadEstimates(true);
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
                });
            },

            filterItems(filter_by='All'){
                switch (filter_by) {
                    case PROCESS_STATUS.CANCELLED:
                    case PROCESS_STATUS.CLOSED:
                    case PROCESS_STATUS.PARTIAL_BILLED:
                    case PROCESS_STATUS.BILLED:
                    case PROCESS_STATUS.OPEN:
                    case PROCESS_STATUS.DRAFT:
                    case PROCESS_STATUS.PENDING_APPROVAL:
                    case PROCESS_STATUS.APPROVED:
                    case PROCESS_STATUS.PAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.VOID:
                    case PROCESS_STATUS.OVERDUE:
                    case PROCESS_STATUS.PARTIAL_PAID:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_ESTIMATES_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = CUSTOMERS_ESTIMATES_API+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = CUSTOMERS_ESTIMATES_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_ESTIMATES_API+'?page='+this.pagination.current_page;
                        break;
                }
            },

            loadEstimate(){
                get(this.initial_estimate_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.estimate = res.data.results;
                        //console.info(this.bill);
                        //this.mail_content = create_mail_content(TRANSACTION_TYPES.BILL,this.bill,this.currency);
                        //this.mailing_api = CUSTOMERS_ESTIMATES_API+'/'+this.bill.id+'?action='+FORM_ACTIONS.SEND_MAIL;
                        for (let index = 0; index < this.estimates.length; index++) {
                            const element = this.estimates[index];
                            if(element.id === this.estimate.id){
                                this.selected_estimate = element;
                                break;
                            }
                        }
                        //this.progress_overlay = "hide";
                        this.page_loaded = true;
                        this.processing = false;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.po_loading = false;
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
                });
            },

            loadTerms(){
                get(CUSTOMERS_TERMS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.payment_terms = res.data.results.data;
                        this.loadCustomers(true);
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
                });
            },

            loadCustomers(){
                get(CUSTOMERS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customers = res.data.results.data;
                        this.loadBankAccount();
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
                });
            },

            loadTaxes(){
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results.data;
                        this.loadTerms()
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
                });
            },
            
        },
        mounted() {
            this.loadTaxes(true);
        }
    }
</script>

