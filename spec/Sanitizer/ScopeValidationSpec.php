<?php

namespace spec\Predmond\HtmlToAmp\Sanitizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use League\Event\EventInterface;
use Predmond\HtmlToAmp\ElementInterface;

class ScopeValidationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Predmond\HtmlToAmp\Sanitizer\ScopeValidation');
        $this->shouldHaveType('Predmond\HtmlToAmp\Sanitizer\Sanitizer');
        $this->shouldHaveType('Predmond\HtmlToAmp\Converter\ConverterInterface');
    }

    function it_removes_element_that_is_in_prohibited_scope(
        EventInterface $event,
        ElementInterface $element,
        ElementInterface $parent
    ) {
        $element->getTagName()->shouldBeCalled()->willReturn('select');

        $element->getParent()->shouldBeCalled()->willReturn($parent);

        $parent->getTagName()->shouldBeCalled()->willReturn('body');

        $element->remove()->shouldBeCalled();

        $this->handleElementScope($event, $element);
    }

    function it_should_ignore_element_that_is_not_listed_in_spec(
        EventInterface $event,
        ElementInterface $element,
        ElementInterface $parent
    ) {
        $element->getTagName()->shouldBeCalled()->willReturn('a');

        $element->getParent()->shouldBeCalled()->willReturn($parent);

        $parent->getTagName()->shouldBeCalled()->willReturn('body');

        $element->remove()->shouldNotBeCalled();

        $this->handleElementScope($event, $element);
    }

    function it_should_skip_element_with_no_parent(
        EventInterface $event,
        ElementInterface $element,
        ElementInterface $parent
    ) {
        $element->getTagName()->shouldBeCalled()->willReturn('html');

        $element->getParent()->shouldBeCalled()->willReturn(null);

        $element->remove()->shouldNotBeCalled();

        $this->handleElementScope($event, $element);
    }

    function it_has_subscribed_events()
    {
        $this->getSubscribedEvents()->shouldReturn([
            '*' => ['handleElementScope', 50]
        ]);
    }
}
