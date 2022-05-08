<?php
namespace app\Controllers\Config;

use app\Controllers\BaseController;
use app\Models\Config;
use app\Server\Ip;
use Illuminate\Http\Request;
use app\Server\Net;
use Illuminate\Database\Capsule\Manager  as DB;
use mysql_xdevapi\Exception;

class SystemController extends BaseController
{
    /**
     * @api {get} /system 1、系统设置-列表
     * @apiSampleRequest  /system
     * @apiGroup Config-system
     *
     *
     */
    public function index()
    {
        $keyData = Config::get();
        for ($i=0;$i<count($keyData);$i++){
            if($keyData[$i]['value_type'] == 'json'){
                $keyData[$i]['value'] = json_decode($keyData[$i]['value'],true);
            }
        }

        $this->responseSend($keyData);
    }

    /**
     * @api {get} /system/get-key 3、系统设置（录像设置）-获取某一个key的值
     * @apiSampleRequest  /system/get-key
     * @apiGroup Config-system
     *@apiParam {str} [key] key名字
     *
     */
    public function getKey()
    {
        $form = $this->validator([
            "key" => "required|String",
        ]);
        $keyData = Config::where('key',$form['key'])->firstOrFail();
        if($keyData && $keyData['value_type'] == 'json'){
            $keyData['value'] = json_decode($keyData['value'],true);
        }
        $this->responseSend($keyData);
    }



    /**
     * @api {post} /system/edit 2、系统设置-编辑(全局)
     * @apiSampleRequest  /system/edit
     * @apiGroup Config-system
     * @apiName system-edit
     * @apiParam {str} [key] 键名 样例：{key:value}

     *
     */
    public function edit()
    {

        $form = Request::capture()->all();
//        var_export($form);
        if(!$form){
            $this->responseSend([],0,'参数不能为空');
        }

        $form = $this->validator([
            "key" => "required",
        ]);
        if($form['key'] && is_array($form['key'])){
            $keys = $form['key'];
        }else{
//        var_export($form['key']);
//            var_export(json_decode($form['key'],true));exit;
            $keys = $form['key'] ? json_decode($form['key'],true):'';
        }
        if(!$keys || !is_array($keys))  $this->responseSend('',422,'key值不能为空且必须为合法的json格式');
        $edit_status = [];
        foreach ($keys as $key =>$value){
            $data = Config::where('key',$key)->update(['value'=>$value]);
            $edit_status[$key] = $data == 1?'success':'fail';
        }

        $this->responseSend($edit_status);
    }


