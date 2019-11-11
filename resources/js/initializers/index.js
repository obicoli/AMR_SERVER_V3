import {get,post} from "../helpers/api";

export function verifyToken(token) {
    let token_url = '/api/oauth/reset-password/'+token;
    get(token_url)
    .then((res) => {
        return true;
    })
    .catch((err) => {
        //console.info(err.response.data.errors);
        return err.response.data.errors;
        // results['status_code'] = err.response.data.status_code;
        // results['results'] = err.response.data.errors;
        // return results
    });
}
