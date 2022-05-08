<?php
namespace app\Server;
use app\Models\Config;
use Exception;

class Net {
    public $configModel;
    public $ip;
    public function __construct()
    {
        $this->configModel = new Config();
        $this->ip = new \app\Server\Ip();
    }

    //网络配置数据补全
    public function netConfigFill($net_arr)
    {
        if(!$net_arr || !is_array($net_arr)) return $net_arr;
        foreach ($net_arr as $key => $value){
            if(!$value){
                $value = $this->ip->getNetConfigAll($key);
                $net_arr[$key] = $value;
            }
        }

        return $net_arr;
    }

    public function setNet($net_arr=[])
    {
        $msg='';
        if ($net_arr && $net_arr['NETWORK_AUTO'] == Config::NETWORK_AUTO_DIY){
            $new_net_arr = $this->netConfigFill($net_arr);//网络配置数据补全
            $this->ip->setNetConfig($new_net_arr);//把网络配置写入到linux系统
        }else{
            try{
                $this->ip->openDHCP();//开启DHCP
            }catch (Exception $e){
                $msg = $e->getMessage();
            }
        }

        $new_net_arr = $this->ip->getNetConfigAll();//获取linux的网络配置
        $new_net_arr['NETWORK_AUTO'] = $net_arr['NETWORK_AUTO'] == Config::NETWORK_AUTO_DIY ? Config::NETWORK_AUTO_DIY: Config::NETWORK_AUTO_DHCP;
        $this->configModel->saveConfig($new_net_arr);//保存网络配置到数据库

        return ['net_arr'=>$new_net_arr,'msg'=>$msg];
    }


    //网络初始化
    public function netInitOld()
    {
        //获取网络配置方式
        $NETWORK_AUTO = Config::query()->where('key','NETWORK_AUTO')->first()["value"];
        $NETWORK_AUTO = $NETWORK_AUTO == Config::NETWORK_AUTO_DHCP?Config::NETWORK_AUTO_DHCP:Config::NETWORK_AUTO_DIY;
        $msg = '';
        $net_arr =[];
        switch ($NETWORK_AUTO)
        {
            case Config::NETWORK_AUTO_DIY://手动配置
                $net_arr =  $this->configModel->getKeys(['NETWORK_IP','NETWORK_SUBNET','NETWORK_GATEWAY','NETWORK_DNS','NETWORK_AUTO']);

                $this->setNet( $net_arr);

                break;
            case Config::NETWORK_AUTO_DHCP://DHCP自动配置
                $net_data = $this->setNet();
                $net_arr = $net_data['net_arr'];
                $msg = $net_data['msg'];

                break;
        }

        return ['net_arr'=>$net_arr,'msg'=>$msg];
    }

    //网络初始化
    public function netInit()
    {
        exec("/link/shell/setNetwork.sh");

        return ['net_arr'=>11,'msg'=>222];
    }

    //网络重置
    public function netReset()
    {
        $net_arr = [
            "NETWORK_IP" => env("DEFAULT_NETWORK_IP","192.168.10.115"),
            "NETWORK_SUBNET" => env("DEFAULT_NETWORK_SUBNET","255.255.255.0"),
            "NETWORK_GATEWAY" =>  env("DEFAULT_NETWORK_GATEWAY","192.168.10.1"),
            "NETWORK_DNS" => env("DEFAULT_NETWORK_DNS","8.8.8.8"),
            "NETWORK_AUTO" => Config::NETWORK_AUTO_DIY,
        ];

        $this->setNet($net_arr);
    }

}