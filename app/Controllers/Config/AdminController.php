<?php
namespace app\Controllers\Config;

use app\Controllers\BaseController;
use Illuminate\Http\Request;
use app\Models\Admin;

class AdminController extends BaseController
{

    /**
     * @api {get} /admin/ 1、系统设置-用户列表
     * @apiSampleRequest  /admin
     * @apiGroup Config-system-admin
     *
     *
     */
    public function index()
    {
        $list = Admin::get();
        return $this->responseSend($list);
    }

    /**
     * @api {post} /admin/add 2、系统设置-用户新增
     * @apiSampleRequest  /admin/add
     * @apiGroup Config-system-admin
     * @apiName admin-add
     * @apiParam {str} name 用户名
     * @apiParam {str} pass 密码
     * @apiParam {str} repass 重复密码
     * @apiParam {str} is_login 自动登陆： 0否 1 是】
     *
     */
    public function add()
    {

        $form = $this->validator([
            "name" => "string",
            "pass" => "string",
            "repass" => "string",
            "is_login" => "string"

        ]);
        if(empty($form['name']))return $this->responseSend([],1001,"账户或者密码不正确，请重新登录");
        if(empty($form['pass']))return $this->responseSend([],1001,"账户或者密码不正确，请重新登录");
        if($form['pass'] != $form['repass'] )return $this->responseSend([],1006,"两次输入的密码不一致，请重新输入");

        $name = $form['name'];
        $pass= md5($form['pass']);
        $is_login = isset($form['is
        _login']) && $form['is_login']==1?$form['is_login']:0;

        $exist = Admin::where('name',$name)->exists();
        if($exist){
            return $this->responseSend([],1005,'该用户名已存在,请更换别的用户名');
        }

        if($is_login == 1){
            Admin::where('is_login',1)->update(['is_login'=>0]);
        }

        $data = Admin::create(['name'=>$name,'pass'=>$pass,"is_login"=>$is_login]);

        return $this->responseSend($data);
    }


    /**
     * @api {post} /admin/edit 3、系统设置-账号自动登陆
     * @apiSampleRequest  /admin/edit
     * @apiGroup Config-system-admin
     * @apiName admin-edit
     * @apiParam {str} name 用户名
     * @apiParam {str} pass 密码
     * @apiParam {str} repass 重复密码
     * @apiParam {int} [is_login] 【自动登陆： 0否 1 是】

     *
     */
    public function edit()
    {

        $form = $this->validator([
            "name" => "string",
            "pass" => "string",
            "repass" => "string",
            "is_login" => "string"
        ]);
        if(empty($form['name']))return $this->responseSend([],1001,"账户或者密码不正确，请重新登录");
        if(empty($form['pass']))return $this->responseSend([],1001,"账户或者密码不正确，请重新登录");
        if($form['pass'] != $form['repass'] )return $this->responseSend([],1006,"两次输入的密码不一致，请重新输入");

        $name = $form['name'];
        $pass= $form['pass'];
        $is_login = isset($form['is_login']) && $form['is_login']==1?$form['is_login']:0;
        if($is_login == 1){
            Admin::where('is_login',1)->update(['is_login'=>0]);
        }
        $data = Admin::where('name',$name)->update(['pass'=>$pass,'is_login'=>$is_login]);

        return $this->responseSend($data);
    }


    /**
     * @api {post} /admin/del 4、系统设置-用户删除
     * @apiSampleRequest  /admin/del
     * @apiGroup Config-system-admin
     * @apiName admin-del
     * @apiParam {str} name 用户名
     *
     *
     */
    public function del()
    {

        $form = $this->validator([
            "name" => "string",
        ]);
        if(empty($form['name']))return $this->responseSend([],1007,"name参数不能为空");
        if($form['name'] == 'root'){
            $this->responseSend([],1008,'该用户为系统用户不能删除');
        }

        $data = Admin::where('name',$form['name'])->delete();

        return $this->responseSend($data);
    }


}