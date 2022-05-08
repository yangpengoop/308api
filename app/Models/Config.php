<?php
/**
 *
 * @api {get} # Config结构体
 * @apiGroup 02Body
 * @apiName Config
 * @apiDescription 配置表
 *
 * @apiSuccess {str} id 配置id
 * @apiSuccess {str} type 类型1文本2列表
 * @apiSuccess {str} key KEY值
 * @apiSuccess {str} value 值
 * @apiSuccess {str} description 描述
 * @apiSuccess {str} created_at 添加时间
 * @apiSuccess {str} updated_at 最后修改时间
 *
 * @apiSuccess {str} KEY KEY列表 <br>
 * key：QUALITY_LEVEL 描述：画质-画质 <br>
 * key：QUALITY_RATE 描述：画质-码率 <br>
 * key：OSD_FORMAT 描述：OSD-OSD格式 <br>
 * key：OSD_POSITION 描述：OSD-OSD位置  1：左上角  2：右上角 3：左下角 4：右下角 <br>
 * key：PUSH_RTMP_URL 描述：OSD-RTMP推流地址 <br>
 * key：PUSH_VIDEOSAVE_URL 描述：OSD-录像文件保存路径 <br>
 * key：3D_SDL 描述：3D设置-双SDL输出 <br>
 * key：NETWORK_IP 描述：网络-IP <br>
 * key：NETWORK_SUBNET 描述：网络-子网掩码 <br>
 * key：NETWORK_GATEWAY 描述：网络-网关 <br>
 * key：NETWORK_DNS 描述：网络-DNS <br>
 * key：NETWORK_AUTO 描述：网络-自动配置 1：关闭  2：开启 <br>
 * key：DISC_FULLACTION 描述：磁盘-磁盘满后的动作 <br>
 * key：COMMON_TIMEFORMAT 描述：通用-时间格式 <br>
 * key：DISPLAY_LIGHT 描述：显示-亮度 <br>
 * key：DISPLAY_RATIO 描述：显示-对比度 <br>
 * key：DISPLAY_SATURATION 描述：显示-饱和度 <br>
 *
 */

namespace app\Models;
use Illuminate\Database\Eloquent\Model;
use app\Server\Ip;
class Config extends Model
{
    public $table = 'config';
    protected $fillable = ['type', 'key','value','description'];

    const NETWORK_AUTO_DIY  = 1;//手动配置
    const NETWORK_AUTO_DHCP = 2;//自动配置

    public function saveConfig($arr)
    {
        $key_save = [];
        foreach ($arr as $key => $value){//把配置数据写入数据库
            $keyRes = self::where('key',$key)->update(['value'=>$value]);
            $key_save[$key] = $keyRes==1?'success':'fail';
        }

        return $key_save;
    }

    /**
     * @param array $keys
     * @param bool $isAutoNet 是否补全网络配置
     * @return array
     */
    public function getKeys($keys=[])
    {
        $net_arr = [];
        if(!$keys || !is_array($keys)) return $net_arr;

        $keysData = Config::whereIn('key',$keys)->get();

        foreach ($keysData as $key_data){
            $net_arr[$key_data["key"]] = $key_data['value'];
        }

        return $net_arr;
    }

}