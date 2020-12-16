http://www.ruanyifeng.com/blog/2011/05/how_to_choose_free_software_licenses.html
使用webpack模板初始化vue项目
http://vuejs-templates.github.io/webpack/

Controller中的action里面
出错了请手工调用 Illuminate\Contracts\Debug\ExceptionHandler::class -> render方法

个人(非商家)接入微信支付原理:https://pay.weixin.qq.com/wiki/doc/api/xiaowei.php?chapter=19_1

laravel joinSub()

### JWT 配置参考
#### https://tutsforweb.com/restful-api-in-laravel-56-using-jwt-authentication/


### 如果使用config:cache 那么就不能从.env里面使用env()函数取值了

-------------------------
商品关联商品类别
商品类别关联多个商品属性
https://blog.csdn.net/hunkcai/article/details/51362073
https://blog.csdn.net/xy707707/article/details/81219756

https://www.tecmint.com/install-lamp-on-centos-8/
https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-centos-8
fastcgi_pass unix:/run/php-fpm/www.sock;

单页-特殊的栏目

php artisan migrate --path=sniper/employee/database/migrations/2020_06_14_153336_create_cms_tags_table.php
php -d memory_limit=-1 /usr/local/bin/composer update
php -d memory_limit=-1 C:\composer\composer.phar

========
php7.4之下 支付宝包(easysdk) 中方法函数hex2dec报错:
vendor/alipaysdk/easysdk/php/src/Kernel/Util/AntCertificationUtil.php
if(substr($hex, 0, 2) === '0x'){
    $hex = substr($hex, 2);
}
支付宝"当面付"是可以生成二维码给用户直接扫的

---------------------------
try 使用带参数的中间来验证管理员 role:administrator

修改app\Http\Middleware\RedirectIfAuthenticated.php里面跳转到/home的代码为/ 
app\Http\Middleware\VerifyCsrfToken.php 加入微信支付宝回调排除

php artisan queue:work --queue=updateDingTalkUser

逆向 Seed 生成器 orangehill/iseed

"overtrue/laravel-wechat": "~5.0",
"jeroen-g/laravel-packager": "2.5.1",
"beyondcode/laravel-dump-server": "^1.0",

chmod -R a+w public/.cache

Laravel 5.8 Laravel-echo-server教程
https://blog.csdn.net/sym134/article/details/100569257

模板制作参考主题wpcom
--------------
https://www.swiper.com.cn/

----------------------------
mysql> SELECT * FROM `ware_product`;
+----+----------+--------------+------------------------------+--------+
| id | category | name | attributes | status |
+----+----------+--------------+------------------------------+--------+
| 1 | 329475 | 某种手机 | ["网络","颜色","存储"] | 1 |
| 2 | 131329 | 某种衣服 | ["尺码","颜色"] | 1 |
+----+----------+--------------+------------------------------+--------+
2 rows in set (0.00 sec)

mysql> SELECT * FROM `ware_item`;
+----+-----+--------+--------------+------------------------+---------+-------+--------+
| id | pid | fakeid | name | attributes | price | stock | status |
+----+-----+--------+--------------+------------------------+---------+-------+--------+
| 1 | 1 | 583701 | NULL | ["电信","白","16G"] | 1999.00 | NULL | 1 |
| 2 | 1 | 583702 | NULL | ["电信","黑","16G"] | 1999.00 | NULL | 1 |
| 3 | 1 | 583703 | 最后五台 | ["移动","黑","64G"] | 1999.00 | 5 | 1 |
| 4 | 2 | 241351 | NULL | ["M","红"] | 128.00 | NULL | 1 |
+----+-----+--------+--------------+------------------------+---------+-------+--------+
4 rows in set (0.00 sec)

----------------------
一个比较好看的后台eleAdmin
----------------------
注册模板directive控制页面内容显示是否全面
directive里面包含判断是否处于会员期内

----------------------
关于composer repositories path
https://getcomposer.org/doc/05-repositories.md#path

