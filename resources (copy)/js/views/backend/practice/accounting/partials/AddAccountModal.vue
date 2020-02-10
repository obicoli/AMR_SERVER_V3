<template>

    <!-- The overlay -->
    <div id="myNav" class="overlay">

        <div class="overlay-content">
            <a href="javascript:void(0)" class="closebtn float-right" @click="toggleModal"><i class="fa fa-close"></i> </a>
            <div id="colorbox" class="" style="padding-bottom: 50px; padding-right: 50px; display: block; width: 700px; height: 525px; top: 0px; left: 267px; cursor: auto;">
                <div id="cboxWrapper" style="height: 575px; width: 750px;">
                    <div>
                        <div id="cboxTopLeft" style="float: left;">

                        </div>
                        <div id="cboxTopCenter" style="float: left; width: 700px;">

                        </div>
                        <div id="cboxTopRight" style="float: left;">

                        </div>
                    </div>
                    <div style="clear:left">
                        <div id="cboxMiddleLeft" style="float: left; height: 525px;">
                        </div>
                        <div id="cboxContent" style="float: left; width: 700px; height: 525px;">
                            <div id="cboxLoadedContent" style="width: 700px; overflow: hidden; height: 485px;">
                                <div id="feedbackformcontainer" class="v7feedback">
                                    <h3 class="live-header">Account</h3>

                                    <form class="pr_form rightmargin_35 allmargin_20 topmargin_50">

                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="fs-14 cl-888">Account Type:</label>
                                                    <vue-single-select
                                                            name="maybe"
                                                            :required="true"
                                                            you-want-to-select-a-post="ok"
                                                            placeholder=""
                                                            v-model="account_item"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="account_types"
                                                            :get-option-value="setDetails"
                                                            a-post-has-an-id="good for search and display"
                                                            option-key=""
                                                            the-post-has-a-title="make sure to show these"
                                                            option-label="name"
                                                            :class="'live-input attended_field'"
                                                    ></vue-single-select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="fs-14 cl-888">Detail Type:</label>
                                                    <vue-single-select
                                                            name="maybe"
                                                            :required="true"
                                                            you-want-to-select-a-post="ok"
                                                            placeholder=""
                                                            v-model="detail_item"
                                                            out-of-all-these-posts="makes sense"
                                                            :options="account_details_types"
                                                            :get-option-value="setDetail"
                                                            a-post-has-an-id="good for search and display"
                                                            option-key=""
                                                            the-post-has-a-title="make sure to show these"
                                                            option-label="name"
                                                            :class="'live-input'"
                                                    ></vue-single-select>
                                                </div>

                                                <textarea readonly class="live-input attended_field min-height-180 mg-top-20" rows="4"></textarea>

                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label class="fs-14 cl-888">Account name:</label>
                                                    <input type="text" v-model="new_account_form.name" required class="form-control product-entry-input-field">
                                                </div>

                                                <div class="form-group">
                                                    <label class="fs-14 cl-888">Description:</label>
                                                    <textarea v-model="new_account_form.description" required class="live-input" rows="4"></textarea>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="fs-14 cl-888">Balance</label>
                                                            <input type="number" v-model="new_account_form.balance" required class="form-control product-entry-input-field">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="fs-14 cl-888">as of:</label>
                                                            <input type="date" v-model="new_account_form.as_at" required class="form-control product-entry-input-field">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-inline dropdown rounded-0 mx-3 float-right">
                                                    <a class="dropdown-toggle btn btn-inventory float-right primary" id="tools" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Continue</a>
                                                    <div class="dropdown-menu dropdown-menu-right rounded-0 text-center" aria-labelledby="tools">
                                                        <a @click="save_account('close')" class="dropdown-item px-2 fs-13 pointer-cursor">Save and Close</a>
                                                        <a @click="save_account('continue')" class="dropdown-item px-2 fs-13 pointer-cursor">Save and New</a>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>
                            </div>

<!--                            <div id="cboxLoadingOverlay" class="" style="height: 525px; display: none;">-->

<!--                            </div>-->
<!--                            <div id="cboxLoadingGraphic" class="" style="height: 525px; display: none;">-->

<!--                            </div>-->
<!--                            <div id="cboxTitle" class="" style="display: block;">-->

<!--                            </div>-->
<!--                            <div id="cboxCurrent" class="" style="display: none;">-->

<!--                            </div>-->
<!--                            <div id="cboxNext" class="" style="display: none;">-->

<!--                            </div>-->
<!--                            <div id="cboxPrevious" class="" style="display: none;">-->

<!--                            </div>-->
<!--                            <div id="cboxSlideshow" class="" style="display: none;">-->

