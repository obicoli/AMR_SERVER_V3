<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-20-pc">
                                </div>
                                <div class="pull pull-right app-header width-70-pc">
                                    <!-- <common-links :active_link="'settings'"></common-links> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo">
                            <!-- <side-bar-inv-settings v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :active_el="'units'" :title="'Inventory Settings'"></side-bar-inv-settings> -->
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20 mg-top-45" role="grid">
                                        <div class="width-70-pc pull-left mg-bottom-10">
                                            <!--<router-link :to="INVENTORY_WEB_ROUTES.INV_SET_ORDER_CATEGORIES" class="pointer-cursor btn-default-md float-right mg-right-5">Order Category</router-link>
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_SUB_CATEGORIES" class="btn-default-md pointer-cursor float-right mg-right-5">Sub Category</router-link>
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_CATEGORIES" class="btn-approved-md pointer-cursor float-right mg-right-5">Category</router-link>-->
                                            <!-- <search-database-form-control v-if="page_ready" :search_type="'Category'" :placeholder="'search by name'" v-on:searchedData="refresh_data" :practice_id="practice_id" :field_wdth="250" :rounded_px="10"></search-database-form-control> -->
                                            <search-database-form-control :search_type="'Category'" :placeholder="'search by name'" v-on:searchedData="refresh_data" :practice_id="practice_id" :field_wdth="250" :rounded_px="10"></search-database-form-control>                                        
                                        </div>
                                        <div class="width-20-pc pull-right mg-bottom-10">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#new_category_modal" type="button" class="btn combo-button combo-default">+ Department</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#import_categories_modal_id"> Import</a>
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#export_categories_modal_id"> Export</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th>SL No.</th>
                                                    <th>Department Name</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    <th>
                                                        <a title="Refresh" class="fa fa-refresh float-right pointer-cursor"></a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <!-- <tbody v-if="categories.length">
                                                <tr v-for="(category, index) in categories" :key="'category_'+index" class="pointer-cursor">
                                                    <td class="padded">{{category.name}}</td>
                                                    <td class="padded">
                                                        <span v-if="category.status" class="lbl-approved">Active</span>
                                                        <span v-if="!category.status" class="lbl-declined">Inactive</span>
                                                    </td>
                                                    <td class="padded">{{category.description}}</td>
                                                    <td class="padded text-right">
                                                        <a data-toggle="modal" :data-target="'#new_category_modal_'+index" class="fs-14 pointer-cursor showOnHover"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                        <a data-toggle="modal" :data-target="'#delete_category_'+index" class="fs-14 cl-amref pointer-cursor showOnHover"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                    <delete-modal :modal_title="'Delete Category!'" :modal_id="'delete_category_'+index" v-on:deletionSuccessful="remove_el(category)" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+category.id"></delete-modal>
                                                    <category-modal v-if="page_ready" :form_data="category" :INITIAL_URL="initial_url+'/'+category.id" :item_id="category.id" :user_mode="'Edit'" :title="'+ New Category'" :modal_id="'new_category_modal_'+index" v-on:categoryEdited="replace_edited" :practice_id="practice_id"></category-modal>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="!categories.length">
                                                <tr>
                                                    <td colspan="5" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No category to display</td>
                                                </tr>
                                            </tbody> -->
                                            <tfoot>
                                                <tr>
                                                    <th colspan="10" class="bg-foo">

                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import SideBarUsers from "../partials/sidebars/SideBarUsers";
    import NewUserModal from "../partials/modals/NewUserModal";
    import SearchDatabaseFormControl from "../partials/search/SearchDatabaseFormControl";
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
    import {PRACTICE_USERS_API,PRACTICE_ROLES_API,FACILITY_URL} from '../../../../router/api_routes';
    export default {
        name: "UsersIndex",
        components: {TopNavBar, SearchDatabaseFormControl, SideBar,SideBarUsers,DeleteModal,NewUserModal,InviteModal,MasterModal,ProcessingOverlay,EditUserModal},
        data(){
            return {
                practice_users: [],
                hr_roles: [],
                practices: [],
                departments: [],
                current_facility: {},
                msg: 'Loading. Please wait...',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                initial_url: PRACTICE_USERS_API,
                // initial_url: AppInfo.app_data.apis.practice_users,
                // initial_url_roles: AppInfo.app_data.apis.practice_roles,
                // initial_url_practices: AppInfo.app_data.apis.practice_practices,
                // initial_url_departments: AppInfo.app_data.apis.departments,
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
                        this.progress_overlay = "hide";
                        this.loadPractice();
                        this.page_ready = true;
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
            //this.loadUsers();
        }
    }
</script>

<style lang="scss">
    //@import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>