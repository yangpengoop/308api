<?php
namespace app\Controllers\Files;
use app\Controllers\BaseController;
use app\Exception\ApiException;
use app\Models\Config;
use app\Models\Files;
use app\Models\Logo;
use app\Models\PatientCase;
use app\Server\FileDownTool;
use app\Server\MountTool;
use app\Server\UploadFileTool;
use Illuminate\Http\Request;
use Symfony\Component\Filesystem\Filesystem;
use Illuminate\Database\Capsule\Manager  as DB;

class FolderController extends BaseController
{
    public $mountTool;

    public function __construct()
    {
        $this->mountTool = new MountTool();
    }

    /**
     * @api {post} /folder/add 1、创建目录
     * @apiSampleRequest  /folder/add
     * @apiGroup Folder
     * @apiName add
     *
     * @apiParam {str} [root_path] 盘符路径
     * @apiParam {str} [path] 相对路径
     *
     *
     */
    public function add()
    {
        $form = Request::capture()->all();
        $name = isset($form['path'])?$form['path']:'';
        $fs = new Filesystem();
        if(isset($form['root_path'])){
            if(!is_dir($form['root_path'])){
                $this->responseSend("",0,"你输入的盘符地址错误") ;
            }
            $newPath = $form['root_path'].$name;
        }else{
            $newPath = env('LOCAL_PATH','').$name;
        }
        if($fs->exists($newPath)){
            throw new ApiException("Create errors, folders cannot be created repeatedly!".$newPath);
        }
        $fs->mkdir($newPath);
        $this->responseSend('',0,"Creating ".$name." Folder Successfully!") ;
    }

