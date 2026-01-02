<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 3.0
 */

// Layout class
if ( RDTheme::$layout == 'full-width' ) {
	$rdtheme_layout_class = 'col-sm-12 col-12';
	$rdtheme_post_class = 'col-lg-4 col-md-4 col-sm-4 col-12';
}
else{
	$rdtheme_layout_class = 'col-sm-12 col-md-8 col-lg-9 col-12';
	$rdtheme_post_class = 'col-lg-6 col-md-6 col-sm-6 col-12';
}

if(isset($_GET['layout']) and $_GET['layout'] == 'style2') {
	RDTheme::$options['blog_style'] = 'style2';
}
?>
<?php get_header(); ?>
<div id="primary" class="content-area">
	<div class="container">
		<div class="row">
			<?php
			if ( RDTheme::$layout == 'left-sidebar' ) {
				get_sidebar();
			}
			?>
			<div class="<?php echo esc_attr( $rdtheme_layout_class );?>">
				<main id="main" class="site-main">
					<?php if ( have_posts() ) :?>
						<?php
						if ( ( is_home() || is_archive() ) && RDTheme::$options['blog_style'] == 'style2' ) {
							echo '<div class="row auto-clear">';
							while ( have_posts() ) : the_post();
								echo '<div class="' . esc_attr( $rdtheme_post_class ). '">';
								get_template_part( 'template-parts/content-2', get_post_format() );
								echo '</div>';
							endwhile;
							echo '</div>';
						}
						else{
							while ( have_posts() ) : the_post();
								get_template_part( 'template-parts/content', get_post_format() );
							endwhile;
						}
						?>
						<?php RDTheme_Helper::pagination();?>
					<?php else:?>
						<?php get_template_part( 'template-parts/content', 'none' );?>
					<?php endif;?>
				</main>					
			</div>
			<?php
			if ( RDTheme::$layout == 'right-sidebar' ) {
				get_sidebar();
			}
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>