<?php

namespace spec\Predmond\HtmlToAmp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use League\Event\Emitter;
use League\Event\EmitterInterface;
use Predmond\HtmlToAmp\Environment;
use Predmond\HtmlToAmp\Converter\ConverterInterface;

class AmpConverterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Predmond\HtmlToAmp\AmpConverter');
    }

    public function it_converts_spaces_to_an_empty_string()
    {
        $this->convert('   ')->shouldReturn('');
    }

    public function it_converts_html_to_amp()
    {
        $this->convert(implode('', [
            '<div class="class">',
            '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>',
            '<img src="foo.jpg">',
            '<p>Aut blanditiis exercitationem in, incidunt odit optio.</p>',
            '</div>'
        ]))->shouldContain(implode('', [
            '<amp-img src="foo.jpg"></amp-img>'
        ]));
    }

    public function it_should_remove_prohibited_tags()
    {
        $html = <<<HTML
        <applet code="game.class" align="left" archive="game.zip" height="250" width="350">
            <param name="difficulty" value="easy">
            <b>Sorry, you need Java to play this game.</b>
        </applet>

        <div id="test">
            Hello! Pick up the phone!
        </div>
HTML;
        $this->convert($html)->shouldNotContain('applet');
        $this->convert($html)->shouldContain('div');
    }

    public function it_should_remove_prohibited_descendants()
    {
        $html = <<<HTML
        <svg width="100%" height="100%" viewBox="0 0 80 40"
             xmlns="http://www.w3.org/2000/svg">

            <stop offset="5%" stop-color="#F60" />
            <rect fill="url(#MyGradient)" stroke="black" stroke-width="1"  
                x="10" y="10" width="60" height="20"/>
        </svg>
HTML;

        $this->convert($html)->shouldNotContain('stop');
        $this->convert($html)->shouldContain('rect');
    }

    public function it_can_add_a_converter(Environment $env, Emitter $event, ConverterInterface $converter)
    {
        $converter->getSubscribedEvents()
                ->shouldBeCalled()
                ->willReturn([
                    'head' => 'blowTheApplicationOver',
        ]);

        $this->addConverter($converter);
    }
}
