<?php

namespace Predmond\HtmlToAmp;

use League\Event\Emitter;
use League\Event\EmitterInterface;
use Predmond\HtmlToAmp\Converter\ConverterInterface as Converter;
use Predmond\HtmlToAmp\Converter\ImageConverter;

class Environment
{
    /**
     * @var EmitterInterface
     */
    private $eventEmitter;

    public function __construct(EmitterInterface $eventEmitter = null)
    {
        $this->eventEmitter = $eventEmitter;

        if ($this->eventEmitter === null) {
            $this->eventEmitter = new Emitter();
        }
    }

    public static function createDefaultEnvironment()
    {
        $env = new static();
        $env->addListener(new ImageConverter());

        return $env;
    }

    public function addListener(Converter $listener, $priority = EmitterInterface::P_NORMAL)
    {
        foreach ($listener->getSubscribedEvents() as $tag => $method) {
            $this->createEvent($tag, $listener, $method, $priority);
        }

        return $this;
    }

    protected function createEvent($event, $listener, $method, $priority = EmitterInterface::P_NORMAL)
    {
        $method = (array) $method;

        $priority = count($method) > 1 ? $method[1] : $priority;

        $method = $method[0];

        $this->eventEmitter->addListener(
            "amp.$event", [$listener, $method], $priority
        );
    }

    /**
     * @return Emitter|EmitterInterface
     */
    public function getEventEmitter()
    {
        return $this->eventEmitter;
    }
}
