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
                                    <h4 class="txt-uppercase fw-600 fs-15">Inventory Report:</h4>
                                </div>
                                <div class="pull pull-right app-header width-80-pc">
                                    <common-links :active_link="'reports'"></common-links>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content bg-white mg-top-30">

                        <div class="row justify-content-center">

                            <div v-if="prod_loaded" class="col-xs-12 col-md-12 col-sm-12 max-width-1200">

                                <div class="box border-top-0 border-bottom-0 border-radius-0">

                                    <div class="box-header box-header-custom mg-top-30">
                                        <div class="pull width-100-pc">
                                            <search-database-form-control v-if="is_page_ready" :search_type="'Inventory Reports'" :placeholder="'Find report by name'" :field_wdth="350" :rounded_px="5"></search-database-form-control>
                                        </div>
                                    </div>

                                    <div class="box-body bg-white padding-right-20 padding-left-20">

                                        <div class="row">

                                            <div class="col-lg-12 mg-top-30 mg-bottom-20">
                                                
                                                <div v-if="run_report" class="width-100-pc">
                                                    <table class="receipt-report-table table table-bordered mg-top-5">
                                                        <tbody>
                                                            <tr data-toggle="collapse" class="pointer-cursor header-tr">
                                                                <td colspan="2">
                                                                    <div class="width-40-pc float-left text-left">
                                                                        <a @click="run_reports(null,false)"><i class="fa fa-arrow-left"></i> Back</a>
                                                                    </div>
                                                                    <div class="width-40-pc float-right text-right">
                                                                        <a class="fs-15" title="Email"><i class="fa fa-envelope-o"></i></a>&nbsp;&nbsp;
                                                                        <a class="fs-15" title="Print"><i class="fa fa-print"></i></a>&nbsp;&nbsp;
                                                                        <a class="fs-15" title="Export to Excel"><i class="fa fa-file-excel-o"></i></a>&nbsp;&nbsp;
                                                                        <a class="fs-15" title="Settings"><i class="fa fa-cog"></i></a>&nbsp;&nbsp;
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="pointer-cursor body-tr">
                                                                <td colspan="2" class="zeroPadding">
                                                                    <div class="width-100-pc padding-20">

                                                                        <div class="row">
                                                                            <div class="col-md-12 text-center">
                                                                                <div class="width-100-pc">
                                                                                    <table class="table table-bordered mg-top-5">
                                                                                        <tbody>
                                                                                            <tr data-toggle="collapse" :data-target="'#collapse_filter_1'" class="pointer-cursor header-tr">
                                                                                                <td colspan="2" class="text-right cl-amref fs-12 fw-600">+ More filter</td>
                                                                                            </tr>
                                                                                            <tr class="pointer-cursor body-tr bg-foo">
                                                                                                <td colspan="2" class="zeroPadding">

                                                                                                    <form @submit.prevent="generate_report" class="collapse out width-100-pc padding-20" :id="'collapse_filter_1'">
                                                                                                        <div class="width-20-pc float-left padding-top-10 padding-bottom-10">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">Facility:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <select @change="set_variable($event,'facility')" required v-model="form.practice_id" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.practice_id}">
                                                                                                                            <option value="" selected disabled>-select-</option>
                                                                                                                            <option v-for="(facility_lis, index) in initializations.facilities" :value="facility_lis.id" :key="'practice_list'+index">{{facility_lis.name}}</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="width-20-pc float-left padding-top-10 padding-bottom-10">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">Department:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <select @change="set_variable($event,'department')" required v-model="form.department_id" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.department_id}">
                                                                                                                            <option value="" selected disabled>-select-</option>
                                                                                                                            <option v-for="(departs, index) in initialization.departments" :value="departs.id" :key="'practice_list'+index">{{departs.name}}</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="width-20-pc float-left padding-top-10 padding-bottom-10">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">Store:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <select @change="set_variable($event,'store')" required v-model="form.store_id" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.store_id}">
                                                                                                                            <option value="" selected disabled>-select-</option>
                                                                                                                            <option v-for="(facility_lis, index) in initialization.stores" :value="facility_lis.id" :key="'practice_list'+index">{{facility_lis.name}}</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="width-20-pc float-left padding-top-10 padding-bottom-10">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">Sub Store:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <select @change="set_variable($event,'substore')" required v-model="form.sub_store_id" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.sub_store_id}">
                                                                                                                            <option value="" selected disabled>-select-</option>
                                                                                                                            <option v-for="(sub_sto, index) in initialization.sub_stores" :value="sub_sto.id" :key="'practice_list'+index">{{sub_sto.name}}</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="width-20-pc float-left padding-top-10 padding-bottom-10">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">Category:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <select @change="set_variable($event,'category')" required v-model="form.category" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.category}">
                                                                                                                            <option value="" selected disabled>-select-</option>
                                                                                                                            <option v-for="(catego, index) in products_attributes.categories" :value="catego.name" :key="'practice_list'+index">{{catego.name}}</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="width-30-pc float-left">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">Inventory Item:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <select @change="set_variable($event,'item')" required v-model="form.item_name" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.item_name}">
                                                                                                                            <option value="" selected disabled>-select-</option>
                                                                                                                            <option v-for="(catego, index) in products_attributes.categories" :value="catego.name" :key="'practice_list'+index">{{catego.name}}</option>
                                                                                                                        </select>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="width-20-pc float-left">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">From:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <input type="date" required v-model="form.date_1" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.date_1}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="width-20-pc float-left">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <label class="fs-13 fw-600 text-left width-100-pc padding-right-3">To:</label>
                                                                                                                </div>
                                                                                                                <div class="inlineBlock width-100-pc">
                                                                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                                                        <input type="date" required v-model="form.date_2" v-bind:class="{'width-100-pc height-27 report-filters-inputs':true,'ctm-attended-field':form.date_1}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                        <div class="width-20-pc float-left">
                                                                                                            <div class="row fullName margin-5">
                                                                                                                <div class="inlineBlock width-100-pc text-right padding-top-25">
                                                                                                                    <button type="submit" class="btn combo-button combo-default float-right">Run Report</button>
                                                                                                                    <button type="submit" class="btn combo-button combo-default float-right">Reset</button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12 text-center report-head">
                                                                                <img src="/assets/img/amref-white.png">
                                                                                <h5 class="txt-uppercase fs-12 fw-600"><span>AMREF Enterprises</span> | <span class="cl-amref">AMREF Health Africa</span></h5>
                                                                                <h5 class="txt-uppercase">({{form.facility_name}})</h5>
                                                                                <h5 class="">
                                                                                    <span v-if="form.department"><span class="fs-13 fw-600 cl-444">Department:</span> {{form.department}},</span>&nbsp;
                                                                                    <span v-if="form.store"><span class="fs-13 fw-600 cl-444">Store:</span> {{form.store}}</span>&nbsp;
                                                                                    <span v-if="form.sub_store"><span class="fs-13 fw-600 cl-444">Sub-Store:</span> {{form.sub_store}}</span>&nbsp;
                                                                                </h5>
                                                                                <h5 class="txt-uppercase fw-800 fs-17">{{form.report_type}}</h5>
                                                                                <h5>{{form.date_format}}</h5>
                                                                                <h5 class="">
                                                                                    <span v-if="form.category"><span class="fs-13 fw-600 cl-444">Category:</span> {{form.category}}</span>
                                                                                </h5>
                                                                                <h5 v-if="form.item_name" class="txt-uppercase">{{form.item_name}}</h5>
                                                                            </div>
                                                                        </div>
                                                                        <sfs-report v-if="form.report_generated" :server_data="server_data" :report_description="form.report_description" :report_name="form.report_type"></sfs-report>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div v-if="!run_report" class="width-100-pc">
                                                    <table v-for="(report,index) in reports" :key="'reports'+index" class="receipt-report-table table table-bordered mg-top-5">
                                                        <tbody>
                                                            <tr data-toggle="collapse" :data-target="'#collapseme_'+index" class="pointer-cursor header-tr">
                                                                <td colspan="2"> <i class="fa fa-check-square-o"></i> {{report.section}}</td>
                                                            </tr>
                                                            <tr class="pointer-cursor body-tr">
                                                                <td colspan="2" class="zeroPadding">
                                                                    <div class="collapse out width-100-pc padding-20" :id="'collapseme_'+index">
                                                                        <table class="table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width:28%">Report Type</th>
                                                                                    <th style="width:72%">Description</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(item,index_i) in report.data" :key="'index_i'+index_i">
                                                                                    <td class=""><a @click="run_reports(item)">{{item.name}}</a></td>
                                                                                    <td>{{item.description}}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                                    <div class="box-header box-header-custom mg-top-30">

                                        <div class="pull pull-right width-100-pc">

                                            <select @change="setInputs($event,'report_type')" class="height-32 form-control float-left mg-right-3 width-250-px" v-bind:style="{borderRadius:'5px'}">
                                                <option disabled selected value="">-Report Type-</option>
                                                <option value="Stock Visibility Dashboard">Stock Visibility Dashboard</option>
                                                <option value="Stock Ledger Report">Stock Ledger Report</option>
                                                <option value="Days Supply Left In Stock">Days Supply Left In Stock</option>
                                                <option value="Detailed Adjustment">Detailed Adjustment</option>
                                                <option value="Detailed Stock Usage">Detailed Stock Usage</option>
                                                <option value="Detailed Stock Transfer">Detailed Stock Transfer</option>
                                                <option value="Expiration Date">Expiration Date</option>
                                                <option value="Inventory By Location">Inventory By Location</option>
                                                <option value="Inventory Valuation">Inventory Valuation</option>
                                                <option value="Summary Stock Usage">Summary Stock Usage</option>
                                                <option value="Summary Stock Transfer">Summary Stock Transfer</option>
                                                <option value="Drug Wise Summary">Drug Wise Summary</option>
                                                <option value="Item Movement Report">Item Movement Report</option>
                                                <option value="Cash Summary Report"></option>
                                            </select>

                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown" style="box-shadow: inset 0 -1px 0 #DFDFDF;">
                                                <button type="button" @click="generate_report" class="btn combo-button combo-default">Generate</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-body bg-white padding-right-20 padding-left-20">

                                        <div class="row">

                                            <div class="col-lg-12 mg-top-30 mg-bottom-20">
                                                <div class="width-100-pc">
                                                    <select @change="setInputs($event,'branch')" class="height-32 form-control width-200-px float-left mg-right-10">
                                                        <option disabled selected value="">-Facility/Branch-</option>
                                                        <option v-for="(facility,index) in initializations.facilities" :value="facility.id" :key="'facility_'+index">{{facility.name}}</option>
                                                    </select>
                                                    <div class="float-left width-400-px mg-right-10">
                                                        <label class="fs-13 width-20-pc pull-left text-right mg-top-5">Date Range:</label>
                                                        <input type="date" v-model="form.date_1" class="height-32 form-control width-38-pc pull-left mg-right-3">
                                                        <input type="date" v-model="form.date_2" class="height-32 form-control width-38-pc pull-left">
                                                    </div>
                                                    <select v-model="form.category" class="height-32 form-control width-200-px float-left mg-right-3">
                                                        <option disabled selected value="">-Category-</option>
                                                        <option value="Drugs">Drugs</option>
                                                        <option value="Equipment">Equipment</option>
                                                        <option value="Supplies">Supplies</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div v-if="form.report_generated" class="col-lg-12">
                                                <div class="width-100-pc text-center report-header">
                                                    <h3 class="enterprises">AMREF Enterprises | AMREF Health Africa</h3>
                                                    <h3 class="branch">{{form.facility_name}}</h3>
                                                    <h3>{{form.report_type}}</h3>
                                                    <h3>Date:{{form.date_1}} to {{form.date_2}}</h3>
                                                    <h3>{{form.category}}</h3>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <table class="table ledgers-table table-hover">
                                                    <tbody v-if="form.report_generated && report_data.length>0">
                                                        <tr v-for="(stock_trans,index) in transactions" :key="'index'+index">
                                                            <td style="width:45%">
                                                                <table>
                                                                    <tr :key="'key_'+index1">
                                                                        <td style="width:20%">{{stock_trans.date_of_trans}}</td>
                                                                        <td style="width:20%">{{stock_trans.origin}}</td>
                                                                        <td style="width:40%">{{stock_trans.product_item}}</td>
                                                                        <td style="width:20%" class="btn-link active text-right">{{stock_trans.amount}}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td style="width:55%">
                                                                <table>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody v-if="form.report_generated && report_data.length < 1">
                                                        <tr>
                                                            <td colspan="2" class="cl-red text-center fs-13">No data to generate report</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-header box-header-custom">
                                        <div class="width-20-pc pull-right">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown" style="box-shadow: inset 0 -1px 0 #DFDFDF;">
                                                <button data-toggle="modal" data-target="#product_item_modal" type="button" class="btn combo-button combo-default"> Print</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu mr-10" aria-labelledby="btnGroupDrop">
                                                        <a class="dropdown-item"> Export as CSV</a>
                                                        <a class="dropdown-item"> Email</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                    </section>

                </div>

            </div>
        </div>
    </div>
