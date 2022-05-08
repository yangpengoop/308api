<?php
namespace app\Exception;
use Exception as SysE;
use app\Traits\ControllerTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
/**
 * 1001  账户或者密码不正确，请重新登录
 * 1002  没有自动登录的用户
 * 1003  账户未登录，请重新登录
 * 1004
 * 1005  该用户名已存在,请更换别的用户名
 * 1006  两次输入的密码不一致，请重新输入
 * 1007  删除的用户不存在
 * 1008  该用户为系统用户不能删除
 *
 */
class Exception{
    use ControllerTrait;
    function __construct(SysE $e)
    {
        if($e instanceof ModelNotFoundException){
            return $this->responseSend("",404,$e->getMessage());
        }else if($e instanceof NotFoundHttpException){
            return $this->responseSend("",404,$e->getMessage());
        }else if($e instanceof ValidationException){
            return $this->responseSend("",$e->status,$e->errors());
        }
        else if($e instanceof IOExceptionInterface ){
            $this->responseSend($e->getPath(),1000);
        }
        else if($e instanceof ApiException){
            $this->responseSend($e->getMessage(),500);
        }
        else{
            $this->responseSend($e->getMessage() . $e->getTraceAsString(),500);
        }
    }
}