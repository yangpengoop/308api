<?php
namespace app\Controllers\Init;
use app\Controllers\PublicBaseController;
use app\Server\Net;
class IndexController extends PublicBaseController
{
    public $net;
    public function __construct()
    {
        $this->net = new Net();
    }

    /**
     * @api {get} /init 1、初始化
     * @apiSampleRequest  /init
     * @apiGroup Init
     * @apiName index
     */
    public function index()
    {

        //网络初始化
      $net_data = $this->net->netInit();

        //时间初始化


      $this->responseSend($net_data['net_arr'],0,$net_data['msg']);
    }
}