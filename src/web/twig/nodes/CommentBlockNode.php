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
class CommentBlockNode extends \Twig\Node\BlockNode
{
    private $blockName;

    private array $excludeBlocks = ['attr'];

    public function __construct(string $name, \Twig\Node\Node $body, int $lineno, string $tag = null)
    {
        parent::__construct($name, $body, $lineno, $tag);
        $this->blockName = $name;
    }

    public function compile(\Twig\Compiler $compiler): void
    {
        $compiler
            ->addDebugInfo($this)
            ->write(sprintf("public function block_%s(\$context, array \$blocks = array())\n", $this->getAttribute('name')), "{\n")
            ->indent()
            ->write("\$macros = \$this->macros;\n")
        ;
        if (!\in_array($this->blockName, $this->excludeBlocks, false)) {
            $compiler
                ->write('$_blockTimer = microtime(true)')
                ->raw(";\n")
                ->write('$_blockName = ')
                ->write("'".$this->blockName."'")
                ->raw(";\n")
                ->write('echo PHP_EOL."<!-- >>> BLOCK BEGIN >>> ".$_blockName." -->".PHP_EOL')
                ->raw(";\n");
        }

        $compiler
            ->subcompile($this->getNode('body'))
            ->outdent()
            ;
        if (!\in_array($this->blockName, $this->excludeBlocks, false)) {
            $compiler
                ->write('echo PHP_EOL."<!-- ".number_format((microtime(true)-$_blockTimer)*1000,2)."ms <<< BLOCK END <<< ".$_blockName." -->".PHP_EOL')
                ->raw(";\n")
                ->write("unset(\$_blockName);\n");
        }

        $compiler
            ->write("}\n\n")
        ;
    }
}
