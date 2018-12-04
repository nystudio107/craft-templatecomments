<?php
/**
 * Template Comments plugin for Craft CMS 3.x
 *
 * Adds a HTML comment to demarcate each Twig template that is included or
 * extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\templatecomments\web\twig\nodes;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
class CommentsNode extends \Twig_Node
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('$_templateTimer = microtime(true)')
            ->raw(";\n")
            ->write('$_templateName = ')
            ->subcompile($this->getNode('templateName'))
            ->raw(";\n")
            ->write('echo PHP_EOL."<!-- >>> TEMPLATE BEGIN >>> ".$_templateName." -->".PHP_EOL')
            ->raw(";\n")
        ;
        // Make sure there is a body node
        if (!empty($this->nodes['body'])) {
            $compiler
                ->indent()
                ->subcompile($this->getNode('body'))
                ->outdent()
            ;
        }
        $compiler
            ->write('echo PHP_EOL."<!-- ".number_format((microtime(true)-$_templateTimer)*1000,2)."ms <<< TEMPLATE END <<< ".$_templateName." -->".PHP_EOL')
            ->raw(";\n")
            ->write("unset(\$_templateName);\n")
            ->write("unset(\$_templateTimer);\n")
        ;
    }
}
