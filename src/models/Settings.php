<?php
/**
 * Template Comments plugin for Craft CMS 3.x
 *
 * Adds a HTML comment to demarcate each Twig template that is included or extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\templatecomments\models;

use craft\base\Model;
use craft\validators\ArrayValidator;

/**
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var bool Whether comments should be generated for site templates
     */
    public bool $siteTemplateComments = true;

    /**
     * @var bool Whether comments should be generated for Control Panel templates
     */
    public bool $cpTemplateComments = false;

    /**
     * @var bool Whether to generate comments only when `devMode` is on
     */
    public bool $onlyCommentsInDevMode = true;

    /**
     * @var array Don't add comments to template blocks that contain these strings (case-insensitive)
     */
    public array $excludeBlocksThatContain = [
        'css',
        'js',
        'javascript',
    ];

    /**
     * @deprecated This is no longer used
     * @var bool Whether or not to show comments for templates that are include'd
     */
    public bool $templateCommentsEnabled = true;

    /**
     * @deprecated This is no longer used
     * @var bool Whether or not to show comments for `{% block %}`s
     */
    public bool $blockCommentsEnabled = true;

    /**
     * @deprecated This is no longer used
     * @var array Template file suffixes that Template Comments should be enabled for
     */
    public array $allowedTemplateSuffixes = [
        '',
        'twig',
        'htm',
        'html'
    ];

    // Public Methods
    // =========================================================================
    /**
     * @inerhitdoc
     */
    public function rules(): array
    {
        return [
            [
                [
                    'siteTemplateComments',
                    'cpTemplateComments',
                    'onlyCommentsInDevMode',
                    'templateCommentsEnabled',
                    'blockCommentsEnabled',
                ],
                'boolean'
            ],
            [
                [
                    'excludeBlocksThatContain',
                    'allowedTemplateSuffixes',
                ],
                ArrayValidator::class
            ],
        ];
    }
}
