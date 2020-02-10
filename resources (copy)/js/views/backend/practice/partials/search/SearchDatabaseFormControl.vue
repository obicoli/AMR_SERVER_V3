<template>
    <div class="width-400-px">
        <input type="text" class="report-filters-inputs height-32" :placeholder="placeholder" v-bind:style="{width:field_wdth+'px',borderRadius:rounded_px+'px'}" @keyup="search_database($event)" autofocus="autofocus" />
    </div>
</template>

<script>
    import {get,post} from '../../../../../helpers/api';
    import {SEARCH_ITEM_URL} from '../../../../../router/api_routes';
    export default {
        props: ['practice_id','field_wdth','rounded_px','show_label','search_type','placeholder'],
        data(){
            return {
                //searched_products_list: [],
            }
        },
        methods: {

            search_database(event){
                let formData = new FormData();
                formData.append('name',event.target.value);
                formData.append('practice_id',this.practice_id);
                post(SEARCH_ITEM_URL+'/'+this.search_type, formData)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$emit("searchedData",res.data.results);
                            // switch (this.search_type) {
                            //     case "Category":
                            //         this.$emit("searchedData",res.data.results);
                            //         break;
                            // }
                        }
                    }).catch((err) => {
                });
            },
        }
    }
</script>


