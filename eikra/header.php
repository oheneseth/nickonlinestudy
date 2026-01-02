<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 2.6
 */

?>
    <!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="https://gmpg.org/xfn/11"/>
		<?php wp_head(); ?>
    </head>
<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>
<?php
// Preloader
if ( RDTheme::$options['preloader'] ) {
	// check for learpress popup too
	if ( ! function_exists( 'learn_press_is_content_item_only' ) || ! learn_press_is_content_item_only() ) {
		if ( ! empty( RDTheme::$options['preloader_image']['url'] ) ) {
			$preloader_img = RDTheme::$options['preloader_image']['url'];
		} else {
			$preloader_img = RDTHEME_IMG_URL . 'preloader.gif';
		}
		echo '<div id="preloader" style="background-image:url(' . esc_url( $preloader_img ) . ');"></div>';
	}
}
?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'eikra' ); ?></a>

<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) { ?>
    <header id="masthead" class="site-header">
		<?php
		if ( RDTheme::$top_bar == 1 || RDTheme::$top_bar == 'on' ) {
			get_template_part( 'template-parts/header/header-top', RDTheme::$top_bar_style );
		}
		get_template_part( 'template-parts/header/header', RDTheme::$header_style );
		?>
    </header>

	<?php get_template_part( 'template-parts/header/header', 'offscreen' ); ?>

<?php } ?>
    <div id="content" class="site-content">
<?php get_template_part( 'template-parts/content', 'banner' ); ?>