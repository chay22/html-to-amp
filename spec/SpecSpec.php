<?php

namespace spec\Predmond\HtmlToAmp;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PhpSpec\Exception\Example\StopOnFailureException;
use PhpSpec\Exception\Example\MatcherException;

class SpecSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Predmond\HtmlToAmp\Spec');
    }

    function it_should_provide_whitelisted_element()
    {
        $this->getWhitelist()->shouldHaveValue([
            'html', 'head', 'body', 'title', 'base',
            'link', 'meta', 'style', 'script', 'noscript',
            'article', 'section', 'nav', 'aside',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'header', 'footer', 'address',
        ]);
    }

    function it_should_not_provide_blacklisted_element()
    {
        $this->getWhitelist()->shouldNotHaveValue([
            'frame', 'frameset', 'object', 'iframe', 'param',
            'applet', 'embed', 'filter'
        ]);
    }

    function it_should_provide_element_scope()
    {
        $this->getRelation(false)->shouldHaveKeyWithValue([
            'head' => [
                'title', 'base', 'link', 'meta', 'style', 'script',
                'noscript',
            ],
            'svg' => 'g',
            'audio' => ['source', 'track']
        ]);
    }

    function it_should_provide_element_scope_returned_with_array_dot()
    {
        $this->getRelation()->shouldHaveValue([
            'video.source', 'audio.track', 'head.link', 'noscript.img',
            'form.label', 'form.select', 'form.textarea', 'form.input'
        ]);
    }

    function it_should_be_whitelisted()
    {
        $this->shouldBeWhitelisted('head');
        $this->shouldBeWhitelisted('body');
        $this->shouldBeWhitelisted('title');
        $this->shouldBeWhitelisted('a');
        $this->shouldBeWhitelisted('p');
        $this->shouldBeWhitelisted('span');
        $this->shouldBeWhitelisted('table');
        $this->shouldBeWhitelisted('thead');
        $this->shouldBeWhitelisted('tbody');
    }

    function it_should_be_allowed()
    {
        $this->shouldBeAllowed('meta');
        $this->shouldBeAllowed('script');
        $this->shouldBeAllowed('svg');
        $this->shouldBeAllowed('video');
        $this->shouldBeAllowed('audio');
        $this->shouldBeAllowed('em');
        $this->shouldBeAllowed('b');
        $this->shouldBeAllowed('i');
        $this->shouldBeAllowed('u');
        $this->shouldBeAllowed('s');
        $this->shouldBeAllowed('g');
    }

    function it_should_be_related()
    {
        $this->shouldBeRelated(['head' => 'title']);
        $this->shouldBeRelated(['video', 'source']);
        $this->shouldBeRelated('video', 'source');
        $this->shouldBeRelated('svg.symbol');
        $this->shouldBeRelated(['audio.track']);
    }

    function it_should_not_allow_to_check_relation_if_the_args_is_invalid()
    {
        $this->shouldThrow('\InvalidArgumentException')->during(
            'isRelated', [['svg'], 'g']
        );

        $this->shouldThrow('\InvalidArgumentException')->during(
            'isRelated', ['noscriptstyle']
        );

        $this->shouldThrow('\InvalidArgumentException')->during(
            'isRelated', [['formfieldset']]
        );
    }

    function getMatchers()
    {
        return [
            'haveKeyWithValue' => function ($subject, $array) {
                foreach ($array as $key => $values) {
                    if (! array_key_exists($key, $subject)) {
                        throw new StopOnFailureException(
                            "The key $key is not found."
                        );
                    }

                    if (is_array($values)) {
                        foreach ($values as $value) {
                            if (! in_array($value, $subject[$key])) {
                                throw new StopOnFailureException(
                                    "Couldn't find matches for value '$value' with key '$key'."
                                );
                            }
                        }
                    } else {
                        if (! in_array($values, $subject[$key])) {
                            throw new MatcherException(
                                "Couldn't find matches for value '$value' with key '$key'."
                            );
                        }
                    }
                }

                return true;
            },
            'haveValue' => function ($subject, $values) {
                if (is_array($values)) {
                    foreach ($values as $value) {
                        if (! in_array($value, $subject)) {
                            return false;
                        } else {
                            return true;
                        }    
                    }
                }

                return in_array($values, $subject);
            },
        ];
    }
}
