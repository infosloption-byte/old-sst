<?php
namespace App\Http\Controllers\Api\Logics;

use App\Models\User;

class AuthLogics
{

    /**
     * get user from auth token.
     *
     * @return User
     */
    function getUserFromAuth(){
        $aa = request()->user();
        return $aa;
    }

}