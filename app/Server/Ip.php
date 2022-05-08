<?php
namespace app\Server;
use Exception;

class Ip{
    public $ip_tool;

    public function __construct()
    {
        $this->ip_tool = new \app\Server\IpTool();
    }


    //手动设置网络配置
    public function setNetConfig($arr)
    {
        $NETWORK_IP = $arr['NETWORK_IP']?$arr['NETWORK_IP']:env("DEFAULT_NETWORK_IP","192.168.10.115");
        $NETWORK_SUBNET = $arr['NETWORK_SUBNET']?$arr['NETWORK_SUBNET']:env("DEFAULT_NETWORK_SUBNET","255.255.255.0");
        $NETWORK_GATEWAY = $arr['NETWORK_GATEWAY']?$arr['NETWORK_GATEWAY']:env("DEFAULT_NETWORK_GATEWAY","192.168.10.1");
        $NETWORK_DNS = $arr['NETWORK_DNS']?$arr['NETWORK_DNS']:env("DEFAULT_NETWORK_DNS","8.8.8.8");

        $this->ip_tool->closeDHCP();
        $this->ip_tool->setNetConfig($NETWORK_IP,$NETWORK_SUBNET,$NETWORK_GATEWAY,$NETWORK_DNS);
    }

    //开启DHCP
    public function openDHCP()
    {
        $sh_path = "/usr/share/udhcpc/ip_dhcp.sh";
        if(!file_exists($sh_path)){
            $sh_src_path= env("WEB_PATH")."core309_local/shell_sh/ip_dhcp.sh";
            if(!file_exists($sh_src_path)){
                throw new Exception("DHCP配置源文件不存在");
            }
            $sh_dir = "/usr/share/udhcpc/";
            if(!is_dir($sh_dir)) {
                shell_exec("cd /usr/share/ && mkdir udhcpc");
            }
            if(!copy($sh_src_path,$sh_path)){
                throw new Exception("DHCP配置文件不存在");
            }
            if(file_exists($sh_path)){
                shell_exec("chmod +x {$sh_path}");
            }
        }

        $this->ip_tool->openDHCP($sh_path);
    }


    /**获取全部linux网络配置
     * @param string $key 获取某个key值
     * @return array|string
     */
    public function getNetConfigAll($key='')
    {
        $net_arr = $this->ip_tool->getNetConfig();
        return $key && isset($net_arr[$key])?$net_arr[$key]:$net_arr;
    }

}