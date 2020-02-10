<template>

    <div>

    </div>
    
</template>

<script type="text/javascript">

    "use strict";
    //var myHostname = window.location.hostname;
    let myHostname = 'localhost';
    //console.log("Hostname: " + myHostname);
    let connection = null;
    let address_obj = {};//This object contains: Source_Facility, Destination_Facility, Staff_Data, & Service_Data
    //Imports
    import {log_this,showTraceable,alertBeep,sendToServer} from "../../../../../rtc/index";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import AWN from "awesome-notifications";
    import {RTC_BASE_URL,RTC_HIS_PORT} from '../../../../../router/api_routes';
    let notifier = new AWN({
        position: 'top-right',
        labels: {
            warning: 'Whoops!',
            success: 'Success',
            confirm: 'Confirmation Required'
        },
        icons: {
            info: 'info-circle'
        }
    });

    function createMsgBody() {
        return {
            type: '',
            //service_type: '',
            text: address_obj
        };
    }

    function alertNoservice(data) {
        let html_string = '<strong>Whoops!</strong> This service is not available, please try again later';
        notifier.warning(html_string);
    }

    export default{

        props: ['address_object'],
        data(){
            return {

            }
        },
        created() {
            //this.connect();
        },
        methods: {
            connect(){

                let serverUrl;
                let scheme = "ws";
                this.myHostname = RTC_BASE_URL;
                // If this is an HTTPS connection, we have to use a secure WebSocket
                // connection too, so add another "s" to the scheme.
                if (document.location.protocol === "https:") {
                    scheme += "s";
                }
                serverUrl = scheme + "://" + this.myHostname + ":"+RTC_HIS_PORT;
                connection = new WebSocket(serverUrl);

                connection.onopen = function (evt) {
                    let msg_body = createMsgBody();
                    msg_body.type = "login";
                    msg_body.text.service_data.service_type = "Requisition";
                    msg_body.text.service_data.service_action = "Listing";
                    //msg_body.text = this.address_obj;
                    sendToServer(connection,msg_body);
                };

                connection.onmessage = function (evt) {

                    let text = "";
                    let msg = JSON.parse(evt.data);
                    log_this("Message received: ");
                    log_this("====================Received Message body===============");
                    console.dir(msg);
                    log_this("====================Received Message body===============");
                    let time = new Date(msg.date);
                    let timeStr = time.toLocaleTimeString();
                    switch(msg.type){
                        case 'success_auth':
                            log_this("====================Success Auth===============");
                            break;
                    }

                };

                connection.onerror = function (evt) {
                    alertNoservice('No service');
                    let err_msg = "This service is not available. Please try again later";
                    let htm_str = '<div class="row">'+
                        '<div class="col-lg-12">'+
                        '<div class="alert alert-danger border-radius-2"><strong>Whoops!</strong> '+err_msg+'</div>'+
                        '</div>'+
                        '</div>';
                    //this.$emit('rtc_con_err',htm_str);
                    //this.emmiters('rtc_con_err',htm_str);
                    //this.emit('rtc_con_err');
                };

            }
        },
        mounted(){
            address_obj = this.address_object;
            //console.info(this.address_object);
            this.connect();
        }
    }


</script>