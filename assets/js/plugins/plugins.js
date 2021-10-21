$( document ).ready( function() {
    // Mobile Menu
	WP.mobileMenu.init();
    // Search Toggles
	WP.searchToggle.init();							
    // Resize
	WP.intrinsicRatioEmbeds.init();					
    // Smooth Scrool
	WP.smoothScroll.init();							
    // AJAX search (on mobile)
	WP.ajaxSearch.init();							
} );