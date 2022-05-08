<?php
namespace app\Controllers\Report;

use app\Controllers\BaseController;
use app\Server\pkgTool;
use app\Server\TempleteTool;
use app\Server\UploadFileTool;
use Exception;
use Illuminate\Http\Request;


class TemplateController extends BaseController
{
    public $TempleteTool;

    public function __construct()
    {
        $this->TempleteTool = new TempleteTool();
    }

    /**
     * @api {get} /templete 1、模板列表
     * @apiSampleRequest  /templete
     * @apiGroup templete
     * @apiName list
     *
     */
    public function index()
    {

        $data = $this->getTempleteList();
        $this->responseSend($data);
    }

    //获取模板列表
    function getTempleteList()
    {
        $temp_arr = scandir($this->TempleteTool->reportPath);
        $data = [];
        foreach ($temp_arr as $tempDir){
            if($tempDir == '.' || $tempDir == '..') continue;

            $config = $this->TempleteTool->getConfig($tempDir);
            if(!is_array($config) || !$config) continue;

            $data[] = [
                'key' =>   $tempDir,
                'config' => $config
            ];
        }
        return $data;
    }

    /**
     * @api {post} /templete/templ-Form 1、模板表单
     * @apiSampleRequest  /templete/templ-Form
     * @apiGroup templete
     * @apiName templ-Form
     * @apiParam {str} key 模板key值
     */
    public function templForm()
    {
        $form = Request::capture()->all();
        if(!isset($form['key']) || !$form['key']) $this->responseSend([],400,"key参数不能为空");

        $config = $this->TempleteTool->getConfig($form['key']);
        if(!is_array($config) || !$config) $this->responseSend([],400,"该模板的配置文件异常");
        $this->responseSend($config,0,"配置数据获取成功");
    }

    /**
     * @api {post} /templete/templ-upload 1、模板上传
     * @apiSampleRequest  /templete/templ-upload
     * @apiGroup templete
     * @apiName templ-upload
     * @apiParam {file} file 模板压缩包，zip格式
     * @apiParam {str} is_cover 模板名称相同是否进行覆盖文件 1:不覆盖 ，2：覆盖
     *
     */
    public function templUpload()
    {
        $form = $form = Request::capture()->all();
        $is_cover = isset($form['is_cover']) && $form['is_cover'] == 2 ?true:false;
        $templete_arr=[];
        if(!$is_cover){
            $templete_data = $this->getTempleteList();
            if ($templete_data){
                foreach ($templete_data as $val){
                    $templete_arr[] = $val['key'];
                }
            }
        }

        $uplaodTool = new UploadFileTool();
        $pkgTool = new pkgTool();
        $uploadPath = STORAGE_PATH.'/templete_tmp_file';//临时存放路径
        $tempPath = STORAGE_PATH.'/templete_tmp_file';//解压临时存放路径
        $reportPath = STORAGE_PATH.'/report';
        try{
            $suffix = 'zip';
            $uplaodTool->setSuffix($suffix);
            $distFilePath = $uplaodTool->uploadFile('file',$uploadPath);
            $param = [
                'srcFilePath' => $distFilePath,
                'tempPath' => $tempPath,
                'finalPath' => $reportPath,
                'is_cover' => $is_cover,
                'templete_arr' => $templete_arr
            ];
            $pkgTool->deTempletePkg($param);
            $pkgTool->clearDir($tempPath);//清理临时文件
            $this->responseSend([],0,"文件上传成功");
        }catch (Exception $e){
            $res = $e->getMessage();
        }
        $pkgTool->clearDir($tempPath);
        $this->responseSend([],400,$res);
    }


}