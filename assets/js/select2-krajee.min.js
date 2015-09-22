/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2015
 * @version 2.0.4
 *
 * Additional enhancements for Select2 widget extension for Yii 2.0.
 *
 * Author: Kartik Visweswaran
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */var initS2Loading=function(){},initS2Open=function(){},initS2Unselect=function(){};!function(e){"use strict";initS2Loading=function(n,t,s,i){var a=e("#"+n),o=e(t),c=e(".kv-plugin-loading.loading-"+n),r=e(".group-"+n);o.length||a.show(),r.length&&r.removeClass("kv-input-group-hide").removeClass(".group-"+n),c.remove(),s&&a.next(t).removeClass(s).addClass(s),i&&a.closest("form").on("reset",function(){setTimeout(function(){a.trigger("change")},100)})},initS2Open=function(){var n,t,s=e(this),i=e(".select2-container--open"),a=s.parents("[class*='has-']");if(a.length)for(n=a[0].className.split(/\s+/),t=0;t<n.length;t++)n[t].match("has-")&&i.removeClass("has-success has-error has-warning").addClass(n[t]);s.data("unselecting")&&(s.removeData("unselecting"),setTimeout(function(){s.select2("close").trigger("krajeeselect2:cleared")},5))},initS2Unselect=function(){e(this).data("unselecting",!0)}}(window.jQuery);