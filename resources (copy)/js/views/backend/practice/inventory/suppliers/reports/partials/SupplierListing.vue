<template>
    <div class="width-100-pc float-left bg-white padding-20">
        <div class="width-30-pc float-left text-center report-header mg-bottom-15">
            <company-logo></company-logo>
        </div>
        <div class="width-30-pc float-right mg-bottom-15">
            <h2 class="invoice-title fs-19 width-100-pc text-right"><b>Supplier Listing Report</b></h2>
            <table class="table overview-table">
                <tbody>
                    <tr>
                        <td style="width:50%" class="text-right">Date:</td>
                        <td class="text-right fw-600">{{date_range}}</td>
                    </tr>
                    <tr>
                        <td style="width:50%" class="text-right">Page:</td>
                        <td class="text-right fw-600">{{current_page+'/'+total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <table class="table banking-transaction-vat-reports">        
            <thead>
                <tr>
                    <td style="width:20%;" class="somepad-1 fw-600">Name</td>
                    <td style="width:15%" class="somepad-1 fw-600">Category</td>
                    <td style="width:10%" class="somepad-1 fw-600">Active</td>
                    <td style="width:25%" class="somepad-1 fw-600">Contact name</td>
                    <td style="width:15%;" class="somepad-1 fw-600">Telephone</td>
                    <td style="width:15%;" class="text-right somepad fw-600">Balance({{currency}})</td>
                </tr>
            </thead>
            <tbody v-for="(report_data,index) in reported_data" :key="'reported_data'+index">
                <tr>
                    <td class="somepad bd-left">{{report_data.display_as}}</td>
                    <td class="somepad bd-right">{{report_data.category}}</td>
                    <td class="somepad bd-right">
                        <span v-if="report_data.status">YES</span>
                        <span v-else>NO</span>
                    </td>
                    <td class="somepad bd-right">{{report_data.legal_name}}</td>
                    <td class="somepad bd-right">{{report_data.phone}}</td>
                    <td class="somepad text-right bd-right">{{formatMon(report_data.balance)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import CompanyLogo from "../../../../partials/CompanyLogo";
import { formatMoney, format_lunox_date } from '../../../../../../../helpers/functionmixin';
export default {
    name: "SupplierListing",
    props: ['currency','pagination','reported_data','filters'],
    components: {CompanyLogo},
    data(){
        return{
            current_page: '',
            total: '',
            date_range: '',
        }
    },
    methods: {
        formatMon(money_to){
            return formatMoney(money_to)
        }
    },
    mounted(){
        if(this.pagination){
            this.current_page = this.pagination.current_page;
            this.total = this.pagination.total;
        }
        if(this.filters){
            this.date_range = this.filters.today;
        }
    }
}
</script>