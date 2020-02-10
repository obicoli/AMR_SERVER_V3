<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-lg-12">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-20-pc">
                                    <h2 class="txt-uppercase fs-12 fw-600">Inventory Requistions:</h2>
                                </div>
                                <div class="pull pull-right app-header width-70-pc">
                                    <common-links :active_link="'requistions'"></common-links>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content bg-white mg-top-30">

                        <div class="row justify-content-center">

                            <div class="col-xs-12 col-md-12 col-sm-12 max-width-1100">

                                <div id="card_alerter"></div>

                                <div class="box border-top-0 border-bottom-0 border-radius-0 mg-top-30" id="print-section">

                                    <div class="box-header box-header-custom">
                                        <div class="pull pull-right width-100-pc">
                                            <div class="filters width-100-pc">
                                                <search-database-form-control v-if="page_ready" :search_type="'Requests'" :placeholder="'search here'" :field_wdth="200" :rounded_px="10"></search-database-form-control>
                                                <!-- <div class="filter-block form-inline width-25-pc mg-right-30">
                                                    <div class="filter-group input-group">
                                                        <span @click="filter_status('all')" class="filter active">All</span>
                                                        <span @click="filter_status('Pending')" class="filter">Pending</span>
                                                        <span @click="filter_status('Approved')" class="filter">Approved</span>
                                                    </div>
                                                </div>
                                                <div class="width-30-pc pull-right">
                                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                        <button data-toggle="modal" data-target="#requisition_modal_id" type="button" class="btn combo-button combo-default">+ New Request</button>
                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                                <a class="dropdown-item"> Print Report</a>
                                                                <a class="dropdown-item"> Export to Csv</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-body bg-white padding-right-20 padding-left-20">

                                        <div class="width-60-pc pull-left mg-bottom-10">
                                            <a class="btn-default-md pointer-cursor mg-right-10">All (0)</a>
                                            <a class="btn-default-md pointer-cursor mg-right-10">Pending (0)</a>
                                            <a class="btn-default-md pointer-cursor mg-right-10">Approved (0)</a>
                                            <a class="btn-approved-md pointer-cursor mg-right-10">Denied (0)</a>
                                        </div>

                                        <div class="width-20-pc pull-right mg-bottom-10">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#requisition_modal_id" type="button" class="btn combo-button combo-default">+ New Request</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                        <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#import_brands_modal_id"> Import Brand</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="requistion_table_holder" class="table ledgers-table">
                                            <thead><tr><th colspan="7">Available Requistion List:</th></tr></thead>
                                            <tbody v-for="(requistion,index) in requistions" :key="'requistions'+index">
                                                <tr>
                                                    <td style="width:2%;">
                                                        <label class="check-container small element-inlined mg-top-0 mg-bottom-20">
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td style="width:15%;">
                                                        <a class="btn-approved">{{requistion.trans_number}}</a><br>
                                                        <span class="text-left fs-11 fw-600">Line Items</span> : <span class="text-left fs-11 fw-600 cl-787887">{{requistion.items.length}}</span><br>
                                                        <a class="fs-11">Status: <span class="text-left fs-11 fw-600 cl-787887">{{requistion.movement_status[requistion.movement_status.length-1].status}}</span></a><br>
                                                        <a data-toggle="collapse" :data-target="'#collapseme_'+index" class="cl-amref fs-12 fw-600 pointer-cursor">+ more details</a>
                                                    </td>
                                                    <td style="width:30%;">
                                                        <a class="fs-12"><span class="width-50-pc text-left cl-888 txt-uppercase">Due Date</span> : <span class="width-50-pc text-left cl-amref fw-600">{{requistion.due_date}}</span></a> <a v-if="requistion.overdue" class="combo-button combo-overdue-sm">Overdue</a><br>
                                                        <a class="fs-12"><span class="width-50-pc text-left cl-888 txt-uppercase">Submitted</span> : <span class="width-50-pc text-left cl-444">{{requistion.trans_date}}</span></a><br>
                                                        <a class="fs-12"><span class="width-50-pc text-left cl-888 txt-uppercase">Requested By</span> : <span class="width-50-pc text-left cl-444">{{requistion.signatories.requested_by.first_name}}</span></a><br>
                                                        <a class="fs-12"><span class="width-50-pc text-left cl-888 txt-uppercase">Facility</span> : <span class="width-50-pc text-left cl-444">{{requistion.source_facility.facility_name}}</span></a><br>
                                                        <a class="fs-12"><span class="width-50-pc text-left cl-888 txt-uppercase">Department</span> : <span class="width-50-pc text-left cl-444">{{requistion.source_facility.department.name}}</span></a>
                                                    </td>
                                                    <td style="width:53%; text-align:right;" class="fs-12">
                                                        <label class="fw-600 fs-14">{{format_money(requistion.amount)}}</label><span class="fs-10 cl-787887"> KES</span> <br>
                                                        <label class="cl-888 txt-uppercase">Next Approver:</label><br>
                                                        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                            <button data-toggle="modal" data-target="#requisition_modal_id" type="button" class="btn combo-button combo-pending-sm">{{requistion.next_approver.name}}</button>
                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop" type="button" class="btn combo-button combo-pending-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </button>
                                                            </div>
                                                        </div><br>
                                                        <div class="mg-top-20 text-right width-100-pc">
                                                            <a v-if="requistion.movement_status[requistion.movement_status.length-1].status!==PROCESS_STATUS.DECLINED" data-toggle="modal" :data-target="'#modal_id_'+index" class="btn-declined pointer-cursor">Deny</a>
                                                            <a v-if="requistion.movement_status[requistion.movement_status.length-1].status===PROCESS_STATUS.PENDING || requistion.movement_status[requistion.movement_status.length-1].status===PROCESS_STATUS.DECLINED" data-toggle="collapse" :data-target="'#approvable_'+index" class="btn-approved pointer-cursor">Approval</a>
                                                        </div>
                                                    </td>
                                                    <!-- <td colspan="5" class="fs-12"><span class="fw-600 fs-12 cl-amref">REQ_NO#{{requistion.req_no}}</span> | Date: {{requistion.trans_date}} | <span class="fw-600 fs-13">Branch:</span> {{requistion.source_facility.facility_name}} | <span class="fw-600 fs-13">Store:</span> {{requistion.source_facility.store.name}} | <span class="fw-600 fs-13">Dep:</span> {{requistion.source_facility.department.name}} | <span class="fw-600 fs-13">Sub-Store:</span> {{requistion.source_facility.sub_store.name}} </td>
                                                    <td>
                                                        <span v-if="requistion.movement_status[requistion.movement_status.length-1].status==='Pending'" class="btn-pending">Pending</span>
                                                        <span v-if="requistion.movement_status[requistion.movement_status.length-1].status==='Approved'" class="btn-approved">Approved</span>
                                                        <span v-if="requistion.movement_status[requistion.movement_status.length-1].status==='Fullfilled'" class="btn-approved">Fullfilled</span>
                                                        <span v-if="requistion.movement_status[requistion.movement_status.length-1].status==='Declined'" class="btn-declined">Declined</span>
                                                    </td>
                                                    <td style="text-align:right;"><a data-toggle="c<div class="collapse out width-100-pc padding-20" :id="'approvable_'+index">ollapse" class="fs-15 pointer-cursor cl-amref" data-target="#collapseme">+</a></td> -->
                                                </tr>
                                                <tr class="requistion-holder">

                                                    <td colspan="6" class="zeroPadding">
                                                        <div class="collapse out width-100-pc padding-20" :id="'approvable_'+index">
                                                            <table class="">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:8%">Code</th>
                                                                        <th style="width:26%">Item</th>
                                                                        <th style="width:10%">Pack(weight)</th>
                                                                        <th style="width:8%">Pack(cost)</th>
                                                                        <th style="width:8%">Pack(retail)</th>
                                                                        <th style="width:8%">Packs</th>
                                                                        <th style="width:10%">Requested</th>
                                                                        <th style="width:10%">Qty</th>
                                                                        <th style="width:10%">Amount</th>
                                                                        <th style="width:2%"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(item,index_i) in requistion.items" :key="'index_i'+index_i">
                                                                        <td>{{item.sku_code}}</td>
                                                                        <td>{{item.item_name}} | {{item.brand}}</td>
                                                                        <td>{{item.pack_qty}} x {{item.unit_weight}}{{item.measure_unit_sympol}}</td>
                                                                        <td>{{format_money(item.pack_cost)}}</td>
                                                                        <td>{{format_money(item.pack_retail)}}</td>
                                                                        <td>{{format_money(item.qty)}}</td>
                                                                        <td>
                                                                            <input v-model="requistion.items[index_i].qty_approved" type="number" required step="any" @keyup="amend_qty($event,'qty',requistion.items[index_i].unit_cost,requistion.items[index_i].pack_cost,requistion.items[index_i].practice_product_item_id,index)" v-bind:class="{'form-control height-24':true,'ctm-attended-field':requistion.items[index_i].qty_approved}">
                                                                        </td>
                                                                        <td class="fs-12 fw-600 cl-amref">{{format_money(requistion.items[index_i].qty_approved*requistion.items[index_i].pack_qty)}}</td>
                                                                        <td>{{format_money(item.pack_cost*item.qty_approved)}}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="width-100-pc text-right padding-top-10">
                                                                <!-- <button data-toggle="modal" :data-target="'#create_supply_modal_'+index" type="button" class="btn combo-button combo-pending-sm">Create Supply</button> -->
                                                                <button data-toggle="modal" :data-target="'#confirm_fulfil_modal_id_'+index" type="button" class="btn combo-button combo-default">Save</button>
                                                            </div>
                                                            <div class="row">
                                                                <!-- <div class="col-lg-7 mg-top-20">
                                                                    <p class="fs-10 cl-444 txt-uppercase fw-600">Real-Time-Budget</p>
                                                                    <table class="">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width:20%">Department</th>
                                                                                <th style="width:20%">Store</th>
                                                                                <th style="width:20%">+Current</th>
                                                                                <th style="width:20%">=Committed</th>
                                                                                <th style="width:5%">/</th>
                                                                                <th style="width:15%">Budget</th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div> -->
                                                                <div class="col-lg-5 mg-top-20">
                                                                    <p class="fs-10 cl-444 txt-uppercase fw-600 txt-deco-underline">Requested Cost</p>
                                                                    <label class="fw-600 txt-uppercase fs-13">Total : </label><label class="fw-600 txt-uppercase fs-13">{{format_money(requistion.amount)}}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="collapse out width-100-pc padding-20" :id="'collapseme_'+index">
                                                            <table class="">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:10%">Code</th>
                                                                        <th style="width:30%">Item</th>
                                                                        <th style="width:10%">Pack(weight)</th>
                                                                        <th style="width:8%">Pack(cost)</th>
                                                                        <th style="width:9%">Pack(retail)</th>
                                                                        <th style="width:10%">Requested/Qty</th>
                                                                        <th style="width:10%">Qty/On/Hand</th>
                                                                        <th style="width:10%">Amount</th>
                                                                        <th style="width:3%"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(item,index_i) in requistion.items" :key="'index_i'+index_i">
                                                                        <td>{{item.sku_code}}</td>
                                                                        <td>{{item.item_name}} | {{item.brand}}</td>
                                                                        <td>{{item.pack_qty}} x {{item.unit_weight}}{{item.measure_unit_sympol}}</td>
                                                                        <td>{{format_money(item.pack_cost)}}</td>
                                                                        <td>{{format_money(item.pack_retail)}}</td>
                                                                        <td>{{format_money(item.qty)}}</td>
                                                                        <td class="fs-12 fw-600 cl-amref">{{item.stock}}</td>
                                                                        <td>{{format_money(item.pack_cost*item.qty)}}</td>
                                                                        <td></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <confirm-modal :modal_id="'confirm_fulfil_modal_id_'+index" :modal_title="'Fulfil'" :confirm_message="'Are you sure?'"></confirm-modal>
                                                <supply-modal :address_ob="address_ob" :practice_id="practice_id" :modal_title="'Create Supply'" :initializations="initializations" :label_txt="'SEARCH ITEM'" :modal_id="'create_supply_modal_'+index"></supply-modal>
                                            </tbody>

                                            <tbody v-if="!requistions.length">
                                                <tr data-toggle="collapse" class="pointer-cursor" data-target="#collapseme">
                                                    <td colspan="7" class="text-center cl-amref fs-14 fw-400">No transaction to display</td>
                                                </tr>
                                            </tbody>
                                            
                                        </table>
                                        
                                    </div>

                                    <div class="box-header box-header-custom">
                                        <div class="width-100-pc">
                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadProductStock()" :custom="true"></paginate-template>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <div v-for="(item,indexs) in requistions" :key="'ff_'+indexs">
                        <deny-modal :modal_id="'modal_id_'+indexs" :item_obj="item.id" :modal_title="'Decline Requisition'" v-on:declined="loadRequistions('hide')" :confirm_message="'Are you sure?'"></deny-modal>
                    </div>
                    <!-- <his-connection-handler v-if="prod_loaded" :address_object="address_ob"></his-connection-handler> -->
                    <requistion-modal v-if="prod_loaded" :address_ob="address_ob" :practice_id="temp_practice_id" :modal_title="'Stock Item Request'" :initializations="initializations" :modal_id="'requisition_modal_id'" v-on:successRequested="loadRequistions('hide')"></requistion-modal>
                </div>

            </div>
        </div>

    </div>
