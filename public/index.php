<?php
date_default_timezone_set("PRC");
define("STORAGE_PATH",__DIR__.'/../storage');

define("EN_OR_DE",__DIR__.'/../config');

//Autoload 自动载入
require '../vendor/autoload.php';

//设置异常捕获
function exceptionInfo($exception){
    new app\Exception\Exception($exception);
}
//set_exception_handler("exceptionInfo");
//处理.env配置
\Dotenv\Dotenv::create("../")->load();

//处理数据库
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection(require '../config/database.php');
$capsule->setAsGlobal();
$capsule->bootEloquent();

//实例化服务器容器，注册事件，路由服务提供者
$app = new Illuminate\Container\Container;
//服务容器【服务的注册和解析】
with(new Illuminate\Events\EventServiceProvider($app))->register();
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();
//加载路由
require '../config/router.php';
//实例化请求并分发处理请求
$request = Illuminate\Http\Request::capture();
$response = $app['router']->dispatch($request);
//返回请求响应
$response->send();