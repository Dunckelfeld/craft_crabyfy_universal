<?php
/**
 * CraByFy Universal plugin for Craft CMS 3.x
 *
 * Deploys craft fed gatsby frontend to netlify
 *
 * @link      dunckelfeld.de
 * @copyright Copyright (c) 2018 Dunckelfeld
 */

namespace dunckelfeld\crabyfyuniversal\controllers;

use dunckelfeld\crabyfyuniversal\CraByFyUniversal;

use Craft;
use craft\web\Controller;
use craft\services\Sites;
use craft\helpers\UrlHelper;

/**
 * Deploy Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Dunckelfeld
 * @package   CraByFyUniversal
 * @since     1.0.0
 */
class DeployController extends Controller
{
    public $enableCsrfValidation = false;

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = [
        'index'
    ];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/cra-by-fy-universal/deploy
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $settings = CraByFyUniversal::$plugin->getSettings();

        $variables = [
            'crabyfyUniversalPreviewUrl'                  => $settings['crabyfyUniversalPreviewUrl'],
            'crabyfyUniversalPreviewDeployTriggerUrl'     => $settings['crabyfyUniversalPreviewDeployTriggerUrl'],
            'crabyfyUniversalPreviewDeployStatusEndpoint' => $settings['crabyfyUniversalPreviewDeployStatusEndpoint'],
            'crabyfyUniversalLiveUrl'                     => $settings['crabyfyUniversalLiveUrl'],
            'crabyfyUniversalLiveDeployTriggerUrl'        => $settings['crabyfyUniversalLiveDeployTriggerUrl'],
            'crabyfyUniversalLiveDeployStatusEndpoint'    => $settings['crabyfyUniversalLiveDeployStatusEndpoint'],
        ];

        return $this->renderTemplate('cra-by-fy-universal', $variables);
    }
}
