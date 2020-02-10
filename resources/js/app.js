
import Vue from 'vue';
import App from './components/App';
import router from './router';
import Auth from './store/auth';
import VueAWN from "vue-awesome-notifications"
import SocialSharing from 'vue-social-sharing';
import * as VueGoogleMaps from "vue2-google-maps";
import Pagination from 'laravel-vue-pagination';



// Import VueScheduler
import VueScheduler from 'v-calendar-scheduler';

// import {Datepicker, Timepicker, DatetimePicker} from '@livelybone/vue-datepicker';
// Vue.component('datepicker', Datepicker);
// Vue.component('timepicker', Timepicker);
// Vue.component('datetime-picker', DatetimePicker);
// import V2Datepicker from 'v2-datepicker';
// //Vue.component('v2-datepicker', V2Datepicker);
// Vue.use(V2Datepicker)

import VueApexCharts from 'vue-apexcharts'
Vue.component('apexchart', VueApexCharts)

import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
import { Settings } from 'luxon'
Settings.defaultLocale = 'en'
Vue.component('datetime', Datetime);

// Import styles
import 'v-calendar-scheduler/lib/main.css';
Vue.use(VueScheduler);

import VueSingleSelect from "vue-single-select";
Vue.component('vue-single-select', VueSingleSelect);

Vue.use(Pagination);

Vue.use(VueGoogleMaps, {
    load: {
        key : "AIzaSyC181oFbh3kPruibCPoLOj8OVEJ-pLGXNQ",
        //key: AppInfo.app_data.google_map.api_key,
        libraries: "places" // necessary for places input
    }
});
Vue.use(SocialSharing);
Vue.use(VueAWN, {
    position: 'top-right',
    labels: {
        warning: 'Whoops!',
        success: 'Success',
        confirm: 'Confirmation Required'
    },
    icons: {
        confirm: 'question-circle'
    },
    modal: {
        okLabel: 'OK',
        cancelLabel: 'Close',
    }
});

// import moment from 'vue-moment'
// Vue.use(moment);
// import VueMoment from 'vue-moment'
// import moment from 'moment-timezone'
// Vue.use(VueMoment, {
//     moment,
// });

import VueMoment from 'vue-moment';
Vue.use(VueMoment);

import vuetimeline from "@growthbunker/vuetimeline";
Vue.use(vuetimeline);

import VuejsDialog from 'vuejs-dialog';
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js'; // only needed in custom components
// include the default style
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
// Tell Vue to install the plugin.
Vue.use(VuejsDialog);

//import 'bootstrap/dist/css/bootstrap.min.css';
import * as uiv from 'uiv';
Vue.use(uiv);

// import VueFusionCharts from 'vue-fusioncharts';
// import FusionCharts from 'fusioncharts';
// import Column2D from 'fusioncharts/fusioncharts.charts';
// import FusionTheme from 'fusioncharts/themes/fusioncharts.theme.fusion';
// Vue.use(VueFusionCharts, FusionCharts, Column2D, FusionTheme);

// import VueGoogleCharts from 'vue-google-charts';
// Vue.use(VueGoogleCharts)




// import { MdButton } from 'vue-material/dist/components'
// Vue.use(MdButton);
// import 'vue-material/dist/vue-material.min.css'
// import 'vue-material/dist/theme/default.css'

// import DecoupledEditor from '@ckeditor/ckeditor5-build-decoupled-document';
// Vue.use(DecoupledEditor);

import {tokenValidator} from "./helpers/functionmixin";
import {ADMIN_PERM} from './helpers/permissions';

router.beforeEach((to, from, next) => {

    const guestUser = to.matched.some(record => record.meta.guestUser);
    const authenticatedUser = to.matched.some(record => record.meta.authenticatedUser);
    // const requireSystemAdmin = to.matched.some(record => record.meta.requireSystemAdmin);
    // const requireAdmin = to.matched.some(record => record.meta.requireAdmin);
    // const requirePharmacy = to.matched.some(record => record.meta.requirePharmacy);
    // const requireApproved = to.matched.some(record => record.meta.requireApproved);
    // const accountSwitched = to.matched.some(record => record.meta.accountSwitched);
    // const hasAccess = to.matched.some(record => record.meta.hasAccess);
    // const requireDoctor = to.matched.some(record => record.meta.requireDoctor);
    // const requireProfileCompleted = to.matched.some(record => record.meta.requireProfileCompleted);

    const accessToUsers = to.matched.some(record => record.meta.accessToUsers);
    const accessToRoles = to.matched.some(record => record.meta.accessToRoles);
    //
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

    if (nearestWithTitle) {
        document.title = nearestWithTitle.meta.title;
    }

    if (guestUser) { //This Resource Requires Un Authenticated User
        if (Auth.isAuth()) {
            const url_to = Auth.redirect_route();
            if (url_to === 'next') {
                next();
            } else {
                next(url_to);
            }
        } else {
            next();
        }
    }
    else if (authenticatedUser) { //This resource requires Authenticated user

        if (Auth.isAuth()) {

            //Requires Access to Users & Roles
            if(accessToUsers || accessToRoles){
                if( Auth.hasPermission(ADMIN_PERM.USERS.VIEW) || Auth.hasPermission(ADMIN_PERM.ROLES.VIEW)){ next() }else{ next('/403') }
            }else{
                next()
            }

            // if (requireSystemAdmin) {
            //     if (Auth.isSysAdmin()) {
            //         next()
            //     } else {
            //         next('/page/not/found')
            //     }
            // } else if (requirePharmacy) {

            //     if (Auth.isPharmacy() || Auth.isPracticeUser()) {
            //         //check if required approval
            //         if (requireApproved) {
            //             if (Auth.isApproved()) {
            //                 next();
            //             } else {
            //                 next('/approval/pending')
            //             }
            //         } else {
            //             next()
            //         }
            //     } else {
            //         next('/403')
            //     }
            // }
            // else {
            //     next()
            // }

        } else {
            let entryUrl = to.path;
            Auth.setEntry(entryUrl);
            next('/login')
        }
    }
    else {
        next();
    }

});

const app = new Vue({
    el: '#root',
    template: `<app></app>`,
    components: { App },
    router
});
