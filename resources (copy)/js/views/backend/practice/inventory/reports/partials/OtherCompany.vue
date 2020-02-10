<template>

    <div class="width-100-pc float-left">

        <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
            <h3 class="fs-14 fw-600">Company Settings</h3>
        </div>
        <div class="width-100-pc float-left">
            <button data-toggle="modal" data-target="#create_new_company" type="button" class="btn btn-inventory btn-amref cl-white float-right mg-bottom-5">+ Add Company</button>
            <table class="table table-vendor-list table-hover">
                <thead>
                    <tr>
                        <th style="width:2%;">
                            <input type="checkbox" class="pointer-cursor">
                        </th>
                        <th style="width:25%;">Name</th>
                        <th style="width:23%;">Propriator Name</th>
                        <th style="width:20%;">Propriator Title.</th>
                        <th style="width:15%;">City</th>
                        <th style="width:10%;">Country</th>
                        <th style="width:5%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company,index) in companies" :key="'companies_'+index">
                        <td>
                            <input class="pointer-cursor" type="checkbox" :value="company.id">
                        </td>
                        <td>{{company.name}}</td>
                        <td>{{company.propriator_name}}</td>
                        <td>{{company.propriator_title}}</td>
                        <td>{{company.city}}</td>
                        <td>{{company.country}}</td>
                        <td>
                            <a data-toggle="modal" :data-target="'#edit_company_'+index" class="showOnHover pointer-cursor" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;
                            <a data-toggle="modal" :data-target="'#delete_company_'+index" class="showOnHover cl-amref pointer-cursor" title="Delete"><i class="fa fa-trash-o"></i></a>
                        </td>
                        <delete-modal v-on:deletionSuccessful="remove_item" :modal_id="'delete_company_'+index" :item_url="company_api+'/'+company.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Company'"></delete-modal>
                        <company-modal :user_mode="'Edit'" :form_data="company" :modal_id="'edit_company_'+index" v-on:newCompany="new_item" :company_api="company_api+'/'+company.id" :title="'Edit Company'"></company-modal>
                    </tr>
                    <tr v-if="!companies.length">
                        <td colspan="7" class="text-center cl-amref fs-12 fw-600">No data to display!</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <company-modal :modal_id="'create_new_company'" :user_mode="'Create'" v-on:newCompany="new_item" :company_api="company_api" :title="'New Company'"></company-modal>
    </div>

</template>

<script>
    import DeleteModal from "../../../partials/modals/DeleteModal";
    import CompanyModal from "./CompanyModal";
    export default {
        name: "OtherCompany",
        props: ['companies','company_api'],
        components:{DeleteModal,CompanyModal},
        data(){
            return {
                //companies: [],
            }
        },
        watch: {
            companies: function(new_data,old_data){
                this.companies = new_data
            }
        },
        methods: {
            new_item(){
                this.$emit("newCompany");
            },
            remove_item(){
                this.$emit("companyDeleted");
            }
        },
        mounted(){
            // if(this.companies_list){
            //     this.companies = this.companies_list;
            // }
        }
    }
</script>