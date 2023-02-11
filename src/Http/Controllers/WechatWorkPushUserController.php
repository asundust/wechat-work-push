<?php

namespace Asundust\WechatWorkPush\Http\Controllers;

use Asundust\WechatWorkPush\Http\Actions\SendTestMessage;
use Asundust\WechatWorkPush\Models\WechatWorkPushUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Grid\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WechatWorkPushUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '企业微信应用消息用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        $grid = new Grid(new WechatWorkPushUser());

        $grid->column('id', '序号');
        $grid->column('name', '推送账号')->copyable();
        $grid->column('sc_secret', '推送密钥')->display(function () {
            return '***';
        })->copyable();
        $grid->column('api_address', '推送Api地址')->display(function () {
            /* @var WechatWorkPushUser $this */
            return $this->api_address_show;
        })->copyable();
        $grid->column('status', '账号状态')->switch(WechatWorkPushUser::STATES_SWITCH);
        $grid->column('is_own_wechat_work', '自定企业微信')->bool();
        $grid->column('created_at', '创建时间')->display(function ($createdAt) {
            return date('Y-m-d H:i:s', strtotime($createdAt));
        });
        $grid->column('updated_at', '更新时间')->display(function ($updatedAt) {
            return date('Y-m-d H:i:s', strtotime($updatedAt));
        });

        $grid->filter(function (Filter $filter) {
            $filter->expand();
            $filter->disableIdFilter();
            $filter->column(6, function (Filter $filter) {
                $filter->equal('status', '账号状态')
                    ->radio(array_merge(['' => '全部'], WechatWorkPushUser::STATES));
                $filter->equal('id', '序号');
                $filter->like('name', '推送账号');
            });
            $filter->column(6, function (Filter $filter) {
                $filter->where(function (Builder $builder) {
                    switch ($this->input) {
                        case 0:
                            $builder->whereNull('corp_id')
                                ->orwhereNull('agent_id')
                                ->orwhereNull('secret');
                            break;
                        case 1:
                            $builder->whereNotNull('corp_id')
                                ->whereNotNull('agent_id')
                                ->whereNotNull('secret');
                            break;
                    }
                }, '自定企业微信')
                    ->radio(array_merge(['' => '全部'], WechatWorkPushUser::IS_OWN_WECHAT_WORK));
                $filter->between('created_at', '创建时间');
                $filter->between('updated_at', '创建时间');
            });
        });

        $grid->actions(function (Actions $actions) {
            $actions->disableView();
            $actions->add(new SendTestMessage());
        });

        $grid->model()->collection(function (Collection $collection) {
            /* @var WechatWorkPushUser $user */
            foreach ($collection as $user) {
                $user['is_own_wechat_work'] = $user->is_own_wechat_work;
                $user['api_address_show'] = $user->api_address_show;
                $user['api_address'] = $user->api_address;
            }

            return $collection;
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        $form = new Form(new WechatWorkPushUser());

        $table = (new WechatWorkPushUser())->getTable();
        $form->text('name', '推送账号')
            ->rules('required')
            ->help('后台的话【通讯录】-【企业名字】-【点击账号进入详情】-【账号】；如果要发送给全部人员请填写【@all】');
        $form->text('sc_secret', '账号推送密钥')
            ->default(strtolower(Str::random(32)))
            ->rules('required')
            ->creationRules(['required', "unique:$table"])
            ->updateRules(['required', "unique:$table,sc_secret,{{id}}"])
            ->help('推送消息的唯一密钥');
        $form->switch('status', '账号状态')
            ->states(WechatWorkPushUser::STATES_SWITCH)
            ->default(1);
        $form->text('corp_id', '自定企业ID')
            ->help('推送不是走自己的企业微信可为空');
        $form->text('agent_id', '自定应用ID/agent_id')
            ->help('推送不是走自己的企业微信可为空');
        $form->password('secret', '自定应用Secret')
            ->help('推送不是走自己的企业微信可为空');

        $form->disableViewCheck();

        return $form;
    }
}
