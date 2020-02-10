<template>

    <div>
        <router-link :to="'/vendors/'+supplier_data.id+'/overview'" v-bind:class="{'cl-blue-link fs-13':true,'active':active==='overview'}">Overview</router-link>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link :to="'/vendors/'+supplier_data.id+'/comments'" v-bind:class="{'cl-blue-link fs-13':true,'active':active==='comments'}">Comments</router-link>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link :to="'/vendors/'+supplier_data.id+'/purchases'" v-bind:class="{'cl-blue-link fs-13':true,'active':active==='purchase'}">Purchases</router-link>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link :to="'/vendors/'+supplier_data.id+'/relatedlist'" v-bind:class="{'cl-blue-link fs-13':true,'active':active==='relatedlist'}">Related List</router-link>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link :to="'/vendors/'+supplier_data.id+'/mails'" v-bind:class="{'cl-blue-link fs-13':true,'active':active==='mails'}">Mails</router-link>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link :to="'/vendors/'+supplier_data.id+'/statement'" v-bind:class="{'cl-blue-link fs-13':true,'active':active==='statement'}">Statement</router-link>
    </div>
    
</template>

<script>
    export default {
        props: ['supplier','active'],
        data(){
            return {
                supplier_data: {},
            }
        },
        watch: {
            supplier: function(new_supplier,old_supplier){
                this.supplier_data = new_supplier;
            }
        },
        mounted(){
            this.supplier_data = this.supplier;
        }
    }
</script>