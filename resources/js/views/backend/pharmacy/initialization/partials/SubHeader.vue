<template>
    <!-- pages navigates here -->
    <section class="content-header mg-top-85">
        <div class="row">
            <div class="col-md-12">
                <div class="pull pull-left sub-app-header width-20-pc">
                    <h5><i class="fa fa-cog"></i> Settings&nbsp;&nbsp| {{sub_title}}</h5>
                </div>
                <div class="pull pull-right sub-app-header width-80-pc text-right">
                    <a v-bind:class="{'active':category}">Category</a> |
                    <a v-bind:class="{'active':brands}">Brands</a> |
                    <a v-bind:class="{'active':brandsector}">Brand sector</a> |
                    <a v-bind:class="{'active':units}">Units</a> |
                    <a v-bind:class="{'active':currency}">Currency</a> |
                    <a v-bind:class="{'active':facility}">Branch/Facility</a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "SubHeader",
        props: ['category','brands','brandsector','units','currency','facility','sub_title']
    }
</script>

<style scoped>

</style>