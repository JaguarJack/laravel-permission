# laravel-permission
about laravel permission

## 安装
composer require "lizyu/permission"

## 使用
1. 添加服务 在confit/app.php “providers”数组加入 Lizyu\Permission\PermissionServiceProvider::class服务
2. 发布配置文件 php artisan vendor:publish --provider="Lizyu\Permission\PermissionServiceProvider" --tag="lizyu.config"
3. 发布migrate文件 php artisan vendor:publish --provider="Lizyu\Permission\PermissionServiceProvider" --tag="lizyu.migrations"
4. 创建权限表 php artisan migrate
5. 填充数据， 配置了基本数据，默认就是使用laravel自带的User表。
6. 这个包设计很简单，只满足一般的权限节点管理
7. 中间件使用\Lizyu\Permission\PermissionMiddleware::class
8. 对于资源路由， 以文档的为准, 本包都是以权限行为为判断基准 Controller@action 形式存储的数据库中
以资源路由 **删除**行为为例， 路由为xxxx/{id} 实际这个行为则是 Controller@destroy

## 提供了基本模型操作
### permission
public function store(array $permission);   
public function destory(int $permission_id);    
public function findById(int $permission_id);    
public function updateBy(array $permission, int $permission_id);   
public function findByName(string $name);
###### 删除权限关联的角色， 当删除某个权限菜单的时候可以使用该方法
public function deletePermissionOfRole(int $permission_id)
### role
public function store(array $role);    
public function destory(int $role_id);    
public function findById(int $role_id);  
public function updateBy(array $role, int $role_id);    
public function findByName(string $name);
##### 删除角色的权限
public function deletePermissionsOfRole(int $role_id, array $permission_ids = null);
##### 赋予角色权限
public function storePermissionsOfRole(int $role_id, array $permission_ids = null);
##### 删除角色关联的用户， 当删除某个角色时候可以使用
public function deleteUserOfRole(int $role_id);
##### 存储用户角色
##### 需要在你项目中的User模型中引入 
lizyu\Permission\Traits\HasRoleTrait;
lizyu\Permission\Traits\HasPermissionsTrait;
##### 提供了几个方法:
##### 获取用户角色
public function getRolesOfUser();
##### 删除用户关联的角色
public function deleteRolesOfUser(array $role_ids = null);
##### 存储用户关联的角色
public function storeRolesOfUser(array $role_ids = null)；;
##### 获取用户的权限列表
public function getUserOfPermissions(int $user_id);
