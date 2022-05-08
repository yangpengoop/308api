<?php
return [
    'driver'    => 'mysql',
    'host'      => env('MYSQL_HOST',''),
    'database'  => env('MYSQL_DATA','408'),
    'username'  => env('MYSQL_NAME','root'),
    'password'  => env('MYSQL_PASS','root'),
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => ''
];

// return [
//     'driver'   => 'sqlite',
//     'database' => __DIR__.'/../sqlite/s309TY.db',
//     'prefix'   => '',
// ];