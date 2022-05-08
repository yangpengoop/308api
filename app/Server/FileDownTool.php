<?php
namespace app\Server;

class FileDownTool{
    public $root_filePath;

    public function __construct($rootFilePath='')
    {
        if(!$rootFilePath) $rootFilePath = env("WEB_PATH")."datas/";
        $this->root_filePath = $rootFilePath;
        $this->nginx_location = env("NGINX_DOWN");

    }

    public function setHeader($filePath,$fileName)
    {
        $filePath = $this->nginx_location.$filePath;
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Content-Type: application/octet-stream");
        header('X-Accel-Redirect: '.$filePath);
    }

    public function download($filePath='')
    {

        $filePath = ltrim($filePath,'/');
        $file = $this->root_filePath.$filePath;
        if(!file_exists($file)) {
            echo "<h1>文件不存在<h1>";
            exit;
        }
        $fileName = basename($filePath);
        $this->setHeader($filePath,$fileName);
        exit;
    }

}