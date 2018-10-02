<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nystudio107\templatecomments\web\twig\nodes;

/**
 * Represents a block node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CommentBlockNode extends \Twig_Node_Block
{
    private $blockName;

    public function __construct($name, \Twig_Node $body, $lineno, $tag = null)
    {
        parent::__construct($name, $body, $lineno, $tag);
        $this->blockName = $name;
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write(sprintf("public function block_%s(\$context, array \$blocks = array())\n", $this->getAttribute('name')), "{\n")
            ->indent()
            ->write('$_blockTimer = microtime(true)')
            ->raw(";\n")
            ->write('$_blockName = ')
            ->write("'".$this->blockName."'")
            ->raw(";\n")
            ->write('echo PHP_EOL."<!-- >>> BLOCK BEGIN >>> ".$_blockName." -->".PHP_EOL')
            ->raw(";\n")
        ;

        $compiler
            ->subcompile($this->getNode('body'))
            ->outdent()
            ->raw(";\n")
            ->write('echo PHP_EOL."<!-- ".number_format((microtime(true)-$_blockTimer)*1000,2)."ms <<< BLOCK END <<< ".$_blockName." -->".PHP_EOL')
            ->raw(";\n")
            ->write("unset(\$_blockName);\n")
            ->write("}\n\n")
        ;
    }
}
