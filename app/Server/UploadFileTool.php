<?php
namespace app\Server;

use Exception;

class UploadFileTool{

    public $tempFile=null;
    public $distPath=null;
    public $preg=null;
    public $suffix=null;

    //接收临时文件
    public function file($fileStr='file')
    {

        if (!isset($_FILES[$fileStr]) || !$_FILES[$fileStr])
            throw new Exception("{$fileStr} 参数下的文件找不到");
        if (!is_uploaded_file($_FILES[$fileStr]['tmp_name']))
            throw new Exception("非POST方式上传，文件上传失败");
        return $this->tempFile = $_FILES[$fileStr];
    }

    //检查路径是否存在
    public function checkPath($path)
    {
        if(!is_dir($path) && !mkdir($path,0777,true))
            throw new Exception('目标路径不存在');
        $this->distPath = $path;
    }

    //设置文件名后缀
    public function setSuffix($str="*")
    {
        switch ($str){
            case 'zip':
                $pregStr = '/.*\.zip$/';
                break;
            case 'rar':
                $pregStr = '/.*\.rar$/';
                break;
            default:
                $pregStr = '/.*$/';
                break;
        }
        $this->suffix = $str;
        $this->preg = $pregStr;
    }

    //检查文件名后缀
    public function checkFileFormat()
    {
        if($this->preg && !preg_match($this->preg,($this->tempFile)['name']))
            throw new Exception("文件名不合法,后缀名必须为{$this->suffix}格式");
    }

    //移动文件
    public function move($distFileName)
    {
        if (!$this->tempFile) throw new Exception("缓存文件不存在");
        $temp_file = ($this->tempFile)['tmp_name'];
        if(!$distFileName) $distFileName = ($this->tempFile)['name'];
        $distFilePath = rtrim($this->distPath,'/').'/'.$distFileName;
        if(!move_uploaded_file($temp_file,$distFilePath) || !file_exists($distFilePath))
            throw new Exception("文件移动失败");
        return $distFilePath;
    }

    //处理文件
    public function uploadFile($fileStr,$distPath,$distFileName='')
    {
        try{
            $this->file($fileStr);
            $this->checkPath($distPath);
            $this->checkFileFormat();
            $distFilePath = $this->move($distFileName);
            return $distFilePath;
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}