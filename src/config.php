<?php
/**
 * Template Comments plugin for Craft CMS 3.x
 *
 * Adds a HTML comment to demarcate each Twig template that is included or
 * extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

/**
 * Template Comments config.php
 *
 * This file exists only as a template for the Instant Analytics settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as
 * 'templatecomments.php' and make your changes there to override default
 * settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just
 * as
 * you do for 'general.php'
 */

return [
    /**
     * @var bool Whether comments should be generated for site templates
     */
    'siteTemplateComments' => true,

    /**
     * @var bool Whether comments should be generated for Control Panel templates
     */
    'cpTemplateComments' => false,

    /**
     * @var bool Whether to generate comments only when `devMode` is on
     */
    'onlyCommentsInDevMode' => true,

    /**
     * @var array Don't add comments to template blocks that contain these strings (case-insensitive)
     */
    'excludeBlocksThatContain' => [
        'css',
        'js',
        'javascript',
    ],

    /**
     * @deprecated This is no longer used
     * @var bool Whether or not to show comments for templates that are include'd
     */
    'templateCommentsEnabled' => true,

    /**
     * @deprecated This is no longer used
     * @var bool Whether or not to show comments for `{% block %}`s
     */
    'blockCommentsEnabled' => true,

    /**
     * @deprecated This is no longer used
     * @var array Template file suffixes that Template Comments should be enabled for
     */
    'allowedTemplateSuffixes' => [
        '',
        'twig',
        'htm',
        'html',
    ],
];
