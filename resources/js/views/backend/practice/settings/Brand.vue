<template>
    <div>
        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                    <side-bar-settings :scrollable="true" :width="true" :transparent="true" :brands="true"></side-bar-settings>
                </div>
                <div class="col-md-10 col-lg-10 col-sm-10 padding-left-0">
                    <div class="settings-header main-heading">Settings | Brands</div>
                    <div class="ui fitted divider"></div>

                    <div class="modal fade" id="edit_branch_modal">
                        <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarSettings from "../partials/sidebars/SideBarSettings"
    export default {
        name: "Brand",
        components: {TopNavBar, SideBar,SideBarSettings},
        data(){
            return {
                current_branch: {},
                initial_url: '/api/practices',
                practice_id: '',
                processing: false,
                page_loaded: false,
            }
        },
    }
</script>

<style scoped>

</style>