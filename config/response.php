<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/14/18
 * Time: 4:14 PM
 */

return [

    'http' => [
        '200' => [
            'status_code' => 200,
            'name' => 'OK',
            'results' => [],
            'description' => 'Request was successful',
        ],
        '201' => [
            'status_code' => 201,
            'name' => 'OK',
            'results' => [],
            'description' => 'Expired stock detected',
        ],
        '400' => [
            'status_code' => 400,
            'name' => 'Unauthorized',
            'description' => 'Username and/or password is incorrect.',
        ],
        '401' => [
            'status_code' => 401,
            'name' => 'Not authenticated',
            'description' => 'No valid Access Key/Token was given.',
        ],
        '402' => [
            'status_code' => 402,
            'name' => 'Activation required',
            'description' => 'Account activation required',
        ],
        '403' => [
            'status_code' => 403,
            'name' => 'Forbidden',
            'description' => 'Not permitted access to the resource.',
        ],
        '405' => [
            'status_code' => 405,
            'name' => 'Method not allowed',
            'description' => 'The method is not implemented',
        ],
        '422' => [
            'status_code' => 422,
            'name' => 'Unprocessable entity',
            'description' => 'The payload has missing required parameters or invalid data was given.',
        ],
        '500' => [
            'status_code' => 500,
            'name' => 'Internal Server Error',
            'description' => 'Request failed due to an internal error.',
        ],
    ],

    'mail_subjects' => [

        'verify_mail' => 'EMAIL VERIFICATION',

        'reset_pass' => 'PASSWORD RESET',

        'set_password' => 'SET YOUR PASSWORD',

    ],

];
