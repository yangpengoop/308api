<?php
namespace app\Server;

use Exception;
use app\util\WLog;

class MountTool{

    public $fileSystem_1 = ["Linux","FAT32"];
    public $fileSystem_2 = ["NTFS"];

    //获取特定的磁盘驱动
    public function getDrive($flag='309'){
        $drive =  trim(shell_exec("blkid | grep {$flag} |awk -F':' '{print $1}'"));
        return $drive;
    }

    //挂载
    public function mount($drive,$mountDir)
    {
        //echo "in to mount ";
        if (!$drive) throw new Exception("挂载硬盘驱动不能为空");
        if (!$mountDir) throw new Exception("挂载目录不能为空");
        if(!is_dir($mountDir) || !$this->mkDir($mountDir)) throw new Exception("挂载目录创建失败");
        shell_exec("mount {$drive} {$mountDir}");

        //error_log("mount {$drive} {$mountDir}! \n",   3,   "/root/errors.log");
    }


     //挂载
     public function  ntfs3g($drive,$mountDir)
     {
        // echo "in to ntfs3g ";
         if (!$drive) throw new Exception("挂载硬盘驱动不能为空");
         if (!$mountDir) throw new Exception("挂载目录不能为空");
         if(!is_dir($mountDir) || !$this->mkDir($mountDir)) throw new Exception("挂载目录创建失败");
         shell_exec("/bin/ntfs-3g {$drive} {$mountDir}");

         //error_log("/bin/ntfs-3g {$drive} {$mountDir}! \n",   3,   "/root/errors.log");
     }

    //创建目录
    public function mkDir($dir)
    {
        if (!$dir) throw new Exception("创建目录路径不能为空");
        shell_exec("mkdir -p {$dir}");
        if (is_dir($dir)) return true;
        return false;
    }

    //是否已经挂载
    public function isMount($drive)
    {
        return trim(shell_exec("df -h |grep  {$drive}"));
    }

    //卸载
    public function umount($mountDir,$type="Linux")
    {
        if (!$mountDir) throw new Exception("卸载硬盘驱动或目录不能为空");
        switch ($type){
            case "Linux":
                shell_exec("umount {$mountDir}");
                break;
            case "NTFS":
                shell_exec("umount {$mountDir}");
                break;

            default:
                shell_exec("umount {$mountDir}");
                break;

        }

    }

    //获取盘符信息,换行切割，并且过滤掉空值
    public function getDiskDriveInfo(){
        return array_filter(explode("\n",shell_exec("fdisk -l |grep /dev/sd |grep -v Disk")));
    }

    //获取挂载信息
    public function getMountInfo(){
        return  array_filter(explode("\n",shell_exec("df -h |grep /dev/sd")));
    }

    //处理磁盘点的数据
    public function dealDiskDriveInfo()
    {
        //error_log("in to dealDiskDriveInfo \n",   3,   "/root/errors.log");
        //$diskDriveInfo 得到的数据格式：'/dev/sdb1   *           1      116738   937691136  83 Linux'
        $diskDriveInfo = $this->getDiskDriveInfo();
        if(!$diskDriveInfo) return [];
        $data = [];
        foreach ($diskDriveInfo as $driveStr){

            
            $driveStr = preg_replace("/\s{2,}/",',',$driveStr);


            $driveArr = explode(',',$driveStr);
            $nSize  = count($driveArr)-1;
            {
                $fileSystem = null;
               // error_log($driveArr[$nSize]." \n",   3,   "/root/errors.log");
                if(preg_match("/Linux/",$driveArr[$nSize])){
                    $fileSystem = 'Linux';
                }elseif(preg_match("/NTFS/",$driveArr[$nSize])) {
                    $fileSystem = 'NTFS';
                }elseif(preg_match("/FAT32/",$driveArr[$nSize])) {
                    $fileSystem = 'FAT32';
                }

                else{
                   // error_log("else \n",   3,   "/root/errors.log");
                    $fileSystem = explode(' ',$driveArr[$nSize])[1];
                }

                $drive['drive'] = $driveArr[0];
                $drive['fileSystem'] = $fileSystem;
                $data[$driveArr[0]] = $drive;
            }
        }
        return $data;
    }


