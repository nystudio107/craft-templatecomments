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

use nystudio107\templatecomments\models\Settings;
use nystudio107\templatecomments\web\twig\CommentsTwigExtension;
use nystudio107\templatecomments\web\twig\CommentTemplateLoader;

use Craft;
use craft\base\Plugin;
use craft\events\TemplateEvent;
use craft\web\View;

use yii\base\Event;

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

    /**
     * @var \Twig\Loader\LoaderInterface
     */
    public static $originalTwigLoader;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        // Initialize properties
        self::$plugin = $this;
        self::$settings = $this->getSettings();
        // Add in our Craft components
        $this->addComponents();
        // Install our global event handlers
        $this->installEventListeners();

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
    protected function addComponents(): void
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
    protected function installSiteComponents(): void
    {
        if (self::$settings->siteTemplateComments) {
            $this->installTemplateComponents();
        }
    }

    /**
     * Install components for Control Panel requests only
     */
    protected function installCpComponents(): void
    {
        if (self::$settings->cpTemplateComments) {
            $this->installTemplateComponents();
        }
    }

    /**
     * Install our event listeners
     */
    protected function installEventListeners(): void
    {
        $request = Craft::$app->getRequest();
        // Do nothing at all on AJAX requests
        if (!$request->getIsConsoleRequest() && $request->getIsAjax()) {
            return;
        }

        // Install only for non-console site requests
        if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest()) {
            $this->installSiteEventListeners();
        }

        // Install only for non-console Control Panel requests
        if ($request->getIsCpRequest() && !$request->getIsConsoleRequest()) {
            $this->installCpEventListeners();
        }
    }

    /**
     * Install site event listeners for site requests only
     */
    protected function installSiteEventListeners(): void
    {
        if (self::$settings->siteTemplateComments) {
            $this->installTemplateEventListeners();
        }
    }

    /**
     * Install site event listeners for Control Panel requests only
     */
    protected function installCpEventListeners(): void
    {
        if (self::$settings->cpTemplateComments) {
            $this->installTemplateEventListeners();
        }
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): \nystudio107\templatecomments\models\Settings
    {
        return new Settings();
    }

    // Private Methods
    // =========================================================================

    /**
     * Install our template components
     */
    private function installTemplateComponents(): void
    {
        $devMode = Craft::$app->getConfig()->getGeneral()->devMode;
        if (!self::$settings->onlyCommentsInDevMode
            || (self::$settings->onlyCommentsInDevMode && $devMode)) {
            $view = Craft::$app->getView();
            self::$originalTwigLoader = $view->getTwig()->getLoader();
            Craft::$app->view->registerTwigExtension(new CommentsTwigExtension());
        }
    }

    /**
     * Install our template event listeners
     */
    private function installTemplateEventListeners(): void
    {
        $devMode = Craft::$app->getConfig()->getGeneral()->devMode;
        if (!self::$settings->onlyCommentsInDevMode
            || (self::$settings->onlyCommentsInDevMode && $devMode)) {
            // Remember the name of the currently rendering template
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE,
                function (TemplateEvent $event): void {
                    $view = Craft::$app->getView();
                    if ($this->enabledForTemplate($event->template)) {
                        $view->getTwig()->setLoader(new CommentTemplateLoader($view));
                    }
                }
            );
        }
    }

    /**
     * Is template parsing enabled for this template?
     *
     *
     */
    private function enabledForTemplate(string $templateName): bool
    {
        $ext = pathinfo($templateName, PATHINFO_EXTENSION);
        return (self::$settings->templateCommentsEnabled
            && \in_array($ext, self::$settings->allowedTemplateSuffixes, false));
    }
}
