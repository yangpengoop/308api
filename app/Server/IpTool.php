<?php
namespace app\Server;

class IpTool{

    //设置全部网络配置
    public function setNetConfig($NETWORK_IP='192.168.10.115',$NETWORK_SUBNET='255.255.255.0',$NETWORK_GATEWAY='192.168.10.1',$NETWORK_DNS='8.8.8.8')
    {
        if ($NETWORK_IP) $this->setIp($NETWORK_IP,$NETWORK_SUBNET);
        if ($NETWORK_GATEWAY) $this->setGateway($NETWORK_GATEWAY);
        if ($NETWORK_DNS) $this->setDns($NETWORK_DNS);
    }

    //获取全部网络配置
    public function getNetConfig()
    {
        $net_arr = [
            'NETWORK_IP' => $this->getIp(),
            'NETWORK_SUBNET' => $this->getSubnet(),
            'NETWORK_GATEWAY' => $this->getGateway(),
            'NETWORK_DNS' => $this->getDns(),
        ];
        return $net_arr;
    }


    //设置Ip和子网俺码
    public function setIp($NETWORK_IP,$NETWORK_SUBNET)
    {
        $ipStr = "ifconfig eth0 {$NETWORK_IP} netmask {$NETWORK_SUBNET}";
        shell_exec($ipStr);
    }

    //获取Ip
    public function getIp()
    {
        $ipStr = "ifconfig |grep inet| sed -n '1p'|awk '{print $2}'|awk -F ':' '{print $2}'";
        $ip = shell_exec($ipStr);
        return trim($ip);
    }


    //获取子网俺码
    public function getSubnet()
    {
        $subnetStr = "ifconfig |grep inet| sed -n '1p'|awk '{print $4}'|awk -F ':' '{print $2}'";
        $subnet = shell_exec($subnetStr);
        return trim($subnet);
    }

    //设置网关
    public function setGateway($NETWORK_GATEWAY)
    {
        $gwStr = "route add default gw {$NETWORK_GATEWAY}";
        shell_exec($gwStr);
    }

    //获取网关
    public function getGateway()
    {
        $gwStr = "route -n | grep eth0 | sed -n '1p' | awk '{print $2}'";
        $gw = shell_exec($gwStr);
        return trim($gw);
    }

    //设置DNS
    public function setDns($NETWORK_DNS)
    {
        $dnsStr = "echo 'nameserver {$NETWORK_DNS}' > /etc/resolv.conf";
        shell_exec($dnsStr);
    }

    //获取DNS
    public function getDns()
    {
        $dnsStr = "cat /etc/resolv.conf | grep nameserver  | sed -n '1p' | awk '{print $2}'";
        $dns = shell_exec($dnsStr);
        return trim($dns);
    }

    //开启DHCP
    public function openDHCP($sh_path='/usr/share/udhcpc/ip_dhcp.sh')
    {
        $this->closeDHCP();
        $dhcp_str = "udhcpc -b -S -p /var/run/udhcpc.pid -s {$sh_path}";
        shell_exec($dhcp_str);
    }

    //关闭DHCP
    public function closeDHCP()
    {
        $dhcp_str = "pkill -9 udhcpc";
        shell_exec($dhcp_str);
    }


}