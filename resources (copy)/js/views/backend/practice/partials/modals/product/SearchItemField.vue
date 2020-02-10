<template>
    <div v-bind:class="{'padding-bottom-10 padding-right-10 padding-left-10 form-group':barcode,'bg-eee':bg_eee}" v-bind:style="{ width: field_cover_wdth + 'px'}">
        <label v-if="show_label" class="fs-12"><i v-if="!searching_list" class="fa fa-barcode" aria-hidden="true"></i><i v-if="searching_list" class="fa fa-spinner fa-spin"></i>  SCAN BARCODE OR SEARCH ITEMS</label>
        <input type="text" :disabled="loading_list" v-model="query" class="form-control report-filters-inputs height-32" v-bind:style="{ width: field_wdth + '%'}" autofocus="autofocus"/>
        <div v-if="tabulated_view" id="search_id_result_manual">
            <div v-if="searched_products_list.length">
                <a class="fs-12 fw-600 txt-uppercase">{{searched_products_list.length}} item(s) selected</a> | 
                <a @click="close_search_result('ADD')" class="cl-blue-link fs-12 fw-600 txt-uppercase">Add</a> | 
                <a @click="close_search_result('CLEAR')" class="cl-amref fs-12 pointer-cursor fw-600 txt-uppercase">Clear</a> | 
                <a @click="close_search_result('CLOSE')" class="cl-amref fs-12 pointer-cursor fw-600 txt-uppercase">Close</a> | 
            </div>
            <ul v-if="queryResults.length" class="search_result" v-bind:style="{ width: search_result_width + 'px',maxHeight:search_result_min_height+'px'}">
                <table class="search-table table-hover">
                    <tr>
                        <th style="width:2%"><input class="pointer-cursor" @click="check_all($event)" type="checkbox"></th>
                        <th style="width:25%">Item Name</th>
                        <th style="width:14%">Item Code</th>
                        <th style="width:22%">Brand</th>
                        <th style="width:7%">Pack/Size</th>
                        <th style="width:6%">U.O.M</th>
                        <th style="width:8%">Stock</th>
                        <th style="width:8%">Retail</th>
                        <th style="width:8%">W.Sale</th>
                        <th style="width:2%" class="fw-600 fs-12 pointer-cursor cl-white text-center">
                            <a @click="close_search_result('CLOSE')">x</a>
                        </th>
                    </tr>
                    <tr v-for="(result,index) in queryResults" :key="'queryResults'+index">
                        <td><input type="checkbox" :value="result" v-model="searched_products_list" class="pointer-cursor"></td>
                        <td>{{result.item_name.name}}</td>
                        <td>{{result.sku_code}}</td>
                        <td>{{result.brand.name}}</td>
                        <td>{{result.pack_qty}}</td>
                        <td>{{result.measure_unit.slug}}</td>
                        <td>{{format_money(result.stock)}}</td>
                        <td>{{format_money(result.price.unit_retail_price)}}</td>
                        <td colspan="2">{{format_money(result.price.pack_retail_price)}}</td>
                    </tr>
                </table>
            </ul>
        </div>
        <div v-else id="search_id_result_manual">
            <ul v-if="queryResults.length" class="search_result padding-0" v-bind:style="{ width: search_result_width + 'px',maxHeight:search_result_min_height+'px'}">
                <li @click="close_search_result()" class="cross_search_result"><i class="fa fa-times" aria-hidden="true"></i></li>
                <li v-for="(searched_products_li,index) in queryResults" @click="emit_add_search_item_invoice(searched_products_li)" :key="'searched_products_li'+index">{{searched_products_li.item_name}} | {{searched_products_li.unit_weight}} {{searched_products_li.measure_unit_sympol}} | {{searched_products_li.generic_name}} | SKU:{{searched_products_li.sku_code}} | Barcode: {{searched_products_li.barcode}} | Stock {{searched_products_li.stock_total}}  | Price {{searched_products_li.unit_retail}}  | Whole sale {{searched_products_li.pack_retail}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    import Crocodilians from "../crocodilians.json";
    import fz from 'fuzzaldrin-plus';
    import {get,post} from '../../../../../../helpers/api';
    import {SEARCH_ITEM_URL,PRODUCT_ITEMS_URL} from '../../../../../../router/api_routes';
    import {formatMoney} from '../../../../../../helpers/functionmixin';
    export default {
        props : ['search_result_width','product_items','show_label','field_wdth','field_cover_wdth','products','search_result_min_height','tabulated_view','barcode','bg_eee'],
        data(){
            return {
                searched_products_list: [],
                query: '',
                list_cleared: false,
                loading_list: false,
                searching_list: false,
                //options: Crocodilians
                options: [],
            }
        },
        watch: {
            products: function(new_prod,old_prod){
                this.loadProductItem("hide");
            }
        },
        computed: {
            queryResults() {

                if(!this.query) {
                    this.searching_list = false;
                    return [];
                }

                if(this.list_cleared) {
                    this.searching_list = false;
                    this.list_cleared = false;
                    return [];
                }

                const preparedQuery = fz.prepareQuery(this.query);
                const scores = {};

                return this.options
                    .map((option, index) => {
                    const scorableFields = [
                        option.id,
                        option.item_name.name,
                        option.generic.name,
                        option.item_type.name,
                        option.sku_code,
                        option.category.name,
                        option.order_category.name,
                        option.sub_category.name,
                        option.route.name,
                        option.formulation.name,
                        option.supplier.name,
                        option.manufacturer.name,
                        option.profile.name,
                        option.brand.name,
                        option.brand_sector.name,
                        option.measure_unit.slug,
                        option.single_unit_weight,
                        option.pack_qty,
                        option.alert_indicator_level,
                        option.price.unit_cost,
                        option.price.unit_retail_price,
                        option.opening_stock,
                        option.price.pack_cost,
                        option.price.pack_retail_price,
                        option.note,
                        option.storage_location,
                        option.price.pack_retail_price,
                        `${option.stock}`,
                    ].map(toScore => fz.score(toScore, this.query, { preparedQuery }));
                    scores[option.id] = Math.max(...scorableFields);
                    return option;
                    })
                    .filter(option => scores[option.id] > 1)
                    .sort((a, b) => scores[b.id] - scores[a.id])
                ;
            }
        },
        methods: {

            check_all(event){
                if(event.target.checked){
                    for (let index = 0; index < this.queryResults.length; index++) {
                        const element = this.queryResults[index];
                        this.searched_products_list.push(element);
                        this.product_items.push(element);
                    }
                }else{
                    this.searched_products_list = [];
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            emit_add_search_item_invoice(item_to){
                // this.$emit('item-event',this.product_items);
                // this.close_search_result();
                // this.searched_products_list.push(item_to);
                //this.product_items.push(item_to);
            },

            close_search_result(action_taken){
                switch (action_taken) {
                    case "ADD":
                        //this.product_items = this.searched_products_list;
                        this.$emit('item-event',this.product_items);
                        this.list_cleared = true;
                        this.searched_products_list = [];
                        break;
                    case "CLOSE":
                        this.list_cleared = true;
                        this.searched_products_list = [];
                        break;
                    case "CLEAR":
                        this.list_cleared = true;
                        this.searched_products_list = [];
                        break;
                }
            },

            loadProductItem(state_show){
                this.loading_list = true;
                this.progress_overlay = state_show;
                get(PRODUCT_ITEMS_URL+'/all_items')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.options = res.data.results;
                        this.loading_list = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.loading_list = false;
                });
            },
        },
        mounted(){
            //this.options = this.products;
            this.loadProductItem("hide");
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../sass/transaction_docs.scss';
    table.search-table tr td{
        font-size: 12px;
        border: 1px dotted #babec5;
        padding: 2px 2px 2px 10px;
    }

    table.search-table tr td:hover{
        cursor: pointer;
    }

    th {
        position: sticky;
        top: 0px;
        background: #787887;
        color: #fff;
        padding: 4px 2px 4px 10px;
    }
</style>