<!--                            </div>-->

                            <div id="cboxClose" class="">
                                <img class="allpadding_5" src="/images/close.png">
                            </div>
                        </div>
                        <div id="cboxMiddleRight" style="float: left; height: 525px;">
                        </div>
                    </div>
                    <div style="clear:left">
                        <div id="cboxBottomLeft" style="float: left;">

                        </div>
                        <div id="cboxBottomCenter" style="float: left; width: 700px;">

                        </div>
                        <div id="cboxBottomRight" style="float: left;">

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "AddAccountModal",
        props: ['account_types','initial_url','user_mode','form_data'],
        data(){
            return {
                account_item: {},
                detail_item: {},
                account_details_types: [],
                processing: false,
                new_account_form: {
                    name: '',
                    description: '',
                    balance: '',
                    as_at: '',
                    is_sub_account: false,
                    account_type_id: '',
                    account_details_id: '',
                    practice_id: '',
                }
            }
        },
        methods: {
            refresh_account_form(){
                this.new_account_form.name = "";
                this.new_account_form.description = "";
                this.new_account_form.balance = 0;
                this.new_account_form.as_at = "";
                this.new_account_form.is_sub_account = false;
                this.new_account_form.account_details_id = "";
                this.new_account_form.account_type_id = "";
            },
            save_account: function (action_type) {
                this.processing = true;
                post(AppInfo.app_data.server_domain+this.initial_url,this.new_account_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                this.$emit('accountEdited');
                            }else {
                                if (action_type === "continue"){
                                    this.refresh_account_form();
                                    this.$emit('accountAdded')
                                }else {
                                    this.refresh_account_form();
                                    this.toggleModal();
                                }
                            }
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
            toggleModal(){
                this.$emit('windowClosed');
            },
            setDetails(selected_value){
                this.new_account_form.account_type_id = selected_value.id;
                this.account_details_types = selected_value.account_details_type;
                console.info(selected_value)
            },
            setDetail(selected_value){
                this.new_account_form.account_details_id = selected_value.id;
                console.info(selected_value)
            },
        },
        mounted() {

            this.new_account_form.practice_id = this.form_data.practice_id;
            this.new_account_form.name = this.form_data.name;
            this.new_account_form.balance = this.form_data.balance;
            this.new_account_form.description = this.form_data.description;
            this.new_account_form.as_at = this.form_data.as_at;
            this.new_account_form.is_sub_account = this.form_data.is_sub_account;
            this.new_account_form.account_details_id = this.form_data.account_details_id;
            this.new_account_form.account_type_id = this.form_data.account_type_id;

        }
    }
</script>

