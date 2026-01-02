<?php

/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</div><!-- #content -->
<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	get_template_part( 'template-parts/footer/footer', RDTheme::$footer_style );
}
?>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>