<template>
    <table class="user-table employees" role="presentation">
        <thead>
            <tr>
                <th class="no-rb" style="width:3%">#ID</th>
                <th style="width:8%">Date</th>
                <th style="width:8%">Type</th>
                <th style="width:7%">No</th>
                <th style="width:8%">Customer</th>
                <th style="width:8%">Due Date</th>
                <th style="width:10%">Balance</th>
                <th style="width:13%">Sub Total</th>
                <th style="width:5%">Tax(%)</th>
                <th style="width:12%">Grand Total</th>
                <th style="width:6%">Status</th>
                <th style="width:12%">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="tb-1">
                <td class="no-rb" tabindex="0">
                    1
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Estimate
                </td>
                <td class="">
                    BL4DUIOIM
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Kes {{formatMoneys(12000000)}}
                </td>
                <td class="">
                    Kes {{formatMoneys(12000000)}}
                </td>
                <td class="">
                    16
                </td>
                <td class="">
                    Kes {{formatMoneys(12000000)}}
                </td>
                <td class="">
                    Pending
                </td>
                <td class="">
                    <div  class="btn-group float-right" role="group" aria-label="Button group">
                        <a data-toggle="modal" data-target="#userModal" class="btn-link">Create invoice</a>&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <a :id="'btnGroupDrop2_1'" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu right-0" :aria-labelledby="'btnGroupDrop2_1'">
                                <a class="dropdown-item">Preview</a>
                                <a class="dropdown-item">Print</a>
                                <a class="dropdown-item">Send</a>
                                <a class="dropdown-item">Update status</a>
                                <a class="dropdown-item">Copy</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

            <tr class="tb-1">
                <td class="no-rb" tabindex="0">
                    2
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Invoice
                </td>
                <td class="">
                    BL4D888
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Kes {{formatMoneys(530000)}}
                </td>
                <td class="">
                    Kes {{formatMoneys(800000)}}
                </td>
                <td class="">
                    16
                </td>
                <td class="">
                    Kes {{formatMoneys(120000)}}
                </td>
                <td class="">
                    Partial
                </td>
                <td class="">
                    <div  class="btn-group float-right" role="group" aria-label="Button group">
                        <a data-toggle="modal" data-target="#userModal" class="btn-link">Receive Payment</a>&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <a :id="'btnGroupDrop2_2'" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu right-0" :aria-labelledby="'btnGroupDrop2_2'">
                                <a class="dropdown-item">Preview</a>
                                <a class="dropdown-item">Print</a>
                                <a class="dropdown-item">Send</a>
                                <a class="dropdown-item">Send Reminder</a>
                                <a class="dropdown-item">Share Invoice Link</a>
                                <a class="dropdown-item">Print Packing Slip</a>
                                <a class="dropdown-item">Void</a>
                                <a class="dropdown-item">Delete</a>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

            <tr class="tb-1">
                <td class="no-rb" tabindex="0">
                    3
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Payment
                </td>
                <td class="">
                    BL4D0987
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Kes {{formatMoneys(908870)}}
                </td>
                <td class="">
                    Kes {{formatMoneys(60000)}}
                </td>
                <td class="">
                    16
                </td>
                <td class="">
                    Kes {{formatMoneys(3000)}}
                </td>
                <td class="">
                    Closed
                </td>
                <td class="">
                    
                </td>
            </tr>

            <tr class="tb-1">
                <td class="no-rb" tabindex="0">
                    4
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Invoice
                </td>
                <td class="">
                    BL4D888
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    2017-12-11
                </td>
                <td class="">
                    Kes {{formatMoneys(530000)}}
                </td>
                <td class="">
                    Kes {{formatMoneys(800000)}}
                </td>
                <td class="">
                    16
                </td>
                <td class="">
                    Kes {{formatMoneys(120000)}}
                </td>
                <td class="">
                    Partial
                </td>
                <td class="">
                    <div  class="btn-group float-right" role="group" aria-label="Button group">
                        <a data-toggle="modal" data-target="#userModal" class="btn-link">Receive Payment</a>&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <a :id="'btnGroupDrop2_2'" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </a>
                            <div class="dropdown-menu right-0" :aria-labelledby="'btnGroupDrop2_2'">
                                <a class="dropdown-item">Preview</a>
                                <a class="dropdown-item">Print</a>
                                <a class="dropdown-item">Send</a>
                                <a class="dropdown-item">Update status</a>
                                <a class="dropdown-item">Copy</a>
                            </div>
                        </div>
                        <!-- <master-modal :practice_user="usery" :initial_url="initial_url+'/master'" :practice_id="practice_id" :modal_id="'master_user_modal_'+indexss"></master-modal> -->
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</template>

<script>
    import {formatMoney} from "../../../../../helpers/functionmixin";
    export default {

        methods: {
            formatMoneys(money_to){
                return formatMoney(money_to)
            },
        }
        
    }
</script>

