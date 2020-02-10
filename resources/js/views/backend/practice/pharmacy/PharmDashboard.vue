<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            
            <div class="row">

                <div class="col-lg-12">

                    <div class="settings-header shadowed  main-heading bg-foo pd-3-rem">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left width-30-pc">
                                    <span class="fs-15 fw-600 cl-444">Available Prescriptions List:</span>
                                </div>
                                <div class="pull pull-right width-60-pc text-right padding-right-70">
                                    <router-link to="/pharmacy" class="btn-link cl-444">Pharmacy | </router-link>
                                    <router-link to="/pharmacy/prescription" class="btn-link cl-444">Prescriptions</router-link>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="cl-amref fs-14">Friday, July 8, 2016</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content bg-white mg-top-20">

                        <div class="row">

                            <!-- <div class="col-lg-2 padding-right-0 padding-left-0">
                                <div class="bg-eee width-100-pc min-height-70-pc">
                                    <div class="row">
                                        <div class="col-xs-12 ">
                                            <nav>
                                                <div class="nav nav-tabs nav-tabs-amref nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-item-amref nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Doctors</a>
                                                    <a class="nav-item nav-item-amref nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Walk-in</a>
                                                    <a class="nav-item nav-item-amref nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Online</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content tab-content-amref px-sm-0 padding-right-0 padding-left-0 padding-top-0 padding-bottom-0" id="nav-tabContent">
                                                <div class="tab-pane show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                    <table class="amref-tab-menu-table table-hover">
                                                        <tbody>
                                                            <tr v-for="(item, index) in 20" :key="'doctors_'+index" v-bind:class="{'active':active_prescript===index+1}">
                                                                <td style="width:10%;" class="lb-0"><img src="/assets/icons/dashboard/medical-doctor-40.png"></td>
                                                                <td @click="setCurrentPrescript(item,index+1)" style="width:90%;" class="rb-0">Dr. Borne Breaker{{index+1}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    <table class="amref-tab-menu-table table-hover">
                                                        <tbody>
                                                            <tr v-for="(item, index) in 20" :key="'walk_in_'+index" v-bind:class="{'active':active_prescript===index+1}">
                                                                <td style="width:10%;" class="lb-0"><img src="/assets/icons/dashboard/elderly-person-50.png"></td>
                                                                <td @click="setCurrentPrescript(item,index+1)" style="width:90%;" class="rb-0">Dr. Borne Breaker{{index+1}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                    <table class="amref-tab-menu-table table-hover">
                                                        <tbody>
                                                            <tr v-for="(item, index) in 20" :key="'online_'+index" v-bind:class="{'active':active_prescript===index+1}">
                                                                <td style="width:10%;" class="lb-0"><img src="/assets/icons/dashboard/firefox-50.png"></td>
                                                                <td @click="setCurrentPrescript(item,index+1)" style="width:90%;" class="rb-0">Dr. Borne Breaker{{index+1}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="text-center bottom-filter">
                                                <a @click="setBottomFilter('all')" v-bind:class="{'active':bottom_filter==='all'}">All</a>
                                                <a @click="setBottomFilter('prescribed')" v-bind:class="{'active':bottom_filter==='prescribed'}">Prescribed</a>
                                                <a @click="setBottomFilter('dispensed')" v-bind:class="{'active':bottom_filter==='dispensed'}">Dispensed</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-lg-12 padding-left-0 padding-right-0">
                                <div class="bg-eee width-100-pc prescript-header">
                                    <h4>Doctor's Prescription</h4>
                                </div>
                                <div class="width-100-pc prescript-body">
                                    <div class="row">
                                        <div class="col-lg-9">

                                            <div class="width-80-pc patient-info">

                                                <div class="width-50-pc float-left">
                                                    <table class="prescrption-table">
                                                        <tbody>
                                                            <tr>
                                                                <td class="width-40-pc label-td-yellow">Registration No:</td>
                                                                <td class="width-60-pc btn-link">12345</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">Patient name:</td>
                                                                <td class="txt-uppercase">John Doe Test</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">Next to Kin:</td>
                                                                <td class="txt-uppercase">John Doe Kin</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">Mobile No:</td>
                                                                <td class="txt-uppercase">John Doe Kin</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">DOB & Age:</td>
                                                                <td>Sep 3 1960 30Yrs 3Mon</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">Gender</td>
                                                                <td class="txt-uppercase">Male</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">Height:</td>
                                                                <td>cm</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">Weight:</td>
                                                                <td class="txt-uppercase">70.20Kg</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-yellow">BMI</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="width-50-pc float-left">
                                                    <table class="prescrption-table">
                                                        <tbody>
                                                            <tr>
                                                                <td class="width-50-pc label-td-pink">Known alergies:</td>
                                                                <td class="width-50-pc">NONE</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">Prescription Type:</td>
                                                                <td>Outpatient</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">Doctor's name:</td>
                                                                <td class="txt-uppercase">Born Breaker Dr.</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">
                                                                    <label class="check-container small width-100-pc fs-13 element-inlined">Prescribed By:
                                                                        <input type="checkbox">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </td>
                                                                <td class="txt-uppercase">Borne Breaker</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">Company name:</td>
                                                                <td>AMREF</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">Covered By:</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">
                                                                    <label class="check-container small width-100-pc fs-13 element-inlined">Receipt No:
                                                                        <input type="checkbox">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">
                                                                    <label class="check-container small width-100-pc fs-13 element-inlined">Creditslip No:
                                                                        <input type="checkbox">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </td>
                                                                <td>OP098765</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label-td-pink">
                                                                    <label class="check-container small width-100-pc fs-13 element-inlined">IP Invoice No:
                                                                        <input type="checkbox">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="width-100-pc prescription-trans">
                                                    <div class="">
                                                        <table class="prescrption-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Doctor's Prescription</th>
                                                                    <th>Preparation & Dispense</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="width-100-pc patient-info">

                                                <div class="width-100-pc prescription-trans">
                                                    <div class="">
                                                        <table class="prescrption-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Doctor's Prescription</th>
                                                                    <th>Preparation & Dispense</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-3">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </section>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarHr from "../partials/sidebars/SideBarHr"
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import DeleteModal from '../../practice/partials/modals/DeleteModal'
    // import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal'
    // import ProductModal from '../../practice/partials/modals/product/ProductModal'
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {formatMoney,removeElement} from "../../../../helpers/functionmixin";

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,SideBarHr,ProcessingOverlay,DeleteModal},
        data(){
            return {
                initialUrl: '/api/pharmacy',
                initializations: {},
                practice_product_items: [],
                prod_loaded: false,
                practice_id: '',
                is_page_ready: false,
                progress_overlay: 'hide',
                product_list_filters: [],
                active_filter: 0,
                active_prescript: 0,
                bottom_filter: 'all',
                work_place: {},
            }
        },
        methods: {
            setCurrentPrescript(item_,index_){
                console.info(this.active_prescript);
                this.active_prescript = index_;
            },
            setBottomFilter(bott_filter){
                this.bottom_filter = bott_filter;
            }
        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.work_place = Auth.getCurrentAccount("work_place");
            this.practice_id = this.work_place.id;
            console.info(this.work_place);
            //this.loadInitializations();
        }
    }
</script>

<style scoped>

    nav > .nav.nav-tabs-amref{
        border: none;
        color:#fff;
        /* background:#272e38; */
        background: #787887;
        border-radius:0;
    }
    nav > div a.nav-item-amref.nav-link,
    nav > div a.nav-item-amref.nav-link.active
    {
        border: none;
        /* padding: 18px 25px; */
        padding: 8px 4px;
        color:#fff;
        /* background:#272e38; */
        background: #787887;
        border-radius:0;
        text-transform: none;
        font-size: 12px;
        font-weight: 600;
    }
    nav > div a.nav-item-amref.nav-link.active{
        background: #fff;
        color: #787887;
    }
    nav > div a.nav-item-amref.nav-link.active:after
    {
        content: "";
        position: relative;
        bottom: -60px;
        left: -10%;
        /* border: 15px solid transparent;
        border-top-color: #d34336 ; */
    }
    .tab-content-amref{
        background: #fdfdfd;
        line-height: 25px;
        border: 1px solid #ddd;
        /* border-top:5px solid #e74c3c;
        border-bottom:5px solid #e74c3c; */
        padding:30px 25px;
        max-height: 450px;
        overflow-y: auto;
    }
    nav > div a.nav-item-amref.nav-link:hover,
    nav > div a.nav-item-amref.nav-link:focus
    {
        border: none;
        /* background: #e74c3c; */
        /* background: #d34336; */
        background: #fff;
        color:#787887;
        border-radius:0;
        transition:background 0.20s linear;
    }

    table.amref-tab-menu-table tbody tr{
        max-height: 30px;
        cursor: pointer;
    }
    table.amref-tab-menu-table tbody tr td{
        font-size: 13px!important;
        max-height: 30px!important;
        padding: 4px 6px!important;
        border: 1px solid #ddd;
    }
    table.amref-tab-menu-table tbody tr td img{
        height: 20px;
        width: 20px;
    }
    table.amref-tab-menu-table tbody tr:last-child td{
        border-bottom: 0;
    }
    table.amref-tab-menu-table tbody tr:first-child td{
        border-top: 0;
    }
    table.amref-tab-menu-table tbody tr td.lb-0{
        border-left: 0;
    }
    table.amref-tab-menu-table tbody tr td.rb-0{
        border-right: 0;
    }

    table.amref-tab-menu-table tbody tr.active{
        background: #eee;
    }
    table.amref-tab-menu-table tbody tr.active td{
        border: 0!important;
        text-decoration: underline;
    }
    .bottom-filter{
        margin-top: 5px;
    }
    .bottom-filter a{
        border: 1px solid #787887;
        font-size: 13px;
        padding: 3px 5px;
        border-radius: 2px;
        cursor: pointer;
    }
    .bottom-filter a.active{
        background: #d34336;
        color: #fff!important;
        border-color: #d34336;
    }
    .bottom-filter a:hover{
        background: #787878;
        color: #fff!important;
        border-color: #787878;
    }


</style>