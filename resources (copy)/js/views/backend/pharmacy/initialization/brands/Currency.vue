<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :settings="true"></page-header>

        <div class="content-wrapper">

            <sub-header :currency="true" :sub_title="'Currency list :'"></sub-header>

            <section class="content bg-white">

                <div class="row">

                    <div v-if="page_loaded && pharmacy_currencies.length < 1" class="col-xs-12 col-md-12 col-sm-12 mg-top-50">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-body bg-white padding-0">
                            </div>
                        </div>
                        <div class="text-center mg-top-30">
                            <p>You dont have any unit</p>
                            <a data-toggle="modal" data-target="#new_unit_modal" class="btn btn-inventory primary">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create new
                            </a>
                        </div>
                    </div>

                    <div v-if="page_loaded && pharmacy_currencies.length > 0" class="col-xs-12 col-md-9 col-sm-9 col-lg-9">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">

                            <div class="box-header box-header-custom">

                                <div class="pull-left pull width-30-pc">
                                    <select required class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true">
                                        <option value="">search medicine category</option>
                                    </select>
                                </div>

                                <div class="pull pull-right width-70-pc">
                                    <div class="filters width-100-pc">
                                        <div class="filter-block form-inline pull-right text-right">
                                            <div class="filter-group input-group">
                                                <span data-toggle="modal" data-target="#new_unit_modal" class="filter"><i class="fa fa-plus"></i> Add</span>
                                                <span data-toggle="modal" data-target="#upload_brand_modal" class="filter"><i class="fa fa-upload"></i> Upload CSV</span>
                                                <span @click="export_to_csv" class="filter"><i class="fa fa-file-excel-o"></i> Export</span>
                                                <span @click="printThis('category_box_body')" class="filter"><i class="fa fa-print"></i> Print</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body bg-white padding-0" id="category_box_body">
                                <table class="items table table-bordered table-hover table-td-5">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">#ID</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 25%">Symbol</th>
                                        <th style="width: 15%">Created At</th>
                                        <th style="width: 15%">Created By</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr v-for="(unite, index) in pharmacy_currencies">
                                        <td>{{index + 1}}</td>
                                        <td>{{unite.name}}</td>
                                        <td>{{unite.symbol}}</td>
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
            </section>

            <div class="modal fade" id="new_unit_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <currency-modal v-if="page_loaded" :form_data="form_data" :branch_id="practice_id" :user_mode="'Create'" v-on:currencyAdded="load_Currency" :initial_ur="initial_url"></currency-modal>
                </div>
            </div>

        </div>

        <page-footer></page-footer>

    </div>

</template>

<script>
    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    import SubHeader from '../partials/SubHeader'
    import CurrencyModal from './partials/CurrencyModal'
    import DeleteStuffModal from '../../patials/DeleteStuffModal'
    import Loading from '../../../../../components/loads/ProgRess'
    import {get} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {print_divs,exportToCsv} from "../../../../../helpers/functionmixin";

    export default {

        components: {
            PageFooter,PageHeader,Loading,SubHeader,CurrencyModal,DeleteStuffModal
        },
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
                    symbol: '',
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
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Currency')
                    .then((res) => {
                        this.pharmacy_currencies = [];
                        if(res.data.status_code === 200) {
                            this.pharmacy_currencies = res.data.results.resources;
                            console.info(this.pharmacy_currencies);
                            this.page_loaded = true;
                        }
                    }).catch((err) => {
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

<style lang="scss">
    @import '../../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>