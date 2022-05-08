<?php
// $app['router']->get('/',function(){
//     return '<h1>配置成功</-h1>';
// });

#病历字段列表
$app['router']->post('ziduan/add','app\Controllers\Case_zd\ZiduanIndexController@add');
$app['router']->post('ziduan/update','app\Controllers\Case_zd\ZiduanIndexController@update');
$app['router']->post('ziduan/showUpdateYes','app\Controllers\Case_zd\ZiduanIndexController@showUpdateYes');
$app['router']->post('ziduan/showUpdateNo','app\Controllers\Case_zd\ZiduanIndexController@showUpdateNo');
$app['router']->get('ziduan/index','app\Controllers\Case_zd\ZiduanIndexController@index');

#病人处理
$app['router']->get('patient','app\Controllers\Patient\IndexController@index');
$app['router']->get('patient/zd_index','app\Controllers\Patient\IndexController@zd_index');

$app['router']->post('patient/add','app\Controllers\Patient\IndexController@add');
$app['router']->post('patient/edit','app\Controllers\Patient\IndexController@edit');
$app['router']->post('patient/delete','app\Controllers\Patient\IndexController@delete');
$app['router']->get('patient/time-index','app\Controllers\Patient\IndexController@timeIndex');
$app['router']->post('patient/file_edit','app\Controllers\Patient\IndexController@file_edit');
$app['router']->post('patient/file_edit_stop','app\Controllers\Patient\IndexController@file_edit_stop');



#病人资源处理
$app['router']->get('files','app\Controllers\Files\IndexController@index');


$app['router']->get('files-logo','app\Controllers\Files\IndexController@Filesindex');
$app['router']->get('files-web','app\Controllers\Files\IndexController@indexWeb');
$app['router']->post('files/add','app\Controllers\Files\IndexController@add');
$app['router']->post('files/edit','app\Controllers\Files\IndexController@edit');
$app['router']->post('files/delete','app\Controllers\Files\IndexController@delete');
$app['router']->post('files/delete-encode','app\Controllers\Files\IndexController@deleteEncode');
$app['router']->post('files/files-all','app\Controllers\Files\IndexController@read_all');
$app['router']->post('files/files-size','app\Controllers\Files\IndexController@files_size');


#Sql 处理
$app['router']->post('select','app\Controllers\Sql\SqlController@selectSql');
$app['router']->post('insert','app\Controllers\Sql\SqlController@insertSql');
$app['router']->post('update','app\Controllers\Sql\SqlController@updateSql');
$app['router']->post('delete','app\Controllers\Sql\SqlController@deleteSql');


/*病例管理*/
$app['router']->post('case-csv/output-csv','app\Controllers\Patient\CaseCsvController@outputCsv');
$app['router']->post('case-csv/input-csv','app\Controllers\Patient\CaseCsvController@inputCsv');



/*录像设置*/
$app['router']->get('video','app\Controllers\Config\VideoController@index');
$app['router']->post('video/edit','app\Controllers\Config\VideoController@edit');

/*系统设置*/
$app['router']->get('system','app\Controllers\Config\SystemController@index');
$app['router']->get('system/get-key','app\Controllers\Config\SystemController@getKey');
$app['router']->post('system/edit','app\Controllers\Config\SystemController@edit');
$app['router']->post('system/network-edit','app\Controllers\Config\SystemController@networkEdit');
$app['router']->get('/system/get-network-key','app\Controllers\Config\SystemController@getNetworkKey');
$app['router']->get('/system/get-linux-net','app\Controllers\Config\SystemController@getLinuxNet');
$app['router']->get('/system/net-reset','app\Controllers\Config\SystemController@netReset');
$app['router']->get('/system/get-signal','app\Controllers\Config\SystemController@getSignal');
$app['router']->post('system/signal-edit','app\Controllers\Config\SystemController@signalEdit');
$app['router']->post('system/set-time','app\Controllers\Config\SystemController@setTime');
$app['router']->get('system/get-time','app\Controllers\Config\SystemController@getTime');
$app['router']->get('system/get-ntptime','app\Controllers\Config\SystemController@getNTPTime');
$app['router']->get('system/getTimeTo','app\Controllers\Config\SystemController@getTimeTo');
$app['router']->get('switch/reboot','app\Controllers\Config\SwitchController@reboot');
$app['router']->get('switch/shutdown','app\Controllers\Config\SwitchController@shutdown');
$app['router']->post('system/setPowerOnstartup','app\Controllers\Config\SystemController@PowerOnstartup');
$app['router']->get('system/getPowerOnstartup','app\Controllers\Config\SystemController@getPowerOnstartup');
$app['router']->post('system/setcodec','app\Controllers\Config\SystemController@setcodec');
$app['router']->get('system/codec','app\Controllers\Config\SystemController@codec');
$app['router']->post('system/setrelay','app\Controllers\Config\SystemController@setrelay');
$app['router']->get('system/relay','app\Controllers\Config\SystemController@relay');
$app['router']->get('system/getEnOrDe','app\Controllers\Config\SystemController@getEnOrDe');
$app['router']->get('system/getWiFiList','app\Controllers\Config\SystemController@wifi');
$app['router']->post('system/safePop_up','app\Controllers\Config\SystemController@safePop_up');
$app['router']->post('system/diskMount','app\Controllers\Config\SystemController@diskMount');
$app['router']->get('system/getDistOut','app\Controllers\Config\SystemController@getDistOut');
$app['router']->post('system/shell','app\Controllers\Config\SystemController@shell');
$app['router']->post('system/netUpdate','app\Controllers\Config\SystemController@netUpdate');

