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

use Twig\Compiler;
use Twig\Node\BlockNode;
use Twig\Node\Node;
use function in_array;

/**
 * Represents a block node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CommentBlockNode extends BlockNode
{
    private string $blockName;

    private array $excludeBlocks = ['attr'];

    public function __construct(string $name, Node $body, int $lineno, string $tag = null)
    {
        parent::__construct($name, $body, $lineno, $tag);
        $this->blockName = $name;
    }

    public function compile(Compiler $compiler): void
    {
        $compiler
            ->addDebugInfo($this)
            ->write(sprintf("public function block_%s(\$context, array \$blocks = array())\n", $this->getAttribute('name')), "{\n")
            ->indent()
            ->write("\$macros = \$this->macros;\n");
        if (!in_array($this->blockName, $this->excludeBlocks, false)) {
            $compiler
                ->write('$_blockTimer = microtime(true)')
                ->raw(";\n")
                ->write('$_templateName = ')
                ->write("'" . $this->getTemplateName() . "'")
                ->raw(";\n")
                ->write('$_blockName = ')
                ->write("'" . $this->blockName . "'")
                ->raw(";\n")
                ->write('echo PHP_EOL."<!-- >>> BLOCK BEGIN >>> ".$_blockName." FROM ".$_templateName." -->".PHP_EOL')
                ->raw(";\n");
        }

        $compiler
            ->subcompile($this->getNode('body'))
            ->outdent();
        if (!in_array($this->blockName, $this->excludeBlocks, false)) {
            $compiler
                ->write('echo PHP_EOL."<!-- <<< BLOCK END <<< ".$_blockName." FROM ".$_templateName." TIME ".number_format((microtime(true)-$_blockTimer)*1000,2)."ms -->".PHP_EOL')
                ->raw(";\n")
                ->write("unset(\$_blockTimer);\n")
                ->write("unset(\$_blockName);\n")
                ->write("unset(\$_templateName);\n");
        }

        $compiler
            ->write("}\n\n");
    }
}
