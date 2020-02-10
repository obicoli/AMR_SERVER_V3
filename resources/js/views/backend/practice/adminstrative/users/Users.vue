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
                                                        Manage Users
                                                    </a>
                                                </div>
                                                <div v-if="page_ready" class="width-100-pc float-left mg-top-20">
                                                    <div class="width-100-pc float-left mg-top-10">
                                                        <a class="fw-600 cl-444 fs-16 float-left">Roles</a>
                                                        <a data-toggle="modal" data-target="#add_role_1" class="float-right btn btn-secondary banking-process-amref mg-bottom-10">Add Role</a>
                                                        <div class="width-100-pc float-left">
                                                            <table class="table itemized x-panel">
                                                                <thead>
                                                                <tr>
                                                                    <th style="width: 20%;">Name</th>
                                                                    <th style="width: 20%;">Slug</th>
                                                                    <th style="width: 40%;" class="">Description</th>
                                                                    <th style="width: 10%;">Permissions</th>
                                                                    <th style="width: 10%;" class="">Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(role,index) in roles" :key="'roles_'+index">
                                                                        <td class="padded">{{role.name}}</td>
                                                                        <td class="padded">{{role.slug}}</td>
                                                                        <td class="padded">{{role.description}}</td>
                                                                        <td class="padded"></td>
                                                                        <td class="padded">
                                                                            <div v-if="role.slug!=='master.admin'" class="btn-group float-right" role="group" aria-label="Button group">
                                                                                <div class="btn-group" role="group">
                                                                                    <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        Action
                                                                                    </a>
                                                                                    <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                                        <a data-toggle="modal" :data-target="'#edit_role_'+index" class="dropdown-item pointer-cursor">Edit</a>
                                                                                        <a data-toggle="modal" :data-target="'#delete_role_'+index" class="dropdown-item pointer-cursor">Delete</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <delete-modal v-if="role.slug!=='master.admin'" :title="'Delete Role'" :modal_id="'delete_role_'+index" :item_url="PRACTICE_ROLES_API+'/'+role.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Role'"></delete-modal>
                                                                        <role-modal v-if="role.slug!=='master.admin'" :modal_id="'edit_role_'+index" :role_api="PRACTICE_ROLES_API+'/'+role.id" :user_mode="'Edit'" :permissions="permissions" :form_data="role" :title="'Role Editor'"></role-modal>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="width-100-pc float-left mg-top-30">
                                                        <a class="fw-600 cl-444 fs-16 float-left">Users</a>
                                                        <a data-toggle="modal" data-target="#add_user_1" class="float-right btn btn-secondary banking-process-amref mg-bottom-10">Add User</a>
                                                        <div class="width-100-pc float-left">
                                                            <table class="table itemized x-panel">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:2%;">
                                                                            <input type="checkbox" class="pointer-cursor">
                                                                        </th>
                                                                        <th style="width:23%;">Full Name</th>
                                                                        <th style="width:20%;">Email</th>
                                                                        <th style="width:15%;">Mobile</th>
                                                                        <th style="width:20%;">Role</th>
                                                                        <th style="width:10%;">Status</th>
                                                                        <th style="width:10%;" class="text-right">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(company_user, user_index) in company_users" :key="'users'+user_index">
                                                                        <td class="padded">
                                                                            <input class="pointer-cursor" type="checkbox" :value="company_user.id">
                                                                        </td>
                                                                        <td class="padded">{{company_user.first_name+' '+company_user.other_name}}</td>
                                                                        <td class="padded">{{company_user.email}}</td>
                                                                        <td class="padded">{{company_user.mobile}}</td>
                                                                        <td class="padded">{{company_user.role.name}}</td>
                                                                        <td class="padded">{{company_user.status}}</td>
                                                                        <td class="padded">
                                                                            <div class="btn-group float-right" role="group" aria-label="Button group">
                                                                                <div class="btn-group" role="group">
                                                                                    <a :id="'btnGroupDrop23_'+user_index" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                        Action
                                                                                    </a>
                                                                                    <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop23_'+user_index">
                                                                                        <a data-toggle="modal" :data-target="'#edit_user_'+user_index" class="dropdown-item pointer-cursor">Edit</a>
                                                                                        <a v-if="company_user.role.slug!=='master.admin'" data-toggle="modal" :data-target="'#delete_user_'+user_index" class="dropdown-item pointer-cursor">Delete</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <delete-modal v-if="company_user.role.slug!=='master.admin'" :title="'Delete User'" :modal_id="'delete_user_'+user_index" :item_url="PRACTICE_USERS_API+'/'+company_user.id" :confirm_message="'Are you sure?'" :modal_title="'Delete User'"></delete-modal>
                                                                        <user-modal :modal_id="'edit_user_'+user_index" :form_data="company_user" :user_mode="'Edit'" :user_api="PRACTICE_USERS_API+'/'+company_user.id" :hr_roles="roles" :companies="companies" :departments="departments" :warehouses="warehouses" :subwarehouses="subwarehouses" :title="'Edit User'"></user-modal>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-100-pc float-left mg-top-20">
                                                            <span class="fw-600 fs-17">Quick Links:</span> <router-link class="pointer-cursor cl-787887 fs-12" :to="ADMINSTRATIVE.USER_ACCESS">Set up User Access</router-link>
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
                    <role-modal v-if="page_ready"
                        :modal_id="'add_role_1'"
                        :role_api="PRACTICE_ROLES_API"
                        :user_mode="'Create'"
                        :permissions="permissions"
                        :title="'Role Editor'"
                        @add-edit-role-event="reloadPage()">
                    </role-modal>
                    <user-modal v-if="page_ready"
                            :modal_id="'add_user_1'"
                            :user_api="PRACTICE_USERS_API"
                            :hr_roles="roles"
                            :companies="companies"
                            :departments="departments"
                            :warehouses="warehouses"
                            :subwarehouses="subwarehouses"
                            :title="'Create New User'"
                            @edit-user-event="reloadPage()"
                            @add-user-event="reloadPage()"></user-modal>
                    <copy-right></copy-right>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DeleteModal from "../../partials/modals/DeleteModal";
    import RoleModal from "../../partials/modals/users/RoleModal";
    import UserModal from "../../partials/modals/users/UserModal";
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from "../../partials/CopyRight";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {
        CUSTOMERS_API,
        PERMISSIONS_API,
        PRACTICE_ROLES_API,
        PRACTICE_USERS_API,
        PRACTICES_API
    } from "../../../../../router/api_routes";
    import {ADMINSTRATIVE, LOGIN_URL} from "../../../../../router/web_routes";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "Users",
        components: {TopNavBar,PaginateTemplate,SideBar,CopyRight,DeleteModal,RoleModal,UserModal},
        data(){
            return {
                company: null,
                page_ready: false,
                is_initializing: false,
                roles: [],
                permissions: [],
                PRACTICE_ROLES_API: PRACTICE_ROLES_API,
                PRACTICE_USERS_API: PRACTICE_USERS_API,
                ADMINSTRATIVE: ADMINSTRATIVE,
                departments: [],
                company_users: [],
                companies: [],
                warehouses: [],
                subwarehouses: [],
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

            reloadPage(){
                window.location.reload();
            },

            loadCompanies(){
                get(PRACTICES_API)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.companies = res.data.results.data;
                            this.is_initializing = false;
                            this.page_ready = true;
                            this.is_initializing = false;
                        }
                    }).catch((err) => {
                });
            },

            loadUsers() {
                get(PRACTICE_USERS_API)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.company_users = res.data.results;
                            this.loadCompanies();
                        }
                    }).catch((err) => {
                });
            },

            loadRoles(){
                this.is_initializing = true;
                get(PRACTICE_ROLES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.roles = res.data.results.data;
                        this.loadPermissions();
                    }
                }).catch((err) => {
                    this.page_loaded = false;
                    if (err.response.status === 500){
                        Auth.remove();
                        this.$awn.warning(err.response.data.description);
                        this.$router.push(LOGIN_URL)
                    }
                    this.is_initializing = false;
                });
            },

            loadPermissions() {
                get(PERMISSIONS_API)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.permissions = res.data.results;
                            this.loadUsers();
                        }
                    }).catch((err) => {
                });
            },
        },
        mounted() {
            this.loadRoles();
        }
    }
</script>

<style scoped>

</style>