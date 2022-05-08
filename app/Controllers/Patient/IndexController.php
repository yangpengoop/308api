<?php
namespace app\Controllers\Patient;
use app\Controllers\BaseController;
use app\Models\PatientCase;
use app\Models\Files;
use app\Models\Ziduan;
use Illuminate\Http\Request;
use Illuminate\Database\Capsule\Manager  as DB;
use Symfony\Component\Filesystem\Filesystem;

class IndexController extends BaseController
{
    /**
     * @api {get} /patient 1、病人列表
     * @apiSampleRequest  /patient
     * @apiGroup Patient
     * @apiName list
     *
     * @apiParam {str} [name] 过滤名字
     * @apiParam {str} [sex] 性别
     * @apiParam {str} [surgery_date] 手术日期
     * @apiParam {str} [hospital_number] 住院号
     * @apiParam {str} [bed_number] 床位号
     * @apiParam {str} [department] 科室
     * @apiParam {str} [operating_room] 手术室
     * @apiParam {str} [surgery_name] 手术名称
     * @apiParam {str} [age] 年龄
     * @apiParam {str} [ward] 病区
     * @apiParam {str} [surgery_doctor] 手术医生
     * @apiParam {str} [created_at] 创建时间
     *
     */
    public function index()
    {
        $form = $this->validator([
            "name" => "string",
            "created_at" => "string",
        ]);
        $zd_list = Ziduan::where('zd_show',1)->orderBy("zd_sort","asc")->pluck('zd_name');
        $model = new PatientCase();
        foreach ($zd_list as $k=>$list){

            if($k==0){
                $res = $model->select($list);
                
            }else{
                $res = $res->addSelect($list);
            }

            // if($k==count($zd_list)-1){
            //     $res = $res->addSelect("id");
            // }
            
        }

        // $res = $model->select('age');
        // $res->addSelect('zhuyh');
        // $list = $res->orderBy("id","desc")->get();
        // $str = implode(",",$zd_list->toArray());
    //    sleep(1);
        $list = $res
            ->where(function($query) use($form){
                isset($form["zhuyh"]) && $query->where("name","like","%".$form["zhuyh"]."%");
                isset($form["xingm"]) && $query->where("sex","like","%".$form["xingm"]."%");
                isset($form["xingb"]) && $query->where("xingb","like","%".$form["xingb"]."%");
                isset($form["age"]) && $query->where("age","like","%".$form["age"]."%");
                isset($form["jcxm"]) && $query->where("jcxm","like","%".$form["jcxm"]."%");
                isset($form["department"]) && $query->where("department","like","%".$form["department"]."%");
                isset($form["operating_room"]) && $query->where("operating_room","like","%".$form["operating_room"]."%");
                isset($form["surgery_name"]) && $query->where("surgery_name","like","%".$form["surgery_name"]."%");
                isset($form["age"]) && $query->where("age","like","%".$form["age"]."%");
                isset($form["ward"]) && $query->where("ward","like","%".$form["ward"]."%");
                isset($form["surgery_doctor"]) && $query->where("surgery_doctor","like","%".$form["surgery_doctor"]."%");
                isset($form["created_at"]) && $query->where("created_at","like","%".$form["created_at"]."%");
            })
            ->orderBy("id","desc")->get();
        return $this->responseSend($list);
    }

    /**
     * @api {post} /patient/add 查询字段显示
     * @apiSampleRequest  /patient/add
     * @apiGroup Patient
     * @apiName add
     *
     *
     */
    public function zd_index(){
        $list = Ziduan::orderBy("zd_sort","asc")->where('zd_show',1)->pluck('zd_cn_name');
        return $this->responseSend($list);
    }

    /**
     * @api {post} /patient/add 查询字段显示
     * @apiSampleRequest  /patient/add
     * @apiGroup Patient
     * @apiName add
     *
     *
     */
    public function zd_indexs(){
        $list = Ziduan::orderBy("zd_sort","asc")->where('zd_show',1)->pluck('zd_cn_name');
        return $this->responseSend($list);
    }

    /**
     * @api {post} /patient/add 2、添加病人
     * @apiSampleRequest  /patient/add
     * @apiGroup Patient
     * @apiName add
     *
     * @apiParam {str} name 名字
     * @apiParam {str} [sex] 性别
     * @apiParam {str} [surgery_date] 手术日期
     * @apiParam {str} [hospital_number] 住院号
     * @apiParam {str} [bed_number] 床位号
     * @apiParam {str} [department] 科室
     * @apiParam {str} [operating_room] 手术室
     * @apiParam {str} [surgery_name] 手术名称
     * @apiParam {str} [age] 年龄
     * @apiParam {str} [ward] 病区
     * @apiParam {str} [surgery_doctor] 手术医生
     *
     */
    public function add(){
        $request = Request::capture();
        $hospital_number = $request['zhuyh'];
        $exist = PatientCase::where('zhuyh',$hospital_number)->exists();
        if($exist){
            return $this->responseSend([],1005,'该住院号已存在,请输入正确的住院号');
        }
        $data= PatientCase::create($request->all());
        return $this->responseSend($data);
    }

