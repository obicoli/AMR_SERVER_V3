<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

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
                                            <div v-if="selected_po.length" class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle pointer-cursor fw-600 cl-444 fs-14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{selected_po.length}} Purchase Orders selected
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Convert to Bill</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Update status</a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Copy Purchase Order</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Delete</a>
                                                </div>
                                            </div>
                                            <div v-else class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle pointer-cursor fw-600 cl-444 fs-14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{default_filter}} Purchase Orders({{pagination.total}})
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a @click="filterPo('All')" class="dropdown-item pointer-cursor">All</a>
                                                    <a @click="filterPo(PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.DRAFT}}</a>
                                                    <a @click="filterPo(PROCESS_STATUS.PENDING_APPROVAL)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                    <a @click="filterPo(PROCESS_STATUS.APPROVED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.APPROVED}}</a>
                                                    <a @click="filterPo(PROCESS_STATUS.OPEN)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OPEN}}</a>
                                                    <a @click="filterPo(PROCESS_STATUS.BILLED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.BILLED}}</a>
                                                    <a @click="filterPo(PROCESS_STATUS.PARTIAL_BILLED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PARTIAL_BILLED}}</a>
                                                    <a @click="filterPo(PROCESS_STATUS.CLOSED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.CLOSED}}</a>
                                                    <a @click="filterPo(PROCESS_STATUS.CANCELLED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.CANCELLED}}</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor">New Custom view</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-20-pc float-right">
                                        <button type="button" data-toggle="modal" title="Add Purchase Order" data-target="#new_po_modal" class="float-right btn btn-secondary banking-process-amref">+</button>
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
                                        <tbody v-if="!purchase_orders.length">
                                            <tr class="parent">
                                                <td colspan="3" class="text-center cl-amref">
                                                    No PO to display!
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-for="(purchase_orde,index) in purchase_orders" v-bind:class="{'active':active_po===index}" :key="'po_list_'+index">
                                            <tr class="parent">
                                                <td style="width:10%"><input v-model="selected_po" :value="purchase_orde.id" type="checkbox"> </td>
                                                <td style="width:55%" class="fs-12">{{purchase_orde.vendor.legal_name}}</td>
                                                <td style="width:35%" class="text-right fs-12 cl-444 fw-600">{{purchase_orde.vendor.currency.currency_sympol}}{{formatMoneys(purchase_orde.total_grand-purchase_orde.discount_allowed)}}</td>
                                            </tr>
                                            <tr class="child">
                                                <td style="width:10%" class="text-right"></td>
                                                <td style="width:55%">
                                                    <a @click="setPo(purchase_orde,index)" class="txt-uppercase fs-12 cl-blue-link fw-600">{{purchase_orde.trans_number}}</a> | <a class="fs-12 cl-787887 fw-600">{{purchase_orde.po_date}}</a>
                                                </td>
                                                <td style="width:35%" class="text-right">
                                                    <a @click="setPo(purchase_orde,index)" v-if="check_status(purchase_orde.status,PROCESS_STATUS.ACCEPTED)" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.DRAFT)" class="documentStatus draft">Draft</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.DECLINED)" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.EXPIRED)" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.INVOICED)" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.SENT)" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.OPEN)" class="documentStatus open">Open</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.CLOSED)" class="txt-uppercase fs-12 fw-600 cl-success-light">{{PROCESS_STATUS.CLOSED}}</a>
                                                    <a @click="setPo(purchase_orde,index)" v-else="" class="txt-uppercase fs-12 fw-600 cl-787887">Pending</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="padding-left-0 bg-ced padding-right-0 content-calculated-height-50 col-md-8 col-lg-8 col-sm-8">
                            
                            <div class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height-50 border-bottom-0 no-shadowed">
                                <!-- ========================================================= -->
                                 <div  class="width-100-pc action-header padding-left-20 padding-top-10 padding-bottom-10">
                                    <div class="float-left width-20-pc">
                                        <h3 class="fs-14 cl-777 fw-600">{{purchase_order.trans_number}}</h3>
                                    </div>
                                    <div class="float-right width-80-pc text-right padding-right-30">
                                        <button v-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.DRAFT" type="button" data-toggle="modal" title="Edit Purchase Order" data-target="#edit_po_modal_00" class="btn btn-default btn-inventory btn-gray mg-left-2"><i class="fa fa-pencil"></i></button>
                                        <button type="button" @click="printDocs('po_component_id_0','Loading PO '+purchase_order.trans_number)" class="btn btn-default btn-inventory btn-gray mg-left-2">
                                            <span v-if="printing"><i class="fa fa-spinner fa-spin"></i> Wait...</span>
                                            <i v-else class="fa fa-print"></i>
                                        </button>
                                        <button type="button" data-toggle="modal" data-target="#send_po_mail_00" title="Send Mail" class="btn btn-default btn-inventory btn-gray mg-left-2"><i class="fa fa-envelope-o"></i></button>
                                        <button type="button" data-toggle="modal" data-target="#attach_files_000" title="Attach file(s)" class="btn btn-default btn-inventory btn-gray mg-left-2 mg-right-20"><i class="fa fa-paperclip"></i></button>

                                        <button v-if="page_loaded && check_status(purchase_order.status,PROCESS_STATUS.DRAFT)" type="button" data-toggle="modal" data-target="#send_po_mail_00" class="btn btn-secondary banking-process-amref">Send to Vendor</button>
                                        <button v-else-if="page_loaded && check_status(purchase_order.status,PROCESS_STATUS.OPEN)" type="button" data-toggle="modal" data-target="#new_bill_id" class="btn btn-secondary banking-process-amref">Convert to Bill</button>
                                        <span v-else></span>
                                        <div v-if="page_loaded" class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop" type="button" class="btn btn-secondary banking-process dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    More
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                    <a v-if="check_status(purchase_order.status,PROCESS_STATUS.OPEN)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#new_bill_id">Convert to Bill</a>
                                                    <a v-if="check_status(purchase_order.status,PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#send_po_mail_00">Send to Vendor</a>
                                                    <a v-if="check_status(purchase_order.status,PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Change status</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a v-if="check_status(purchase_order.status,PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <router-link :to="PURCHASE_ORDERS" tag="i" class="btn btn-default btn-inventory btn-gray"><i class="fa fa-arrow-circle-left"></i> Back to PO List</router-link>
                                    </div>
                                    <div class="width-100-pc mg-top-45 content-links">
                                        <!-- <supplier-header v-if="page_loaded" :supplier="supplier" :active="'statement'"></supplier-header> -->
                                    </div>
                                </div>

                                <div class="page-content bg-white padding-left-0 height-scrollable">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        
                                        <div class="row">
                                            <div class="col-lg-12 padding-right-0">

                                                <div class="width-100-pc float-left">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <a v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">{{purchase_order.trans_number}}</a>
                                                            <a v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Comment&History</a>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content tab-content-role" id="nav-tabContent">
                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-right-10 bg-f4 padding-bottom-20">
                                                                <section v-if="page_loaded" class="padding-right-0 padding-left-0 padding-top-20" id="print_section">
                                                                    <div v-if="po_loading" class="float-left width-100-pc text-center mg-top-30">
                                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                                    </div>
                                                                    <div v-else class="width-100-pc float-left invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20 max-width-800" id="po_component_id_0">
                                                                        
                                                                        <div class="width-100-pc float-left">
                                                                            <div class="width-45-pc float-left text-center report-header">
                                                                                <ribbon-maker :STATUS_ARRAY="purchase_order.status" :PROCESS_STATUS="PROCESS_STATUS"></ribbon-maker>
                                                                                <company-logo></company-logo>
                                                                            </div>
                                                                            <div class="width-40-pc float-right text-right">
                                                                                <h2 class="invoice-title txt-uppercase fs-20"><b>Purchase Order</b></h2>
                                                                                <table class="document-title">
                                                                                    <tr>
                                                                                        <td style="width:50%;" class="no-bd text-right title">Date:</td>
                                                                                        <td style="width:50%;" class="text-right info">{{purchase_order.po_date}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width:50%;" class="no-bd text-right title">PO Number:</td>
                                                                                        <td style="width:50%;" class="text-right info">{{purchase_order.trans_number}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width:50%;" class="no-bd text-right title">Ref:</td>
                                                                                        <td style="width:50%;" class="text-right info">{{purchase_order.ref_number}}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="width:50%;" class="no-bd text-right title">Due Date:</td>
                                                                                        <td style="width:50%;" class="text-right info">{{purchase_order.po_due_date}}</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="width-100-pc float-left set-border-bottom">
                                                                            <div class="width-40-pc float-left to-address padding-top-20 mg-top-20">
                                                                                <table class="sales-table width-100-pc">
                                                                                    <tr class="title">
                                                                                        <td colspan="2" class="">Supplier</td>
                                                                                    </tr>
                                                                                    <tr class="info">
                                                                                        <td colspan="2" class="width-100-pc no-bd">
                                                                                            {{purchase_order.vendor.display_as}}<br>
                                                                                            {{purchase_order.vendor.legal_name}}<br>
                                                                                            {{purchase_order.vendor.addresses.billing.address}}, {{purchase_order.vendor.addresses.billing.postal_code}}<br>
                                                                                            {{purchase_order.vendor.addresses.billing.phone}} | {{purchase_order.vendor.email}}<br>
                                                                                            {{purchase_order.vendor.addresses.billing.fax}}<br>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <div class="width-40-pc float-right to-address padding-top-20 mg-top-20 text-right">
                                                                                <table class="sales-table width-100-pc">
                                                                                    <tr class="title">
                                                                                        <td colspan="2" class="">Ship To</td>
                                                                                    </tr>
                                                                                    <tr class="info">
                                                                                        <td colspan="2" class="width-100-pc no-bd">
                                                                                            {{purchase_order.shipping.name}}<br>
                                                                                            {{purchase_order.shipping.address}}<br>
                                                                                            {{purchase_order.shipping.postal_code}} {{purchase_order.shipping.city}}, {{purchase_order.shipping.country}}<br>
                                                                                            {{purchase_order.shipping.phone}}<br>
                                                                                            {{purchase_order.shipping.email}}<br>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                        <div class="width-100-pc float-left">
                                                                            <div class="width-100-pc float-left mg-top-20">

                                                                                <table class="sales-table width-100-pc">
                                                                                    <tr class="title">
                                                                                        <td class="" style="width:50%;">Item</td>
                                                                                        <td class="text-right" style="width:10%;">Qty</td>
                                                                                        <td class="text-right" style="width:10%;">Rate</td>
                                                                                        <td class="text-right" style="width:10%;">Disc</td>
                                                                                        <td class="text-center" style="width:5%;">Tax</td>
                                                                                        <td class="text-right" style="width:15%;">Line Total</td>
                                                                                    </tr>
                                                                                    <tr v-for="(po_item,est_index) in purchase_order.items" class="info" :key="'estimate_'+est_index">
                                                                                        <td class="no-top-bottom-bd" style="width:50%;">{{po_item.brand.name}} | {{po_item.single_unit_weight}}{{po_item.measure_unit.slug}}</td>
                                                                                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.qty)}}</td>
                                                                                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.price.pack_cost)}}</td>
                                                                                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.line_discount)}}</td>
                                                                                        <td class="no-top-bottom-bd text-center"><span v-if="po_item.line_taxation.length">x</span></td>
                                                                                        <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(po_item.amount-po_item.line_discount)}}</td>
                                                                                    </tr>
                                                                                    <tr class="info">
                                                                                        <td style="width:50%;" colspan="2" class="txt-italic">{{purchase_order.notes}}</td>
                                                                                        <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{currency+' '+formatMoneys(purchase_order.discount_allowed)}} </a></td>
                                                                                    </tr>
                                                                                    <tr class="info">
                                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                                            <a class="float-left">SubTotal:</a>
                                                                                            <a class="float-right">{{currency+' '+formatMoneys(purchase_order.total_grand-purchase_order.total_tax)}}</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="info">
                                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                                            <a class="float-left">Sales Tax:</a>
                                                                                            <a class="float-right">{{currency+' '+formatMoneys(purchase_order.total_tax)}}</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="info">
                                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                                            <a class="float-left">Shipping:</a>
                                                                                            <a class="float-right">{{currency+' '+formatMoneys(purchase_order.shipping_total)}}</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="info">
                                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                                            <a class="float-left">Other:</a>
                                                                                            <a class="float-right">{{currency+' '+formatMoneys(purchase_order.other_total)}}</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="title">
                                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                                        <td class="txt-uppercase fw-600" colspan="4">
                                                                                            <a class="float-left">Total:</a>
                                                                                            <a class="float-right">{{currency+' '+formatMoneys(purchase_order.total_bill)}}</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                        <div class="width-100-pc float-left">
                                                                            <div class="width-100-pc float-left fw-600 accepted-row mg-top-20 text-center">
                                                                                <hr>
                                                                                <p class="fs-13">{{purchase_order.vendor.payment_term.notes}}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="width-100-pc float-left">
                                                                            <div class="width-100-pc float-left text-center accepted-row">
                                                                                <p class="fs-13">If you have any questions, please contact: [{{purchase_order.status[purchase_order.status.length-1].signatory.first_name}} {{purchase_order.status[purchase_order.status.length-1].signatory.mobile}} {{purchase_order.status[purchase_order.status.length-1].signatory.email}}]</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-transactions-'+'1'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'1'" :key="'tab_index_'+'1'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-top-20 padding-right-10 bg-f4 padding-bottom-20 min-height-427">
                                                                <audit-timeline v-if="page_loaded" :audit_trails="purchase_order.audit_trails"></audit-timeline>
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
                                                                        <button @click="toggleAddComment(false)" type="button" class="btn btn-secondary banking-process mg-top-5">x close</button>
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
                                 <bill-modal v-if="page_loaded" :currency="currency" v-on:billCreated="loadPo('hide')" :initial_api="SUPPLIER_BILL_URL" :billable_type="'PO'" :suppliers="suppliers" :order="purchase_order" :payment_terms="payment_terms" :modal_id="'new_bill_id'" :modal_title="'New Bill'"></bill-modal>
                                 <po-modal v-if="page_loaded" :currency="currency" :taxations="taxations" :supplier_po_api="SUPPLIER_PO_URL" :user_mode="'Create'" :filters="filters" @po-create-event="loadPos" :suppliers="suppliers" :facilities="facilities" :customers="customers" :modal_id="'new_po_modal'" :modal_title="'New Purchase Order'"></po-modal>
                                 <po-modal v-if="page_loaded" :currency="currency" :taxations="taxations" :supplier_po_api="SUPPLIER_PO_URL+'/'+purchase_order.id" :user_mode="'Edit'" :form_data="purchase_order" :filters="filters" @po-edit-event="loadPo" :suppliers="suppliers" :facilities="facilities" :customers="customers" :modal_id="'edit_po_modal_00'" :modal_title="'Edit Purchase Order | '+purchase_order.trans_number"></po-modal>
                                 <send-mail v-if="page_loaded" :mailing_api="mailing_api" :modal_id="'send_po_mail_00'" :mail_content="mail_content" :modal_title="'Email To '+purchase_order.vendor.legal_name" @send-mail-event="loadPos(true)"></send-mail>
                                 <file-attach-modal v-if="page_loaded" @upload-success-event="loadPos(true)" @delete-file-event="loadPo" :attachable="purchase_order" :upload_api="SUPPLIER_PO_ASSETS_API" :title="'File Attachment | '+purchase_order.trans_number" :modal_id="'attach_files_000'" :info="'Individual files may not exceed 2.00 MB in size. A maximum of 5 attachments per purchase order can be added'"></file-attach-modal>
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
    //import EstimateModal from '../../partials/modals/customer/EstimateModal';
    import PaginateTemplate from '../../../partials/pagination/PaginateTemplate';
    //import SupplyPreview from "../../partials/modals/supply/SupplyPreview";
    //import RequistionModal from '../../partials/modals/product/RequistionModal';
    import ProcessingOverlay from '../../../../../progress/ProcessingOverlay';
    import SearchDatabaseFormControl from '../../../partials/search/SearchDatabaseFormControl';
    import CommonLinks from "../../../partials/sidebars/CommonLinks";
    import {get, post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import SupplierHeader from '../partials/SupplierHeader';
    import PoModal from "../../../partials/modals/purchase/PoModal";
    import CompanyLogo from "../../../partials/CompanyLogo";
    import RibbonMaker from "../../../partials/RibbonMaker";
    import BillModal from "../../../partials/modals/vendors/BillModal";
    import SendMail from "../../../partials/modals/mails/SendMail";
    import FileAttachModal from "../../../partials/modals/attachment/FileAttachModal";
    import AuditTimeline from "../../../partials/AuditTimeline";
    // import EstimateView from './partials/Estimates'
    // import CustomerModal from '../../partials/modals/customer/CustomerModal';
    import {SUPPLIER_BILL_URL,PRODUCT_ITEMS_URL,PRODUCT_TAX_URL,SUPPLIER_URL,ACCOUNTS_ACCOUNT,PRACTICES_API,SUPPLIER_PO_URL,SUPPLIER_PO_ASSETS_API} from '../../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney,paginator,printing, format_lunox_date,create_mail_content} from '../../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING, TRANSACTION_TYPES, FORM_ACTIONS} from '../../../../../../helpers/process_status';
    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    import print from "print-js";
    import printJS from "print-js";
    export default {
        name: "PoView",
        components: {TopNavBar,SideBar,PaginateTemplate,SupplierHeader,PoModal,BillModal,ConfirmModal,SendMail,AuditTimeline,
        SideBarInventory,ProcessingOverlay,CommonLinks,SearchDatabaseFormControl,RibbonMaker,CompanyLogo,FileAttachModal},
        data(){
            return {
                curr_tab: 0,
                PURCHASE_ORDERS: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS,
                initializations: {},
                products: [],
                estimate_list: [],
                purchase_orders: [],
                payment_terms: [],
                purchase_order: {},
                selected_po: [],
                suppliers: [],
                taxations: [],
                page_loaded: false,
                progress_overlay: 'hide',
                pagination: paginator(),

                comment_form: {
                    comment: null,
                },

                active_po: -1,
                PROCESS_STATUS : PROCESS_STATUS,
                SUPPLIER_BILL_URL:SUPPLIER_BILL_URL,
                initial_api: SUPPLIER_PO_URL,
                initial_po_api: SUPPLIER_PO_URL+'/'+this.$route.params.uuid,
                SUPPLIER_PO_URL: SUPPLIER_PO_URL,
                SUPPLIER_PO_ASSETS_API: SUPPLIER_PO_ASSETS_API,

                is_initializing: false,
                processing: false,
                default_filter: 'All',
                default_api: SUPPLIER_PO_URL+'?page=1',
                po_list_ready: false,
                po_loading: false,
                mail_content: null,
                mailing_api: null,
                printing: false,
                add_comment: false,
                //
                filters: {},
                suppliers: [],
                facilities: [],
                customers: [],
                currency: ACCOUNTING.CURRENCY
            }
        },

        watch: {
            default_api: function(){
                this.loadPos(false);
            }
        },

        methods: {

            printDocs(element_id,msg=null) {
                //printing(element_id,msg);
                this.log_print(element_id,msg);
            },

            toggleAddComment(toggle_comment){
                this.add_comment = toggle_comment;
            },

            addComment(){
                this.processing = true;
                let api_ = SUPPLIER_PO_URL+'/'+this.purchase_order.id+'?action='+FORM_ACTIONS.COMMENT;
                post(api_,this.comment_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.loadPo();
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

            log_print(element_id,msg){
                this.printing = true;
                let api_ = SUPPLIER_PO_URL+'/'+this.purchase_order.id+'?action='+FORM_ACTIONS.PRINT;
                let form_ = {};
                post(api_,form_)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.loadPo();
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
                this.selected_po = [];
                if(event.target.checked){
                    for (let index = 0; index < this.purchase_orders.length; index++) {
                        const element = this.purchase_orders[index];
                        this.selected_po.push(element.id);
                    }
                }
            },

            setPo(purchase_orde,index=-1){
                this.active_po = index;
                this.po_loading = true;
                this.initial_po_api = SUPPLIER_PO_URL+'/'+purchase_orde.id;
                this.loadPo();
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadPos(show_progress=false){

                if(show_progress){
                    this.processing = true;
                }
                this.is_initializing = true;
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.purchase_orders = res.data.results.data;
                        this.pagination = res.data.results.pagination;
                        this.filters = res.data.results.filters;
                        if(show_progress){
                            this.loadPo();
                        }else{
                            this.progress_overlay = "hide";
                            this.page_loaded = true;
                            this.processing = false;
                            this.page_ready = true;
                            this.is_initializing = false;
                        }
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

            filterPo(filter_by='All'){
                switch (filter_by) {
                    case PROCESS_STATUS.CANCELLED:
                    case PROCESS_STATUS.CLOSED:
                    case PROCESS_STATUS.PARTIAL_BILLED:
                    case PROCESS_STATUS.BILLED:
                    case PROCESS_STATUS.OPEN:
                    case PROCESS_STATUS.DRAFT:
                    case PROCESS_STATUS.PENDING_APPROVAL:
                    case PROCESS_STATUS.APPROVED:
                        this.default_filter = filter_by;
                        this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page;
                        break;
                }
            },

            loadPo(){
                //this.progress_overlay = state_load;
                get(this.initial_po_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //console.info('11111111111111');
                        this.purchase_order = res.data.results;
                        //console.info(this.purchase_order);
                        //this.purchase_order.po_date = format_lunox_date(this.purchase_order.po_date);
                        //this.purchase_order.po_due_date = format_lunox_date(this.purchase_order.po_due_date);
                        this.mail_content = create_mail_content(TRANSACTION_TYPES.PURCHASE_ORDER,this.purchase_order,this.currency);
                        this.mailing_api = SUPPLIER_PO_URL+'/'+this.purchase_order.id+'?action='+FORM_ACTIONS.SEND_MAIL;
                        this.progress_overlay = "hide";
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

            // check_status(array_to,pin_to){
            //     let result = null;
            //     for (let index = 0; index < array_to.length; index++) {
            //         const element = array_to[index];
            //         if(element.status === pin_to){
            //             result = element.date;
            //             break;
            //         }
            //     }
            //     return result;
            // },
            check_status(array_to,pin_to){
                let result = false;
                if( array_to[array_to.length-1].status === pin_to ){
                    result = true;
                }
                return result;
            },

            // loadPo(show_progress=false){
            //     if(show_progress){
            //         this.processing = true;
            //     }
            //     get(this.default_api)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.purchase_orders = res.data.results.data;
            //             this.filters = res.data.results.filters;
            //             this.pagination = res.data.results.pagination;
            //             console.info(this.pagination);
            //             this.progress_overlay = "hide";
            //             this.page_ready = true;
            //             this.is_initializing = false;
            //             this.processing = false;
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors));
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description);
            //         }
            //     });
            // },

            loadSuppliers(){
                get(SUPPLIER_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.suppliers = res.data.results.data;
                        this.loadTaxes(true);
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
                        this.loadPos(true);
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

            loadFacilities(state_load=false){
                get(PRACTICES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.facilities = res.data.results;
                        this.loadSuppliers(state_load);
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
            this.loadFacilities(true);
            //this.loadPos(true);
            //this.page_loader();
            //console.info(this.purchase_orders);
        }
    }
</script>

