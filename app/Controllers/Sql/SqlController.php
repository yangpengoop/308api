<?php
namespace app\Controllers\Sql;
use app\Controllers\PublicBaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Capsule\Manager  as DB;

class SqlController extends PublicBaseController
{

    /**
     * @api {post} /select 1、sql查询
     * @apiSampleRequest  /select
     * @apiGroup Sql
     * @apiName select
     *
     * @apiParam {string} Sql sql查询语句
     *
     */
    public function selectSql(){
        $form = Request::capture()->all();
        $re = DB::select($form['Sql']);
        $this->responseSend($re);
    }

    /**
     * @api {post} /insert 2、sql插入
     * @apiSampleRequest  /insert
     * @apiGroup Sql
     * @apiName insert
     *
     * @apiParam {string} Sql sql查询语句
     *
     */
    public function insertSql(){
        $form = Request::capture()->all();
        $re = DB::insert($form['Sql']);
        $this->responseSend($re);
    }

    /**
     * @api {post} /update 3、sql更新
     * @apiSampleRequest  /update
     * @apiGroup Sql
     * @apiName update
     *
     * @apiParam {string} Sql sql查询语句
     *
     */
    public function updateSql(){
        $form = Request::capture()->all();
        $re = DB::update($form['Sql']);
        $this->responseSend($re);
    }

    /**
     * @api {post} /delete 4、sql删除
     * @apiSampleRequest  /delete
     * @apiGroup Sql
     * @apiName delete
     *
     * @apiParam {string} Sql sql查询语句
     *
     */
    public function deleteSql(){
        $form = Request::capture()->all();
        $re = DB::delete($form['Sql']);
        $this->responseSend($re);
    }
}