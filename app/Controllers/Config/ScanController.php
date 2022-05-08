<?php
/**
 * Created by PhpStorm.
 * User: zxy
 * Date: 2019/4/28
 * Time: 15:44
 */
namespace app\Controllers\Config;
use app\Controllers\BaseController;
use app\Models\Config;
use Illuminate\Http\Request;

class ScanController extends BaseController
{
    /**
     * @api {get} /scan 1、扫描服务
     * @apiSampleRequest  /scan
     * @apiGroup Scan
     */
    public function index()
    {
        set_time_limit(0);
        //$ip = $_SERVER["SERVER_ADDR"];
        $ip = $this->_getLocalConfig('NETWORK_IP');
        if(!$ip){
            return $this->responseSend([]);
        }
        //简单处理扫描同一网络（掩码24）
        $ipArr = explode('.',$ip);
        $ipLast = $ipArr[3];
        unset($ipArr[3]);
        $ipPrefix = join('.',$ipArr);
        $list = array();
        for ($i = 100;$i<121;$i++){
            if($i == $ipLast) continue;
            $scanIp = $ipPrefix  . "." .  $i;
            $result = $this->_scanCurlGet($scanIp);
            if($result == false) continue;
            $data = json_decode($result,true);
            if(isset($data["code"]) && $data["code"] == 0){
                $list[] = $data["data"];
            }

        }
        return $this->responseSend($list);
    }

    public function _scanCurlGet($ip){
        $url = sprintf('http://%s:809/scan/verify',$ip);
        /*$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$url );
        #curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);*/
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'timeout'=>0.5,//单位秒
            )
        );
        $data = @file_get_contents($url,false, stream_context_create($opts));
        return $data;
    }

    /**
     * @api {get} /scan/verify 1、扫描验证
     * @apiSampleRequest  /scan/verify
     * @apiGroup Scan
     */
    public function verify()
    {
        $keys = Config::query()->whereIn('key',['MACHINE_NAME','MACHINE_TYPE'])->get();
        $machineName = "";
        $machineType = 0;
        foreach ($keys as $o){
            switch ($o->key){
                case "MACHINE_NAME":
                    $machineName = $o->value;
                    break;
                case "MACHINE_TYPE":
                    $machineType = $o->value;
                    break;
            }
        }
        $service = array();
        switch ($machineType){
            case 1:
            case 2:
                $service = array("type"=>"rtsp","value"=>sprintf("rtsp://%s/%s",$_SERVER["SERVER_ADDR"],"eyt"));
                break;
        }
        $data["name"] = $machineName;
        $data["type"] = (int)$machineType;
        $data["service"] = $service;
        return $this->responseSend($data);
    }

    function _getLocalConfig($key)
    {
        switch ($key){
            case 'NETWORK_IP':
                $ipStr = "ifconfig |grep inet| sed -n '1p'|awk '{print $2}'|awk -F ':' '{print $2}'";
                $value = shell_exec($ipStr);
                break;
            case 'NETWORK_SUBNET':
                $subnetStr = "ifconfig |grep inet| sed -n '1p'|awk '{print $4}'|awk -F ':' '{print $2}'";
                $value = shell_exec($subnetStr);
                break;
            case 'NETWORK_GATEWAY':
                $getewayStr = "route -n | grep eth0 | sed -n '1p' | awk '{print $2}'";
                $value = shell_exec($getewayStr);
                break;
            case 'NETWORK_DNS':
                $dnsStr = " cat /etc/resolv.conf | grep nameserver  | sed -n '1p' | awk '{print $2}'";
                $value = shell_exec($dnsStr);
                break;
            default:
                $value = '';
        }
        $value = trim($value);

        return $value;
    }
}