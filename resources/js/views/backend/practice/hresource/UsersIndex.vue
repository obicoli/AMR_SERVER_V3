<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">Users</div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-users v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :hr_role="hr_roles" v-on:selectedRole="selectedUserRole" :active_num="format_slug_back(url_slug)"></side-bar-users>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    <div class="filter-block form-inline float-left page-title">
                                        <h4>{{capitalizeTitle(url_slug)}}</h4>
                                    </div>
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#userModal" type="button" class="btn combo-button primary">+ New User</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item" href="#">Import users</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-block form-inline float-right mg-right-10">
                                        <input type="text" placeholder="Search by name" class="form-control product-entry-input-field height-27">
                                    </div>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">
                                        <table class="user-table" role="presentation">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User type</th>
                                                    <th>Status</th>
                                                    <th>Billable</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(usery,indexss) in practice_users" :key="'usery'+indexss">
                                                    <td class="" tabindex="0">
                                                        {{usery.first_name}} {{usery.other_name}}
                                                    </td>
                                                    <td class="">
                                                        {{usery.email}}
                                                    </td>
                                                    <td class="">
                                                        <div v-if="usery.roles.length > 0 && usery.roles[0].slug==='master.admin'" class="master-admin">{{usery.roles[0].name}}</div>
                                                        <span v-else-if="usery.roles.length > 0">{{usery.roles[0].name}}</span>
                                                        <span v-else>Standard user</span>
                                                    </td>
                                                    <td class="">
                                                        {{usery.status}}
                                                    </td>
                                                    <td class="">
                                                        {{usery.billable}}
                                                    </td>
                                                    <td class="">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a v-if="usery.status==='Invited'" data-toggle="modal" :data-target="'#resend_invite_modal_'+indexss" class="btn-link">Resend Invite</a>
                                                            <invite-modal :practice_user="usery" :initial_url="initial_url+'/invite'" :practice_id="practice_id" :modal_id="'resend_invite_modal_'+indexss"></invite-modal>
                                                            <a v-if="usery.status==='Active'" data-toggle="modal" :data-target="'#edit_user_'+indexss" class="btn-link">Edit</a>&nbsp;&nbsp;
                                                            <div v-if="usery.status==='Active'" class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+indexss" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+indexss">
                                                                    <a v-if="usery.status==='Active'" class="dropdown-item" href="#">View user activity</a>
                                                                    <!-- <a v-if="usery.status!=='Active' && usery.roles.length>0 && usery.roles[0].slug!=='master.admin'" class="dropdown-item" href="#">Delete</a> -->
                                                                    <!-- <a v-if="usery.status==='Active' && usery.roles.length>0 && usery.roles[0].slug!=='master.admin'" :data-target="'#master_user_modal_'+indexss" class="dropdown-item">Make master admin</a> -->
                                                                    <!-- <a v-if="usery.status==='Active' && usery.roles.length===0" data-toggle="modal" :data-target="'#master_user_modal_'+indexss" class="dropdown-item">Make master admin</a> -->
                                                                    <a v-if="usery.roles[0].slug!=='master.admin'" data-toggle="modal" :data-target="'#modal_user_'+indexss" class="dropdown-item">Delete</a>
                                                                </div>
                                                            </div>
                                                            <master-modal :practice_user="usery" :initial_url="initial_url+'/master'" :practice_id="practice_id" :modal_id="'master_user_modal_'+indexss"></master-modal>
                                                            <delete-modal :item_url="initial_url_practices+'/users/'+usery.id" :practice_id="practice_id" :modal_id="'modal_user_'+indexss" :modal_title="'Delete user'" :confirm_message="'Are you sure?'" v-on:deletionSuccessful="deleteItem(usery)"></delete-modal>
                                                            <edit-user-modal :modal_id="'edit_user_'+indexss" :modal_title="'Edit User'" :form_data="usery"></edit-user-modal>
                                                        </div>
                                                    </td>
                                                </tr>
                                        
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <new-user-modal v-if="page_ready" :modal_id="'userModal'" :hr_roles="hr_roles" :practices="practices" :departments="departments" :practice_id="practice_id" :initial_url="initial_url" :title="'Add a new user'" :user_mode="'Create'" v-on:userAdded="loadUsers"></new-user-modal>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import SideBarUsers from "../partials/sidebars/SideBarUsers";
    import NewUserModal from "../partials/modals/NewUserModal";
    import EditUserModal from "../partials/modals/users/EditUserModal";
    import InviteModal from "../partials/modals/InviteModal";
    import MasterModal from "../partials/modals/MasterModal";
    import DeleteModal from "../partials/modals/DeleteModal";
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    // import DeleteStuffModal from "../../pharmacy/patials/DeleteStuffModal";
    import {get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    import {removeElement} from "../../../../helpers/functionmixin";
    export default {
        name: "UsersIndex",
        components: {TopNavBar, SideBar,SideBarUsers,DeleteModal,NewUserModal,InviteModal,MasterModal,ProcessingOverlay,EditUserModal},
        data(){
            return {
                practice_users: [],
                hr_roles: [],
                practices: [],
                departments: [],
                msg: 'Loading. Please wait...',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                initial_url: AppInfo.app_data.apis.practice_users,
                initial_url_roles: AppInfo.app_data.apis.practice_roles,
                initial_url_practices: AppInfo.app_data.apis.practice_practices,
                initial_url_departments: AppInfo.app_data.apis.departments,
                practice_id: '',
                url_slug: this.$route.params.role,
            }
        },
        methods: {

            loadUsers() {
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/users/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.practice_users = res.data.results;
                        this.processing = false;
                        //this.progress_overlay = "hide";
                        this.loadRoles();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadRoles() {
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+this.initial_url_roles+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.hr_roles = res.data.results;
                        //this.progress_overlay = "hide";
                        //this.page_ready = true;
                        this.loadPractice();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadPractice() {
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+this.initial_url_practices+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.practices = res.data.results;
                        this.loadDepartments();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadDepartments() {
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+this.initial_url_departments+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.departments = res.data.results;
                        //console.info(this.departments);
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            selectedUserRole(){

            },

            format_slug_back(sluger){
                return sluger.replace("_",".")
            },

            deleteItem(item_obj){
                this.practice_users = removeElement(this.practice_users,item_obj);
            },
            capitalizeTitle(url_slug){
                if(url_slug === "all"){
                    return "Available Users List";
                }else{
                    url_slug = url_slug.replace("_"," ");
                    return url_slug.charAt(0).toUpperCase() + url_slug.slice(1)+" List:";
                }
            }

        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadUsers();
        }
    }
</script>

<style lang="scss">
    @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>