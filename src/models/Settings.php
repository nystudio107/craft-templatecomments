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
    public $siteTemplateComments = true;

    /**
     * @var bool Whether comments should be generated for AdminCP templates
     */
    public $cpTemplateComments = false;

    /**
     * @var bool Whether to generate comments only when `devMode` is on
     */
    public $onlyCommentsInDevMode = true;

    /**
     * @var bool Whether or not to show comments for templates that are include'd
     */
    public $templateCommentsEnabled = true;

    /**
     * @var bool Whether or not to show comments for `{% block %}`s
     */
    public $blockCommentsEnabled = true;

    /**
     * @var array Template file suffixes that Template Comments should be enabled for
     */
    public $allowedTemplateSuffixes = [
        '',
        'twig',
        'htm',
        'html'
    ];

    // Public Methods
    // =========================================================================

    /** @noinspection ReturnTypeCanBeDeclaredInspection */
    /**
     * @return array
     */
    public function rules()
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
                    'allowedTemplateSuffixes',
                ],
                ArrayValidator::class
            ],
        ];
    }
}
