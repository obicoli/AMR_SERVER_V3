<template>
    <div data-component="sidebar">
        <div class="sidebar">
            <ul class="list-group flex-column d-inline-block first-menu scrollable-menu padding-bottom-100">
                <li v-if="has_permission(true,'Calendar')" class="list-group-item pl-3 py-2">
                    <router-link :to="SCM_WORKSPACE"><i class="fa fa-truck" aria-hidden="true"><span class="ml-2 align-middle">Supply Chain</span></i></router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    //
    import Auth from '../../../../../store/auth';
    import {INVENTORY_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "ModuledSideBar",
        data(){
            return{
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES,
                SCM_WORKSPACE: INVENTORY_WEB_ROUTES.SCM_WORKSPACE,
            }
        },
        methods: {
            has_permission(outer_level, inner_level){
                return Auth.setMenu(outer_level,inner_level);
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },
        mounted(){
        }
    }
</script>

<style scoped>
    [data-component='sidebar'] .first-menu {
        background-color: #c00e2d!important;
    }
    [data-component='sidebar'] .first-menu .list-group-item:hover {
        background-color: #f0f0f5;
    }
    [data-component='sidebar'] .first-menu .list-group-item:hover a {
        color: #444!important;
    }
</style>
