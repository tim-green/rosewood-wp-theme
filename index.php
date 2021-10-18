<?php
/**
 * Template Name: Blog Index
 * Description: The template for displaying the Blog index /blog.
 *
 */

	get_header();

	$page_id = get_option( 'page_for_posts' );
?>
<?php 

$archive_title_elem 	= is_front_page() || ( is_home() && get_option( 'show_on_front' ) == 'posts' ) ? 'h2' : 'h1';
$archive_type 			= rosewood_get_archive_type();
$archive_title 			= get_the_archive_title();
$archive_description 	= get_the_archive_description();

if ( $archive_title || $archive_description ) : 
	?>

	<div class="row">
		
		<div class="col-md-12">
			<?php
				echo nl2br( apply_filters( 'the_content', get_post_field( 'post_content', $page_id ) ) ); // = echo content from Bloghome

				edit_post_link( __( 'Edit', 'my-theme' ), '<span class="edit-link">', '</span>', $page_id );
			?>
		</div><!-- /.col -->

		<div class="col-md-12">
			<?php
				get_template_part( 'archive', 'loop' );
			?>
		</div><!-- /.col -->
		
	</div><!-- /.row -->

<?php get_footer(); ?>
		<?php if ( $archive_type ) : ?>
			<h4 class="page-subtitle"><?php echo wp_kses_post( $archive_type ); ?></h4>
		<?php endif; ?>

		<?php if ( $archive_title ) : ?>
			<<?php echo $archive_title_elem; ?> class="page-title"><?php echo wp_kses_post( $archive_title ); ?></<?php echo $archive_title_elem; ?>>
		<?php endif; ?>

		<?php if ( $archive_description ) : ?>
			<div class="page-description">
				<?php echo wpautop( wp_kses_post( $archive_description ) ); ?>
			</div>
		<?php endif; ?>
