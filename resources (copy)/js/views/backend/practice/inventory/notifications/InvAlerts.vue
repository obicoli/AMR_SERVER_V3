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
                                    <common-links :active_link="'notifications'"></common-links>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo">
                            <side-bar-inv-settings v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :title="'Inventory Alerts'" :active_el="'notifications'"></side-bar-inv-settings>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20 mg-top-45" role="grid">
                                        <div class="width-70-pc pull-left mg-bottom-10">

                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_NOTIFICATIONS_ALERT" class="btn-approved-md pointer-cursor float-left mg-right-5">Inventory Alerts</router-link>
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_NOTIFICATIONS" class="btn-default-md pointer-cursor float-left mg-right-5">Emails</router-link>
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_NOTIFICATIONS_SMS" class="btn-default-md pointer-cursor float-left mg-right-5">SMS</router-link>
                                            <!-- <search-database-form-control v-if="page_ready" :search_type="'Category'" :placeholder="'search by name'" v-on:searchedData="refresh_data" :practice_id="practice_id" :field_wdth="250" :rounded_px="10"></search-database-form-control> -->
                                        </div>
                                        <div class="width-20-pc pull-right mg-bottom-10">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#create_alert_modal" type="button" class="btn combo-button combo-default">+ Inventory Alert</button>
                                            </div>
                                        </div>
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">No.</th>
                                                    <th style="width: 20%;">Alert</th>
                                                    <th style="width: 25%;">Frequency</th>
                                                    <th style="width: 15%;">Enable Alert</th>
                                                    <th style="width: 15%;">Email/Notification</th>
                                                    <th style="width: 15%;">SMS/Notification</th>
                                                    <th style="width: 5%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="categories.length">
                                                <tr v-for="(category, index) in categories" :key="'category_'+index" class="pointer-cursor">
                                                    <td class="padded">{{index+1}}</td>
                                                    <td class="padded cl-amref fw-600 fs-12">{{category.name}}</td>
                                                    <td class="padded txt-uppercase cl-444 fw-600">{{category.frequency}}</td>
                                                    <td class="padded">{{category.status}}</td>
                                                    <td class="padded">{{category.status}}</td>
                                                    <td class="padded">{{category.status}}</td>
                                                    <td class="padded">{{category.status}}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="7" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadCategories()" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <alerts-modal v-if="page_ready" v-on:alertAdded="loadCategories('hide')" :initial_url="initial_url" :organ_data="organ_data" :initializations="initializations" :practice_id="practice_id" :modal_title="'Inventory Alert Settings'" :modal_id="'create_alert_modal'"></alerts-modal>
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
    import AlertsModal from "../../partials/modals/inventory_settings/inv_alerts/AlertsModal";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import SearchDatabaseFormControl from "../../partials/search/SearchDatabaseFormControl";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator} from "../../../../../helpers/functionmixin";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {PRODUCT_ATTRIBUTES_URL,PRODUCT_CATEGORIES_URL,PRODUCT_NOTIFICATIONS,PURCHASES_ATTRIBUTES_URL} from '../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "InvAlerts",
        components: {TopNavBar, SideBar,SideBarInvSettings,SearchDatabaseFormControl,AlertsModal,
        ProcessingOverlay,CommonLinks,PaginateTemplate},
        data(){
            return {
                initializations: {},
                organ_data: {},
                categories: [],
                msg: 'Loading. Please wait...',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                practice_id: '',
                initial_url: PRODUCT_NOTIFICATIONS,
                pagination: paginator(),
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
            }
        },
        methods: {

            remove_el(ele_to){
                this.categories = removeElement(this.categories, ele_to)
            },
            refresh_data(new_data){
                this.categories = new_data.data;
                this.pagination = paginator(new_data);
            },
            replace_edited(to_replace){
                for( let j=0; j<this.categories.length;j++ ){
                    if( this.categories[j].id===to_replace.id ){
                        this.categories[j] = to_replace;
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
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
                        this.loadCategories();
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

            loadCategories(overlay_='show'){
                this.categories = [];
                this.progress_overlay = overlay_;
                get(this.initial_url+'/'+this.practice_id+'/alerts/'+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.categories = res.data.results.data;
                        this.pagination = paginator(res.data.results);
                        this.progress_overlay = "hide";
                        this.page_ready = true;
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
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            //this.loadInitials();
            this.page_ready = true;
            
        }
    }
</script>

<style lang="scss">
    // @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>