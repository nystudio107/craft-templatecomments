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

namespace nystudio107\templatecomments\web\twig\tokenparsers;

use nystudio107\templatecomments\TemplateComments;
use nystudio107\templatecomments\web\twig\nodes\CommentBlockNode;
use Twig\Error\SyntaxError;
use Twig\Node\BlockNode;
use Twig\Node\BlockReferenceNode;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Marks a section of a template as being reusable.
 *
 * <pre>
 *  {% block head %}
 *    <link rel="stylesheet" href="style.css" />
 *    <title>{% block title %}{% endblock %} - My Webpage</title>
 *  {% endblock %}
 * </pre>
 */
final class CommentBlockTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): BlockReferenceNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(/* Twig_Token::NAME_TYPE */ 5)->getValue();
        if ($this->parser->hasBlock($name)) {
            throw new SyntaxError(sprintf("The block '%s' has already been defined line %d.", $name, $this->parser->getBlock($name)->getTemplateLine()), $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }

        // Exclude certain blocks from being CommentBlockNodes
        $blockClass = CommentBlockNode::class;
        $settings = TemplateComments::$settings;
        foreach ($settings->excludeBlocksThatContain as $excludeString) {
            if (stripos($name, $excludeString) !== false) {
                $blockClass = BlockNode::class;
            }
        }

        $this->parser->setBlock($name, $block = new $blockClass($name, new Node(array()), $lineno));
        $this->parser->pushLocalScope();
        $this->parser->pushBlockStack($name);

        if ($stream->nextIf(/* Twig_Token::BLOCK_END_TYPE */ 3) !== null) {
            $body = $this->parser->subparse(fn(Token $token): bool => $this->decideBlockEnd($token), true);
            if (($token = $stream->nextIf(/* Twig_Token::NAME_TYPE */ 5)) !== null) {
                $value = $token->getValue();

                if ($value !== $name) {
                    throw new SyntaxError(sprintf('Expected endblock for block "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
                }
            }
        } else {
            $body = new Node(array(
                new PrintNode($this->parser->getExpressionParser()->parseExpression(), $lineno),
            ));
        }

        $stream->expect(/* Twig_Token::BLOCK_END_TYPE */ 3);

        $block->setNode('body', $body);
        $this->parser->popBlockStack();
        $this->parser->popLocalScope();

        return new BlockReferenceNode($name, $lineno, $this->getTag());
    }

    public function decideBlockEnd(Token $token): bool
    {
        return $token->test('endblock');
    }

    public function getTag(): string
    {
        return 'block';
    }
}
