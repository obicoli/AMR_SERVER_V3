<template>
    <div>
        <loading :is-loading="processing"></loading>
        <top-nav-bar></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            <div class="row">
                <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                    <side-bar-settings :scrollable="true" :width="true" :transparent="true" :currency="true"></side-bar-settings>
                </div>
                <div class="col-md-10 col-lg-10 col-sm-10 padding-left-0">
                    <div class="settings-header main-heading">Settings | Currency</div>
                    <div class="ui fitted divider"></div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="box box-primary border-top-0 border-bottom-0 no-shadowed">
                                <div class="box-header bg-white with-border bg-white border-bottom-0">
                                    <div class="pull pull-right width-60-pc text-right">
                                        <a data-toggle="modal" data-target="#new_unit_modal" class="btn btn-inventory">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                            Add Currency
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body bg-white">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="items table items-analytic-table table-bordered table-hover">
                                                <thead class="bg-eee">
                                                    <tr>
                                                        <th style="width: 10%">#ID</th>
                                                        <th style="width: 20%">Name</th>
                                                        <th style="width: 20%">Symbol</th>
                                                        <th style="width: 20%">Created At</th>
                                                        <th style="width: 20%">Created By</th>
                                                        <th style="width: 10%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="noprintclass">
                                                <tr v-for="(unite, index) in pharmacy_currencies">
                                                    <td>{{index + 1}}</td>
                                                    <td>{{unite.name}}</td>
                                                    <td>{{unite.slug}}</td>
                                                    <td>{{unite.created_at}}</td>
                                                    <td>{{unite.created_by}}</td>
                                                    <td>
                                                        <a data-toggle="modal" :data-target="'#edit_currency_modal_'+index" class="cl-444 showOnHover"><i class="fa fa-edit"></i></a>
                                                        <!-- (Ajax Modal)-->
                                                        <div class="modal fade" :id="'edit_currency_modal_'+index">
                                                            <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                                <currency-modal :form_data="unite" :item_id="unite.id" :branch_id="practice_id" v-on:currencyEdited="load_Currency" :initial_ur="initial_url" :user_mode="'Edit'"></currency-modal>
                                                            </div>
                                                        </div> <!-- Bootstrap model  ends-->
                                                        <!-- /.content -->
                                                        <a data-toggle="modal" :data-target="'#delete_currency_modal_'+index" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                                        <!-- (Ajax Modal)-->
                                                        <div class="modal fade" :id="'delete_currency_modal_'+index">
                                                            <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                                <delete-stuff-modal :modal_title="'Delete Currency'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+unite.id" v-on:deletionSuccessful="load_Currency"></delete-stuff-modal>
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
                            <currency-modal v-if="page_loaded" :form_data="form_data" :branch_id="practice_id" :user_mode="'Create'" v-on:currencyAdded="load_Currency" :initial_ur="initial_url"></currency-modal>
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
    import CurrencyModal from '../../pharmacy/initialization/brands/partials/CurrencyModal'
    import DeleteStuffModal from '../../pharmacy/patials/DeleteStuffModal'
    import Loading from '../../../../components/loads/ProgRess'

    export default {
        name: "ProductCurrency",
        components: {TopNavBar, SideBar,SideBarSettings,CurrencyModal,DeleteStuffModal,Loading},
        data(){
            return {
                processing: false,
                page_loaded: false,
                practice_id: '',
                initial_url: '/api/products/currencies',
                pharmacy_currencies: [],
                form_data: {
                    status: '',
                    name: '',
                    slug: '',
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
            load_Currency: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Currency')
                    .then((res) => {
                        this.pharmacy_currencies = [];
                        if(res.data.status_code === 200) {
                            this.pharmacy_currencies = res.data.results.resources;
                            console.info(this.pharmacy_currencies);
                            this.page_loaded = true;
                            this.processing = false;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            }
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.load_Currency();
            this.page_loaded = true;
        }
    }
</script>

<style scoped>

</style>