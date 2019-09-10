<?php
/**
 * CraByFy Universal plugin for Craft CMS 3.x
 *
 * Plugin to trigger deployment via webhooks from craft cms backend
 *
 * @link      dunckelfeld.de
 * @copyright Copyright (c) 2018 Dunckelfeld
 */

namespace dunckelfeld\crabyfyuniversal\models;

use dunckelfeld\crabyfyuniversal\CraByFyUniversal;

use Craft;
use craft\base\Model;

/**
 * CraByFy Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Dunckelfeld
 * @package   CraByFyUniversal
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Preview URL
     *
     * @var string
     */
    public $crabyfyUniversalPreviewUrl = '';

    /**
     * Preview Deploy Trigger URL
     *
     * @var string
     */
    public $crabyfyUniversalPreviewDeployTriggerUrl = '';

    /**
     * Preview Deploy Status Endpoint
     *
     * @var string
     */
    public $crabyfyUniversalPreviewDeployStatusEndpoint = '';

    /**
     * Live URL
     *
     * @var string
     */
    public $crabyfyUniversalLiveUrl = '';

    /**
     * Live Deploy Trigger URL
     *
     * @var string
     */
    public $crabyfyUniversalLiveDeployTriggerUrl = '';

    /**
     * Live Deploy Status Endpoint
     *
     * @var string
     */
    public $crabyfyUniversalLiveDeployStatusEndpoint = '';


    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['crabyfyUniversalPreviewUrl', 'default', 'value' => ''],
            ['crabyfyUniversalPreviewDeployTriggerUrl', 'default', 'value' => ''],
            ['crabyfyUniversalPreviewDeployStatusEndpoint', 'default', 'value' => ''],
            ['crabyfyUniversalLiveUrl', 'default', 'value' => ''],
            ['crabyfyUniversalLiveDeployTriggerUrl', 'default', 'value' => ''],
            ['crabyfyUniversalLiveDeployStatusEndpoint', 'default', 'value' => ''],
        ];
    }
}
