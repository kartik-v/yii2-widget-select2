/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version 2.0.2
 *
 * Additional enhancements for Select2 widget extension for Yii 2.0.
 *
 * Author: Kartik Visweswaran
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */var initS2Loading=function(){},initS2Open=function(){},initS2Unselect=function(){};!function(e){"use strict";initS2Loading=function(n,s,t){var i=e("#"+n),a=e(s),o=e(".kv-plugin-loading.loading-"+n),l=e(".group-"+n);a.length||i.show(),l.length&&l.removeClass("kv-input-group-hide").removeClass(".group-"+n),o.remove(),t&&i.next(s).removeClass(t).addClass(t)},initS2Open=function(){var n,s,t=e(this),i=e(".select2-container--open"),a=t.parents("[class*='has-']");if(a.length)for(n=a[0].className.split(/\s+/),s=0;s<n.length;s++)n[s].match("has-")&&i.removeClass("has-success has-error has-warning").addClass(n[s]);t.data("unselecting")&&(t.removeData("unselecting"),setTimeout(function(){t.select2("close").trigger("krajeeselect2:cleared")},5))},initS2Unselect=function(){e(this).data("unselecting",!0)}}(window.jQuery);