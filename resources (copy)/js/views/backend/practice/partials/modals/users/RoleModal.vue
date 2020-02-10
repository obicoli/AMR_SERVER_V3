<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="saveRole" class="modal-content">

                <div class="modal-header bg-f4">
                    <h4 class="width-100-pc text-left"> {{title}}</h4>
                </div>

                <div class="modal-body bg-f4">
                    <div class="row mg-right-10 mg-left-10">

                        <div class="col-lg-12 col-md-12 mg-bottom-10">

                            <div class="width-30-pc float-left">
                                <div class="row fullName mg-bottom-5 mg-left-30">
                                    <div class="inlineBlock width-20-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Name:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="inlineBlock width-80-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <input v-model="role_form.name" v-bind:class="{'width-100-pc report-filters-inputs':true,'ctm-attended-field':role_form.name}" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row fullName mg-bottom-5 mg-left-30">
                                    <div class="inlineBlock width-20-pc text-right">
                                        <label class="company-label text-right fs-12 width-100-pc">Description:&nbsp;&nbsp;</label>
                                    </div>
                                    <div class="inlineBlock width-80-pc">
                                        <div class="dijitInline firstName dijitTextBox width-100-pc">
                                            <textarea v-model="role_form.description" placeholder="" v-bind:class="{'height-32 width-100-pc min-height-60':true,'ctm-attended-field':role_form.description}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 mg-top-20">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a v-for="(perma,index) in permissions" @click="toggleTab(index)" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===index}" :id="'nav-permission-tab-'+index" data-toggle="tab" :href="'#nav-permission-'+index" role="tab" :aria-controls="'nav-permission-'+index" aria-selected="true" :key="'permissions_tab'+index">{{perma.category}}</a>
                                </div>
                            </nav>
                            <div class="tab-content tab-content-role" id="nav-tabContent">

                                <div v-for="(permission,tab_index) in permissions" v-bind:class="{'tab-pane fade':true,'show active':curr_tab===tab_index}" :id="'nav-permission-'+tab_index" role="tabpanel" :aria-labelledby="'nav-permission-tab-'+tab_index" :key="'tab_index_'+tab_index">
                                    
                                    <div class="card-body padding-left-0 padding-right-0">
                                        <h5 class="mb-0">
                                            <label class="check-container small element-inlined fs-14 cl-888">
                                                <input type="checkbox" @click="selectAll($event,permission.data)" :value="'select_all_checkbox_'+tab_index" :name="'select_all_checkbox_name_'+tab_index">
                                                <span class="checkmark"></span>
                                            </label>
                                            <ul class="reports-lista">
                                                <li class="title txt-uppercase fs-12 fw-600 cl-amref">{{tab_index+1}}. {{permission.category}}</li>
                                            </ul>
                                        </h5>
                                        <div class="row">
                                            <section class=" padding-top-10 padding-left-15 padding-bottom-10">

                                                <div class="row">
                                                    <div v-for="(sub_pammissio, sub_index) in permission.data" :key="'sub_pammissio_'+sub_index" class="col-md-2 col-lg-2 mg-bottom-15">
                                                        <h4 class="role-label">{{sub_pammissio.sub_category}}</h4>
                                                        <label v-for="(sub_sub_pammissio, sub_sub_index) in sub_pammissio.sub_category_data" :key="'sub_sub_pammissio'+sub_sub_index" class="check-container small element-inlined fs-12 role-label-fw-normal min-width-100 mg-right-10">{{sub_sub_pammissio.name}}
                                                            <input type="checkbox" :value="sub_sub_pammissio.id" v-model="role_form.permissions">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-f4">
                    <button :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                        <span v-else>Save</span>
                    </button>
                    <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process">
                        Close
                    </button>
                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {get,post} from '../../../../../../helpers/api';
    //import AppInfo from '../../../../../../helpers/config';
    import {createHtmlErrorString,removeElement,isInArray} from '../../../../../../helpers/functionmixin';
    import {SUPPLIERS_URL} from '../../../../../../router/api_routes';
    import {ADDRESS_TYPES} from '../../../../../../helpers/process_status';
    export default {
        name: "RoleModal",
        props:['form_data','role_api','user_mode','modal_id','title','permissions'],
        data(){
            return {
                processing: false,
                curr_tab: 0,
                role_form: {
                    name: null,
                    description: null,
                    permissions: [],
                },
            }
        },
        methods: {

            toggleTab(index_){
                this.curr_tab = index_;
            },
            saveRole() {
                this.processing = true;
                post(this.role_api, this.role_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.$emit("add-edit-role-event");
                        this.$awn.success(res.data.description);
                        this.processing = false;
                        $('#'+this.modal_id).hide();
                    }
                }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },

            selectAll(event,select_role){
                if(event.target.checked){
                    for( let m=0; m < select_role.length; m++ ){
                        for( let n=0; n < select_role[m].sub_category_data.length; n++ ){
                            if( !isInArray(select_role[m].sub_category_data[n].id, this.role_form.permissions) ){
                                this.role_form.permissions.push(select_role[m].sub_category_data[n].id);
                            }
                        }
                    }
                }else{
                    for( let m=0; m < select_role.length; m++ ){
                        for( let n=0; n < select_role[m].sub_category_data.length; n++ ){
                            removeElement(this.role_form.permissions,select_role[m].sub_category_data[n].id);
                        }
                    }
                }
            },

            initialize_permissions(permissions){
                this.role_form.permissions = [];
                for (let index = 0; index < permissions.length; index++) {
                    const element = permissions[index];
                    this.role_form.permissions.push(element.id);
                }
            },

        },
        mounted() {
            if(this.user_mode === "Edit"){
                this.role_form = this.form_data;
                this.initialize_permissions(this.form_data.permissions);
            }
        },
    }
</script>

<style scoped>
    .modal {
        background: rgba(0, 0, 0, 0.62);
        z-index: 9999;
    }
    .modal-content{
        top: 50px!important;
    }
    .modal-lg {
        max-width: 1100px!important;
        min-width: 1100px!important;
    }
    .modal-header{
        /* border-bottom: 1px solid #fff!important; */
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
        font-size: 14px;
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
</style>