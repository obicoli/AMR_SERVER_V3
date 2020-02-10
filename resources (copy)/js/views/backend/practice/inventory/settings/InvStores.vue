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
                                    <common-links :active_link="'settings'"></common-links>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-inv-settings v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :active_el="'stores'" :title="'Inventory Settings'"></side-bar-inv-settings>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20 mg-top-45" role="grid">
                                        <div class="width-50-pc pull-left mg-bottom-10">
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_STORES" class="btn-approved-md pointer-cursor">Stores</router-link>
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_SUB_STORES" class="btn-default-md pointer-cursor">Sub Stores</router-link>
                                            <!-- <search-database-form-control v-if="page_ready" :search_type="'Category'" :placeholder="'search by name'" :practice_id="practice_id" :field_wdth="250" :rounded_px="10"></search-database-form-control> -->
                                        </div>
                                        <div class="width-20-pc pull-right mg-bottom-10">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#new_store_modal" type="button" class="btn combo-button combo-default">+ Store</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                        <!-- <a class="dropdown-item" data-toggle="modal" data-target="#import_categories_modal_id"> Import Categories</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">No.</th>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 15%;">code</th>
                                                    <th style="width: 35%;">Facility</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 5%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="stores_list.length">
                                                <tr v-for="(category, index) in stores_list" :key="'category_'+index">
                                                    <td class="padded">{{index+1}}</td>
                                                    <td class="padded">{{category.name}}</td>
                                                    <td class="padded">{{category.code}}</td>
                                                    <td class="padded">{{category.facility.name}}</td>
                                                    <td class="padded">
                                                        <span v-if="category.status" class="">Active</span>
                                                        <span v-if="!category.status" class="cl-amref fs-12 fw-600">Inactive</span>
                                                    </td>
                                                    <td class="padded">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a data-toggle="modal" :data-target="'#edit_user_'+index" class="pointer-cursor">Action</a>&nbsp;&nbsp;
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                    <a data-toggle="modal" :data-target="'#new_store_modal_'+index" class="dropdown-item pointer-cursor">Edit</a>
                                                                    <a v-if="category.status" data-toggle="modal" :data-target="'#status_store_modal_'+index" class="dropdown-item pointer-cursor">Make Inactive</a>
                                                                    <a v-if="!category.status" data-toggle="modal" :data-target="'#status_store_modal_'+index" class="dropdown-item pointer-cursor">Activate</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <store-modal :user_mode="'Edit'" :form_data="category" :initializations="initializations" :initial_url="initial_url+'/'+category.id" :title="'Edit Store'" :modal_id="'new_store_modal_'+index" v-on:storeEditted="loadStores('hide')" :practice_id="practice_id"></store-modal>
                                                    <confirm-modal v-if="!category.status" :status_action="1" v-on:successReq="loadStores('hide')" :modal_id="'status_store_modal_'+index" :modal_title="'Activate'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+category.id"></confirm-modal>
                                                    <confirm-modal v-if="category.status" :status_action="0" v-on:successReq="loadStores('hide')" :modal_id="'status_store_modal_'+index" :modal_title="'Make Inactive'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+category.id"></confirm-modal>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="!stores_list.length">
                                                <tr>
                                                    <td colspan="6" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No store to display</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="6" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadStores()" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <store-modal v-if="page_ready" :user_mode="'Create'" :initializations="initializations" :initial_url="initial_url" :title="'+ New Store'" :modal_id="'new_store_modal'" v-on:storeAdded="loadStores" :practice_id="practice_id"></store-modal>
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
    import SideBarInvSettings from "../../partials/sidebars/SideBarInvSettings";
    //import CategoryModal from '../../partials/modals/inventory_settings/category/CategoryModal';
    import StoreModal from '../../partials/modals/inventory_settings/inv_stores/StoreModal';
    import ConfirmModal from '../../partials/modals/ConfirmModal';
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import DeleteModal from "../../partials/modals/DeleteModal";
    //import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import SearchDatabaseFormControl from "../../partials/search/SearchDatabaseFormControl";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator} from "../../../../../helpers/functionmixin";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {PRODUCT_ATTRIBUTES_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_STORES} from '../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "InvStores",
        components: {TopNavBar, SideBar,SideBarInvSettings,
        DeleteModal,StoreModal,ConfirmModal,SearchDatabaseFormControl,
        ProcessingOverlay,CommonLinks,PaginateTemplate},
        data(){
            return {
                initializations: {},
                stores_list: [],
                msg: 'Loading. Please wait...',
                store_type: 'main',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                practice_id: '',
                initial_url: PRODUCT_STORES,
                pagination: paginator(),
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
            }
        },
        methods: {

            remove_el(ele_to){
                this.stores_list = removeElement(this.stores_list, ele_to)
            },
            replace_edited(to_replace){
                for( let j=0; j<this.stores_list.length;j++ ){
                    if( this.stores_list[j].id===to_replace.id ){
                        this.stores_list = removeElement(this.stores_list,this.stores_list[j]);
                        this.stores_list.push(to_replace);
                        break;
                    }
                }
            },
            loadInitials(){
              this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        console.info(this.initializations);
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
                        this.loadStores();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            loadStores(){
                this.stores_list = [];
                this.progress_overlay = "show";
                get(this.initial_url+'/practice/'+this.practice_id+'/'+this.store_type+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.stores_list = res.data.results.data;
                        this.pagination = paginator(res.data.results);
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                        console.info(this.stores_list);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        //this.$router.push('/500');
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            // loadAttributes(){
            //     this.progress_overlay = "show";
            //     get(PRODUCT_ATTRIBUTES_URL+'/'+this.practice_id)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.initializations = res.data.results;
            //             console.info(this.initializations);
            //             this.progress_overlay = "hide";
            //             this.page_ready = true;
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors))
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //             window.location.href = "/500";
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description)
            //         }
            //     });
            // },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadInitials();
        }
    }
</script>

<style lang="scss">
    // @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>