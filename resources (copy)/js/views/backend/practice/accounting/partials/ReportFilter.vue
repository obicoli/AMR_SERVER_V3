<template>
    <div class="width-100-pc bg-foo padding-left-40 padding-right-20 padding-top-30 padding-bottom-10">
        <h4 class="fs-17 fw-600">{{title}}</h4>
        <div class="row fullName margin-5">
            <div class="inlineBlock width-200-px padding-right-5 mg-right-10">
                <span class="professionalreports">Report period</span>
                <div class="dijitInline firstName dijitTextBox width-100-pc">
                    <select class="width-100-pc report-filters-inputs">
                        <option disabled selected value="">-select-</option>
                        <option>Today</option>
                        <option>This week</option>
                        <option>This Week-to-date</option>
                        <option>This Month</option>
                        <option>This Month-to-date</option>
                        <option>This Quarter</option>
                        <option>This Quarter-to-date</option>
                        <option>This Year</option>
                        <option>This Year-to-date</option>
                    </select>
                </div>
            </div>
            <div class="inlineBlock width-150-px padding-right-5 padding-top-29">
                <div class="dijitInline firstName dijitTextBox width-100-pc">
                    <select class="width-100-pc report-filters-inputs">
                        <option disabled selected value="">-select-</option>
                        <option>KMO Main Store</option>
                        <option>Westlands Stores</option>
                        <option>Upper Hill Store</option>
                    </select>
                </div>
            </div>
            <div class="inlineBlock mg-left-10 mg-right-10 padding-top-29">
                <div class="dijitInline firstName dijitTextBox width-100-pc">
                    <span class="fs-14">to</span>
                </div>
            </div>
            <div class="inlineBlock width-150-px padding-right-5 padding-top-29">
                <div class="dijitInline firstName dijitTextBox width-100-pc" id="widget_dijit_form_TextBox_2" role="presentation" widgetid="dijit_form_TextBox_2">
                    <select class="width-100-pc report-filters-inputs">
                        <option disabled selected value="">-select-</option>
                        <option>KMO Main Store</option>
                        <option>Westlands Stores</option>
                        <option>Upper Hill Store</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row fullName margin-5">
            <div class="inlineBlock width-350-px padding-right-5">
                <span class="professionalreports">Company/Facility</span>
                <div class="dijitInline firstName dijitTextBox width-100-pc">
                    <select class="width-100-pc report-filters-inputs">
                        <option disabled selected value="">-select-</option>
                        <option>Amref Upper Hill</option>
                        <option>Amref Westlands</option>
                        <option>Amref Lang'ata</option>
                    </select>
                </div>
            </div>
            <div class="inlineBlock padding-right-5 padding-top-29">
                <label class="check-container small element-inlined mg-right-10">
                    <span class="professionalreports">Accounting method:</span>
                </label>
                <label class="radio-container small element-inlined fs-14 mg-right-10">Cash
                    <input type="radio">
                    <span class="checkmark"></span>
                </label>
                <label class="radio-container small element-inlined fs-14 mg-right-10">Acrual
                    <input type="radio">
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="inlineBlock padding-top-29 mg-left-30">
                <button class="btn btn-default bg-white btn-inventory">Run Report</button>
            </div>
        </div>
        <!-- <hr class="mg-top-30"> -->
    </div>
</template>

<script>
    export default {
        name: 'ReportFilter',
        props: ['title'],
    }
</script>

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

