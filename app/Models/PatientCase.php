<?php
/**
 *
 * @api {get} # PatientCase结构体
 * @apiGroup 02Body
 * @apiName PatientCase
 * @apiDescription 病人信息表
 *
 * @apiSuccess {str} id 病人id
 * @apiSuccess {str} name 名字
 * @apiSuccess {str} sex 性别
 * @apiSuccess {str} surgery_date 手术日期
 * @apiSuccess {str} hospital_number 住院号
 * @apiSuccess {str} bed_number 床位号
 * @apiSuccess {str} department 科室
 * @apiSuccess {str} operating_room 手术室
 * @apiSuccess {str} surgery_name 手术名称
 * @apiSuccess {str} age 年龄
 * @apiSuccess {str} ward 病区
 * @apiSuccess {str} surgery_doctor 手术医生
 * @apiSuccess {str} created_at 添加时间
 * @apiSuccess {str} updated_at 最后修改时间
 *
 */

namespace app\Models;
use Illuminate\Database\Eloquent\Model;

class PatientCase extends Model
{
    public $table = 'bingli_info';

    protected $casts = [ 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s' ];

    protected $dates=['created_at'];
    // protected $fillable = ['zhuyh', 'xingm','xingb','age','jcxm','shoush','shousys','shousmc','mazys','shuqzd','shuhzd','shoustime','menzh','songjys','songjks','jiancys','jiancjl','bingrzs','lingczd','xiaodr',
    // 'xiaodtime'
    // ,'jiataddr','lianxdh','lianxren','zhiye','guopji','remark','baogaoUrl','update','upoper','created_at','updated_at'
    // ];
    protected $fillable = [];
   
    
}