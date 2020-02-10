<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom width-100-pc':true,'scrollable-menu':scrollable}">
        <li v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el===1}">
            <router-link to="/banks" class="">Banks</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/written_cheque" class="">Cheques</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/deposit_list" class="">Bank Deposits</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/bank_book" class="">Bank Book</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/payment_collection" class="">Bank Collection</router-link>
        </li>
        <li class="list-group-item items-lists pl-4">
            <router-link to="/banks/add_bank_expense" class="">Bank Expenses</router-link>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['scrollable','width','transparent','active_el'],
    }
</script>

