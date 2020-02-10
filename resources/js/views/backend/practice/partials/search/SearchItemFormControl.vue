<template>
    <div class="width-400-px">
        <label v-if="show_label" class="fs-12"><i class="fa fa-barcode" aria-hidden="true"></i> {{label_text}}</label>
        <input type="text" class="report-filters-inputs height-32" v-bind:style="{width:field_wdth+'px',borderRadius:rounded_px+'px'}" @keyup="search_things($event,'practice_product_item')" autofocus="autofocus" />
        <div id="search_id_result_manual">
            <ul v-if="searched_products_list.length > 0" class="search_result" v-bind:style="{ width: search_result_width + 'px',maxHeight:search_result_min_height+'px'}">
                <li @click="close_search_result()" class="cross_search_result"><i class="fa fa-times" aria-hidden="true"></i></li>
                <li v-for="(searched_products_li,index) in searched_products_list" @click="emit_add_search_item_invoice(searched_products_li)" :key="'searched_products_li'+index" class="fs-12"><span class="fw-600 fs-13">Name</span>:{{searched_products_li.item_name}} | <span class="fw-600 fs-13">Category</span>:{{searched_products_li.brand}} | <span class="fw-600 fs-13">Weight</span>:{{searched_products_li.unit_weight}} {{searched_products_li.measure_unit_sympol}} | <span class="fw-600 fs-13">Generic</span>: {{searched_products_li.generic_name}} | <span class="fw-600 fs-13">SKU</span>::{{searched_products_li.sku_code}} | <span class="fw-600 fs-13">Barcode</span>: {{searched_products_li.barcode}} | <span class="fw-600 fs-13">Stock</span>: {{searched_products_li.stock_total}}  | <span class="fw-600 fs-13">Price</span>: {{searched_products_li.unit_retail}}  | <span class="fw-600 fs-13">Whole sale</span>: {{searched_products_li.pack_retail}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {get,post} from '../../../../../helpers/api';
    import {SEARCH_ITEM_URL} from '../../../../../router/api_routes';
    export default {
        props: ['practice_id','field_wdth','rounded_px','show_label','search_result_width','search_result_min_height','label_txt','search_type'],
        data(){
            return {
                searched_products_list: [],
                label_text: 'SCAN BARCODE OR SEARCH ITEMS',
            }
        },
        watch: {
            practice_id:function(new_pr,old_pr){
                this.practice_id = new_pr;
            }
        },
        methods: {

            search_things(event, things_type){
                let formData = new FormData();
                formData.append('name',event.target.value);
                formData.append('practice_id',this.practice_id);
                formData.append('search_type',this.search_type);
                post(SEARCH_ITEM_URL+'/'+things_type, formData)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            switch (things_type) {
                                case "practice_product_item":
                                    this.searched_products_list = res.data.results;
                                    console.info(this.searched_products_list);
                                    break;
                            }
                        }
                    }).catch((err) => {

                });
            },
            emit_add_search_item_invoice(item_to){
                this.$emit("itemFound",item_to);
                this.close_search_result();
            },
            close_search_result(){
                this.searched_products_list = [];
            },

        },
        mounted(){
            if(this.label_txt){
                this.label_text = this.label_txt
            }
            
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../sass/transaction_docs.scss';
</style>


