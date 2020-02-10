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
                                    <common-link :active_link="'statements'"></common-link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo">
                            <side-bar-ac-statements v-if="page_ready" :scrollable="false" :width="true" :transparent="true" :active_el="'categories'" :title="'Statements'"></side-bar-ac-statements>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20 mg-top-45" role="grid">

                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30%;">Name</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 45%;">Description</th>
                                                    <th style="width: 15%;">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="subcategories.length">
                                                <tr v-for="(category, index) in subcategories" :key="'category_'+index" class="pointer-cursor">
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
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../../../partials/sidebars/SideBar";
    import TopNavBar from "../../../partials/topbars/TopNavBar";
    import SideBarAcStatements from "../../../partials/sidebars/SideBarAcStatements";
    import CommonLink from "../../../partials/sidebars/accounting/CommonLink";
    import ProcessingOverlay from "../../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import {removeElement,paginator} from "../../../../../../helpers/functionmixin";
    import PaginateTemplate from '../../../partials/pagination/PaginateTemplate';
    import {PRODUCT_ATTRIBUTES_URL,PRODUCT_SUB_CATEGORIES_URL} from '../../../../../../router/api_routes';
    import {INVENTORY_WEB_ROUTES} from '../../../../../../router/web_routes';
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarAcStatements,
        ProcessingOverlay,CommonLink,PaginateTemplate},
        data(){
            return {
                initializations: {},
                subcategories: [],
                msg: 'Loading. Please wait...',
                current_role_name: '',
                progress_overlay: 'hide',
                page_ready: false,
                practice_id: '',
                initial_url: PRODUCT_SUB_CATEGORIES_URL,
                pagination: paginator(),
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
            }
        },
        methods: {

            remove_el(ele_to){
                this.subcategories = removeElement(this.subcategories, ele_to)
            },
            refresh_data(new_data){
                this.subcategories = new_data.data;
                this.pagination = paginator(new_data);
            },
            replace_edited(to_replace){
                for( let j=0; j<this.subcategories.length;j++ ){
                    if( this.subcategories[j].id===to_replace.id ){
                        this.subcategories[j] = to_replace;
                        break;
                    }
                }
            },
            

            loadLedger(){
                this.page_ready = true;
                // this.subcategories = []; //page_ready
                // this.progress_overlay = "show";
                // get(PRODUCT_SUB_CATEGORIES_URL+'/practice/'+this.practice_id+'?page='+this.pagination.current_page)
                // .then((res) => {
                //     if(res.data.status_code === 200) {
                //         this.subcategories = res.data.results.data;
                //         this.pagination = paginator(res.data.results);
                //         this.progress_overlay = "hide";
                //         this.page_ready = true;
                //     }
                //     this.progress_overlay = "hide";
                // }).catch((err) => {
                //     this.progress_overlay = "hide";
                //     this.page_loaded = false;
                //     if(err.response.status === 422) {
                //         this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                //     }else if (err.response.status === 500){
                //         this.$awn.warning(err.response.data.description);
                //         //this.$router.push('/500');
                //         window.location.href = "/500";
                //     }
                //     else{
                //         this.processing = false;
                //         this.$awn.warning(err.response.data.description)
                //     }
                // });
            },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadLedger();
        }
    }
</script>

<style lang="scss">
    // @import '../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>