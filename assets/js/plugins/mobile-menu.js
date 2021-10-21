//Mobile Menu


WP.mobileMenu = {
	init: function(){

		// Toggle navigation
		$( '.nav-toggle' ).on( 'click', function(){
			$( this ).toggleClass( 'active' );
			$( '.mobile-menu-wrapper' ).slideToggle().toggleClass( 'visible' );
			$( 'body' ).toggleClass( 'mobile-menu-visible lock-scroll' );
			$( '.mobile-search, .toggle-mobile-search' ).removeClass( 'active' );
		} );

		// Hide navigation on resize
		$( window ).on( 'resize', function(){
			var winWidth = $( window ).width();
			if ( winWidth > 1000 ) {
				$( 'body' ).removeClass( 'mobile-menu-visible lock-scroll' );
				$( '.mobile-menu-wrapper' ).hide().removeClass( 'visible' );
				$( '.nav-toggle' ).removeClass( 'active' );
				$( '.mobile-search' ).removeClass( 'active hide' );

				// Empty the mobile search results
				WP.ajaxSearch.emptyResults();
			}
		} );

	},

} 
