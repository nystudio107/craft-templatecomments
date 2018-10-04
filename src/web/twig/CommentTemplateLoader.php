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

use Craft;
use craft\web\twig\TemplateLoader;
use craft\web\twig\TemplateLoaderException;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
class CommentTemplateLoader extends TemplateLoader
{
    /**
     * @inheritdoc
     */
    public function getSourceContext($name)
    {
        $template = $this->_resolveTemplate($name);

        if (!is_readable($template)) {
            throw new TemplateLoaderException($name, Craft::t('app', 'Tried to read the template at {path}, but could not. Check the permissions.', ['path' => $template]));
        }

        $escapedName = addslashes($name);
        $prefix = "{% comments '{$escapedName}' %}".PHP_EOL;
        $suffix = PHP_EOL."{% endcomments %}";

        return new \Twig_Source($prefix.file_get_contents($template).$suffix, $name, $template);
    }

    // Private Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    private function _resolveTemplate(string $name): string
    {
        $template = $this->view->resolveTemplate($name);

        if ($template !== false) {
            return $template;
        }

        throw new TemplateLoaderException($name, Craft::t('app', 'Unable to find the template “{template}”.', ['template' => $name]));
    }
}
