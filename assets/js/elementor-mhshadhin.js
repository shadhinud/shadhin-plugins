(function($) {
    'use strict';

    var elementorBlogSlider = {};

    elementorBlogSlider.ShadhinCoreElementorInitScript = ShadhinCoreElementorInitScript;


    elementorBlogSlider.ShadhinCoreElementorOnWindowLoad = ShadhinCoreElementorOnWindowLoad;

    $(window).load(ShadhinCoreElementorOnWindowLoad);

    /*
     ** All functions to be called on $(window).load() should be in this function
     */
    function ShadhinCoreElementorOnWindowLoad() {

        var isEditMode = Boolean(elementorFrontend.isEditMode());
        if (isEditMode) {
            ShadhinCoreElementorInitScript();
        }
    }

    function ShadhinCoreElementorInitScript(){
        $(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/init', function() {
            // Do something that is based on the elementorFrontend object.
            } );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/mh-ele-animated-layers.default', function() {
            } );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
            } );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
                MHSHADHIN.documentOnReady.init();
                MHSHADHIN.windowOnLoad.init();
            } );
        });
    }


})(jQuery);