<template>
    <ul class="list-group flex-column d-inline-block submenu submenu-custom scrollable-menu width-100-pc">
        <li class="list-group-item menu-title-li pl-4">
            <a href="" class="menu-title">{{title}}</a>
        </li>
        <li v-bind:class="{'list-group-item items-lists pl-4':true,'active':active_num==='requisitions'}">
            <router-link to="/requistions" class="">All</router-link>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['active_num','title'],
}
</script>