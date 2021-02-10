<?php

namespace Asundust\WechatWorkPush\Http\Actions;

use Asundust\WechatWorkPush\Http\Traits\SendMessageTrait;
use Asundust\WechatWorkPush\Models\WechatWorkPushConfig;
use Asundust\WechatWorkPush\Models\WechatWorkPushUser as WechatWorkPushUserModel;
use Encore\Admin\Actions\RowAction;

class SendTestMessage extends RowAction
{
    use SendMessageTrait;

    public $name = '发送测试消息';

    /**
     * @return \Encore\Admin\Actions\Response
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function handle(WechatWorkPushUserModel $user)
    {
        if ($user->is_own_wechat_work) {
            $config = [
                'corp_id' => $user->corp_id,
                'agent_id' => $user->agent_id,
                'secret' => $user->secret,
            ];
            $type = '自定义';
        } else {
            $config = WechatWorkPushConfig::firstOrNew([]);
            if (!$config->is_complete) {
                return $this->response()->error('【默认配置】或【自定义配置】企业微信通道尚未配置');
            }
            $config = [
                'corp_id' => $config->corp_id,
                'agent_id' => $config->agent_id,
                'secret' => $config->secret,
            ];
            $type = '默认';
        }

        $title = '当前使用的【'.$type.'配置】企业微信通道发送的测试消息';
        $result = $this->send($config, $user->name, $title);
        if (0 == $result['code']) {
            return $this->response()->success('使用【'.$type.'配置】企业微信通道发送消息成功');
        }

        return $this->response()->success('使用【'.$type.'配置】企业微信通道发送消息失败：'.$result['message']);
    }
}
