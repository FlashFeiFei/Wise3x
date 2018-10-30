<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * BaseApi.php.
 *
 * Part of Overtrue\WeChat.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    mingyoung <mingyoungcheung@gmail.com>
 * @author    lixiao <leonlx126@gmail.com>
 * @copyright 2016
 *
 * @see      https://github.com/overtrue
 * @see      http://overtrue.me
 */

namespace Wise\OpenPlatform\Api;

class BaseApi extends AbstractOpenPlatform
{
    /**
     * Get auth info api.
     * 通过授权码获取授权用户的信息
     */
    const GET_AUTH_INFO = 'https://openapi.baidu.com/rest/2.0/oauth/token';

    /**
     * Get authorizer token api.
     * 通过refresh_token去刷新token
     */
    const GET_AUTHORIZER_TOKEN = 'https://openapi.baidu.com/rest/2.0/oauth/token';

    /**
     * Get authorization info.
     * 通过授权码获取token
     *
     * @param $authCode
     *
     * @return \Wise\Support\Collection
     */
    public function getAuthorizationInfo($authCode = null)
    {
        $params = [
            'code' => $authCode ?: $this->request->get('authorization_code'),
            'grant_type' => 'app_to_tp_authorization_code'
        ];

        return $this->parseJSON('get', [self::GET_AUTH_INFO, $params]);
    }

    /**
     * Get authorizer token.
     *
     * It doesn't cache the authorizer-access-token.
     * So developers should NEVER call this method.
     * It'll called by: AuthorizerAccessToken::renewAccessToken()
     *
     * @param $refreshToken
     *
     * @return \Wise\Support\Collection
     */
    public function getAuthorizerToken($refreshToken)
    {
        $params = [
            'grant_type' => 'app_to_tp_refresh_token',
            'refresh_token' => $refreshToken,
        ];

        return $this->parseJSON('get', [self::GET_AUTHORIZER_TOKEN, $params]);
    }
}
