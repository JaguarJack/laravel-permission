# laravel-permission
about laravel permission

## 安装
composer require "lizyu/permission"

## 使用
1. 添加服务 在confit/app.php “providers”数组加入 Lizyu\Permission\PermissionServiceProvider::class服务
2. 发布配置文件 php artisan vendor:publish --provider="Lizyu\Permission\PermissionServiceProvider" --tag="lizyu.config"
3. 发布migrate文件 php artisan vendor:publish --provider="Lizyu\Permission\PermissionServiceProvider" --tag="lizyu.migrations"
4. 创建权限表 php artisan migration
5. 填充数据， 配置了基本数据，默认就是使用laravel自带的User表， 所以填充数据。
