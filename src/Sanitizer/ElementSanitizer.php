<?php

namespace Predmond\HtmlToAmp\Sanitizer;

use League\Event\EventInterface;
use Predmond\HtmlToAmp\ElementInterface;

class ElementSanitizer extends Sanitizer
{
    /**
     * {@inheritdoc}
     */
    protected $events = [
        'html' => 'sanitize',
    ];

    /**
     * Sanitize every element's descendant from prohibited elements.
     *
     * @param EventInterface   $event
     * @param ElementInterface $element
     *
     * @return ElementInterface
     */
    public function sanitize(EventInterface $event, ElementInterface $element)
    {
        if (! $element->hasChildren()) {
            return false;
        }

        foreach ($element->getChildren() as $child) {
            $this->removeProhibitedTag($child);
        }

        return $element;
    }

    /**
     * Remove any element which is not present in specification list.
     *
     * @see  \Predmond\HtmlToAmp\Spec::$element
     * 
     * @param ElementInterface $element
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

        if (! is_null($tagName) && !$this->spec->isAllowed($tagName)) {
            $element->remove();
        }

        return $element;
    }

    /**
     * Return a tag name that has no `#`.
     *
     * This used to exclude any node such as `#text`
     *
     * @param \DOMNode $element
     *
     * @return string|null
     */
    protected function getTagName($element)
    {
        if (strpos($element->getTagName(), '#') === false) {
            return $element->getTagName();
        }
    }
}
