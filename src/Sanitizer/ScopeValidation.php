<?php

namespace Predmond\HtmlToAmp\Sanitizer;

use League\Event\EventInterface;
use Predmond\HtmlToAmp\ElementInterface;

class ScopeValidation extends Sanitizer
{
    /**
     * {@inheritdoc}
     */
    protected $events = [
        '*' => ['handleElementScope', 150]
    ];


    public function handleElementScope(EventInterface $event, ElementInterface $element)
    {

        $child = $element->getTagName();
        $parent = $element->getParent()->getTagName();

        //Skip this removal if current element isn't defined in spec context
        //as child value
        if (! in_array($child, $this->getElementFromSpec())) {
            return $element;
        }

        if (! $this->spec->isRelated($parent.'.'.$child)) {
            $element->remove();
        }

        return $element;
    }

    protected function getElementFromSpec()
    {
        $elements = [];

        foreach ($this->spec->getRelation(false) as $relations) {
            foreach ($relations as $child) {
                $elements[] = $child;
            }
        }

        return array_unique($elements);
    }
}
