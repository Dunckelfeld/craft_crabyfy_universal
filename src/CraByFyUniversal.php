<?php
/**
 * CraByFy Universal plugin for Craft CMS 3.x
 *
 * Deploys craft fed gatsby frontend to netlify
 *
 * @link      dunckelfeld.de
 * @copyright Copyright (c) 2018 Dunckelfeld
 */

namespace dunckelfeld\crabyfyuniversal;

use dunckelfeld\crabyfyuniversal\services\Deploy as DeployService;
use dunckelfeld\crabyfyuniversal\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\ModelEvent;
use craft\fields\Matrix;
use craft\services\Elements;
use craft\elements\Entry;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use craft\events\ElementEvent;
use yii\base\Event;


/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Dunckelfeld
 * @package   CraByFyUniversal
 * @since     1.0.0
 *
 * @property  DeployService $deploy
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class CraByFyUniversal extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * CraByFy::$plugin
     *
     * @var CraByFyUniversal
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * CraByFy::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'deploy' => \dunckelfeld\crabyfyuniversal\services\Deploy::class,
        ]);

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function (RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url'   => '/admin/actions/cra-by-fy-universal/deploy',
                    'label' => 'CraByFy',
                    'icon'  => '@dunckelfeld/crabyfy-universal/icon.svg',
                ];
            }
        );

        Craft::$app->getView()->hook('cp.layouts.base', function (array &$context) {
            return $this->deployButtonAssets();
        });

        Craft::$app->getView()->hook('cp.entries.edit.details', function (array &$context) {
            return $this->previewButton($context['entry']['uri']);
        });

        /**
         * Logging in Craft involves using one of the following methods:
         *
         * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
         * Craft::info(): record a message that conveys some useful information.
         * Craft::warning(): record a warning message that indicates something unexpected has happened.
         * Craft::error(): record a fatal error that should be investigated as soon as possible.
         *
         * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
         *
         * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
         * the category to the method (prefixed with the fully qualified class name) where the constant appears.
         *
         * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
         * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
         *
         * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
         */
        Craft::info(
            Craft::t(
                'cra-by-fy-universal',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered sidebar HTML, which will be inserted into the content
     * block on the sidebar page.
     *
     * @return string The rendered sidebar HTML
     */
    protected function deployButtonAssets(): string
    {
        $settings = CraByFyUniversal::$plugin->getSettings();

        $variables = [
            'crabyfyPreviewDeployStatusBadge' => $settings['crabyfyPreviewDeployStatusBadge'],
            'crabyfyLiveDeployStatusBadge' => $settings['crabyfyLiveDeployStatusBadge'],
        ];

        return Craft::$app->view->renderTemplate(
            'cra-by-fy-universal/deployButtonAssets',
            $variables
        );
    }

    /**
     * Returns the rendered sidebar HTML, which will be inserted into the content
     * block on the sidebar page.
     *
     * @return string The rendered sidebar HTML
     */
    protected function previewButton($uri): string
    {

        $settings  = CraByFyUniversal::$plugin->getSettings();
        $variables = [
            'previewLink' => $settings['crabyfyUniversalPreviewUrl'] . $uri . '?preview=1',
        ];

        return Craft::$app->view->renderTemplate(
            'cra-by-fy-universal/previewButton', $variables
        );
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'cra-by-fy-universal/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
