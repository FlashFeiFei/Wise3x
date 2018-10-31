<?php
/**
 * Created by PhpStorm.
 * User: liangyu
 * Date: 2018/10/31
 * Time: 11:04
 */

namespace Wise\MiniProgram\Image;

use Wise\MiniProgram\Core\AbstractMiniProgram;
use Wise\Core\Exceptions\InvalidArgumentException;

class image extends AbstractMiniProgram
{
    //图片上传
    const API_UPLOAD_IMAGE = 'https://openapi.baidu.com/rest/2.0/smartapp/upload/image';

    /**
     * 图片上传
     * @param $path
     * @return \Wise\Support\Collection
     * @throws InvalidArgumentException
     */
    public function uploadImage($path)
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new InvalidArgumentException("File does not exist, or the file is unreadable: '$path'");
        }
        //post文件数据，资源字段
        $files = [
            'multipartFile' => $path
        ];
        //post数据，非资源字段
        $form = [];
        //url?后面的参数
        $queries = [];

        return $this->parseJSON('upload', [self::API_UPLOAD_IMAGE, $files, $form, $queries]);
    }
}