<template>
    <form @submit.prevent="add_roles">

        <div class="modal-content">
            <div class="modal-header">
                <h4 v-if="user_mode==='Create'" class="cl-grey"><i class="fa fa-plus-circle"></i> Add New HR Type:</h4>
                <h4 v-if="user_mode==='Edit'" class="cl-grey"><i class="fa fa-edit"></i> Edit HR Type:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>

            <div  class="modal-body">

                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Name:</label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="text" required v-model="form.name" @keydown="search_roles($event)" list="search_list" placeholder="e.g Procurement Manager" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.name}">
                        <datalist id="search_list">
                            <option v-for="search_list in searched_list" :value="search_list.name">{{search_list.name}}</option>
                        </datalist>
                    </div>
                </div>

                <div class="row form-group mg-bottom-15">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Description:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <textarea v-model="form.description" placeholder="" style="max-height: 70px!important;" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.description}" rows="5"></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Status:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <select v-model="form.status" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':form.status}" data-live-search="true" style="width: 100%;">
                            <option value="" disabled selected>-select-</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
                <button v-if="user_mode==='Create'" type="button" class="btn btn-inventory">
                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                </button>
                <button v-if="user_mode==='Edit'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i>Save Changes</span>
                </button>
                <button v-if="user_mode==='Create'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>

            </div>

        </div>
    </form>
</template>

<script>

    import {post} from "../../../../../helpers/api";
    import Loading from "../../../../../components/loads/ProgRess";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "RoleModel",
        props: ['branch_id','user_mode','form_data'],
        components: {Loading},
        data(){
            return {
                processing: false,
                form: {
                    name: this.form_data.name,
                    description: this.form_data.description,
                    branch_id: this.branch_id,
                    status: this.form_data.status,
                },
                searched_list: [],
            }
        },
        methods: {
            search_roles(event){
                post(AppInfo.app_data.server_domain+'/api/search/HR',this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.searched_list = res.data.results;
                            this.processing = false;
                        }
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
                });
            },
            add_roles(event){
                this.processing = false;
                post(AppInfo.app_data.server_domain+'/api/practices/roles',this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.searched_list = res.data.results;
                            this.processing = false;
                            this.form.description = "";
                            this.form.name = "";
                            this.form.status = "";
                            this.$awn.success(res.data.description);
                            this.$emit('roleAdded')
                        }
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
                });
            },
        }

    }
</script>

<style scoped>

</style>