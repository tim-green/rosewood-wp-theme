<?php 

//add google analytics to site

function add_google_site_tag() {
	
	if ( get_site_url() !== '' ) {
		return;
	}

	?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php the_field('ga-tag','option'); ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'the_field('ga-tag','options')');
	</script>
	<?php
}
add_action( 'wp_head', 'add_google_site_tag', -10 );