<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :initialization="true"></page-header>

        <mobile-otp-overlay v-if="not_verified" v-on:otpVerificationSuccess="reloadBranch" :message="message" :mobile="mobile"></mobile-otp-overlay>

        <div class="content-wrapper">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-50-pc">
                            <h5>
                                Initialization |
                                <small>{{current_branch.name}} Branch</small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                        <div class="pull pull-right width-50-pc text-right">
                            <a data-toggle="modal" data-target="#" class="btn btn-inventory navy">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                Import
                            </a>
                            <a v-bind:href="'/initialization/branches'" class="btn btn-inventory">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back to Branches
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">
                    <div v-if="current_branch.status===0" class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <div class="alert alert-danger"><strong>Whoops!</strong> This branch is inactive, activation is required to perform any transaction</div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 col-sm-12">
                        <div class="item-info half ng-scope">
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Name:</div>
                                <div class="value">{{current_branch.name}}</div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Type:</div>
                                <div class="value ng-binding">{{current_branch.type}}</div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">REG. NO:</div>
                                <div class="value ng-binding">{{current_branch.reg_no}}</div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Mobile:</div>
                                <div class="value ng-binding">
                                    {{current_branch.mobile}}
                                    <span title="Verified" v-if="current_branch.phone_verified===1" class="btn btn-xs btn-success"><i class="fa fa-check"></i></span>
                                    <span v-else class="btn btn-xs btn-danger" title="Unverified"><i class="fa fa-close"></i></span>
                                </div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Email:</div>
                                <div class="value ng-binding">
                                    {{current_branch.email}}
                                    <span v-if="current_branch.mail_verified===1" class="btn btn-xs btn-success" title="Verified"><i class="fa fa-check-circle-o"></i></span>
                                    <span v-else class="btn btn-xs btn-danger" title="Unverified"><i class="fa fa-close"></i></span>
                                </div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Location:</div>
                                <div class="value ng-binding">{{current_branch.city}}, {{current_branch.country}}</div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Address:</div>
                                <div class="value tax-value ng-binding">{{current_branch.address}}</div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Website:</div>
                                <div class="value tax-value ng-binding">{{current_branch.website}}</div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Support:</div>
                                <div class="value tax-value ng-binding"><strong class="fs-13">Mail</strong>:{{current_branch.support_email}}, Mobile:</div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Operational status:</div>
                                <div class="value tax-value ng-binding">
                                    <span v-if="current_branch.status===1"><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-success':true}"></i> Active</span>
                                    <span v-else ><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-danger':true}"></i> Inactive</span>
                                </div>
                            </div>
                            <div class="info-block mg-bottom-10">
                                <div class="name txt-uppercase">Approval status:</div>
                                <div class="value tax-value ng-binding">
                                    <span v-if="current_branch.approval_status==='approved'"><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-success':true}"></i> Approved</span>
                                    <span v-else ><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-danger':true}"></i> Pending</span>
                                </div>
                            </div>
                        </div>
                        <div class="pull pull-right text-center width-100-pc">
                            <a data-toggle="modal" data-target="#edit_branch_modal" class="btn btn-inventory primary">
                                <i class="fa fa-edit" aria-hidden="true"></i>
                                Edit Branch
                            </a>
                            <a data-toggle="modal" data-target="#delete_branch_modal" class="btn btn-inventory">
                                <i class="fa fa-close" aria-hidden="true"></i>
                                Delete
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 col-sm-12 mg-top-20">
                        <div class="pull-left pull width-60-pc mg-bottom-5">
                            <select @change="" class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" style="width: 100%;">
                                <option value="">Search Department</option>
                            </select>
                        </div>
                        <div class="pull-right pull width-30-pc text-right mg-bottom-5">
                            <button title="Add New Department" :disabled="!show_analysis || current_branch.status===0" type="button" data-toggle="modal" data-target="#add_department_modal" class="btn btn-inventory">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add
                            </button>
                        </div>
                        <table class="items table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 50%">Departments</th>
                                <th style="width: 25%">Status</th>
                                <th style="width: 25%"></th>
                            </tr>
                            </thead>
                            <tbody class="noprintclass">
                            <tr v-if="show_analysis" v-for="departm in current_branch.departments">
                                <td>{{departm.name}}</td>
                                <td>
                                    <span v-if="departm.status==='1'"><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-success':true}"></i> Active</span>
                                    <span v-else ><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-danger':true}"></i> Inactive</span>
                                </td>
                                <td class="text-right">
                                    <a title="View more" class="cl-grey pointer-cursor"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a title="Delete" class="cl-red pointer-cursor"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4 col-sm-12 mg-top-20">
                        <div class="pull-left pull width-60-pc mg-bottom-5">
                            <select @change="" class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" style="width: 100%;">
                                <option value="">Search store</option>
                            </select>
                        </div>
                        <div class="pull-right pull width-30-pc text-right mg-bottom-5">
                            <button :disabled="!show_analysis || current_branch.status===0" type="button" data-toggle="modal" data-target="#add_store_modal" class="btn btn-inventory">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add Store
                            </button>
                        </div>
                        <table class="items table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 55%">Stores</th>
                                <th style="width: 20%">Status</th>
                                <th style="width: 25%"></th>
                            </tr>
                            </thead>
                            <tbody class="noprintclass">
                            <tr v-if="show_analysis" v-for="story in current_branch.stores">
                                <td>{{story.name}}</td>
                                <td>
                                    <span v-if="story.status==='1'"><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-success':true}"></i> Active</span>
                                    <span v-else ><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-danger':true}"></i> Inactive</span>
                                </td>
                                <td class="text-right">
                                    <a title="View more" class="cl-grey pointer-cursor"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a title="Delete" class="cl-red pointer-cursor"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_department_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <department-modal :user_mode="'Create'" :branch_id="current_branch.id" :form_data="dept_form" v-on:departmentAdded="reloadBranch"></department-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_store_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <store-modal :user_mode="'Create'" :form_data="dept_form" :branch_id="current_branch.id" v-on:storeAdded="reloadBranch"></store-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="edit_branch_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                        <branch-modal v-if="show_analysis" :user_mode="'Edit'" :form_data="current_branch" v-on:branchEdited="reloadBranch"></branch-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="delete_branch_modal">

                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="cl-grey"><i class="fa fa-trash-o"></i> Delete Branch</h4>
                                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                            </div>
                            <div  class="modal-body">
                                <p>Are you sure you want to delete this branch?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" @click="delete_branch" class="btn btn-inventory primary">
                                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Deleting...</span>
                                    <span v-else><i class="fa fa-trash-o" aria-hidden="true"></i> Yes, delete</span>
                                </button>
                                <button data-dismiss="modal" class="btn btn-inventory">
                                    Close
                                </button>
                            </div>
                        </div>

                    </div>

                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

            </section>

        </div>

        <page-footer></page-footer>

    </div>
    
