<template>

    <div class="hold-transition skin-yellow sidebar-collapse">
        <page-header :settings="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <sub-header :brandsector="true" :sub_title="'Brand Sector :'"></sub-header>

            <section class="content bg-white">

                <div class="row">

                    <div v-if="prod_loaded && brandsector.length < 1" class="col-xs-12 col-md-12 col-sm-12 mg-top-50">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-body bg-white padding-0">
                            </div>
                        </div>
                        <div class="text-center mg-top-30">
                            <p>You dont have any brand sector</p>
                            <a data-toggle="modal" data-target="#new_brand_sector_modal" class="btn btn-inventory primary">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create new
                            </a>
                        </div>
                    </div>

                    <div v-if="prod_loaded && brandsector.length > 0" class="col-xs-12 col-md-9 col-sm-9 col-lg-9">

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
                                                <span data-toggle="modal" data-target="#new_brand_sector_modal" class="filter"><i class="fa fa-plus"></i> Add</span>
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
                                        <th style="width: 50%">Name</th>
                                        <th style="width: 15%">Created At</th>
                                        <th style="width: 15%">Created By</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr v-for="(brand, index) in brandsector">
                                        <td>{{index + 1}}</td>
                                        <td>{{brand.name}}</td>
                                        <td>{{brand.created_at}}</td>
                                        <td>{{brand.created_by}}</td>
                                        <td>
                                            <a data-toggle="modal" :data-target="'#edit_brand_sector_modal_'+brand.id" class="cl-444 showOnHover"><i class="fa fa-edit"></i></a>
                                            <!-- (Ajax Modal)-->
                                            <div class="modal fade" :id="'edit_brand_sector_modal_'+brand.id">
                                                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                    <brand-sector-modal :form_data="brand" :item_id="brand.id" :branch_id="practice_id" v-on:brandSectorEdited="loadBrands" :initial_ur="initial_url" :user_mode="'Edit'"></brand-sector-modal>
                                                </div>
                                            </div> <!-- Bootstrap model  ends-->
                                            <!-- /.content -->
                                            <a data-toggle="modal" :data-target="'#delete_brand_sector_modal_'+index" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                            <!-- (Ajax Modal)-->
                                            <div class="modal fade" :id="'delete_brand_sector_modal_'+index">
                                                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                    <delete-stuff-modal :modal_title="'Delete Brand Sector'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+brand.id" v-on:deletionSuccessful="loadBrands"></delete-stuff-modal>
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

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="new_brand_sector_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <brand-sector-modal v-if="prod_loaded" :form_data="form_data" :branch_id="practice_id" :user_mode="'Create'" v-on:brandSectorAdded="loadBrands" :initial_ur="initial_url"></brand-sector-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

        </div>

        <page-footer></page-footer>
    </div>

</template>

<script>
    import VueSingleSelect from "vue-single-select";
    import Loading from '../../../../../components/loads/ProgRess'
    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    import DeleteStuffModal from '../../patials/DeleteStuffModal'
    import BrandSectorModal from './partials/BrandSectorModal'
    import SubHeader from '../partials/SubHeader'
    import {get,post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {print_divs,exportToCsv} from "../../../../../helpers/functionmixin";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "Brands",
        components: {
            PageFooter,PageHeader,Loading,SubHeader,BrandSectorModal,DeleteStuffModal,VueSingleSelect
        },
        data(){
            return {
                brandsector: [],
                practice_id: '',
                item_id: '',
                initial_url: '/api/products/brands/sectors',
                item_loaded : false,
                prod_loaded : false,
                processing : false,
                form_data: {
                    name: '',
                    practice_id: '',
                    status: '',
                }
            }
        },
        methods: {

            printThis(ele_id){
                print_divs(ele_id)
            },
            export_to_csv(){
                exportToCsv(this.categories,'Brand Sector')
            },
            loadBrands(){
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Brand Sector')
                    .then((res) => {
                        this.brandsector = [];
                        if(res.data.status_code === 200) {
                            this.brandsector = res.data.results.resources;
                            this.prod_loaded = true;
                        }
                    }).catch((err) => {
                });
            },
        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.form_data.practice_id = this.practice_id;
            this.prod_loaded = true;
            this.loadBrands();
        }

    }
</script>

<style lang="scss">
    @import '../../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>