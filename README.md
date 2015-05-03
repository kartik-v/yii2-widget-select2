yii2-widget-select2
===================

[![Latest Stable Version](https://poser.pugx.org/kartik-v/yii2-widget-select2/v/stable)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![License](https://poser.pugx.org/kartik-v/yii2-widget-select2/license)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-widget-select2/downloads)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-widget-select2/d/monthly)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-widget-select2/d/daily)](https://packagist.org/packages/kartik-v/yii2-widget-select2)

This is the Select2 widget and a Yii 2 enhanced wrapper for the [Select2 jQuery plugin](http://ivaynberg.github.io/select2). This input widget is a jQuery based replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results. The widget is specially styled for Bootstrap 3 and offers a few enhancements not available in the source plugin. The widget allows graceful degradation to a normal HTML select or text input, if the browser does not support JQuery.

> NOTE: This extension is a sub repo split of [yii2-widgets](https://github.com/kartik-v/yii2-widgets). The split has been done since 08-Nov-2014 to allow developers to install this specific widget in isolation if needed. One can also use the extension the previous way with the whole suite of [yii2-widgets](http://demos.krajee.com/widgets).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/kartik-v/yii2-widget-select2/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install, either run

```
$ php composer.phar require kartik-v/yii2-widget-select2 "*"
```

or add

```
"kartik-v/yii2-widget-select2": "*"
```

to the ```require``` section of your `composer.json` file.

## Latest Release

> NOTE: The latest version of the module is v1.0.1. Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-widget-select2/blob/master/CHANGE.md) for details.

## Demo

You can refer detailed [documentation and demos](http://demos.krajee.com/widget-details/select2) on usage of the extension.

## Usage

```php
use kartik\select2\Select2;

// Normal select with ActiveForm & model
echo $form->field($model, 'state_1')->widget(Select2::classname(), [
    'data' => array_merge(["" => ""], $data),
    'language' => 'de',
    'options' => ['placeholder' => 'Select a state ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

// Multiple select without model
echo Select2::widget([
    'name' => 'state_2',
    'value' => '',
    'data' => $data,
    'options' => ['multiple' => true, 'placeholder' => 'Select states ...']
]);
```

## License

**yii2-widget-select2** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.