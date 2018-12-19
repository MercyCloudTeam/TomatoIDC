# TomatoIDC虚拟主机销售系统

![GPL3.0](https://badgen.net/badge/License/GPL-3.0/blue?icon=github)![PHP](https://badgen.net/badge/PHP/7.1.3+/orange)![Verison](https://badgen.net/badge/Verison/V0.1.6/cyan)![PHP](https://badgen.net/badge/版本/测试版/red)

语言: [简体中文](https://github.com/MercyCloudTeam/TomatoIDC/blob/master/Readme.md) | 

导航: [Github](https://github.com/MercyCloudTeam/TomatoIDC/) | [Coding](https://dev.tencent.com/u/Franary/p/TomatoIDC/git) | [Gitee](https://gitee.com/MercyCloud/TomatoIDC) | [交流论坛](https://dev.fanqieui.com) |[🚧官方文档](https://www.yuque.com/mercycloud/eg1gz6) | [Telegram](https://t.me/joinchat/LS-kqxSAs2QI-uYZTThRxg) | [QQ群](http//shang.qq.com/wpa/qunwpa?idkey=5bcf211d7faaafa83e0253d93be8d3813acebafcb24d4eb013d1e3ae9b015383)

## 介绍



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

TomatoIDC是一款以[GPL3.0](https://opensource.org/licenses/gpl-3.0.html)协议开源虚拟主机销售系统，具备易于扩展的插件系统，模版系统，使用强大的Laravel框架进行驱动，能帮助你轻松的扩展虚拟主机销售业务。



### 版本



目前版本V0.1.5 较多功能还在开放当中，目前版本为测试版，但是使用是完全没有问题的，更新改动可能较大。

关于框架版本：框架采用laravel最新版本



### 演示站

[演示站-1](https://dev.moe.beer/)

[演示站-2](https://demo.tomatoidc.com)

> 都还没什么人的项目，建个演示站都要被人打:(

会不定期清空数据库，不建议往里面冲钱:)

欢迎大家搭建一下w来给新人玩耍

（可以到知识星球或者直接转给我）





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



#### Git安装

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



#### 压缩包安装

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
3. 配置.env文件
4. 安装依赖（压缩包安装跳过）
5. 运行php artisan migrate 完成数据库迁移
6. 运行php artisan key:g 生成加密密匙
7. 设置网站目录 运行目录设置为/public
8. 设置伪静态（Apache基本不用配置即可使用）
9. 访问 https://domain/install 进行最后安装



## 功能



### 支付

- 有赞云支付
- 微信官方支付
- 支付宝官方（未测试，如果有人可以提供Key测试一下就好了）
- 卡密充值
- 番茄云支付

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

- 阿里云OSS文件存储




### 模板

- default(Argon源自[CreativeTim](https://www.creative-tim.com/))
- SPA支持



## 本项目



### PRO版计划？

我们暂无Pro版计划，我们可能会推出技术支持插件定制开发的，但如果是兼容面板，支付，我们会一步步进行开发，大家可以通过[交流论坛](https://dev.fanqieui.com)或者[交流群](https://shang.qq.com/wpa/qunwpa?idkey=5bcf211d7faaafa83e0253d93be8d3813acebafcb24d4eb013d1e3ae9b015383)内提出



### 功能开发

欢迎在我们的[交流论坛](https://dev.fanqieui.com)里提出，如果越多人需要我们将会越快更新！



### 更新记录

- V0.1.0  🎉 发布第一个开源版本，可以拿来正式使用-2018-11-23日 现已发布
- V0.1.1 添加依赖（软件大小提升）卡密，用户充值，请参考[论坛](https://dev.fanqieui.com/d/7-tomatoidc-v0-1-1) (更新预计需要10分钟)减少了一个BUG并新增了N个BUG
- V0.1.2 添加对mariadb支持 （未测试），表结构更改，添加微信官方支付， 有赞云支付【支付宝官方（未测试）】，移除BLK模版，更新界面[详见](https://dev.fanqieui.com/d/10-tomatoidc-v0-1-2)
- V0.1.3 设置项列表更改，添加邮件设置,添加注册邮件验证，购买，开通邮件发送,优化安装体验,添加无服务器插件,修复了一些bug又添加了很多bug
- V0.1.4 添加微信公众号支持，可以绑定账户，查询余额
- V0.1.5 添加Cpanel插件，工单可选优先级以及商品，商品功能添加库存
- V0.1.6 添加SolusVM DirectAdmin支持 添加Log-viewer，添加了一些Bug



### 问题报告

请提交issue/官方群讨论

也可以提交到[交流论坛](https://dev.fanqieui.com)

如果存在安全问题请私聊我萌~~（但是我们没钱奖励你，SRC？不存在的）~~



### 文档

施工中🚧

可到官方群里提问



### 官方群

<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=5bcf211d7faaafa83e0253d93be8d3813acebafcb24d4eb013d1e3ae9b015383"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="TomatoIDC交流群" title="TomatoIDC交流群"></a>

群号：927933095

[Telegram](https://t.me/joinchat/LS-kqxSAs2QI-uYZTThRxg)



### 求支持

不要脸的求支持，觉得这个项目不错的大家可以点一下右上角的小星星，有什么问题去论坛，群，GITHUB我都会看的．也会回复的



也欢迎大家打赏我进知识星球MercyCloudTeam(可以白嫖主机等东西)

里面可以看到我疯狂挖的新坑，以及一些好玩的BUG，以及一些先行的源代码

[知识星球二维码](https://sz.ali.ftc.red/ftc/2018/11/27/image_822582455182_4.jpg)



#### 服务器推荐

>以下为我目前使用的服务器，仅代表个人。推广链接可领优惠卷

[Aliyun](https://promotion.aliyun.com/ntms/yunparter/invite.html?userCode=rdnyjbu6)

[Vultr](https://www.vultr.com/?ref=7244417) 



#### TomatoProject

> 在TomatoIDC的V0.1.2开发中，决定将其规划为TomatoProject，将会有一系列开源项目，欢迎大家支持



### 废话

本项目刚刚起步，需要大家的支持(一颗小星星就可以了)，如果大家想从其他主机销售系统转过来，需要什么功能欢迎提出来 ~~挖墙脚~~  

```


{\__/}
( • . •)
/ >🖥 我们的项目

{\__/}
( • . •)
/ >🐘 使用最好的PHP语言

{\__/}
( • - •)
/ >🐘🐘 采用面向对象编程

{\__/}
( • - •)
/ >🌹 选用优雅的Laravel框架

{\__/}
( • - •)
/ >🆓 还是开源免费使用

{\__/}
( • - •)
/ >👫 还有性感开发者们，在线PHP

{\__/}
( • - •)
/ > 🛒 快来开启你的主机商之旅吧


```

### 版权

TomatoIDC 是基于 GNU General Public License version 3 开放源代码的自由软件，你可以遵照 GPLv3 协议来修改或重新发布本程序。

**例外情况**：插件在未使用 TomatoIDC 程序源代码的情况下，无须采用GPL3.0协议，无须强制开放插件源代码



### 感谢

[Laravel](https://laravel.com/)   [Laravel-China](https://laravel-china.org/)  [CreativeTim](https://www.creative-tim.com/)  [printempw](https://blessing.studio/)  [番茄UI](https://www.fanqieui.com)  [MercyCloudTeam](https://mercycloud.com)  [Hostloc](https://www.hostloc.com)  [魔王](http://idc.la) [Overtrue](https://github.com/overtrue)