<template>

    <div class="modal-content">

        <form @submit.prevent="savePermissions">

            <div  class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-plus"></i> Assign Privileges:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div  class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <div v-for="permiss in permissions" class="item-info half mg-top-1 width-100-pc mg-bottom-10">
                            <h4 class="purchase-heading cl-444 fs-15 fw-600 padding-0"> {{permiss.category}}</h4>
                            <label v-for="datas in permiss.data" class="check-container width-20-pc fs-13 cl-grey element-inlined">{{datas.name}}
                                <input v-if="datas.has_perm === true" @click="checkIf($event)" :value="datas.id" type="checkbox" checked="checked">
                                <input v-if="datas.has_perm === false" @click="checkIf($event)" :value="datas.id" type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>
            </div>

        </form>

    </div>
    
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "AssignPrivilegeModal",
        props: ['user_data'],
        data(){
            return {
                new_user_data: {},
                processing: false,
                permission_form: {
                    permissions: [],
                    practice_user_id: this.user_data.id,
                },
                permissions: []
            }
        },
        methods: {

            loadUser(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/users/'+this.user_data.id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.new_user_data = res.data.results;
                            this.permissions = res.data.results.permissions;
                            this.processing = false;
                            this.permission_form.practice_user_id = this.user_data.id;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },

            savePermissions(){
                this.processing = true;
                this.permission_form.practice_user_id = this.user_data.id;
                post(AppInfo.app_data.server_domain+'/api/practices/users/permissions',this.permission_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.processing = false;
                        this.$awn.success(res.data.description);
                        this.permission_form.permissions = [];
                        this.permission_form.practice_user_id = '';
                        this.loadUser();
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
                    this.processing = false;
                });
            },

            checkIf(event){
                if (event.target.checked){
                    this.permission_form.permissions.push(event.target.value)
                }else {
                    let index = this.permission_form.permissions.indexOf(event.target.value);
                    if (index > -1) {
                        this.permission_form.permissions.splice(index, 1);
                    }
                }
            }

        },
        mounted(){
            this.loadUser();
        }
    }
</script>

<style scoped>
    /* The container */
    .check-container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .check-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .check-container:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .check-container input:checked ~ .checkmark {
        background-color: #28328c;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .check-container input:checked ~ .checkmark:after {
        display: block;
    }

    .check-container .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>