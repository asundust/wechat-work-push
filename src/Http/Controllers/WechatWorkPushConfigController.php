<?php

namespace Asundust\WechatWorkPush\Http\Controllers;

use Asundust\WechatWorkPush\Models\WechatWorkPushConfig;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WechatWorkPushConfigController extends Controller
{
    /**
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title('企业微信应用消息')
            ->description('默认配置')
            ->row(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('wechatWorkPushConfig'));
                    $config = WechatWorkPushConfig::firstOrNew([]);
                    $form->text('corp_id', '默认企业ID')->default($config->corp_id)->rules('required');
                    $form->text('agent_id', '默认应用ID/agent_id')->default($config->agent_id)->rules('required');
                    $form->password('secret', '默认应用Secret')->default($config->secret)->rules('required');
                    $column->append((new Box(trans('admin.edit'), $form))->style('success'));
                });
            });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $data = [
            'corp_id' => $request->input('corp_id'),
            'agent_id' => $request->input('agent_id'),
            'secret' => $request->input('secret'),
        ];
        foreach ($data as $value) {
            if (!$value) {
                admin_toastr('请填写完整配置', 'error');
                return back()->withInput();
            }
        }

        $config = WechatWorkPushConfig::firstOrNew([]);
        $config->fill($data)->save();

        admin_toastr('保存成功');
        return redirect(admin_url('wechatWorkPushConfig'));
    }
}