</template>

<script>
    import PageHeader from '../../patials/Header'
    import MobileOtpOverlay from '../../patials/MobileOtpOverlay'
    import PageFooter from '../../patials/Footer'
    import Loading from '../../../../../components/loads/ProgRess'
    import ImagePreview from '../../../../../components/images/ImagePreview'
    import DepartmentModal from './partials/DepartmentModal'
    import StoreModal from './partials/StoreModal'
    import BranchModal from './partials/BranchModal'
    import Auth from "../../../../../store/auth";
    import {get,del} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";

    export default {
        components: {
            PageFooter,PageHeader,Loading,DepartmentModal,ImagePreview,MobileOtpOverlay,StoreModal,BranchModal
        },
        data(){
            return {
                processing: false,
                not_verified: false,
                show_analysis: false,
                current_branch: Auth.getCurrentBranch(),
                //avatar: Auth.getAvatar(),
                message: '',
                mobile: '',
                form: {
                    status: '',
                    //user_id: Auth.getKey(),
                    user_id: '',
                    name: '',
                    type: '',
                    address: '',
                    city: '',
                    country: '',
                    website: '',
                    email: '',
                    mobile: '',
                    registration_number: '',
                },
                dept_form: {
                    name: '',
                    description: '',
                    branch_id: '',
                    status: '',
                },
            }
        },
        created(){

        },
        methods: {

            delete_branch(){
                let url_ = AppInfo.app_data.server_domain+'/api/practices/'+this.current_branch.id;
                del(url_)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            window.location.href = "/initialization/practices";
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },
            reloadBranch: function (branch_id = null) {
                //this.processing = true;
                let url_ = '';
                if (branch_id){
                    url_ = AppInfo.app_data.server_domain+'/api/practices/'+branch_id+'/Departments';
                } else {
                    url_ = AppInfo.app_data.server_domain+'/api/practices/'+this.current_branch.id+'/Departments';
                }
                console.info(url_);
                get(url_)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.current_branch = res.data.results;
                            console.info(this.current_branch);
                            Auth.setCurrentBranch(this.current_branch);
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        //this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    //this.processing = false;
                });
            },
        },
        mounted(){
            this.current_branch = Auth.getCurrentBranch();
            this.mobile = this.current_branch.mobile;
            if ( this.current_branch.phone_verified === 0 ){
                this.message = "OTP was sent to "+this.current_branch.mobile+". Please key in to continue";
                this.not_verified = true;
            }
            this.show_analysis = true;
            console.info(this.current_branch);
            this.reloadBranch();
        }
    }
</script>

<style scoped>

</style>