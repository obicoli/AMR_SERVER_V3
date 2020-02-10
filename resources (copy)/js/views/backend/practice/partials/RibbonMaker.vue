<template>
    <div class="ribbon text-ellipsis popovercontainer ember-view" data-original-title="" title="">
        <div v-if="check_status(STATUS_ARRAY,PROCESS_STATUS.OPEN)" class="ribbon-inner ribbon-open">{{PROCESS_STATUS.OPEN}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.DRAFT)" class="ribbon-inner ribbon-draft">{{PROCESS_STATUS.DRAFT}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.UNPAID)" class="ribbon-inner ribbon-open">{{PROCESS_STATUS.UNPAID}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.CLOSED)" class="ribbon-inner ribbon-success">{{PROCESS_STATUS.CLOSED}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.PAID)" class="ribbon-inner ribbon-success">{{PROCESS_STATUS.PAID}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.PARTIAL_PAID)" class="ribbon-inner ribbon-success">{{PROCESS_STATUS.PARTIAL_PAID}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.UNLOCATED)" class="ribbon-inner ribbon-draft">{{PROCESS_STATUS.UNLOCATED}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.ACCEPTED)" class="ribbon-inner ribbon-success">{{PROCESS_STATUS.ACCEPTED}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.INVOICED)" class="ribbon-inner ribbon-invoiced">{{PROCESS_STATUS.INVOICED}}</div>
        <div v-else-if="check_status(STATUS_ARRAY,PROCESS_STATUS.ACTIVE)" class="ribbon-inner ribbon-invoiced">{{PROCESS_STATUS.ACTIVE}}</div>
        <div v-else class="ribbon-inner ribbon-draft">Pending</div>
    </div>
</template>
<script>
    export default {
        name: "RibbonMaker",
        props: ['STATUS_ARRAY','PROCESS_STATUS'],
        watch: {
            STATUS_ARRAY : function(new_arr,old_arr){
                this.STATUS_ARRAY = new_arr;
            }
        },
        methods: {
            check_status(array_to,pin_to){
                let result = false;
                if( array_to[array_to.length-1].status === pin_to ){
                    result = true;
                }
                return result;
            },
        }
    }
</script>