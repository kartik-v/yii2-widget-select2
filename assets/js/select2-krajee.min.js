/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version 2.0.2
 *
 * Additional enhancements for Select2 widget extension for Yii 2.0.
 *
 * Author: Kartik Visweswaran
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */var initS2Loading=function(){},initS2Open=function(){},initS2Unselect=function(){};!function(e){"use strict";initS2Loading=function(n,t){var i=e("#"+n),s=e(t),a=e(".kv-plugin-loading.loading-"+n),o=e(".group-"+n);s.length||i.show(),o.length&&o.removeClass("kv-input-group-hide").removeClass(".group-"+n),a.remove()},initS2Open=function(){var n,t,i=e(this),s=e(".select2-container--open"),a=i.parents("[class*='has-']");if(a.length)for(n=a[0].className.split(/\s+/),t=0;t<n.length;t++)n[t].match("has-")&&s.removeClass("has-success has-error has-warning").addClass(n[t]);i.data("unselecting")&&(i.removeData("unselecting"),setTimeout(function(){i.select2("close").trigger("krajeeselect2:cleared")},1))},initS2Unselect=function(){e(this).data("unselecting",!0)}}(window.jQuery);