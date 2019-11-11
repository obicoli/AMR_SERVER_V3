<template>

    <!-- pages navigates here -->
    <section class="content-header mg-top-85">

        <div class="row">
            <div class="col-md-12">
                <div class="pull pull-left sub-app-header width-20-pc">
                    <h5><i class="fa fa-id-card-o"></i> Accounts&nbsp;&nbsp| {{sub_title}}</h5>
                </div>
                <div class="pull pull-right sub-app-header width-80-pc text-right">
                    <a href="/accounts" v-bind:class="{'active':accounts}">Accounts</a> |
                    <a href="/payee" v-bind:class="{'active':payee}">Account Holders :</a> |
                    <a data-toggle="modal" data-target="#open_account_head_modal" v-bind:class="{'active':false}">Opening Account Heads</a> |
                    <a v-bind:class="{'active':false}">Credit Voucher</a> |
                    <a v-bind:class="{'active':false}">Debit Voucher</a> |
                    <a v-bind:class="{'active':false}">Journal Voucher</a> |
                    <a data-toggle="modal" data-target="#open_balance_modal" v-bind:class="{'active':false}">Opening Balances</a>
                </div>
            </div>
        </div>

        <!-- (Ajax Modal)-->
        <div class="modal fade" id="open_account_head_modal">
            <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                <open-account-head-modal></open-account-head-modal>
            </div>
        </div> <!-- Bootstrap model  ends-->
        <!-- /.content -->

        <!-- (Ajax Modal)-->
        <div class="modal fade" id="open_balance_modal">
            <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                <opening-balance-modal></opening-balance-modal>
            </div>
        </div> <!-- Bootstrap model  ends-->
        <!-- /.content -->

    </section>
    
</template>

<script>
    import OpenAccountHeadModal from './OpenAccountHeadModal';
    import OpeningBalanceModal from './OpeningBalanceModal'
    export default {
        name: "SubHeader",
        props: ['accounts','brands','brandsector','payee','sub_title'],
        components: {OpenAccountHeadModal,OpeningBalanceModal}
    }
</script>

<style scoped>

</style>