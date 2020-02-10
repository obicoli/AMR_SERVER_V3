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

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo">
                            <side-bar-inv-settings v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :active_el="'units'" :title="'Inventory Settings'"></side-bar-inv-settings>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20 mg-top-45" role="grid">
                                        <div class="width-70-pc pull-left mg-bottom-10">
                                            <search-database-form-control v-if="page_ready" :search_type="'UOM'" :placeholder="'search by name'" v-on:searchedData="refresh_data" :practice_id="practice_id" :field_wdth="250" :rounded_px="10"></search-database-form-control>
                                        </div>
                                        <div class="width-20-pc pull-right mg-bottom-10">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#new_uom_modal" type="button" class="btn combo-button combo-default">+ Units</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#import_uom_modal_id"> Import</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%;">Name</th>
                                                    <th style="width: 30%;">Symbol</th>
                                                    <th style="width: 20%;">
                                                        <a @click="loadCategories" title="Refresh" class="fa fa-refresh float-right pointer-cursor"></a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="uom_list.length">
                                                <tr v-for="(category, index) in uom_list" :key="'category_'+index" class="pointer-cursor">
                                                    <td class="padded">{{category.name}}</td>
                                                    <td class="padded">{{category.slug}}</td>
                                                    <td class="padded text-right">
                                                        <a data-toggle="modal" :data-target="'#edit_uom_modal_'+index" class="fs-14 pointer-cursor showOnHover"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                        <a data-toggle="modal" :data-target="'#delete_uom_'+index" class="fs-14 cl-amref pointer-cursor showOnHover"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                    <delete-modal :modal_title="'Delete Unit of Measure'" :modal_id="'delete_uom_'+index" v-on:deletionSuccessful="remove_el(category)" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+category.id"></delete-modal>
                                                    <uom-modal v-if="page_ready" :form_data="category" :INITIAL_URL="initial_url+'/'+category.id" :item_id="category.id" :user_mode="'Edit'" :title="'Edit Unit of Measure'" :modal_id="'edit_uom_modal_'+index" v-on:categoryEdited="replace_edited" :practice_id="practice_id"></uom-modal>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="!uom_list.length">
                                                <tr>
                                                    <td colspan="5" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No category to display</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadCategories()" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <uom-modal v-if="page_ready" :user_mode="'Create'" :INITIAL_URL="initial_url" :title="'+ New Unit of Measure'" :modal_id="'new_uom_modal'" v-on:categoryAdded="loadCategories" :practice_id="practice_id"></uom-modal>
                                <general-import-modal v-if="page_ready" v-on:imported="loadCategories" :practice_id="practice_id" :title="'Import Unit of Measure'" :modal_id="'import_uom_modal_id'" :modal_min_width="900" :sample_file="'uom'" :upload_type="'UOM'"></general-import-modal>
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
    import UomModal from '../../partials/modals/inventory_settings/uom/UomModal';
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import SearchDatabaseFormControl from "../../partials/search/SearchDatabaseFormControl";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator} from "../../../../../helpers/functionmixin";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {PRODUCT_ATTRIBUTES_URL,PRODUCT_UNITS} from '../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarInvSettings,
        DeleteModal,UomModal,GeneralImportModal,SearchDatabaseFormControl,
        ProcessingOverlay,CommonLinks,PaginateTemplate},
        data(){
            return {
                initializations: {},
                uom_list: [],
                msg: 'Loading. Please wait...',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                practice_id: '',
                initial_url: PRODUCT_UNITS,
                pagination: paginator(),
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
            }
        },
        methods: {

            remove_el(ele_to){
                this.uom_list = removeElement(this.uom_list, ele_to)
            },
            refresh_data(new_data){
                this.uom_list = new_data.data;
                this.pagination = paginator(new_data);
            },
            replace_edited(to_replace){
                for( let j=0; j<this.uom_list.length;j++ ){
                    if( this.uom_list[j].id===to_replace.id ){
                        this.uom_list[j] = to_replace;
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
            loadCategories(){
                this.uom_list = [];
                this.progress_overlay = "show";
                get(PRODUCT_UNITS+'/practice/'+this.practice_id+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.uom_list = res.data.results.data;
                        this.pagination = paginator(res.data.results);
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                        console.info(this.uom_list);
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
            //this.progress_overlay = "show";
            this.loadCategories();
        }
    }
</script>

<style lang="scss">
    // @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>