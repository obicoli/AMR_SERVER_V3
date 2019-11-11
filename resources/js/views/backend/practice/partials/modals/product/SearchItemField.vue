<template>
    <div class="form-group">
        <label><i class="fa fa-barcode" aria-hidden="true"></i> SCAN BARCODE OR SEARCH ITEMS</label>
            <input type="text" class="form-control report-filters-inputs width-500-px" @keyup="search_things($event,'practice_product_item')" autofocus="autofocus" />
            <div id="search_id_result_manual">
            <ul v-if="searched_products_list.length > 0" class="search_result width-500-px">
                <li @click="close_search_result()" class="cross_search_result"><i class="fa fa-times" aria-hidden="true"></i></li>
                <li v-for="(searched_products_li,index) in searched_products_list" @click="emit_add_search_item_invoice(searched_products_li)" :key="'searched_products_li'+index">{{searched_products_li.item_name}} | {{searched_products_li.generic_name}} | {{searched_products_li.item_code}} | {{searched_products_li.single_unit_weight}} {{searched_products_li.product_unit_slug}} | Stock {{searched_products_li.item_stock}}  | Price {{searched_products_li.unit_retail_price}}  | Whole sale {{searched_products_li.pack_cost}}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    import AppInfo from '../../../../../../helpers/config'
    import {get,post} from '../../../../../../helpers/api'
    export default {
        props: ['practice_id'],
        data(){
            return {
                searched_products_list: [],
            }
        },
        methods: {

            search_things(event, things_type){
                let url_search = AppInfo.app_data.server_domain+'/api/search/'+things_type;
                let formData = new FormData();
                formData.append('name',event.target.value);
                formData.append('practice_id',this.practice_id);
                post(url_search, formData)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            switch (things_type) {
                                case "practice_product_item":
                                    this.searched_products_list = res.data.results;
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

        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../../../../../sass/transaction_docs.scss';
</style>


