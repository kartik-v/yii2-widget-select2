<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2020
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.1.8
 */

namespace kartik\select2;

/**
 * Asset bundle for the classic theme for [[Select2]] widget.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ThemeClassicAsset extends ThemeAsset
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initTheme();
        $this->setupAssets('css', ['css/select2-classic']);
        parent::init();
    }
}
