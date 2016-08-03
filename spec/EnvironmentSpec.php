<?php

namespace spec\Predmond\HtmlToAmp;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;

use League\Event\Emitter;
use League\Event\EmitterInterface;
use Predmond\HtmlToAmp\Converter\ConverterInterface;

class EnvironmentSpec extends ObjectBehavior
{
    public function let(Emitter $emitter)
    {
        $this->beConstructedWith($emitter);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Predmond\HtmlToAmp\Environment');
    }

    public function it_can_add_a_listener(
        ConverterInterface $converter,
        Emitter $emitter
    ) {
        $pHigh = EmitterInterface::P_HIGH;
        $pNormal = EmitterInterface::P_NORMAL;
        $pLow = EmitterInterface::P_LOW;

        $converter
            ->getSubscribedEvents()->shouldBeCalled()
            ->willReturn([
                'img' => 'handleImg',
                'foo' => ['handleFoo', $pHigh],
                'bar' => ['handleBar', $pLow],
                // Bad handlers to check the automatic prepending of "convert."
                'fizz' => ['badFizzHandler'],
                'buzz' => ['badBuzzHandler'],
            ]);

        $emitter
            ->addListener('amp.img', [$converter, 'handleImg'], $pNormal)
            ->shouldBeCalled();

        $emitter
            ->addListener('amp.foo', [$converter, 'handleFoo'], $pHigh)
            ->shouldBeCalled();

        $emitter
            ->addListener('amp.bar', [$converter, 'handleBar'], $pLow)
            ->shouldBeCalled();

        $emitter
            ->addListener(
                'amp.fizz',
                [$converter, 'badFizzHandler'], $pNormal
            )
            ->shouldBeCalled();

        $emitter
            ->addListener(
                'amp.buzz',
                [$converter, 'badBuzzHandler'], $pNormal
            )
            ->shouldBeCalled();

        $this->addListener($converter)->shouldReturn($this);
    }

    public function it_returns_the_event_emitter()
    {
        $this->getEventEmitter()->shouldReturnAnInstanceOf(Emitter::class);
    }
}
