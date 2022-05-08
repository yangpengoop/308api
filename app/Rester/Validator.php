<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2017/11/28
 * Time: 10:57
 */
namespace Rester;
use Illuminate\Validation\ValidationException;

class Validator extends \Illuminate\Validation\Factory
{
    /***
     * 创建实例
     *
     * @return \Illuminate\Validation\Factory
     */
    public static function getInstance()
    {
        static $validator = null;
        if ($validator === null) {
            $test_translation_path = __DIR__.'/lang';
            $test_translation_locale = 'en';
            $translation_file_loader = new \Illuminate\Translation\FileLoader(new \Illuminate\Filesystem\Filesystem, $test_translation_path);
            $translator = new \Illuminate\Translation\Translator($translation_file_loader, $test_translation_locale);
            $validator = new \Illuminate\Validation\Factory($translator);
        }
        return $validator;
    }

    /**
     * @param array $rules  验证规则
     * @param array $data   验证数据
     * @return bool
     */
    public static function validators($rules=[],$data=[])
    {
        $v = self::vmake($rules,$data);
        if( $v->fails() )
        {
            throw new ValidationException($v);
        }
        return true;
    }

    /**
     * 验证实例
     * @param $rules
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    private static function vmake($rules,$data)
    {
        $v = self::getInstance()->make($data,$rules);
        return $v;
    }
}