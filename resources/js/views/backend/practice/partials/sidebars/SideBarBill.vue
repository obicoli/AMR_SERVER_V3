<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu">
        <li class="list-group-item menu-title-li pl-4">
            <a href="#" class="menu-title">Billing</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Add Service</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="">Service List</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Add Package</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Package List</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Add Patient Admission</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Patient Admission List</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Add Advance Payment</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Advance Payment List</a>
        </li>
        <li class="list-group-item items-lists pl-4">
            <a href="#" class="menu-title">Add Bill</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num===10}">
            <a href="/billing" class="menu-title">Bill List</a>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['active_num'],
}
</script>

