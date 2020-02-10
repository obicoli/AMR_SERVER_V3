<template>
    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="save_employee" class="modal-content">
                <div class="modal-header">
                    <h4 class="float-left dijitDialogTitle" id="myModalLabel2">{{title}}</h4>
                    <a class="close float-right" data-dismiss="modal" aria-label="Close"><span class="fs-16" aria-hidden="true">&times;</span></a>
                </div>
                <div class="modal-body pd-l-55 pd-r-55 padding-bottom-29">
                    <div class="row">

                        <div class="col-lg-12 col-md-12">

                            <div class="padding-right-10">

                                <div class="row fullName mg-bottom-10">
                                    <div class="inlineBlock width-100-pc">
                                        <div class="filter-block form-inline width-100-pc">
                                            <span class="name">Status: </span>
                                            <div class="filter-group input-group">
                                                <span @click="setStatus('all',0)" v-bind:class="{'filter':true,'active':filter_is===0}">All</span>
                                                <span @click="setStatus('low',1)" v-bind:class="{'filter':true,'active':filter_is===1}">Low</span>
                                                <span @click="setStatus('stock out',2)" v-bind:class="{'filter':true,'active':filter_is===2}">Stock out</span>
                                                <span @click="setStatus('recently expired',3)" v-bind:class="{'filter':true,'active':filter_is===3}">Recent expired</span>
                                                <span @click="setStatus('expired',4)" v-bind:class="{'filter':true,'active':filter_is===4}">Expired</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row fullName">
                                    <div class="inlineBlock width-33-pc mg-right-3">
                                        <!-- <label class="fullname">Gender</label> -->
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <vue-single-select
                                                name="maybe"
                                                :required="true"
                                                placeholder="Facility"
                                                you-want-to-select-a-post="ok"
                                                v-model="facility_item"
                                                out-of-all-these-posts="makes sense"
                                                :options="facilities"
                                                a-post-has-an-id="good for search and display"
                                                option-key=""
                                                the-post-has-a-title="make sure to show these"
                                                option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-33-pc mg-right-3">
                                        <!-- <label class="fullname" for="firstName">First name</label> -->
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <select v-bind:class="{'height-32':true}">
                                                <option value="" selected disabled>--type</option>
                                                <option value="Male">All</option>
                                                <option v-for="(prod_type,index) in product_types" :key="'prod_type'+index">{{prod_type.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="inlineBlock width-33-pc">
                                        <!-- <label class="fullname" for="firstName">Other name</label> -->
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <vue-single-select
                                                name="maybe"
                                                :required="true"
                                                placeholder="Item category"
                                                you-want-to-select-a-post="ok"
                                                v-model="item_category"
                                                out-of-all-these-posts="makes sense"
                                                :options="categories"
                                                a-post-has-an-id="good for search and display"
                                                option-key=""
                                                the-post-has-a-title="make sure to show these"
                                                option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>
                                </div>

                                

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-inventory btn-amref">
                        <span>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else>Select</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory cancel">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FilterModal",
        props:['practice_id','facilities','categories','modal_id','title','categories','product_types'],
        data(){
            return {
                processing: false,
                facility_item:{},
                item_category: {},
                filter_is: 0,
            }
        },
        methods: {
            setStatus(status_,num_){
                this.filter_is = num_;
            },
        },
        mounted() {

        }
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-lg {
        max-width: 800px!important;
        min-width: 800px!important;
    }
    .modal-header{
        border-bottom: 1px solid #fff!important;
    }
    .pd-l-55{padding-left: 55px!important;}
    .pd-r-55{padding-right: 55px!important;}
    .dijitDialogTitle {
        font-weight: 600;
        color: #000000;
        font-size: 2.2rem!important;
        /* line-height: 70px; */
        line-height: 50px!important;
        max-width: calc(100% - 40px);
    }
    .fullAdd.employeeForm .row {
        padding-bottom: 4px;
    }
    .inlineBlock {
        display: inline-block;
    }
    .inlineBlock label {
        font-weight: 600!important;
        color: #404040!important;
        display: block!important;
        margin-bottom: 4px!important;
        font-size: 14px!important;
    }
    .dijitInline {
        display: inline-block;
        border: 0;
        padding: 0;
        vertical-align: middle;
    }
    .dijitTextBox input, .dijitTextBox textarea, .dijitTextBox select{
        outline: none!important;
        /* height: 32px!important; */
        border: 1px solid #BABEC5!important;
        padding: 0 8px!important;
        border-radius: 2px!important;
        transition-property: border!important;
        transition-duration: 0.35s!important;
        font-size: 13px!important;
        background-color: #FFFFFF;
        box-sizing: border-box!important;
        -webkit-appearance: none!important;
        width: 100%;
        vertical-align: middle!important;
    }

    input::placeholder, textarea::placeholder  {
        color: #babec5!important;
        font-size: 12px!important;
        font-style: italic;
        font-weight: 400!important;
    }
    .checkboxInline {
        margin-left: 5px;
    }
    input[type=checkbox]:not(.dijitCheckBoxInput):not(.idsCheckbox__input) {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        background-color: transparent;
        border: 1px solid #8D9096;
        border-radius: 2px;
        background-repeat: no-repeat;
        background-size: 124px;
        background-position: -28px -3px;
        user-select: none;
        -webkit-appearance: none;
    }
    .attended_fiel{
        background-color: #f4f4f4!important;
        font-weight: 600!important;
    }
</style>


