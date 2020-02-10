<template>

    <div>
        <vue-timeline-update v-for="(trailed,index) in trails"
            :date="new Date(trailed.date)"
            :title="trailed.notes"
            :description="'by '+trailed.signatory.first_name"
            icon="code" :key="'trailed'+index">
        </vue-timeline-update>
    </div>

    <!-- <vue-timeline-update
        :date="new Date('2017-02-26')"
        title="v2.2.0 - Initial D"
        description="Today I am thrilled to announce the release of Vue.js 2.2.0."
        thumbnail="/images/vuetimeline/initial_d.jpg"
        category="announcement"
        icon="code"
        color="red"
    /> -->

</template>
<script>
    export default {
        name: "AuditTimeline",
        props: ['audit_trails'],
        data(){
            return {
                trails: [],
            }
        },
        watch: {
            audit_trails: function(new_data,old_data){
                this.trails = new_data;
            }
        },
        mounted(){
            if(this.audit_trails){
                this.trails = this.audit_trails;
            }
        }
    }
</script>