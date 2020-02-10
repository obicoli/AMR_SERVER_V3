<template>

    <div>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar v-if="page_ready" :reports="inventory_reports"></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">
                            
                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">
                                
                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-9 col-lg-9 padding-right-0 border-bottom">

                                                <div class="width-100-pc float-left">
                                                    <div class="width-40-pc float-left">
                                                        <div class="btn-group" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    All {{page_title}} ({{pagination.total}})
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="width-30-pc float-right padding-10">
                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                New
                                                            </button>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                <a v-if="page_title==='Category'" data-toggle="modal" data-target="#import_add_modal_id" class="dropdown-item pointer-cursor">{{page_title}}</a>
                                                                <a v-else-if="page_title==='Sub Category'" data-toggle="modal" data-target="#add_sub_category" class="dropdown-item pointer-cursor">{{page_title}}</a>
                                                                <a v-else data-toggle="modal" data-target="#import_add_modal_id" class="dropdown-item pointer-cursor">{{page_title}}</a>
                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import {{page_title}}</a>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                
                                                <div class="width-100-pc float-left bg-white mg-top-20 mg-bottom-30">
                                                    <div class="width-100-pc float-left padding-15">
                                                        <div class="width-100-pc float-right bg-white mg-top-30">
                                                            <nav>
                                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                    <a @click="loadCategories(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">Category</a>
                                                                    <a @click="loadSubCategory(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">Sub Category</a>
                                                                    <a @click="loadOrderCategory(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===2}" :id="'nav-transactions-tab-'+'2'" data-toggle="tab" :href="'#nav-transactions-'+'2'" role="tab" :aria-controls="'nav-transactions-'+'2'" aria-selected="true" :key="'transactions_tab'+'2'">Order Category</a>
                                                                    <a @click="loadGeneric(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===3}" :id="'nav-transactions-tab-'+'3'" data-toggle="tab" :href="'#nav-transactions-'+'3'" role="tab" :aria-controls="'nav-transactions-'+'3'" aria-selected="true" :key="'transactions_tab'+'3'">Generic</a>
                                                                    <a @click="loadBrands(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===4}" :id="'nav-transactions-tab-'+'4'" data-toggle="tab" :href="'#nav-transactions-'+'4'" role="tab" :aria-controls="'nav-transactions-'+'4'" aria-selected="true" :key="'transactions_tab'+'4'">Brand</a>
                                                                    <a @click="loadBrandSector(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===5}" :id="'nav-transactions-tab-'+'5'" data-toggle="tab" :href="'#nav-transactions-'+'5'" role="tab" :aria-controls="'nav-transactions-'+'5'" aria-selected="true" :key="'transactions_tab'+'5'">Brand Sector</a>
                                                                    <a @click="loadProfiles(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===6}" :id="'nav-transactions-tab-'+'6'" data-toggle="tab" :href="'#nav-transactions-'+'6'" role="tab" :aria-controls="'nav-transactions-'+'6'" aria-selected="true" :key="'transactions_tab'+'6'">Profile</a>
                                                                    <a @click="loadTypes(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===7}" :id="'nav-transactions-tab-'+'7'" data-toggle="tab" :href="'#nav-transactions-'+'7'" role="tab" :aria-controls="'nav-transactions-'+'7'" aria-selected="true" :key="'transactions_tab'+'7'">Product Type</a>
                                                                    <a @click="loadRoutes(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===8}" :id="'nav-transactions-tab-'+'8'" data-toggle="tab" :href="'#nav-transactions-'+'8'" role="tab" :aria-controls="'nav-transactions-'+'8'" aria-selected="true" :key="'transactions_tab'+'8'">Route</a>
                                                                    <a @click="loadFormulation(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===9}" :id="'nav-transactions-tab-'+'9'" data-toggle="tab" :href="'#nav-transactions-'+'9'" role="tab" :aria-controls="'nav-transactions-'+'9'" aria-selected="true" :key="'transactions_tab'+'9'">Formulation</a>
                                                                    <a @click="loadUnits(true)" v-bind:class="{'nav-item nav-link nav-link-overview':true,'active':curr_tab===10}" :id="'nav-transactions-tab-'+'10'" data-toggle="tab" :href="'#nav-transactions-'+'10'" role="tab" :aria-controls="'nav-transactions-'+'10'" aria-selected="true" :key="'transactions_tab'+'10'">U.O.M</a>
                                                                </div>
                                                            </nav>
                                                            <div class="tab-content tab-content-role" id="nav-tabContent">
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_category_modal_id" class="dropdown-item pointer-cursor">Category</a>
                                                                                <a data-toggle="modal" data-target="#import_categories_modal_id" class="dropdown-item pointer-cursor">Import Category</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(item, index) in categories" :key="'item_key_'+index">
                                                                                    <td class="padded">{{item.name}}</td>
                                                                                    <td class="padded">{{item.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="item.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_modal_id_'+index" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_category_modal_00_'+index" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <category-modal
                                                                                            :modal_id="'edit_modal_id_'+index"
                                                                                            :category_api="category_api+'/'+item.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :form_model="item"
                                                                                            :modal_title="'Edit Category'"
                                                                                            @category-action-event="reloadPage('Category')">
                                                                                        </category-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Category'"
                                                                                            :item_url="PRODUCT_CATEGORIES_URL+'/'+item.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_category_modal_00_'+index"
                                                                                            @delete-item-event="reloadPage('Category')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadCategories()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-transactions-'+'1'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'1'" :key="'tab_index_'+'1'">
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(subcategory, sindex) in subcategories" :key="'item_key_'+sindex">
                                                                                    <td class="padded">{{subcategory.name}}</td>
                                                                                    <td class="padded">{{subcategory.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="subcategory.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+sindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+sindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_sub_category_modal_id_'+sindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_sub_category_modal_'+sindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <sub-category-modal
                                                                                            :modal_id="'edit_sub_category_modal_id_'+sindex"
                                                                                            :category_api="PRODUCT_SUB_CATEGORIES_URL+'/'+subcategory.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :form_model="subcategory"
                                                                                            :modal_title="'Edit Sub Category'"
                                                                                            @sub-category-action-event="loadSubCategory(true)">
                                                                                        </sub-category-modal>
                                                                                        <delete-modal 
                                                                                            :modal_title="'Delete sub category'"
                                                                                            :item_url="PRODUCT_SUB_CATEGORIES_URL+'/'+subcategory.id" 
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_sub_category_modal_'+sindex"
                                                                                            @delete-item-event="loadSubCategory()">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadSubCategory()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===2}" :id="'nav-transactions-'+'2'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'2'" :key="'tab_index_'+'2'">
                                                                    <!-- <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-12 cl-blue-link fw-600" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </a>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_order_category_modal_id" class="dropdown-item pointer-cursor">New Order Category</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Order Category</a>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_order_category_modal_id" class="dropdown-item pointer-cursor">New Order Category</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Order Category</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(ordercategory, oindex) in ordercategories" :key="'item_key_'+oindex">
                                                                                    <td class="padded">{{ordercategory.name}}</td>
                                                                                    <td class="padded">{{ordercategory.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="ordercategory.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+oindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+oindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_order_category_modal_id_'+oindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a @click="deleteItem(ordercategory,'Order Category')" data-toggle="modal" :data-target="'#delete_item_modal_0'" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <order-category-modal
                                                                                            :modal_id="'edit_order_category_modal_id_'+oindex"
                                                                                            :category_api="PRODUCT_ORDER_CATEGORIES_URL+'/'+ordercategory.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :form_model="ordercategory"
                                                                                            :modal_title="'Edit Order Category'"
                                                                                            @order-category-action-event="reloadPage()">
                                                                                        </order-category-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadSubCategory()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===3}" :id="'nav-transactions-'+'3'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'3'" :key="'tab_index_'+'3'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_generic_modal_id" class="dropdown-item pointer-cursor">New Generic</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Order Category</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(generic, gindex) in generics" :key="'item_key_'+gindex">
                                                                                    <td class="padded">{{generic.name}}</td>
                                                                                    <td class="padded">{{generic.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="generic.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+gindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+gindex">
                                                                                                    <a data-toggle="modal" :data-target="'#new_generic_modal_id_'+gindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_item_modal_00_'+gindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <generic-modal v-if="page_ready"
                                                                                            :modal_id="'new_generic_modal_id_'+gindex"
                                                                                            :category_api="PRODUCT_GENERIC_URL+'/'+generic.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Generic'"
                                                                                            :form_model="generic"
                                                                                            @order-category-action-event="reloadPage('Generic')">
                                                                                        </generic-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Generic'"
                                                                                            :item_url="PRODUCT_GENERIC_URL+'/'+generic.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_item_modal_00_'+gindex"
                                                                                            @delete-item-event="reloadPage('Generic')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadSubCategory()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===4}" :id="'nav-transactions-'+'4'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'4'" :key="'tab_index_'+'4'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_brand_modal_id" class="dropdown-item pointer-cursor">New Brand</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Brand</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(brand, bindex) in brands" :key="'item_key_'+bindex">
                                                                                    <td class="padded">{{brand.name}}</td>
                                                                                    <td class="padded">{{brand.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="brand.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+bindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+bindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_brand_modal_id_'+bindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_brand_modal_00_'+bindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <brand-modal v-if="page_ready"
                                                                                            :modal_id="'edit_brand_modal_id_'+bindex"
                                                                                            :category_api="PRODUCT_BRANDS+'/'+brand.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Brand'"
                                                                                            :form_model="brand"
                                                                                            @order-category-action-event="reloadPage('Brand')">
                                                                                        </brand-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Brand'"
                                                                                            :item_url="PRODUCT_BRANDS+'/'+brand.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_brand_modal_00_'+bindex"
                                                                                            @delete-item-event="reloadPage('Brand')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadBrands()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===5}" :id="'nav-transactions-'+'5'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'5'" :key="'tab_index_'+'5'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_brand_sector_modal_id" class="dropdown-item pointer-cursor">New Brand Sector</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Brand</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(brandsector, bindex) in brandsectors" :key="'item_key_'+bindex">
                                                                                    <td class="padded">{{brandsector.name}}</td>
                                                                                    <td class="padded">{{brandsector.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="brandsector.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+bindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+bindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_brand_modal_id_'+bindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_brand_modal_00_'+bindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <brand-sector-modal v-if="page_ready"
                                                                                            :modal_id="'edit_brand_modal_id_'+bindex"
                                                                                            :category_api="PRODUCT_BRAND_SECTORS+'/'+brandsector.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Brand Sector'"
                                                                                            :form_model="brandsector"
                                                                                            @brand-sector-action-event="reloadPage('Brand Sector')">
                                                                                        </brand-sector-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Brand Sector'"
                                                                                            :item_url="PRODUCT_BRAND_SECTORS+'/'+brandsector.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_brand_modal_00_'+bindex"
                                                                                            @delete-item-event="reloadPage('Brand Sector')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadBrandSector()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===6}" :id="'nav-transactions-'+'6'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'6'" :key="'tab_index_'+'6'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_profile_modal_id" class="dropdown-item pointer-cursor">New Profile</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Brand</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(profile_name, pindex) in profile_names" :key="'item_key_'+pindex">
                                                                                    <td class="padded">{{profile_name.name}}</td>
                                                                                    <td class="padded">{{profile_name.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="profile_name.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+pindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+pindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_brand_modal_id_'+pindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_profile_modal_00_'+pindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <profile-modal v-if="page_ready"
                                                                                            :modal_id="'edit_brand_modal_id_'+pindex"
                                                                                            :category_api="PRODUCT_PROFILES_URL+'/'+profile_name.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Profile'"
                                                                                            :form_model="profile_name"
                                                                                            @profile-action-event="reloadPage('Profile')">
                                                                                        </profile-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Profile'"
                                                                                            :item_url="PRODUCT_PROFILES_URL+'/'+profile_name.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_profile_modal_00_'+pindex"
                                                                                            @delete-item-event="reloadPage('Profile')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadBrandSector()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===7}" :id="'nav-transactions-'+'7'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'7'" :key="'tab_index_'+'7'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_type_modal_id" class="dropdown-item pointer-cursor">New Product Type</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Brand</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(product_type, tindex) in product_types" :key="'item_key_'+tindex">
                                                                                    <td class="padded">{{product_type.name}}</td>
                                                                                    <td class="padded">{{product_type.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="product_type.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+tindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+tindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_type_modal_id_'+tindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_type_modal_00_'+tindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <types-modal v-if="page_ready"
                                                                                            :modal_id="'edit_type_modal_id_'+tindex"
                                                                                            :category_api="PRODUCT_TYPES_URL+'/'+product_type.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Type'"
                                                                                            :form_model="product_type"
                                                                                            @profile-action-event="reloadPage('Types')">
                                                                                        </types-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Type'"
                                                                                            :item_url="PRODUCT_TYPES_URL+'/'+product_type.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_type_modal_00_'+tindex"
                                                                                            @delete-item-event="reloadPage('Types')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadTypes()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===8}" :id="'nav-transactions-'+'8'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'8'" :key="'tab_index_'+'8'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_route_modal_id" class="dropdown-item pointer-cursor">New Product Route</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Route</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(product_route, rindex) in product_routes" :key="'item_key_'+rindex">
                                                                                    <td class="padded">{{product_route.name}}</td>
                                                                                    <td class="padded">{{product_route.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="product_route.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+rindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+rindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_route_modal_id_'+rindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_route_modal_00_'+rindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <routes-modal v-if="page_ready"
                                                                                            :modal_id="'edit_route_modal_id_'+rindex"
                                                                                            :category_api="PRODUCT_ROUTES_URL+'/'+product_route.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Route'"
                                                                                            :form_model="product_route"
                                                                                            @profile-action-event="reloadPage('Routes')">
                                                                                        </routes-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Type'"
                                                                                            :item_url="PRODUCT_ROUTES_URL+'/'+product_route.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_route_modal_00_'+rindex"
                                                                                            @delete-item-event="reloadPage('Routes')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadTypes()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===9}" :id="'nav-transactions-'+'9'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'9'" :key="'tab_index_'+'9'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_formulation_modal_id" class="dropdown-item pointer-cursor">New Formulation</a>
                                                                                <a data-toggle="modal" data-target="#import_items_modal_id" class="dropdown-item pointer-cursor">Import Formulation</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 30%;">Name</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(formulated, rindex) in formulations" :key="'item_key_'+rindex">
                                                                                    <td class="padded">{{formulated.name}}</td>
                                                                                    <td class="padded">{{formulated.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="formulated.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+rindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+rindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_formulation_modal_id_'+rindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_formulation_modal_00_'+rindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <formulation-modal v-if="page_ready"
                                                                                            :modal_id="'edit_formulation_modal_id_'+rindex"
                                                                                            :category_api="PRODUCT_FORMULATIONS_URL+'/'+formulated.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Formulation'"
                                                                                            :form_model="formulated"
                                                                                            @profile-action-event="reloadPage('Formulations')">
                                                                                        </formulation-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Type'"
                                                                                            :item_url="PRODUCT_FORMULATIONS_URL+'/'+formulated.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_formulation_modal_00_'+rindex"
                                                                                            @delete-item-event="reloadPage('Formulations')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadFormulation()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                                <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===10}" :id="'nav-transactions-'+'10'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'10'" :key="'tab_index_'+'10'">
                                                                    <div class="width-30-pc float-right padding-10">
                                                                        <div class="btn-group float-right mg-left-5 mg-right-5" role="group">
                                                                            <button :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                New
                                                                            </button>
                                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                                <a data-toggle="modal" data-target="#new_unit_modal_id" class="dropdown-item pointer-cursor">Unit of measure</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="width-100-pc float-left min-height-120 padding-10">
                                                                        <table class="table itemized x-panel">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width: 35%;">Name</th>
                                                                                    <th style="width: 15%;">Symbol</th>
                                                                                    <th style="width: 35%;">Description</th>
                                                                                    <th style="width: 5%;">Active</th>
                                                                                    <th style="width: 10%;" class="text-right">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr v-for="(product_unit, uindex) in product_units" :key="'item_key_'+uindex">
                                                                                    <td class="padded">{{product_unit.name}}</td>
                                                                                    <td class="padded">{{product_unit.slug}}</td>
                                                                                    <td class="padded">{{product_unit.description}}</td>
                                                                                    <td class="padded">
                                                                                        <input v-model="product_unit.status" type="checkbox" disabled>
                                                                                    </td>
                                                                                    <td class="padded">
                                                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                                                            <div class="btn-group" role="group">
                                                                                                <a :id="'btnGroupDrop2_'+uindex" class="dropdown-toggle pointer-cursor fw-600 fs-11 cl-blue-link showOnHover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Action
                                                                                                </a>
                                                                                                <div class="dropdown-menu mr-10" :aria-labelledby="'btnGroupDrop2_'+uindex">
                                                                                                    <a data-toggle="modal" :data-target="'#edit_unit_modal_id_'+uindex" class="dropdown-item pointer-cursor">Edit</a>
                                                                                                    <a data-toggle="modal" :data-target="'#delete_unit_modal_00_'+uindex" class="dropdown-item pointer-cursor">Delete</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <units-modal v-if="page_ready"
                                                                                            :modal_id="'edit_unit_modal_id_'+uindex"
                                                                                            :category_api="PRODUCT_UNITS+'/'+product_unit.id"
                                                                                            :user_mode="'Edit'"
                                                                                            :modal_title="'Edit Unit of Measure'"
                                                                                            :form_model="product_unit"
                                                                                            @uom-action-event="reloadPage('Units of Measure')">
                                                                                        </units-modal>
                                                                                        <delete-modal
                                                                                            :modal_title="'Delete Unit'"
                                                                                            :item_url="PRODUCT_UNITS+'/'+product_unit.id"
                                                                                            :confirm_message="'Are you sure?'"
                                                                                            :modal_id="'delete_unit_modal_00_'+uindex"
                                                                                            @delete-item-event="reloadPage('Units of Measure')">
                                                                                        </delete-modal>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="width-100-pc float-left text-center">
                                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadFormulation()" :custom="true"></paginate-template>
                                                                    </div>
                                                                    <div class="width-100-pc float-left padding-10 text-center">
                                                                        <button type="button" class="btn btn-secondary banking-process-amref">Print</button>
                                                                        <button type="button" class="btn btn-secondary banking-process">Email</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 col-lg-12 padding-right-0 border-bottom">
                                                <product-qv></product-qv>
                                                <general-import-modal v-if="page_ready" v-on:imported="loadCategories" :title="'Import Category'" :modal_id="'import_categories_modal_id'" :modal_min_width="900" :sample_file="'categories'" :upload_type="'Category'"></general-import-modal>
                                                <general-import-modal v-if="page_ready" @imported="loadItems(true)" :title="'Import Items'" :modal_id="'import_items_modal_id'" :modal_min_width="1000" :sample_file="'invetory_items'" :upload_type="'Inventory Items'"></general-import-modal>
                                                <category-modal v-if="page_ready"
                                                    :modal_id="'new_category_modal_id'"
                                                    :category_api="PRODUCT_CATEGORIES_URL"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New category'"
                                                    @category-action-event="reloadPage('Category')">
                                                </category-modal>
                                                <sub-category-modal v-if="page_ready"
                                                    :modal_id="'add_sub_category'"
                                                    :category_api="PRODUCT_SUB_CATEGORIES_URL"
                                                    :user_mode="user_mode"
                                                    :modal_title="'New Sub Category'"
                                                    @sub-category-action-event="reloadPage('Sub Category')">
                                                </sub-category-modal>
                                                <order-category-modal v-if="page_ready"
                                                    :modal_id="'new_order_category_modal_id'"
                                                    :category_api="PRODUCT_ORDER_CATEGORIES_URL"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Order Category'"
                                                    @order-category-action-event="reloadPage('Order Category')">
                                                </order-category-modal>
                                                <generic-modal v-if="page_ready"
                                                    :modal_id="'new_generic_modal_id'"
                                                    :category_api="PRODUCT_GENERIC_URL"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Item Generic'"
                                                    @order-category-action-event="reloadPage()">
                                                </generic-modal>
                                                <brand-modal v-if="page_ready"
                                                    :modal_id="'new_brand_modal_id'"
                                                    :category_api="PRODUCT_BRANDS"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Brand'"
                                                    @brand-action-event="reloadPage('Brand')">
                                                </brand-modal>
                                                <brand-sector-modal v-if="page_ready"
                                                    :modal_id="'new_brand_sector_modal_id'"
                                                    :category_api="PRODUCT_BRAND_SECTORS"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Brand Sector'"
                                                    @brand-sector-action-event="reloadPage('Brand Sector')">
                                                </brand-sector-modal>
                                                <profile-modal v-if="page_ready"
                                                    :modal_id="'new_profile_modal_id'"
                                                    :category_api="PRODUCT_PROFILES_URL"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Profile'"
                                                    @profile-action-event="reloadPage('Profile')">
                                                </profile-modal>
                                                <types-modal v-if="page_ready"
                                                    :modal_id="'new_type_modal_id'"
                                                    :category_api="PRODUCT_TYPES_URL"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Product Type'"
                                                    @profile-action-event="reloadPage('Types')">
                                                </types-modal>
                                                <routes-modal v-if="page_ready"
                                                    :modal_id="'new_route_modal_id'"
                                                    :category_api="PRODUCT_ROUTES_URL"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Product Route'"
                                                    @profile-action-event="reloadPage('Routes')">
                                                </routes-modal>
                                                <formulation-modal v-if="page_ready"
                                                    :modal_id="'new_formulation_modal_id'"
                                                    :category_api="PRODUCT_FORMULATIONS_URL"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Formulation'"
                                                    @profile-action-event="reloadPage('Formulations')">
                                                </formulation-modal>
                                                <units-modal v-if="page_ready"
                                                    :modal_id="'new_unit_modal_id'"
                                                    :category_api="PRODUCT_UNITS"
                                                    :user_mode="'Create'"
                                                    :modal_title="'New Unit of Measure'"
                                                    @uom-action-event="reloadPage('Units of Measure')">
                                                </units-modal>
                                                <delete-modal 
                                                    :modal_title="detele_title"
                                                    :item_url="delete_item_api" 
                                                    :confirm_message="'Are you sure?'"
                                                    :modal_id="'delete_item_modal_0'"
                                                    @delete-item-event="itemDeleted()">
                                                </delete-modal>
                                                <copy-right></copy-right>
                                            </div>
                                        </div>
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
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../partials/CopyRight';
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import ProductModal from '../../partials/modals/product/ProductModal';
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import ProductQv from "../../partials/modals/inventory/ProductQv";
    import CategoryModal from "../../partials/modals/inventory/CategoryModal";
    import SubCategoryModal from "../../partials/modals/inventory/SubCategoryModal";
    import OrderCategoryModal from "../../partials/modals/inventory/OrderCategoryModal";
    import GenericModal from "../../partials/modals/inventory/GenericModal";
    import BrandModal from "../../partials/modals/inventory/BrandModal";
    import BrandSectorModal from "../../partials/modals/inventory/BrandSectorModal";
    import ProfileModal from "../../partials/modals/inventory/ProfileModal";
    import TypesModal from "../../partials/modals/inventory/TypesModal";
    import RoutesModal from "../../partials/modals/inventory/RoutesModal";
    import FormulationModal from "../../partials/modals/inventory/FormulationModal";
    import UnitsModal from "../../partials/modals/inventory/UnitsModal";

    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES,REPORT_SECTIONS} from "../../../../../helpers/process_status";
    import {PRODUCT_CATEGORIES_URL,PRODUCT_UNITS,PRODUCT_SUB_CATEGORIES_URL,PRODUCT_ORDER_CATEGORIES_URL,PRODUCT_ROUTES_URL,PRODUCT_GENERIC_URL,PRODUCT_FORMULATIONS_URL,PRODUCT_BRANDS,PRODUCT_BRAND_SECTORS,PRODUCT_PROFILES_URL,PRODUCT_TYPES_URL} from '../../../../../router/api_routes';
    export default {
        name: "Category",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,GenericModal,BrandModal,BrandSectorModal,RoutesModal,FormulationModal,
        ProductModal,GeneralImportModal,ProductQv,CategoryModal,SubCategoryModal,OrderCategoryModal,ProfileModal,TypesModal,UnitsModal},
        data(){
            return {
                //
                curr_tab: 0,
                modal_title: 'New Category',
                category_api: PRODUCT_CATEGORIES_URL,
                page_title: 'Category',
                delete_item_api: null,
                page_ready: false,
                inventory_reports: [],
                form_model: null,
                user_mode: 'Create',
                detele_title: null,
                PRODUCT_CATEGORIES_URL: PRODUCT_CATEGORIES_URL,
                PRODUCT_SUB_CATEGORIES_URL:PRODUCT_SUB_CATEGORIES_URL,
                PRODUCT_ORDER_CATEGORIES_URL:PRODUCT_ORDER_CATEGORIES_URL,
                PRODUCT_GENERIC_URL:PRODUCT_GENERIC_URL,
                PRODUCT_BRANDS: PRODUCT_BRANDS,
                PRODUCT_BRAND_SECTORS:PRODUCT_BRAND_SECTORS,
                PRODUCT_PROFILES_URL:PRODUCT_PROFILES_URL,
                PRODUCT_TYPES_URL: PRODUCT_TYPES_URL,
                PRODUCT_ROUTES_URL:PRODUCT_ROUTES_URL,
                PRODUCT_FORMULATIONS_URL:PRODUCT_FORMULATIONS_URL,
                PRODUCT_UNITS:PRODUCT_UNITS,
                
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                PROCESS_STATUS: PROCESS_STATUS,
                
                categories: [],
                subcategories: [],
                ordercategories: [],
                generics: [],
                brands: [],
                brandsectors: [],
                profile_names: [],
                product_types: [],
                product_routes: [],
                formulations: [],
                product_units: [],
            }
        },
        methods: {

            check_all(event){
                this.selected_salesorders = [];
                if(event.target.checked){
                    for (let index = 0; index < this.salesorders.length; index++) {
                        const element = this.salesorders[index];
                        this.selected_salesorders.push(element.id);
                    }
                }
            },

            deleteItem(item,item_type){
                switch (item_type) {
                    case "Order Category":
                        this.detele_title = "Delete Order Category";
                        this.delete_item_api = PRODUCT_ORDER_CATEGORIES_URL+'/'+item.id;
                        break;
                    case "Generic":
                        this.detele_title = "Delete Generic";
                        this.delete_item_api = PRODUCT_GENERIC_URL+'/'+item.id;
                    default:
                        break;
                }
            },

            itemDeleted(){
                switch (this.detele_title) {
                    case "Delete Order Category":
                        this.loadOrderCategory(true);
                        break;
                    default:
                        break;
                }
            },

            editItem(item,item_type){
                switch (item_type) {
                    case "Category":
                        this.user_mode = 'Edit';
                        this.form_model = item;
                        this.item_url = PRODUCT_CATEGORIES_URL+'/'+item.id;
                        break;
                    default:
                        break;
                }
            },

            reloadPage(current_tab='Category'){
                let location_to = '/inventory/items/categories?attr='+current_tab;
                window.location.href = location_to;
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            loadUnits(){
                this.page_title = "Unit of Measures";
                this.is_initializing = true;
                get(PRODUCT_UNITS+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.product_units = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadFormulation(){
                this.page_title = "Formulations";
                this.is_initializing = true;
                get(PRODUCT_FORMULATIONS_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.formulations = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadRoutes(){
                this.page_title = "Routes";
                this.is_initializing = true;
                get(PRODUCT_ROUTES_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.product_routes = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadTypes(){
                this.page_title = "Product Types";
                this.is_initializing = true;
                get(PRODUCT_TYPES_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.product_types = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadProfiles(){
                this.page_title = "Profiles";
                this.is_initializing = true;
                get(PRODUCT_PROFILES_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.profile_names = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadBrandSector(){
                this.page_title = "Brand Sectors";
                this.is_initializing = true;
                get(PRODUCT_BRAND_SECTORS+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.brandsectors = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },
            loadBrands(){
                this.page_title = "Brands";
                this.is_initializing = true;
                get(PRODUCT_BRANDS+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.brands = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadGeneric(){
                this.page_title = "Generic";
                this.is_initializing = true;
                get(PRODUCT_GENERIC_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.generics = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadSubCategory(){
                this.page_title = "Sub Category";
                this.is_initializing = true;
                get(PRODUCT_SUB_CATEGORIES_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.subcategories = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadOrderCategory(){
                this.page_title = "Order Category";
                this.is_initializing = true;
                get(PRODUCT_ORDER_CATEGORIES_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.ordercategories = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },

            loadCategories(load_status=false){
                this.page_title = "Category";
                this.is_initializing = true;
                get(PRODUCT_CATEGORIES_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.categories = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                });
            },
        },

        mounted() {
            this.attr_type = this.$route.query.attr;
            if(this.attr_type){
                switch (this.attr_type) {
                    case "Category":
                        this.curr_tab = 0;
                        this.loadCategories();
                        break;
                    case "Sub Category":
                        this.curr_tab = 1;
                        this.loadSubCategory();
                        break;
                    case "Order Category":
                        this.curr_tab = 2;
                        this.loadOrderCategory();
                        break;
                    case 'Generic':
                        this.curr_tab = 3;
                        this.loadGeneric();
                        break;
                    case 'Brand':
                        this.curr_tab = 4;
                        this.loadBrands();
                        break;
                    case 'Brand Sector':
                        this.curr_tab = 5;
                        this.loadBrandSector();
                        break;
                    case "Profile":
                        this.curr_tab = 6;
                        this.loadProfiles();
                        break;
                    case "Types":
                        this.curr_tab = 7;
                        this.loadTypes();
                        break;
                    case "Routes":
                        this.curr_tab = 8;
                        this.loadRoutes();
                        break;
                    case "Formulations":
                        this.curr_tab = 9;
                        this.loadFormulation();
                        break;
                    case "Units of Measure":
                        this.curr_tab = 10;
                        this.loadUnits();
                        break;
                    default:
                        this.curr_tab = 0;
                        this.loadCategories();
                        break;
                }
            }else{
                this.curr_tab = 0;
                this.loadCategories();
            }
            
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>