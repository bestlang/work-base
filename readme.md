open /Users/lu/PhpstormProjects/bestlang/laracms

composer require bestlang/laracms

php artisan vendor:publish




Controller中的action里面
出错了请手工调用 Illuminate\Contracts\Debug\ExceptionHandler::class -> render方法



个人(非商家)接入微信支付原理:https://pay.weixin.qq.com/wiki/doc/api/xiaowei.php?chapter=19_1



laravel joinSub()




### JWT 配置参考
#### https://tutsforweb.com/restful-api-in-laravel-56-using-jwt-authentication/


### 如果使用config:cache 那么就不能从.env里面使用env()函数取值了


Uncaught RangeError: Maximum call stack size exceeded. at VueComponent.handleMouseenter

-------------------------
商品关联商品类别
商品类别关联多个商品属性
https://blog.csdn.net/hunkcai/article/details/51362073
https://blog.csdn.net/xy707707/article/details/81219756



php -d memory_limit=2048M /usr/local/bin/composer update

https://www.tecmint.com/install-lamp-on-centos-8/
https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-centos-8
fastcgi_pass unix:/run/php-fpm/www.sock;


单页-特殊的栏目



php artisan migrate --path=packages/bestlang/laracms/database/migrations/2020_06_14_153336_create_cms_tags_table.php
C:\Users\sniper\PhpProjects\sniper\sniper\employee\database\migrations\2020_09_11_150535_create_sniper_employee_education_table.php
php -d memory_limit=-1 /usr/local/bin/composer update
php -d memory_limit=-1 C:\composer\composer.phar update


========
php7.4之下 支付宝包(easysdk) 中方法函数hex2dec报错:
vendor/alipaysdk/easysdk/php/src/Kernel/Util/AntCertificationUtil.php
if(substr($hex, 0, 2) === '0x'){
    $hex = substr($hex, 2);
}
支付宝"当面付"是可以生成二维码给用户直接扫的

---------------------------
官网参照: 站点1: https://laradoc.com/


---------------------------
"Bestlang\\Laracms\\":"packages/bestlang/laracms/src/"


---------------------------
try 使用带参数的中间来验证管理员 role:administrator

修改app\Http\Middleware\RedirectIfAuthenticated.php里面跳转到/home的代码为/ 
app\Http\Middleware\VerifyCsrfToken.php 加入微信支付宝回调排除