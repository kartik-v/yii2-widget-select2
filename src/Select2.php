<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2020
 * @package yii2-widgets
 * @subpackage yii2-widget-select2
 * @version 2.1.8
 */

namespace kartik\select2;

use kartik\base\AddonTrait;
use kartik\base\InputWidget;
use ReflectionException;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Select2 widget is a Yii2 wrapper for the Select2 jQuery plugin. This input widget is a jQuery based replacement for
 * select boxes. It supports searching, remote data sets, and infinite scrolling of results. The widget is specially
 * styled for Bootstrap 3.x and Bootstrap 4.x.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see https://github.com/select2/select2
 */
class Select2 extends InputWidget
{
    use AddonTrait;
    /**
     * Select2 large input size
     */
    const LARGE = 'lg';
    /**
     * Select2 medium input size (default)
     */
    const MEDIUM = 'md';
    /**
     * Select2 small input size
     */
    const SMALL = 'sm';
    /**
     * Select2 default theme
     */
    const THEME_DEFAULT = 'default';
    /**
     * Select2 classic theme
     */
    const THEME_CLASSIC = 'classic';
    /**
     * Select2 Bootstrap theme
     */
    const THEME_BOOTSTRAP = 'bootstrap';
    /**
     * Select2 Krajee theme (default for BS3)
     */
    const THEME_KRAJEE = 'krajee';
    /**
     * Select2 Krajee theme (default for BS4)
     */
    const THEME_KRAJEE_BS4 = 'krajee-bs4';
    /**
     * Select2 Material Theme
     */
    const THEME_MATERIAL = 'material';

    /**
     * @var array $data the option data items. The array keys are option values, and the array values are the
     * corresponding option labels. The array can also be nested (i.e. some array values are arrays too). For each
     * sub-array, an option group will be generated whose label is the key associated with the sub-array. If you
     * have a list of data models, you may convert them into the format described above using [[ArrayHelper::map()]].
     */
    public $data;

    /**
     * @var string the locale ID (e.g. 'fr', 'de') for the language to be used by the Select2 Widget. If this property
     * not set, then the current application language will be used.
     */
    public $language;

    /**
     * @var string the theme name to be used for styling the Select2. If not set this will default to:
     * - [[THEME_KRAJEE]] if [[bsVersion]] is set to '3.x'
     * - [[THEME_KRAJEE_BS4]] if [[bsVersion]] is set to '4.x'
     */
    public $theme;

    /**
     * @var string|array, the displayed text in the dropdown for the initial value when you do not set or provide
     * `data` (e.g. using with ajax). If options['multiple'] is set to `true`, you can set this as an array of text
     * descriptions for each item in the dropdown `value`.
     */
    public $initValueText;

    /**
     * @var boolean whether to trigger change for Select2 input on form reset so the Select2 value is rightly reset.
     */
    public $changeOnReset = true;

    /**
     * @var boolean whether to hide the search control and render it as a simple select.
     */
    public $hideSearch = false;

    /**
     * @var boolean whether to maintain the order of tag / option selected for a multiple select
     */
    public $maintainOrder = false;

    /**
     * @var boolean whether to show the toggle all button for selection all options in a multiple select.
     */
    public $showToggleAll = true;

    /**
     * @var array the toggle all button settings for selecting/unselecting all the options. This is applicable only for
     * multiple select. The following array key properties can be set:
     * - `selectLabel`: _string_, the markup to be shown to select all records. Defaults to:
     *   `<i class="glyphicon glyphicon-unchecked"></i> Select all`.
     * - `unselectLabel`: _string_, the markup to be shown to unselect all records. Defaults to:
     *   `<i class="glyphicon glyphicon-checked"></i> Unselect all`.
     * - `selectOptions`: _array_, the HTML attributes for the container wrapping the select label. Defaults to `[]`.
     * - `unselectOptions`: _array_, the HTML attributes for the container wrapping the unselect label. Defaults to `[]`.
     * - `options`: _array_, the HTML attributes for the toggle button container. Defaults to:
     *   `['class' => 's2-togall-button']`.
     */
    public $toggleAllSettings = [];

