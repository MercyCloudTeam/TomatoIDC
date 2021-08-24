# TomatoIDC虚拟主机销售系统

![MIT](https://badgen.net/badge/License/MIT/blue?icon=github)![PHP](https://badgen.net/badge/PHP/7.1.3+/orange)![Verison](https://badgen.net/badge/Verison/V0.1.8/cyan)![PHP](https://badgen.net/badge/版本/测试版/red)

语言: [简体中文](https://github.com/MercyCloudTeam/TomatoIDC/blob/master/Readme.md) | 

导航: [Github](https://github.com/MercyCloudTeam/TomatoIDC/) | [Coding](https://dev.tencent.com/u/Franary/p/TomatoIDC/git) | [Gitee](https://gitee.com/MercyCloud/TomatoIDC)  | [Telegram](https://t.me/joinchat/LS-kqxSAs2QI-uYZTThRxg) | [QQ群](http://shang.qq.com/wpa/qunwpa?idkey=5bcf211d7faaafa83e0253d93be8d3813acebafcb24d4eb013d1e3ae9b015383)

### 该分支V0.1系列的最终分支，可进行二次开发，部分功能已经完善。该分支不再进行后续维护。

## 介绍

非常抱歉咕咕咕了那么久。

项目后续可能会更改名称，以及进行大改。

许可证已从GPL3.0更改为MIT

感谢你们的支持。

若追求商业运营请选择WHMCS

目前还在更改以及测试，发布时间待定
如果有建议请去QQ或TG或ISSUE提出，如果想要一起开发请发送邮件或私聊我

### 特性

- 易于使用

  - 界面清新
  - 可视化管理界面

- 可扩展

  - 支持（支付，服务器，功能）插件
  - 支持多种模版
  - 支持SPA模板

- 功能强大

  - 支持卡密充值
  - 支持多种支付方式
  - 支持接入微信公众号（账户绑定，查询余额）

- 人性化

  - Gravatar头像
  - 微信公众号提醒
  - 邮件提醒



### 简介

TomatoIDC是一款以MIT协议开源虚拟主机销售系统，具备易于扩展的插件系统，模版系统，使用强大的Laravel框架进行驱动，能帮助你轻松的扩展虚拟主机销售业务。


### 版本

目前版本V0.1.8 较多功能还在开放当中，目前版本为测试版，但是使用是完全没有问题的，更新改动可能较大。

## 安装



#### 环境需求

- 一台支持 URL 重写的主机，Nginx、Apache 或 IIS
- **PHP >= 7.1.3** 
- Composer（如果没有请本地克隆安装好扩展再打包上传服务器）
- 安装并启用如下 PHP 扩展：
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - GD
  - XML
  - Ctype
  - JSON
  - **fileinfo**

删除 PHP 函数限制（常见错误解决）

```
passthru
proc_open
proc_get_status
```



#### Git

安装V0.1.8以前

```shell
#克隆代码（国内用户可选Coding/Gitee）
git clone --depth=1  https://github.com/MercyCloudTeam/TomatoIDC.git;
#移动到目录
cd TomatoIDC;
#编辑配置文件,编辑数据库连接部分即可
cp .env.example .env
vi .env
#依赖安装
composer install --no-dev
#完成数据库迁移
php artisan migrate
#初始化程序密匙
php artisan key:g
#访问安装页面完成安装
https://domain/install
```

V0.1.8以及以后

```bash
#克隆代码（国内用户可选Coding/Gitee）
git clone --depth=1  https://github.com/MercyCloudTeam/TomatoIDC.git;
#移动到目录
cd TomatoIDC;
#依赖安装
composer install --no-dev
#复制.env.example
cp .env.example .env
#访问安装页面完成安装
https://domain/install
```



#### 压缩包安装

安装V0.1.8以前

```	shell
#下载并解压压缩包
🚧压缩包服务器找不到啦
#编辑配置文件（填写数据库部分即可）
vi .env
#完成数据库迁移
php artisan migrate
#初始化程序密匙
php artisan key:g
#访问安装页面完成安装
https://domain/install
```

V0.1.8以后

```shell
#下载并解压压缩包
🚧压缩包服务器找不到啦
#配置运行目录，伪静态，复制.env.example 成.env
#访问安装页面完成安装
https://domain/install
```



#### Web 服务器配置 - 伪静态（优雅链接）

**Apache**
TomatoIDC 使用 public/.htaccess 文件来为前端控制器提供了隐藏 index.php 的优雅链接. TomatoIDC 使用 Apache 作为服务器，请务必启用 mod_rewrite 模块 让服务器能够支持 .htaccess 的解析。

如果 TomatoIDC 附带的 .htaccess 文件不起作用，尝试下面的方法替代:

```
Options +FollowSymLinks -Indexes
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

**Nginx**
如果你使用 Nginx 服务器，在你的站点配置中加入以下内容，它将会将所有请求引导到 index.php 前端控制器中：

```
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```



#### 宝塔面板安装步骤（时间约3分钟）

1. 添加站点
2. 上传代码（GIT克隆 /压缩包 二选一）
3. composer install安装依赖（压缩包安装跳过）
4. 复制.env.example 成.env

(V0.1.8之前版本请进行下面三步)

1. 配置.env文件
2. 运行php artisan migrate 完成数据库迁移
3. 运行php artisan key:g 生成加密密匙



5. 设置网站目录 运行目录设置为/public
6. 设置伪静态（Apache基本不用配置即可使用）
7. 访问 https://domain/install 进行最后安装


## 功能



### 支付

- 有赞云支付
- 微信官方支付
- 支付宝官方（未测试，如果有人可以提供Key测试一下就好了）
- 卡密充值
- 番茄云支付
- 码支付（未测试）

更多支付方式，请自行进行支付插件开发

### 邮件发送

- SMTP

### 短信验证码

- 施工中🚧

### 服务器面板

当前支持的服务器管理面板

- [Easypanel ](https://www.kanglesoft.com/)
- [Cpanel](https://cpanel.net)
- [DirectAdmin](https://www.directadmin.com/)
- [SolusVM](https://solusvm.com/)
- [VestaCP](https://vestacp.com/)
- [CyberPanel](https://cyberpanel.net/)
- [SwapIDC](http://www.swapidc.cn/)

### 微信公众号

- 绑定账号
- 机器人自动回复（查询余额）



### TODO

- 服务器
  - 服务器组
  - 售卖VPS
  - 服务器插件
  - ~~售卖Shadowsocks~~（考虑到ss长久不更新可能会做V2ray）
- 用户

  - aff推广
- 优惠卷
- 文档完善
- 教程完善
- 用户等级
- 第三方文件存储
- 多周期付费




### 模板

- default(Argon源自[CreativeTim](https://www.creative-tim.com/))
- SPA支持



## 本项目



### 更新记录

- V0.1.0  🎉 发布第一个开源版本，可以拿来正式使用-2018-11-23日 现已发布
- V0.1.1 添加依赖（软件大小提升）卡密，用户充值，请参考[论坛](https://dev.fanqieui.com/d/7-tomatoidc-v0-1-1) (更新预计需要10分钟)减少了一个BUG并新增了N个BUG
- V0.1.2 添加对mariadb支持 （未测试），表结构更改，添加微信官方支付， 有赞云支付【支付宝官方（未测试）】，移除BLK模版，更新界面[详见](https://dev.fanqieui.com/d/10-tomatoidc-v0-1-2)
- V0.1.3 设置项列表更改，添加邮件设置,添加注册邮件验证，购买，开通邮件发送,优化安装体验,添加无服务器插件,修复了一些bug又添加了很多bug
- V0.1.4 添加微信公众号支持，可以绑定账户，查询余额
- V0.1.5 添加Cpanel插件，工单可选优先级以及商品，商品功能添加库存
- V0.1.6 添加SolusVM DirectAdmin支持 添加Log-viewer，添加了一些Bug
- V0.1.7 添加Vesta CyberPanel支持，多个服务器插件支持一键登录，重置主机密码，释放永久删除主机，码支付未测试
- V0.1.8 开通主机可改为异步，费用计算改动，添加Swapidc分销，安装简化，以及添加了很多未发现的特性（bug）



### 问题报告

请提交issue/官方群讨论

如果存在安全问题请私聊~~（但是没钱奖励，SRC？不存在的）~~



### 文档

施工中🚧

可到官方群里提问



### 官方群

<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=5bcf211d7faaafa83e0253d93be8d3813acebafcb24d4eb013d1e3ae9b015383"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="TomatoIDC交流群" title="TomatoIDC交流群"></a>

群号：927933095

[Telegram](https://t.me/MercyCloudNetwork)



### 求支持

不要脸的求支持，觉得这个项目不错的大家可以点一下右上角的小星星，有什么问题去论坛，群，GITHUB我都会看的．也会回复的


#### 服务器推荐

>以下为我目前使用的服务器，仅代表个人。推广链接可领优惠卷

[Aliyun](https://promotion.aliyun.com/ntms/yunparter/invite.html?userCode=rdnyjbu6)


### 版权

TomatoIDC 是基于 MIT 开放源代码的自由软件，你可以遵照 MIT 协议来修改或重新发布本程序。




### 感谢

[Laravel](https://laravel.com/)   [Laravel-China](https://laravel-china.org/)  [CreativeTim](https://www.creative-tim.com/)  [printempw](https://blessing.studio/)  [番茄UI](https://www.fanqieui.com)  [MercyCloudTeam](https://mercycloud.com)  [Hostloc](https://www.hostloc.com)  [魔王](http://idc.la) [Overtrue](https://github.com/overtrue)  [Jcyt](s.iyt.li)
