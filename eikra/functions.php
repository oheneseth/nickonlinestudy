<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 3.8
 */

$rt_licenses = get_option( 'rt_licenses', [] );
$rt_licenses['eikra_license_key'] = 'e2eb9ef2-bc34-8ed2-39b4-ad59974c6f51';
update_option( 'rt_licenses', $rt_licenses );
$rdtheme_theme_data = wp_get_theme( get_template() );
if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
	define( 'EIKRA_VERSION', time() );
} else {
	define( 'EIKRA_VERSION', ( WP_DEBUG ) ? time() : $rdtheme_theme_data->get( 'Version' ) );
}

define( 'RDTHEME_AUTHOR_URI', $rdtheme_theme_data->get( 'AuthorURI' ) );
define( 'RDTHEME_PREFIX', 'eikra' );

// DIR
define( 'RDTHEME_BASE_DIR', get_template_directory() . '/' );
define( 'RDTHEME_INC_DIR', RDTHEME_BASE_DIR . 'inc/' );
define( 'RDTHEME_VIEW_DIR', RDTHEME_INC_DIR . 'views/' );
define( 'RDTHEME_PLUGINS_DIR', RDTHEME_INC_DIR . 'plugins/' );

// URL
define( 'RDTHEME_BASE_URL', get_template_directory_uri() . '/' );
define( 'RDTHEME_ASSETS_URL', RDTHEME_BASE_URL . 'assets/' );
define( 'RDTHEME_CSS_URL', RDTHEME_ASSETS_URL . 'css/' );
define( 'RDTHEME_AUTORTL_URL', RDTHEME_ASSETS_URL . 'css-auto-rtl/' );
define( 'RDTHEME_JS_URL', RDTHEME_ASSETS_URL . 'js/' );
define( 'RDTHEME_IMG_URL', RDTHEME_ASSETS_URL . 'img/' );

// Includes
require_once RDTHEME_INC_DIR . 'helper-functions.php';
RDTheme_Helper::requires( 'class-tgm-plugin-activation.php' );
//RDTheme_Helper::requires( 'utility/utility.php' );
RDTheme_Helper::requires( 'tgm-config.php' );
RDTheme_Helper::requires( 'redux-config.php' );
RDTheme_Helper::requires( 'rdtheme.php' );
RDTheme_Helper::requires( 'general.php' );
RDTheme_Helper::requires( 'scripts.php' );
RDTheme_Helper::requires( 'layout-settings.php' );
RDTheme_Helper::requires( 'sidebar-generator.php' );
RDTheme_Helper::requires( 'vc-settings.php' );

// Learnpress
if ( RDTheme_Helper::lp_is_v3() ) {
	RDTheme_Helper::requires( 'lp-functions.php', 'learnpress/custom/inc' );
	RDTheme_Helper::requires( 'lp-hooks.php', 'learnpress/custom/inc' );
}

// WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
	RDTheme_Helper::requires( 'woo-functions.php' );
	RDTheme_Helper::requires( 'woo-hooks.php' );
}

// Notices
if ( defined( 'EIKRA_CORE' ) ) {
	$notice = false;

	if ( defined( 'EIKRA_CORE_VERSION' ) ) {
		if ( version_compare( EIKRA_CORE_VERSION, '2.4', '<' ) ) {
			$notice = true;
		}
	} else {
		$notice = true;
	}

	if ( $notice ) {
		add_action( 'admin_notices', 'eikra_core_plugin_update_notice', 3 );
	}
}

function eikra_core_plugin_update_notice() {
	$notice = '<div class="error"><p>'
	          . sprintf( __( "Please update plugin <b><i>Eikra Core</b></i> to the latest version otherwise some functionalities will not work properly. You can update it from <a href='%s'>here</a>",
			'eikra' ), menu_page_url( 'eikra-install-plugins', false ) ) . '</p></div>';
	echo wp_kses_post( $notice );
}

//country image meta box for course
add_action( 'add_meta_boxes', 'lp_add_image_meta_box' );
function lp_add_image_meta_box() {
	add_meta_box(
		'lp_flag_image',
		__('Add Country Image', 'eikra'),
		'lp_image_meta_box_callback',
		'lp_course',
		'side',
		'default'
	);
}

function lp_image_meta_box_callback( $post ) {
	wp_nonce_field( 'lp_image_meta_box_nonce', 'lp_image_meta_box_nonce' );
	$image_id = get_post_meta( $post->ID, '_lp_flag_image_id', true );
	$image_url = $image_id ? wp_get_attachment_url( $image_id ) : '';
	?>

	<div class="lp-image-wrapper">
		<img id="lp-image-preview"
		     src="<?php echo esc_url( $image_url ); ?>"
		     style="max-width:100%;<?php echo empty($image_url) ? 'display:none;' : ''; ?>" />
		<input type="hidden" id="lp-image-id" name="lp_image_id" value="<?php echo esc_attr( $image_id ); ?>" />
		<p>
			<button type="button" class="button lp-upload-image">
				<?php esc_html_e('Upload Image', 'eikra'); ?>
			</button>
			<button type="button" class="button lp-remove-image"
			        style="<?php echo empty($image_url) ? 'display:none;' : ''; ?>">
				<?php esc_html_e('Remove', 'eikra'); ?>
			</button>
		</p>
	</div>
	<?php
}

add_action( 'save_post', 'lp_save_image_meta' );
function lp_save_image_meta( $post_id ) {

	if ( ! isset( $_POST['lp_image_meta_box_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['lp_image_meta_box_nonce'], 'lp_image_meta_box_nonce' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	if ( isset( $_POST['lp_image_id'] ) ) {
		update_post_meta( $post_id, '_lp_flag_image_id', intval( $_POST['lp_image_id'] ) );
	}
}

add_action( 'admin_footer', 'lp_image_uploader_js' );
function lp_image_uploader_js() {
	?>
	<script>
        jQuery(document).ready(function($){
            var frame;

            $('.lp-upload-image').on('click', function(e){
                e.preventDefault();

                if ( frame ) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: 'Select Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function(){
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#lp-image-id').val(attachment.id);
                    $('#lp-image-preview').attr('src', attachment.url).show();
                    $('.lp-remove-image').show();
                });

                frame.open();
            });

            $('.lp-remove-image').on('click', function(){
                $('#lp-image-id').val('');
                $('#lp-image-preview').hide();
                $(this).hide();
            });
        });
	</script>
	<?php
}