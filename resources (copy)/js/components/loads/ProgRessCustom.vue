<template>
    <div class="vld-parent">
        <loading :active.sync="data.is_active"
                 :can-cancel="false"
                 :on-cancel="onCancel"
                 :opacity="data.opacity"
                 :height="data.height"
                 :width="data.width"
                 :loader="'spinner'"
                 :backgroundColor="colorB"
                 :is-full-page="fullPage"></loading>
    </div>
</template>

<script>
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
        props: ['data'],
        data() {
            return {
                fullPage: true,
                colorB: '#444'
            }
        },
        components: {
            Loading
        },
        methods: {
            onCancel() {
                alert('Wait...');
            }
        }
    }
</script>
