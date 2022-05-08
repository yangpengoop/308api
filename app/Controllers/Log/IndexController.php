<?php
namespace app\Controllers\Log;
use app\Controllers\PublicBaseController;
use app\Models\ApiLog;


class IndexController extends PublicBaseController
{
    /**
     * @api {get} /log 1、日志列表
     * @apiSampleRequest  /log
     * @apiGroup log
     *
     *
     */
    public function index()
    {
        $list = ApiLog::get();
        return $this->responseSend($list);
    }

    /**
     * @api {post} /log/add 2、日志新增
     * @apiSampleRequest  /log/add
     * @apiGroup log
     * @apiName log-add
     * @apiParam {str} interface 接口
     * @apiParam {str} param 参数
     * @apiParam {str} callback  回调参数
     *
     */
    public function add()
    {
        $form = $this->validator([
            "interface" => "required|string",
            "param" => "required|string",
            "callback" => "required|string",

        ]);

        if(!isset($form['interface']) || !$form['interface']) $this->responseSend([],400,"interface参数不能为空");
        if(!isset($form['param']) || !$form['param']) $this->responseSend([],400,"param参数不能为空");
        if(!isset($form['callback']) || !$form['callback']) $this->responseSend([],400,"callback参数不能为空");

        $interface = $form['interface'];
        $param= $form['param'];
        $callback= $form['callback'];

        $data = ApiLog::create(['interface'=>$interface,'param'=>$param,'callback'=>$callback]);

        return $this->responseSend($data);
    }

    /**
     * @api {post} /log/del 3、日志删除
     * @apiSampleRequest  /log/del
     * @apiGroup log
     * @apiName log-del
     * @apiParam {str} id 日志序号
     *
     *
     */
    public function del()
    {

        $form = $this->validator([
            "id" => "required",
        ]);

        if(!isset($form['id']) || !$form['id']) $this->responseSend([],400,"id参数不能为空");

        $data = ApiLog::where('id',$form['id'])->delete();

        return $this->responseSend($data);
    }





}