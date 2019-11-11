<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/27/18
 * Time: 1:55 PM
 */

namespace App\Transformers\User;


use App\Models\Users\Patient;

class PatientTransformer
{

    public function transform(Patient $patient){

    }

    public function signupRule(){
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
        ];
    }

}
