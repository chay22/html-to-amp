<?php

namespace Predmond\HtmlToAmp\Sanitizer;

use League\Event\EventInterface;
use Predmond\HtmlToAmp\ElementInterface;

class ElementSanitizer extends Sanitizer
{
    protected $events = [
        'html' => 'sanitize'
    ];

    public function sanitize(EventInterface $event, ElementInterface $element)
    {
        foreach ($element->getChildren() as $child) {
            $this->removeProhibitedTag($child);
        }

        return $element;
    }

    /**
     * Remove any element which is not present in whitelist.
     *
     * @param \Predmond\HtmlToAmp\ElementInterface $element Any body element's child.
     *
     * @return void
     */
    protected function removeProhibitedTag(ElementInterface $element)
    {
        if ($element->hasChildren()) {
            foreach ($element->getChildren() as $child) {
                $this->removeProhibitedTag($child);
            }
        }

        $tagName = $this->getTagName($element);

        //Since node name that is started with '#' such as '#text' is converted
        //into null, it should be skippped from removal.
        if (! is_null($tagName) && ! $this->spec->isAllowed($tagName)) {
            $element->remove();
        }
    }

    protected function getTagName($element)
    {
        if (strpos($element->getTagName(), '#') === false) {
            return $element->getTagName();
        }
    }
}