<template>
    <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">
        
        <div class="dgrid-header dgrid-header-row ui-widget-header sticky-header" role="row">
            <table class="account-report-table" role="presentation" id="dgrid_120-header">
                <tr>
                    <th style="width:60%" class="text-left">
                    </th>
                    <th style="width:30%;" class="left-dotted text-right">
                        Total
                    </th>
                </tr>
            </table>
        </div>
        <div class="dgrid-scroller" tabindex="-1" style="user-select: text; margin-top: 36px; margin-bottom: 35px;">
            <div class="dgrid-content ui-widget-content">
                <div role="row" class=" dgrid-row dgrid-row-even ui-state-default" id="dgrid_120-row-78">
                    <table class="dgrid-row-table account-report-table">

                        <tr>
                            <td colspan="2">
                                <button class="accordion">Income</button>
                                <div class="panel">
                                    <table class="dgrid-row-table table-hover-tr account-report-table">
                                        <tr>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name" style="width:60%;">
                                                <div>Sales</div>
                                            </td>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type text-right" style="width:30%;">100000</td>
                                        </tr>
                                        <tr>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name" style="width:60%;">
                                                <div>Sales of Product Income</div>
                                            </td>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type text-right" style="width:30%;">100000</td>
                                        </tr>
                                        <tr>
                                            <td class="totalRow" style="width:60%;">
                                                <div>Total income</div>
                                            </td>
                                            <td class="totalRow text-right" style="width:30%;">200000</td>
                                        </tr>
                                    </table>
                                </div>

                                <button class="accordion">Cost of Sales</button>
                                <div class="panel">
                                    <table class="dgrid-row-table table-hover-tr account-report-table">
                                        <tr>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name" style="width:60%;">
                                                <div>Cost of sales</div>
                                            </td>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type text-right" style="width:30%;">100000</td>
                                        </tr>
                                        <tr>
                                            <td class="totalRow" style="width:60%;">
                                                <div>Total Cost of Sales</div>
                                            </td>
                                            <td class="totalRow text-right" style="width:30%;">200000</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="topborder" style="width:60%;">
                                <div class="txt-uppercase">Gross Profit</div>
                            </td>
                            <td class="topborder text-right padding-right-30" style="width:30%;">Ksh200000</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="accordion">Expenses</button>
                                <div class="panel">
                                    <table class="dgrid-row-table table-hover-tr account-report-table">
                                        <tr>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name" style="width:60%;">
                                                <div>Equipment rental</div>
                                            </td>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type text-right" style="width:30%;">6,000.00</td>
                                        </tr>
                                        <tr>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name" style="width:60%;">
                                                <div>Legal and professional fees</div>
                                            </td>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type text-right" style="width:30%;">5,000,000.00</td>
                                        </tr>
                                        <tr>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-0 field-name" style="width:60%;">
                                                <div>Office expenses</div>
                                            </td>
                                            <td class="dgrid-cell dgrid-cell-padding dgrid-column-2 field-type text-right" style="width:30%;">4000</td>
                                        </tr>
                                        <tr>
                                            <td class="totalRow" style="width:60%;">
                                                <div>Total Expenses</div>
                                            </td>
                                            <td class="totalRow text-right" style="width:30%;">200000</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="topborder" style="width:60%;">
                                <div class="txt-uppercase">Net Earnings</div>
                            </td>
                            <td class="topborder text-right padding-right-30" style="width:30%;">Ksh200000</td>
                        </tr>

                    </table>
                </div>

            </div>
        </div>

    </div>
</template>

<style scoped>

    tbody.collapse.in {
        display: table-row-group;
    }
    
    .report-filters-inputs{
        outline: none;
        height: 32px;
        border: 1px solid #BABEC5;
        padding: 0 8px;
        border-radius: 2px;
        transition-property: border;
        transition-duration: 0.35s;
        font-size: 13px;
        background-color: #FFFFFF;
        box-sizing: border-box;
        -webkit-appearance: none;
        width: 100%;
        vertical-align: middle;
    }

    .professionalreports {
        border-width: 0 0 1px;
        border-style: dotted;
        display: inline-block;
    }

    .professionalreports {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .accordion {
        /* background-color: #eee; */
        background-color: transparent!important;
        color: #444;
        cursor: pointer;
        /* padding: 18px; */
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 14px;
        font-weight: 600!important;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        /* max-height: 0; */
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        margin-bottom: 0!important;
        -webkit-box-shadow: 0 0 0 rgba(0,0,0,0);
        box-shadow: 0 0 0 rgba(0,0,0,0);
    }

</style>
