<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.1.4
 */

namespace kartik\select2;

use kartik\base\AssetBundle;

/**
 * Base theme asset bundle.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ThemeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends = [
        'kartik\select2\Select2Asset'
    ];
}