</template>

<script>


    "use strict";
    //var myHostname = window.location.hostname;
    let myHostname = 'localhost';
    //console.log("Hostname: " + myHostname);
    let connection = null;
    let address_obj = {};//This object contains: Source_Facility, Destination_Facility, Staff_Data, & Service_Data
    let requisition_transactions = [];
    //Imports
    import {log_this,showTraceable,alertBeep,sendToServer} from "../../../../../rtc/index";
    import {createHtmlErrorString,handle_requistion_listing} from "../../../../../helpers/functionmixin";
    import AWN from "awesome-notifications";
    import {RTC_BASE_URL,RTC_HIS_PORT} from '../../../../../router/api_routes';
    let notifier = new AWN({
        position: 'top-right',
        labels: {
            warning: 'Whoops!',
            success: 'Success',
            confirm: 'Confirmation Required'
        },
        icons: {
            info: 'info-circle'
        }
    });

    function createMsgBody() {
        return {
            type: '',
            //service_type: '',
            text: address_obj
        };
    }

    // function filter_status(filter_status) {
    //     alert(filter_status);
    // }

    function alertNoservice(data) {
        let html_string = '<strong>Whoops!</strong> This service is not available, please try again later';
        notifier.warning(html_string);
    }

    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    // import SideBarHr from "../../partials/sidebars/SideBarHr";
    import CommonLinks from "../../partials/sidebars/CommonLinks";//see
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import DeleteModal from '../../partials/modals/DeleteModal';
    import ConfirmModal from '../../partials/modals/ConfirmModal';
    import SupplyModal from "../../partials/modals/supply/SupplyModal";
    import DenyModal from '../../partials/modals/stocks/DenyModal';
    import RequistionModal from '../../partials/modals/product/RequistionModal';
    import SearchDatabaseFormControl from '../../partials/search/SearchDatabaseFormControl';
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    // import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal';
    // import ProductModal from '../../../practice/partials/modals/product/ProductModal';
    // import ImportItemModal from '../../../practice/partials/modals/product/ImportItemModal';
    import {get, post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {formatMoney,removeElement,paginator} from "../../../../../helpers/functionmixin";
    // import SearchItemField from '../../partials/modals/product/SearchItemField';
    import SearchItemFormControl from '../../partials/modals/product/SearchItemFormControl';
    import HisConnectionHandler from '../../partials/rtc/HisConnectionHandler';
    import {PROCESS_STATUS} from '../../../../../helpers/process_status'
    import {PRODUCT_URL,PRODUCT_STOCK_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_REQUISITIONS} from '../../../../../router/api_routes';

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,DenyModal,SupplyModal,
        ProcessingOverlay,DeleteModal,PaginateTemplate,ConfirmModal,
        HisConnectionHandler,CommonLinks,SearchItemFormControl,SearchDatabaseFormControl,RequistionModal},
        data(){
            return {
                initializations: {},
                address_ob: {},
                prod_loaded: false,
                practice_id: '',
                temp_practice_id: '',
                progress_overlay: 'hide',
                pagination: paginator(),
                requistions: [],
                page_ready: false,
                PROCESS_STATUS: PROCESS_STATUS,
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to)
            },

            loadRequistions(over_lay="show"){
                this.progress_overlay = over_lay;
                get(PRODUCT_REQUISITIONS+'/'+this.practice_id+'/'+this.address_ob.source_address.department_id+'/'+this.address_ob.source_address.store_id+'/'+this.address_ob.source_address.sub_store_id+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.requistions = res.data.results.incomings;
                        this.progress_overlay = "hide";
                        //console.info(res.data.results);
                        this.prod_loaded = true;
                        this.page_ready = true;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },



            filter_status(filter_status) {
                alert(filter_status);
            },

            // loadProductStock(){
            //     this.progress_overlay = "show";
            //     get(PRODUCT_STOCK_URL+'/practice/'+this.practice_id+'?page='+this.pagination.current_page)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.transactions = res.data.results;
            //             this.loadInitials();
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //     });
            // },

            sendRequest(requisition_item){
                let msg_body = createMsgBody();
                msg_body.type = "inventory";
                msg_body.text.service_data.service_type = "Requisition";
                msg_body.text.service_data.service_action = "Create";
                msg_body.text.service_data.posted_data = requisition_item;
                //console.info(requisition_item);
                sendToServer(connection,msg_body);
            },

            loadInitials(){
                this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        // this.progress_overlay = "hide";
                        // this.prod_loaded = true;
                        this.loadRequistions();
                        //console.info(this.initializations);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            connect(){

                let serverUrl;
                let scheme = "ws";
                this.myHostname = RTC_BASE_URL;
                // If this is an HTTPS connection, we have to use a secure WebSocket
                // connection too, so add another "s" to the scheme.
                if (document.location.protocol === "https:") {
                    scheme += "s";
                }
                serverUrl = scheme + "://" + this.myHostname + ":"+RTC_HIS_PORT;
                connection = new WebSocket(serverUrl);

                connection.onopen = function (evt) {
                    let msg_body = createMsgBody();
                    msg_body.type = "login";
                    msg_body.text.service_data.service_type = "Requisition";
                    msg_body.text.service_data.service_action = "Listing";
                    //msg_body.text = this.address_obj;
                    sendToServer(connection,msg_body);
                };

                connection.onmessage = function (evt) {

                    let text = "";
                    let msg = JSON.parse(evt.data);
                    log_this("Message received: ");
                    //log_this("====================Received Message body===============");
                    console.dir(msg);
                    //log_this("====================Received Message body===============");
                    let time = new Date(msg.date);
                    let timeStr = time.toLocaleTimeString();
                    switch(msg.type){
                        case 'success_auth':
                            //log_this("====================Success Auth===============");
                            requisition_transactions = msg.results;
                            let str_html = handle_requistion_listing(requisition_transactions);
                            let requistion_table = document.getElementById("requistion_table_holder");
                            //requistion_table.innerHTML = str_html;
                            $("#requistion_table_holder").append(str_html);
                            break;
                    }

                };

                connection.onerror = function (evt) {
                    alertNoservice('No service');
                    let err_msg = "This service is not available. Please try again later";
                    let htm_str = '<div class="row">'+
                        '<div class="col-lg-12">'+
                        '<div class="alert alert-danger border-radius-2"><strong>Whoops!</strong> '+err_msg+'</div>'+
                        '</div>'+
                        '</div>';
                    //this.$emit('rtc_con_err',htm_str);
                    //this.emmiters('rtc_con_err',htm_str);
                    //this.emit('rtc_con_err');
                };

            },

            // loadProductAttr(){
            //     get(PRODUCT_ATTRIBUTES_URL+'/'+this.practice_id)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.products_attributes = res.data.results;
            //             this.is_page_ready = true;
            //             this.prod_loaded = true;
            //             this.progress_overlay = "hide";
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //     });
            // },

            // format_money(money_to){
            //     return formatMoney(money_to);
            // },

            // delete_item(item_to){
            //     this.initializations.product_items = removeElement(this.initializations.product_items,item_to);
            //     this.practice_product_items = this.initializations.product_items;
            // }
        },

        mounted(){
            this.address_ob = Auth.getCurrentAccount('address');
            //address_obj = Auth.getCurrentAccount('address');
            //console.info(this.address_ob);
            this.address_ob = Auth.getCurrentAccount('address');
            this.practice_id = Auth.getCurrentAccount('id');
            this.temp_practice_id = this.practice_id;
            this.loadInitials();
            //this.prod_loaded = true;
            //this.connect();
        }
    }
</script>

<style scoped>

</style>
