<?php

namespace Asundust\WechatWorkPush;

use Encore\Admin\Extension;

class WechatWorkPush extends Extension
{
    public $name = 'wechat-work-push';

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public static function import()
    {
        parent::createMenu('企业微信消息推送', '', 'fa-wechat', 0, [
            [
                'title' => '用户配置',
                'path' => 'wechatWorkPushUsers',
                'icon' => 'fa-users',
            ],
            [
                'title' => '默认配置',
                'path' => 'wechatWorkPushConfig',
                'icon' => 'fa-toggle-on',
            ],
        ]);

        parent::createPermission('企业微信消息推送配置', 'ext.wechatWorkPush', 'wechatWorkPush*');
    }
}
