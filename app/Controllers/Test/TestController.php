<?php

namespace app\Controllers\Test;

use app\Controllers\PublicBaseController;
use app\Server\MountTool;
use app\Models\Report;
class TestController extends PublicBaseController
{


    /**
     * @api {get} /test 1、专门用于测试的控制器
     * @apiSampleRequest  /test
     * @apiGroup test
     * @apiName test
     */
    public function test()
    {
        // $mountTool = new MountTool();
        // $mountTool->mountFixedDisk();
        //        $a = $mountTool->getDiskDriveInfo();
        //        var_export($a);
        //        $b = $mountTool->getMountInfo();
        //        var_export($b);

        $form = $this->validator([
            "name" => "string",
            "created_at" => "string",
        ]);
            
            
            var_dump($form);
            $list = Report::query()
            ->where(function($query) use($form){
        // $list=Report::join('patient_case', 'patient_case.id', '=', 'report.patient_id')
        // ->where(function($query) use($form){
                isset($form["name"]) && $query->where("name","like","%".$form["name"]."%");
                isset($form["created_at"]) && $query->where("created_at","like","%".$form["created_at"]."%");
            })
            ->orderBy("id","desc")->get();
            var_dump( $list);
        return $this->responseSend($list);

        // $this->mountTool->mountFixedDisk();
        // $diskInfo = $this->mountTool->getDisk_run();
        // $this->responseSend($diskInfo);

        // $info = $mountTool->getDisk_run();

        // $this->responseSend($info);
    }


    public function testt()
    {
        echo "进入到test1测试函数";
    }

}
