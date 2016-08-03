<?php

namespace Predmond\HtmlToAmp\Sanitizer;

use Predmond\HtmlToAmp\Converter\ConverterInterface;
use Predmond\HtmlToAmp\Spec;

abstract class Sanitizer implements ConverterInterface
{
    /**
     * The AMP specification class.
     *
     * @var Spec
     */
    protected $spec;

    /**
     * The class' events should listen to.
     *
     * @var array
     */
    protected $events = [];

    public function __construct()
    {
        $this->spec = new Spec();
    }

    /**
     * Get the events.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return $this->events;
    }
}
