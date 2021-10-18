<?php
/**
 * The template for displaying search forms
 */
?><?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo $unique_id; ?>"><?php _e( 'Search for:', 'rosewood' ); ?></label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php esc_attr_e( 'Enter your search query',  'rosewood' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" autocomplete="off" />
	</button>
</form>