    /**
     * @api {post} /system/network-edit 1、系统设置-网络编辑
     * @apiSampleRequest  /system/network-edit
     * @apiGroup Config-system-network
     * @apiName system-networkEdit
     * @apiParam {str} [NETWORK_IP] 网络-IP
     * @apiParam {str} [NETWORK_SUBNET] 网络-子网掩码
     * @apiParam {str} [NETWORK_GATEWAY] 网络-网关
     * @apiParam {str} [NETWORK_DNS] 网络-DNS
     * @apiParam {int} [NETWORK_AUTO] 网络-自动配置 【1：关闭  2：开启】
     *
     */
    public function networkEdit()
    {
        $form = Request::capture()->all();

        $NETWORK_AUTO = isset($form['NETWORK_AUTO'])?$form['NETWORK_AUTO']:'';
        if(!in_array($NETWORK_AUTO,[Config::NETWORK_AUTO_DIY,Config::NETWORK_AUTO_DHCP])) {
            $this->responseSend('',422,'NETWORK_AUTO不能为空或不合法');
        }

        $NETWORK_IP = isset($form['NETWORK_IP'])?trim($form['NETWORK_IP']):'';
        $NETWORK_SUBNET = isset($form['NETWORK_SUBNET'])?trim($form['NETWORK_SUBNET']):'';
        $NETWORK_GATEWAY = isset($form['NETWORK_GATEWAY'])?trim($form['NETWORK_GATEWAY']):'';
        $NETWORK_DNS = isset($form['NETWORK_DNS'])?trim($form['NETWORK_DNS']):'';

        if ($NETWORK_AUTO == 1 && (!$NETWORK_IP || !$NETWORK_SUBNET || !$NETWORK_GATEWAY || !$NETWORK_DNS)){
           $this->responseSend('',422,'NETWORK_IP或NETWORK_SUBNET或NETWORK_GATEWAY或NETWORK_DNS不能为空');
        }
        $Ddscp="true";
        if($NETWORK_AUTO==1){
            $Ddscp="false";
        }
        $net = new Net();
// {"ip":"192.168.10.161","mask":"255.255.255.0","gateway":"192.168.10.1","dns":"8.8.8.8","dhcp":false}
        //$txt ='{"NETWORK_IP":"'.$NETWORK_IP.'","NETWORK_SUBNET":"'.$NETWORK_SUBNET.'","NETWORK_GATEWAY":"'.$NETWORK_GATEWAY.'","NETWORK_DNS":"'.$NETWORK_DNS.'","NETWORK_AUTO":"'.$NETWORK_AUTO.'"}';
        $txt ='{"ip":"'.$NETWORK_IP.'","mask":"'.$NETWORK_SUBNET.'","gateway":"'.$NETWORK_GATEWAY.'","dns":"'.$NETWORK_DNS.'","dhcp":'.$Ddscp.'}';
        //echo $txt;


        //保存网络配置到/link/config/net.json
        $myfile = fopen("/link/config/net.json", "w") or die("Unable to open file!");
        //$net_arr='{"NETWORK_IP":"192.168.10.181","NETWORK_SUBNET":"255.255.255.0","NETWORK_GATEWAY":"192.168.10.1","NETWORK_DNS":"10.0.2.3","NETWORK_AUTO":"1"}';

        fwrite($myfile, $txt);
        fclose($myfile);
        exec("/link/shell/setNetwork.sh");
        //       $net_arr=[];
//        switch ($form['NETWORK_AUTO'])
//        {
//            case 1://自动配置关闭
//                $net_arr = [
//                    "NETWORK_IP" => $NETWORK_IP,
//                    "NETWORK_SUBNET" => $NETWORK_SUBNET,
//                    "NETWORK_GATEWAY" => $NETWORK_GATEWAY,
//                    "NETWORK_DNS" => $NETWORK_DNS,
//                    "NETWORK_AUTO" => Config::NETWORK_AUTO_DIY,
//                ];
//                $net_arr = $net->setNet($net_arr);
//
//                $linux_real_ip = $net->ip->ip_tool->getIp();
//                if($NETWORK_IP != $linux_real_ip) {
//                    $msg = "网络配置设置失败，IP没有改变";
//                    $this->responseSend($net_arr,400,$msg);
//                }
//
//                break;
//            case 2://DHCP自动配置开启
//
//                $net_arr = $net->setNet();
//
//                break;
//        }



        //$this->responseSend(shell_exec("/tchd/shell/setNetwork.sh"),0,'网络配置设置成功');
       $this->responseSend($net_arr,0,'网络配置设置成功1');

    }

    /**
     * @api {get} /system/get-network-key 2、系统设置-获取网络key值
     * @apiSampleRequest  /system/get-network-key
     * @apiGroup Config-system-network
     * @apiName system-getNetworkKey
     *
     *
     */
    public function getNetworkKeyOld()
    {
        $configModel = new Config();

        $net_arr = $configModel->getKeys(['NETWORK_IP','NETWORK_SUBNET','NETWORK_GATEWAY','NETWORK_DNS','NETWORK_AUTO']);
        //$net_arr='{"NETWORK_IP":"192.168.10.181","NETWORK_SUBNET":"255.255.255.0","NETWORK_GATEWAY":"192.168.10.1","NETWORK_DNS":"10.0.2.3","NETWORK_AUTO":"1"}';

        $this->responseSend($net_arr);
    }
    /**
     * @api {get} /system/get-network-key 2、系统设置-获取网络key值
     * @apiSampleRequest  /system/get-network-key
     * @apiGroup Config-system-network
     * @apiName system-getNetworkKey
     *
     *
     */
    public function getNetworkKey()
    {
        //$configModel = new Config();
        // 从文件中读取数据到PHP变量
        $json_string = file_get_contents('/link/config/net.json');
        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);
//        echo  $json_string;
//        echo  "\n";
//        echo  $json_string;
//        echo  "\n";
        //$net_arr = $configModel->getKeys(['NETWORK_IP','NETWORK_SUBNET','NETWORK_GATEWAY','NETWORK_DNS','NETWORK_AUTO']);
       // $net_arr='{"NETWORK_IP":"192.168.10.181","NETWORK_SUBNET":"255.255.255.0","NETWORK_GATEWAY":"192.168.10.1","NETWORK_DNS":"10.0.2.3","NETWORK_AUTO":"1"}';

