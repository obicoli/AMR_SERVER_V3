<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            
            <div class="row">

                <div class="col-lg-12">

                    <div class="settings-header shadowed  main-heading bg-foo pd-3-rem">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left width-60-pc">
                                    <router-link to="/pharmacy" class="btn-link cl-444">Pharmacy | </router-link>
                                    <router-link to="/pharmacy/prescription" class="btn-link cl-444">Prescriptions</router-link>
                                </div>
                                <div class="pull pull-right width-30-pc text-right padding-right-70 pd-3-rem">
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="content bg-white mg-top-30">

                        <div class="row">

                        </div>

                    </section>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarHr from "../partials/sidebars/SideBarHr"
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import DeleteModal from '../../practice/partials/modals/DeleteModal'
    // import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal'
    // import ProductModal from '../../practice/partials/modals/product/ProductModal'
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {formatMoney,removeElement} from "../../../../helpers/functionmixin";

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,SideBarHr,ProcessingOverlay,DeleteModal},
        data(){
            return {
                initialUrl: '/api/pharmacy',
                initializations: {},
                practice_product_items: [],
                prod_loaded: false,
                practice_id: '',
                is_page_ready: false,
                progress_overlay: 'hide',
                product_list_filters: [],
                active_filter: 0,
                work_place: {},
            }
        },
        methods: {

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.work_place = Auth.getCurrentAccount("work_place");
            this.practice_id = this.work_place.id;
            console.info(this.work_place);
            //this.loadInitializations();
        }
    }
</script>

<style scoped>

</style>