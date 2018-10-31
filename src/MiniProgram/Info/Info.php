<?php
/**
 * Created by PhpStorm.
 * User: liangyu
 * Date: 2018/10/31
 * Time: 10:01
 */

namespace Wise\MiniProgram\Info;

use Wise\MiniProgram\Core\AbstractMiniProgram;

class Info extends AbstractMiniProgram
{
    //获取小程序类目
    const API_CATEGORY_LIST = 'https://openapi.baidu.com/rest/2.0/smartapp/app/category/list';
    //修改小程序类目
    const API_CATEGORY_UPDATE = 'https://openapi.baidu.com/rest/2.0/smartapp/app/category/update';
    //修改小程序icon
    const API_APP_MODIFYHEADIMAGE = 'https://openapi.baidu.com/rest/2.0/smartapp/app/modifyheadimage';
    //修改功能介绍
    const API_APP_MODIFYSIGNATURE = 'https://openapi.baidu.com/rest/2.0/smartapp/app/modifysignature';
    //暂停服务
    const API_APP_PAUSE = 'https://openapi.baidu.com/rest/2.0/smartapp/app/pause';
    //开启服务
    const API_APP_RESUME = 'https://openapi.baidu.com/rest/2.0/smartapp/app/resume';
    //获取体验二维码
    const API_APP_QRCODE = 'https://openapi.baidu.com/rest/2.0/smartapp/app/qrcode';
    //小程序名称设置及改名
    const API_APP_SETNICKNAME = 'https://openapi.baidu.com/rest/2.0/smartapp/app/setnickname';
    //获取小程序基础信息
    const API_APP_INFO = 'https://openapi.baidu.com/rest/2.0/smartapp/app/info';

    /**
     * 获取小程序类目
     * @return \Wise\Support\Collection
     */
    public function categoryList()
    {
        $params = [
            'category_type' => 2
        ];
        return $this->parseJSON('get', [self::API_CATEGORY_LIST, $params]);
    }

    /**
     * 修改小程序类目
     * @param $categorys_json
     * @return \Wise\Support\Collection
     */
    public function categoryUpdate($categorys_json)
    {
        $params = [
            'categorys' => $categorys_json
        ];
        return $this->parseJSON('post', [self::API_CATEGORY_UPDATE, $params]);
    }

    /**
     * 修改小程序icon
     * @param $image_url
     * @return \Wise\Support\Collection
     */
    public function modifyheadimage($image_url)
    {
        $params = [
            'image_url' => $image_url
        ];
        return $this->parseJSON('post', [self::API_APP_MODIFYHEADIMAGE, $params]);
    }

    /**
     * 修改功能介绍
     * @param $signature
     * @return \Wise\Support\Collection
     */
    public function modifysignature($signature)
    {
        $params = [
            'signature' => $signature
        ];
        return $this->parseJSON('post', [self::API_APP_MODIFYSIGNATURE, $params]);
    }

    /**
     * 暂停服务
     * @return \Wise\Support\Collection
     */
    public function appPause()
    {
        return $this->parseJSON('post', [self::API_APP_PAUSE]);
    }

    /**
     * 开启服务
     * @return \Wise\Support\Collection
     */
    public function appResume()
    {
        return $this->parseJSON('post', [self::API_APP_RESUME]);
    }

    /**
     * 获取体验二维码
     * @param $package_id
     * @return \Psr\Http\Message\StreamInterface
     * @throws \Wise\Core\Exceptions\HttpException
     */
    public function qrcode($package_id)
    {
        $params = [
            'package_id' => $package_id
        ];

        return $this->getHttp()->get(self::API_APP_QRCODE, $params)->getBody();;
    }

    /**
     * 小程序名称设置及改名
     * @param $nick_name
     * @return \Wise\Support\Collection
     */
    public function setnickname($nick_name)
    {
        $params = [
            'nick_name' => $nick_name
        ];
        return $this->parseJSON('post', [self::API_APP_SETNICKNAME, $params]);
    }

    /**
     * 获取小程序基础信息
     * @return \Wise\Support\Collection
     */
    public function info()
    {
        return $this->parseJSON('get', [self::API_APP_INFO]);
    }

}