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
 * PreAuthorization.php.
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

use Wise\Core\Exceptions\InvalidArgumentException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PreAuthorization extends AbstractOpenPlatform
{
    /**
     * Create pre auth code url.
     */
    const CREATE_PRE_AUTH_CODE = 'https://openapi.baidu.com/rest/2.0/smartapp/tp/createpreauthcode';

    /**
     * Pre auth link.
     */
    const PRE_AUTH_LINK = 'http://smartprogram.baidu.com/mappconsole/tp/authorization?client_id=%s&pre_auth_code=%s&redirect_uri=%s';

    /**
     * Get pre auth code.
     *
     * @throws \Wise\Core\Exceptions\InvalidArgumentException
     *
     * @return string
     */
    public function getCode()
    {
        $data = [];

        $result = $this->parseJSON('get', [self::CREATE_PRE_AUTH_CODE, $data]);

        if (empty($result['data']) || empty($result['data']['pre_auth_code'])) {
            throw new InvalidArgumentException('Invalid response.');
        }

        return $result['data']['pre_auth_code'];
    }

    /**
     * Redirect to WeChat PreAuthorization page.
     *
     * @param string $url
     * @param string $preAuthCode
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect($url, $preAuthCode = null)
    {
        return new RedirectResponse(
            sprintf(self::PRE_AUTH_LINK, $this->getAppId(), $preAuthCode ?: $this->getCode(), urlencode($url))
        );
    }
}
