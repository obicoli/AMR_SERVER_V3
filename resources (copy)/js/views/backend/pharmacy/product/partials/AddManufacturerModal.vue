<template>

    <form @submit.prevent="add_manufacturer">

        <div class="modal-content">

            <div class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-plus-circle"></i> Add Manufacturer:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div  class="modal-body">

                <div class="bg-white border-top-0 border-bottom-0 border-radius-0">

                    <div class="row form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                            <label class="fs-14 cl-888">Name:</label>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7">
                            <input v-model="form.name" type="text" name="product_name" class="form-control product-entry-input-field">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i>Save</span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i>
                    Close
                </button>
            </div>

        </div>
    </form>
    
</template>

<script>
    import {post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "AddManufacturerModal",
        props: [],
        data(){
            return{
                form:{
                    name: '',
                },
                processing: false,
            }
        },
        methods: {
            add_manufacturer: function () {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/manufacturers',this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.form.name = "";
                        this.$awn.success(res.data.description);
                        this.$emit('manufacturerAdded',res.data.results)
                    }
                    this.processing = false;
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
        },
        mounted(){

        }
    }
</script>

<style scoped>

</style>