<?php
namespace app\Controllers\Patient;
use app\Controllers\BaseController;
use app\Models\PatientCase;
use app\Server\Csv;
use Illuminate\Http\Request;


class CaseCsvController extends BaseController
{

    private $file_prefix;//导出文件路径前缀
    private $header = ['id', 'name', 'sex', 'surgery_date', 'hospital_number', 'bed_number', 'department', 'operating_room', 'surgery_name', 'age', 'ward', 'surgery_doctor', 'created_at', 'updated_at'];
    private $headerData = ['ID(此列不可更改)', '姓名', '性别', '手术日期', '住院号', '床位号', '科室', '手术室', '手术名称', '年龄', '病区', '手术医生', '添加时间', '最后修改时间'];

    public function __construct()
    {
//        $file_prefix = env('LOCAL_PATH', '');
//        $this->file_prefix = $file_prefix ? rtrim($file_prefix, '/') . '/' : $file_prefix . '/';

    }

    /**
     * @api {post} /case-csv/output-csv 5、病例管理-导出病例
     * @apiSampleRequest  /case-csv/output-csv
     * @apiGroup Patient
     * @apiName casecsv-outputcsv
     * @apiParam {str} filePath 文件导出路径【绝对路径】
     *
     */
    public function outputCsv()
    {

        $form = $this->validator([
            "filePath" => "required|string",
        ]);
        if(!is_dir($form['filePath'])) return $this->responseSend([], 0, "{$form['filePath']} 该目录不存在");

        $filePath = $form['filePath'];
//        var_export($filePath);exit;
        $caseData = PatientCase::all()->toArray();
        $inputData[] = $this->headerData;

        foreach ($caseData as $val) {
//            unset($val['id']);
            $inputData[] = $val;
        }

        $data = [
            'fileName' => "patient_record_" . date("YmdHis", time()),
            'filePath' => $filePath,
            'inputData' => $inputData
        ];

        $Csv = new Csv();
        $res = $Csv->putCsv($data);

        if ($res) {
            $this->responseSend([], 0, '导出成功');
        }

        $this->responseSend([], 0, '导出失败');
    }

    /**
     * @api {post} /case-csv/input-csv 6、病例管理-导入病例
     * @apiSampleRequest  /case-csv/input-csv
     * @apiGroup Patient
     * @apiName casecsv-inputcsv
     * @apiParam {str} filePath 导入文件的路径【绝对路径】
     *
     */
    public function inputCsv()
    {
        $form = $this->validator([
            "filePath" => "required|string",
        ]);
        if(!file_exists($form['filePath'])) return $this->responseSend([], 0, "{$form['filePath']} 该文件不存在");

        $filePath = $form['filePath'];

        $Csv = new Csv();
        $csvData = $Csv->getCsv($filePath);

        if (!$csvData) return $this->responseSend([], 0, '导入失败');

        $count = count($csvData);
        for ($i = 1; $i < $count; $i++) {
            $header = $this->header;
            for ($j = 1; $j < count($csvData[$i]); $j++) {
                $key = $header[$j];
//                var_export($header[$j]);exit;
                $newData[$key] = $csvData[$i][$j];
                
            }

            PatientCase::create($newData);
        }

        return $this->responseSend([], 0, '导入成功');
    }
}