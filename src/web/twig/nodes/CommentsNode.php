<?php

namespace nystudio107\templatecomments\web\twig\nodes;

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
            ->indent()
            ->subcompile($this->getNode('body'))
            ->outdent()
            ->write('echo PHP_EOL."<!-- ".number_format((microtime(true)-$_templateTimer)*1000,2)."ms <<< TEMPLATE END <<< ".$_templateName." -->".PHP_EOL')
            ->raw(";\n")
            ->write("unset(\$_templateName);\n")
            ->write("unset(\$_templateTimer);\n")
        ;
    }
}
