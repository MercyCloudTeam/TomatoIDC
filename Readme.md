# TomatoIDC虚拟主机销售系统

![GPL3.0](https://badgen.net/badge/License/GPL-3.0/blue?icon=github)![PHP](https://badgen.net/badge/PHP/7.1.3+/orange)![Verison](https://badgen.net/badge/Verison/V0.1.0/cyan)![PHP](https://badgen.net/badge/版本/测试版/red)

[简体中文](https://github.com/MercyCloudTeam/TomatoIDC/blob/master/Readme.md)

[Github](https://github.com/MercyCloudTeam/TomatoIDC/) | [Coding](https://dev.tencent.com/u/Franary/p/TomatoIDC/git) | [Gitee](https://gitee.com/MercyCloud/TomatoIDC) | [交流论坛](https://dev.fanqieui.com) 

## 介绍



### 特性

- 易于使用

  - 界面清新
  - 可视化管理界面

- 可扩展

  - 支持（支付，服务器，功能）插件
  - 支持更换模版

- 人性化

  - Gravatar头像


### 简介

TomatoIDC是一款以[GPL3.0](https://opensource.org/licenses/gpl-3.0.html)协议开源虚拟主机销售系统，具备易于扩展的插件系统，模版系统，使用强大的Laravel框架进行驱动，能帮助你轻松的扩展虚拟主机销售业务。



### 版本



目前版本V0.1.0只完成了基础功能，较多功能还在开放当中，目前版本为测试版，但是使用是完全没有问题的，更新改动可能较大。



### 演示站

[默认](https://dev.moe.beer/)



## 安装



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
#初始化程序密匙
php artisan key:g
#访问安装页面完成安装
https://domain/install
```



#### 压缩包安装

```	shell
#下载并解压压缩包

#编辑配置文件（填写数据库部分即可）
vi .env
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
5. 运行php artisan key:g 生成加密密匙
6. 设置网站目录 运行目录设置为/public
7. 设置伪静态（Apache基本不用配置即可使用）
8. 访问 https://domain/install 进行最后安装



## 功能



### 支付

目前暂未完成支付宝/微信官方支付插件（可以参考其他支付插件，改写一下即可使用），但拥有其他免签支付插件

更多支付方式，请自行进行支付插件开发



预计更新：下版本将支持卡密充值帐户余额



### 服务器面板

当前支持的服务器管理面板

- [Easypanel ](https://www.kanglesoft.com/)



### TODO

- 服务器
  - 服务器组
  - 售卖VPS
  - ~~售卖Shadowsocks~~
- 支付
  - 充值卡
  - 支付宝微信官方支付
- 用户
  - aff推广
- 优惠卷
- 更好的插件系统



## 本项目



### PRO版计划？

我们暂无Pro版计划，我们可能会推出技术支持插件定制开发的，但如果是兼容面板，支付，我们会一步步进行开发，大家可以通过论坛或者交流群内提出



### 功能开发

欢迎在我们的论坛里提出，如果越多人需要我们将会越快更新！



### 更新记录

- V0.1.0  🎉 发布第一个开源版本，可以拿来正式使用-2018-11-23日 现已发布



### 问题报告

请提交issue/官方群讨论

如果存在安全问题请私聊我萌~~（但是我们没钱奖励你，SRC？不存在的）~~



### 文档

施工中🚧

可到官方群里提问



### 官方群

<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=5bcf211d7faaafa83e0253d93be8d3813acebafcb24d4eb013d1e3ae9b015383"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="TomatoIDC交流群" title="TomatoIDC交流群"></a>



### 废话

本项目刚刚起步，需要大家的支持，如果大家想从其他主机销售系统转过来，需要什么功能欢迎提出来~~（挖墙脚）~~ 



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



### 版权

TomatoIDC 是基于 GNU General Public License version 3 开放源代码的自由软件，你可以遵照 GPLv3 协议来修改或重新发布本程序。

**例外情况**：插件在未使用 TomatoIDC 程序源代码的情况下，无须采用GPL3.0协议，无须强制开放插件源代码



### 感谢

[Laravel](https://laravel.com/)

[CreativeTim](https://www.creative-tim.com/)

[printempw](https://blessing.studio/)

[番茄UI](https://www.fanqieui.com)

[MercyCloudTeam](https://mercycloud.com)
