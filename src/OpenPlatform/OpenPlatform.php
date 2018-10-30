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
 * OpenPlatform.php.
 *
 * Part of Overtrue\WeChat.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    mingyoung <mingyoungcheung@gmail.com>
 * @copyright 2016
 *
 * @see      https://github.com/overtrue
 * @see      http://overtrue.me
 */

namespace Wise\OpenPlatform;

use Wise\Support\Traits\PrefixedContainer;

/**
 * Class OpenPlatform.
 *
 * @property \Wise\OpenPlatform\Api\BaseApi $api
 * @property \Wise\OpenPlatform\Api\PreAuthorization $pre_auth
 * @property \Wise\OpenPlatform\Guard $server
 * @property \Wise\OpenPlatform\AccessToken $access_token
 *
 * @method \Wise\Support\Collection getAuthorizationInfo($authCode = null)
 * @method \Wise\Support\Collection getAuthorizerInfo($authorizerAppId)
 * @method \Wise\Support\Collection getAuthorizerOption($authorizerAppId, $optionName)
 * @method \Wise\Support\Collection setAuthorizerOption($authorizerAppId, $optionName, $optionValue)
 * @method \Wise\Support\Collection getAuthorizerList($offset = 0, $count = 500)
 */
class OpenPlatform
{
    use PrefixedContainer;

    /**
     * Create an instance of the EasyWeChat for the given authorizer.
     *
     * @param string $appId        Authorizer AppId
     * @param string $refreshToken Authorizer refresh-token
     *
     * @return \Wise\Foundation\Application
     */
    public function createAuthorizerApplication($appId, $refreshToken)
    {
        $this->fetch('authorizer', function ($authorizer) use ($appId, $refreshToken) {
            $authorizer->setAppId($appId);
            $authorizer->setRefreshToken($refreshToken);
        });

        return $this->fetch('app', function ($app) {
            $app['access_token'] = $this->fetch('authorizer_access_token');
            $app['oauth'] = $this->fetch('oauth');
            $app['server'] = $this->fetch('server');
        });
    }

    /**
     * Quick access to the base-api.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->api, $method], $args);
    }
}
