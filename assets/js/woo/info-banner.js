(function ($) {
    'use strict';


    $( document ).ready(
        function () {
            mascotBannerReveal.init();
        }
    );

    var mascotBannerReveal = {
        init: function () {
            this.holder = $( '.tm-sc-info-banner-advanced' );

            if ( this.holder.length ) {
                this.holder.each(
                    function () {
                        mascotBannerReveal.initItem( $( this ) );
                    }
                );
            }
        },
        initItem: function( $currentItem ) {
            if ( $currentItem.hasClass( 'tm-layout-top-reveal' ) ) {
                var $text      = $currentItem.find( '.text-paragraph' ),
                    $button    = $currentItem.find( '.btn-view-details' ),
                    textHeight = $text.outerHeight( true );
                $button.css(
                    'transform',
                    'translateY(-' + textHeight + 'px) translateZ(0)'
                );
                setTimeout(
                    function () {
                        $currentItem.addClass( 'mascot--visible' );
                    },
                    400
                );
            }
        },
    };





    $( document ).ready(
        function () {
            mascotBannerFromBottom.init();
        }
    );

    var mascotBannerFromBottom = {
        init: function () {
            this.holder = $( '.tm-sc-info-banner-advanced' );

            if ( this.holder.length ) {
                this.holder.each(
                    function () {
                        mascotBannerFromBottom.initItem( $( this ) );
                    }
                );
            }
        },
        initItem: function ( $currentItem ) {
            if ( $currentItem.hasClass( 'tm-layout-bottom' ) ) {
                var $text      = $currentItem.find( '.content-holder' ),
                    $content   = $currentItem.find( '.info-banner-text-holder-inner' ),
                    textHeight = $text.outerHeight( true );

                $content.css(
                    'transform',
                    'translateY(' + textHeight + 'px) translateZ(0)'
                );
                setTimeout(
                    function () {
                        $currentItem.addClass( 'mascot--visible' );
                    },
                    400
                );
            }
        },
    };
})(jQuery);
