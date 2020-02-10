<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom width-100-pc':true,'scrollable-menu':scrollable}">

        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_el==='map'}">
            <router-link :to="'/item/'+product_id+'/view'" class="">Stock Map View</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/deposit_list" class="">Product Detail</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/bank_book" class="">Requests</router-link>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_el==='location'}">
            <router-link :to="'/item/'+product_id+'/locations_view'" class="">Facility Reporting</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/add_bank_expense" class="">Stock Assignment</router-link>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['scrollable','width','transparent','active_el','product_id'],
    }
</script>