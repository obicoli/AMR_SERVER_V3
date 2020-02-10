<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom width-100-pc':true,'scrollable-menu':scrollable}">
        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'min_ht_67 transparent-li':transparent}">
            <a href="" class="menu-title float-left">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el==='suppliers'}">
            <a href="/suppliers" class="">Supplier List</a>
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
        props: ['scrollable','width','transparent','hr_role','title','active_el'],
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
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },
        mounted() {
            this.hr_roles = this.hr_role;
            //console.info(this.active_num);
        }
    }
</script>

<style scoped>

</style>