<style scoped>

    .overlay {
        height: 0;
        width: 100%;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        background-color: #193048;
        /*opacity: 0.65;*/
        opacity: 1;
        overflow-x: hidden;
        transition: 0.5s;
    }

    /* Position the content inside the overlay */
    .overlay-content {
        position: relative;
        top: 25%; /* 25% from the top */
        width: 100%; /* 100% width */
        /*text-align: center; !* Centered text/links *!*/
        margin-top: 30px; /* 30px top margin to avoid conflict with the close button on smaller screens */
    }

    .overlay .closebtn {
        position: absolute;
        /*top: 20px;*/
        /*right: 45px;*/
        /*font-size: 30px;*/
        right: 230px;
        font-size: 20px;
        color: #fff!important;
    }

    #cboxContent {
        background: #fff;
    }

    #cboxContent {
        position: relative;
        overflow: hidden;
    }

    .live-header {
        font-size: 18px;
        font-weight: bold;
        color: #000000;
        padding-left: 18px;
        border: none !important;
        background-image: url(/assets/images/live-chat-horizontal-strip.webp);
        background-repeat: no-repeat;
        background-position: bottom center;
        padding-bottom: 15px;
    }
    .live_right_30per {
        width: 50%;
        float: right;
        padding: 10px 2% 10px 4%;
        color: #4F4F4F;
        font-size: 12px;
        background-image: url(/assets/images/live-chat-vertical-strip.webp);
        background-repeat: no-repeat;
    }
    .topbottompadding_5 {
        line-height: 1.42857;
    }

    .topbottompadding_5 {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .topbottompadding_5 {
        line-height: 1.42857;
    }

    .topborder {
        border-top: 1px solid #dfdfdf;
    }
    .topbottompadding_5 {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .font_12 {
        font-size: 12px;
    }

    .strong, strong {
        font-weight: bold;
    }
    .font_12 {
        font-size: 12px;
    }
    .toppadding_10 {
        padding-top: 10px;
    }

    .pr_left_30per {
        padding-right: 50%;
    }

    .grey {
        color: #4F4F4F !important;
    }

    .pr_form {
        color: #2F2F2F;
    }

    .rightmargin_35 {
        margin-right: 35px;
    }
    .allmargin_20 {
        margin: 20px;
    }

    .live-title {
        color: #777676!important;
    }
    .strong, strong {
        font-weight: bold;
    }
    .font_14 {
        font-size: 14px!important;
    }
    .bottommargin_10 {
        margin-bottom: 3px!important;
    }

    /*-------------------------------------------------------------------------*/
    input[type="text"], select {
        border-radius: 2px;
        outline: none;
    }
    textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
        background-color: #ffffff;
        border: 1px solid #cccccc;
        transition: border linear .2s, box-shadow linear .2s;
    }
    select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
        display: inline-block;
        /*height: 20px;*/
        padding: 4px 6px;
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 20px;
        color: #555555;
        vertical-align: middle;
    }
    .live-input {
        width: 94% !important;
    }
    .lightcyan_bk {
        background-color: #daebf3;
        color: #3088b8;
        font-size: 13px!important;
    }
    .allpadding_20 {
        padding: 20px;
    }
    .topmargin_10 {
        margin-top: 10px !important;
    }
    .pr_boxradius_5 {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }


    #cboxTopLeft {
        width: 25px;
        height: 25px;
        background: url(/assets/images/border1.webp) 0 0 no-repeat;
    }
    #cboxTopCenter {
        height: 25px;
        background: url(/assets/images/border1.webp) 0 -50px repeat-x;
    }
    #cboxTopRight {
        width: 25px;
        height: 25px;
        background: url(/assets/images/border1.webp) -25px 0 no-repeat;
    }
    #cboxMiddleLeft {
        width: 25px;
        background: url(/assets/images/border2.webp) 0 0 repeat-y;
    }
    #cboxMiddleLeft, #cboxBottomLeft {
        clear: left;
    }
    #cboxMiddleRight {
        width: 25px;
        background: url(/assets/images/border2.webp) -25px 0 repeat-y;
    }

    #cboxBottomLeft {
        width: 25px;
        height: 25px;
        background: url(/assets/images/border1.webp) 0 -25px no-repeat;
    }
    #cboxBottomLeft {
        clear: left;
    }
    #cboxBottomCenter {
        height: 25px;
        background: url(/assets/images/border1.webp) 0 -75px repeat-x;
    }
    #cboxBottomRight {
        width: 25px;
        height: 25px;
        background: url(/assets/images/border1.webp) -25px -25px no-repeat;
    }
    /*-------------------------------------------------------------------------*/


    #cboxWrapper {
        position: absolute;
        top: 0;
        /*left: 0;*/
        left: 20%;
        z-index: 9999;
        overflow: hidden;
        margin-bottom: 50px!important;
    }
    .v7feedback .btn-primary,
    .v7feedback .btn-primary:hover,
    .v7feedback .btn-primary:active,
    .v7feedback .btn-primary:focus  {
        background: none;
        background-color: #ffa000;
        height: 28px;
        border: 0;
        text-shadow: none;
        border-radius: 2px;
        font-family: 'Museo Sans 500', 'Helvetica';
        color: #fff;
    }

    .v7feedback input[type="text"], textarea.live-input {
        border-radius: 2px;
        font-family: 'Museo Sans 500', 'Helvetica';

    }
    .v7feedback .font_16 {
        font-size: 14px;
    }

    .v7feedback .lineheight_1_5 {
        line-height: 1.8;
    }

    .v7feedback input[type="text"]:focus, textarea:focus {
        border-color: #97a2a3;
        background: #FFF;
        color: rgba(0,0,0,.8);
        box-shadow: none;
        outline: none;
    }


    #pr_feedbackform input[type='text'],#pr_feedbackform textarea{
        width:90%;
    }
    .lineheight_1_5{
        line-height: 1.5;
    }
    .support_icon_modal{
        padding-left: 50px;
        background-image: url(/assets/images/feedback_sprite.png);
        background-repeat: no-repeat;
        display: inline-block;
        height: 42px;
    }
    .support_icon_modal {
        color: #3088b8;
    }
    .support_icon_modal.support_icon_modal_help{
        line-height: 42px;
    }
    .support_icon_modal.support_icon_modal_chat{
        background-position: 0px -42px;
        line-height: 42px;
    }

    .support_icon_modal.support_icon_modal_phone{
        background-position: 0px -84px;
    }
    .support_icon_modal.support_icon_modal_app{
        background-position: 0px -126px;
    }
    .support_icon_modal{
        color:#3088b8;
    }

    .support_icon_modal.support_icon_modal_chat.disabled{
        background-position: 0px -168px;
        line-height: 42px;
        color:#737373;
    }
    #feedbackformcontainer{
        background: #fff!important;
    }

    .search-input{
        height: 36px!important;
    }
</style>