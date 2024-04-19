<?php
/**
 * Template Comments plugin for Craft CMS
 *
 * Adds a HTML comment to demarcate each Twig template that is included or extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c)  nystudio107
 */

namespace nystudio107\templatecomments\web\twig\tokenparsers;

use nystudio107\templatecomments\web\twig\nodes\CommentsNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
class CommentsTokenParser extends AbstractTokenParser
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getTag()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $nodes = [
            'templateName' => $this->parser->getExpressionParser()->parseExpression(),
        ];
        $stream->expect(Token::BLOCK_END_TYPE);
        $nodes['body'] = $this->parser->subparse([$this, 'decideCommentsEnd'], true);
        $stream->expect(Token::BLOCK_END_TYPE);

        return new CommentsNode($nodes, [], $lineno, $this->getTag());
    }


    /**
     * @param Token $token
     *
     * @return bool
     */
    public function decideCommentsEnd(Token $token): bool
    {
        return $token->test('endcomments');
    }
}
