<template>

    <!-- The overlay -->
    <div id="myNav" class="overlay">

        <div class="overlay-content">

            <div id="colorbox" class="" style="padding-bottom: 50px; padding-right: 50px; display: block; width: 700px; height: 525px; top: 0px; left: 267px; opacity: 1; cursor: auto;">
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
                                    <h3 class="live-header">Need help with something on Practo?</h3>

                                    <div class="live_right_30per">

                                        <div class="topbottompadding_5">
                                            <p class="font_12 strong toppadding_10 lineheight_1_5"><span class="grey_light">Your Customer ID : </span>186165</p>
                                            <p class="font_12 strong lineheight_1_5"><span class="grey_light">Your Practice ID : </span>186009</p>
                                            <p class="font_12 strong lineheight_1_5"><span class="grey_light" id="planDetail">Plan Detail: v7.0 Ray-Clinic-Management</span></p>

                                            <p class="font_12 lineheight_1_5"><span class="grey_light">Quote these details in any support query.</span></p>
                                        </div>

                                        <div class="topbottompadding_5 topborder">
                                            <a href="" target="_blank" class="pr_blue underline support_icon_modal support_icon_modal_help">
                                                Check AppName Help
                                            </a>
                                        </div>

                                        <div class="topbottompadding_5 topborder">
                                            <a href="" target="_blank" class="pr_blue underline support_icon_modal support_icon_modal_chat disabled">Sorry, Live Chat is offline</a>
                                        </div>

                                        <div class="topbottompadding_5 topborder">
                                            <div class="support_icon_modal support_icon_modal_phone">
                                                <p class="font_16">+91 88805 88999</p>
                                                <p class="grey_light font_11">(9 am to 7 pm, Monday to Sunday)</p>
                                            </div>
                                        </div>

                                        <div class="topbottompadding_5 topborder">
                                            <a rel="noreferrer" href="" target="_blank" class="pr_blue underline support_icon_modal support_icon_modal_app toppadding_10">
                                                Download Support Application for Windows
                                            </a>
                                        </div>

                                    </div>

                                    <div class="pr_left_30per grey">


                                        <form action="" method="post" name="feedback" class="pr_form rightmargin_35 allmargin_20 topmargin_50" id="pr_feedbackform">
                                            <p class="strong font_14 bottommargin_10 live-title">
                                                Report an issue        </p>
                                            <textarea class="live-input" name="ticketcontent" id="pr_feedback_ticketcontent" rows="4"></textarea>

                                            <div class="hidden">
                                                <label class="strong font_16">
                                                    Subject
                                                </label>
                                                <input type="text" id="pr_feedback_ticketsubject" name="ticketsubject">
                                            </div>
                                            <br>

                                            <p class="strong font_14 bottommargin_10 live-title">
                                                Email where we can reach you
                                            </p>
                                            <input class="live-input" type="text" id="pr_feedback_ticketemail" name="ticketemail" value="">
                                            <br>
                                            <p>
                                                <input type="submit" class="btn btn-primary medium" id="pr_feedback_submit" value="Submit Issue">
                                            </p>
                                            <br>
                                            <a href="" class="lightcyan_bk allpadding_20 pr_boxradius_5 topmargin_10 block resolution_center">
                                                Go to "Support Center" to see previous issues
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="cboxLoadingOverlay" class="" style="height: 525px; display: none;">

                            </div>
                            <div id="cboxLoadingGraphic" class="" style="height: 525px; display: none;">

                            </div>
                            <div id="cboxTitle" class="" style="display: block;">

                            </div>
                            <div id="cboxCurrent" class="" style="display: none;">

                            </div>
                            <div id="cboxNext" class="" style="display: none;">

                            </div>
                            <div id="cboxPrevious" class="" style="display: none;">

                            </div>
                            <div id="cboxSlideshow" class="" style="display: none;">

                            </div>
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
    export default {
        name: "NewAccountOverlay",
        methods:{
            closeNav(){

            }
        }
    }
</script>

<style scoped>

    /* The Overlay (background) */
    .overlay {
        /* Height & width depends on how you want to reveal the overlay (see JS below) */
        height: 100%;
        width: 100%;
        position: fixed; /* Stay in place */
        z-index: 10000; /* Sit on top */
        left: 0;
        top: 0;
        background-color: #162435; /* Black fallback color */
        opacity: 0.9;
        /*background-color: rgba(0,0,0, 0.9); !* Black w/opacity *!*/
        overflow-x: hidden; /* Disable horizontal scroll */
        transition: 0.5s; /* 0.5 second transition effect to slide in or slide down the overlay (height or width, depending on reveal) */
    }

    /* Position the content inside the overlay */
    .overlay-content {
        position: relative;
        top: 25%; /* 25% from the top */
        width: 100%; /* 100% width */
        /*text-align: center; !* Centered text/links *!*/
        margin-top: 30px; /* 30px top margin to avoid conflict with the close button on smaller screens */
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
        width: 30%;
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
        padding-right: 34%;
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
        margin-bottom: 10px!important;
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
        left: 25%;
        z-index: 9999;
        overflow: hidden;
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

    #cboxOverlay.v7modal {
        background: #162435;
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
</style>