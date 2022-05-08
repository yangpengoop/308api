<?php
namespace app\Controllers\Files;
use app\Controllers\BaseController;
use app\Exception\ApiException;
use app\Models\Files;
use app\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Database\Capsule\Manager  as DB;

class IndexController extends BaseController
{
    /**
     * @api {get} /files 1、病人资源列表（不包括录制中）
     * @apiSampleRequest  /files
     * @apiGroup Files
     * @apiName list
     *
     * @apiParam {str} patient_case_id 病人病历id
     *
     */
    public function index()
    {
        $form = Request::capture()->all();
        if(!isset($form['patient_case_id']) || !$form['patient_case_id']) $this->responseSend([],400,"病人病历id不能为空");
        $list = Files::query()->where("patient_case_id",$form["patient_case_id"])->where('status', '<>', 0)->orderBy("id","desc")->get();
        foreach ($list as $k=>$item){
            $list[$k]['webPath'] = "/datas" . $item["path"];
            // $list[$k]['webPath'] = str_replace("/record","",$item["path"]);
            $list[$k]['wgetPath'] = str_replace("/record","",$item["path"]);
            $list[$k]['rootPath'] = "/link/web/datas" . $item["path"];
            $list[$k]['copyPath'] = substr($item["path"],0,strrpos($item["path"],"/".$item["name"]));
            $list[$k]['AllCopyPath'] = "/" . $item['hospital_number'] . substr($item["path"],0,strrpos($item["path"],"/".$item["name"]));
            $rootPath = "/link/web/datas" . $item["path"];
            $list[$k]['size'] = file_exists($rootPath)?trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath"))):"";
        }
        $this->responseSend($list);
    }

    public function Filesindex()
    {

        $list = Logo::get();
//        $list = DB::select("select id,path
//                            from logo
//                            ");
        //$this->responseSend($list);
        foreach ($list as $k=>$item){
            $list[$k]['path'] = "/logo" . $item["path"];
            $list[$k]['rootPath'] = "/link/web" . $item["path"];
            //$list[$k]['copyPath'] = substr($item["path"],0,strrpos($item["path"],"/".$item["name"]));
           // $rootPath = "/link/web/datas" . $item["path"];
           // $list[$k]['size'] = file_exists($rootPath)?trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath"))):"";
        }
        //$this->responseSend([],400,"循环了");
        $this->responseSend($list);
    }

    /**
     * @api {get} /files-web 2、病人资源列表(PC接口)
     * @apiSampleRequest  /files-web
     * @apiGroup Files
     * @apiName files-web
     *
     * @apiParam {str} patient_case_id 病人病历id
     *
     */
    public function indexWeb()
    {
        $form = Request::capture()->all();
        if(!isset($form['patient_case_id']) || !$form['patient_case_id'])  $this->responseSend([],400,"病人病历id不能为空");
        $list = Files::query()->where("patient_case_id",$form["patient_case_id"])->where('status', '<>', 0)->orderBy("id","desc")->get()->toArray();
        foreach ($list as $k=>$item){
            $list[$k]['webPath'] = "/datas" . $item["path"];
            $list[$k]['rootPath'] = "/link/web/datas" . $item["path"];
            $list[$k]['copyPath'] = substr($item["path"],0,strrpos($item["path"],"/".$item["name"]));
            $rootPath = "/link/web/datas" . $item["path"];
            $list[$k]['size'] = file_exists($rootPath)?trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath"))):"";
        }
        $this->responseSend($list);
    }


    /**
     * @api {post} /files/add 3、添加资源
     * @apiSampleRequest  /files/add
     * @apiGroup Files
     * @apiName add
     *
     * @apiParam {str} patient_case_id 病人资源id
     * @apiParam {str} type 文件类型1图片2视频
     * @apiParam {str} path 储存路径
     * @apiParam {str} [name] 文件名字
     *
     */
    public function add(){
        $form = Request::capture()->all();
        //if(!isset($form['patient_case_id']) || !$form['patient_case_id']) $this->responseSend([],400,"病人资源id不能为空");
        if(!isset($form['type']) || !$form['type']) $this->responseSend([],400,"文件类型不能为空");
        if(!isset($form['path']) || !$form['path'])$this->responseSend([],400,"储存路径不能为空");
        if(!isset($form["name"])){
            $form["name"] = substr($form["path"], strlen(dirname($form["path"])) + 1);
        }
        if($form["type"] == 1){
            $form["status"] = "1";
        }
        if($form['type'] == 2){
            if(!preg_match("/\.mp4/",$form['name'])){
                $this->responseSend([],400,"储存路径不正确，错误为path：".$form["path"]);
            }
        }
        $this->responseSend(Files::create($form));
    }

