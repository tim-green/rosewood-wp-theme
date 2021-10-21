//Search Toggle

WP.searchToggle = {

	init: function(){

		// Toggle desktop search
		$( 'a[href$="?s="]' ).on( 'click', function(){
			$( this ).toggleClass( 'active' );
			$( '.search-overlay' ).toggleClass( 'active' );
			if ( $( this ).hasClass( 'active' ) ) {
				$( '.search-overlay .search-field' ).focus();
			} else {
				$( '.search-overlay .search-field' ).blur();
			}
			return false;
		} );

		// Untoggle on click outside of form
		$( '.search-overlay' ).click( function( e ){
			console.log( 'log' );
			if ( e.target != this ) return; // only continue if the target itself has been clicked
			$( '.search-overlay .search-field' ).blur();
			$( '.search-overlay' ).removeClass( 'active' );
			$( '.social-menu.desktop a[href$="?s="]' ).removeClass( 'active' );
		} );

		// Toggle mobile search
		$( '.toggle-mobile-search' ).on( 'click', function(){
			$( '.mobile-search' ).removeClass( 'hide' );
			$( '.toggle-mobile-search, .mobile-search' ).toggleClass( 'active' );
			$( '.mobile-search .search-field' ).focus();
			return false;
		} );

		// Untoggle mobile search
		$( '.untoggle-mobile-search' ).on( 'click', function(){
			$( '.mobile-search' ).addClass( 'hide' );
			$( '.mobile-search, .toggle-mobile-search' ).removeClass( 'active' )
			$( '.mobile-search .search-field' ).blur();

			// Empty the results
			WP.ajaxSearch.emptyResults();
			return false;
		} );

	},

}