<?php
/**
 *
 * @api {get} # Report
 * @apiGroup 02Body
 * @apiName Report
 * @apiDescription 报告表
 *
 * @apiSuccess {str} id 报告id
 * @apiSuccess {str} templete_html 模板html
 * @apiSuccess {str} name 报告名字
 * @apiSuccess {str} config 表单配置
 * @apiSuccess {str} config_value 表单配置带value值
 * @apiSuccess {str} templete_final 最终模板html

 * @apiSuccess {str} created_at 添加时间
 * @apiSuccess {str} updated_at 最后修改时间
 *
 */

namespace app\Models;
use Illuminate\Database\Eloquent\Model;
class Report extends Model
{
    public $table = 'report';
    protected $fillable = ['templete_html', 'config','config_value','templete_final','name','patient_id'];
}