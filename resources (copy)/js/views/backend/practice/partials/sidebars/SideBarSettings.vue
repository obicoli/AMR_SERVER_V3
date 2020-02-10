<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable,'width-100-pc':width}">

        <li v-if="check_permissions('view.company')" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_link==='branches'}">
            <router-link :to="ADMINSTRATIVE_WEB_ROUTES.FACILITIES" class="">Organization Profile</router-link>
        </li>
        <li v-if="check_permissions('view.branch')" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_link==='branches'}">
            <router-link :to="ADMINSTRATIVE_WEB_ROUTES.FACILITIES" class="">Facilities</router-link>
        </li>
        <li v-if="check_permissions('view.users')" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_link===3}">
            <router-link to="/users/index/all" class="">Users</router-link>
        </li>
        <li v-if="check_permissions('view.role')" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_link===3}">
            <router-link to="/users/roles" class="">User roles</router-link>
        </li>
        <li v-if="check_permissions('view.hcc.code')" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_link===3}">
            <router-link to="/health/common/codes" class="">HCC Codes</router-link>
        </li>
        <li v-if="check_permissions('create.backup')" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_link===3}">
            <router-link to="/take/backup" class="">Take backup</router-link>
        </li>
        <li v-if="check_permissions('create.backup')" v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_link===3}">
            <router-link to="/restore/backup" class="">Restore backup</router-link>
        </li>

        <!-- <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">
            <a href="#" class="">Sub stores</a>
        </li> -->

<!--        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="" class="menu-title">Inventory settings</a>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">-->
<!--            <router-link :to="'/inventory/settings/billing'" class="">Billing</router-link>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent,'active':category}">-->
<!--            <router-link :to="'/inventory/settings/product_category'" class="">Product category</router-link>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent,'active':brands}">-->
<!--            <router-link :to="'/inventory/settings/brands'" class="">Brands</router-link>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent,'active':brand_sector}">-->
<!--            <router-link :to="'/inventory/settings/brand_sector'" class="">Brand sector</router-link>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent,'active':services}">-->
<!--            <router-link :to="'/inventory/settings/services'" class="">Services & Pricing</router-link>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent,'active':units}">-->
<!--            <router-link :to="'/inventory/settings/units'" class="">Units</router-link>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent,'active':currency}">-->
<!--            <router-link :to="'/inventory/settings/currency'" class="">Currency</router-link>-->
<!--        </li>-->


<!--        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="" class="menu-title">Calendar settings</a>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="#" class="">Calendar</a>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="#" class="">Treatment Notification</a>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="#" class="">Data security</a>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="#" class="">Patient Group</a>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="#" class="">Auto ID Generation</a>-->
<!--        </li>-->
<!--        <li v-bind:class="{'list-group-item items-lists pl-4':true,'transparent-li':transparent}">-->
<!--            <a href="#" class="">Printer</a>-->
<!--        </li>-->

    </ul>
</template>

<script>
    import Auth from "../../../../../store/auth";
    import {ADMINSTRATIVE_WEB_ROUTES} from "../../../../../router/web_routes";

    export default {
        name: "SideBarSettings",
        props: [
            'scrollable',
            'width',
            'transparent',
            'currency',
            'units',
            'services',
            'brand_sector',
            'brands',
            'category',
            'billing',
            'active_link',
        ],
        data(){
            return {
                ADMINSTRATIVE_WEB_ROUTES:ADMINSTRATIVE_WEB_ROUTES
            }
        },
        methods: {
            link_user(link_to,active_link){
                console.info('----------------------');
                console.info(this.active_link);
                console.info(active_link);
                console.info(link_to);
                console.info('----------------------');
                this.active_link = active_link;
                Auth.traceActive('set',active_link);
                window.location.href = link_to;
            },
            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },
        mounted() {
            //this.active_link = Auth.traceActive('get',0);
            // console.info('----------------------');
            // console.info(Auth.traceActive('get',0));
            // console.info('----------------------')
        }
    }
</script>

<style scoped>

</style>