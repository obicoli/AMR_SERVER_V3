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
                            <side-bar-inv-settings v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :active_el="'brands'" :title="'Inventory Settings'"></side-bar-inv-settings>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20 mg-top-45" role="grid">
                                        <div class="width-60-pc pull-left mg-bottom-10">
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_BRAND_SECTOR" class="btn-default-md pointer-cursor float-right mg-right-10">Brand Sector</router-link>
                                            <router-link :to="INVENTORY_WEB_ROUTES.INV_SET_BRANDS" class="btn-approved-md pointer-cursor float-right mg-right-10">Brand</router-link>
                                            <search-database-form-control v-if="page_ready" :search_type="'Brands'" :placeholder="'search by name'" v-on:searchedData="refresh_data" :practice_id="practice_id" :field_wdth="200" :rounded_px="10"></search-database-form-control>
                                        </div>
                                        <div class="width-20-pc pull-right mg-bottom-10">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#new_brand_modal" type="button" class="btn combo-button combo-default">+ Create Brand</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                        <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#import_brands_modal_id"> Import Brand</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 30%;">Company</th>
                                                    <th style="width: 35%;">Description</th>
                                                    <th style="width: 5%;">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="brands.length">
                                                <tr v-for="(brand, index) in brands" :key="'category_'+index">
                                                    <td>{{brand.name}}</td>
                                                    <td>{{brand.company_name}}</td>
                                                    <!-- <td>
                                                        <span v-if="brand.status" class="lbl-approved">Active</span>
                                                        <span v-if="!brand.status" class="lbl-declined">Inactive</span>
                                                    </td> -->
                                                    <td>{{brand.description}}</td>
                                                    <td class="padded">
                                                        <a data-toggle="modal" :data-target="'#edit_brand_modal'+index" class="fs-14 pointer-cursor showOnHover"><i class="fa fa-edit"></i></a>&nbsp;
                                                        <a data-toggle="modal" :data-target="'#delete_category_'+index" class="fs-14 cl-amref pointer-cursor showOnHover"><i class="fa fa-trash-o"></i></a>
                                                    </td>
                                                    <delete-modal :modal_title="'Delete Brand'" :modal_id="'delete_category_'+index" v-on:deletionSuccessful="remove_el(brand)" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+brand.id"></delete-modal>
                                                    <brand-modal v-if="page_ready" :form_data="brand" :companies="initializations.manufacturers" :user_mode="'Edit'" :INITIAL_URL="initial_url+'/'+brand.id" :title="'Edit Brand'" :modal_id="'edit_brand_modal'+index" v-on:brandEdited="loadBrands" :practice_id="practice_id"></brand-modal>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="!brands.length">
                                                <tr>
                                                    <td colspan="5" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No brand to dispalay</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadBrands()" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <brand-modal v-if="page_ready" :companies="initializations.manufacturers" :user_mode="'Create'" :INITIAL_URL="initial_url" :title="'+ New Brand'" :modal_id="'new_brand_modal'" v-on:brandAdded="loadBrands" :practice_id="practice_id"></brand-modal>
                                <general-import-modal v-if="page_ready" v-on:imported="loadBrands" :practice_id="practice_id" :title="'Import Brand'" :modal_id="'import_brands_modal_id'" :modal_min_width="900" :sample_file="'brands'" :upload_type="'Brands'"></general-import-modal>
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
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import BrandModal from "../../partials/modals/inventory_settings/brands/BrandModal";
    import SearchDatabaseFormControl from "../../partials/search/SearchDatabaseFormControl";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator} from "../../../../../helpers/functionmixin";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {PRODUCT_ATTRIBUTES_URL,PRODUCT_BRANDS} from '../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarInvSettings,
        DeleteModal,GeneralImportModal,BrandModal,SearchDatabaseFormControl,
        ProcessingOverlay,CommonLinks,PaginateTemplate},
        data(){
            return {
                initializations: {},
                brands: [],
                msg: 'Loading. Please wait...',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                practice_id: '',
                initial_url: PRODUCT_BRANDS,
                pagination: paginator(),
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
            }
        },
        methods: {

            remove_el(ele_to){
                this.brands = removeElement(this.brands, ele_to)
            },
            refresh_data(new_data){
                this.brands = new_data.data;
                this.pagination = paginator(new_data);
            },
            replace_edited(to_replace){
                for( let j=0; j<this.categories.length;j++ ){
                    if( this.categories[j].id===to_replace.id ){
                        this.categories = removeElement(this.categories,this.categories[j]);
                        this.categories.push(to_replace);
                        break;
                    }
                }
            },
            loadBrands(){
                this.brands = [];
                this.progress_overlay = "show";
                get(PRODUCT_BRANDS+'/practice/'+this.practice_id+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.brands = res.data.results.data;
                        this.pagination = paginator(res.data.results);
                        this.loadAttributes();
                        // this.progress_overlay = "hide";
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

            loadAttributes(){
                this.progress_overlay = "show";
                get(PRODUCT_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        console.info(this.initializations);
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
            this.loadBrands();
        }
    }
</script>

<style lang="scss">
    // @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>