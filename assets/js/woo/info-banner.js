(function ($) {
    'use strict';


    $( document ).ready(
        function () {
            shadhinBannerReveal.init();
        }
    );

    var shadhinBannerReveal = {
        init: function () {
            this.holder = $( '.mh-sc-info-banner-advanced' );

            if ( this.holder.length ) {
                this.holder.each(
                    function () {
                        shadhinBannerReveal.initItem( $( this ) );
                    }
                );
            }
        },
        initItem: function( $currentItem ) {
            if ( $currentItem.hasClass( 'mh-layout-top-reveal' ) ) {
                var $text      = $currentItem.find( '.text-paragraph' ),
                    $button    = $currentItem.find( '.btn-view-details' ),
                    textHeight = $text.outerHeight( true );
                $button.css(
                    'transform',
                    'translateY(-' + textHeight + 'px) translateZ(0)'
                );
                setTimeout(
                    function () {
                        $currentItem.addClass( 'shadhin--visible' );
                    },
                    400
                );
            }
        },
    };





    $( document ).ready(
        function () {
            shadhinBannerFromBottom.init();
        }
    );

    var shadhinBannerFromBottom = {
        init: function () {
            this.holder = $( '.mh-sc-info-banner-advanced' );

            if ( this.holder.length ) {
                this.holder.each(
                    function () {
                        shadhinBannerFromBottom.initItem( $( this ) );
                    }
                );
            }
        },
        initItem: function ( $currentItem ) {
            if ( $currentItem.hasClass( 'mh-layout-bottom' ) ) {
                var $text      = $currentItem.find( '.content-holder' ),
                    $content   = $currentItem.find( '.info-banner-text-holder-inner' ),
                    textHeight = $text.outerHeight( true );

                $content.css(
                    'transform',
                    'translateY(' + textHeight + 'px) translateZ(0)'
                );
                setTimeout(
                    function () {
                        $currentItem.addClass( 'shadhin--visible' );
                    },
                    400
                );
            }
        },
    };
})(jQuery);
