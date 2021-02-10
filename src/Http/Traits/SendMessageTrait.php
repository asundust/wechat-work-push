<?php

namespace Asundust\WechatWorkPush\Http\Traits;

use EasyWeChat\Factory;

trait SendMessageTrait
{
    /**
     * @param array       $config
     * @param string      $name
     * @param string      $title
     * @param string|null $content
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function send(array $config, string $name, string $title, ?string $content = null)
    {
        $message = $title;
        if ($content) {
            $message .= "\n\n" . $content;
        }
        $messenger = Factory::work($config)->messenger;
        $result = $messenger->ofAgent($config['agent_id'])->message($message)->toUser($name ?? '@all')->send();
        if ($result['errcode'] == 0 && $result['errmsg'] == 'ok') {
            return ['code' => 0, 'message' => 'success', 'original' => app()->isLocal() ? $result : []];
        }
        return ['code' => 1, 'message' => $result['errmsg'], 'original' => app()->isLocal() ? $result : []];
    }
}