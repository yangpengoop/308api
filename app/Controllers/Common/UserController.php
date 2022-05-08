<?php
namespace app\Controllers\Common;

use app\Controllers\PublicBaseController;
use Illuminate\Http\Request;
use app\Models\Admin;

class UserController extends PublicBaseController
{
    /**
     * @api {post} /user/login 1、用户登录
     * @apiSampleRequest  /user/login
     * @apiGroup Common-user
     * @apiName login
     * @apiParam {str} name 用户名
     * @apiParam {str} pass 密码
     * @apiParam {str} is_login 是否自动登录 0不登录  1 登陆
     *
     *
     */
    public function login()
    {
      //  echo "用户登录login";
       // return $this->responseSend([],1001,"账户或者密码不正确，请重新登录 ppppppppppppppp");

        $form = $this->validator([
            "name" => "string",
            "pass" => "string",
            "is_login" => "string",
        ]);
        if(empty($form['name']))return $this->responseSend([],1001,"账户或者密码不正确，请重新登录");
        if(empty($form['pass']))return $this->responseSend([],1001,"账户或者密码不正确，请重新登录");

        $userInfo = Admin::where('name',$form['name'])->where('pass',md5($form['pass']))->first();
        if(!$userInfo){
            return $this->responseSend([],1001,"账户或者密码不正确，请重新登录");
        }

        self::signIn($userInfo);

        if(isset($form["is_login"]) && $form["is_login"]!=""){
            if($form["is_login"] == 1){
                Admin::where('is_login',1)->update(['is_login'=>0]);
            }
            Admin::where('id',$userInfo['id'])->update(['is_login'=>$form['is_login']]);
        }

        
        $data['uid'] = $userInfo['id'];
        $data['name'] = $userInfo['name'];
        return $this->responseSend($data);

    }


    public function signIn($userInfo){
        $uid = $userInfo['id'];
        $cpwd = $userInfo['pass'];
        $name = $userInfo['name'];
        $is_login = $userInfo['is_login'];

        if(!isset($_SESSION)){session_start();}
        $_SESSION['loginauth'] = $uid . "|" . $cpwd . "|" . $name . "|" . $is_login;
    }

    /**
     * @api {get} /user/login-sign 2、自动登录
     * @apiSampleRequest  /user/login-sign
     * @apiGroup Common-user
     * @apiName login-sign
     *
     */
    public  function loginSign(){
        $userIsLogin= Admin::where('is_login',1)->first();
        if(!$userIsLogin){
            $this->responseSend([],1002,"没有自动登录的用户");
        }
        self::signIn($userIsLogin);
        $data['uid'] = $userIsLogin['id'];
        $data['name'] = $userIsLogin['name'];
        $this->responseSend($data);
    }

    /**
     * @api {post} /user/login-info 3、获取用户信息
     * @apiSampleRequest  /user/login-info
     * @apiGroup Common-user
     * @apiName login-info
     *
     */
    public function loginInfo(){
        if(!isset($_SESSION)){session_start();}
        if ( empty( $_SESSION['loginauth'] ) ) {return $this->responseSend([],1003,'账户未登录，请重新登录');}
        list( $id, $cpwd ,$name,$is_login) = explode( "|", $_SESSION['loginauth'] );
        if ( empty( $id )  || empty( $cpwd ) || empty( $name ) )  $this->responseSend([],1001,'账户未登录，请重新登录');
        $data['id'] = $id;
        $data['name'] = $name;
        $data['is_login'] = $is_login;
        return $this->responseSend($data);
    }

    /**
     * @api {post} /user/logout 4、用户退出
     * @apiSampleRequest  /user/logout
     * @apiGroup Common-user
     * @apiName logout
     *
     */
    public function logout(){
        if(!isset($_SESSION)){session_start();}
        session_destroy();
        Admin::where('is_login',1)->update(['is_login'=>0]);
        return $this->responseSend([],0,"退出成功");
    }

    /**
     * @api {post} /user/reset-root 5、系统设置-重置root账号
     * @apiSampleRequest  /user/reset-root
     * @apiGroup Common-user
     * @apiName reset-root
     * @apiParam {str} pass 密码
     *
     */
    public function resetRoot(){
        $form = $this->validator(["pass" => "string"]);
        if(empty($form['pass']))return $this->responseSend([],1009,"root重置的密码不能为空");
        $data = Admin::where('name',"root")->update(['pass'=>$form["pass"]]);
        return $this->responseSend($data);
    }

}