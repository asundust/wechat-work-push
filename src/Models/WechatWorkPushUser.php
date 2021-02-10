<?php

namespace Asundust\WechatWorkPush\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Asundust\WechatWorkPush\Models\WechatWorkPushUser
 *
 * @property int         $id
 * @property string      $name        用户的账户
 * @property string      $sc_secret   用户的推送密钥
 * @property int         $status      状态(0禁用1启用)
 * @property string|null $corp_id     用户自定企业ID
 * @property string|null $agent_id    用户自定应用ID/agent_id
 * @property string|null $secret      用户自定应用Secret
 * @property-read bool   $is_own_wechat_work
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin Eloquent
 */
class WechatWorkPushUser extends Model
{
    protected $fillable = ['name', 'sc_secret', 'status', 'corp_id', 'agent_id', 'secret'];

    const STATES = [
        0 => '禁用',
        1 => '启用',
    ];

    const IS_OWN_WECHAT_WORK = [
        0 => '否',
        1 => '是',
    ];

    const STATES_SWITCH = [
        'on' => ['value' => 1, 'text' => '启用', 'color' => 'success'],
        'off' => ['value' => 0, 'text' => '禁用', 'color' => 'danger'],
    ];

    /**
     * Settings constructor.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('admin.database.connection') ?: config('database.default'));

        $this->setTable(config('admin.extensions.wechat-work-push.user_table', 'wechat_work_push_users'));
    }

    // is_own_wechat_work
    public function getIsOwnWechatWorkAttribute(): bool
    {
        return $this->corp_id && $this->agent_id && $this->secret;
    }
}
