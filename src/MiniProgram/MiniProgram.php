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
 * MiniProgram.php.
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

namespace Wise\MiniProgram;

use Wise\Support\Traits\PrefixedContainer;

/**
 * Class MiniProgram.
 * @property \Wise\MiniProgram\Sns\Sns $sns
 * @property \Wise\MiniProgram\Image\Image $image
 * @property \Wise\MiniProgram\Info\Info $info
 * @property \Wise\MiniProgram\Package\Package $package
 */
class MiniProgram
{
    use PrefixedContainer;
}
