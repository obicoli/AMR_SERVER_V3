<template>
    <!-- <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom width-100-pc':true,'scrollable-menu':scrollable}">
        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'min_ht_67 transparent-li':transparent}">
            <a href="" class="">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent}">
            <a class="">User summary</a>
        </li>
    </ul> -->
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom width-100-pc':true,'scrollable-menu':scrollable}">
        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'min_ht_67 transparent-li':transparent}">
            <a href="" class="menu-title float-left">{{title}}</a>
        </li>
        <!-- <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el==='summary'}">
            <a href="/system_users_summary" class="">Summary</a>
        </li> -->
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el==='summary'}">
            <a href="/system_users_summary" class="">Summary</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el==='activities'}">
            <a href="/users_activities" class="">Activities</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el==='users'}">
            <a href="/users/index/all" class="">Users</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el==='roles'}">
            <a href="/users/roles" class="">Roles</a>
        </li>
    </ul>
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import Loading from "../../../../../components/loads/ProgRess";

    export default {
        name: "SideBarHr",
        props: ['scrollable','width','transparent','active_num','hr_role','title','active_el'],
        components: {
            Loading
        },
        data(){
            return {
                hr_roles: [],
            }
        },
        watch: {
            hr_role: function(newVal, oldVal){
                this.hr_roles = newVal;
            }
        },
        methods: {
            format_slug(sluger){
                return sluger.replace(".","_");
            },
        },
        mounted() {
            this.hr_roles = this.hr_role;
            //console.info(this.active_num);
        }
    }
</script>

<style scoped>

</style>