    //处理挂载点的数据
    public function dealMountInfo()
    {
        //$mountInfo 得到的数据格式：'/dev/sdc1               880.1G     71.9M    835.3G   0% /mnt/disk1'
        $mountInfo = $this->getMountInfo();
        if(!$mountInfo) return [];
        $data = [];
        foreach ($mountInfo as $mountStr){
            $mountStr = preg_replace("/\s{1,}/",',',$mountStr);
            $mountArr = explode(',',$mountStr);
            $mount['drive'] = $mountArr[0];
            $mount['size'] = $mountArr[1];
            $mount['used_size'] = $mountArr[2];
            $mount['available'] = $mountArr[3];
            $mount['used'] = $mountArr[4];
            $mount['mounted'] = $mountArr[5];
            $data[$mountArr[0]] = $mount;
        }
        return $data;
    }

    //挂载NTFS文件系统的磁盘
    public function mount_NTFS()
    {

    }

    //检查是否有磁盘被拔出，拨出就进行卸载挂载点
    public function checkDiskUmount($diskDriveInfo,$mountInfo)
    {
        if (!$diskDriveInfo || !is_array($diskDriveInfo)) throw new Exception('磁盘驱动获取失败');
        if (!$mountInfo || !is_array($mountInfo)) return;
        foreach ($mountInfo as $mount){
            $drive = $mount['drive'];
            $mountDir = $mount['mounted'];
            if(array_key_exists($drive,$diskDriveInfo)) continue;//磁盘存在则跳过本循环
            $this->umount($mountDir);
        }
    }

    //获取可用的挂载路径
    public function getMountDir($mountInfo)
    {
        $mountDirArr = [
            "/mnt/disk2"=>"/mnt/disk2",
            "/mnt/disk3"=>"/mnt/disk3",
            "/mnt/disk4"=>"/mnt/disk4"
        ];
        if(!$mountInfo || !is_array($mountInfo)) return  $mountDirArr[0];
        foreach ($mountInfo as $mount){
            if(in_array($mount['mounted'],$mountDirArr)){
                unset($mountDirArr[$mount['mounted']]);
            }
        }
        $mountDir = array_values($mountDirArr)[0];
        return $mountDir;
    }

    //获取所有磁盘
    public function getDisk_run()
    {
        //error_log("in to vgetDisk_rugetDisk_run \n",   3,   "/root/errors.log");
        $diskDriveInfo = $this->dealDiskDriveInfo(); //fdisk -l |grep /dev/sd |grep -v Disk
        $mountInfo = $this->dealMountInfo();//df -h |grep /dev/sd
        $this->checkDiskUmount($diskDriveInfo,$mountInfo);//检查是否有磁盘被拔出，拨出就进行卸载挂载点
        $mountInfo = $this->dealMountInfo();//重新获取新的挂载点信息
        $mountDir = $this->getMountDir($mountInfo);//获取可用的挂载路径

//        foreach ($diskDriveInfo as $driveArr){
//            //error_log($driveArr['fileSystem'].AA." \n",   3,   "/root/errors.log");
//            $drive = $driveArr['drive'];
//
//            if(array_key_exists($drive,$mountInfo)) continue;//查询是否已经挂载,挂载过就跳过本次循环
//
//            if ($driveArr['fileSystem'] == 'NTFS' ||$driveArr['fileSystem'] == 'ee' ) {
//
//                //目前是不挂载ntfs
//                if(!is_dir($mountDir)) $this->mkDir($mountDir);
//                $this->ntfs3g($drive,$mountDir);
//               // continue;
//            }
//            else
//            {
//            if(!is_dir($mountDir)) $this->mkDir($mountDir);
//            $this->mount($drive,$mountDir);
//            }
//        }

        $diskInfo = array_values($this->dealMountInfo());//获取最新的挂载点信息

        return $diskInfo;
    }

    //挂载内置硬盘
    public function mountFixedDisk()
    {
        $drive = $this->getDrive();
        if(!$drive) throw new Exception("内置硬盘出错！");
        $mountDir = "/mnt/disk1";
        if (!$this->isMount($drive)) {
            $this->mount($drive, $mountDir);
        }
    }

}