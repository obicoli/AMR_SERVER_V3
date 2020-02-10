<template>
    <div>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">

                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">

                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a class="fw-600 cl-444 fs-20">
                                                        My Profile
                                                    </a>
                                                </div>

                                                <div v-if="page_ready" class="width-100-pc float-left">
                                                    <div class="width-100-pc float-left">
                                                        <div class="width-70-pc float-left padding-15">
                                                            <div class="width-100-pc float-right mg-top-20">
                                                                <nav>
                                                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                        <a v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">My Details</a>
                                                                    </div>
                                                                </nav>
                                                                <div class="tab-content tab-content-role" id="nav-tabContent">
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                                        <div class="width-100-pc float-left fs-12">
                                                                            <form @submit.prevent="saveUser" class="width-50-pc float-left fs-12 mg-top-10">
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-100-pc">
                                                                                        <label class="fullname fw-600 fs-14">Contact Details</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-30-pc text-right">
                                                                                        <label class="company-label text-right fs-12 width-100-pc">First Name:&nbsp;&nbsp;</label>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-70-pc">
                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                            <input v-model="company_user.first_name" :disabled="processing" required class="width-100-pc report-filters-inputs" type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-30-pc text-right">
                                                                                        <label class="company-label text-right fs-12 width-100-pc">Last Name:&nbsp;&nbsp;</label>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-70-pc">
                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                            <input v-model="company_user.other_name" :disabled="processing" required class="width-100-pc report-filters-inputs" type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-30-pc text-right">
                                                                                        <label class="company-label text-right fs-12 width-100-pc">Email:&nbsp;&nbsp;</label>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-60-pc">
                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                            <input class="width-100-pc report-filters-inputs ctm-attended-field" disabled type="email" v-model="company_user.email" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-10-pc padding-5">
                                                                                        <a class="fs-12 cl-blue-link fw-600" title="Change">Change</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-30-pc text-right">
                                                                                        <label class="company-label text-right fs-12 width-100-pc">Mobile:&nbsp;&nbsp;</label>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-70-pc">
                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                            <input v-model="company_user.mobile" :disabled="processing" required class="width-100-pc report-filters-inputs" type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-100-pc">
                                                                                        <button :disabled="processing" type="submit" data-dismiss="modal" class="btn btn-secondary banking-process-amref float-right">
                                                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                                                                            <span v-else>Save</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <!-- --------------------------------------------- -->
                                                                        </div>

                                                                        <div class="width-100-pc float-left fs-12">
                                                                            <!-- --------------------------------------------- -->
                                                                            <form @submit.prevent="changePassword()" class="width-50-pc float-left fs-12">
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-100-pc">
                                                                                        <label class="fullname fw-600 fs-14">Change Password</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-50-pc text-right">
                                                                                        <label class="company-label text-right fs-12 width-100-pc">Old Password:&nbsp;&nbsp;</label>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-50-pc">
                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                            <input v-model="form.old_password" :disabled="processing" required class="width-100-pc report-filters-inputs" type="password">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-50-pc text-right">
                                                                                        <label class="company-label text-right fs-12 width-100-pc">New Password:&nbsp;&nbsp;</label>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-50-pc">
                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                            <input v-model="form.password" :disabled="processing" required class="width-100-pc report-filters-inputs" type="password">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-50-pc text-right">
                                                                                        <label class="company-label text-right fs-12 width-100-pc">Confirm New Password:&nbsp;&nbsp;</label>
                                                                                    </div>
                                                                                    <div class="inlineBlock width-50-pc">
                                                                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                            <input v-model="form.password_confirmation" :disabled="processing" class="width-100-pc report-filters-inputs" type="password">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row fullName mg-bottom-5 mg-left-30">
                                                                                    <div class="inlineBlock width-100-pc">
                                                                                        <button :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref">
                                                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                                                                            <span v-else>Change Password</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <!-- --------------------------------------------- -->
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="checkPerms(ADMIN_PERM.ROLES.VIEW) || checkPerms(ADMIN_PERM.USERS.VIEW)" class="width-25-pc float-right padding-15 additionalInformation-panel mg-top-80">
                                                            <div style="padding-top: 5px">
                                                                <span class="cl-444 fw-600 fs-12" style="line-height: 26px;">
                                                                    Invite Accountant or Additional Users
                                                                </span>
                                                                <p class="fs-12">
                                                                    Click <router-link :to="ADMINSTRATIVE.USERS" class="pointer-cursor cl-blue-link">here</router-link> to invite your accountant
                                                                    as well as other users to access your company data.
                                                                </p>
                                                                <br>
                                                                <span class="cl-444 fw-600 fs-12" style="margin-top: 5px;">
                                                                    User List
                                                                </span>
                                                                <p class="fs-12">
                                                                    Click <router-link :to="ADMINSTRATIVE.USERS" class="pointer-cursor cl-blue-link">here</router-link> to manage the list of
                                                                    users that have access to your company data.
                                                                </p>
                                                                <br>
                                                                <span class="cl-444 fw-600 fs-12" style="margin-top: 5px;">
                                                                    User Access Rights
                                                                </span>
                                                                <p class="fs-12">
                                                                    Click <router-link :to="ADMINSTRATIVE.USER_ACCESS" class="pointer-cursor cl-blue-link">here</router-link> to assign different access
                                                                    rights to each of your users. This will allow you to choose which areas of your company
                                                                    data you want your users to have access to.
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="width-100-pc float-left mg-top-30 text-center">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
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
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <copy-right></copy-right>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from "../../partials/CopyRight";
    import {ADMINSTRATIVE} from "../../../../../router/web_routes";
    import {get, post} from "../../../../../helpers/api";
    import {CHANGE_PASSWORD, PRACTICE_USERS_API} from "../../../../../router/api_routes";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString, reset_forms} from "../../../../../helpers/functionmixin";
    import {ADMIN_PERM} from "../../../../../helpers/permissions";

    export default {
        name: "MyAccount",
        components: {TopNavBar,PaginateTemplate,SideBar,CopyRight},
        data(){
            return {
                curr_tab: 0,
                is_initializing: false,
                page_ready: false,
                company_user: null,
                ADMINSTRATIVE:ADMINSTRATIVE,
                ADMIN_PERM: ADMIN_PERM,
                processing: false,
                form: {
                    old_password: null,
                    password: null,
                    password_confirmation: null,
                },
            }
        },
        methods: {
            checkPerms(perm_){
                return Auth.hasPermission(perm_)
            },
            changePassword(){
                this.processing = true;
                post(CHANGE_PASSWORD,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.form = reset_forms(this.form);
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        //console.info(err.response.data.errors);
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
            },

            loadUser(){
                get(PRACTICE_USERS_API+'/'+Auth.getCurrentAccount('staff_id'))
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.company_user = res.data.results;
                        this.page_ready = true;
                    }
                }).catch((err) => {
                });
            },

            saveUser(){
                this.processing = true;
                post(PRACTICE_USERS_API+'/'+this.company_user.id,this.company_user)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.loadUser();
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        //console.info(err.response.data.errors);
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
            },
        },
        mounted() {
            this.loadUser();
        }
    }
</script>

<style scoped>

</style>