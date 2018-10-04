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
class CommentsTokenParser extends \Twig_TokenParser
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
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $nodes = [
            'templateName' => $this->parser->getExpressionParser()->parseExpression(),
        ];
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        $nodes['body'] = $this->parser->subparse([$this, 'decideCommentsEnd'], true);
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new CommentsNode($nodes, [], $lineno, $this->getTag());
    }


    /**
     * @param \Twig_Token $token
     *
     * @return bool
     */
    public function decideCommentsEnd(\Twig_Token $token): bool
    {
        return $token->test('endcomments');
    }
}
