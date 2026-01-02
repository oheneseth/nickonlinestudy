<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

?>
<div class="col-sm-12 col-lg-3 col-md-4 col-12">
    <aside class="sidebar-widget-area">
		<?php
		if ( is_singular( 'lp_course' ) && RDTheme_Helper::is_LMS() ) {
			learn_press_get_template( 'custom/content-course-sidebar.php' );
		} elseif ( is_post_type_archive( 'lp_course' ) && RDTheme_Helper::is_LMS() && is_active_sidebar( 'archive-courses-sidebar' ) ) {
			learn_press_get_template( 'custom/lms-archive-sidebar.php' );
		} else {
			if ( RDTheme::$sidebar ) {
				if ( is_active_sidebar( RDTheme::$sidebar ) ) {
					dynamic_sidebar( RDTheme::$sidebar );
				}
			} else {
				if ( is_active_sidebar( 'sidebar' ) ) {
					dynamic_sidebar( 'sidebar' );
				}
			}
		}
		?>
    </aside>
</div>