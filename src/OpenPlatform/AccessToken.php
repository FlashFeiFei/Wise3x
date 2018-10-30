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
 * AccessToken.php.
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

use Wise\Core\AccessToken as CoreAccessToken;
use Wise\Core\Exceptions\HttpException;

class AccessToken extends CoreAccessToken
{
    /**
     * VerifyTicket.
     *
     * @var \Wise\OpenPlatform\VerifyTicket
     */
    protected $verifyTicket;

    /**
     * API.
     */
    const API_TOKEN_GET = 'https://openapi.baidu.com/public/2.0/smartapp/auth/tp/token';

    /**
     * {@inheritdoc}.
     */
    protected $queryName = 'access_token';

    /**
     * {@inheritdoc}.
     */
    protected $tokenJsonKey = 'access_token';

    /**
     * {@inheritdoc}.
     */
    protected $prefix = 'wise.open_platform.component_access_token.';

    /**
     * Set VerifyTicket.
     *
     * @param \Wise\OpenPlatform\VerifyTicket $verifyTicket
     *
     * @return $this
     */
    public function setVerifyTicket(VerifyTicket $verifyTicket)
    {
        $this->verifyTicket = $verifyTicket;

        return $this;
    }

    /**
     * {@inheritdoc}.
     */
    public function getTokenFromServer()
    {
        $data = [
            'client_id' => $this->appId,
            'ticket' => $this->verifyTicket->getTicket(),
        ];

        $http = $this->getHttp();

        $token = $http->parseJSON($http->get(self::API_TOKEN_GET, $data));

        if (empty($token['data']) || empty($token['data'][$this->tokenJsonKey])) {
            throw new HttpException('Request ComponentAccessToken fail. response: ' . json_encode($token, JSON_UNESCAPED_UNICODE));
        }
        $token = $token['data'];

        return $token;
    }
}
