<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package yii2-widgets
 * @subpackage yii2-widget-select2 
 * @version 1.0.1
 */

namespace kartik\select2;

use Yii;

/**
 * Asset bundle for Select2 Widget
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Select2Asset extends \kartik\base\AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/lib');
        $this->setupAssets('css', ['select2', 'select2-kv']);
        $this->setupAssets('js', ['select2', 'select2-kv']);
        parent::init();
    }

}