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
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a class="fw-600 cl-444 fs-20">
                                                        Control User Access
                                                    </a>
                                                </div>
                                                <div v-if="page_ready" class="width-100-pc float-left mg-top-20">
                                                    <div class="width-100-pc float-left mg-top-10">
                                                        <h3 class="fw-600 fs-12 cl-444">Select the company to manage user access and permissions</h3>
                                                        <div class="width-100-pc float-left bg-white min-height-180">
                                                            <table class="table itemized x-panel">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 5%;">Select</th>
                                                                        <th style="width: 50%;">Name</th>
                                                                        <th style="width: 20%;" class="">Email</th>
                                                                        <th style="width: 20%;">Mobile</th>
                                                                        <th style="width: 5%;" class="">Active</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(company,index) in companies" :key="'companies'+index">
                                                                        <td class="padded"><input type="checkbox" @click="selectCompany($event)" v-model="selected_companies" :value="company.id" class="pointer-cursor"></td>
                                                                        <td class="padded">{{company.name}}</td>
                                                                        <td class="padded">{{company.email}}</td>
                                                                        <td class="padded">{{company.mobile}}</td>
                                                                        <td class="padded"><input disabled v-model="company.status" type="checkbox"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="width-49-pc float-left mg-top-20">
                                                        <h3 class="fw-600 fs-12 cl-444">List of all users you have invited to <router-link class="cl-amref txt-uppercase" to="/">{{company.name}} Company</router-link></h3>
                                                        <div v-if="is_initializing" class="width-100-pc float-left">
                                                            <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                        </div>
                                                        <div v-else class="width-100-pc float-left bg-white min-height-180">
                                                            <table class="table itemized x-panel">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10%;">Select</th>
                                                                        <th style="width: 50%;">Name</th>
                                                                        <th style="width: 30%;" class="text-center">Email</th>
                                                                        <th style="width: 10%;" class="text-center">Active</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="padded"><input type="checkbox"></td>
                                                                        <td class="padded"><input type="checkbox"></td>
                                                                        <td class="padded"><input type="checkbox"></td>
                                                                        <td class="padded"><input type="checkbox"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="width-49-pc float-right mg-top-20">
                                                        <h3 class="fw-600 fs-12 cl-444">Users that have access to <router-link class="cl-amref txt-uppercase" to="/">{{company.name}} Company</router-link> </h3>
                                                        <div v-if="is_initializing" class="width-100-pc float-left">
                                                            <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                        </div>
                                                        <div v-else class="width-100-pc float-left bg-white min-height-180">
                                                            <table class="table itemized x-panel">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 40%;">Name</th>
                                                                        <th style="width: 30%;" class="">Email</th>
                                                                        <th style="width: 30%;" class="">Role</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(company_user,index) in company_users" :key="'company_users_'+index">
                                                                        <td class="padded">{{company_user.first_name+' '+company_user.other_name}}</td>
                                                                        <td class="padded">{{company_user.email}}</td>
                                                                        <td class="padded">
                                                                            <a class="cl-blue-link">{{company_user.role.name}}</a>
                                                                        </td>
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
    import DeleteModal from "../../partials/modals/DeleteModal";
    import BankAccountModal from "../../partials/modals/accounting/BankAccountModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import CopyRight from "../../partials/CopyRight";
    import AccountModal from "../../partials/modals/accounting/AccountModal";
    import SalesPurchaseModal from "../../partials/modals/accounting/SalesPurchaseModal";
    import AccountOpeningBalance from "../../partials/modals/accounting/AccountOpeningBalance";
    import {get} from "../../../../../helpers/api";
    import {CUSTOMERS_API, PRACTICES_API} from "../../../../../router/api_routes";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "UserAccess",
        components: {TopNavBar,PaginateTemplate,SideBar,CopyRight},
        data(){
            return {
                companies: [],
                company: null,
                company_users: [],
                invited_users: [],
                is_initializing: false,
                selected_company: null,
                selected_companies: [],
                page_ready: false,
            }
        },
        methods: {
            selectCompany(event){
                this.selected_companies = [];
                if(event.target.checked){
                    this.selected_companies.push(event.target.value);
                    this.loadCompany(event.target.value);
                }
            },

            loadCompany(uuid){
                this.is_initializing = true;
                get(PRACTICES_API+'/'+uuid)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.company = res.data.results;
                            console.info(this.company);
                            this.company_users = this.company.users;
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
                        console.info(this.companies);
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
        },
        mounted() {
            this.loadCompanies();
        }
    }
</script>

<style scoped>

</style>