# Laravel-layui-admin

基于 Laravel, Layui 构建的 RABC 基础后台管理系统。

> 如果你想要 vue 版本的后台系统， 移步 [moell/mojito ](https://github.com/moell-peng/mojito)

## 截图

![laravel-layui-admin.png](https://ws1.sinaimg.cn/large/7a679ca1gy1g6omhlvr4nj217y0ovn0d.jpg)

## 要求

- 最低支持 laravel5.8 , 支持 6.0



## 安装

首先安装laravel, 并且确保你配置了正确的数据库连接。

```
composer require moell/laravel-layui-admin
```

然后运行下面的命令来发布资源和配置:

```
php artisan laravel-layui-admin:install
```



在`config/auth.php`中添加相应的 guards 和 providers，如下： 

```
    'guards' => [
        ...
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin'
        ]
    ],

    'providers' => [
        ...
        'admin' => [
            'driver' => 'eloquent',
            'model' => \Moell\LayuiAdmin\Models\AdminUser::class,
        ]
    ],
```

在 `app/Http/Kernel.php` 中 $routeMiddleware 属性添加路由中间`admin.permission` 和替换 auth 中间件：

```
class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
    	//'auth' => \App\Http\Middleware\Authenticate::class,
        'auth' => \Moell\LayuiAdmin\Http\Middleware\Authenticate::class,
        ...
        'admin.permission' => \Moell\LayuiAdmin\Http\Middleware\Authenticate::class,
    ];
}
```

执行数据迁移，数据填充

```
php artisan migrate

php artisan db:seed --class="Moell\LayuiAdmin\Database\LayuiAdminTableSeeder"
```



登录


url: http://localhost/admin/login

email: admin@gmail.com

password: secret

## 依赖开源软件

* Laravel
* Layui
* spatie/laravel-permission

  

## 打赏

<p>
  <img src="http://ww1.sinaimg.cn/mw690/7a679ca1ly1fvxrfnvxa4j20dw0dwdic.jpg" width="250" />
  <img src="http://ww1.sinaimg.cn/mw690/7a679ca1ly1fvxrfnr0dhj20dw0dwgp0.jpg" width="250" />
</p>

## 交流
QQ群：339803849

微信：扫码后拉入群
<p>
  <img src="http://ww1.sinaimg.cn/large/7a679ca1gy1fvym2d0xv1j20by0bywfb.jpg" width="250" />
</p>

## License

Apache License Version 2.0 see http://www.apache.org/licenses/LICENSE-2.0.html
