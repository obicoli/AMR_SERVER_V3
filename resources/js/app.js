
import Vue from 'vue'
import App from './components/App'
import router from './router'
import Auth from './store/auth'
import VueAWN from "vue-awesome-notifications"
import SocialSharing from 'vue-social-sharing';
import * as VueGoogleMaps from "vue2-google-maps";
import app_info from './helpers/config'
import Pagination from 'laravel-vue-pagination';

// Import VueScheduler
import VueScheduler from 'v-calendar-scheduler';
// Import styles
import 'v-calendar-scheduler/lib/main.css';
Vue.use(VueScheduler);


Vue.use(Pagination);

Vue.use(VueGoogleMaps, {
    load: {
        key: app_info.app_data.google_map.api_key,
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

//Location to display the notifications. Possible values: "top-left", "top-right", "bottom-left", "bottom-right"
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll);

router.beforeEach((to, from, next) => {


    const guestUser = to.matched.some(record => record.meta.guestUser);
    const authenticatedUser = to.matched.some(record => record.meta.authenticatedUser);
    const requireSystemAdmin = to.matched.some(record => record.meta.requireSystemAdmin);
    const requireAdmin = to.matched.some(record => record.meta.requireAdmin);
    const requirePatient = to.matched.some(record => record.meta.requirePatient);
    const requireDoctor = to.matched.some(record => record.meta.requireDoctor);
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

    if (nearestWithTitle){
        document.title = nearestWithTitle.meta.title;
    }

    if ( guestUser ){

        if (Auth.isAuth()){

            const url_to = Auth.redirect_route();
            if (url_to === 'next'){
                next();
            }else {
                next(url_to);
            }

        }else {

            next();

        }

    }
    else if ( authenticatedUser ){
        
        if (Auth.isAuth()) {

            if (requireSystemAdmin) {
                if (Auth.isSysAdmin()){
                    next()
                } else {
                    next('/page/not/found')
                }
            }else if (requirePatient){

                if (Auth.isPatient()){
                    next()
                } else {
                    next('/page/not/found')
                }

            }else if ( requireDoctor ){

                if ( Auth.isDoctor() ){
                    next()
                } else {
                    next('/page/not/found')
                }

            }else if (requireAdmin){

                if ( Auth.isAdmin() ){
                    next()
                } else {
                    next('/page/not/found')
                }

            }
            else {
                next()
            }
        }else {
            let entryUrl = to.path;
            localStorage.setItem("entryUrl",entryUrl);
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
