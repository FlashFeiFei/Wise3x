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
 * OpenPlatformServiceProvider.php.
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

namespace Wise\Foundation\ServiceProviders;

use Wise\Encryption\Encryptor;
use Wise\Foundation\Application;
use Wise\OpenPlatform\AccessToken;
use Wise\OpenPlatform\Api\BaseApi;
use Wise\OpenPlatform\Api\PreAuthorization;
use Wise\OpenPlatform\Authorizer;
use Wise\OpenPlatform\AuthorizerAccessToken;
use Wise\OpenPlatform\EventHandlers;
use Wise\OpenPlatform\Guard;
use Wise\OpenPlatform\OpenPlatform;
use Wise\OpenPlatform\VerifyTicket;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OpenPlatformServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['open_platform.verify_ticket'] = function ($pimple) {
            return new VerifyTicket(
                $pimple['config']['open_platform']['client_id'],
                $pimple['cache']
            );
        };

        $pimple['open_platform.access_token'] = function ($pimple) {
            $accessToken = new AccessToken(
                $pimple['config']['open_platform']['client_id'],
                $pimple['config']['open_platform']['client_secret'],
                $pimple['cache']
            );
            $accessToken->setVerifyTicket($pimple['open_platform.verify_ticket']);

            return $accessToken;
        };

        $pimple['open_platform.encryptor'] = function ($pimple) {
            return new Encryptor(
                $pimple['config']['open_platform']['client_id'],
                $pimple['config']['open_platform']['token'],
                $pimple['config']['open_platform']['aes_key']
            );
        };

        $pimple['open_platform'] = function ($pimple) {
            return new OpenPlatform($pimple);
        };

        $pimple['open_platform.server'] = function ($pimple) {
            $server = new Guard($pimple['config']['open_platform']['token']);
            $server->debug($pimple['config']['debug']);
            $server->setEncryptor($pimple['open_platform.encryptor']);
            $server->setHandlers([
                Guard::EVENT_AUTHORIZED => $pimple['open_platform.handlers.authorized'],
                Guard::EVENT_UNAUTHORIZED => $pimple['open_platform.handlers.unauthorized'],
                Guard::EVENT_UPDATE_AUTHORIZED => $pimple['open_platform.handlers.updateauthorized'],
                Guard::EVENT_COMPONENT_VERIFY_TICKET => $pimple['open_platform.handlers.component_verify_ticket'],
            ]);

            return $server;
        };

        $pimple['open_platform.pre_auth'] = $pimple['open_platform.pre_authorization'] = function ($pimple) {
            return new PreAuthorization(
                $pimple['open_platform.access_token'],
                $pimple['request']
            );
        };

        $pimple['open_platform.api'] = function ($pimple) {
            return new BaseApi(
                $pimple['open_platform.access_token'],
                $pimple['request']
            );
        };

        $pimple['open_platform.authorizer'] = function ($pimple) {
            return new Authorizer(
                $pimple['open_platform.api'],
                $pimple['config']['open_platform']['client_id'],
                $pimple['cache']
            );
        };

        $pimple['open_platform.authorizer_access_token'] = function ($pimple) {
            return new AuthorizerAccessToken(
                $pimple['config']['open_platform']['client_id'],
                $pimple['open_platform.authorizer']
            );
        };

        // Authorization events handlers.
        $pimple['open_platform.handlers.component_verify_ticket'] = function ($pimple) {
            return new EventHandlers\ComponentVerifyTicket($pimple['open_platform.verify_ticket']);
        };
        $pimple['open_platform.handlers.authorized'] = function () {
            return new EventHandlers\Authorized();
        };
        $pimple['open_platform.handlers.updateauthorized'] = function () {
            return new EventHandlers\UpdateAuthorized();
        };
        $pimple['open_platform.handlers.unauthorized'] = function () {
            return new EventHandlers\Unauthorized();
        };

        $pimple['open_platform.app'] = function ($pimple) {
            return new Application($pimple['config']->toArray());
        };
    }

}
