<template>
    <ul v-bind:class="{'list-group flex-column d-inline-block submenu submenu-custom':true,'scrollable-menu':scrollable}">
        <!-- <loading :is-loading="processing"></loading> -->
        <li v-bind:class="{'list-group-item menu-title-li pl-4':true,'min_ht_67 transparent-li':transparent}">
            <a href="#" class="menu-title float-left">HR Management</a>
        </li>
        <li class="list-group-item items-lists padding-left-25">
            <a :href="'/human_resources/employee/index/'+format_slug('employees')" class="pointer-cursor fs-14 fw-600 cl-red">Employee List</a>
        </li>
        <li v-for="(hr_role, index) in hr_roles" :key="'hr_role'+index" v-bind:class="{'list-group-item items-lists padding-left-25':true,'transparent-li':transparent,'active':active_el===index}">
            <a @click="redirect_user_to('/human_resources/employee/index/'+format_slug(hr_role.slug),index)" class="">{{hr_role.name}}</a>
        </li>
    </ul>
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import Loading from "../../../../../components/loads/ProgRess";
    // import RoleModel from '../../../pharmacy/hr_depart/partials/RoleModel'

    export default {
        name: "SideBarHr",
        props: ['scrollable','width','transparent','active_num','hr_role'],
        components: {
            Loading
        },
        data(){
            return {
                processing: false,
                loaded_page: false,
                practice_id: '',
                branch_id: '',
                current_branch: {},
                hr_roles: [],
                form: {
                    name: '',
                    description: '',
                    practice_id: '',
                    status: '',
                },
                active_el:0
            }
        },
        watch: {
            hr_role: function(newVal, oldVal){
                //console.log('Prop changed: ', newVal, ' | was: ', oldVal)
                this.hr_roles = newVal;
            }
        },
        methods: {
            load_hr(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/roles/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.hr_roles = res.data.results;
                            console.info(this.hr_roles);
                            this.processing = false;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
            format_slug(sluger){
                return sluger.replace(".","_")
            },
            redirect_user_to(url_to,current_active){
                //Auth.traceActive(current_active,'store');
                //window.location.href = url_to;
                this.active_el = current_active;
                console.info(this.active_el);
                this.$router.push(url_to);
            }
        },
        mounted() {
            this.hr_roles = this.hr_role;
            // this.practice_id = Auth.getCurrentAccount('id');
            // this.current_branch = Auth.getCurrentBranch();
            // console.info(this.practice_id);
            // console.info(this.current_branch);
            // //this.branch_id = this.current_branch.id;
            // this.form.practice_id = this.practice_id;
            // this.active_el = this.active_num;
            // this.load_hr();
            // this.loaded_page = true;
        }
    }
</script>

<style scoped>

</style>