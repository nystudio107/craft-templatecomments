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

use nystudio107\templatecomments\web\twig\tokenparsers\CommentBlockTokenParser;
use Twig\Extension\AbstractExtension;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
class CommentsTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'template-comments';
    }

    /**
     * @inheritdoc
     */
    public function getTokenParsers(): array
    {
        return [
            new CommentBlockTokenParser(),
        ];
    }
}
