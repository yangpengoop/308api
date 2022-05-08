<?php
namespace app\Traits;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as R;
use Rester\Validator;
use Illuminate\Http\Request;

trait ControllerTrait{
    //统一输出模板
    function responseSend($content = [],$code = 0,$message = "" ,$status = 200){
        $data = [];
        $data["data"] = $content;
        $data["code"] = $code;
        $data["message"] = $message;
        R::create(json_encode($data),$status)->send();
        die();
    }

    //前端数据验证
    function validator($rules){
        $data = Request::capture()->all();
        $result = Validator::validators($rules,$data);
        if (!$result) {
            throw new ValidationException($result);
        }
        return $data;
    }
}