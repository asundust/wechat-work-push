<?php

use Asundust\WechatWorkPush\Http\Controllers\WechatWorkPushHandleController;

Route::match(['get', 'post'], 'push/{secret}', WechatWorkPushHandleController::class . '@push');