<?php
namespace app\Controllers\Report;

use app\Controllers\BaseController;
use app\Models\Report;
use Illuminate\Http\Request;
use app\Server\TempleteTool;
use Illuminate\Database\Capsule\Manager  as DB;

class ReportController extends BaseController
{
    public $TempleteTool;

    public function __construct()
    {
        $this->TempleteTool = new TempleteTool();
    }

    /**
     * @api {get} /report 1、报告列表
     * @apiSampleRequest  /report
     * @apiGroup report
     * @apiName list
     *
     *a.'updated_at',
     */
    public function index()
    {
        error_log("搞砸了!\n",   3,   "/root/errors.log");
        $form = $this->validator([
            "name" => "string",
            "created_at" => "string",
        ]);

        $data = DB::select("select a.id,a.`name`,a.patient_id,b.name as patient_name,a.updated_at as updated_at ,a.created_at as created_at
                            from report a
                            left join patient_case b on b.id = a.patient_id
                            where a.created_at like '%".$form["created_at"]."%'
                            order by a.id DESC 
                            ");
        error_log("搞砸了2!",   3,   "/root/errors.log");
        $this->responseSend($data);

        // $form = $this->validator([
        //     "name" => "string",
        //     "created_at" => "string",
        // ]);
        // $list = Report::query()
        //     ->where(function($query) use($form){
        //         isset($form["name"]) && $query->where("name","like","%".$form["name"]."%");
        //         isset($form["created_at"]) && $query->where("created_at","like","%".$form["created_at"]."%");
        //     })
        //     ->orderBy("id","desc")->get();
        // return $this->responseSend($list);


    }

    /**
     * @api {get} /report/detail 2、获取报告详情
     * @apiSampleRequest  /report/detail
     * @apiGroup report
     * @apiParam {int} id 报告id
     *
     */
    public function detail()
    {
        $form = Request::capture()->all();
        if(!isset($form['id']) || !$form['id']) $this->responseSend([],400,"id参数不能为空");
        $data = Report::select('id','config_value','name','patient_id')->where('id',$form['id'])->first();
        $config_value = json_decode($data['config_value'],true);
        $data['config_value'] = $config_value['form'];
        $this->responseSend($data,0,'获取成功');
    }

    /**
     * @api {post} /report/add 3、添加报告
     * @apiSampleRequest  /report/add
     * @apiGroup report
     * @apiName add
     * @apiParam {str} patient_id 病人id
     * @apiParam {str} name 报告名称
     * @apiParam {str} key 模板key
     * @apiParam {str} form 值为json字符串 例如：{"Patient_name":"李四","Hospital_name":"歼击机互联网医院"}
     *
     */
    public function add()
    {
        $form = Request::capture()->all();
        if(!isset($form['patient_id']) || !$form['patient_id']) $this->responseSend([],400,"patient_id参数不能为空");
        if(!isset($form['key']) || !$form['key']) $this->responseSend([],400,"key参数不能为空");
        if(!isset($form['name']) || !$form['name']) $this->responseSend([],400,"name参数不能为空");
        if(!isset($form['form']) || !$form['form']) $this->responseSend([],400,"from参数不能为空");
        if(!$this->TempleteTool->checkKeyPath($form['key'])) $this->responseSend([],400,"key值不合法");

        $key = $form['key'];

        $form_arr = $this->dealFormData($form);

        $config = $this->TempleteTool->getConfig($key);
        $templete_html = $this->TempleteTool->getTemplete($key);
        $data = $this->TempleteTool->replaceHtml($templete_html,$config,$form_arr);

        $data['name'] = $form['name'];
        $data['patient_id'] = $form['patient_id'];
        $id = Report::create($data);
        $this->responseSend($id,0,'创建成功');
    }


    /**
     * @api {post} /report/edit 4、编辑报告
     * @apiSampleRequest  /report/edit
     * @apiGroup report
     * @apiName edit
     * @apiParam {str} id 报告id
     * @apiParam {str} patient_id 病人id
     * @apiParam {str} name 报告名称
     * @apiParam {str} form 值为json字符串 例如：{"Patient_name":"李四","Hospital_name":"歼击机互联网医院"}
     *
     */
    public function edit()
    {
        $form = Request::capture()->all();
        //if(!isset($form['patient_id']) || !$form['patient_id']) $this->responseSend([],400,"patient_id参数不能为空");
        if(!isset($form['name']) || !$form['name']) $this->responseSend([],400,"name参数不能为空");
        if(!isset($form['form']) || !$form['form']) $this->responseSend([],400,"from参数不能为空");

        $form_arr = $this->dealFormData($form);

        $res = Report::where('id',$form['id'])->first();
        if(!$res) return ['code'=>'false','msg'=>'id值不存在'];
        $config = json_decode($res['config'],true);
        $templete_html = $res['templete_html'];

        $data = $this->TempleteTool->replaceHtml($templete_html,$config,$form_arr);
        if(isset($data['code'])) $this->responseSend([],400,$data['msg']);
        $data['name'] = $form['name'];
        //$data['patient_id'] = $form['patient_id'];
        $res = Report::where(['id'=>$form['id']])->update($data);
        if ($res) $this->responseSend($res,0,'编辑成功');
        $this->responseSend($res,400,'编辑失败');
    }

    /**
     * @api {post} /report/del 5、删除报告
     * @apiSampleRequest  /report/del
     * @apiGroup report
     * @apiName del
     * @apiParam {str} id 报告id
     *
     */
    public function del()
    {
        $form = Request::capture()->all();
        if(!isset($form['id']) || !$form['id']) $this->responseSend([],0,"id参数不能为空");

        $res = Report::where(['id'=>$form['id']])->delete();

        if ($res) $this->responseSend($res,0,'删除成功');
        $this->responseSend($res,400,'删除失败');
    }

    /**
     * @api {get} /report/view 6、预览报告
     * @apiSampleRequest  /report/view
     * @apiGroup report
     * @apiName view
     * @apiParam {str} id 报告id
     *
     */
    public function view()
    {
        $form = Request::capture()->all();
        if(!isset($form['id']) || !$form['id']) $this->responseSend([],0,"id参数不能为空");
        $html = "<h3>不存在该报告!<h3>";
        $data = Report::select('templete_final')->where('id',$form['id'])->first();
        if ($data) {
           $html = $data['templete_final'];
        }
        echo $html;exit;
    }


    function dealFormData($form)
    {
        $form_temp_arr = json_decode($form['form'],true);
        if (!is_array($form_temp_arr)) $this->responseSend([],400,"form参数的值必须为合法json字符串");
        $form_arr = [];
        foreach ($form_temp_arr as $key => $value){
            $form_arr[$key] = $value;
        }

        return $form_arr;
    }

    /**
     * @api {get} /report/timeIndex 7、时间检索导航
     * @apiSampleRequest  /report/timeIndex
     * @apiGroup Report
     * @apiName timeIndex
     *
     *
     */
    public function timeIndex()
    {
        $sql = "select substr(created_at,0,11) as dateTime from report 
                group by dateTime ORDER by dateTime DESC ";
        $res = DB::select($sql);
//        var_export($res);exit;
        $date=[];
        foreach ($res as $val){
            $created_at = $val->dateTime;
            if(!$created_at) continue;
            $date_time = explode('-',$created_at); //0:年 1:月 2:日
            $year = $date_time[0];
            $month = $date_time[1];
            $day = $date_time[2];
            if(!isset($date[$year]))
                $date[$year] = ['time'=>$year,'name'=>$year,'son'=>[]];
            if(!isset($date[$year]['son'][$month]))
                $date[$year]['son'][$month] = ['time'=>$year.'-'.$month,'name'=>$month,'son'=>[]];
            $date[$year]['son'][$month]['son'][]= ['time'=>$year.'-'.$month.'-'.$day,'name'=>$day];
        }

        $date = array_values($date);
        $count = count($date);
        for ($i=0;$i<$count;$i++){
            $date[$i]['son'] = array_values($date[$i]['son']);
        }

        $this->responseSend($date);
    }


}