$app['router']->post('system/WiFiConnect','app\Controllers\Config\SystemController@WiFiConnect');
$app['router']->get('system/restore_factory_settings','app\Controllers\Config\SystemController@restore_factory_settings');
$app['router']->post('system/getMachineNumber','app\Controllers\Config\SystemController@getMachineNumber');
$app['router']->get('system/get-mac','app\Controllers\Config\SystemController@getMAC');
$app['router']->get('system/set-mac','app\Controllers\Config\SystemController@setMAC');
$app['router']->get('system/getInfo','app\Controllers\Config\SystemController@getInfo');


/*文件夹处理*/
$app['router']->post('folder/add','app\Controllers\Files\FolderController@add');
$app['router']->get('folder/get','app\Controllers\Files\FolderController@get');
$app['router']->post('folder/del','app\Controllers\Files\FolderController@del');
$app['router']->post('folder/copy','app\Controllers\Files\FolderController@copy');
$app['router']->get('folder/get-disk','app\Controllers\Files\FolderController@getDisk');
$app['router']->get('folder/download','app\Controllers\Files\FolderController@download');
$app['router']->get('folder/get-file-size','app\Controllers\Files\FolderController@getFileSize');
$app['router']->get('folder/get-file-size-in','app\Controllers\Files\FolderController@getFileSizeIn');
$app['router']->get('folder/clear-disk','app\Controllers\Files\FolderController@clearDisk');
$app['router']->get('folder/file-out','app\Controllers\Files\FolderController@fileOut');
$app['router']->get('folder/file-in','app\Controllers\Files\FolderController@fileIn');
$app['router']->get('folder/patientfile-out','app\Controllers\Files\FolderController@fileCreatPathOut');
$app['router']->post('folder/patientfile-out','app\Controllers\Files\FolderController@fileCreatPathOut'); 
$app['router']->post('folder/umount','app\Controllers\Files\FolderController@umount');
$app['router']->post('folder/fileList','app\Controllers\Files\FolderController@fileList');
$app['router']->post('folder/fileOutNew','app\Controllers\Files\FolderController@fileOutNew');
$app['router']->post('folder/video-time','app\Controllers\Files\FolderController@video_path');
$app['router']->post('folder/del-logo','app\Controllers\Files\FolderController@delLogo');
$app['router']->post('folder/clear_cp','app\Controllers\Files\FolderController@clear_cp');

/*文件上传*/
$app['router']->post('folder/upload-file','app\Controllers\Files\FolderController@uploadFile');
$app['router']->post('folder/upload-file-video','app\Controllers\Files\FolderController@uploadFileVideo');


/*模板*/
$app['router']->get('templete','app\Controllers\Report\TemplateController@index');
$app['router']->post('templete/templ-Form','app\Controllers\Report\TemplateController@templForm');
$app['router']->post('templete/templ-upload','app\Controllers\Report\TemplateController@templUpload');

/*报告*/
$app['router']->get('report','app\Controllers\Report\ReportController@index');
$app['router']->get('report/detail','app\Controllers\Report\ReportController@detail');
$app['router']->post('report/add','app\Controllers\Report\ReportController@add');
$app['router']->post('report/edit','app\Controllers\Report\ReportController@edit');
$app['router']->post('report/del','app\Controllers\Report\ReportController@del');
$app['router']->get('report/view','app\Controllers\Report\ReportController@view');
$app['router']->get('report/timeIndex','app\Controllers\Report\ReportController@timeIndex');



/*系统设置-管理员*/
$app['router']->get('admin','app\Controllers\Config\AdminController@index');
$app['router']->post('admin/add','app\Controllers\Config\AdminController@add');
$app['router']->post('admin/edit','app\Controllers\Config\AdminController@edit');
$app['router']->post('admin/del','app\Controllers\Config\AdminController@del');

/*扫描相关*/
$app['router']->get('scan','app\Controllers\Config\ScanController@index');
$app['router']->get('scan/verify','app\Controllers\Config\ScanController@verify');

/*初始化*/
$app['router']->get('init','app\Controllers\Init\IndexController@index');
$app['router']->get('init/reset','app\Controllers\Init\IndexController@reset');

/*日志处理*/
$app['router']->get('log','app\Controllers\Log\IndexController@index');
$app['router']->post('log/add','app\Controllers\Log\IndexController@add');
$app['router']->post('log/del','app\Controllers\Log\IndexController@del');

/*登录退出*/
$app['router']->post('/user/login','app\Controllers\Common\UserController@login');
$app['router']->get('/user/login-sign','app\Controllers\Common\UserController@loginSign');
$app['router']->post('/user/login-info','app\Controllers\Common\UserController@loginInfo');
$app['router']->post('/user/logout','app\Controllers\Common\UserController@logout');
$app['router']->post('/user/reset-root','app\Controllers\Common\UserController@resetRoot');


/*专用于测试的控制器*/
$app['router']->get('testbyzyb','app\Controllers\Test\TestController@test');

$app['router']->get('testq','app\Controllers\Test\TestController@testt');

$app['router']->get('test','app\Controllers\Files\FolderController@getDisk');
