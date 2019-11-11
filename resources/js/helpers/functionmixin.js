import {get} from "./api";

import moment from 'vue-moment'

export function getYear() {
    return moment(String(value)).format('MM/DD/YYYY hh:mm')
}

export function createHtmlErrorString(errors = []) {

    let html_errors = '<ul>';

    for (let ki = 0; ki < errors.length; ki++ ) {

        html_errors += '<li>'+errors[ki]+'</li>';

    }

    html_errors += '</ul>';

    return html_errors;

}

export function customizeLoader(action) {
    if (action === 'show') {
        return {
            is_active: true,
            opacity: 0,
            height: 3,
            width: 3,
        }
    }else {
        return {
            is_active: false,
            opacity: 0,
            height: 3,
            width: 3,
        }
    }

}

export function sleep(milliseconds) {
    let start = new Date().getTime();
    for (let i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}

export function getUuidService() {
    return localStorage.getItem('service_id');
}

export function storeUuidService(payload) {
    localStorage.setItem('service_id',payload);
}

export function deleteUuidService() {
    localStorage.removeItem('service_id');
}

export function navLinkActiveness(target = null) {

    if (target) {

        return {
            details: false,
            staff: false,
            schedules: false,
            notification: false,
            pricing: false,
            security: false,
            clinical: false,
            drugcatalogue: false,
            printouts: false,
            emails: false,
            billings: false,
            autoid: false,
            groups: false,
        }

    }

    return {
        records: false,
        appointments: false,
        tests: false,
        orders: false,
        consultation: false,
        chats: false,
        calls: false,
        articles: false,
        feedback: false,
        payments: false,
    }

}

export function customClasses() {

    return {
        header_sticky: true,
        sticky: true,
        'mt-40': false,
        menu_header: true,
    }

}

// moment().format('MMMM Do YYYY, h:mm:ss a'); // February 11th 2019, 11:15:35 am
// moment().format('dddd');                    // Monday
// moment().format("MMM Do YY");               // Feb 11th 19
// moment().format('YYYY [escaped] YYYY');     // 2019 escaped 2019
// moment().format();                          // 2019-02-11T11:15:35+03:00

