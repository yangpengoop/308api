<?php
namespace app\Controllers;
use app\Traits\ControllerTrait;
use app\Models\Admin;
/**
 * BaseController
 */
class BaseController
{
    use ControllerTrait;
    public function __construct(){
//        self::apiCheckauth();
    }
    public function BaseController(){
        $this->__construct();
    }

    public function apiCheckauth(){
        if(!isset($_SESSION)){session_start();}
        if ( empty( $_SESSION['loginauth'] ) ) {return $this->responseSend([],'1003','账户未登录，请重新登录');}
    }

}