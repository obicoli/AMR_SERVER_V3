<template>

    <table class="user-table employees table-striped" role="presentation">
        <thead>
            <tr>
                <th class="no-rb" style="width:15%">PO Number.</th>
                <th style="width:15%">Status</th>
                <th style="width:15%">Date</th>
                <th style="width:20%">PO Value(Kes)</th>
                <th style="width:6%">Type</th>
                <th style="width:15%">Invoiced Value</th>
                <th style="width:14%"></th>
            </tr>
        </thead>
        <tbody v-if="purchases.length > 0">
            <tr class="tb-1 tb-2" v-for="(purchase,index) in purchases" :key="'purchase'+index">
                <td class="no-rb">
                    {{purchase.bill_no}}
                </td>
                <td class="">
                    {{purchase.status}}
                </td>
                <td class="">
                    {{formatMoneys(purchase.total)}}
                </td>
                <td class="">
                    {{formatMoneys(purchase.grand_total)}}
                </td>
                <td class="">
                    {{formatMoneys(purchase.grand_total)}}
                </td>
                <td class="">
                    {{purchase.status}}
                </td>
                <td class="">
                    <div class="btn-group float-right" role="group" aria-label="Button group">
                        <a data-toggle="modal" data-target="#userModal" class="btn-link">Action</a>&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index">
                                <a data-toggle="modal" :data-target="'#preview_purchase_'+index" class="dropdown-item">Preview</a>
                                <a v-if="purchase.status==='Pending'" class="dropdown-item pointer-cursor">Edit</a>
                                <a v-if="!purchase.status==='Delivered'" class="dropdown-item pointer-cursor">Pending</a>
                                <a v-if="purchase.status==='Delivered'" class="dropdown-item pointer-cursor">Close</a>
                                <a v-if="purchase.status==='Pending' && check_permissions('approve.purchase')" class="dropdown-item">Accepted</a>
                                <a v-if="purchase.status==='Pending' && check_permissions('approve.purchase')" class="dropdown-item">Rejected</a>
                                <a v-if="purchase.status==='Submitted' && check_permissions('approve.purchase')" data-toggle="modal" :data-target="'#grn_note_'+index" class="dropdown-item pointer-cursor">Receive Goods</a>
                                <a v-if="purchase.status==='Delivered' && check_permissions('create.purchase')" class="dropdown-item">Grn Note</a>
                                <a v-if="purchase.status==='Delivered' && check_permissions('create.stock')" class="dropdown-item">Update to stock</a>
                                <a v-if="!purchase.status==='Delivered'" data-toggle="modal" :data-target="'#delete_purchase_'+index" class="dropdown-item">Delete</a>
                            </div>
                        </div>
                    </div>
                </td>
                <po-preview-modal :modal_id="'preview_purchase_'+index" :purchase="purchase" :organ_data="organ_data"></po-preview-modal>
                <grn-note-modal :modal_id="'grn_note_'+index" :purchase="purchase" :initializations="initializations" :organ_data="organ_data" :modal_title="'Goods Received Note: LPO#'+purchase.po_number"></grn-note-modal>
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
    import {formatMoney,paginator} from '../../../../../helpers/functionmixin';
    import PoPreviewModal from "../../partials/modals/purchase/PoPreviewModal";
    import GrnNoteModal from "../../partials/modals/purchase/GrnNoteModal";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import {PURCHASES_URL} from "../../../../../router/api_routes";
    import Auth from "../../../../../store/auth";
    export default {
        props: ['purchases','organ_data','initializations'],
        components: {PoPreviewModal,DeleteModal,GrnNoteModal},
        data(){
            return {
                purchase_url: PURCHASES_URL,
                pagination: paginator(),
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
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },
    }
</script>

