<?php
/**
 *
 * @api {get} # case_zd_list
 * @apiGroup 02Body
 * @apiName case_zd_list
 * @apiDescription 病历字段表
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
class Ziduan extends Model
{
    public $table = 'case_zd_list';
    protected $fillable = ['zd_name','zd_cn_name','zd_type','zd_sort'];
    public $timestamps= false; //框架会自动维护更新时间及创建时间，表里没有这个字段请加这个
}