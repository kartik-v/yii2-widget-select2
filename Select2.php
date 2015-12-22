<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.0.6
 */

namespace kartik\select2;

use kartik\base\AssetBundle;
use kartik\base\InputWidget;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Select2 widget is a Yii2 wrapper for the Select2 jQuery plugin. This input widget is a jQuery based replacement for
 * select boxes. It supports searching, remote data sets, and infinite scrolling of results. The widget is specially
 * styled for Bootstrap 3.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see https://github.com/select2/select2
 */
class Select2 extends InputWidget
{
    const LARGE = 'lg';
    const MEDIUM = 'md';
    const SMALL = 'sm';

    const THEME_DEFAULT = 'default';
    const THEME_CLASSIC = 'classic';
    const THEME_BOOTSTRAP = 'bootstrap';
    const THEME_KRAJEE = 'krajee';

    /**
     * @var array $data the option data items. The array keys are option values, and the array values are the
     *     corresponding option labels. The array can also be nested (i.e. some array values are arrays too). For each
     *     sub-array, an option group will be generated whose label is the key associated with the sub-array. If you
     *     have a list of data models, you may convert them into the format described above using
     *     [[\yii\helpers\ArrayHelper::map()]].
     */
    public $data;

    /**
     * @var string the locale ID (e.g. 'fr', 'de') for the language to be used by the Select2 Widget. If this property
     *     not set, then the current application language will be used.
     */
    public $language;

    /**
     * @var string the theme name to be used for styling the Select2.
     */
    public $theme = self::THEME_KRAJEE;

    /**
     * @var string|array, the displayed text in the dropdown for the initial value when you do not set or provide
     *     `data` (e.g. using with ajax). If options['multiple'] is set to `true`, you can set this as an array of text
     *     descriptions for each item in the dropdown `value`.
     */
    public $initValueText;

    /**
     * @var bool whether to trigger change for Select2 input on form reset so the Select2 value is rightly reset.
     */
    public $changeOnReset = true;

    /**
     * @var bool whether to hide the search control and render it as a simple select. Defaults to `false`.
     */
    public $hideSearch = false;
    
    /**
     * @var bool whether to maintain the order of tag / option selected for a multiple select
     */
    public $maintainOrder = false;

    /**
     * @var bool whether to show the toggle all button for selection all options in a multiple select.
     */
    public $showToggleAll = true;

    /**
     * @var array the toggle all button settings for selecting/unselecting all the options. This is applicable only for
     * multiple select. The following array key properties can be set:
     * - `selectLabel`: string, the markup to be shown to select all records. Defaults to `<i class="glyphicon
     *     glyphicon-unchecked"></i> Select all`.
     * - `unselectLabel`: string, the markup to be shown to unselect all records. Defaults to `<i class="glyphicon
     *     glyphicon-checked"></i> Unselect all`.
     * - `selectOptions`: array, the HTML attributes for the container wrapping the select label. Defaults to `[]`.
     * - `unselectOptions`: array, the HTML attributes for the container wrapping the unselect label. Defaults to `[]`.
     * - `options`: array, the HTML attributes for the toggle button container. Defaults to:
     *   `['class' => 's2-togall-button']`.
     */
    public $toggleAllSettings = [];

    /**
     * @var array addon to prepend or append to the Select2 widget
     * - prepend: array|string the prepend addon configuration. If set as a string will be rendered as is. If set as an
     *     array, the following properties can be set:
     *     - content: string, the prepend addon content
     *     - asButton: bool, whether the addon is a button or button group. Defaults to false.
     * - append: array|string the append addon configuration. If set as a string will be rendered as is. If set as an
     *     array, the following properties can be set:
     *     - content: string, the append addon content
     *     - asButton: bool, whether the addon is a button or button group. Defaults to false.
     * - groupOptions: array, HTML options for the input group
     * - contentBefore: string, content placed before addon
     * - contentAfter: string, content placed after addon
     */
    public $addon = [];

    /**
     * @var string Size of the Select2 input, must be one of the `Select2::LARGE`, `Select2::MEDIUM` or
     * `Select2::SMALL`. Defaults to `Select2::MEDIUM`.
     */
    public $size = self::MEDIUM;

