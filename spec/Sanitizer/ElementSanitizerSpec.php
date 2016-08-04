<?php

namespace spec\Predmond\HtmlToAmp\Sanitizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use League\Event\EventInterface;
use Predmond\HtmlToAmp\ElementInterface;

class ElementSanitizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Predmond\HtmlToAmp\Sanitizer\ElementSanitizer');
        $this->shouldHaveType('Predmond\HtmlToAmp\Sanitizer\Sanitizer');
        $this->shouldHaveType('Predmond\HtmlToAmp\Converter\ConverterInterface');
    }

    function it_sanitizes_child_elements_from_prohibited_tags(
        EventInterface $event,
        ElementInterface $element,
        ElementInterface $div,
        ElementInterface $frameset
    ) {

        $element->hasChildren()->shouldBeCalled()->willReturn(true);
        $element->getChildren()->shouldBeCalled()->willReturn([$div, $frameset]);

        $div->hasChildren()->shouldBeCalled()->willReturn(false);
        $div->getTagName()->shouldBeCalled()->willReturn('div');
        $div->remove()->shouldNotBeCalled();

        $frameset->hasChildren()->shouldBeCalled()->willReturn(false);
        $frameset->getTagName()->shouldBeCalled()->willReturn('frameset');
        $frameset->remove()->shouldBeCalled();

        $this->sanitize($event, $element);
    }

    function it_should_sanitize_prohibited_child_of_elements_child(
        EventInterface $event,
        ElementInterface $element,
        ElementInterface $div,
        ElementInterface $object
    ) {
        $element->hasChildren()->shouldBeCalled()->willReturn(true);
        $element->getChildren()->shouldBeCalled()->willReturn([$div, $object]);

        $div->hasChildren()->shouldBeCalled()->willReturn(true);
        $div->getChildren()->shouldBeCalled()->willReturn([$object]);

        $object->hasChildren()->shouldBeCalled()->willReturn(false);
        $object->getTagName()->shouldBeCalled()->willReturn('object');
        $object->remove()->shouldBeCalled();

        $div->getTagName()->shouldBeCalled()->willReturn('div');
        $div->remove()->shouldNotBeCalled();

        $this->sanitize($event, $element);
    }

    function it_should_skip_element_that_has_no_child(
        EventInterface $event,
        ElementInterface $element
    ) {
        $element->hasChildren()->shouldBeCalled()->willReturn(false);
        $element->getChildren()->shouldNotBeCalled();
        $element->remove()->shouldNotBeCalled();

        $this->sanitize($event, $element);
    }

    function it_should_skip_element_that_has_a_should_skipped_node_type(
        EventInterface $event,
        ElementInterface $element,
        ElementInterface $text
    ) {
        $element->hasChildren()->shouldBeCalled()->willReturn(true);
        $element->getChildren()->shouldBeCalled()->willReturn([$text]);

        $text->hasChildren()->shouldBeCalled()->willReturn(false);
        $text->getTagName()->shouldBeCalled()->willReturn('#text');
        $text->remove()->shouldNotBeCalled();

        $this->sanitize($event, $element);
    }

    function it_has_subscribed_events()
    {
        $this->getSubscribedEvents()->shouldReturn([
            'html' => 'sanitize'
        ]);
    }
}
