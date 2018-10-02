<?php

namespace nystudio107\templatecomments\web\twig;

use Craft;
use craft\web\twig\TemplateLoader;
use craft\web\twig\TemplateLoaderException;

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
     * Returns the path to a given template, or throws a TemplateLoaderException.
     *
     * @param string $name
     * @return string
     * @throws TemplateLoaderException if the template doesn’t exist
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
