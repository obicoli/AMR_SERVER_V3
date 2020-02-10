<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">
                        <div  class="btn-group float-right mg-right-50" role="group" aria-label="Button group with nested dropdown">
                            <button data-toggle="modal" data-target="#userModal" type="button" class="btn combo-button primary">+ New User</button>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                    <a class="dropdown-item" href="#">Import users</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-users v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :title="'User summary'" :active_el="'summary'"></side-bar-users>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <dl>
                                                    <dt>
                                                        Summary by Role
                                                    </dt>
                                                    <dd v-for="(hr_role,index) in hr_roles" class="percentage percentage-11" :key="'role_summary_'+index"><span class="text">{{hr_role.name}}: 11.33%</span></dd>
                                                    <!-- <dd class="percentage percentage-49"><span class="text">Chrome: 49.77%</span></dd>
                                                    <dd class="percentage percentage-16"><span class="text">Firefox: 16.09%</span></dd>
                                                    <dd class="percentage percentage-5"><span class="text">Safari: 5.41%</span></dd>
                                                    <dd class="percentage percentage-2"><span class="text">Opera: 1.62%</span></dd>
                                                    <dd class="percentage percentage-2"><span class="text">Android 4.4: 2%</span></dd> -->
                                                </dl>
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <table class="table table-hover table-user-summary table-responsive table-striped mg-left-90 width-80-pc">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Facilities</th>
                                                            <th>Total Users</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(hr_role,indexx) in hr_roles" :key="'facility'+indexx">
                                                            <td>{{hr_role.name}}</td>
                                                            <td>1</td>
                                                            <td>1</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
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
    import {PRACTICE_USERS_API,PRACTICE_ROLES_API,FACILITY_URL} from '../../../../router/api_routes'
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
                get(PRACTICE_USERS_API+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.practice_users = res.data.results;
                        this.processing = false;
                        console.info(this.practice_users);
                        this.loadRoles();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            // loadRoles() {
            //     this.progress_overlay = "show";
            //     get(AppInfo.app_data.server_domain+this.initial_url_roles+'/practice/'+this.practice_id)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.hr_roles = res.data.results;
            //             //this.progress_overlay = "hide";
            //             //this.page_ready = true;
            //             this.loadPractice();
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //     });
            // },

            loadRoles() {
                this.progress_overlay = "show";
                get(PRACTICE_ROLES_API+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.hr_roles = res.data.results;
                        console.info(this.hr_roles);
                        //this.page_loaded = true;
                        //this.progress_overlay = "hide";
                        this.loadPractice();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadPractice() {
                this.progress_overlay = "show";
                get(FACILITY_URL+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.practices = res.data.results;
                        //this.loadDepartments();
                        this.progress_overlay = "hide";
                        this.page_ready = true;
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

            deleteItem(item_obj){
                this.practice_users = removeElement(this.practice_users,item_obj);
            },

        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadUsers();
        }
    }
</script>

<style lang="scss">
    @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
    dl {
        display: flex;
        background-color: white;
        flex-direction: column;
        width: 100%;
        max-width: 700px;
        position: relative;
        padding: 20px;

    }

    dt {
        align-self: flex-start;
        width: 100%;
        //   font-weight: 700;
        font-weight: normal;
        display: block;
        text-align: center;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 20px;
        //   font-size: 1.2em;
        //   font-weight: 700;
        //   margin-bottom: 20px;
        //   margin-left: 130px;
    }

    .text {
        font-weight: 600;
        display: flex;
        align-items: center;
        // height: 40px;
        height: 30px;
        width: 130px;
        background-color: white;
        position: absolute;
        left: 0;
        justify-content: flex-end;
    }

    .percentage {
        // font-size: .8em;
        font-size: .6em;
        line-height: 1;
        text-transform: uppercase;
        width: 100%;
        // height: 40px;
        height: 30px;
        margin-left: 130px;
        background: repeating-linear-gradient(
        to right,
        #ddd,
        #ddd 1px,
        #fff 1px,
        #fff 5%
    );
  
  &:after {
    content: "";
    display: block;
    background-color: #3d9970;
    width: 50px;
    margin-bottom: 10px;
    height: 90%;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    transition: background-color .3s ease;
    cursor: pointer;
  }
  &:hover,
  &:focus {
    &:after {
       background-color: #aaa; 
    }
  }
}

@for $i from 1 through 100 {
  .percentage-#{$i} {
    &:after {
      $value: ($i * 1%);
      width: $value;
    }
  }
}

// html, body {
//   height: 500px;
//   font-family: "fira-sans-2",sans-serif;
//   color: #333;
// }
</style>