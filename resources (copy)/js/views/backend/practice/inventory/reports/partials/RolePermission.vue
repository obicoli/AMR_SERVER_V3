<template>

    <div class="width-100-pc float-left">

        <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
            <h3 class="fs-14 fw-600 width-30-pc float-left">Roles</h3>
            <div class="float-right">
                <a data-toggle="modal" :data-target="'#add_role_1'" class="cl-white pointer-cursor fw-600 fs-13 txt-uppercase">Add Role</a> &nbsp;&nbsp;
                <a data-toggle="collapse" :data-target="'#roles_list_div'" class="cl-white pointer-cursor fs-14">+</a>
            </div>
        </div>
        <div class="width-100-pc float-left collapse in padding-20 bg-f7" id="roles_list_div">
            <table class="table table-vendor-list table-hover mg-top-10">
                <thead>
                    <tr>
                        <th style="width:2%;">
                            <input type="checkbox" class="pointer-cursor">
                        </th>
                        <th style="width:20%;">Name</th>
                        <th style="width:35%;">Description</th>
                        <th style="width:15%;">Created At</th>
                        <th style="width:15%;">Updated At</th>
                        <th style="width:13%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(role,index) in roles" :key="'roles_'+index">
                        <td>
                            <input class="pointer-cursor" type="checkbox" :value="role.id">
                        </td>
                        <td>{{role.name}}</td>
                        <td>{{role.description}}</td>
                        <td>{{role.created_at}}</td>
                        <td>{{role.updated_at}}</td>
                        <td>
                            <a data-toggle="modal" :data-target="'#edit_role_'+index" class="showOnHover pointer-cursor" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;
                            <a data-toggle="modal" :data-target="'#delete_role_'+index" class="showOnHover cl-amref pointer-cursor" title="Delete"><i class="fa fa-trash-o"></i></a>
                        </td>
                        <delete-modal v-on:deletionSuccessful="remove_item" :title="'Delete Role'" :modal_id="'delete_role_'+index" :item_url="role_api+'/'+role.id" :confirm_message="'Are you sure?'" :modal_title="'Delete Role'"></delete-modal>
                        <role-modal :modal_id="'edit_role_'+index" :role_api="role_api+'/'+role.id" :user_mode="'Edit'" :permissions="permissions" :form_data="role" :title="'Role Editor'"></role-modal>
                    </tr>
                    <tr v-if="!roles.length">
                        <td colspan="6" class="text-center cl-amref">No data to display!</td>
                    </tr>
                </tbody>
            </table>
            
        </div>

        <role-modal :modal_id="'add_role_1'" v-on:roleAdded="loadR" :role_api="role_api" :user_mode="'Create'" :permissions="permissions" :title="'Role Editor'"></role-modal>

        <div class="width-100-pc float-left mg-top-30 mg-bottom-10 fw-600 stripped-bar">
            <h3 class="fs-14 fw-600 width-30-pc float-left">Users</h3>
            <div class="float-right">
                <a data-toggle="modal" :data-target="'#add_user_1'" class="cl-white pointer-cursor fw-600 fs-13 txt-uppercase">Add User</a> &nbsp;&nbsp;
                <a data-toggle="collapse" :data-target="'#users_list_div'" class="cl-white pointer-cursor fs-14">+</a>
            </div>
        </div>
        <div class="width-100-pc float-left collapse out" id="users_list_div">
            <table class="table table-vendor-list table-hover mg-top-10">
                <thead>
                    <tr>
                        <th style="width:2%;">
                            <input type="checkbox" class="pointer-cursor">
                        </th>
                        <th style="width:20%;">Full Name</th>
                        <th style="width:16%;">Email</th>
                        <th style="width:10%;">Mobile</th>
                        <th style="width:15%;">Role</th>
                        <th style="width:10%;">Created At</th>
                        <th style="width:10%;">Updated At</th>
                        <th style="width:10%;">Status</th>
                        <th style="width:7%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, user_index) in users_data" :key="'users'+user_index">
                        <td>
                            <input class="pointer-cursor" type="checkbox" :value="user.id">
                        </td>
                        <td>{{user.first_name+' '+user.other_name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.mobile}}</td>
                        <td>{{user.role.name}}</td>
                        <td>{{user.created_at}}</td>
                        <td>{{user.updated_at}}</td>
                        <td>{{user.status}}</td>
                        <td>
                            <a data-toggle="modal" :data-target="'#edit_user_'+user_index" class="showOnHover pointer-cursor" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;&nbsp;
                            <a data-toggle="modal" :data-target="'#delete_user_'+user_index" class="showOnHover cl-amref pointer-cursor" title="Delete"><i class="fa fa-trash-o"></i></a>
                        </td>
                        <delete-modal v-on:deletionSuccessful="remove_user" :title="'Delete User'" :modal_id="'delete_user_'+user_index" :item_url="user_api+'/'+user.id" :confirm_message="'Are you sure?'" :modal_title="'Delete User'"></delete-modal>
                        <user-modal :modal_id="'edit_user_'+user_index" :form_data="user" :user_mode="'Edit'" :user_api="user_api" v-on:userAdded="remove_user" :hr_roles="company_roles" :companies="companies" :departments="departments" :warehouses="warehouses" :subwarehouses="subwarehouses" :title="'Edit User'"></user-modal>
                    </tr>
                    <tr v-if="users.length===0">
                        <td colspan="9" class="text-center cl-amref">No data to display!</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <user-modal :modal_id="'add_user_1'" :user_api="user_api" v-on:userAdded="remove_user" :hr_roles="company_roles" :companies="companies" :departments="departments" :warehouses="warehouses" :subwarehouses="subwarehouses" :title="'New User'"></user-modal>
    </div>

</template>

<script>
    import DeleteModal from "../../../partials/modals/DeleteModal";
    import RoleModal from "../../../partials/modals/users/RoleModal";
    import UserModal from "../../../partials/modals/users/UserModal";
    import {removeElement} from "../../../../../../helpers/functionmixin";
    export default {
        name: "RolePermission",
        props: ['company_roles','companies','departments','role_api','user_api','departments','warehouses','permissions','subwarehouses','users'],
        components: {DeleteModal,RoleModal,UserModal},
        data(){
            return {
                roles: [],
                users_data: [],
            }
        },
        watch: {
            company_roles: function(new_data,old_data){
                this.roles = new_data
            },
            users: function(new_user,old_user){
                this.users_data = new_user;
            }
        },
        methods: {
            remove_item(item){
                this.$emit("rolesChanged");
            },
            remove_user(){
                this.$emit("usersChanged");
            },
            loadR(){
                this.$emit("rolesChanged");
            },
            // sendAlert(){
            //     this.$emit("userAdded");
            // }
        },
        mounted(){
            if(this.company_roles){
                this.roles = this.company_roles;
                this.users_data = this.users;
            }
        }
    }
</script>