<?php
/**
 * Template Comments plugin for Craft CMS 3.x
 *
 * Adds a HTML comment to demarcate each Twig template that is included or extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\templatecomments\web\twig;

use nystudio107\templatecomments\TemplateComments;
use nystudio107\templatecomments\web\twig\tokenparsers\CommentsTokenParser;
use nystudio107\templatecomments\web\twig\tokenparsers\CommentBlockTokenParser;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
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
