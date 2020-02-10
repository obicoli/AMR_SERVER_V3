<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">
                        <!-- Billing | Bill List: -->
                    </div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-purchase :scrollable="false" :width="true" :transparent="true" :title="'Orders'" :active_num="'grn'"></side-bar-purchase>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed min-height-100-vh">
                                fffffff
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
    import SideBarPurchase from "../../../partials/sidebars/SideBarPurchase";
    import {get} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,SideBarPurchase},
        data(){
            return {
                
                
            }
        },
        methods: {
            
        },
        mounted() {
            // this.practice_id = Auth.getCurrentAccount('id');
            // this.branch_id = Auth.getCurrentAccount('id');
            // this.user_form.branch_id = this.branch_id;
            // this.page_loaded = true;
        }
    }
</script>

