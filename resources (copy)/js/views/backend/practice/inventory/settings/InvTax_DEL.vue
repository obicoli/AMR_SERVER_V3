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
                            <side-bar-inv-settings v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :active_el="'taxrates'" :title="'Inventory Settings'"></side-bar-inv-settings>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20 mg-top-45" role="grid">
                                        <div class="width-70-pc pull-left mg-bottom-10">
                                            <search-database-form-control v-if="page_ready" :search_type="'Category'" :placeholder="'search by name'" v-on:searchedData="refresh_data" :practice_id="practice_id" :field_wdth="250" :rounded_px="10"></search-database-form-control>
                                        </div>
                                        <div class="width-20-pc pull-right mg-bottom-10">
                                            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                                <button data-toggle="modal" data-target="#new_tax_modal" type="button" class="btn combo-button combo-default">+ Tax Rates</button>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#import_categories_modal_id"> Import</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">No.</th>
                                                    <th style="width: 50%;">Name</th>
                                                    <th style="width: 25%;">Value(%)</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 10%;">
                                                        <a @click="loadInitials" title="Refresh" class="fa fa-refresh float-right pointer-cursor"></a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="tax_rates.length">
                                                <tr v-for="(category, index) in tax_rates" :key="'category_'+index" class="pointer-cursor">
                                                    <td class="padded">{{index+1}}</td>
                                                    <td class="padded">{{category.name}}</td>
                                                    <td class="padded">{{category.amount}}</td>
                                                    <td class="padded">
                                                        <span v-if="category.status">Active</span>
                                                        <span v-if="!category.status" class="cl-amref fs-12 fw-600">Inactive</span>
                                                    </td>
                                                    <td class="padded">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a data-toggle="modal" :data-target="'#edit_user_'+index" class="btn-link pointer-cursor">Action</a>&nbsp;&nbsp;
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                    <a data-toggle="modal" :data-target="'#new_tax_modal_'+index" class="dropdown-item pointer-cursor">Edit</a>
                                                                    <a v-if="category.status" data-toggle="modal" :data-target="'#status_tax_modal_'+index" class="dropdown-item pointer-cursor">Make Inactive</a>
                                                                    <a v-if="!category.status" data-toggle="modal" :data-target="'#status_tax_modal_'+index" class="dropdown-item pointer-cursor">Activate</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <tax-rate v-if="page_ready" :form_data="category" :initial_url="initial_url+'/'+category.id" :item_id="category.id" :user_mode="'Edit'" :title="'+ New Tax Rates'" :modal_id="'new_tax_modal_'+index" v-on:taxEdited="loadInitials('hide')" :practice_id="practice_id"></tax-rate>
                                                    <confirm-modal v-if="!category.status" :status_action="1" v-on:successReq="loadInitials" :modal_id="'status_tax_modal_'+index" :modal_title="'Activate'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+category.id"></confirm-modal>
                                                    <confirm-modal v-if="category.status" :status_action="0" v-on:successReq="loadInitials" :modal_id="'status_tax_modal_'+index" :modal_title="'Make Inactive'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+category.id"></confirm-modal>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="!tax_rates.length">
                                                <tr>
                                                    <td colspan="5" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No tax rate to display</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadInitials" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <tax-rate v-if="page_ready" :user_mode="'Create'" :initial_url="initial_url" :title="'+ New Tax Rates'" :modal_id="'new_tax_modal'" v-on:taxAdded="loadInitials" :practice_id="practice_id"></tax-rate>
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
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import SearchDatabaseFormControl from "../../partials/search/SearchDatabaseFormControl";
    import DeleteModal from "../../partials/modals/DeleteModal";
    //import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import TaxRate from '../../partials/modals/inventory_settings/tax/TaxRate';
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator} from "../../../../../helpers/functionmixin";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import {PRODUCT_ATTRIBUTES_URL,PRODUCT_TAX_URL} from '../../../../../router/api_routes';
    import ConfirmModal from '../../partials/modals/ConfirmModal';
    //import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "InvTax",
        components: {TopNavBar, SideBar,SideBarInvSettings,
        DeleteModal,SearchDatabaseFormControl,TaxRate,ConfirmModal,
        ProcessingOverlay,CommonLinks,PaginateTemplate},
        data(){
            return {
                initializations: {},
                tax_rates: [],
                msg: 'Loading. Please wait...',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                practice_id: '',
                initial_url: PRODUCT_TAX_URL,
                pagination: paginator(),
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
            loadInitials(show_overlay="show"){
                this.progress_overlay = show_overlay;
                get(this.initial_url+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.tax_rates = res.data.results;
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
            this.loadInitials();
        }
    }
</script>

<style lang="scss">
    // @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>