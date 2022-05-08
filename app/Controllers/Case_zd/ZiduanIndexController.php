<?php
namespace app\Controllers\Case_zd;
use app\Controllers\BaseController;
use app\Exception\ApiException;
use app\Models\Ziduan;
// use app\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Database\Capsule\Manager  as DB;

class ZiduanIndexController extends BaseController
{

    public function index(){
        $list = Ziduan::orderBy("zd_sort","asc")->get();
        return $this->responseSend($list);
    }

    /**
     * @api {post} /ziduan/add 3、添加资源
     * @apiSampleRequest  /ziduan/add
     * @apiGroup Files
     * @apiName add
     *
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     *
     */
    public function add(){
        $form = Request::capture()->all();
        $zd_name = $form['zd_name'];
        $zd_cn_name = $form['zd_cn_name'];
        $zd_type = $form['zd_type'];
        $zd_sort = $form['zd_sort'];
        $zd_len = $form['zd_len'];

        $exist = Ziduan::where('zd_name',$zd_name)->exists();
        if($exist){
            return $this->responseSend([],1005,'该字段已存在,请重新输入');
        }
        // $as = "ALTER TABLE bingli_info ADD ". $zd_name ." ". $zd_type;
        // $sd = DB::statement("ALTER TABLE testadd ADD qqq varchar(32)"); //例
        $sd = DB::statement("ALTER TABLE bingli_info ADD ". $zd_name ." ". $zd_type."(".$zd_len.")");
        
        $data = Ziduan::create(['zd_name'=>$zd_name,'zd_cn_name'=>$zd_cn_name,'zd_type'=>$zd_type,'zd_sort'=> $zd_sort,'zd_len'=>$zd_len]);

        $this->responseSend($sd);
    }

    /**
     * @api {post} /ziduan/update 3、修改字段
     * @apiSampleRequest  /ziduan/add
     * @apiGroup Files
     * @apiName add
     *
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     *
     */
    public function update(){
        
        $form = Request::capture()->all();
        $zd_name = $form['zd_name'];
        $zd_cn_name = $form['zd_cn_name'];
        $zd_type = $form['zd_type'];
        $zd_sort = $form['zd_sort'];
        $zd_len = $form['zd_len'];

        if(isset($form['s'])){
            unset($form['s']);
        }
        $zd_name = $form['zd_name'];

        if(!$form['zd_name']) $this->responseSend([],400,"zd_name不存在");
        $res = Ziduan::where("id",$form["id"])->update($form);

        
        $this->responseSend($res);
    }

    /**
     * @api {post} /ziduan/showUpdateYes 4、修改字段显示及顺序
     * @apiSampleRequest  /ziduan/showUpdateYes
     * @apiGroup Files
     * @apiName add
     *
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     *
     */
    public function showUpdateYes(){
        
        $form = Request::capture()->all();
        if(isset($form['s'])){
            unset($form['s']);
        }
        foreach($form as $key => $value){
            $form[$key]['zd_sort'] =$key;
            $form[$key]['zd_show'] =1;
            $res = Ziduan::where("id",$form[$key]["id"])->update($form[$key]);
        }
        $this->responseSend($res);

        $zd_name = $form['zd_name'];

        if(!$form['zd_name']) $this->responseSend([],400,"zd_name不存在");
        $res = Ziduan::where("id",$form["id"])->update($form);

        
        $this->responseSend($res);
    }

    /**
     * @api {post} /ziduan/showUpdateNo 4、修改字段显示及顺序
     * @apiSampleRequest  /ziduan/showUpdateNo
     * @apiGroup Files
     * @apiName add
     *
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     * @apiParam {str} 
     *
     */
    public function showUpdateNo(){
        
        $form = Request::capture()->all();
        if(isset($form['s'])){
            unset($form['s']);
        }
        foreach($form as $key => $value){
            $form[$key]['zd_sort'] =$key;
            $form[$key]['zd_show'] =0;
            $res = Ziduan::where("id",$form[$key]["id"])->update($form[$key]);
        }
        $this->responseSend($res);
    }
}