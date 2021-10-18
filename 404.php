<?php
/**
 * The Template for displaying Archive pages.
 */

	get_header();
?>
<div class="section-inner">

<header class="page-header section-inner">

    <h4 class="page-subtitle"><?php _e( 'Error 404', 'rosewood' ); ?></h4>
    <h1 class="page-title"><?php _e( 'Page Not Found', 'rosewood' ); ?></h1>

</header><!-- .page-header -->

<div class="section-inner">

    <?php /* Translators: %s = link to the start page */ ?>
    <p class="excerpt"><?php printf( _x( "Hello, the thing you are looking for might have been either renamed, deleted, or didn't even exist in the first place. You can return to the %s or search for the content through the form below.", 'Translators: %s = link to the start page', 'rosewood' ), '<a href="' . esc_url( home_url() ) . '">' . __( 'start page', 'rosewood' ) . '</a>' ); ?></p>

    <?php get_search_form(); ?>

</div><!-- .section-inner -->

</div><!-- .post -->

<?php get_footer(); ?>