    /**
     * @api {post} /patient/edit 3、编辑病人
     * @apiSampleRequest  /patient/edit
     * @apiGroup Patient
     * @apiName edit
     *
     * @apiParam {int} id 病人id
     * @apiParam {str} name 名字
     * @apiParam {str} [sex] 性别
     * @apiParam {str} [surgery_date] 手术日期
     * @apiParam {str} [hospital_number] 住院号
     * @apiParam {str} [bed_number] 床位号
     * @apiParam {str} [department] 科室
     * @apiParam {str} [operating_room] 手术室
     * @apiParam {str} [surgery_name] 手术名称
     * @apiParam {str} [age] 年龄
     * @apiParam {str} [ward] 病区
     * @apiParam {str} [surgery_doctor] 手术医生
     *
     */
    public function edit(){
        $form = Request::capture()->all();
        if(isset($form['s'])){
            unset($form['s']);
        }
        if(!$form['zhuyh']) $this->responseSend([],400,"zhuyh不能为空");
        $res = PatientCase::where("zhuyh",$form["zhuyh"])->update($form);
        $this->responseSend($res);
    }

    /**解决录像不正常结束后的文件显示问题 */
    public function file_edit(){
        $form = Request::capture()->all();
        if(!$form['id']) $this->responseSend([],400,"id参数不能为空");
        if(isset($form['record_files'])){
            $res = PatientCase::where('id',$form['id'])->update(['record_files'=>$form['record_files'],'record_status'=>$form['record_status']]);
        }else{
            $res = PatientCase::where('id',$form['id'])->update(['record_status'=>$form['record_status']]);
        }
        
        $this->responseSend($res);
    }
/**解决录像不正常结束后的文件显示问题 */
    public function file_edit_stop(){
        $form = Request::capture()->all();
        if(!$form['id']) $this->responseSend([],400,"id参数不能为空");
            $res = PatientCase::where('id',$form['id'])->update(['record_status'=>$form['record_status']]);
        
        $this->responseSend($res);
    }
    
    /**
     * @api {post} /patient/delete 4、删除病人
     * @apiSampleRequest  /patient/delete
     * @apiGroup Patient
     * @apiName delete
     *
     * @apiParam {int} id 病人id
     * @apiParam {int} type 文件类型  1录像文件 2捉拍文件  4所以文件和病人信息
     *
     */
    public function delete(){
        error_log("in to delete \n",   3,   "/link/web/core309_local/errors.log");
        $form = Request::capture()->all();
        if(!$form['id']) $this->responseSend([],400,"id参数不能为空");
        $field = "type";
        if($form["type"] == 1) {
            $ids = [2];
        }else if($form["type"] == 2) {
            $ids = [1];
        }else if($form["type"] == 3) {
            $ids = [1,2];
        }else if($form["type"] >= 4) {
            $ids = [1,2];
            $row = PatientCase::findOrFail($form["id"])->delete();
        }
        $where = function ($query) use( $field , $ids ){
            $query->whereIn( $field, $ids );
        };
        $list = Files::query()
            ->where("patient_case_id",$form["id"])
            ->where($where)
            ->orderBy("id","desc")->get();
        $fs = new Filesystem();
        
        foreach ($list as $key => $value){  
            Files::findOrFail($value["id"])->delete();
           $path = env("WEB_PATH")."datas" . $value["path"];
            error_log($path.":in to path \n",   3,   "/link/web/core309_local/errors.log");
            $ppp="/link/web/".$path;
            error_log($ppp.":in to ppp \n",   3,   "/link/web/core309_local/errors.log");
            $fs->remove($ppp);
        }
        $this->responseSend();
    }

    /**
     * @api {get} /patient/time-index 5、时间检索导航
     * @apiSampleRequest  /patient/time-index
     * @apiGroup Patient
     * @apiName time-index
     *
     *
     */
    public function timeIndex()
    {
        // $sql = "select substr(created_at,0,11) as dateTime from bingli_info 
        //         group by dateTime ORDER by dateTime DESC ";
        $sql = "select created_at as dateTime from bingli_info 
                group by dateTime ORDER by dateTime DESC ";
        $res = DB::select($sql);
        // $res =DB::table('bingli_info')->select(DB::raw("date_format(created_at,'%Y-%m-%d %H:%i:%s')"),"created_at")->get();
        // $this->responseSend($res);
//        var_export($res);exit;
        // $res = PatientCase::orderBy("created_at","asc")->whereNotNull('created_at')->pluck("created_at");
        // $this->responseSend($res);
        $date=[];
        foreach ($res as $val){
            $created_at = $val->dateTime;
            if(!$created_at) continue;
            $date_time = explode('-',$created_at); //0:年 1:月 2:日
            $year = $date_time[0];
            $month = $date_time[1];
            $day = substr($date_time[2],0,2);
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