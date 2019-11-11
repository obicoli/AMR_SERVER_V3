import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../views/front/home'
import Login from '../views/auth/login'
import Register from '../views/auth/signup/register'
import PassEmail from '../views/auth/password/email'
import ResetPass from '../views/auth/password/reset'
import CreatePass from '../views/auth/password/create_password'
import AcceptInvite from '../views/auth/password/AcceptInvite'
import ActToken from '../views/auth/signup/token'
import MobileVerify from '../views/auth/signup/mobile_verify'
import MailVerify from '../views/auth/signup/mail_verify'
import ActReq from '../views/auth/signup/activation'

//errors
import NotFound from '../views/errors/404'
import Err500 from '../views/errors/500'
import UnderRepaire from '../views/errors/maintanance'
//practices:

import Config from '../helpers/config'

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {   path: '/', component: Home, meta: { title: ':: '+Config.app_data.app_name+' :: '+Config.app_data.app_description, guestUser: true } },
        {   path: '/login', component: Login, meta: { title: 'Login - '+Config.app_data.app_name, guestUser: true } },
        {   path: '/register', component: Register, meta: { title: 'Register :: '+Config.app_data.app_name, guestUser: true } },
        {   path: '/forgot/password', component: PassEmail, meta: { title: Config.app_data.app_name+' | Password problem', guestUser: true } },
        {   path: '/reset/password/:token', component: ResetPass, meta: { title: Config.app_data.app_name+' | Reset password', guestUser: true } },
        {   path: '/activate/:token', component: ActToken, meta: { title: Config.app_data.app_name+' | Activation required', guestUser: true } },
        {   path: '/oauth/login/:uuid/create/password', component: CreatePass, meta: { title: Config.app_data.app_name+' | Create password', guestUser: true } },
        {   path: '/invitation/accept/:email/:uuid', component: AcceptInvite, meta: { title: Config.app_data.app_name+' | Invitation', guestUser: true } },
        {   path: '/registration/mobile-verification', component: MobileVerify, meta: { title: ':: '+Config.app_data.app_name+' :: Mobile verification', guestUser: true } },
        {   path: '/registration/email-verification', component: MailVerify, meta: { title: ''+Config.app_data.app_name+' :: Email verification', guestUser: true } },
        {   path: '/activation/required', component: ActReq, meta: { title: Config.app_data.app_name+' | Activation required', guestUser: true } },
        {   path: '/reset/password', component: ResetPass, meta: { title: Config.app_data.app_name+' | Activation required', guestUser: true } },

        //errors pages
        { path: '*', component: NotFound, meta: {  title: Config.app_data.app_name+' | 404 - Page Not Found'} },
        { path: '/under/maintenance', component: UnderRepaire, meta: {  title: Config.app_data.app_name+' | Under Maintenance'} },
        { path: '/500', component: Err500, meta: {  title: Config.app_data.app_name+' | 500-Internal Server Error'} },
    ]
});

export default router