    /**
     * @api {get} /folder/get 2、获取目录
     * @apiSampleRequest  /folder/get
     * @apiGroup Folder
     * @apiName get
     *
     * @apiParam {str} [root_path] 盘符路径
     * @apiParam {str} [path] 相对路径
     * @apiParam {str} [type] 类型 数据类型的 0:全部  1：文件夹，2：文件
     *
     * @apiSuccess {str} type  返回数据类型的1：文件夹，2：文件
     */
     public function get(){
         $form = Request::capture()->all();
         $name = isset($form['path'])?$form['path']:'';
         $type = isset($form['type'])?$form['type']:'0';
         if(isset($form['root_path'])){
             if(!is_dir($form['root_path'])){
                 $this->responseSend("",0,"你输入的盘符地址错误") ;
             }
             $newPath = $form['root_path'].$name;
         }else{
             $newPath = env('LOCAL_PATH','').$name;
         }
         $data = [];
         if(!is_dir($newPath)){
             $this->responseSend("",0,"获取".$newPath."目录不存在") ;
         }
         $filesnames = scandir($newPath);
         foreach($filesnames as $key=>$value) {
             $arr = array();
             if($key>1){
                 $rootPath = $newPath ."/". $value;
                 if($type == 0){
                     $arr['name'] = self::characet($value);
                     $arr['time'] = file_exists($rootPath)?date('Y-m-d H:i:s', filemtime($rootPath)):"";
                     $arr['type'] =  (@filetype($rootPath) == "dir")?1:2;
                     if( $arr['type'] ==1){
                         $arr['size'] =  0;
                         $arr['path'] = $name?$name."/".$arr['name']:"/".$arr['name'];
                     }elseif($arr['type'] ==2){
                         $arr['size'] =  file_exists($rootPath)?self::howSize(trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath")))):"";
                         $arr['fileSize'] = file_exists($rootPath)?trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath"))):"";
                         $arr['path'] =  $name?$name:"/";
                         $arr['Absolutepath'] =  "/link/web/datas" . $name . "/" . $value;
                         $re = self::isImage($rootPath);
                         if($re!==false){//图片
                             $arr['rootPath'] = "/datas" . $name . "/" . $value;
                             $arr['fileType'] = "img";
                         }else { //视频
                             $arr['rootPath'] =$name ."/". $value;
                             $arr['fileType'] = "other";
                         }

                     }
                 }else if($type == 1){
                     if(filetype($newPath . "/" . $value) == "dir"){
                         $arr['name'] = self::characet($value);
                         $arr['time'] = file_exists($rootPath)?date('Y-m-d H:i:s', filemtime($rootPath)):"";
                         $arr['size'] =  0;
                         $arr['type'] =  (filetype($rootPath) == "dir")?1:2;
                         $arr['path'] =  $name?$name."/".$arr['name']:"/".$arr['name'];
                     }
                 }else if($type == 2){
                     if(filetype($newPath . "/" . $value) != "dir"){
                         $arr['name'] = self::characet($value);
                         $arr['time'] = file_exists($rootPath)?date('Y-m-d H:i:s', filemtime($rootPath)):"";
                         $arr['size'] =  file_exists($rootPath)?self::howSize(trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath")))):"";
                         $arr['fileSize'] = file_exists($rootPath)?trim(str_replace('\n', '',shell_exec("stat -c '%s' $rootPath"))):"";
                         $arr['type'] =  (filetype($rootPath) == "dir")?1:2;
                         $arr['path'] =  $name?$name:"/";
                         $arr['Absolutepath'] =  "/link/web/datas" . $name . "/" . $value;
                         $re = self::isImage($rootPath);
                         if($re!==false){//图片
                             $arr['rootPath'] = "/datas" . $name . "/" . $value;
                             $arr['fileType'] = "img";
                         }else { //视频
                             $arr['rootPath'] = $name ."/". $value;
                             $arr['fileType'] = "other";
                         }
                     }
                 }
                 $data[]=$arr;
             }
         }
         $this->responseSend(array_filter($data),0,"获取目录信息成功") ;
     }
    /*
     * 转码
     */
    function characet($data){
        if( !empty($data) ){
            $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
            if( $fileType != 'UTF-8'){
                $data = mb_convert_encoding($data ,'utf-8' , $fileType);
            }
        }
        return $data;
    }

    /*
    * 判断是否是图片
    */
    function isImage($filename)
    {
        $info = explode(".",$filename);
        $os=array("gif","jpg","jpeg","png","bmp");
        if(!in_array($info[1],$os)){
            return false;
        }
        return true;
    }

    /*
     * 换算文件大小单位
     */
    function howSize($size){
        if($size >= pow(2, 40)){
            return round($size/pow(2, 40), 2).'TB';
        }else if($size >= pow(2, 30)){
            return round($size/pow(2, 30), 2).'GB';
        }else if($size >= pow(2, 20)){
            return round($size/pow(2, 20), 2).'MB';
        }else if($size >= pow(2, 10)){
            return round($size/pow(2, 10), 2).'KB';
        }else{
            return round($size, 2).'Byte';
        }
    }

    /**
     * @api {post} /folder/del 3、删除文件、文件夹
     * @apiSampleRequest  /folder/del
     * @apiGroup Folder
     * @apiName del
     *
     * @apiParam {str} [root_path] 盘符路径
     * @apiParam {str} [path] 相对路径
     * @apiParam {str} [name] 文件夹名字/文件名
     *
     */
    public function del(){
        $form = Request::capture()->all();
        $path = isset($form['path'])?$form['path']:'';
        $name = isset($form['name'])?$form['name']:'';
        $root_path = isset($form['root_path'])?$form['root_path']:env('LOCAL_PATH');
        $fs = new Filesystem();
        if($path){
            if(strpos($path,$name)){//文件夹
                $oldPath = $root_path."/".explode("/",$path,2)[1];
            }else{//文件
                $oldPath = $root_path."/".explode("/",$path,2)[1]."/".$name;
            }

        }else{
            $oldPath =$root_path."/".$name;
        }
        if(!file_exists($oldPath)){
            $this->responseSend('',0,"path参数有误:".$path) ;
        }
        $dir = $oldPath;
        if($oldPath == $root_path){
            $this->responseSend('',0,"不能删除，".$oldPath."目录为盘符目录") ;

        }
        $fs->remove($dir);
        $this->responseSend('',0,"Delete successful") ;
    }

    /**
     * @api {post} /folder/copy 4、拷贝文件
     * @apiSampleRequest  /folder/copy
     * @apiGroup Folder
     * @apiName copy
     *
     * @apiParam {str} [path] 复制的路径  /1979/1.mp4
     * @apiParam {str} [new_path] 粘贴的绝对路径
     * @apiParam {str} [root_path] 复制的盘符地址，不填默认本地盘符
     * @apiParam {str} [root_new_path] 粘贴的盘符地址，不填默认本地盘符
     * @apiParam {str} [name] 文件名字
     *
     */
    public function copy(){
        $form = Request::capture()->all();
        $name = isset($form['name'])?$form['name']:'';
        $path = isset($form['path'])?$form['path']:'';
        $new_path = isset($form['new_path'])?$form['new_path']:'';
        $root_path = isset($form['root_path'])?$form['root_path']:env('LOCAL_PATH');
        $root_new_path = isset($form['root_new_path'])?$form['root_new_path']:env('LOCAL_PATH');
        if($path){
            if(strpos($path,$name) ){//文件夹
                $oldPath = $root_path."/".explode("/",$path,2)[1]."/";
            }else{//文件
                $oldPath = $root_path."/".explode("/",$path,2)[1]."/".$name;
            }

        }else{
            $oldPath =$root_path."/".$name;
        }
        if(!file_exists($oldPath)){
            $this->responseSend('',400,"oldPath参数有误:".$oldPath) ;
        }
        if($new_path){
            $new_path = $root_new_path."/".explode("/",$new_path,2)[1]."/";
        }else{
            $new_path = $root_new_path."/";
        }
         if(!is_dir ($new_path)){
             $this->responseSend('',400,"new_path参数有误".$new_path) ;
           }

        if(strpos($path,$name) ){//文件夹
            $newPath = $new_path;
        }else{//文件
            $newPath = $new_path.$name;
        }
       if(is_dir($oldPath)){//目录复制
            $cp = "rsync -r ".$oldPath." ".$newPath;
            exec($cp);
        }else{//文件复制
            $cp = "rsync ".$oldPath." ".$newPath;
            exec($cp);
        }
        $this->responseSend($newPath,0,"Copy successful") ;
    }



    /**
     * @api {get} /folder/get-disk 5、获取磁盘信息
     * @apiSampleRequest  /folder/get-disk
     * @apiGroup Folder
     * @apiName get-disk
     *
     */
    public function getDisk(){

        //error_log("in to getdisk \n",   3,   "/root/errors.log");

        try{
            $this->mountTool->mountFixedDisk();
           // error_log("in to mountFixedDisk \n",   3,   "/root/errors.log");
            $diskInfo = $this->mountTool->getDisk_run();
          //  error_log("in to getDisk_run \n",   3,   "/root/errors.log");
            $this->responseSend($diskInfo);
        }catch (\Exception $e){
            $this->responseSend('',400,$e->getMessage());
        }

    }

    public function uploadFileVideo()
    {
        $form = Request::capture()->all();
        if(!isset($_FILES['file'])) $this->responseSend([],400,'file参数不为空');
        $file = $_FILES['file']?$_FILES['file']:$this->responseSend([],400,'没接收到缓存文件，文件上传失败');

        $fileType = isset($form['fileType'])?$form['fileType']:'';
        $fileName = $file['name'];
        $imaPath = "/" .$file['name'];
        $fileNameArr = explode('.',$fileName);
        $fileExt = end($fileNameArr);
        switch ($fileType){
            case 'logo':
                $filePath = rtrim(env('RTSP_LOGO_PATH'),'/').'/';
                $fileName = 'logo.'.$fileExt;
                break;
            default:
                $filePath = rtrim(env('UPLOAD_PATH'),'/').'/mnt/disk1/uploadVideo/';
                break;
        }

        if(!is_dir($filePath)) exec("mkdir -p $filePath");
        try{
            $fileFullPath = $filePath.$fileName;
            $uploadFileTool = new UploadFileTool();
            $uploadFileTool->uploadFile('file',$filePath,$fileName);
            if($fileType == 'logo') $this->setLogoPath($fileFullPath);
            // $this->setRootLogoPath($fileName,$imaPath);
            $this->responseSend(["file_path"=>$fileFullPath],0,"文件上传成功");
        }catch (\Exception $e){
            $this->responseSend([],400,$e->getMessage());
        }
    }


    /**
     * @api {post} /folder/upload-file 6、上传文件
     * @apiSampleRequest  /folder/upload-file
     * @apiGroup Folder
     * @apiName upload-file
     *
     * @apiParam {str} file 文件参数名
     * @apiParam {str} fileType 文件类型 logo图标：logo
     *
     */
    public function uploadFile()
    {
        $form = Request::capture()->all();
        if(!isset($_FILES['file'])) $this->responseSend([],400,'file参数不为空');
        $file = $_FILES['file']?$_FILES['file']:$this->responseSend([],400,'没接收到缓存文件，文件上传失败');

        $fileType = isset($form['fileType'])?$form['fileType']:'';
        $fileName = $file['name'];
        $imaPath = "/" .$file['name'];
        $fileNameArr = explode('.',$fileName);
        $fileExt = end($fileNameArr);
        switch ($fileType){
            case 'logo':
                $filePath = rtrim(env('RTSP_LOGO_PATH'),'/').'/';
                $fileName = 'logo.'.$fileExt;
                break;
            default:
                $filePath = rtrim(env('UPLOAD_PATH'),'/').'/link/web/logo/';
                break;
        }

        if(!is_dir($filePath)) exec("mkdir -p $filePath");
        try{
            $fileFullPath = $filePath.$fileName;
            $uploadFileTool = new UploadFileTool();
            $uploadFileTool->uploadFile('file',$filePath,$fileName);
            if($fileType == 'logo') $this->setLogoPath($fileFullPath);
            // $this->setRootLogoPath($fileName,$imaPath);
            $this->responseSend(["file_path"=>$fileFullPath],0,"文件上传成功");
        }catch (\Exception $e){
            $this->responseSend([],400,$e->getMessage());
        }

    }

    function setRootLogoPath($fileName,$imaPath)
    {
        Logo::create(['name'=>$fileName,"path"=>$imaPath]);
    }

    //修改logo地址
    function setLogoPath($fileFullPath)
    {
        if (!$fileFullPath) throw new \Exception("logo地址不能为空");
        $key = "OSD_IMAGES";
        $keyData = Config::where('key',$key)->firstOrFail();
        $value = $keyData['value']?json_decode($keyData['value'],true):"";
        if (!$value) throw new \Exception("logo地址替换失败，code:001");
        if(!file_exists($fileFullPath)) throw new \Exception("$fileFullPath 图标文件不存在，code:002");
        $imgInfo = getimagesize($fileFullPath);
        $value['text'] = $fileFullPath;
        $value['w'] = $imgInfo[0];
        $value['h'] = $imgInfo[1];
        Config::where('key',$key)->update(['value'=>json_encode($value,320)]);
    }

    /**
     * @api {get} /folder/download 7、web资源文件下载
     * @apiSampleRequest  /folder/download
     * @apiGroup Folder
     * @apiName download
     *
     * @apiParam {str} id 文件id
     *
     */
    public function download()
    {
        $form = Request::capture()->all();
        if(!$form['id']) $this->responseSend([],400,"id参数不能为空");
        $info = Files::where("id",$form["id"])->first();
        if(!$info) $this->responseSend([],400,"该资源不存在");
        $fileDownTool = new FileDownTool();
        $fileDownTool->download($info['path']);
    }


    /**
     * @api {get} /folder/get-file-size 8、获取文件大小
     * @apiSampleRequest  /folder/get-file-size
     * @apiGroup Folder
     * @apiName getFileSize
     *
     * @apiParam {str} filePath 文件绝对路径!,是绝对路径！
     *
     */
    public function getFileSize()
    {
        $form = Request::capture()->all();
        if(!isset($form['filePath']) || !$form['filePath']) $this->responseSend('',403,"filePath参数不能为空");
        $filePath = dirname($form['filePath']);
        if(!file_exists($filePath)) $this->responseSend(0,402,basename($filePath)."该文件不存在,请检查外接磁盘");
        // $fileSize = trim(shell_exec("stat -c '%s' {$filePath}"));
        // $file = exec("cd {$filePath};cat t3.log");
        $file = exec("cd {$filePath};cat t3.log  | tr \"\\r\" \"\\n\" | tail -n 1");
        $needle ="%";
        $tmp = explode($needle,$file);
        if(count($tmp) > 1){
            $this->responseSend($file,0,"文件大小获取成功");
        }else{
            $file = exec("cd {$filePath};cat t3.log  | tr \"\\r\" \"\\n\" | tail -n 1");
            $needle ="%";
            $tmp = explode($needle,$file);
            if(count($tmp) > 1){
                $this->responseSend($file,0,"文件大小获取成功");
            }else{
                $this->responseSend(0,402,"导出错误，请重试。");
            }
        }
        $this->responseSend($file,0,"文件大小获取成功");


    }

    /**
     * @api {get} /folder/file-out 10、文件导出
     * @apiSampleRequest  /folder/file-out
     * @apiGroup Folder
     * @apiName file-out 58763218090
     *
     * @apiParam {str} path 要复制的文件绝对路径，是绝对路径！
     * @apiParam {str} new_path 粘贴的绝对路径，是绝对路径！
     * @apiParam {str} name 文件新名字
     *
     */
    public function fileOut()
    {
        $form = Request::capture()->all();
        if(!isset($form['path']) || !$form['path']) $this->responseSend('',400,"path参数不能为空");
        if(!isset($form['new_path']) || !$form['new_path']) $this->responseSend('',400,"new_path参数不能为空");
        $name = basename($form['path']);
        $size = $form['wgetSize'];
        // if(isset($form['name']) && $form['name']) $name = $form['name'];
        $path = $form['path'];
        // $new_path = "/mnt/disk2/".$form['hospital_number'];
        $new_path = $form['new_path'].'/'.$form['hospital_number'];
        if(!file_exists("/mnt/disk1".$path)) $this->responseSend('',400,"【{$path}】该文件不存在！");
        if(!is_dir($new_path)) shell_exec("mkdir -p $new_path");//检查外接磁盘内有无文件夹存在，不存在则创建文件夹
        $new_file_path = rtrim($new_path,'/').'/'.$name;//完整路径+文件名
        if(file_exists($new_file_path)){
                // $new_file_path = rtrim($new_path,'/').'/'.rand(999,9999).'_'.$name;
                $fileSize = trim(shell_exec("stat -c '%s' {$new_file_path}"));
                if($size == $fileSize){
                    $this->responseSend('',403,"【{$path}】该文件已存在，是否覆盖");
                }else{
                    // $sh = " cd {$new_path} ;wget http://127.0.0.1:818/files{$path} -c &> t3.log &";
                    if(strpos($path,'VideoFile') !== false){
                        $sh = " cd {$new_path} ;wget http://127.0.0.1:818/files{$path} -c &> t3.log &";
                    }else{
                        $sh = " cd {$new_path} ;wget http://127.0.0.1:888/chfs/shared{$path} -c &> t3.log &";
                    }
                    exec($sh);
                    $this->responseSend($new_file_path,0,"该文件正在导出1");
                }
        }else{
            // $sh = " cd {$new_path} ;wget http://127.0.0.1:818/files{$path} -c &> t3.log &";
            if(strpos($path,'VideoFile') !== false){
                $sh = " cd  {$new_path} ;wget http://127.0.0.1:818/files{$path} -c &> t3.log &";
            }else{
                $sh = " cd {$new_path} ;wget http://127.0.0.1:888/chfs/shared{$path} -c &> t3.log &";
            }
            exec($sh);
            $this->responseSend($new_file_path,0,"该文件正在导出2");
        }
    }

    public function fileIn()
    {
        $form = Request::capture()->all();
        if(!isset($form['path']) || !$form['path']) $this->responseSend('',400,"path参数不能为空");
        if(!isset($form['new_path']) || !$form['new_path']) $this->responseSend('',400,"new_path参数不能为空");
        $name = $form['path'];
        $size = $form['wgetSize'];
        // if(isset($form['name']) && $form['name']) $name = $form['name'];
        $path = $form['path'];
        // $new_path = "/mnt/disk2/".$form['hospital_number'];
        $new_path = $form['new_path'].$form['hospital_number'];
        // if(!file_exists("/mnt/disk1/record".$path)) $this->responseSend('',400,"【{$path}】该文件不存在！");
        if(!is_dir($new_path)) shell_exec("mkdir -p $new_path");
        $new_file_path = rtrim($new_path,'/').'/'.$name;
        if(file_exists($new_file_path)){
                // $new_file_path = rtrim($new_path,'/').'/'.rand(999,9999).'_'.$name;
                $fileSize = trim(shell_exec("stat -c '%s' {$new_file_path}"));
                if($size == $fileSize){
                    $this->responseSend('',403,"【{$path}】该文件已存在，是否覆盖");
                }else{
                    $sh = " cd {$new_path} ;wget http://127.0.0.1:818/filesin/{$path} -c &> t3.log &";
                    // $sh = " cd {$new_path} ;wget http://127.0.0.1:888/chfs/shared{$path} -c &> t3.log &";
                    exec($sh);
                    $this->responseSend($new_file_path,0,"该文件正在导出1");
                }
        }else{
            $sh = " cd {$new_path} ;wget http://127.0.0.1:818/filesin/{$path} -c &> t3.log &";
            // $sh = " cd {$new_path} ;wget http://127.0.0.1:888/chfs/shared{$path} -c &> t3.log &";
            exec($sh);
            $this->responseSend($new_file_path,0,"该文件正在导出2");
        }
    }
    
    public function getFileSizeIn()
    {
        $form = Request::capture()->all();
        if(!isset($form['filePath']) || !$form['filePath']) $this->responseSend('',400,"filePath参数不能为空");
        $filePath = $form['filePath'];
        if(!file_exists($filePath)) $this->responseSend(0,400,basename($filePath)."该文件不存在");
        $fileSize = trim(shell_exec("stat -c '%s' {$filePath}"));
        $this->responseSend($fileSize,0,"文件大小获取成功");

    }
    /**
     * @api {get} /folder/patientfile-out 10、文件导出
     * @apiSampleRequest  /folder/patientfile-out
     * @apiGroup Folder
     * @apiName patientfile-out
     *
     * @apiParam {str} path 要复制的文件绝对路径，是绝对路径！
     * @apiParam {str} new_path 粘贴的绝对路径，是绝对路径！
     * @apiParam {str} name 文件新名字      
     *
     */

    public function fileCreatPathOut()
    {
        $form = Request::capture()->all();
        if(!isset($form['cases']) || !$form['cases']) $this->responseSend('',400,"cases参数不能为空");
        if(!isset($form['new_path']) || !$form['new_path']) $this->responseSend('',400,"new_path参数不能为空");
       
        $list = DB::select(" select a.*,('/link/web/datas' ) as rootPath,
        ('/link/web/datas' ) as copyPath,(1) as filestatus,
        b.name as patient_name
        from files a
        left join patient_case b on b.id = a.patient_case_id 
        where a.patient_case_id in (".$form["cases"].")
          order by a.id DESC
        ");

        foreach ($list as $val){
            $PatientName = $val->patient_name;
            $name = $val->name;
            $path = $val->rootPath.$val->path;
            $val->rootPath = $path;


            $new_path = $form['new_path'].'/'.$PatientName;
            if(!file_exists($path))
            {
                $val->filestatus = 0;
            }
            // if(!file_exists($path)) $this->responseSend('',400,"【{$path}】该文件不存在！");
            if(!is_dir($new_path)) shell_exec("mkdir -p $new_path");
            $new_file_path = rtrim($new_path,'/').'/'.$name;

            if(file_exists($new_file_path)){

                    $new_file_path = rtrim($new_path,'/').'/'.rand(999,9999).'_'.$name;
            }
            $val->copyPath =  $new_file_path ;

            $sh = "nohup cp -r {$path} {$new_file_path} > /tmp/php_fileOut.txt ";
            //$sh = "nohup cp -r {$path} {$new_file_path} > /tmp/php_fileOut.txt &";
            exec($sh);

        }

        $this->responseSend($list);

    }

    public function fileList()
    {
        $form = Request::capture()->all();
        if(!isset($form['cases'])  || !$form['cases']) $this->responseSend('',400,"cases参数不能为空");
        if(!isset($form['new_path']) || !$form['new_path']) $this->responseSend('',400,"new_path参数不能为空");

        $list = DB::select(" select a.*,('/link/web/datas' ) as rootPath,
        ('/link/web/datas' ) as copyPath,(1) as filestatus,
        b.name as patient_name
        from files a
        left join patient_case b on b.id = a.patient_case_id 
        where a.patient_case_id in (".$form["cases"].") and
        a.status =1
          order by a.id DESC
        ");
        foreach ($list as $val){
            $PatientName = $val->patient_name;
            $name = $val->name;
            $path = $val->rootPath.$val->path;
            $val->rootPath = $path;
            $val->size = file_exists($path)?trim(str_replace('\n', '',shell_exec("stat -c '%s' $path"))):"";


            $new_path = $form['new_path'].'/'.$PatientName;
            if(!file_exists($path))
            {
                $val->filestatus = 0;
            }
            // if(!file_exists($path)) $this->responseSend('',400,"【{$path}】该文件不存在！");
            if(!is_dir($new_path)) shell_exec("mkdir -p $new_path");
            $new_file_path = rtrim($new_path,'/').'/'.$name;

            if(file_exists($new_file_path)){

                $new_file_path = rtrim($new_path,'/').'/'.rand(999,9999).'_'.$name;
            }
            $val->copyPath =  $new_file_path ;

            //$sh = "nohup cp -r {$path} {$new_file_path} > /tmp/php_fileOut.txt &";
            //$sh = "nohup cp -r {$path} {$new_file_path} > /tmp/php_fileOut.txt &";
           // exec($sh);

        }


        $this->responseSend($list);
    }


    public function fileOutNew()
    {
        $form = Request::capture()->all();


            $path = $form['rootPath'];

            $new_file_path = $form['copyPath'];

            $sh = "nohup cp -r {$path} {$new_file_path} > /tmp/php_fileOut.txt &";
            //$sh = "nohup cp -r {$path} {$new_file_path} > /tmp/php_fileOut.txt &";
            exec($sh);
            $this->responseSend(0);





    }

    /**
     * @api {get} /folder/clear-cp 杀死cp进程
     * @apiSampleRequest  /folder/clear-cp
     * @apiGroup Folder
     * @apiName clear-cp
     *
     */
    public function clear_cp()
    {
        // exec("ps -ef | grep "."cp -r" ."| grep -v "."grep"  ."| awk '{print $1}' | xargs kill -9");
        exec("ps -ef | grep "."wget" ."| grep -v "."grep"  ."| awk '{print $1}' | xargs kill -9");
        $this->responseSend(0,"取消导出");
    }


    /**
     * @api {get} /folder/clear-disk 11、磁盘清空
     * @apiSampleRequest  /folder/clear-disk
     * @apiGroup Folder
     * @apiName clear-disk
     *
     */
    public function clearDisk()
    {
        exec("rm -rf /mnt/disk1/record/*");
        $re =  DB::table('files')->truncate();
        $rs = DB::table('patient_case')->truncate();
        $this->responseSend($re,0,"磁盘清空成功");
    }

    /**
     * @api {post} /folder/umount 12、卸载磁盘
     * @apiSampleRequest  /folder/umount
     * @apiGroup Folder
     * @apiName umount
     * @apiParam {str} diskDir 磁盘路径 例如：/mnt/disk2
     *
     */
    public function umount()
    {
        $form = Request::capture()->all();
        if(!isset($form['diskDir']) || !$form['diskDir']) $this->responseSend("",400,"diskDir参数不能为空");
        $diskDir = $form['diskDir'];
        $this->mountTool->umount($diskDir);
        $this->responseSend('',0,"硬盘卸载成功");
    }

    /**
     * @api {post} /folder/video-time 13、读取视频时长
     * @apiSampleRequest  /folder/video-time
     * @apiGroup Folder
     * @apiName umount
     * @apiParam {str}
     *
     */
    public  function video_path(){
        $form = Request::capture()->all();
        $path = $form['path'];
        $data_time =$this->video_time($path);
        return $this->responseSend($data_time);
    }

    public function video_time($path){
        ob_start();
        passthru(sprintf(FFMPEG_PATH,$path));
        $info = ob_get_clean();
        $ret = array();
        if (preg_match("/Duration: (.*?),start: (.*?),bitrate: (\d*) kb\/s/",$info,$match)){
            $ret['duration'] = $match[1];
            return $ret;
        }
        return "";
    }

    /**
     * @api {post} /folder/del-logo 14、删除Logo图片
     * @apiSampleRequest  /folder/del-logo
     * @apiGroup Folder
     * @apiName /folder/del-logo
     * @apiParam {str}
     *
     */
    public  function delLogo(){
        $form = Request::capture()->all();
        $rootPath = $form['rootPath'];
        $data = Logo::where('id',$form['id'])->delete();
        exec("rm " . $rootPath);
        return $this->responseSend($data);
    }


}