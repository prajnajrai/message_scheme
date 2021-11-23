<?php

use Illuminate\Http\Request;

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

Route::group(['middleware'=>['cors']], function () { //APIKey
	Route::get('get-hello', ['uses' => 'API\APIController@getHello'
    ]);

    Route::get('receive-sms', ['uses' => 'API\APIController@receiveSms'
    ]);

    Route::get('test-send-sms', ['uses' => 'API\APIController@testSendSms'
    ]);

    Route::get('insert-campaign-code', ['uses' => 'API\APIController@insertCampaignCode'
    ]);

    // Route::get('get-received-sms-list', ['as'=>'get.received.sms-list',  'uses' => 'API\APIController@getReceievedSMSList'
    // ]);

    // Route::post('get-received-sms-list', ['as'=>'search.received.sms-list',  'uses' => 'API\APIController@searchReceievedSMSList'
    // ]);
});
