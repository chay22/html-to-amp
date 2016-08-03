<?php

namespace spec\Predmond\HtmlToAmp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use League\Event\Emitter;
use League\Event\EmitterInterface;
use Predmond\HtmlToAmp\Converter\ConverterInterface;
use Predmond\HtmlToAmp\Environment;
use Predmond\HtmlToAmp\Element;

class AmpConverterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Predmond\HtmlToAmp\AmpConverter');
    }

    public function it_should_not_allow_to_convert_invalid_html_string()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringConvert(' ');
    }

    function it_converts_html_to_amp()
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

    function it_can_add_a_converter(ConverterInterface $converter, Environment $env)
    {
        $pNormal = EmitterInterface::P_NORMAL;

        $converter->getSubscribedEvents()
                  ->shouldBeCalled()
                  ->willReturn([
                        'head' => 'handleHeadElement',
                        '*' => ['blowTheApplicationOver'],
        ]);

        $env->addListener($converter, $pNormal)->shouldBeCalled();

        $this->addConverter($converter)->shouldHaveType(
            'Predmond\HtmlToAmp\Environment'
        );


    }

    function it_should_remove_prohibited_tags(Element $element)
    {
        $html = <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="canonical" href="self.html" />
</head>
<body>
    <applet code="game.class" align="left" archive="game.zip" height="250" width="350">
      <param name="difficulty" value="easy">
      <b>Sorry, you need Java to play this game.</b>
    </applet>

    <div id="test">Test</div>

    <frameset cols="50%,50%">
      <frame src="https://developer.mozilla.org/en/HTML/Element/frameset" />
      <frame src="https://developer.mozilla.org/en/HTML/Element/frame" />
    </frameset>

    <svg width="120" height="120" 
         viewPort="0 0 120 120" version="1.1"
         xmlns="http://www.w3.org/2000/svg">
        
        <rect x="10" y="10" width="100" height="100">
            <animate attributeType="XML"
                     attributeName="x"
                     from="-100" to="120"
                     dur="10s"
                     repeatCount="indefinite"/>
        </rect>
    </svg>

    <object data="move.swf" type="application/x-shockwave-flash">
      <param name="foo" value="bar">
    </object>
  </body>
</html>
HTML;

        $return = <<<HTML
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="canonical" href="self.html" />
</head>
<body>
    <div id="test">Test</div>

    <svg width="120" height="120" 
         viewPort="0 0 120 120" version="1.1"
         xmlns="http://www.w3.org/2000/svg">
        
        <rect x="10" y="10" width="100" height="100">
        </rect>
    </svg>
  </body>
</html>
HTML;
        $element->shouldBeCalled();

        $this->convert($html)->shouldReturn($return);
    }
}
