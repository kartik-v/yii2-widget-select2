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
 * Asset bundle for the Krajee theme for [[Select2]] widget.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ThemeKrajeeBs4Asset extends ThemeAsset
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/select2-krajee-bs4']);
        parent::init();
    }
}
