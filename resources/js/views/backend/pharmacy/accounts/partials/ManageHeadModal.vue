<template>

    <form @submit.prevent="assign_place">

        <div class="modal-content">

            <div  class="modal-header">
                <h4 v-if="user_mode==='Create'" class="cl-grey"><i class="fa fa-plus-circle"></i> Create Head:</h4>
                <h4 v-if="user_mode==='Edit'" class="cl-grey"><i class="fa fa-edit"></i> Edit Head:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div  class="modal-body">

                <div class="row">

                    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Name:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" required class="form-control product-entry-input-field">
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Branch:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" required list="branch_list" @change="set_condition('branch')" class="form-control product-entry-input-field" id="selected_branch">
                                <datalist id="branch_list">
                                    <option v-for="practice_branch in practice_branches" :data-value="practice_branch.id" :value="practice_branch.name+' ('+practice_branch.category+')'"></option>
                                </datalist>
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Department:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" required list="department_list"
                                       @change="set_condition('department')" class="form-control product-entry-input-field" id="selected_department">
                                <datalist id="department_list">
                                    <option v-for="practice_department in practice_departments" :data-value="practice_department.id" :value="practice_department.name"></option>
                                </datalist>
                            </div>
                        </div>

                    </div>


                </div>

            </div>

            <div class="modal-footer">
                <button v-if="user_mode==='Create'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>
                <button v-if="user_mode==='Edit'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save Changes</span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
            </div>

        </div>

    </form>
    
</template>

<script>
    export default {
        name: "ManageHeadModal",
        props: ['user_mode']
    }
</script>

<style scoped>

</style>