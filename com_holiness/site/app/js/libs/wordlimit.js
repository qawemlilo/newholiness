;(function ($, window, document, undefined) {
    "use strict";

    // Create the defaults once
    var pluginName = "wordLimit",
        defaults = {limit: 150};

    // The actual plugin constructor
    function Plugin ( element, options ) {
        this.element = $(element);

        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype.init = function () {
        var self = this;
        
        self.element.on('keyup', function () {
            var len = self.element.val().length, 
                diff = self.settings.limit - parseInt(len, 10);
             
            if (diff < 0) {
                self.element.val(self.element.val().substring(0, self.settings.limit));
                diff = 0;
            }
            
            $(self.settings.counterDiv).html(diff);
        });
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        return this.each(function() {
            if ( !$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
    };
})(jQuery, window, document);