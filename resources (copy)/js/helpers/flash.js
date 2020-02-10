import {get} from "./api";

export default {

    loadRole(){
        let roles = [];
        get('/api/roles')
            .then((res) => {
                if(res.data.status_code === 200) {
                    roles = res.data.results;
                }
            }).catch((err) => {
        });
        return roles;
    },

}
