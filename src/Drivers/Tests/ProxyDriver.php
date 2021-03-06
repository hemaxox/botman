<?php

namespace Mpociot\BotMan\Drivers\Tests;

use Mpociot\BotMan\Message;
use Mpociot\BotMan\Http\Curl;
use Mpociot\BotMan\Drivers\NullDriver;
use Symfony\Component\HttpFoundation\Request;
use Mpociot\BotMan\Interfaces\DriverInterface;

/**
 * A driver that acts as a proxy for a global driver instance. Useful for mock/fake drivers in integration tests.
 */
final class ProxyDriver implements DriverInterface
{
    /**
     * @var DriverInterface
     */
    private static $instance;

    /**
     * Set driver instance to be used.
     *
     * @param DriverInterface $driver
     */
    public static function setInstance(DriverInterface $driver)
    {
        self::$instance = $driver;
    }

    /**
     * @return DriverInterface
     */
    private static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new NullDriver(new Request, [], new Curl);
        }

        return self::$instance;
    }

    public function matchesRequest()
    {
        return self::instance()->matchesRequest();
    }

    public function hasMatchingEvent()
    {
        return self::instance()->hasMatchingEvent();
    }

    public function getMessages()
    {
        return self::instance()->getMessages();
    }

    public function isBot()
    {
        return self::instance()->isBot();
    }

    public function isConfigured()
    {
        return self::instance()->isConfigured();
    }

    public function getUser(Message $matchingMessage)
    {
        return self::instance()->getUser($matchingMessage);
    }

    public function getConversationAnswer(Message $message)
    {
        return self::instance()->getConversationAnswer($message);
    }

    public function buildServicePayload($message, $matchingMessage, $additionalParameters = [])
    {
        return self::instance()->buildServicePayload($message, $matchingMessage, $additionalParameters);
    }

    public function sendPayload($payload)
    {
        return self::instance()->sendPayload($payload);
    }

    public function getName()
    {
        return self::instance()->getName();
    }

    public function types(Message $matchingMessage)
    {
        return self::instance()->types($matchingMessage);
    }
}
