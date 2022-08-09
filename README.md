Laravel-Admin 消息推送插件 by 企业微信应用消息
======
> 无需公众号，不需要安装企业微信客户端，低成本推送消息解决方案

> 另有 [Dcat-Admin版](https://github.com/asundust/dcat-wechat-work-push)

![StyleCI build status](https://github.styleci.io/repos/337583331/shield)
<a href="https://packagist.org/packages/asundust/wechat-work-push"><img src="https://img.shields.io/packagist/dt/asundust/wechat-work-push" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/asundust/wechat-work-push"><img src="https://img.shields.io/packagist/v/asundust/wechat-work-push" alt="Latest Stable Version"></a>

## 前言

灵感启发Server酱，这边只是一个简单的实现。

## 客户端支持

- Laravel版 [https://github.com/asundust/push-laravel](https://github.com/asundust/push-laravel)

## 功能介绍

目前版本支持灵活设置

- 支持入参标题、内容、链接、链接标题
- 一个【企业微信应用】的消息可推送【单个账号/全部人员】）
- 【单个账号/全部人员】可设置独立的【企业微信应用】配置

另外

- 目前版本不支持内容文本markdown等格式，仅支持简单文本，后期开发
- 目前版本无日志功能，后期开发

## 截图

- 能直接在通知里看到消息内容

![通知效果](https://user-images.githubusercontent.com/6573979/107605606-a4adfb80-6c6e-11eb-9f71-66309bc41c1e.png)

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

![申请企业微信](https://user-images.githubusercontent.com/6573979/107605784-230a9d80-6c6f-11eb-87b0-b5ca2119ca2f.png)

- 注册成功后，点【管理企业】进入管理界面，选择【[应用管理](https://work.weixin.qq.com/wework_admin/frame#apps)】-【自建】-【创建应用】。

![创建应用](https://user-images.githubusercontent.com/6573979/107605802-3453aa00-6c6f-11eb-94de-97b5044bd09d.png)

- 应用名称自行想一个，图片Logo自行上传一个，可见范围选择公司名。

![填写信息](https://user-images.githubusercontent.com/6573979/107605804-3584d700-6c6f-11eb-9238-ec9e16985334.png)

- 创建好后复制【AgentId】和【Secret】出来到网站后台的【企业微信应用消息】-【默认配置】填写对应的那一栏上。

- 进入【[我的企业](https://work.weixin.qq.com/wework_admin/frame#profile)】页面，拉到最下边，可以看到企业ID，复制并填到对应那一栏上，记得保存。

![企业ID](https://user-images.githubusercontent.com/6573979/107605805-3584d700-6c6f-11eb-8a30-cabfc306ea33.png)

- 如果是用户自定义企业记得是编辑用户填入对应的三栏里。

- 在列表可以发送测试消息，如果企业微信接收到了消息就成功了。

- 进入【我的企业】-【[微信插件](https://work.weixin.qq.com/wework_admin/frame#profile/wxPlugin)】，
  拉到下边扫描二维码，关注以后即可收到推送的消息（可能需要先下载一次企业微信绑定一下微信），此时企业微信和微信应该能同时收到消息。

![二维码](https://user-images.githubusercontent.com/6573979/107605807-361d6d80-6c6f-11eb-9f97-96da63a5741a.png)

> 设置企业微信不接收消息，微信接收消息。
>
> 【企业微信】-【我】-【设置】-【新消息通知】-【仅在企业微信中接收消息】-【应用消息】关闭
>
> 如果有多个企业身份，【企业微信】-【我】-【设置】-【新消息通知】-【其他企业消息提醒】-选择神申请的企业名字改成【仅接收特别提醒的消息】或者【不提醒】-然后切换回自己常用的企业消息。
>
> 然后去发送测试通知，应该没什么问题。
>
> 这边关于消息通知的设置教程有误，如有问题请联系我。

> 如果遇到问题的话可以到刚刚创建的应用里发个测试消息（选择【[应用管理](https://work.weixin.qq.com/wework_admin/frame#apps)】-【自建】-【应用名称】-【功能】-【发送消息】）。

> 另外如果出现接口请求正常，企业微信接受消息正常，个人微信无法收到消息的情况
>
> 进入【我的企业】-【[微信插件](https://work.weixin.qq.com/wework_admin/frame#profile/wxPlugin)】，拉到最下方，勾选【允许成员在微信插件中接收和回复聊天消息 】
>
> 另外检查一下上述的【仅在企业微信中接收消息】相关设置

## 使用

- 默认路由支持`get`和`post`，记得在`VerifyCsrfToken`里的`except`添加`push/*`，以便支持`post`接口请求。

- 接口地址为`http://{www.abc.com}/push/{推送密钥}`，标题为`title`不可空，内容为`content`可不传，链接为`url`可不传，链接标题为`url_title`可不传。 示例：`get`
  地址为`http://{www.abc.com}/push/我是密钥?title=测试标题&content=测试内容&url=https://www.baidu.com&url_title=我是百度的测试链接`

- 传入不合法的`url`可能会导致发送请求超时，不知为何，建议自行测试。

## 内部调用支持

- 引用此Trait类`\Asundust\WechatWorkPush\Http\Traits\WechatWorkPushSendMessageTrait`。
- 使用默认配置发送`defaultSend()`，使用自定配置发送`send()`，具体入参看方法。

## 支持

如果觉得这个项目帮你节约了时间，不妨支持一下呗！

![alipay](https://user-images.githubusercontent.com/6573979/91679916-2c4df500-eb7c-11ea-98a7-ab740ddda77d.png)
![wechat](https://user-images.githubusercontent.com/6573979/91679913-2b1cc800-eb7c-11ea-8915-eb0eced94aee.png)

## License

[The MIT License (MIT)](https://opensource.org/licenses/MIT)