    /**
     * @var array addon to prepend or append to the Select2 widget
     * - `prepend`: _array_|_string_, the prepend addon configuration. If set as a string will be rendered as is. If set
     *   as an array, the following properties can be set:
     *    - `content`: _string_, the prepend addon content.
     *    - `asButton`: _boolean`, whether the addon is a button or button group. Defaults to `false`.
     * - `append`: _array_|_string_, the append addon configuration. If set as a string will be rendered as is. If set
     *   as an array, the following properties can be set:
     *    - `content`: _string_, the append addon content.
     *    - `asButton`: _boolean`, whether the addon is a button or button group. Defaults to `false`.
     * - `groupOptions`: _array_, HTML options for the input group
     * - `contentBefore`: _string_, content placed before addon
     * - `contentAfter`: _string_, content placed after addon
     */
    public $addon = [];

    /**
     * @var string Size of the Select2 input, must be one of the [[Select2::LARGE]], [[Select2::MEDIUM]] or
     * [[Select2::SMALL]].
     */
    public $size = self::MEDIUM;

    /**
     * @var array the HTML attributes for the input tag. The following options are important:
     * - `multiple`: _boolean_, whether multiple or single item should be selected. Defaults to false.
     * - `placeholder`: _string_, placeholder for the select item.
     */
    public $options = [];

    /**
     * @var string the name of the jQuery plugin
     */
    public $pluginName = 'select2';
    /**
     *
     * @var string Implements open selector with accesskey
     */
    public $accesskey = null;

    /**
     * @var string the variable that will store additional options for Select2 to add enhanced features after the
     * plugin is loaded and initialized. This variable name will be stored as a data attribute `data-s2-options`
     * within the base select input options.
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
        self::THEME_KRAJEE_BS4,
        self::THEME_MATERIAL,
    ];

    /**
     * @inheritdoc
     * @throws ReflectionException
     * @throws InvalidConfigException
     */
    public function run()
    {
        parent::run();
        $this->renderWidget();
    }

    /**
     * Initializes and renders the widget
     * @throws ReflectionException
     * @throws InvalidConfigException
     */
    public function renderWidget()
    {
        if (!isset($this->theme)) {
            $this->theme = $this->isBs4() ? self::THEME_KRAJEE_BS4 : self::THEME_KRAJEE;
        }
        $this->initI18N(__DIR__);
        $this->pluginOptions['theme'] = $this->theme;
        $multiple = ArrayHelper::getValue($this->pluginOptions, 'multiple', false);
        unset($this->pluginOptions['multiple']);
        $multiple = ArrayHelper::getValue($this->options, 'multiple', $multiple);
        $this->options['multiple'] = $multiple;
        if (empty($this->pluginOptions['width'])) {
            if ($this->theme !== self::THEME_KRAJEE_BS4) {
                $this->pluginOptions['width'] = '100%';
            } elseif (empty($this->addon)) {
                $this->pluginOptions['width'] = 'auto';
            }
        }
        if ($this->hideSearch) {
            $this->pluginOptions['minimumResultsForSearch'] = new JsExpression('Infinity');
        }
        $this->initPlaceholder();
        if (empty($this->data)) {
            $emptyValue = !isset($this->value) || $this->value === '';
            $emptyInitText = !isset($this->initValueText) || $this->initValueText === '';
            if (!isset($this->pluginOptions['placeholder']) && !$multiple && $this->isRequired()) {
                $emptyData = ['' => ''];
            } else {
                $emptyData = [];
            }
            if ($emptyValue && $emptyInitText) {
                $this->data = $emptyData;
            } else {
                if ($multiple) {
                    $key = !$emptyValue && is_array($this->value) ? $this->value : '';
                } else {
                    $key = !$emptyValue ? $this->value : '';
                }
                $val = !$emptyInitText ? $this->initValueText : $key;
                if ($multiple) {
                    $this->data = $key !== '' ? array_combine((array)$key, (array)$val) : $emptyData;
                } else {
                    $this->data = $key !== '' ? [$key => $val] : $emptyData;
                }
            }
        }
        $this->initLanguage('language', true);
        $this->renderToggleAll();
        $this->registerAssets();
        $this->renderInput();
    }

