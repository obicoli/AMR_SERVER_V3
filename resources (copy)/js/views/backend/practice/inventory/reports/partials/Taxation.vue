<template>

    <div class="width-100-pc float-left">

        <div class="width-100-pc float-left">
            <button data-toggle="modal" data-target="#new_tax_modal" type="button" class="btn btn-inventory btn-amref cl-white float-right mg-bottom-5 mg-top-20">+ Tax Rate</button>
            <table class="table table-vendor-list table-hover">
                <thead>
                    <tr>
                        <th style="width:2%;">
                            <input type="checkbox" class="pointer-cursor">
                        </th>
                        <th style="width:16%;">Tax Name</th>
                        <th style="width:16%;">Agent</th>
                        <th style="width:14%;">Tax Pin</th>
                        <th style="width:18%;">Frequency</th>
                        <th style="width:9%;" class="text-right">Sales Rate</th>
                        <th style="width:9%;">Purchase Rate</th>
                        <th style="width:9%;">Status</th>
                        <th style="width:7%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(taxation,index) in taxations" :key="'taxations_'+index">
                        <td></td>
                        <td>{{taxation.name}}</td>
                        <td>{{taxation.agent_name}}</td>
                        <td>{{taxation.registration_number}}</td>
                        <td>{{taxation.filling_frequency}}</td>
                        <td>{{taxation.sales_rate}}</td>
                        <td>{{taxation.purchase_rate}}</td>
                        <td>{{taxation.status}}</td>
                        <td>
                            <a data-toggle="modal" :data-target="'#edit_tax_'+index" class="showOnHover pointer-cursor" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;
                            <a data-toggle="modal" :data-target="'#delete_tax_'+index" class="showOnHover cl-amref pointer-cursor" title="Delete"><i class="fa fa-trash-o"></i></a>
                        </td>
                        <tax-rate :user_mode="'Edit'" :form_data="taxation" :initial_url="tax_api+'/'+taxation.id" v-on:taxChanged="tax_info" :title="'Edit Tax Rate'" :modal_id="'edit_tax_'+index"></tax-rate>
                        <delete-modal v-on:deletionSuccessful="tax_info" :title="'Delete Tax'" :modal_id="'delete_tax_'+index" :item_url="tax_api+'/'+taxation.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Tax'"></delete-modal>
                    </tr>
                    <tr v-if="taxations.length===0">
                        <td colspan="9" class="text-center cl-amref">No data to show!</td>
                    </tr>
                </tbody>
            </table>
            <tax-rate :user_mode="'Create'" :initial_url="tax_api" v-on:taxChanged="tax_info" :title="'+ New Tax Rate'" :modal_id="'new_tax_modal'"></tax-rate>
        </div>
    </div>

</template>

<script>
    import ImagePreview from "../../../../../../components/images/ImagePreview";
    import TaxRate from '../../../partials/modals/inventory_settings/tax/TaxRate';
    import DeleteModal from "../../../partials/modals/DeleteModal";
    export default {
        name: "Taxation",
        props: ['taxes','tax_api'],
        components: {ImagePreview,TaxRate,DeleteModal},
        data(){
            return {
                taxations: [],
            }
        },
        watch: {
            taxes: function(new_data,old_data){
                this.taxations = new_data;
            }
        },
        methods: {
            tax_info(){
                this.$emit("taxChanged");
            }
        },
        mounted(){
            if(this.taxes){
                this.taxations = this.taxes;
            }
        }
    }
</script>