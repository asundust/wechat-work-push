<?php

use Asundust\WechatWorkPush\Http\Controllers\WechatWorkPushConfigController;
use Asundust\WechatWorkPush\Http\Controllers\WechatWorkPushUserController;
use Illuminate\Support\Facades\Route;

Route::get('wechatWorkPushConfig', WechatWorkPushConfigController::class . '@index');
Route::post('wechatWorkPushConfig', WechatWorkPushConfigController::class . '@update');
Route::resource('wechatWorkPushUsers', WechatWorkPushUserController::class)->except(['show']);
