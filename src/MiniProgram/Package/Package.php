<?php
/**
 * Created by PhpStorm.
 * User: liangyu
 * Date: 2018/10/31
 * Time: 9:19
 */

namespace Wise\MiniProgram\Package;

use Wise\MiniProgram\Core\AbstractMiniProgram;

class Package extends AbstractMiniProgram
{
    //为授权的小程序帐号上传小程序代码
    const API_PACKAGE_UPLOAD = 'https://openapi.baidu.com/rest/2.0/smartapp/package/upload';
    //为授权的小程序提交审核
    const API_PACKAGE_DUBMITAUDIT = 'https://openapi.baidu.com/rest/2.0/smartapp/package/submitaudit';
    //发布已通过审核的小程序
    const API_PACKAGE_RELEASE = 'https://openapi.baidu.com/rest/2.0/smartapp/package/release';
    //小程序版本回退
    const API_PACKAGE_ROLLBACK = 'https://openapi.baidu.com/rest/2.0/smartapp/package/rollback';
    //小程序审核撤回
    const API_PACKAGE_WITHDRAW = 'https://openapi.baidu.com/rest/2.0/smartapp/package/withdraw';
    //获取授权小程序预览包详情
    const API_PACKAGE_GETTRIAL = 'https://openapi.baidu.com/rest/2.0/smartapp/package/gettrial';
    //获取小程序包列表
    const API_PACKAGE_GET = 'https://openapi.baidu.com/rest/2.0/smartapp/package/get';
    //获取授权小程序包详情
    const API_PACKAGE_GETDETAIL = 'https://openapi.baidu.com/rest/2.0/smartapp/package/getdetail';

    /**
     * 为授权的小程序帐号上传小程序代码
     * @param $template_id
     * @param $ext_json
     * @param $user_version
     * @param $user_desc
     * @return \Wise\Support\Collection
     */
    public function upload($template_id, $ext_json, $user_version, $user_desc)
    {
        $params = [
            'template_id' => $template_id,
            'ext_json' => $ext_json,
            'user_version' => $user_version,
            'user_desc' => $user_desc
        ];
        return $this->parseJSON('post', [self::API_PACKAGE_UPLOAD, $params]);
    }

    /**
     * 为授权的小程序提交审核
     * @param $content
     * @param $package_id
     * @param $remark
     * @return \Wise\Support\Collection
     */
    public function submitaudit($content, $package_id, $remark)
    {
        $params = [
            'content' => $content,
            'package_id' => $package_id,
            'remark' => $remark
        ];
        return $this->parseJSON('post', [self::API_PACKAGE_DUBMITAUDIT, $params]);
    }

    /**
     * 发布已通过审核的小程序
     * @param $package_id
     * @return \Wise\Support\Collection
     */
    public function release($package_id)
    {
        $params = [
            'package_id' => $package_id
        ];
        return $this->parseJSON('post', [self::API_PACKAGE_RELEASE, $params]);
    }

    /**
     * 小程序版本回退
     * @param $package_id
     * @return \Wise\Support\Collection
     */
    public function rollback($package_id)
    {
        $params = [
            'package_id' => $package_id
        ];
        return $this->parseJSON('post', [self::API_PACKAGE_ROLLBACK, $params]);
    }

    /**
     * 小程序审核撤回
     * @param $package_id
     * @return \Wise\Support\Collection
     */
    public function withdraw($package_id)
    {
        $params = [
            'package_id' => $package_id
        ];
        return $this->parseJSON('post', [self::API_PACKAGE_WITHDRAW, $params]);
    }

    /**
     * 获取授权小程序预览包详情
     * @return \Wise\Support\Collection
     */
    public function gettrial()
    {
        return $this->parseJSON('get', [self::API_PACKAGE_GETTRIAL]);
    }

    /**
     * 获取小程序包列表
     * @return \Wise\Support\Collection
     */
    public function get()
    {
        return $this->parseJSON('get', [self::API_PACKAGE_GET]);
    }

    /**
     * 获取授权小程序包详情
     * @param null $type
     * @param null $package_id
     * @return \Wise\Support\Collection
     */
    public function getdetail($type = null, $package_id = null)
    {
        if (!empty($type) && !empty($package_id)) {
            $params = [
                'type' => $type,
                'package_id' => $package_id
            ];
        }
        return $this->parseJSON('get', [self::API_PACKAGE_GETDETAIL, $params]);
    }
}