<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2023
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.2.5
 */

namespace kartik\select2;

use kartik\base\AssetBundle;

/**
 * Base theme asset bundle for the [[Select2]] widget.
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
        'kartik\select2\Select2KrajeeAsset'
    ];
    
    /**
     * Initializes theme
     */
    protected function initTheme()
    {
        $this->setSourcePath(__DIR__ . '/assets');
    }
}
