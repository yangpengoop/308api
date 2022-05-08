##运行
###请装composer
相关地址：https://www.phpcomposer.com/
###执行composer install

##ApiDoc接口生成配置与命令
安装node.js 
安装Apidoc插件
<pre>
npm install apidoc -g
</pre>
生成接口文件
<pre>
apidoc -i ./app -o ./public/apidoc/
</pre>

##使用了laravel的routing组件、ORM组件与数据验证组件
快速学习地址：
常用到：Request、Model、Helper、DB、Composer、Collection
<pre>
https://cs.laravel-china.org/
</pre>
##NGINX配置
<pre>
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
</pre>