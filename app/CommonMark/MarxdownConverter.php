<?php

namespace App\CommonMark;

use Illuminate\Support\Str;
use League\CommonMark\Node\Node;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Environment\Environment;
use Torchlight\Commonmark\V2\TorchlightExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\DefaultAttributes\DefaultAttributesExtension;

class MarxdownConverter extends \League\CommonMark\MarkdownConverter
{
    public function __construct(array $config = [])
    {
        $environment = new Environment([
            'default_attributes' => [
                Heading::class => [
                    'id' => function (Heading $node) {
                        $text = $this->childrenToText($node);

                        return Str::slug($text);
                    },
                    'x-intersect' => function (Heading $node) {
                        $text = $this->childrenToText($node);

                        return "\$dispatch('toc.section.changed', `$text`)";
                    },
                ],
                Link::class => [
                    'rel' => function (Link $node) {
                        if (
                            // Is an external link.
                            ! str_contains($node->getUrl(), url('/')) &&
                            // And not an anchor.
                            ! Str::startsWith($node->getUrl(), '#')
                        ) {
                            return 'nofollow noopener noreferrer';
                        }
                    },
                    'target' => function (Link $node) {
                        if (
                            // Is an external link.
                            ! str_contains($node->getUrl(), url('/')) &&
                            // And not an anchor.
                            ! Str::startsWith($node->getUrl(), '#')
                        ) {
                            return '_blank';
                        }
                    },
                    '@click' => function (Link $node) {
                        // Is an affiliate link.
                        return str_contains($node->getUrl(), url('/recommends'))
                            ? "window.fathom?.trackGoal('LBJL4VHK', 0)"
                            : "window.fathom?.trackGoal('SMD2GKMN', 0)";
                    },
                ],
            ],
        ]);
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new DefaultAttributesExtension());
        $environment->addExtension(new DescriptionListExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new SmartPunctExtension());
        $environment->addExtension(new TableExtension());
        $environment->addExtension(new TorchlightExtension());

        parent::__construct($environment);
    }

    protected function childrenToText(Node $node) : string
    {
        $text = '';

        foreach ($node->children() as $child) {
            if ($child instanceof Text) {
                $text .= $child->getLiteral();
            } else {
                $text .= $this->childrenToText($child);
            }
        }

        return $text;
    }
}
