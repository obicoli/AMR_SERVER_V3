<template>

    <div class="hold-transition skin-yellow sidebar-collapse">
        <page-header :settings="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <sub-header :category="true" :sub_title="'Medicine Category List :'"></sub-header>

            <section class="content bg-white">

                <div class="row">

                    <div v-if="prod_loaded && categories.length < 1" class="col-xs-12 col-md-12 col-sm-12 mg-top-50">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-body bg-white padding-0">
                            </div>
                        </div>
                        <div class="text-center mg-top-30">
                            <p>You dont have any category</p>
                            <a data-toggle="modal" data-target="#new_category_modal" class="btn btn-inventory primary">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create new
                            </a>
                        </div>
                    </div>

                    <div v-if="prod_loaded && categories.length > 0" class="col-xs-12 col-md-9 col-sm-9 col-lg-9">

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
                                                <span data-toggle="modal" data-target="#new_category_modal" class="filter"><i class="fa fa-plus"></i> Add</span>
                                                <span data-toggle="modal" data-target="#upload_category_modal" class="filter"><i class="fa fa-upload"></i> Upload CSV</span>
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
                                        <th style="width: 5%">#ID</th>
                                        <th style="width: 15%">Name</th>
                                        <th style="width: 25%">Description</th>
                                        <th style="width: 15%">Date</th>
                                        <th style="width: 15%">Added By</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">

                                    <tr v-for="(categori, index) in categories">
                                        <td>{{index + 1}}</td>
                                        <td>{{categori.name}}</td>
                                        <td>{{categori.description}}</td>
                                        <td>{{categori.created_at}}</td>
                                        <td>{{categori.created_by}}</td>
                                        <td>
                                            <span v-if="categori.status===1"> Active</span>
                                            <span v-else>Inactive</span>
                                        </td>
                                        <td>
                                            <a data-toggle="modal" :data-target="'#edit_category_modal_'+index" class="cl-444 showOnHover"><i class="fa fa-edit"></i></a>
                                            <!-- (Ajax Modal)-->
                                            <div class="modal fade" :id="'edit_category_modal_'+index">
                                                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                    <category-modal :form_data="categori" :item_id="categori.id" :branch_id="practice_id" :user_mode="'Edit'" v-on:categoryEdited="loadCategory"></category-modal>
                                                </div>
                                            </div> <!-- Bootstrap model  ends-->
                                            <!-- /.content -->
                                            <a data-toggle="modal" :data-target="'#delete_category_modal_'+index" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                            <!-- (Ajax Modal)-->
                                            <div class="modal fade" :id="'delete_category_modal_'+index">
                                                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                                                    <delete-stuff-modal :modal_title="'Delete Category'" :confirm_message="'Are you sure?'" :item_url="initial_ur+'/'+categori.id" v-on:deletionSuccessful="loadCategory"></delete-stuff-modal>
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
            <div class="modal fade" id="new_category_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <category-modal v-if="prod_loaded" :form_data="form_data" :branch_id="practice_id" :user_mode="'Create'" v-on:categoryAdded="loadCategory"></category-modal>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

            <!-- (Ajax Modal)-->
            <div class="modal fade" id="upload_category_modal">
                <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="cl-grey"><i class="fa fa-upload"></i>Upload Categories</h4>
                            <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                        </div>
                        <div  class="modal-body">
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Format:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <img src="/assets/icons/category_format_csv.png">
                                </div>
                            </div>
                            <div class="row form-group mg-bottom-10">
                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                    <label class="fs-14 cl-888">Select a Csv:</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="file" class="form-control product-entry-input-field">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-inventory primary">
                                <span><i class="fa fa-trash-o" aria-hidden="true"></i> Upload</span>
                            </button>
                            <button data-dismiss="modal" class="btn btn-inventory">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div> <!-- Bootstrap model  ends-->
            <!-- /.content -->

        </div>

        <page-footer></page-footer>
    </div>

</template>

<script>
    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    import DeleteStuffModal from '../../patials/DeleteStuffModal'
    import ReadCsvModal from '../../patials/ReadCsvModal'
    import SubHeader from '../partials/SubHeader'
    import CategoryModal from './partials/CategoryModal'
    import {get,post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {print_divs,exportToCsv} from "../../../../../helpers/functionmixin";


    export default {
        name: "CateIndex",
        components: {
            PageFooter,PageHeader,SubHeader,CategoryModal,DeleteStuffModal,ReadCsvModal
        },
        data(){
            return {
                categories: [],
                category_item: {},
                pharmacy_name: '',
                prod_loaded: false,
                practice_id: '',
                item_id: '',
                initial_ur: '/api/practices/medicine_category',
                item_loaded : false,
                form_data: {
                    name: '',
                    description: '',
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
                exportToCsv(this.categories,'Category List')
            },
            loadCategory(){
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Medicine Category')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.categories = res.data.results.resources;
                        }
                    }).catch((err) => {
                });
            },
            setItemTo(practice_prod){
                console.info(practice_prod);
                this.item_id = practice_prod.id;
                this.initial_ur = '/api/practices/medicine_category/'+practice_prod.id;
                this.form_data.name = practice_prod.name;
                this.form_data.status = practice_prod.status;
                this.form_data.description = practice_prod.description;
                this.item_loaded = true;
            }

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.form_data.practice_id = this.practice_id;
            this.prod_loaded = true;
            this.loadCategory();
        }
    }
</script>

<style scoped>

</style>