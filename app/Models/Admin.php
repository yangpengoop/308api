<?php
/**
 *
 * @api {get} # Admin结构体
 * @apiGroup 02Body
 * @apiName Admin
 * @apiDescription 管理用户登陆表
 *
 * @apiSuccess {str} id 管理用户id
 * @apiSuccess {str} name 名字
 * @apiSuccess {str} pass 密码（明文）
 * @apiSuccess {str} is_login 是否自动登陆0否1是
 * @apiSuccess {str} created_at 添加时间
 * @apiSuccess {str} updated_at 最后修改时间
 *
 */

namespace app\Models;
use Illuminate\Database\Eloquent\Model;
class Admin extends Model
{
    public $table = 'admin';
    protected $fillable = ['name', 'pass','is_login'];
}