    /**
     * Initializes and render the toggle all button
     * @throws InvalidConfigException
     */
    protected function renderToggleAll()
    {
        // disable select all toggle feature for a single select, or when the showToggleALl is false, or
        // when one is generating an ajax based search for rendering the select2 options
        if (!$this->options['multiple'] || !$this->showToggleAll || !empty($this->pluginOptions['ajax'])) {
            return;
        }
        $unchecked = '<i class="glyphicon glyphicon-unchecked"></i>';
        $checked = '<i class="glyphicon glyphicon-check"></i>';
        if ($this->isBs4()) {
            $unchecked = '<i class="far fa-square"></i>';
            $checked = '<i class="far fa-check-square"></i>';
        }
        $settings = array_replace_recursive([
            'selectLabel' => $unchecked . Yii::t('kvselect', 'Select all'),
            'unselectLabel' => $checked . Yii::t('kvselect', 'Unselect all'),
            'selectOptions' => [],
            'unselectOptions' => [],
            'options' => ['class' => 's2-togall-button'],
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
        if (!is_null($this->accesskey)) {
            $accesskey = substr($this->accesskey, 0, 1);
            echo Html::tag('button', '', [
                'accesskey' => $accesskey,
                'style' => 'background: transparent;border: none !important;font-size:0;',
                'onfocus' => '$("#' . $this->options['id'] . '").select2("open");',
            ]);
        }
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
     * @throws InvalidConfigException
     */
    protected function embedAddon($input)
    {
        if (empty($this->addon)) {
            return $input;
        }
        $isBs4 = $this->isBs4();
        $group = ArrayHelper::getValue($this->addon, 'groupOptions', []);
        $css = ['input-group', 's2-input-group'];
        if (isset($this->size)) {
            $css[] = 'input-group-' . $this->size;
        }
        Html::addCssClass($group, $css);
        if ($this->pluginLoading) {
            Html::addCssClass($group, 'kv-input-group-hide');
            Html::addCssClass($group, 'group-' . $this->options['id']);
        }
        $prepend = $this->getAddonContent('prepend', $isBs4);
        $append = $this->getAddonContent('append', $isBs4);
        if (!$isBs4 && isset($this->addon['prepend']) && is_array($this->addon['prepend'])) {
            Html::addCssClass($group, 'select2-bootstrap-prepend');
        }
        if (!$isBs4 && isset($this->addon['append']) && is_array($this->addon['append'])) {
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
     * @throws InvalidConfigException
     */
    protected function renderInput()
    {
        if ($this->pluginLoading) {
            $this->_loadIndicator = '<div class="kv-plugin-loading loading-' . $this->options['id'] . '">&nbsp;</div>';
            Html::addCssStyle($this->options, ['width' => '1px', 'height' => '1px', 'visibility' => 'hidden']);
        }
        Html::addCssClass($this->options, 'form-control');
        $input = $this->getInput('dropDownList', true);
        echo $this->_loadIndicator . $this->embedAddon($input);
    }

    /**
     * Parses the variable for boolean value and returns a right JS expression
     *
     * @param mixed $var the variable value to parse
     *
     * @return JsExpression
     */
    protected static function parseBool($var)
    {
        return new JsExpression($var ? 'true' : 'false');
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
             * @var ThemeAsset $bundleClass
             */
            $bundleClass = __NAMESPACE__ . '\Theme' . Inflector::id2camel($this->theme) . 'Asset';
            $bundleClass::register($view);
        }
    }

    /**
     * Registers the client assets for [[Select2]] widget.
     */
    public function registerAssets()
    {
        $id = $this->options['id'];
        $this->registerAssetBundle();
        $isMultiple = isset($this->options['multiple']) && $this->options['multiple'];
        $options = Json::encode([
            'themeCss' => ".select2-container--{$this->theme}",
            'sizeCss' => empty($this->addon) && $this->size !== self::MEDIUM ? ' input-' . $this->size : '',
            'doReset' => static::parseBool($this->changeOnReset),
            'doToggle' => static::parseBool($isMultiple && $this->showToggleAll),
            'doOrder' => static::parseBool($isMultiple && $this->maintainOrder),
        ]);
        $this->_s2OptionsVar = 's2options_' . hash('crc32', $options);
        $this->options['data-s2-options'] = $this->_s2OptionsVar;
        $view = $this->getView();
        $view->registerJs("var {$this->_s2OptionsVar} = {$options};", View::POS_HEAD);
        if ($this->maintainOrder) {
            $val = Json::encode(is_array($this->value) ? $this->value : [$this->value]);
            $view->registerJs("initS2Order('{$id}',{$val});");
        }
        $this->registerPlugin($this->pluginName, "jQuery('#{$id}')", "initS2Loading('{$id}','{$this->_s2OptionsVar}')");
    }
    
    protected function isRequired()
    {
        if (!empty($this->options['required'])) {
            return true;
        }
        if (!$this->hasModel()) {
            return false;
        }
        $validators = $this->model->getValidators($this->attribute);
        foreach ($validators as $validator) {
            if ($validator instanceof yii\validators\RequiredValidator) {
                return true;
            }
        }
        return false;
    }
}
