<?php
namespace app\Server;

class TempleteTool{

    public $reportPath;

    public function __construct()
    {
        $this->reportPath = STORAGE_PATH.'/report';

    }

    //检测模板key值是否存在
    public function checkKeyPath($key)
    {
        $path = $this->reportPath.'/'.$key;
        if (is_dir($path)) return true;
        return false;
    }

    //检测模板key值的config文件是否存在
    public function checkConfigPath($key)
    {
        $path = $this->reportPath.'/'.$key.'/config.json';
        if (!file_exists($path)) return false;
        return $path;
    }

    //检测模板key值的模板文件是否存在
    public function checkTempletePath($key)
    {
        $path = $this->reportPath.'/'.$key.'/templete.html';
        if (!file_exists($path)) return false;
        return $path;
    }


    //获取config配置数据
    public function getConfig($key)
    {
        if(!$this->checkConfigPath($key)) return [];
        $config = file_get_contents($this->checkConfigPath($key));
        $config = json_decode($config,true);
        if(!is_array($config)) return [];
        return $config;
    }

    //获取模板html
    public function getTemplete($key)
    {
        $path = $this->checkTempletePath($key);
        if(!$path) return '';
        return file_get_contents($path);
    }


    //模板变量替换
    public function replaceHtml($templete_html,$config,$form)
    {
        $finalHtml = $templete_html;
        $configWithValue = $config;
        foreach ($config['form'] as $key => $value){
            $v = isset($form[$value['key']])?$form[$value['key']]:'';
            $configWithValue['form'][$key]['value'] = $v;
            $finalHtml = preg_replace("/{{".$value['key']."}}/",$v,$finalHtml);
        }

        $data = [
            'templete_html' => $templete_html,
            'config' => json_encode($config,320),
            'config_value' => json_encode($configWithValue,320),
            'templete_final' => $finalHtml,
        ];
        return $data;
    }


}