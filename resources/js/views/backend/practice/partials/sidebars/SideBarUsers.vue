<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom width-100-pc':true,'scrollable-menu':scrollable}">
        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'min_ht_67 transparent-li':transparent}">
        </li>
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_num==='all'}">
            <a href="/users/index/all" class="">All</a>
        </li>
        <li v-for="(hr_role, index) in hr_roles" :key="'hr_role'+index" v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_num===hr_role.slug}">
            <a :href="'/users/index/'+format_slug(hr_role.slug)" class="">{{hr_role.name}}</a>
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
        props: ['scrollable','width','transparent','active_num','hr_role'],
        components: {
            Loading
        },
        data(){
            return {
                hr_roles: [],
                active_el:0
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