    /**
     * @api {post} /files/edit 4、录制视频的状态修改
     * @apiSampleRequest  /files/edit
     * @apiGroup Files
     * @apiName edit
     *
     * @apiParam {str} id 资源id
     * @apiParam {str} status 录制的视频状态 0 正在录制  1 停止录制
     *
     */
    public function edit(){
        $form = Request::capture()->all();
        // if(!isset($form['id']) || !$form['id']) $this->responseSend([],400,"资源的id不能为空");
        if(!isset($form['status']) || !$form['status']) $this->responseSend([],400,"录制的视频状态不能为空");
        $this->responseSend(Files::where('id',$form['id'])->update(['status'=>$form['status']]));
    }

    /**
     * @api {post} /files/delete 5、删除资源
     * @apiSampleRequest  /files/delete
     * @apiGroup Files
     * @apiName delete
     *
     * @apiParam {int} id 资源id
     *
     */
    public function delete(){
        $form = Request::capture()->all();

        if(!isset($form['id']) || !$form['id']) $this->responseSend([],400,"资源的id不能为空");
        Files::findOrFail($form["id"])->delete();

        $ppp=$form["path"];
        exec("rm /mnt/disk1".$ppp);

        $this->responseSend($ppp);
    }
    public function deleteEncode(){
        $form = Request::capture()->all();

        $path=$form["path"];
        $this->responseSend(exec("rm /mnt/disk1".$path));
    }

    /**
     * @api {post} /files-all 获取文件夹目录
     * @apiSampleRequest  /files/add
     * @apiGroup Files
     * @apiName add
     *
     * @apiParam {str} type 文件类型1图片2视频
     * @apiParam {str} path 储存路径
     * @apiParam {str} [name] 文件名字
     *
     */
    public  function  read_all(){
        $form = Request::capture()->all();
        $dir=$form['path'];

        //$dir="/mnt/disk1";
        $subdirs = array();
        if (!$dh = opendir($dir))
            return $subdirs;
        $i = 0;
        while ($f = readdir($dh)){
            if ($f == '.' || $f == '..')
                continue;
            $path = $f;
            $subdirs[$i] = $path;
            $i++;
        }
        //return $subdirs;
        $this->responseSend($subdirs);
    }

    /**
     * @api {get} /files-size 录制文件大小
     * @apiSampleRequest  /files-all
     * @apiGroup Files
     * @apiName list

     *
     */
    public function files_size()
    {
        $form = Request::capture()->all();
        $lists =array();
        $rootPath =  $form["path"];
        $lists['size'] = file_exists($rootPath)?trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath"))):"";
        $lists['rootPath']=$rootPath;

        $this->responseSend($lists);
    }

    /**
     * @api {post} /files-all/files  获取文件
     * @apiSampleRequest  /files/add
     * @apiGroup Files
     * @apiName add
     *
     * @apiParam {str} patient_case_id 病人资源id
     * @apiParam {str} type 文件类型1图片2视频
     * @apiParam {str} path 储存路径
     * @apiParam {str} [name] 文件名字
     *
     */
    public function getSubDirs(){
        $form = Request::capture()->all();
        $name = $form['name'];
        $dir="D:\server\datas\server/"."$name";
        $files = array();
        if(@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
            while(($file = readdir($handle)) !== false) {
                if($file != ".." && $file != ".") { //排除根目录；
                    if(is_dir($dir."/".$file)) { //如果是子文件夹，就进行递归
                        $files[$file] = my_dir($dir."/".$file);
                    } else { //不然就将文件的名字存入数组；
                        $files[] = $file;
                    }

                }
            }
            closedir($handle);

            $this->responseSend($files);
        }
    }
}