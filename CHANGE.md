Change Log: `yii2-widget-select2`
=================================

## Version 2.0.8

**Date:** 17-Feb-2016

- Add branch alias for dev-master latest release.
- (enh #117): Add Dutch Translations.
- (enh #119): Add Slovak Translations.
- (enh #124): Maintain order of selected values for an update scenario.
- (enh #125): Update to latest release of the select2 plugin (v4.0.2-rc.1).
- (enh #126): Enhance jQuery event handling for Krajee's additional features.

## Version 2.0.7

**Date:** 10-Jan-2016

- (enh #108): Remove navbar styling from Krajee theme.
- (enh #109): Add Hungarian Translations.
- (enh #110): Enhancements for PJAX based reinitialization. Complements enhancements in kartik-v/yii2-krajee-base#52 and kartik-v/yii2-krajee-base#53.

## Version 2.0.6

**Date:** 22-Dec-2015

- (enh #100): Update Russian translations.
- (enh #101): Consolidate asset bundles.
- (enh #102): Enhance toggle all auto-reset based on each option clear, change, or form reset.
- (enh #103): Enhance maintaining order of multi select tags.
- (enh #104): Enhance Select2 custom init routines to work with jQuery, AMD and CommonJS.

## Version 2.0.5

**Date:** 21-Dec-2015

- (enh #69): Add ability to select and unselect all options for multiple select.
- (enh #97): Allow maintaining order of pills selected for multiple select.
- (enh #98): Various enhancements to the Select2 widget.
    - Fix the plugin bug which does not close the dropdown when a value is cleared using the `x` clear indicator.
    - Enhance widget to show bootstrap `success` and `error` states for active field trapped errors
    - Better and more dynamic theming support
    - Allow select2 to be reset correctly when parent form is reset (controlled by boolean property `changeOnReset`)
    - (ref enh #69): Enable SELECT ALL and UNSELECT ALL to toggle all options for multiple select (new property `toggleAllSettings`). Allow complete configuration and styling of the same .
    - (ref enh #97): Enable select2 dropdown to maintain the right order of tags/options for multiple select (new boolean property `maintainOrder` which defaults to `false`. Set this to `true` to maintain order)
    - Consolidate and refactor code to just call one additional JS initialization script after plugin initialization. A new data-attribute `data-s2-options` is now stored in parent select input. This will store the global variable that will maintain the additional Json encoded options to be used by `initS2Loading` method.
- (enh #99): Add messages and translations support.

## Version 2.0.4

**Date:** 22-Sep-2015

- (enh #67): Remove redundant code in embedAddon.

## Version 2.0.3

**Date:** 13-Sep-2015

- (enh #57): Better handling of `multiple` property.
- (enh #58): Enhance styling of Select2 Krajee theme for non input groups.
- (enh #64): Ability to reset Select2 on form reset.

## Version 2.0.2

**Date:** 01-Jul-2015

- Rename `lib` folder to `assets` for consistency.
- (enh #53): Correct validation of values using `isset` instead of `empty`.
- (enh #54): Styling for select2 on focus (via tab and applicable only for THEME_KRAJEE).

## Version 2.0.1

**Date:** 07-Jun-2015

- (enh #28): Better width style validation for Select2.
- (enh #32): More correct language validation.
- (enh #34): Better initialization for `data` and `multiple` ajax select.
- (bug #42): Fix plugin bug that prevents clearing Select2 input correctly.
- (enh #43): Code style and formatting fixes.
- (enh #44): Trigger custom event `krajeeselect2:cleared`.
- (enh #49): Allow custom tags to be added for both single select and multiple select.

## Version 2.0.0

**Date:** 09-May-2015

Major revamp to the widget. Version bumped to release v2.0.0.

- (enh #27): Updates Select2 plugin to release v4.0. The following additional functionalities and changes should be expected with this new release:
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
    
## Version 1.0.1

**Date:** 03-May-2015

- (enh #2, #3): Register assets based on availability of locale files.
- (enh #13): Add ability to hide search control and use as normal select.
- (enh kartik-v/yii2-krajee-base#34, kartik-v/yii2-krajee-base#35): Enhance i18n translation locales.
- (enh #22): Enhance JS code to support older browser/IE versions.

## Version 1.0.0

**Date:** 08-Nov-2014

- Initial release 
- Sub repo split from [yii2-widgets](https://github.com/kartik-v/yii2-widgets)