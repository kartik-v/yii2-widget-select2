<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2017
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.0.9
 */

namespace kartik\select2;

use kartik\base\AssetBundle;

/**
 * Asset bundle for [[Select2]] Widget.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Select2Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/select2', 'css/select2-addl']);
        $this->setupAssets('js', ['js/select2.full', 'js/select2-krajee']);
        parent::init();
    }
}
