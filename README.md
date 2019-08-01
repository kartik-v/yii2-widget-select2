<h1 align="center">
    <a href="http://demos.krajee.com" title="Krajee Demos" target="_blank">
        <img src="http://kartik-v.github.io/bootstrap-fileinput-samples/samples/krajee-logo-b.png" alt="Krajee Logo"/>
    </a>
    <br>
    yii2-widget-select2
    <hr>
    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DTP3NZQ6G2AYU"
       title="Donate via Paypal" target="_blank">
        <img src="http://kartik-v.github.io/bootstrap-fileinput-samples/samples/donate.png" alt="Donate"/>
    </a>
</h1>

<div align="center">

[![Financial Contributors on Open Collective](https://opencollective.com/yii2-widget-select2/all/badge.svg?label=financial+contributors)](https://opencollective.com/yii2-widget-select2)
[![Stable Version](https://poser.pugx.org/kartik-v/yii2-widget-select2/v/stable)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![Unstable Version](https://poser.pugx.org/kartik-v/yii2-widget-select2/v/unstable)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![License](https://poser.pugx.org/kartik-v/yii2-widget-select2/license)](https://packagist.org/packages/kartik-v/yii2-widget-select2)

[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-widget-select2/downloads)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-widget-select2/d/monthly)](https://packagist.org/packages/kartik-v/yii2-widget-select2)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-widget-select2/d/daily)](https://packagist.org/packages/kartik-v/yii2-widget-select2)

</div>

This is the Select2 widget and a Yii 2 enhanced wrapper for the [Select2 jQuery plugin](http://ivaynberg.github.io/select2). This input widget is a jQuery based replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results. The widget is specially styled for Bootstrap 3 and offers a few enhancements not available in the source plugin. The widget allows graceful degradation to a normal HTML select or text input, if the browser does not support JQuery.

> NOTE: This extension is a sub repo split of [yii2-widgets](https://github.com/kartik-v/yii2-widgets). The split has been done since 08-Nov-2014 to allow developers to install this specific widget in isolation if needed. One can also use the extension the previous way with the whole suite of [yii2-widgets](http://demos.krajee.com/widgets).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/kartik-v/yii2-widget-select2/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install, either run

```
$ php composer.phar require kartik-v/yii2-widget-select2 "@dev"
```

or add

```
"kartik-v/yii2-widget-select2": "@dev"
```

to the ```require``` section of your `composer.json` file.

## Release Changes

> NOTE: Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-widget-select2/blob/master/CHANGE.md) for details on changes to various releases.

The widget has a major version revamp with v2.0. This release includes updates to use Select2 plugin release v4.0. Select2 release v4.0 is a major rewrite over Select2 v3.x and hence quite a few enhancements or changes should be expected. To use the earlier plugin release v3.5.2, you must point it to the [v1.0.1 release](https://github.com/kartik-v/yii2-widget-select2/releases/tag/v1.0.1) of the widget.

Enhancements with release v2.0:

- New `theme` property that allows you to set themes in Select2 to style your widget.
- A brand new theme by Krajee `Select2::THEME_KRAJEE` is specially styled for Select2. This will help achieve various new yii2-widget-select2 features. This theme matches the bootstrap 3 styling with enhancements.
- Additional themes provided in form of `Select2::THEME_DEFAULT`, `Select2::THEME_CLASSIC`, and `Select2::THEME_BOOTSTRAP`. One can add their own custom theme and configure the widget.
- No more `query` plugin property needed. It is also not mandatory to configure `data` even if you have not set `tags` or `query` or `ajax`. Widget will intelligently evaluate the properties and default list values.
- Enhanced tagging support. Use it just like a multiple select but with taggable values. In addition, one can create tags on the fly.
- Enhanced ajax support. Refer the [demos](http://demos.krajee.com/widget-details/select2) for details.
- The `initSelection` method of Select2 3.5.x plugin is obsolete/removed. New `initValueText` property is been provided with the Select2 widget to cater to this (e.g. for ajax based loading).
- Ability to disable selective option values in the Select2 dropdown OR add HTML attributes to selective options.
- Enhancement by Krajee to disable the search box to use like a normal select.
- Enhancements to locales and translations. Allow multiple language Select2 widgets on the same page.

## Documentation and Demo

You can refer detailed [documentation and demos](http://demos.krajee.com/widget-details/select2) on usage of the extension.

## Usage

```php
use kartik\select2\Select2;

// Normal select with ActiveForm & model
echo $form->field($model, 'state_1')->widget(Select2::classname(), [
    'data' => $data,
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

## Contributors

### Code Contributors

This project exists thanks to all the people who contribute. [[Contribute](.github/CONTRIBUTING.md)].
<a href="https://github.com/kartik-v/yii2-widget-select2/graphs/contributors"><img src="https://opencollective.com/yii2-widget-select2/contributors.svg?width=890&button=false" /></a>

### Financial Contributors

Become a financial contributor and help us sustain our community. [[Contribute](https://opencollective.com/yii2-widget-select2/contribute)]

#### Individuals

<a href="https://opencollective.com/yii2-widget-select2"><img src="https://opencollective.com/yii2-widget-select2/individuals.svg?width=890"></a>

#### Organizations

Support this project with your organization. Your logo will show up here with a link to your website. [[Contribute](https://opencollective.com/yii2-widget-select2/contribute)]

<a href="https://opencollective.com/yii2-widget-select2/organization/0/website"><img src="https://opencollective.com/yii2-widget-select2/organization/0/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/1/website"><img src="https://opencollective.com/yii2-widget-select2/organization/1/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/2/website"><img src="https://opencollective.com/yii2-widget-select2/organization/2/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/3/website"><img src="https://opencollective.com/yii2-widget-select2/organization/3/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/4/website"><img src="https://opencollective.com/yii2-widget-select2/organization/4/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/5/website"><img src="https://opencollective.com/yii2-widget-select2/organization/5/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/6/website"><img src="https://opencollective.com/yii2-widget-select2/organization/6/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/7/website"><img src="https://opencollective.com/yii2-widget-select2/organization/7/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/8/website"><img src="https://opencollective.com/yii2-widget-select2/organization/8/avatar.svg"></a>
<a href="https://opencollective.com/yii2-widget-select2/organization/9/website"><img src="https://opencollective.com/yii2-widget-select2/organization/9/avatar.svg"></a>

## License

**yii2-widget-select2** is released under the BSD-3-Clause License. See the bundled `LICENSE.md` for details.