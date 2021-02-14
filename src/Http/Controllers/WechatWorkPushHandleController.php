<?php

namespace Asundust\WechatWorkPush\Http\Controllers;

use Asundust\WechatWorkPush\Http\Traits\SendMessageTrait;
use Asundust\WechatWorkPush\Models\WechatWorkPushConfig;
use Asundust\WechatWorkPush\Models\WechatWorkPushUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WechatWorkPushHandleController extends Controller
{
    use SendMessageTrait;

    /**
     * @param $secret
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function push($secret, Request $request): array
    {
        $title = $request->input('title');
        $content = $request->input('content');
        if (!$title) {
            return ['code' => 1, 'message' => '消息标题为空'];
        }

        $user = WechatWorkPushUser::where('sc_secret', $secret)
            ->where('status', 1)
            ->first();

        if ($user) {
            if ($user->is_own_wechat_work) {
                $config = [
                    'corp_id' => $user->corp_id,
                    'agent_id' => $user->agent_id,
                    'secret' => $user->secret,
                ];
            } else {
                $config = WechatWorkPushConfig::firstOrNew([]);
                if (!$config->is_complete) {
                    return ['code' => 1, 'message' => '系统配置错误'];
                }
                $config = [
                    'corp_id' => $config->corp_id,
                    'agent_id' => $config->agent_id,
                    'secret' => $config->secret,
                ];
            }
            return $this->send($config, $user->name, $title, $content);
        }

        return ['code' => 1, 'message' => 'secret验证失败'];
    }
}
