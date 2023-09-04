<?php

namespace Asundust\WechatWorkPush;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WechatWorkPushServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(WechatWorkPush $extension)
    {
        if (!WechatWorkPush::boot()) {
            return;
        }

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        $this->app->booted(function () {
            WechatWorkPush::routes(__DIR__ . '/../routes/web.php');
        });

        $attributes = array_merge(
            [
                'middleware' => [config('admin.extensions.wechat-work-push.middleware', 'web')],
            ],
            WechatWorkPush::config('route', [])
        );
        Route::group($attributes, __DIR__ . '/../routes/push.php');
    }
}
