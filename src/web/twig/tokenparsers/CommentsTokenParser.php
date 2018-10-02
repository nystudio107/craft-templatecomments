<?php

namespace nystudio107\templatecomments\web\twig\tokenparsers;

use nystudio107\templatecomments\web\twig\nodes\CommentsNode;

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