    /**
     * @var array the HTML attributes for the input tag. The following options are important:
     * - multiple: bool, whether multiple or single item should be selected. Defaults to false.
     * - placeholder: string, placeholder for the select item.
     */
    public $options = [];

    /**
     * @var string the variable that will store additional options for Select2 to add enhanced features after the
     *     plugin is loaded and initialized. This variable name will be stored as a data attribute `data-s2-options`
     *     within the base select input options.
     */
    protected $_s2OptionsVar;

    /**
     * @inheritdoc
     */
    protected $_msgCat = 'kvselect';

    /**
     * @var array list of inbuilt themes
     */
    protected static $_inbuiltThemes = [
        self::THEME_DEFAULT,
        self::THEME_CLASSIC,
        self::THEME_BOOTSTRAP,
        self::THEME_KRAJEE,
    ];

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        $this->renderWidget();
    }

    /**
     * Initializes and renders the widget
     */
    public function renderWidget()
    {
        $this->initI18N(__DIR__);
        $this->pluginOptions['theme'] = $this->theme;
        $multiple = ArrayHelper::getValue($this->pluginOptions, 'multiple', false);
        unset($this->pluginOptions['multiple']);
        $multiple = ArrayHelper::getValue($this->options, 'multiple', $multiple);
        $this->options['multiple'] = $multiple;
        if (!empty($this->addon) || empty($this->pluginOptions['width'])) {
            $this->pluginOptions['width'] = '100%';
        }
        if ($this->hideSearch) {
            $this->pluginOptions['minimumResultsForSearch'] = new JsExpression('Infinity');
        }
        $this->initPlaceholder();
        if (!isset($this->data)) {
            if (!isset($this->value) && !isset($this->initValueText)) {
                $this->data = [];
            } else {
                $key = isset($this->value) ? $this->value : ($multiple ? [] : '');
                $val = isset($this->initValueText) ? $this->initValueText : $key;
                $this->data = $multiple ? array_combine($key, $val) : [$key => $val];
            }
        }
        Html::addCssClass($this->options, 'form-control');
        $this->initLanguage('language', true);
        $this->renderToggleAll();
        $this->registerAssets();
        $this->renderInput();
    }

    /**
     * Initializes and render the toggle all button
     */
    protected function renderToggleAll()
    {
        if (!$this->options['multiple'] || !$this->showToggleAll) {
            return;
        }
        $settings = array_replace_recursive([
            'selectLabel' => '<i class="glyphicon glyphicon-unchecked"></i>' . Yii::t('kvselect', 'Select all'),
            'unselectLabel' => '<i class="glyphicon glyphicon-check"></i>' . Yii::t('kvselect', 'Unselect all'),
            'selectOptions' => [],
            'unselectOptions' => [],
            'options' => ['class' => 's2-togall-button']
        ], $this->toggleAllSettings);
        $sOptions = $settings['selectOptions'];
        $uOptions = $settings['unselectOptions'];
        $options = $settings['options'];
        $prefix = 's2-togall-';
        Html::addCssClass($options, "{$prefix}select");
        Html::addCssClass($sOptions, "s2-select-label");
        Html::addCssClass($uOptions, "s2-unselect-label");
        $options['id'] = $prefix . $this->options['id'];
        $labels = Html::tag('span', $settings['selectLabel'], $sOptions) .
            Html::tag('span', $settings['unselectLabel'], $uOptions);
        $out = Html::tag('span', $labels, $options);
        echo Html::tag('span', $out, ['id' => 'parent-' . $options['id'], 'style' => 'display:none']);
    }

    /**
     * Initializes the placeholder for Select2
     */
    protected function initPlaceholder()
    {
        $isMultiple = ArrayHelper::getValue($this->options, 'multiple', false);
        if (isset($this->options['prompt']) && !isset($this->pluginOptions['placeholder'])) {
            $this->pluginOptions['placeholder'] = $this->options['prompt'];
            if ($isMultiple) {
                unset($this->options['prompt']);
            }
            return;
        }
        if (isset($this->options['placeholder'])) {
            $this->pluginOptions['placeholder'] = $this->options['placeholder'];
            unset($this->options['placeholder']);
        }
        if (isset($this->pluginOptions['placeholder']) && is_string($this->pluginOptions['placeholder']) && !$isMultiple) {
            $this->options['prompt'] = $this->pluginOptions['placeholder'];
        }
    }

    /**
     * Embeds the input group addon
     *
     * @param string $input
     *
     * @return string
     */
    protected function embedAddon($input)
    {
        if (empty($this->addon)) {
            return $input;
        }
        $group = ArrayHelper::getValue($this->addon, 'groupOptions', []);
        $size = isset($this->size) ? ' input-group-' . $this->size : '';
        Html::addCssClass($group, 'input-group' . $size);
        $prepend = ArrayHelper::getValue($this->addon, 'prepend', '');
        $append = ArrayHelper::getValue($this->addon, 'append', '');
        if ($this->pluginLoading) {
            Html::addCssClass($group, 'kv-input-group-hide');
            Html::addCssClass($group, 'group-' . $this->options['id']);
        }
        if (is_array($prepend)) {
            $content = ArrayHelper::getValue($prepend, 'content', '');
            if (isset($prepend['asButton']) && $prepend['asButton'] == true) {
                $prepend = Html::tag('div', $content, ['class' => 'input-group-btn']);
            } else {
                $prepend = Html::tag('span', $content, ['class' => 'input-group-addon']);
            }
            Html::addCssClass($group, 'select2-bootstrap-prepend');
        }
        if (is_array($append)) {
            $content = ArrayHelper::getValue($append, 'content', '');
            if (isset($append['asButton']) && $append['asButton'] == true) {
                $append = Html::tag('div', $content, ['class' => 'input-group-btn']);
            } else {
                $append = Html::tag('span', $content, ['class' => 'input-group-addon']);
            }
            Html::addCssClass($group, 'select2-bootstrap-append');
        }
        $addonText = $prepend . $input . $append;
        $contentBefore = ArrayHelper::getValue($this->addon, 'contentBefore', '');
        $contentAfter = ArrayHelper::getValue($this->addon, 'contentAfter', '');
        return Html::tag('div', $contentBefore . $addonText . $contentAfter, $group);
    }

    /**
     * Renders the source Input for the Select2 plugin. Graceful fallback to a normal HTML select dropdown or text
     * input - in case JQuery is not supported by the browser
     */
    protected function renderInput()
    {
        if ($this->pluginLoading) {
            $this->_loadIndicator = '<div class="kv-plugin-loading loading-' . $this->options['id'] . '">&nbsp;</div>';
            Html::addCssStyle($this->options, 'display:none');
        }
        $input = $this->getInput('dropDownList', true);
        echo $this->_loadIndicator . $this->embedAddon($input);
    }

    /**
     * Registers the asset bundle and locale
     */
    public function registerAssetBundle()
    {
        $view = $this->getView();
        $lang = isset($this->language) ? $this->language : '';
        Select2Asset::register($view)->addLanguage($lang, '', 'js/i18n');
        if (in_array($this->theme, self::$_inbuiltThemes)) {
            /**
             * @var AssetBundle $bundleClass
             */
            $bundleClass = __NAMESPACE__ . '\Theme' . ucfirst($this->theme) . 'Asset';
            $bundleClass::register($view);
        }
    }

    /**
     * Parses the variable for boolean value and returns a right JS expression
     *
     * @return JsExpression
     */
    protected static function parseBool($var) 
    {
        return new JsExpression($var ? 'true' : 'false');
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $id = $this->options['id'];
        $this->registerAssetBundle();
        $isMultiple = $this->options['multiple'];
        $options = Json::encode([
            'themeCss' => ".select2-container--{$this->theme}",
            'sizeCss' => empty($this->addon) && $this->size !== self::MEDIUM ? 'input-' . $this->size : '',
            'doReset' => static::parseBool($this->changeOnReset),
            'doToggle' => static::parseBool($isMultiple && $this->showToggleAll),
            'doOrder' => static::parseBool($isMultiple && $this->maintainOrder)
        ]);
        $this->_s2OptionsVar = 's2options_' . hash('crc32', $options);
        $this->options['data-s2-options'] = $this->_s2OptionsVar;
        $this->getView()->registerJs("var {$this->_s2OptionsVar} = {$options};", View::POS_HEAD);
        $this->registerPlugin('select2', "jQuery('#{$id}')", "initS2Loading('{$id}','{$this->_s2OptionsVar}')");
    }
}
