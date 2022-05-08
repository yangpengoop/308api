<?php
namespace app\Controllers\Config;
use app\Controllers\BaseController;
use app\Models\Config;
use Illuminate\Http\Request;

class VideoController extends BaseController
{
    /**
     * @api {get} /video 1、录像设置-列表
     * @apiSampleRequest  /video
     * @apiGroup Config-video
     * @apiName video-list
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

        return $this->responseSend($keyData);
    }



    /**
     * @api {post} /video/edit 2、录像设置-编辑
     * @apiSampleRequest  /video/edit
     * @apiGroup Config-video
     * @apiName video-edit
     * @apiParam {str} [key] 键名 样例：{key:value}
     *
     */
    public function edit()
    {
        $form = Request::capture()->all();
        if(!$form){
            return $this->responseSend([],0,'参数不能为空');
        }

        $form = $this->validator([
            "key" => "required",
        ]);
        if($form['key'] && is_array($form['key'])){
            $keys = $form['key'];
        }else{
            $keys = $form['key'] ? json_decode($form['key'],true):'';
        }

        if(!$keys || !is_array($keys))  return $this->responseSend('',422,'key值不能为空且必须为合法的json格式');

        $edit_status = [];
        foreach ($keys as $key =>$value){
            $data = Config::where('key',$key)->update(['value'=>$value]);
            $edit_status[$key] = $data == 1?'success':'fail';
        }

        return $this->responseSend($edit_status);
    }


}