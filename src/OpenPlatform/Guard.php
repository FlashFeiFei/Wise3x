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
 * Guard.php.
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

namespace Wise\OpenPlatform;

use Wise\Server\Guard as ServerGuard;
use Wise\Support\Collection;
use Wise\Support\Log;
use Symfony\Component\HttpFoundation\Response;

class Guard extends ServerGuard
{
    const EVENT_AUTHORIZED = 'authorized';
    const EVENT_UNAUTHORIZED = 'unauthorized';
    const EVENT_UPDATE_AUTHORIZED = 'updateauthorized';
    const EVENT_COMPONENT_VERIFY_TICKET = 'ticket';

    /**
     * Event handlers.
     *
     * @var \Wise\Support\Collection
     */
    protected $handlers;

    /**
     * Set handlers.
     *
     * @param array $handlers
     */
    public function setHandlers(array $handlers)
    {
        $this->handlers = new Collection($handlers);

        return $this;
    }

    /**
     * Get handlers.
     *
     * @return \Wise\Support\Collection
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Get handler.
     *
     * @param string $type
     *
     * @return \Wise\OpenPlatform\EventHandlers\EventHandler|null
     */
    public function getHandler($type)
    {
        return $this->handlers->get($type);
    }

    /**
     * {@inheritdoc}
     */
    public function serve()
    {
        $message = $this->getMessage();

//        // Handle Messages.智能小程序目前处理tick之外没有别的
//        if (isset($message['MsgType'])) {
//            return parent::serve();
//        }

        Log::debug('OpenPlatform Request received:', [
            'Method' => $this->request->getMethod(),
            'URI' => $this->request->getRequestUri(),
            'Query' => $this->request->getQueryString(),
            'Protocal' => $this->request->server->get('SERVER_PROTOCOL'),
            'Content' => $this->request->getContent(),
        ]);

        // If sees the `auth_code` query parameter in the url, that is,
        // authorization is successful and it calls back, meanwhile, an
        // `authorized` event, which also includes the auth code, is sent
        // from WeChat, and that event will be handled.
        if ($this->request->get('auth_code')) {
            return new Response(self::SUCCESS_EMPTY_RESPONSE);
        }

        $this->handleEventMessage($message);

        return new Response(self::SUCCESS_EMPTY_RESPONSE);
    }

    /**
     * Handle event message.
     *
     * @param array $message
     */
    protected function handleEventMessage(array $message)
    {
        Log::debug('OpenPlatform Event Message detail:', $message);

        $message = new Collection($message);

        $infoType = $message->get('MsgType');

        if ($handler = $this->getHandler($infoType)) {
            $handler->handle($message);
        } else {
            Log::notice("No existing handler for '{$infoType}'.");
        }
        //执行自定义的回调函数
        if ($messageHandler = $this->getMessageHandler()) {
            call_user_func_array($messageHandler, [$message]);
        }
    }
}
