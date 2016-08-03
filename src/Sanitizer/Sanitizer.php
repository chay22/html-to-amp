<?php

namespace Predmond\HtmlToAmp\Sanitizer;

use Predmond\HtmlToAmp\Converter\ConverterInterface;
use Predmond\HtmlToAmp\Spec;

abstract class Sanitizer implements ConverterInterface
{
    protected $spec;
    protected $events = [];

    public function __construct()
    {
        $this->spec = new Spec();
    }

    public function getSubscribedEvents()
    {
        return $this->events;
    }
}