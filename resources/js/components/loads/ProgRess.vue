<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading"
                 :can-cancel="false"
                 :on-cancel="onCancel"
                 :opacity="0.7"
                 :height="50"
                 :width="50"
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
        props: ['isLoading'],
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
