<?php
namespace app\Server;

class Csv
{
  public function putCsv($data)
   {
       $fileName = isset($data['fileName'])?$data['fileName']:"patient_record_".date("YmdHis",time());
       $filePath = isset($data['filePath'])?$data['filePath']:'';
       $inputData = isset($data['inputData'])?$data['inputData']:[];

       if(!$inputData || !is_array($inputData)) return false;
       if(!$filePath) return false;
       if(!is_dir($filePath)) @mkdir($filePath,0777,true);

       $file = rtrim($filePath,'/').DIRECTORY_SEPARATOR.$fileName.'.csv';

       while (!($fd = fopen($file,'w')));


       foreach ($inputData as $val)
       {
           fputcsv($fd,$val);
       }

       fclose($fd);

       if(file_exists($file)) return $file;

       return false;
   }

  public function getCsv($filePath)
   {
       if(!file_exists($filePath)) return [];

       $fd = fopen($filePath,'r');
       $data = [];
       while (!feof($fd)){
           $linedata = fgetcsv($fd);
           if($linedata && is_array($linedata))
           {
               $data[] = $linedata;
           }
       }
       fclose($fd);

       return $data;
   }
}