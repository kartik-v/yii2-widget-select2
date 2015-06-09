version 2.0.1
=============
**Date:** 07-Jun-2015

- (enh #28): Better width style validation for Select2.
- (enh #32): More correct language validation.
- (enh #34): Better initialization for `data` and `multiple` ajax select.
- (bug #42): Fix plugin bug that prevents clearing Select2 input correctly.
- (enh #43): Code style and formatting fixes.
- (enh #44): Trigger custom event `krajeeselect2:cleared`.

version 2.0.0
=============
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
    
version 1.0.1
=============
**Date:** 03-May-2015

- (enh #2, #3): Register assets based on availability of locale files.
- (enh #13): Add ability to hide search control and use as normal select.
- (enh kartik-v/yii2-krajee-base#34, kartik-v/yii2-krajee-base#35): Enhance i18n translation locales.
- (enh #22): Enhance JS code to support older browser/IE versions.

version 1.0.0
=============
**Date:** 08-Nov-2014

- Initial release 
- Sub repo split from [yii2-widgets](https://github.com/kartik-v/yii2-widgets)