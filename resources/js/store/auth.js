export default {
    state: {
        api_token: null,
        token_type: null,
        expires_at: null,
        current_user: null,
    },
    initialize() {

        this.state.api_token = localStorage.getItem('api_token');
        this.state.token_type = localStorage.getItem('token_type');
        this.state.expires_at = localStorage.getItem('expires_at');
        this.state.current_user = localStorage.getItem('current_user');

    },
    set(api_token,token_type,expires_at,current_user) {
        localStorage.setItem('api_token', api_token);
        localStorage.setItem('token_type', token_type);
        localStorage.setItem('expires_at', expires_at);
        localStorage.setItem('current_user', JSON.stringify(current_user));
        this.initialize()
    },
    remove() {
        localStorage.removeItem('api_token');
        localStorage.removeItem('token_type');
        localStorage.removeItem('expires_at');
        localStorage.removeItem('current_user');
        this.initialize()
    },

    isAuth(){
        if ( localStorage.getItem('api_token') ){ return true;}else { return false; }
    },

    getRole(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.user_type;
    },
    getKey(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.uuid;
    },
    getUsername(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.username;
    },
    getFname(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.first_name;
    },

    getPhone(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.phone;
    },
    getEmail(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.email;
    },

    getAvatar(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.avatar;
    },

    redirect_user(){
        let  role = this.getRole();
        if (role === 'systemadmin'){
            return "/dashboard"
        }else if(role === 'patient'){
            return "/patient/"+this.getKey()+"/dashboard"
        }else if(role === 'doctor'){
            return "/doctor/"+this.getKey()+"/dashboard"
        }else if (role === 'admin'){
            return "/administrator";
        }
        else {
            return "/page/not/found"
        }
    },
    redirect_route(){

        let  role = this.getRole();
        if (role){
            if (role === 'systemadmin'){
                return "/dashboard"
            }else if(role === 'patient'){
                return "/patient/"+this.getKey()+"/dashboard"
            }else if(role === 'doctor'){
                return "/partners/"+this.getKey()+"/dashboard"
            }else if (role === 'admin'){
                return "/administrator";
            }
            else {
                return "/page/not/found"
            }
        }else {
            return "next"
        }

    },
    isSysAdmin(){
        let  role = this.getRole();
        if (role === 'systemadmin'){
            return true
        }else {
            return false
        }
    },
    isPatient(){
        let  role = this.getRole();
        if (role === 'patient'){
            return true
        }else {
            return false
        }
    },

    isDoctor(){
        let  role = this.getRole();
        if (role === 'doctor'){
            return true
        }else {
            return false
        }
    },
    isAdmin(){
        let  role = this.getRole();
        if (role === 'admin'){
            return true
        }else {
            return false
        }
    },

    getProvideProfileLevel(){

        if ( localStorage.hasOwnProperty("profile_status") ) {
            let profile_state = JSON.parse(localStorage.getItem('profile_status'));
            if (profile_state.basic === 0) {
                return "/partners/onboarding";
            }else if ( profile_state.medical_registration === 0 ) {
                return "/partners/onboarding/registration";
            }else if ( profile_state.education ===0 ){
                return "/partners/onboarding/education";
            } else if ( profile_state.practice_connect ===0 ){
                return "/partners/onboarding/connect_clinic";
            } else if ( profile_state.practice_detail ===0 ){
                return "/partners/onboarding/clinic_details";
            } else if ( profile_state.profile_identity ===0 ){
                return "/partners/onboarding/identity_proof";
            } else if( profile_state.locations ===0){
                return "/partners/onboarding/set/location";
            }
            else {
                return "/partners/onboarding";
            }
        }else {
            return "/partners/onboarding";
        }

    },

    setProfileStatus(profile_status){
        localStorage.setItem('profile_status',JSON.stringify(profile_status))
    },

    set_mobile_to_verify(mobile){
        localStorage.setItem('ver_mobile',mobile)
    },
    get_mobile_to_verify(){
        return localStorage.getItem('ver_mobile')
    },
    delete_mobile_to_verify(){
        localStorage.removeItem('ver_mobile')
    }

}
