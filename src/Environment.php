<?php

namespace Predmond\HtmlToAmp;

use League\Event\Emitter;
use League\Event\EmitterInterface;
use Predmond\HtmlToAmp\Converter\ConverterInterface as Converter;
use Predmond\HtmlToAmp\Sanitizer\ElementSanitizer;
use Predmond\HtmlToAmp\Sanitizer\ScopeValidation;
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
        $env->addListener(new ElementSanitizer(), 200);
        $env->addListener(new ScopeValidation());
        $env->addListener(new ImageConverter());

        return $env;
    }

    /**
     * Add a listener for events.
     *
     * The events should have been defined inside the listener class.
     *
     * @see  Environment::createEvent()
     *
     * @param Converter $listener Listener class.
     * @param int       $priority
     *
     * @return Environment
     */
    public function addListener(Converter $listener, $priority = EmitterInterface::P_NORMAL)
    {
        foreach ($listener->getSubscribedEvents() as $tag => $method) {
            $this->createEvent($tag, $listener, $method, $priority);
        }

        return $this;
    }

    /**
     * Create an event.
     *
     * @param string       $event    The event name which identified by tag name.
     *                               The event will then prefixed by 'amp' unless
     *                               wildcard (*) event is given.
     * @param Converter    $listener Listener class.
     * @param array|string $method   The method of listener should get invoked.
     *                               If an array given, the 2nd value will identified
     *                               as event priority.
     * @param int          $priority
     *
     * @return void
     */
    protected function createEvent($event, $listener, $method, $priority = EmitterInterface::P_NORMAL)
    {
        $method = (array) $method;

        $priority = count($method) > 1 ? $method[1] : $priority;

        $method = $method[0];

        $event = $event !== '*' ? 'amp.'.$event : '*';

        $this->eventEmitter->addListener(
            $event, [$listener, $method], $priority
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
