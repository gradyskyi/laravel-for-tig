<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Auth\User;
use Jenssegers\Mongodb\Schema\Blueprint;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/create-user', function () {
    for ($i = 1; $i <= 4; $i++) {
        $user = new User();
        $user->password = Hash::make('password');
        $user->email = 'gurichna@gmail' . $i . '.com';
        $user->name = 'User-' . $i;
        $user->save();
    }

    $users = \App\Models\User::all();
    $userNames = [];

    foreach ($users as $user) {
        $userNames[] = [
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id
        ];

        $user->delete();
    }

    return response()->json($userNames);
});
