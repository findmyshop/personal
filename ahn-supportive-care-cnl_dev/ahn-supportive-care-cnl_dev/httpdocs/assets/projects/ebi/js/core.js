var EBI = EBI || {};

(function($) {
    var Core = function() {
        $(document).ready(function() {
            $(window).trigger('resize');
            EBI.core.cssFixes();
            EBI.core.flowHandler();
        });

        $(window).on('resize', function() {
            EBI.core.cssFixes();
        });

        this.cssFixes = function() {

        };

        this.flowHandler = function() {

        };
    };

    EBI.core = new Core();
})(jQuery);