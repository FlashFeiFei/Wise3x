<?php
/**
 * Created by PhpStorm.
 * User: liangyu
 * Date: 2018/10/31
 * Time: 11:25
 */

namespace Wise\MiniProgram\Sns;

use Wise\MiniProgram\Core\AbstractMiniProgram;

class Sns extends AbstractMiniProgram
{
    //登录接口
    const API_GET_SESSION_KEY_BY_CODE = 'https://openapi.baidu.com/rest/2.0/oauth/getsessionkeybycode';

    /**
     * TP代授权小程序登录
     * @param $code
     * @return \Wise\Support\Collection
     */
    public function getsessionkeybycode($code)
    {
        $params = [
            'code' => $code,
            'grant_type' => 'authorization_code'
        ];
        return $this->parseJSON('get', [self::API_GET_SESSION_KEY_BY_CODE, $params]);
    }
}