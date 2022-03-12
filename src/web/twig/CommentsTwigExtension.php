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

use Craft;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
class CommentsTwigExtension extends \Twig\Extension\AbstractExtension
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
    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction('source', fn(\Twig_Environment $env, string $name, bool $ignoreMissing = false): string => $this->originalSource($env, $name, $ignoreMissing), ['needs_environment' => true, 'is_safe' => ['all']]),
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
     * @param string           $name          The template name
     * @param bool             $ignoreMissing Whether to ignore missing templates or not
     * @return string The template source
     */
    function originalSource(\Twig\Environment $env, string $name, bool $ignoreMissing = false)
    {
        $loader = TemplateComments::$originalTwigLoader;
        try {
            return $loader->getSourceContext($name)->getCode();
        } catch (\Twig\Error\LoaderError $twigErrorLoader) {
            if (!$ignoreMissing) {
                throw $twigErrorLoader;
            }
        }
    }
}
