<template>

    <div class="modal right fade" id="switchAccountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <form  class="modal-content">

                <div class="modal-body">

                    <div class="row justify-content-center">

                        <div class="col-lg-4 col-md-4">

                            <div class="width-100-pc bg-white min-height-427 border-radius-2 mg-top-30">

                            </div>

                        </div>

                    </div>

                </div>

            </form>
        </div>
    </div>

</template>

<script>
    export default {
        name: "SwitchAccountModal",
        props:['accounts'],
        mounted() {
            console.info(this.accounts);
        }
    }
</script>

<style scoped>

    .modal-open .modal {
        z-index: 9999;
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 100%!important;
        height: 100%;
        max-width: 100%!important;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
        top: 0!important;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog{
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog{
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    /*.modal-header {*/
    /*    border-bottom-color: #EEEEEE;*/
    /*    background-color: #FAFAFA;*/
    /*}*/

    .modal.left .modal-header,
    .modal.right .modal-header {
        height: 40px;
        line-height: 50px;
        font-weight: 600;
        color: #fff;
        background-color: #131e3c!important;
    }

    .modal-body{
        background-color: #131e3c!important;
        /*height:500px;*/
        /*overflow-y: auto;*/
        height:100%;
    }
    .modal-footer{
        background-color: #131e3c!important;
    }

</style>