</template>

<script>

    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import SideBarHr from "../../partials/sidebars/SideBarHr";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import SfsReport from "../../partials/reports/inventory/SfsReport";
    import SearchDatabaseFormControl from '../../partials/search/SearchDatabaseFormControl';
    import {get, post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {formatMoney,removeElement,getDates,createHtmlErrorString,location_obj_setter} from "../../../../../helpers/functionmixin";
    import SearchItemField from '../../partials/modals/product/SearchItemField';
    import {PRODUCT_URL,PRODUCT_STOCK_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_REPORTS_URL,PRODUCT_ATTRIBUTES_URL } from '../../../../../router/api_routes';

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,
        SideBarHr,SearchDatabaseFormControl,
        ProcessingOverlay,PaginateTemplate,
        SearchItemField,CommonLinks,SfsReport},
        data(){
            return {
                initializations: {},
                report_object: {},
                practice_product_items: [],
                transactions: [],
                server_data: {},
                reports: [],
                taxes: [],
                products_attributes: [],
                manufacturers: [],
                report_data: [],
                prod_loaded: false,
                practice_id: '',
                is_page_ready: false,
                run_report: false,
                progress_overlay: 'hide',
                active_filter: 0,
                pagination: {
                    'current_page': 1
                },
                form: {
                    report_id: '',
                    report_type: '',
                    report_description: '',
                    date_range: '',
                    facility_name: '',
                    practice_id: '',
                    report_generated: false,
                    graphical_view: false,
                    date_1: '',
                    date_2: '',
                    date_format: "As of September 4, 2019",
                    category: '',
                    item_name: '',
                    department: '',
                    department_id: '',
                    store: '',
                    store_id: '',
                    sub_store: '',
                    sub_store_id: '',
                },
                initialization: {},
                selected_practice_id: '',
            }
        },
        methods: {

            run_reports(report_obj,run_repo = true){
                if(run_repo){
                    this.form.report_type = report_obj.name;
                    this.form.report_description = report_obj.description;
                    this.form.report_id = report_obj.id;
                    this.run_report = run_repo;
                    this.generate_report();
                }else{
                    this.run_report = run_repo;
                }
            },

            set_variable(event,type_){
                switch(type_){
                    case "facility":
                        this.initialization = location_obj_setter(this.initializations,event.target.value);
                        this.selected_practice_id = event.target.value;
                        for (let index = 0; index < this.initializations.facilities.length; index++) {
                            const element = this.initializations.facilities[index];
                            if(element.id === this.selected_practice_id){
                                this.form.facility_name = element.name;
                                break;
                            }
                        }
                        break;
                    case "department":
                        for (let index = 0; index < this.initializations.departments.length; index++) {
                            const element = this.initializations.departments[index];
                            if(element.id === event.target.value){
                                this.form.department = element.name;
                                break;
                            }
                        }
                        break;
                    case "store":
                        for (let index = 0; index < this.initializations.stores.length; index++) {
                            const element = this.initializations.stores[index];
                            if(element.id === event.target.value){
                                this.form.store = element.name;
                                break;
                            }
                        }
                        break;
                    case "substore":
                        for (let index = 0; index < this.initializations.sub_stores.length; index++) {
                            const element = this.initializations.sub_stores[index];
                            if(element.id === event.target.value){
                                this.form.sub_store = element.name;
                                break;
                            }
                        }
                        break;
                }
            },

            filter_method(index_to,item_type_id,item_type_name){
                this.active_filter = index_to;
                switch(item_type_name){
                    case "All":
                        break;
                    default:
                        break;
                }
            },

            setInputs(event,type_){
                switch(type_){
                    case "report_type":
                        this.form.report_type = event.target.value;
                        break;
                    case "branch":
                        for( let k=0; k<this.initializations.facilities.length;k++ ){
                            if( event.target.value === this.initializations.facilities[k].id  ){
                                this.form.facility_name = this.initializations.facilities[k].name;
                                this.form.facility_id = this.initializations.facilities[k].id;
                                break;
                            }
                        }
                        break;
                }
            },

            generate_report(){
                this.progress_overlay = "show";
                post(PRODUCT_REPORTS_URL, this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.transactions = res.data.results.data;
                        this.server_data = res.data.results;
                        console.info(this.transactions);
                        this.form.date_format = res.data.results.selected_dates;
                        this.progress_overlay = "hide";
                        this.form.report_generated = true;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        this.$router.push("/500")
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            loadProducts(item_type_name){},

            redirect_to_item(item_to){
                window.location.href = "/item/"+item_to.id+"/view";
            },

            getTax(tax_array){
                let str_returned = '';
                return str_returned;
            },

            loadProductStock(){
                this.progress_overlay = "show";
                get(PRODUCT_STOCK_URL+'/practice/'+this.practice_id+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.transactions = res.data.results;
                        this.loadInitials();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadReports(){
                this.progress_overlay = "show";
                get(PRODUCT_REPORTS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.reports = res.data.results;
                        this.loadInitials();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadProductAttr(){
                get(PRODUCT_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.products_attributes = res.data.results;
                        this.is_page_ready = true;
                        this.prod_loaded = true;
                        this.progress_overlay = "hide";
                        //console.info(this.products_attributes);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadInitials(){
              this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        //console.info(this.initializations);
                        // this.is_page_ready = true;
                        // this.prod_loaded = true;
                        //this.progress_overlay = "hide";
                        this.loadProductAttr();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        //this.$router.push('/500');
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            delete_item(item_to){
                this.initializations.product_items = removeElement(this.initializations.product_items,item_to);
                this.practice_product_items = this.initializations.product_items;
            }

        },
        mounted(){
            //let account = Auth.getCurrentAccount('account');
            this.form.facility_name = Auth.getCurrentAccount('facility');
            this.form.practice_id = Auth.getCurrentAccount('id');
            this.form.date_1 = getDates("Default Date");
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadReports();
        }
    }
</script>

<style scoped>

</style>
