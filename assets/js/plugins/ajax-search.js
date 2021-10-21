//AJAX Search
WP.ajaxSearch = {

	init: function(){

		// Delay function
		var delay = ( function(){
			var timer = 0;
			return function( callback, ms ) {
				clearTimeout( timer );
				timer = setTimeout( callback, ms );
			}
		} )();

		// Update results on keyup, after delay
		$( '.mobile-search .search-field' ).keyup( function() {
			if ( $( this ).val().length != 0 ) {
				delay( function(){
					WP.ajaxSearch.loadPosts();
				}, 200 );
			} else {
				delay( function(){
					WP.ajaxSearch.emptyResults();
				}, 50 );
			}
		} );

		delay( function(){
			WP.ajaxSearch.emptyResults();
		}, 50 );

		// Check for empty on blur
		$( '.mobile-search .search-field' ).blur( function() {
			if ( $( this ).val().length == 0 ) {
				WP.ajaxSearch.emptyResults();
			}
		} );

	},

	loadPosts: function(){

		var $container = $( '.mobile-results .results-wrapper' ),
			data = $( '.mobile-search .search-field' ).val();

		search_string = JSON.stringify( data );

		$.ajax({
			url: mcluhan_ajaxpagination.ajaxurl,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_data: search_string
			},

			beforeSend: function() {
				$( '.mobile-results' ).addClass( 'loading' );
			},

			success: function( result ) {

				// Append the results
				$container.empty().append( $( result ) );
				$( '.mobile-results' ).addClass( 'searching' );

				// We don't have results
				if ( result.indexOf( 'no-results-message' ) >= 0 ) {
					$( '.mobile-results' ).addClass( 'no-results' );

				// We have results
				} else {
					$( '.mobile-results' ).removeClass( 'no-results' );
				}

			},

			complete: function() {
				// We're no longer loading
			},

			error: function( jqXHR, textStatus, errorThrown ) {
				console.log( 'AJAX error: ' + errorThrown );
			}
		});

	},

	emptyResults: function(){
		$( '.mobile-results .results-wrapper' ).empty();
		$( '.mobile-results' ).removeClass( 'no-results searching' );
		$( '.mobile-search .search-field' ).val( '' );
	}

} 