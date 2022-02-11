<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2022
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.2.3
 */

namespace kartik\select2;

/**
 * Asset bundle for the bootstrap theme for the [[Select2]] widget.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ThemeBootstrapAsset extends ThemeAsset
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initTheme();
        $this->setupAssets('css', ['css/select2-bootstrap']);
        parent::init();
    }
}
