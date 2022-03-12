<?php
/**
 * Template Comments plugin for Craft CMS 3.x
 *
 * Adds a HTML comment to demarcate each Twig template that is included or extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\templatecomments\web\twig\tokenparsers;

use nystudio107\templatecomments\web\twig\nodes\CommentsNode;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
class CommentsTokenParser extends \Twig\TokenParser\AbstractTokenParser
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getTag(): string
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function parse(\Twig\Token $token): \nystudio107\templatecomments\web\twig\nodes\CommentsNode
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $nodes = [
            'templateName' => $this->parser->getExpressionParser()->parseExpression(),
        ];
        $stream->expect(\Twig\Token::BLOCK_END_TYPE);
        $nodes['body'] = $this->parser->subparse(fn(\Twig_Token $token): bool => $this->decideCommentsEnd($token), true);
        $stream->expect(\Twig\Token::BLOCK_END_TYPE);

        return new CommentsNode($nodes, [], $lineno, $this->getTag());
    }


    public function decideCommentsEnd(\Twig\Token $token): bool
    {
        return $token->test('endcomments');
    }
}
