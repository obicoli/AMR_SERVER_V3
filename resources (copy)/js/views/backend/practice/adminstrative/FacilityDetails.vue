<template>
    <div>
        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                    <side-bar-settings :scrollable="true" :width="true" :transparent="true" :active_num="1"></side-bar-settings>
                </div>
                <div class="col-md-10 col-lg-10 col-sm-10 padding-left-0">
                    <div class="settings-header main-heading">Facility Details</div>
                    <div class="ui fitted divider"></div>
                    <div class="item-info half">
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Name:</div>
                            <div class="value">{{current_branch.name}}</div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Type:</div>
                            <div class="value">{{current_branch.type}}</div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">REG. NO:</div>
                            <div class="value">{{current_branch.registration_number}}</div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Mobile:</div>
                            <div class="value">
                                {{current_branch.mobile}}
                                <span title="Verified" v-if="current_branch.phone_verified===1" class="btn btn-xs btn-success"><i class="fa fa-check"></i></span>
                                <span v-else class="btn btn-xs btn-danger" title="Unverified"><i class="fa fa-close"></i></span>
                            </div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Email:</div>
                            <div class="value">
                                {{current_branch.email}}
                                <span v-if="current_branch.mail_verified===1" class="btn btn-xs btn-success" title="Verified"><i class="fa fa-check-circle-o"></i></span>
                                <span v-else class="btn btn-xs btn-danger" title="Unverified"><i class="fa fa-close"></i></span>
                            </div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Location:</div>
                            <div class="value">{{current_branch.city}}, {{current_branch.country}}</div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Address:</div>
                            <div class="value tax-value">{{current_branch.address}}</div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Website:</div>
                            <div class="value tax-value">{{current_branch.website}}</div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Support:</div>
                            <div class="value tax-value"><strong class="fs-13">Mail</strong>:{{current_branch.support_email}}, Mobile:</div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Operational status:</div>
                            <div class="value tax-value">
                                <span v-if="current_branch.status===1"><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-success':true}"></i> Active</span>
                                <span v-else ><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-danger':true}"></i> Inactive</span>
                            </div>
                        </div>
                        <div class="info-block mg-bottom-10">
                            <div class="name txt-uppercase">Approval status:</div>
                            <div class="value tax-value">
                                <span v-if="current_branch.approval_status==='approved'"><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-success':true}"></i> Approved</span>
                                <span v-else ><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-danger':true}"></i> Pending</span>
                            </div>
                        </div>

                        <div class="pull pull-right text-center width-100-pc">
                            <a data-toggle="modal" data-target="#edit_branch_modal" class="btn btn-inventory">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                                Edit Branch
                            </a>
                            <a data-toggle="modal" data-target="#delete_branch_modal" class="btn btn-inventory">
                                <i class="fa fa-close" aria-hidden="true"></i>
                                Delete
                            </a>
                        </div>

                    </div>

                    <div class="modal fade" id="edit_branch_modal">
                        <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                            <branch-modal v-if="page_loaded" :form_data="current_branch" :item_id="current_branch.id" :initial_ur="initial_url" :branch_id="current_branch.id" v-on:branchEdited="get_branch" :user_mode="'Edit'"></branch-modal>
                        </div>
                    </div> <!-- Bootstrap model  ends-->

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarSettings from "../partials/sidebars/SideBarSettings"
    import BranchModal from "../../pharmacy/initialization/branches/partials/BranchModal"
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";

    export default {
        name: "FacilityDetails",
        components: {TopNavBar, SideBar,SideBarSettings,BranchModal},
        data(){
            return {
                current_branch: {},
                initial_url: '/api/practices',
                practice_id: '',
                processing: false,
                page_loaded: false,
            }
        },
        methods: {
            get_branch(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.current_branch.id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.current_branch = res.data.results;
                            this.processing = false;
                            this.page_loaded = true;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            }
        },
        mounted() {
            this.current_branch = Auth.getCurrentBranch();
            //console.info(this.current_branch);
            this.get_branch();
        }
    }
</script>

<style scoped>
    @import "../../../../../sass/style.css";
</style>