<?php

namespace Predmond\HtmlToAmp;

class Spec
{
    protected $element = [
        'html', 'head', 'body',

        //head
        'title', 'base', 'link', 'meta', 'style',
        'script', 'noscript',

        //section
        'article', 'section', 'nav', 'aside',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'header', 'footer', 'address',

        //grouping content
        'p', 'hr', 'pre', 'blockquote', 'ol', 'ul',
        'li', 'dl', 'dt', 'dd', 'figure', 'figcaption',
        'div', 'main',

        //text-level semantics
        'a', 'em', 'strong', 'small', 's', 'cite', 'q',
        'dfn', 'abbr', 'data', 'time', 'code', 'var',
        'samp', 'kbd', 'sub', 'sup', 'i', 'b', 'u', 'mark',
        'ruby', 'rb', 'rt', 'rtc', 'rp', 'bdi', 'bdo',
        'span', 'br', 'wbr',

        //edits
        'ins', 'del',

        //embedded content
        'img', 'video', 'audio', 'source', 'track',

        //svg
        'g', 'glyph', 'glyphRef', 'marker', 'path',
        'svg', 'view', 'circle', 'line', 'polygon',
        'polyline', 'rect', 'text', 'textPath',
        'tref', 'tspan', 'clipPath', 'filter', 'hkern',
        'linearGradient', 'mask', 'pattern', 'radialGradient',
        'stop', 'vkern', 'defs', 'symbol', 'use',
        'foreignObject', 'desc', 'title',

        //tabular data
        'table', 'caption', 'colgroup', 'col', 'tbody',
        'thead', 'tfoot', 'tr', 'td', 'th',

        //forms
        'form', 'label', 'input', 'button', 'select',
        'option', 'textarea', 'fieldset', 'legend',

        //scripting
        'script', 'noscript',

        //template
        'template',

        //non-conforming features
        'acronym', 'big', 'center', 'dir', 'hgroup',
        'listing', 'multicol', 'nextid', 'nobr', 'spacer',
        'strike', 'tt', 'xmp', 'o:p',

        //teh amp
        'amp-img', 'amp-pixel', 'amp-video',

        'amp-accordion',
        'amp-ad',
        'amp-embed',
        'amp-analytics',
        'amp-anim',
        'amp-audio',
        'amp-brid-player',
        'amp-brightcove',
        'amp-carousel',
        'amp-dailymotion',
        'amp-experiment',
        'amp-facebook',
        'amp-fit-text',
        'amp-font',
        'amp-fx-flying-carpet',
        'amp-google-vrview-image',
        'amp-iframe',
        'amp-image-lightbox',
        'amp-instagram',
        'amp-install-serviceworker',
        'amp-jwplayer',
        'amp-kaltura-player',
        'amp-lightbox',
        'amp-list',
        'amp-live-list',
        'amp-o2-player',
        'amp-pinterest',
        'amp-reach-player',
        'amp-sidebar',
        'amp-social-share',
        'amp-soundcloud',
        'amp-springboard-player',
        'amp-sticky-ad',
        'amp-twitter',
        'amp-user-notification',
        'amp-vimeo',
        'amp-vine',
        'amp-viz-vega',
        'amp-youtube',
    ];

    protected $relation = [
        'head' => [
            'title', 'base', 'link', 'meta', 'style', 'script',
            'noscript',
        ],
        'noscript' => [
            'style', 'img', 'video', 'audio',
        ],

        //resource
        'video' => [
            'source', 'track',
        ],
        'audio' => [
            'source', 'track',
        ],
        'amp-video' => [
            'source', 'track',
        ],

        //svg
        'svg' => [
            'g', 'glyph', 'glyphRef', 'marker', 'path',
            'view', 'circle', 'line', 'polygon',
            'polyline', 'rect', 'text', 'textPath',
            'tref', 'tspan', 'clipPath', 'filter', 'hkern',
            'vkern', 'defs', 'symbol', 'use',
            'foreignObject', 'desc', 'title', 'linearGradient',
            'radialGradient',
        ],

        'defs' => [
            //shapes
            'circle', 'line', 'polygon', 'polyline', 'rect',
            //descriptive elements
            'title', 'desc',
            //structural elements
            'defs', 'g', 'symbol', 'use',
            //gradient elements
            'linearGradient', 'radialGradient',

            'clipPath', 'foreignObject', 'marker', 'text',
        ],

        'text' => [
            'tspan', 'tref', 'textPath', 'title', 'desc',
        ],

        'tref' => [
            'title', 'desc',
        ],

        'tspan' => [
            'tspan', 'tref', 'textPath', 'title', 'desc',
        ],

        'g' => [
            'circle', 'line', 'polygon', 'polyline', 'rect',
            'title', 'desc',
            'defs', 'g', 'symbol', 'use',
            'linearGradient', 'radialGradient',
            'clipPath', 'foreignObject', 'marker', 'text',
        ],

        'glyph' => [
            'circle', 'line', 'polygon', 'polyline', 'rect',
            'title', 'desc',
            'defs', 'g', 'symbol', 'use',
            'linearGradient', 'radialGradient',
            'clipPath', 'foreignObject', 'marker', 'text',
        ],

        'circle' => [
            'title', 'desc',
        ],

        'line' => [
            'title', 'desc',
        ],

        'polygon' => [
            'title', 'desc',
        ],

        'polyline' => [
            'title', 'desc',
        ],

        'rect' => [
            'title', 'desc',
        ],

        'marker' => [
            'circle', 'line', 'polygon', 'polyline', 'rect',
            'title', 'desc',
            'defs', 'g', 'symbol', 'use',
            'linearGradient', 'radialGradient',
            'clipPath', 'foreignObject', 'marker', 'text',
        ],

        'path' => [
            'title', 'desc',
        ],

        'use' => [
            'title', 'desc',
        ],

        'clipPath' => [
            'circle', 'line', 'polygon', 'polyline', 'rect',
            'title', 'desc', 'use',
        ],

        'linearGradient' => [
            'stop', 'title', 'desc',
        ],

        'radialGradient' => [
            'stop', 'title', 'desc',
        ],

        //form
        'form' => [
            'label', 'input', 'button', 'select',
            'option', 'textarea', 'fieldset', 'legend',
        ],
    ];

    public function getWhitelist()
    {
        return array_unique($this->element);
    }

    public function getRelation($dot = true)
    {
        if ($dot) {
            return $this->toDot($this->relation);
        }

        return $this->relation;
    }

    public function isWhitelisted($element)
    {
        return in_array($element, $this->getWhitelist());
    }

    public function isAllowed($element)
    {
        return $this->isWhitelisted($element);
    }

    public function isRelated($element, $parent = null)
    {
        $element = is_array($element) ?
               $this->toDot($element) : $element;

        $element = ! is_null($parent) ? $parent.'.'.$element : $element;

        return in_array(
            $element, $this->getRelation()
        );
    }

    protected function toDot($array)
    {
        $results = [];

        foreach ($array as $key => $values) {
            if (is_array($values)) {
                foreach ($values as $value) {
                    $results[] = $key.'.'.$value;
                }
            } else {
                $results[] = $key.'.'.$value;
            }
        }

        return $results;
    }
}
