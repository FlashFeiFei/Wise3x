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
 * MiniProgramServiceProvider.php.
 *
 * This file is part of the wechat.
 *
 * (c) mingyoung <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Wise\Foundation\ServiceProviders;

use Wise\MiniProgram\AccessToken;
use Wise\MiniProgram\MiniProgram;
use Wise\MiniProgram\Image\Image;
use Wise\MiniProgram\Info\Info;
use Wise\MiniProgram\Sns\Sns;
use Wise\MiniProgram\Package\Package;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class MiniProgramServiceProvider.
 */
class MiniProgramServiceProvider implements ServiceProviderInterface
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
        $pimple['mini_program.access_token'] = function ($pimple) {
            //这个是自己的AccessToken,但是我没有写自己的智能小程序
            //所以，这个组件会在MiniProgram的createAuthorizerMiniProgram方法中重置为授权用户的AccessToken
            return new AccessToken(
                $pimple['config']['mini_program']['client_id'],
                $pimple['config']['mini_program']['client_secret'],
                $pimple['cache']
            );
        };

        $pimple['mini_program.image'] = function ($pimple) {
            return new Image($pimple['mini_program.access_token']);
        };

        $pimple['mini_program.info'] = function ($pimple) {
            return new Info($pimple['mini_program.access_token']);
        };

        $pimple['mini_program.package'] = function ($pimple) {
            return new Package($pimple['mini_program.access_token']);
        };

        $pimple['mini_program.sns'] = function ($pimple) {
            return new Sns(
                $pimple['mini_program.access_token']
            );
        };

        $pimple['mini_program'] = function ($pimple) {
            return new MiniProgram($pimple);
        };
    }
}
