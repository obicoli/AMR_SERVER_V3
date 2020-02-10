<template>

    <table class="user-table employees" role="presentation">
        <thead>
            <tr>
                <!-- <th class="no-rb" style="width:10%">#TransID</th> -->
                <th class="no-rb" style="width:15%">BillNo.</th>
                <th style="width:15%">Date</th>
                <th style="width:18%">Sub-total(Kes)</th>
                <!-- <th style="width:10%">Cash Paid</th> -->
                <th style="width:20%">Total(Kes)</th>
                <!-- <th style="width:10%">Pay Date</th> -->
                <!-- <th style="width:8%">Pay Method</th> -->
                <th style="width:18%">Status</th>
                <th style="width:14%"></th>
            </tr>
        </thead>
        <tbody v-if="purchases.length > 0">
            <tr class="tb-1 tb-2" v-for="(purchase,index) in purchases" :key="'purchase'+index">
                <!-- <td class="no-rb" tabindex="0">
                    {{indexss+1}}
                </td> -->
                <td class="no-rb">
                    {{purchase.bill_no}}
                </td>
                <td class="">
                    {{purchase.created_at}}
                </td>
                <!-- <td class="">
                    BL4DUIOIM
                </td> -->
                <td class="">
                    {{formatMoneys(purchase.total)}}
                </td>
                <td class="">
                    {{formatMoneys(purchase.grand_total)}}
                </td>
                <td class="">
                    {{purchase.status}}
                </td>
                <td class="">
                    <div  class="btn-group float-right" role="group" aria-label="Button group">
                        <a data-toggle="modal" data-target="#userModal" class="btn-link">Action</a>&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index">
                                <a data-toggle="modal" :data-target="'#preview_purchase_'+index" class="dropdown-item">Preview</a>
                                <a class="dropdown-item">Attachments</a>
                                <a class="dropdown-item">Edit</a>
                                <a data-toggle="modal" :data-target="'#delete_purchase_'+index" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                    </div>
                </td>
                <purchase-preview-modal :modal_id="'preview_purchase_'+index" :purchase="purchase" :organ_data="organ_data"></purchase-preview-modal>
                <delete-modal :modal_id="'delete_purchase_'+index" :modal_title="'Delete Purchase'" :confirm_message="'Are you sure?'" :item_url="purchase_url+'/'+purchase.id" v-on:deletionSuccessful="sendToParent"></delete-modal>
            </tr>
        </tbody>
        <tbody v-if="purchases.length === 0">
            <tr>
                <td colspan="10" class="cl-red text-center no-rb"> No purchases to display</td>
            </tr>
        </tbody>
    </table>
    
</template>

<script>
    import {formatMoney} from '../../../../../helpers/functionmixin';
    import PurchasePreviewModal from "../../partials/modals/purchase/PurchasePreviewModal";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {PURCHASES_URL} from "../../../../../router/api_routes"
    export default {
        props: ['purchases','organ_data'],
        components: {PurchasePreviewModal,DeleteModal},
        data(){
            return {
                purchase_url: PURCHASES_URL,
            }
        },
        watch: {
            purchases:function(new_purchases,old_purchases){
                this.purchases = new_purchases;
            }
        },
        methods: {
            formatMoneys(money_to){
                return formatMoney(money_to);
            },
            sendToParent(){
                this.$emit("deletionSuccessful")
            }
        },
    }
</script>

