<?php
/**
 *
 * @api {get} # Files结构体
 * @apiGroup 02Body
 * @apiName Files
 * @apiDescription 用户文件表
 *
 * @apiSuccess {str} id 文件id
 * @apiSuccess {str} patient_case_id 病人病历id
 * @apiSuccess {str} type 文件类型1图片2视频
 * @apiSuccess {str} name 文件名字
 * @apiSuccess {str} path 储存路径
 * @apiSuccess {str} created_at 添加时间
 * @apiSuccess {str} updated_at 最后修改时间
 *
 */

namespace app\Models;
use Illuminate\Database\Eloquent\Model;
class Files extends Model
{
    public $table = 'files';
    protected $fillable = ['patient_case_id','hospital_number', 'type','name','path',"status"];

    const UPLOAD_FILE_SIZE="230m";
    const POST_MAX_SIZE="250m";

    /*public function getPathAttribute($value)
    {
        return "/datas/".$value;
    }*/

}