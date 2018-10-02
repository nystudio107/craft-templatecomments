<?php

namespace nystudio107\templatecomments\web\twig;

use nystudio107\templatecomments\TemplateComments;
use nystudio107\templatecomments\web\twig\tokenparsers\CommentsTokenParser;
use nystudio107\templatecomments\web\twig\tokenparsers\CommentBlockTokenParser;

class CommentsTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'template-comments';
    }

    /**
     * @inheritdoc
     */
    public function getTokenParsers(): array
    {
        $parsers = [];
        if (TemplateComments::$settings->templateCommentsEnabled) {
            $parsers[] = new CommentsTokenParser();
        }
        if (TemplateComments::$settings->blockCommentsEnabled) {
            $parsers[] = new CommentBlockTokenParser();
        }

        return $parsers;
    }
}