        $this->responseSend($data);
    }
    /**
     * @api {get} /system/get-mac 2、系统设置-获取mac地址
     * @apiSampleRequest  /system/get-mac
     * @apiGroup Config-system-network
     * @apiName system-getNetworkKey
     *
     *
     */
    public function getMAC()
    {
        //$configModel = new Config();
        // 从文件中读取数据到PHP变量
        $json_string = file_get_contents('/link/config/mac');
        // 用参数true把JSON字符串强制转成PHP数组
        // $data = json_decode($json_string, true);

        $this->responseSend($json_string);
    }
    public function setMAC(){
        exec("rm /link/config/mac");
        exec("/link/shell/setMac.sh");
        $json_string = file_get_contents('/link/config/mac');
        $this->responseSend($json_string);
    }

    /**
     * @api {get} /system/getEnOrDe 3、系统设置-获取当前系统是编码还是解码
     */
    public function getEnOrDe()
    {
        //echo EN_OR_DE;

        $path=EN_OR_DE.'/ED.json';
       // echo $path;


        $json_string = file_get_contents($path);
        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);
        $this->responseSend($data);
    }

    /**
     * @api {get} /system/get-linux-net 3、系统设置-获取当前linux系统上的网络配置
     * @apiSampleRequest  /system/get-linux-net
     * @apiGroup Config-system-network
     * @apiName system-getLinuxNet
     *
     *
     */
    public function getLinuxNet()
    {
        $ip = new Ip();
        $net_arr = $ip->getNetConfigAll();

        $this->responseSend($net_arr);
    }

    /**
     * @api {get} /system/net-reset 4、系统设置-重置网络配置
     * @apiSampleRequest  /system/net-reset
     * @apiGroup Config-system-network
     * @apiName system-netReset
     *
     *
     */
    public function netReset()
    {
        $net = new Net();
        $net->netReset();
    }


    /**
     * @api {get} /system/get-signal 1、系统设置-获取信号源类型
     * @apiSampleRequest  /system/get-signal
     * @apiGroup Config-system-signal
     * @apiName system-getSignal
     *
     *
     */
    public function getSignal()
    {
        $keyData = Config::where('key',"SIGNAL_SOURCE")->firstOrFail();

        $keyData['value'] = isset($keyData['value']) && $keyData['value']?
                            json_decode($keyData['value'],320):'';

        $this->responseSend($keyData);
    }


    /**
     * @api {post} /system/signal-edit 2、系统设置-编辑信号源类型
     * @apiSampleRequest  /system/signal-edit
     * @apiGroup Config-system-signal
     * @apiName system-signalEdit
     * @apiParam {str} [value] value值样例：{"SDI-1":"SDI_1信号","HDMI-1":"HDMI_1信号"}
     *
     */
    public function signalEdit()
    {
        $signal_arr = ['SDI-1','SDI-2','SDI-3','SDI-4','SDI-5',"HDMI-1","HDMI-2","HDMI-3","SAVS4K"];//信号类型
        $signal_key = 'SIGNAL_SOURCE';

        $form = $this->validator([
            "value" => "required",
        ]);
        if($form['value'] && is_array($form['value'])){
            $value = $form['value'];
        }else{
            $value = $form['value'] ? json_decode($form['value'],true):'';
        }

        if(!$value || !is_array($value))  $this->responseSend('',422,'value值不能为空且必须为合法的json格式');

        $keyData = Config::where('key',$signal_key)->firstOrFail();
        $old_value =   $keyData['value']?json_decode($keyData['value'],320):[];

        foreach ($value as $key => $signal){
            $old_value[$key] = $signal;
        }

        $res = Config::where('key',$signal_key)->update(['value'=>json_encode($old_value,320)]);

        $this->responseSend($res);
    }

    /**
     * @api {post} /system/set-time 1、系统设置-设置系统时间
     * @apiSampleRequest  /system/set-time
     * @apiGroup Config-system-setTime
     * @apiName system-setTime
     * @apiParam {str} [time] 值样例：时间戳
     *
     */
    public function setTime()
    {
            $sh_src_path= env("WEB_PATH")."core309_local/shell_sh/localtime";
            $sh_dest_path = "/etc/localtime";
            if(!file_exists($sh_dest_path)) copy($sh_src_path,$sh_dest_path);
            $form = Request::capture()->all();
            if(!isset($form['time']) || !$form['time']) $this->responseSend([],400,"time参数不能为空");
            $time = date("Y/m/d/H/i/s",intval($form['time']));
            exec("/link/bin/rtc -s time {$time}");
            exec("/link/bin/rtc -g time");
            $this->responseSend($time);
    }

    /**
     * @api {get} /system/get-time 1、系统设置-获取系统时间
     * @apiSampleRequest  /system/get-time
     * @apiGroup Config-system-setTime
     * @apiName system-getTime
     */
    public function getTime()
    {
        $t = time();
        $day = date("Y/m/d",$t);
        $time = date("H:i:s",$t);
        $this->responseSend(['day'=>$day,'time'=>$time]);
    }

    public function getNTPTime()
    {
        error_log("sssss",   3,   "/link/web/wiilog.txt");
        ini_set('date.timezone', 'Asia/Shanghai');
        $startTime = microtime(true);
        $resource = @fsockopen('172.18.1.253', $code, $error, 30);
        // $resource = @fsockopen('time.nist.gov', 13, $code, $error, 30);
        error_log($resource,   3,   "/link/web/wiilog.txt");
        if($resource){
                stream_set_timeout($resource, 30);
                $response = stream_get_contents($resource);
                // 服务器返回的字符串形如 57637 16-09-06 16:26:17 50 0 0 147.2 UTC(NIST) *               
                $endTime = microtime(true);
                $timeDifference = (int)round($endTime - $startTime);
                if(preg_match('%\d{2}\-\d{2}\-\d{2}\s+\d{2}\:\d{2}\:\d{2}%', $response, $match)){
                        // 得到当前时间戳
                        $timestamp = strToTime('20'.$match[0]) + 3600*8 + $timeDifference;
                        error_log($timestamp,   3,   "/link/web/wiilog.txt");
                        // echo date('Y-m-d H:i:s', $timestamp);
                        echo $timestamp;
                        $time = date("Y/m/d/H/i/s",intval($timestamp));
                        error_log($time,  3,   "/link/web/wiilog.txt");
                        exec("/link/bin/rtc -s time {$time}");
                        exec("/link/bin/rtc -g time");
                        $this->responseSend($time);
                }
        }
    }
    /**
     * @api {get} /system/getTimeTo 1、系统设置-获取系统时间 （通用-时间日期 下拉选择框用途）
     * @apiSampleRequest  /system/getTimeTo
     * @apiGroup Config-system-setTime
     * @apiName system-getTimeTo
     */
    public function getTimeTo()
    {
        $t = time();
        $year = date("Y",$t);
        $mon = date('m',$t);
        $day = date("d",$t);
        $time = date("H",$t);
        $branch = date("i",$t);
        $second = date("s",$t);
        $this->responseSend(['year'=>$year,'mon'=>$mon,'day'=>$day,'time'=>$time,'branch'=>$branch,'second'=>$second]);
    }

    /**
     * @api {get} /system/setPowerOnstartup 3、系统设置-是否上电启动
     * @apiSampleRequest  /system/getPowerOnstartup
     * @apiGroup Config-system-setTime
     * @apiName system-getPowerOnstartup
     */
    public function PowerOnstartup()
    {
        $form = Request::capture()->all();

        $values= $form['PowerOnstartup'];


        DB::update("update  power_on_startup SET power_on_startup_log='$values'
                    ") ;
        $this->responseSend([yes]);
    }
    /**
     * @api {get} /system/getPowerOnstartup 3、系统设置-是否上电启动
     * @apiSampleRequest  /system/getPowerOnstartup
     * @apiGroup Config-system-setTime
     * @apiName system-getPowerOnstartup
     */
    public function getPowerOnstartup()
    {

        $data = DB::select("select  power_on_startup_log
                             from power_on_startup
                             ");
        $this->responseSend($data);
    }

    /**
     * @api {get} /system/setcodec 4、设置编解码界面状态
     * @apiSampleRequest  /system/setcodec
     * @apiGroup Config-system-setTime
     * @apiName system-setcodec
     */
    public function setcodec()
    {
        $form = Request::capture()->all();

        $values= $form['codec'];


        DB::update("update  code_decode SET code_decode_state='$values'
                    ") ;
        $this->responseSend([yes]);
    }

    /**
     * @api {post} /system/codec 4、获取编解码界面状态
     * @apiSampleRequest  /admin/codec
     * @apiGroup Config-system-admin
     * @apiName admin-del
     * @apiParam {str} name 用户名
     *
     *
     */
    public function codec()
    {
        $list = DB::select("select code_decode_state
                            from code_decode 
                            ") ;

        return $this->responseSend($list);
    }

    /**
     * @api {get} /system/setrelay 4、设置转播状态
     * @apiSampleRequest  /system/setrelay
     * @apiGroup Config-system-setTime
     * @apiName system-setrelay
     */
    public function setrelay()
    {
        $form = Request::capture()->all();

        $values= $form['relay'];


        DB::update("update  code_decode SET relay_state='$values'
                    ") ;
        $this->responseSend([yes]);
    }

    /**
     * @api {post} /system/relay 4、获取转播状态
     * @apiSampleRequest  /system/relay
     * @apiGroup Config-system-admin
     * @apiName admin-del
     * @apiParam {str} name 用户名
     *
     *
     */
    public function relay()
    {
        $list = DB::select("select relay_state
                            from code_decode 
                            ") ;

        return $this->responseSend($list);
    }

    /**
     * @api {post} /system/getWiFiList 5、wifi列表获取
     * @apiSampleRequest  /system/wifi
     *
     *
     */
    public function wifi()
    {
        $json_string = file_get_contents('/root/wifi/wifiList.json');
        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);

        return $this->responseSend($data);
    }

    /**
     * @api {post} /system/shell 开启脚本命令
     * @apiSampleRequest  /system/shell
     *
     *
     */
    public function shell()
    {
        $form = Request::capture()->all();
        $shell = $form['shell_exec'];
        $ip = $form['ping'];

        if($shell ==''){
            $value = $this->ping($ip);
            return $this->responseSend($value);
        }else{
            $a = "{$shell} 2>/root/wifilog.txt";
            shell_exec("{$shell}");
            $avc = exec("{$a}",$va,$vn);
            error_log($vn." \n".$va."\n".$a."\n".$avc."\n",   3,   "/root/wifilog.txt");
            return $this->responseSend($va);
        }
    }

    public function ping($ip,$times=12){
        $info =array();
        if (!is_numeric($times) || $times-12<0){
            $times =12 ;
        }
        if (PATH_SEPARATOR == ':' || DIRECTORY_SEPARATOR == '/'){
            exec("ping $ip -c $times",$info);
            if (count($info) <9){
                $info['error'] ='请求超时';
            }
        }
        return $info;
    }
    public function getValue(){
        exec("/root/wifi/getStatus.sh",$vs,$vv);
        return $vs;
    }
    public function getNum(){
        $mun =0;
        for ($i=0;$i<=5;$i++){
            $mun=$i;
            usleep(5000);
        }
        return $mun;
    }
    /**
     * @api {post} /system/WiFiConnect 连接wifi
     * @apiSampleRequest  /system/WiFiConnect
     *
     *
     */
    public function WiFiConnect()
    {
        $form = Request::capture()->all();
        $name = $form['wifiname'];
        $pwd = $form['wifipwd'];
        shell_exec("/root/wifi/connectWIFI.sh {$name} {$pwd}");
        sleep(5);
        $value = $this->getValue();
//        while($value != 'ok'){
//            $value = $this->getValue();
            //$mun = $this->getNum();
//            if ($mun <= 5){
//
//            }
//        }
        return $this->responseSend($value);
        //return $this->responseSend();
    }

    /**
     * @api {post} /system/safePop_up 6、外接磁盘安全弹出
     * @apiSampleRequest  /system/safePop_up
     *
     *
     */
    public function safePop_up()
    {
        $form = Request::capture()->all();
        $disk = $form['disk'];
        shell_exec("umount {$disk}");
        return $this->responseSend();
    }

    /**
     * @api {post} /system/netUpdate 云端网络更新
     * @apiSampleRequest  /system/safePop_up
     *
     *
     */
    public function netUpdate()
    {
        $form = Request::capture()->all();
        $shell = "/link/shell/update480.sh ftp://gkftp:gbw@47.96.126.171/fs480.tar.gz";
        $a = "{$shell} 2>/root/netUpdate.txt";
        // shell_exec("{$shell}");
        $avc = exec("{$a}",$va,$vn);
        error_log($vn." \n".$va."\n".$a."\n".$avc."\n",   3,   "/root/netUpdate.txt");
        return $this->responseSend($va);
    }

    /**
     * @api {post} /system/restore_factory_settings 恢复出厂设置
     * @apiSampleRequest  /system/safePop_up
     *
     *
     */
    public function restore_factory_settings()
    {        
        DB::insert("insert into config select * from config_init");
        //return $this->responseSend();
    }
    
    /**
     * @api {post} /system/diskMount 7、尝试手动挂载
     * @apiSampleRequest  /system/diskMount
     *
     *
     */
    public function diskMount()
    {
        $form = Request::capture()->all();
        $diskType = $form['id'];
        $diskPath  = $form['path']; //  /mnt/disk2
        $diskRoot  = $form['root']; //  sdb1   sdb2   sdc1  sdc2
        if($diskType =='NTFS'){
            if($diskPath == '/mnt/disk2'){
                exec("ntfs-3g {$diskRoot} {$diskPath}");
            }else if($diskPath == '/mnt/disk3'){
                exec("ntfs-3g {$diskRoot} {$diskPath}");
            }
            return $this->responseSend('',0,'正在尝试挂载');
        }else{
            if($diskPath == '/mnt/disk2'){
                exec("mount {$diskRoot} {$diskPath}");
            }else if($diskPath == '/mnt/disk3'){
                exec("mount {$diskRoot} {$diskPath}");
            }
            return $this->responseSend('',0,'正在尝试挂载');
        }
        
        
    }

    /**
     * @api {post} /system/getDistOut 8、获取磁盘信息
     * @apiSampleRequest  /system/getDistOut
     *
     *
     */
    public function getDistOut()
    {
        exec("fdisk -l | grep /dev/sd",$tip);
        return $this->responseSend($tip);
    }


    /**
     * @api {post} /system/getMachineNumber 9、获取机器编号  --山东项目
     * @apiSampleRequest  /system/getDistOut
     *
     *
     */
    public function getMachineNumber()
    {
        $form = Request::capture()->all();
        $number = $form['number'];
        $txt = $number;
        $myfile = fopen("/link/config/testtt.txt", "w") or die("Unable to open file!");
        //$net_arr='{"NETWORK_IP":"192.168.10.181","NETWORK_SUBNET":"255.255.255.0","NETWORK_GATEWAY":"192.168.10.1","NETWORK_DNS":"10.0.2.3","NETWORK_AUTO":"1"}';

        fwrite($myfile, $txt);
        fclose($myfile);
        
        // $string = file_get_contents('/link/config/MachineNumber.txt');
        return $this->responseSend($txt);
    }


    /**
     * 
     * @api {post} /system/getInfo 10、获取产品信息
     * @apiSampleRequest  /system/getInfo
     *
     *
     */
    public function getInfo(){
        $json_string = file_get_contents('/link/web/core309_local/info.json');
        $data = json_decode($json_string, true);
        return $this->responseSend($data);

    }


}