<template>
    <div class="modal-content">

        <div  class="modal-header">
            <h4 class="cl-grey"><i class="fa fa-edit"></i> View User:</h4>
            <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
        </div>

        <div  class="modal-body">

            <div class="row">

                <div class="col-xs-12 col-md-6 col-lg-6 col-sm-12">
                    <div class="item-info half ng-scope">
                        <div class="info-block mg-bottom-5">
                            <div class="name txt-uppercase">First name:</div>
                            <div class="value">{{user_data.first_name}}</div>
                        </div>
                        <div class="info-block mg-bottom-5">
                            <div class="name txt-uppercase">Other name:</div>
                            <div class="value ng-binding">{{user_data.other_name}}</div>
                        </div>
                        <div class="info-block mg-bottom-5">
                            <div class="name txt-uppercase">SL.NO:</div>
                            <div class="value ng-binding"></div>
                        </div>
                        <div class="info-block mg-bottom-5">
                            <div class="name txt-uppercase">Mobile:</div>
                            <div class="value ng-binding">
                                {{user_data.mobile}}
                            </div>
                        </div>
                        <div class="info-block mg-bottom-5">
                            <div class="name txt-uppercase">Email:</div>
                            <div class="value ng-binding">
                                {{user_data.email}}
                            </div>
                        </div>
                        <div class="info-block mg-bottom-5">
                            <div class="name txt-uppercase">Address:</div>
                            <div class="value ng-binding">{{user_data.address}}</div>
                        </div>
                        <div class="info-block mg-bottom-5">
                            <div class="name txt-uppercase">Gender:</div>
                            <div class="value tax-value ng-binding">{{user_data.gender}}</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-inventory">
                            <i class="fa fa-check" aria-hidden="true"></i> Assign Permissions
                        </button>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6 col-lg-6 col-sm-12">

                    <div class="user-profile text-center">
                        <img :src="user_data.avatar"><br>
                        <span>{{user_data.first_name}} {{user_data.other_name}}</span><br>
                        <span class="role">({{user_data.role}})</span><br>
                        <label v-if="user_data.work_place"><span class="txt-uppercase cl-grey fs-14">Branch:</span> <span>{{user_data.work_place.branch_name}}</span></label><br>
                        <label v-if="user_data.work_place"><span class="txt-uppercase cl-grey fs-14">Department:</span> <span>{{user_data.work_place.department_name}}</span></label>
                    </div>

                </div>

            </div>

        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-inventory">
                <i class="fa fa-close" aria-hidden="true"></i> Close
            </button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "ViewUserModal",
        props: ['user_data']
    }
</script>

<style scoped>

</style>