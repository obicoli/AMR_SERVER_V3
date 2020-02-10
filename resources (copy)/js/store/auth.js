export default {
    state: {
        api_token: "",
        token_type: "",
        expires_at: "",
        //current_user: null,
        all_accounts: [],
        current_account: {},
    },
    initialize() {

        this.state.api_token = localStorage.getItem('api_token');
        this.state.token_type = localStorage.getItem('token_type');
        this.state.expires_at = localStorage.getItem('expires_at');
        //this.state.current_user = localStorage.getItem('current_user');
        this.state.all_accounts = JSON.parse(localStorage.getItem('all_accounts'));
        this.state.current_account = JSON.parse(localStorage.getItem('current_account'));

    },
    set(api_token,token_type,expires_at,all_accounts, current_account) {
        localStorage.setItem('api_token', api_token);
        localStorage.setItem('token_type', token_type);
        localStorage.setItem('expires_at', expires_at);
        //localStorage.setItem('current_user', JSON.stringify(current_user));
        localStorage.setItem('all_accounts', JSON.stringify(all_accounts));
        localStorage.setItem('current_account', JSON.stringify(current_account));
        this.initialize()
    },
    remove() {
        localStorage.removeItem('api_token');
        localStorage.removeItem('token_type');
        localStorage.removeItem('expires_at');
        //localStorage.removeItem('current_user');
        localStorage.removeItem('all_accounts');
        localStorage.removeItem('current_account');
        localStorage.removeItem('entryUrl');
        localStorage.removeItem('accountings');
        localStorage.removeItem('products');
        this.initialize();
        this.traceActive(null,null);
        this.deleteCurrentBranch();
    },

    isAuth(){
        if ( localStorage.getItem('api_token') ){ return true;}else { return false; }
    },

    setMenu(outer_level, inner_level){
        let current_account = JSON.parse(localStorage.getItem('current_account'));
        //console.info(current_account.data.roles[0].permissions);
        let permissions = current_account.data.role.permissions;
        if(outer_level){
            for( let i = 0; i < permissions.length; i++ ){
                if(permissions[i].description === inner_level){
                    return true;
                }
            }
        }
    },

    getAccounting(){
        return JSON.parse(localStorage.getItem("accountings"));
    },
    getProducts(){
        return JSON.parse(localStorage.getItem("products"));
    },

    menuChecker(check_value){

        let current_account = JSON.parse(localStorage.getItem('current_account'));
        let permissions = current_account.data.role.permissions;
        let pin_ = false;
        for( let i = 0; i < permissions.length; i++ ){
            if(permissions[i].slug === check_value){
                pin_ = true;
            }
        }
        return pin_;
    },

    // export function isInArray(value, array) {
    //     return array.includes(value);
    // }

    getRole(){
        let current_account = JSON.parse(localStorage.getItem('current_account'));
        //console.info(current_account);
        return current_account;
    },

    // getCurrentPracticePermission(){
    //     let current_account = JSON.parse(localStorage.getItem('current_account'));
    //     //console.info(current_account);
    //     return current_account.data[0].practice_user.roles[0].permissions;
    // },

    getKey(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.id;
    },
    getId(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.id;
    },
    getUsername(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.username;
    },
    getFname(){

        let current_account = JSON.parse(localStorage.getItem('current_account'));
        if (this.isPracticeUser()){
            return current_account.data[0].practice_user.first_name;
        } else if (this.isPharmacy()) {
            return "Admin";
        }
    },

    getOtherName(){
        let current_account = JSON.parse(localStorage.getItem('current_account'));
        if (this.isPracticeUser()){
            return current_account.data[0].practice_user.other_name;
        } else if (this.isPharmacy()) {
            return "Admin";
        }
    },

    // jobData(search_type_){

    //     let current_account = JSON.parse(localStorage.getItem('current_account'));
    //     switch (search_type_) {

    //         case "org_name":
    //             if (this.isPracticeUser()){
    //                 return current_account.data[0].name;
    //             } else if (this.isPharmacy()) {
    //                 return current_account.data.name+' ('+current_account.data.category+')';
    //             }
    //             break;

    //         case "work_place_name":
    //             if (this.isPracticeUser()){
    //                 return current_account.data[0].practice_user.work_place.branch_name+ ', ('+current_account.data[0].practice_user.work_place.branch_category+')';
    //             } else {
    //                 return "";
    //             }
    //             break;

    //         case "work_department":
    //             if (this.isPracticeUser()){
    //                 return current_account.data[0].practice_user.work_place.department_name;
    //             } else {
    //                 return "";
    //             }
    //             break;

    //         case "user_permissions":
    //             if (this.isPracticeUser()){
    //                 return current_account.data[0].practice_user.permissions;
    //             } else {
    //                 //console.info(current_account);
    //                 return current_account.data.permissions;
    //             }
    //             break

    //     }
    // },

    isPracticeUser(){
        let current_account = JSON.parse(localStorage.getItem('current_account'));
        //console.info(current_account);
        //if (current_account.account_type === "Practice User"){ return true; }else { return false; }
        return true;
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

    getPname(){
        let logged_user = JSON.parse(localStorage.getItem('current_user'));
        return logged_user.name;
    },

    redirect_route(){

        if ( this.getEntryUrl() ){
            //return this.getEntryUrl()
            // return "/accounting/dashboard";
            return "/dashboard";
        } else {

            let  role = this.getRole();

            if (role){

                if (role.account_type === 'Pharmacy'){
                    return "/dashboard"
                }else if(role.account_type === 'Facility Staff'){
                    //return "/inventory/dashboard"
                    return "/dashboard";
                }else if(role.account_type === 'Doctor'){
                    return "/partners/"+this.getKey()+"/dashboard"
                }else if (role === 'admin'){
                    return "/administrator";
                }
                else {
                    return "/403"
                    //return "/dashboard";
                }

            }else {
                //return "/403"
                return "/dashboard";
            }

        }

    },

    isDoctor(){
        let  role = this.getRole();
        if (role === 'Doctor'){
            return true
        }else {
            return false
        }
    },
    isPharmacy(){
        // let current_account = JSON.parse(localStorage.getItem('current_account'));
        // if (current_account.account_type === 'Pharmacy'){
        //     return true
        // }else {
        //     return false
        // }
        return true
    },
    isApproved(){
        let current_account = JSON.parse(localStorage.getItem('current_account'));
        if (current_account.data.approval_status === 'approved'){
            return true
        }else {
            return true
        }
    },

    getCurrentAccount(type_ = null){
        let current_account = JSON.parse(localStorage.getItem('current_account'));
        let responder = null;
        if (type_){
            switch (type_) {
                case "clinic": //Current Account
                    responder = current_account.data.facility;
                    break;
                case "id":
                    responder = current_account.data.facility.id;
                    break;
                case "facility":
                    responder = current_account.data.facility.name;
                    break;
                case "account":
                    responder = current_account;
                    break;
                case "work_place":
                        //responder = current_account.data.facility;
                    responder = current_account;
                    break;
                case "staff_id":
                    responder = current_account.data.id;
                    break;
                case "address":
                    let src_facility_id = null;
                    let src_store_id = null;
                    let src_department_id = null;
                    let src_sub_store_id = null;
                    if(current_account.data.work_station){
                        src_facility_id = current_account.data.work_station.id;
                    }
                    if(current_account.data.department){
                        src_department_id = current_account.data.department.id;
                    }
                    if(current_account.data.store){
                        src_store_id = current_account.data.store.id;
                    }
                    if(current_account.data.sub_store){
                        src_sub_store_id = current_account.data.sub_store.id;
                    }
                    responder = {
                        source_address: {
                            facility_id: src_facility_id,
                            store_id: src_store_id,
                            department_id: src_department_id,
                            sub_store_id: src_sub_store_id,
                        },
                        destination_address: {
                            facility_id: src_facility_id,
                            store_id: '',
                            department_id: '',
                            sub_store_id: ''
                        },
                        staff_address: {
                            staff_id: current_account.data.id,
                            email: current_account.data.email,
                            role: current_account.data.role.name,
                            facility_id: src_facility_id,
                            store_id: current_account.data.work_station.store.id,
                            department_id: current_account.data.work_station.department.id,
                            sub_store_id: current_account.data.work_station.sub_store.id,
                        },
                        service_data: {
                            service_type: '',
                            service_action: '',
                            posted_data: null,
                        }
                    }
                break;
            }
            return responder
        }
        return current_account;
    },

    getLoggedUser(){
        return  JSON.parse(localStorage.getItem('current_user'));
    },

    isAdmin(){
        let  role = this.getRole();
        if (role === 'admin'){
            return true
        }else {
            return false
        }
    },

    setCurrentBranch(current_branch){
        localStorage.setItem('current_account', JSON.stringify(current_branch));
    },

    getCurrentBranch(){
        
        if(localStorage.getItem('current_account')){
            return JSON.parse( localStorage.getItem('current_account') );
        }else{
            return false;
        }
    },

    deleteCurrentBranch(){
        localStorage.removeItem('current_account');
    },

    redirect_to_branch(){
        let branchs = this.getCurrentBranch();
        if (branchs){
            //return "/facility/dashboard";
            return "/accounting/dashboard";
        } else {
            return "/";
        }
    },

    setEntry(entryUrl){
        localStorage.setItem("entryUrl",entryUrl)
    },

    delEntry(){
        localStorage.removeItem("entryUrl")
    },
    
    getEntryUrl(){
        if (localStorage.getItem("entryUrl")){
            return localStorage.getItem("entryUrl")
        }else {
            return  false;
        }
    },
    traceActive(action_to,current_active){
        switch (action_to) {
            case "get":
                if (localStorage.getItem("activeLink")) {
                    return localStorage.getItem("activeLink");
                }else {
                    return 0;
                }
                break;
            case "set":
                localStorage.setItem("activeLink",current_active);
                break;
            case "remove":
                localStorage.removeItem("activeLink");
                break;
        }
    }


}
