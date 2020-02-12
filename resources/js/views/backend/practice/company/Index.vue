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
                                                <div class="width-60-pc float-left mg-top-20">
                                                    <a class="fw-600 cl-444 fs-20">
                                                        Open and Manage Companies
                                                    </a>
                                                </div>
                                                <div class="width-40-pc float-right mg-top-20">
                                                    <a data-toggle="modal" data-target="#add_user_1" class="float-right btn btn-secondary banking-process-amref mg-bottom-10">Add Company</a>
                                                </div>
                                                <div v-if="page_ready" class="width-100-pc float-left mg-top-20">
                                                    <div class="width-100-pc float-left mg-top-10">
                                                        <div class="fs-12 alert alert-info">
                                                            <span>You last worked in <b>Collombo Company</b> on <b>11 February 2020</b> at <b>01:15 AM </b><br>Choose another company to open from the list below. If your company does not appear in the list, your company has been deleted or you do not have access.</span>
                                                        </div>
                                                        <div class="width-35-pc float-left mg-top-20">
                                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                                <div class="inlineBlock width-30-pc text-right">
                                                                    <label class="company-label text-right fs-12 width-100-pc">Switch Company:&nbsp;&nbsp;</label>
                                                                </div>
                                                                <div class="inlineBlock width-70-pc">
                                                                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                        <vue-single-select
                                                                                name="maybe"
                                                                                placeholder=""
                                                                                you-want-to-select-a-post="ok"
                                                                                v-model="switched_company"
                                                                                out-of-all-these-posts="makes sense"
                                                                                :options="companies"
                                                                                a-post-has-an-id="good"
                                                                                the-post-has-a-title="make"
                                                                                option-label="name"
                                                                        ></vue-single-select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-35-pc float-right mg-top-20">
                                                            <div class="row fullName mg-bottom-5 mg-left-30">
                                                                <div class="inlineBlock width-70-pc text-right">
                                                                    <label class="company-label text-right fs-12 width-100-pc">Open Last Used Company on Log On&nbsp;&nbsp;</label>
                                                                </div>
                                                                <div class="inlineBlock width-30-pc">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <table class="table itemized x-panel">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 30%;">Company Name</th>
                                                                        <th style="width: 15%;">Last Login</th>
                                                                        <th style="width: 20%;" class="">Financial Year End</th>
                                                                        <th style="width: 15%;">Next VAT Submission Due</th>
                                                                        <th style="width: 10%;" class="">Active</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(company,index) in companies" :key="'companies'+index">
                                                                        <td class="padded">{{company.name}}</td>
                                                                        <td class="padded">{{company.name}}</td>
                                                                        <td class="padded">{{company.email}}</td>
                                                                        <td class="padded">{{company.mobile}}</td>
                                                                        <td class="padded"><input disabled v-model="company.status" type="checkbox"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="width-100-pc float-left text-center mg-top-30">
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
                    <delete-modal v-if="page_ready"
                                  :modal_id="'remove_user_modal_id'"
                                  :confirm_message="'Are you sure?'"
                                  :item_url="item_url"
                                  :modal_title="modal_title"
                                  @delete-item-event="loadCompany(company.id)">
                    </delete-modal>
                    <copy-right></copy-right>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import PaginateTemplate from '../partials/pagination/PaginateTemplate';
    import DeleteModal from "../partials/modals/DeleteModal";
    import CopyRight from "../partials/CopyRight";
    import {get} from "../../../../helpers/api";
    import {
        PERMISSIONS_API,
        PRACTICE_ROLE_URL,
        PRACTICE_USERS_API,
        PRACTICES_API
    } from "../../../../router/api_routes";
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";
    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,SideBar,CopyRight,DeleteModal},
        data(){
            return {
                companies: [],
                company: null,
                current_user: null,
                company_users: [],
                invited_users: [],
                is_initializing: false,
                selected_company: null,
                selected_companies: [],
                permissions: [],
                page_ready: false,
                PRACTICE_ROLE_URL: PRACTICE_ROLE_URL,
                item_url: null,
                modal_title: null,
                switched_company: null,
            }
        },
        methods: {

            deleteUser(company_user,action_){
                this.modal_title = action_;
                this.item_url = PRACTICE_USERS_API+'/'+company_user.id+'?action='+action_+'&company_id='+this.company.id;
                this.current_user = company_user;
            },

            selectCompany(event){
                this.selected_companies = [];
                if(event.target.checked){
                    this.selected_companies.push(event.target.value);
                    this.loadCompany(event.target.value);
                }else {
                    this.company_users = [];
                    this.invited_users = [];
                }
            },

            loadCompany(uuid){
                this.is_initializing = true;
                get(PRACTICES_API+'/'+uuid)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.company = res.data.results;
                            console.info(this.company);
                            this.company_users = [];
                            this.invited_users = [];
                            for ( let i = 0; i < this.company.users.length; i++ ){
                                const element = this.company.users[i];
                                if (element.can_access_company){
                                    this.company_users.push(element);
                                }else {
                                    this.invited_users.push(element);
                                }
                            }
                            this.is_initializing = false;
                        }
                    }).catch((err) => {
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            loadCompanies(){
                this.is_initializing = true;
                get(PRACTICES_API)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.companies = res.data.results.data;
                            if(this.companies.length){
                                this.company = this.companies[0];
                                this.page_ready = true;
                            }
                            this.is_initializing = false;
                        }
                    }).catch((err) => {
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },
            loadPermissions() {
                get(PERMISSIONS_API)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.permissions = res.data.results;
                            this.loadCompanies();
                        }
                    })
                    .catch((err) => {
                    });
            },
        },
        mounted() {
            this.loadPermissions();
        }
    }
</script>

<style scoped>

</style>