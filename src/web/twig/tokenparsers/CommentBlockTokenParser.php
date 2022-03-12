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

use nystudio107\templatecomments\web\twig\nodes\CommentBlockNode;

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
final class CommentBlockTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    public function parse(\Twig\Token $token): \Twig\Node\BlockReferenceNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(/* Twig_Token::NAME_TYPE */ 5)->getValue();
        if ($this->parser->hasBlock($name)) {
            throw new \Twig\Error\SyntaxError(sprintf("The block '%s' has already been defined line %d.", $name, $this->parser->getBlock($name)->getTemplateLine()), $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }

        $this->parser->setBlock($name, $block = new CommentBlockNode($name, new \Twig\Node\Node(array()), $lineno));
        $this->parser->pushLocalScope();
        $this->parser->pushBlockStack($name);

        if ($stream->nextIf(/* Twig_Token::BLOCK_END_TYPE */ 3) !== null) {
            $body = $this->parser->subparse(fn(\Twig_Token $token): bool => $this->decideBlockEnd($token), true);
            if (($token = $stream->nextIf(/* Twig_Token::NAME_TYPE */ 5)) !== null) {
                $value = $token->getValue();

                if ($value !== $name) {
                    throw new \Twig\Error\SyntaxError(sprintf('Expected endblock for block "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
                }
            }
        } else {
            $body = new \Twig\Node\Node(array(
                new \Twig\Node\PrintNode($this->parser->getExpressionParser()->parseExpression(), $lineno),
            ));
        }

        $stream->expect(/* Twig_Token::BLOCK_END_TYPE */ 3);

        $block->setNode('body', $body);
        $this->parser->popBlockStack();
        $this->parser->popLocalScope();

        return new \Twig\Node\BlockReferenceNode($name, $lineno, $this->getTag());
    }

    public function decideBlockEnd(\Twig\Token $token): bool
    {
        return $token->test('endblock');
    }

    public function getTag(): string
    {
        return 'block';
    }
}
