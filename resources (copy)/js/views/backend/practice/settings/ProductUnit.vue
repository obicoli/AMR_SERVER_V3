<template>
    <div>

        <loading :is-loading="processing"></loading>

        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                    <side-bar-settings :scrollable="true" :width="true" :transparent="true" :units="true"></side-bar-settings>
                </div>
                <div class="col-md-10 col-lg-10 col-sm-10 padding-left-0">
                    <div class="settings-header main-heading">
                        Settings | Units <a data-toggle="modal" data-target="#new_unit_modal" class="btn btn-inventory float-right"><i class="fa fa-plus-circle"></i> Add Unit</a>
                    </div>
                    <div class="ui fitted divider"></div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="box box-primary border-top-0 border-bottom-0 no-shadowed">
                                <div class="box-body bg-white">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="selectable-table table table-bordered read-table table-hover">
                                                <thead>
                                                <tr>
                                                    <th style="width: 25%">Name</th>
                                                    <th style="width: 20%">Symbol</th>
                                                    <th style="width: 20%">Created At</th>
                                                    <th style="width: 20%">Created By</th>
                                                    <th style="width: 15%"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(unite, index) in pharmacy_units">
                                                    <td>{{unite.name}}</td>
                                                    <td>{{unite.slug}}</td>
                                                    <td>{{unite.created_at}}</td>
                                                    <td>{{unite.created_by}}</td>
                                                    <td>
                                                        <a data-toggle="modal" :data-target="'#edit_currency_modal_'+index" class="cl-444 showOnHover"><i class="fa fa-edit"></i></a>
                                                        <!-- (Ajax Modal)-->
                                                        <div class="modal fade" :id="'edit_currency_modal_'+index">
                                                            <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                                <units-modal :form_data="unite" :item_id="unite.id" :branch_id="practice_id" v-on:unitEdited="load_Units" :initial_ur="initial_url" :user_mode="'Edit'"></units-modal>
                                                            </div>
                                                        </div> <!-- Bootstrap model  ends-->
                                                        <!-- /.content -->
                                                        <a data-toggle="modal" :data-target="'#delete_currency_modal_'+index" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                                        <!-- (Ajax Modal)-->
                                                        <div class="modal fade" :id="'delete_currency_modal_'+index">
                                                            <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                                <delete-stuff-modal :modal_title="'Delete Unit'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+unite.id" v-on:deletionSuccessful="load_Units"></delete-stuff-modal>
                                                            </div>
                                                        </div> <!-- Bootstrap model  ends-->
                                                        <!-- /.content -->
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="new_unit_modal">
                        <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                            <units-modal v-if="page_loaded" :form_data="form_data" :branch_id="practice_id" :user_mode="'Create'" v-on:unitAdded="load_Units" :initial_ur="initial_url"></units-modal>
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
    import {get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";
    import {exportToCsv,print_divs} from "../../../../helpers/functionmixin";
    import UnitsModal from '../../pharmacy/initialization/brands/partials/UnitsModal'
    import DeleteStuffModal from '../../pharmacy/patials/DeleteStuffModal'
    import Loading from '../../../../components/loads/ProgRess'
    export default {
        name: "ProductUnit",
        components: {TopNavBar, SideBar,SideBarSettings,UnitsModal,DeleteStuffModal,Loading},
        data(){
            return {
                initial_url: '/api/products/units',
                practice_id: '',
                processing: false,
                page_loaded: false,
                pharmacy_units: [],
                form_data: {
                    status: '',
                    name: '',
                    slug: '',
                    practice_id: '',
                },
            }
        },
        methods: {
            printThis(ele_id){
                print_divs(ele_id)
            },
            export_to_csv(){
                exportToCsv(this.categories,'Brand Sector')
            },
            load_Units: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Units')
                    .then((res) => {
                        this.pharmacy_units = [];
                        if(res.data.status_code === 200) {
                            this.pharmacy_units = res.data.results.resources;
                            console.info(this.pharmacy_units);
                            this.page_loaded = true;
                            this.processing = false;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.load_Units();
        }
    }
</script>

<style scoped>

</style>