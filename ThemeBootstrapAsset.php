<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.0.1
 */

namespace kartik\select2;

use Yii;

/**
 * Bootstrap Select2 theme
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ThemeBootstrapAsset extends \kartik\base\AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/lib');
        $this->setupAssets('css', ['css/select2-bootstrap']);
        parent::init();
    }
}