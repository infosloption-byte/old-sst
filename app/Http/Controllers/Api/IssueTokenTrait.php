<?php 

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

trait IssueTokenTrait{

	public static function issueToken(Request $request, $grantType, $scope = "*")
    {
        $client = Client::where('password_client', 1)->first();

		$params = [
    		'grant_type'    => $grantType,
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $request->username,
            'password'      => bcrypt($request->password),
            'scope'         => $scope,
    	];

    	$request->request->add($params);

    	$proxy = Request::create('oauth/token', 'POST');

    	return Route::dispatch($proxy);

	}

}