<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <!-- <div class="settings-header shadowed main-heading bg-foo">
                    </div> -->
                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-20-pc">
                                </div>
                                <div class="pull pull-right app-header width-70-pc">
                                    <common-links :active_link="'requistions'"></common-links>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-requisition :scrollable="false" :width="true" :transparent="true" :active_num="'dashboard'" :title="'Requisition'"></side-bar-requisition>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 bg-white min-height-100-vh">

                            <div class="box box-primary bg-white border-top-0 padding-top-60 border-bottom-0 padding-right-30 padding-left-15 no-shadowed min-height-100-vh">

                                <div class="row tiles-bg-settings">

                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box bordered-card">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">0</label></h3>
                                                <h4 class="paragraph cl-grey txt-uppercase">Pending Order Request</h4>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                            </div>
                                            <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box bordered-card">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">0</label></h3>
                                                <h4 class="paragraph cl-grey txt-uppercase">Pending Item Request</h4>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-bar-chart "></i>
                                            </div>
                                            <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box bordered-card">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">00.00</label></h3>
                                                <h4 class="paragraph cl-grey txt-uppercase">Approved Item Request</h4>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-fire" aria-hidden="true"></i>
                                            </div>
                                            <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-xs-6">
                                        <div class="small-box bordered-card ">
                                            <div class="inner">
                                                <h3><label class="label cl-grey">00.00</label></h3>
                                                <h4 class="paragraph cl-grey txt-uppercase">Approved Order Request</h4>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-dollar" aria-hidden="true"></i>
                                            </div>
                                            <router-link to="/" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></router-link>
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
    import SideBarRequisition from "../../partials/sidebars/SideBarRequisition";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,SideBarRequisition,CommonLinks},
        data(){
            return {
                
            }
        },
        methods: {
            
        },
        mounted() {
        }
    }
</script>

