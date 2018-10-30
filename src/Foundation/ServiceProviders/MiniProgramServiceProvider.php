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
use Wise\MiniProgram\Material\Temporary;
use Wise\MiniProgram\MiniProgram;
use Wise\MiniProgram\Notice\Notice;
use Wise\MiniProgram\QRCode\QRCode;
use Wise\MiniProgram\Sns\Sns;
use Wise\MiniProgram\Staff\Staff;
use Wise\MiniProgram\Stats\Stats;
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
            return new AccessToken(
                $pimple['config']['mini_program']['client_id'],
                $pimple['config']['mini_program']['client_secret'],
                $pimple['cache']
            );
        };

        $pimple['mini_program.staff'] = function ($pimple) {
            return new Staff($pimple['mini_program.access_token']);
        };

        $pimple['mini_program.notice'] = function ($pimple) {
            return new Notice($pimple['mini_program.access_token']);
        };

        $pimple['mini_program.material_temporary'] = function ($pimple) {
            return new Temporary($pimple['mini_program.access_token']);
        };

        $pimple['mini_program.stats'] = function ($pimple) {
            return new Stats(
                $pimple['mini_program.access_token'],
                $pimple['config']['mini_program']
            );
        };

        $pimple['mini_program.sns'] = function ($pimple) {
            return new Sns(
                $pimple['mini_program.access_token'],
                $pimple['config']['mini_program']
            );
        };

        $pimple['mini_program.qrcode'] = function ($pimple) {
            return new QRCode(
                $pimple['mini_program.access_token'],
                $pimple['config']['mini_program']
            );
        };

        $pimple['mini_program'] = function ($pimple) {
            return new MiniProgram($pimple);
        };
    }
}
