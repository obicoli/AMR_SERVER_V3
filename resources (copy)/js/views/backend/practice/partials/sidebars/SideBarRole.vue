<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom width-100-pc':true,'scrollable-menu':scrollable}">
        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'min_ht_67 transparent-li':transparent}">
            <a href="" class="menu-title float-left">{{default_title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el===hr_role.id}">
            <a href="/system_users_summary" class="">Summary</a>
        </li>
        <li v-for="(hr_role, index) in hr_roles" :key="'hr_role'+index" v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el===hr_role.id}">
            <a @click="redirect_user_to('/administrative/manage/roles',hr_role.id,hr_role)" class="">{{hr_role.name}}</a>
        </li>
    </ul>
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import Loading from "../../../../../components/loads/ProgRess";
    // import RoleModel from '../../../pharmacy/hr_depart/partials/RoleModel'

    export default {
        name: "SideBarHr",
        props: ['scrollable','width','transparent','active_num','hr_role'],
        components: {
            Loading
        },
        data(){
            return {
                hr_roles: [],
                active_el:0,
                default_title: 'Roles'
            }
        },
        watch: {
            hr_role: function(newVal, oldVal){
                this.hr_roles = newVal;
            }
        },
        methods: {
            format_slug(sluger){
                return sluger.replace(".","_")
            },
            redirect_user_to(url_to,current_active,role_selected){
                this.active_el = current_active;
                this.default_title = role_selected.name;
                this.$emit('selectedRole',role_selected)
            }
        },
        mounted() {
            this.hr_roles = this.hr_role;
            //console.info(this.hr_roles);
        }
    }
</script>

<style scoped>

</style>