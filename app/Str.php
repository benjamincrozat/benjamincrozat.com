<?php

namespace App;

use League\CommonMark\Node\Node;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Embed\EmbedExtension;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Embed\Bridge\OscaroteroEmbedAdapter;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;

class Str extends \Illuminate\Support\Str
{
    public static function markdown($string, array $options = []) : string
    {
        $options = array_merge([
            'default_attributes' => [
                Heading::class => [
                    'id' => fn (Heading $heading) : string => Str::slug(
                        static::childrenToText($heading)
                    ),
                ],
            ],
            'embed' => [
                'adapter' => new OscaroteroEmbedAdapter,
                'allowed_domains' => ['twitter.com', 'youtube.com'],
                'fallback' => 'link',
            ],
            'external_link' => [
                'internal_hosts' => preg_replace('/https?:\/\//', '', config('app.url')),
                'open_in_new_window' => true,
                'nofollow' => 'external',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
        ], $options);

        $environment = (new Environment($options))
            // This extension comes from the container so I can swap
            // it at runtime when testing. Because it's quite slow.
            ->addExtension(app(HighlightCodeExtension::class))
            ->addExtension(new AttributesExtension)
            ->addExtension(new CommonMarkCoreExtension)
            ->addExtension(new DefaultAttributesExtension)
            // Same thing there.
            ->addExtension(app(EmbedExtension::class))
            ->addExtension(new ExternalLinkExtension)
            ->addExtension(new GithubFlavoredMarkdownExtension)
            ->addExtension(new SmartPunctExtension)
            // This new renderer adds an anchor link, just like in Laravel's documentation.
            ->addRenderer(Heading::class, new HeadingRenderer);

        return (string) (new MarkdownConverter($environment))->convert($string);
    }

    /**
     * This is a recursive method that will traverse the given
     * node and all of its children to get the text content.
     */
    protected static function childrenToText(Node $node) : string
    {
        $text = '';

        foreach ($node->children() as $child) {
            $text .= $child instanceof Text
                ? $child->getLiteral()
                : static::childrenToText($child);
        }

        return $text;
    }
}
