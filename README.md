Laravel-Admin 消息推送插件 by 企业微信应用消息
======
> 无需公众号，不需要安装企业微信客户端，低成本推送消息解决方案

![StyleCI build status](https://github.styleci.io/repos/337583331/shield) 

<a href="https://packagist.org/packages/asundust/wechat-work-push"><img src="https://img.shields.io/packagist/dt/asundust/wechat-work-push" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/asundust/wechat-work-push"><img src="https://img.shields.io/packagist/v/asundust/wechat-work-push" alt="Latest Stable Version"></a>

## 前言

灵感启发Server酱，这边只是一个简单的实现。

## 功能介绍

目前版本支持灵活设置

- 一个【企业微信应用】的消息可推送【单个账号/全部人员】）
- 【单个账号/全部人员】可设置独立的【企业微信应用】配置

另外

- 目前版本不支持内容文本markdown等格式，仅支持简单文本，后期开发
- 目前版本无日志功能，后期开发

## 截图

- todo

## 安装

### 安装

```
composer require asundust/wechat-work-push
```

### 配置文件

```
'wechat-work-push' => [
    'enable' => true,
    // 'config_table' => 'wechat_work_push_configs', // 自定义配置表表名，可不填写，默认wechat_work_push_configs
    // 'user_table' => 'wechat_work_push_users', // 自定义用户表表名，可不填写，默认wechat_work_push_users
    // 'middleware' => 'web', // 自定义中间件组，可不填写，默认web
],
```

### 迁移

```
php artisan migrate
```

### 发布菜单

```
php artisan admin:import wechat-work-push
```

会生成如下的菜单

- 企业微信消息推送
- └用户配置
- └默认配置

## 配置

### 大致流程

- 在企业微信注册一个企业（无需企业认证）
- 创建一个内部应用
- 配置相关配置
- 开启微信插件
- 在微信里收到消息

### 申请流程

- 申请企业微信[https://work.weixin.qq.com/](https://work.weixin.qq.com/)

- 注册成功后，点【管理企业】进入管理界面，选择【应用管理】-【自建】-【创建应用】。

- 应用名称自行想一个，图片Logo自行上传一个，可见范围选择公司名。

- 创建好后复制【AgentId】和【Secret】出来到网站后台的【企业微信应用消息】-【默认配置】填写对应的那一栏上。

- 进入【我的企业】页面，拉到最下边，可以看到企业ID，复制并填到对应那一栏上，记得保存。

- 如果是用户自定义企业记得是编辑用户填入对应的三栏里。

- 进入【我的企业】-【微信插件】，拉到下边扫描二维码，关注以后即可收到推送的消息（可能需要先下载一次企业微信绑定一下微信）。

- 在列表可以发送测试消息，如果微信接收到了就成功了。

- 如果遇到问题的话可以到刚刚创建的应用里发个测试消息（选择【应用管理】-【自建】-【应用名称】-【功能】-【发送消息】）。

## 使用

- 默认路由支持`get`和`post`，记得在`VerifyCsrfToken`里的`except`添加`push/*`，以便支持`post`接口请求。

- 接口地址为`http://{www.abc.com}/push/{推送密钥}`，标题为`title`不可控，内容为`content`可不传。 示例：`get`
  地址为`http://{www.abc.com}/push/secretSecret?title=测试标题&content=测试内容`

## 内部调用支持

- 引用此Trait类`\Asundust\WechatWorkPush\Http\Traits\SendMessageTrait`。
- 使用默认配置发送`defaultSend()`，使用自定配置发送`send()`，具体入参看方法。