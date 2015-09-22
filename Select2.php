<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.0.4
 */

namespace kartik\select2;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Select2 widget is a Yii2 wrapper for the Select2 jQuery plugin. This
 * input widget is a jQuery based replacement for select boxes. It supports
 * searching, remote data sets, and infinite scrolling of results. The widget
 * is specially styled for Bootstrap 3.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see https://github.com/select2/select2
 */
class Select2 extends \kartik\base\InputWidget
{
    const LARGE = 'lg';
    const MEDIUM = 'md';
    const SMALL = 'sm';

    const THEME_DEFAULT = 'default';
    const THEME_CLASSIC = 'classic';
    const THEME_BOOTSTRAP = 'bootstrap';
    const THEME_KRAJEE = 'krajee';

    /**
     * @var array $data the option data items. The array keys are option values, and the array values
     * are the corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * [[\yii\helpers\ArrayHelper::map()]].
     */
    public $data;

    /**
     * @var string the locale ID (e.g. 'fr', 'de') for the language to be used by the Select2 Widget.
     * If this property not set, then the current application language will be used.
     */
    public $language;

    /**
     * @var string the theme name to be used for styling the Select2
     */
    public $theme = self::THEME_KRAJEE;

    /**
     * @var bool whether to trigger change for Select2 input on form reset
     * so the Select2 value is rightly reset.
     */
    public $changeOnReset = true;

    /**
     * @var string|array, the displayed text in the dropdown for the initial
     * value when you do not set or provide `data` (e.g. using with ajax).
     * If options['multiple'] is set to `true`, you can set this as an array of
     * text descriptions for each item in the dropdown `value`.
     */
    public $initValueText;

    /**
     * @var bool whether to hide the search control and render it as a simple select. Defaults to `false`.
     */
    public $hideSearch = false;

    /**
     * @var array addon to prepend or append to the Select2 widget
     * - prepend: array the prepend addon configuration
     *     - content: string the prepend addon content
     *     - asButton: boolean whether the addon is a button or button group. Defaults to false.
     * - append: array the append addon configuration
     *     - content: string the append addon content
     *     - asButton: boolean whether the addon is a button or button group. Defaults to false.
     * - groupOptions: array HTML options for the input group
     * - contentBefore: string content placed before addon
     * - contentAfter: string content placed after addon
     */
    public $addon = [];

    /**
     * @var string Size of the Select2 input, must be one of the
     * [[LARGE]], [[MEDIUM]] or [[SMALL]]. Defaults to [[MEDIUM]]
     */
    public $size = self::MEDIUM;

    /**
     * @var array the HTML attributes for the input tag. The following options are important:
     * - multiple: boolean whether multiple or single item should be selected. Defaults to false.
     * - placeholder: string placeholder for the select item.
     */
    public $options = [];

    protected static $_inbuiltThemes = [
        self::THEME_DEFAULT,
        self::THEME_CLASSIC,
        self::THEME_BOOTSTRAP,
        self::THEME_KRAJEE,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->pluginOptions['theme'] = $this->theme;
        if (!empty($this->addon) || empty($this->pluginOptions['width'])) {
            $this->pluginOptions['width'] = '100%';
        }
        $multiple = ArrayHelper::getValue($this->pluginOptions, 'multiple', false);
        unset($this->pluginOptions['multiple']);
        $multiple = ArrayHelper::getValue($this->options, 'multiple', $multiple);
        $this->options['multiple'] = $multiple;
        if ($this->hideSearch) {
            $css = ArrayHelper::getValue($this->pluginOptions, 'dropdownCssClass', '');
            $css .= ' kv-hide-search';
            $this->pluginOptions['dropdownCssClass'] = $css;
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
        $this->registerAssets();
        $this->renderInput();
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
     * Renders the source Input for the Select2 plugin.
     * Graceful fallback to a normal HTML select dropdown
     * or text input - in case JQuery is not supported by
     * the browser
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
            $bundleClass = __NAMESPACE__ . '\Theme' . ucfirst($this->theme) . 'Asset';
            $bundleClass::register($view);
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $id = $this->options['id'];
        $this->registerAssetBundle();
        // do not open dropdown when clear icon is pressed to clear value
        $js = "\$('#{$id}').on('select2:opening', initS2Open).on('select2:unselecting', initS2Unselect);";
        $this->getView()->registerJs($js);
        $size = empty($this->addon) && $this->size !== self::MEDIUM ? 'input-' . $this->size : '';
        // register plugin
        if ($this->pluginLoading) {
            $reset = $this->changeOnReset ? 'true' : 'false';
            $this->registerPlugin(
                'select2',
                "jQuery('#{$id}')",
                "initS2Loading('{$id}', '.select2-container--{$this->theme}', '{$size}', {$reset})"
            );
        } else {
            $this->registerPlugin('select2');
        }
    }
}