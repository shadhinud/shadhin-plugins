jQuery( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope, $ ) {
		/*setTimeout(function(){
			mh_rearrange_stretched_col( $scope.data('id') );
			mh_bgimage_class();
			mh_bgcolor_class();
		}, 200);*/
		mh_stretched_col();
		mh_stretched_col_calc();
		mh_bgimage_class();
		mh_bgcolor_class();
		setTimeout(function() {
			mh_stretched_col_calc();
		}, 100);
	} );
} );

