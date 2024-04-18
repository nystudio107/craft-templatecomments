<?php
/**
 * Template Comments plugin for Craft CMS
 *
 * Adds a HTML comment to demarcate each Twig template that is included or extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c)  nystudio107
 */

namespace nystudio107\templatecomments\web\twig;

use nystudio107\templatecomments\TemplateComments;
use nystudio107\templatecomments\web\twig\tokenparsers\CommentBlockTokenParser;
use nystudio107\templatecomments\web\twig\tokenparsers\CommentsTokenParser;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

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
    public function getFunctions()
    {
        return [
            new TwigFunction('source', [$this, 'originalSource'], ['needs_environment' => true, 'is_safe' => ['all']]),
        ];
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

    /**
     * Returns a template content without rendering it.
     *
     * @param Environment $env The Twig environment
     * @param string $name The template name
     * @param bool $ignoreMissing Whether to ignore missing templates or not
     *
     * @return string The template source
     */
    public function originalSource(Environment $env, string $name, bool $ignoreMissing = false): string
    {
        $loader = TemplateComments::$originalTwigLoader;
        try {
            return $loader->getSourceContext($name)->getCode();
        } catch (LoaderError $e) {
            if (!$ignoreMissing) {
                throw $e;
            }
        }

        return '';
    }
}
