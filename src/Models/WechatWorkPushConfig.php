<?php

namespace Asundust\WechatWorkPush\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Asundust\WechatWorkPush\Models\WechatWorkPushConfig
 *
 * @property int $id
 * @property string|null $corp_id 企业ID
 * @property string|null $agent_id 应用ID/agent_id
 * @property string|null $secret 应用Secret
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read bool $is_complete
 * @method static \Illuminate\Database\Eloquent\Builder|\Asundust\WechatWorkPush\Models\WechatWorkPushConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Asundust\WechatWorkPush\Models\WechatWorkPushConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Asundust\WechatWorkPush\Models\WechatWorkPushConfig query()
 * @mixin \Eloquent
 */
class WechatWorkPushConfig extends Model
{
    protected $fillable = ['corp_id', 'agent_id', 'secret'];

    /**
     * Settings constructor.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('admin.database.connection') ?: config('database.default'));

        $this->setTable(config('admin.extensions.wechat-work-push.config_table', 'wechat_work_push_configs'));
    }

    // is_complete
    public function getIsCompleteAttribute(): bool
    {
        return $this->corp_id && $this->agent_id && $this->secret;
    }
}
