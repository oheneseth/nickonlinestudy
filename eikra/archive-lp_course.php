<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

// Layout class
if ( RDTheme::$layout == 'full-width' ) {
	$rdtheme_layout_class           = 'col-sm-12 col-12';
	$rdtheme_course_container_class = 'col-lg-3 col-md-3 col-sm-3 col-12';
} else {
	$rdtheme_layout_class           = 'col-sm-12 col-md-8 col-lg-9 col-12';
	$rdtheme_course_container_class = 'col-lg-4 col-md-4 col-sm-4 col-12';
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
                <div class="<?php echo esc_attr( $rdtheme_layout_class ); ?>">
                    <main id="main" class="site-main">
                        <div class="rt-course-archive-top">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="rtin-left">
                                        <div class="rtin-icons">
                                            <a href="#" class="rtin-grid"><i class="fas fa-th-large"></i></a>
                                            <a href="#" class="rtin-list"><i class="fas fa-list-ul"></i></a>
                                        </div>
                                        <div class="rtin-text"><?php RDTheme_Helper::course_indexing_text( $wp_query->found_posts ); ?></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="rtin-search">
                                        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lp_course' ) ); ?>">
                                            <input type="hidden" name="ref" value="course">
											<?php if ( RDTheme::$options['course_archive_cat_filter'] ) : ?>
												<?php $course_cat = RDTheme_Helper::rt_get_term_lit( 'course_category', 'slug' ); ?>
                                                <select name='course_category' id='category-dropdown'>
                                                    <option value=""><?php _e( 'Category', 'eikra' ); ?></option>
													<?php
													foreach ( $course_cat as $slug => $cat ) {
														$selected = null;
														if ( isset( $_GET['course_category'] ) && $_GET['course_category'] == $slug ) {
															$selected = " selected";
														}
														echo "<option value='" . esc_attr( $slug ) . "' {$selected}>" . esc_html__( $cat, 'text-domain' ) . "</option>";
													}
													?>
                                                </select>
											<?php endif; ?>
                                            <input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s"
                                                   placeholder="<?php esc_attr_e( 'Search our courses', 'eikra' ) ?>" class="form-control"/>
                                            <button type="submit"><i class="fas fa-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php if ( have_posts() ) : ?>
                            <div class="row auto-clear">
								<?php while ( have_posts() ) : the_post(); ?>
                                    <div class="rtin-main-cols <?php echo esc_attr( $rdtheme_course_container_class ); ?>">
										<?php get_template_part( 'template-parts/content', 'course-box' ); ?>
                                    </div>
								<?php endwhile; ?>
                            </div>
                            <div class="mt30"><?php RDTheme_Helper::pagination(); ?></div>
						<?php endif; ?>
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