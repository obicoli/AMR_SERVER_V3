<template>
    <div data-component="navbar">
        <nav v-bind:class="{'navbar p-0 fixed-top':true,'no-shadowed':inventory,'bg-f7':bg_f7}">
            
            <div class="width-100-pc">

                <div class="welcome-msg float-left">
                    <a href="/" class="dash-logo-icon">
                        <img src="/assets/front/images/amref_healthafrica_kenya_small.png">
                    </a>
                </div>

                <div v-if="head_loaded" class="welcome-msg float-left padding-top-10 mg-left-10 bd-left padding-left-10">
                    <p class="txt-uppercase fw-600">AMREF Enterprises | <span class="cl-amref">AMREF Health Africa</span> ({{user_account.data.facility.name}})</p>
                    <p class="cl-787887 fs-12 fw-600"></p>
                </div>

                <div class="right-links-custome float-right">
                    <div v-if="!head_loaded" class="d-inline dropdown rounded-0 mx-3">
                        <a class="dropdown-toggle" id="tools" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fa fa-wrench" aria-hidden="true"></i></a>
                        <div class="dropdown-menu dropdown-menu-right rounded-0 text-center" aria-labelledby="tools">
                            <a class="dropdown-item px-2" href="#">Recompile CSS</a>
                        </div>
                    </div>
                    <div v-if="!head_loaded" class="d-inline dropdown mr-3">
                        <a class="dropdown-toggle" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><span>10</span><i class="fa fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-menu-right rounded-0 pt-0" aria-labelledby="notifications">
                            <div class="list-group">
                                <div class="lg">
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                        <h5 class="mb-1">Real Estate Marketing Automation: 6 Simple Systems</h5>
                                        <p class="mb-0">17 October 2016 | 9:32 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">How to Generate Seller Leads For $0.88 Using...</h5>
                                        <p class="mb-0">3 October 2016 | 9:58 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">AgentFire Re-Opens For Business. New Services,...</h5>
                                        <p class="mb-0">20 September 2016 | 6:28 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">Real Estate Blogging 101: How To Get Better...</h5>
                                        <p class="mb-0">7 September 2016 | 3:03 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">How To Get More Listings With Strategic...</h5>
                                        <p class="mb-0">16 August 2016 | 8:26 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">How To Find Strategic Real Estate Partners as...</h5>
                                        <p class="mb-0">9 August 2016 | 6:44 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">Top 10 Real Estate Marketing Tools</h5>
                                        <p class="mb-0">2 August 2016 | 10:25 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">The Beginner Guide To Google Adwords For Real...</h5>
                                        <p class="mb-0">27 July 2016 | 1:15 am</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">The Complete Guide To Hyper-Local SEO For Realtors</h5>
                                        <p class="mb-0">19 July 2016 | 5:51 pm</p>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <h5 class="mb-1">How We Took Ed Eakin’s Real Estate Website...</h5>
                                        <p class="mb-0">11 July 2016 | 6:19 pm</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="!head_loaded" class="d-inline dropdown mr-3">
                        <a class="dropdown-toggle" id="messages2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fa fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-menu-right rounded-0 text-center" aria-labelledby="messages">
                            <a class="dropdown-item">There are no new messages</a>
                        </div>
                    </div>

                    <div v-if="head_loaded" class="d-inline dropdown mr-3">
                        <a class="cl-444 fs-13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Welcome <strong>{{user_account.data.first_name}} {{user_account.data.other_name}}! </strong> ({{user_account.data.role.name}})
                        </a>
                    </div>

                    <div class="d-inline dropdown mr-3">
                        <a class="dropdown-toggle" id="messages1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                            <img src="/assets/icons/staff.png">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right rounded-0" aria-labelledby="messages">
                            <a class="dropdown-item" href="">My profile</a>
                            <a class="dropdown-item pointer-cursor" @click="logout">Log Out</a>
                        </div>
                    </div>

                </div>
            </div>

        </nav>
    </div>
</template>

<script>
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import {PRACTICE_ROLE_URL} from '../../../../../router/api_routes';

    export default {
        name: "TopNavBar",
        props: ['inventory','bg_f7'],
        data(){
            return {
                user_account: {},
                head_loaded: false,
                addresser: {},
            }
        },
        methods: {
            logout(){
                Auth.remove();
                window.location.reload();
            },
        },
        mounted() {
            this.user_account = Auth.getCurrentAccount('account');
            this.addresser = Auth.getCurrentAccount('work_place');
            this.head_loaded = true;
            // console.info(this.addresser);
        }
    }
</script>

<style scoped>

</style>