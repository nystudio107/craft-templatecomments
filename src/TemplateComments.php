<?php
/**
 * Template Comments plugin for Craft CMS 3.x
 *
 * Adds a HTML comment to demarcate each Twig template that is included or extended.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\templatecomments;

use Craft;
use craft\base\Plugin;
use nystudio107\templatecomments\models\Settings;
use nystudio107\templatecomments\web\twig\CommentsTwigExtension;
use nystudio107\templatecomments\web\twig\CommentTemplateLoader;

/**
 * Class TemplateComments
 *
 * @author    nystudio107
 * @package   TemplateComments
 * @since     1.0.0
 *
 */
class TemplateComments extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var TemplateComments
     */
    public static $plugin;

    /**
     * @var Settings $settings
     */
    public static $settings;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // Initialize properties
        self::$plugin = $this;
        self::$settings = $this->getSettings();
        // Add in our Craft components
        $this->addComponents();

        Craft::info(
            Craft::t(
                'templatecomments',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * Add in our Craft components
     */
    protected function addComponents()
    {
        $request = Craft::$app->getRequest();
        if (!$request->getIsConsoleRequest()) {
            // Do nothing at all on AJAX requests
            if ($request->getIsAjax()) {
                return;
            }
            // Install only for site requests
            if ($request->getIsSiteRequest()) {
                $this->installSiteComponents();
            }
            // Install only for Control Panel requests
            if ($request->getIsCpRequest()) {
                $this->installCpComponents();
            }
        }
    }

    /**
     * Install components for site requests only
     */
    protected function installSiteComponents()
    {
        if (self::$settings->siteTemplateComments) {
            $this->installTemplateComponents();
        }
    }

    /**
     * Install components for Control Panel requests only
     */
    protected function installCpComponents()
    {
        if (self::$settings->cpTemplateComments) {
            $this->installTemplateComponents();
        }
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    // Private Methods
    // =========================================================================

    /**
     * Install our template components
     */
    private function installTemplateComponents()
    {
        $devMode = Craft::$app->getConfig()->getGeneral()->devMode;
        if (!self::$settings->onlyCommentsInDevMode
            || (self::$settings->onlyCommentsInDevMode && $devMode)) {
            Craft::$app->view->registerTwigExtension(new CommentsTwigExtension());
        }
    }
}
