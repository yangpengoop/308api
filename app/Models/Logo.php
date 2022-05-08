<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020/1/18
 * Time: 11:52
 */
/**
 *
 * @api {get} # Logo结构体
 * @apiGroup 02Body
 * @apiName Logo
 * @apiDescription OSD-logo图片列表
 *
 * @apiSuccess {str} id logoid
 * @apiSuccess {str} path 储存路径
 * @apiSuccess {str} name 文件名字
 *
 */
namespace app\Models;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    public $table = 'logo';
    protected $fillable = ['id','name','path'];
}