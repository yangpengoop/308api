<?php
/**
 *
 * @api {get} # ApiLog结构体
 * @apiGroup 02Body
 * @apiName ApiLog
 * @apiDescription 接口访问记录
 *
 * @apiSuccess {str} id 接口历史记录id
 * @apiSuccess {str} interface 接口
 * @apiSuccess {str} param 参数
 * @apiSuccess {str} callback  回调参数
 * @apiSuccess {str} time  时间
 * @apiSuccess {str} created_at 添加时间
 * @apiSuccess {str} updated_at 最后修改时间
 *
 */

namespace app\Models;
use Illuminate\Database\Eloquent\Model;
class ApiLog extends Model
{
    public $table = 'api_log';
    protected $fillable = ['interface', 'param','callback'];
}