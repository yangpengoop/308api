<?php
namespace app\Server;

use Exception;

class pkgTool{

    public $srcFilePath;//源文件路径


    //检查文件是否存在
    public function checkFile($srcFilePath='')
    {
        if (!file_exists($srcFilePath))
            throw new Exception("{$srcFilePath}文件不存在");
        $this->srcFilePath = $srcFilePath;
    }

    //检查路径是否存在
    public function checkPath($path)
    {
        if(!is_dir($path) && !mkdir($path,0777,true))
            throw new Exception("{$path}路径不存在");
    }


    //解压
    public function deCode($srcFilePath,$distPath)
    {
        shell_exec("unzip -o {$srcFilePath} -d {$distPath}");
    }


    /**扫描文件夹
     * @param $tempPath
     * @param $is_cover 是否覆盖
     * @return array
     * @throws Exception
     */
    public function scanDir($tempPath)
    {
        $templeteArr = [];
        $tempPath = rtrim($tempPath,'/').'/';
        $distPath_arr = scandir($tempPath);

        foreach ($distPath_arr as $dir){
            if($dir == '.' || $dir == '..') continue;
            $dirPath = $tempPath.$dir.'/';
            if(!is_dir($dirPath)) continue;
            $configPath = $dirPath . "config.json";
            $templetePath = $dirPath . "templete.html";

            if(!file_exists($configPath)) throw new Exception("{$dir}文件夹下缺失config.json文件");
            if(!file_exists($templetePath)) throw new Exception("{$dir}文件夹下缺失templete.html文件");
            $templeteArr[] = $dir;
        }

        if(!$templeteArr) throw new Exception("找不到模板文件夹，请检测路径格式是否正确");

        return $templeteArr;
    }

    public function copyDir($srcDir,$distDir)
    {
        shell_exec("cp -r {$srcDir} $distDir");
    }

    public function clearDir($tempPath)
    {
        if ($tempPath == '/') throw new Exception("不能删除根目录");
        shell_exec("cd $tempPath && rm -rf ./*");
    }

    /**
     * @param $srcFilePath  源压缩包文件
     * @param $tempPath  解压后临时存放路径
     * @param $finalPath  最终存放路径
     * @throws Exception
     */
    public function deTempletePkg($param)
    {
        $srcFilePath = isset($param['srcFilePath'])?$param['srcFilePath']:'';
        $tempPath = isset($param['tempPath'])?$param['tempPath']:'';
        $finalPath = isset($param['finalPath'])?$param['finalPath']:'';
        $is_cover = isset($param['is_cover'])?$param['is_cover']:false;
        $templete_arr = isset($param['templete_arr'])?$param['templete_arr']:[];
        try{
            $this->checkFile($srcFilePath);
            $this->checkPath($tempPath);
            $this->checkPath($finalPath);
            $this->deCode($srcFilePath,$tempPath);
            $templeteArr = $this->scanDir($tempPath);
            if ($templeteArr){
                foreach ($templeteArr as $dir){
                    $dirPath = $tempPath.'/'.$dir.'/';
                    $dirPath_rename = $tempPath.'/'.$dir.'_'.rand(1,9999).'/';

                    if (in_array($dir,$templete_arr) && !$is_cover && rename($dirPath,$dirPath_rename)){//不覆盖
                        $dirPath = $dirPath_rename;
                    }
                    $this->copyDir($dirPath,$finalPath);
                }
            }
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }
}