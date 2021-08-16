<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Hash;

class User extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'api_token'];

    /**
     * @param $userDetails
     * @return mixed
     */
    static function addNewUser($userDetails)
    {
        $userDetails['password'] = Hash::make($userDetails['password']);
        self::create($userDetails);
    }
}
