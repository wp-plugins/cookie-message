<?php
/**
 * Plugin Name: Cookie Message
 * Plugin URI: http://www.wp-load.com
 * Description: Add a cookie message to your website.
 * Version: 1.2
 * Author: Jenst
 * Author URI: http://www.jenst.se
 * License: GPL2
 */

include 'register-settings-api.php';
include 'settings-array.php';

$cookie_message = new CookieMessage();

class CookieMessage {
	public $options;

	function __construct() {
		$this->options = get_option('cookie_message');

		add_action( 'wp_head', array( $this, 'inline' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_footer', array( $this, 'render_footer' ) );
		add_action( 'admin_init', array( $this, 'save_css' ) );
	}

	function render_footer() {
		$message = ( ! empty( $this->options['message'] ) ) ? $this->options['message'] : '';
		$accept_html = ( ! empty( $this->options['accept-text'] ) ) ? '<span class="cm-accept">' . $this->options['accept-text'] . '</span>' : '';
		$html = '
		<div class="cm-message">
			<div class="cm-button-wrap">
				<div class="cm-button">
					<div class="icono-check"></div>
					' . $accept_html . '
				</div>
			</div>
			<div class="cm-text">' . $message . '</div>
		</div>';
		$cookie_message_shortcode = '';

		/* Page replacement */
		$page_id = ( ! empty( $this->options['page-id'] ) ) ? $this->options['page-id'] : 0;
		if( ! empty( $page_id ) ) {
			$page_obj = get_post($page_id);
			$permalink = get_permalink($page_id);
			$page_text = ( ! empty( $this->options['page-text'] ) ) ? $this->options['page-text'] : $page_obj->post_title;
			$cookie_message_shortcode = '<a href="' . $permalink . '">' . $page_text . '</a>';
		}
		$html = str_replace( '[page]', $cookie_message_shortcode, $html );
		echo $html;
	}

	function scripts() {
		if( empty( $this->options['enable_css'] ) ) {
			$dir = plugin_dir_path( __FILE__ );
			if( file_exists( $dir . 'css/generated.css') ) {
				$timestamp = ( is_user_logged_in() ) ? '?timestamp=' . time() : '';
		 		wp_register_style( 'cookie_message_style', plugins_url( '/css/generated.css' . $timestamp, __FILE__) );
		 	} else {
		 		wp_register_style( 'cookie_message_style', plugins_url( '/css/style.css', __FILE__) );
		 	}
		 	wp_enqueue_style( 'cookie_message_style' );
		 }
		 if( empty( $this->options['enable_js'] ) ) {
		 	wp_enqueue_script( 'cookie_message_script', plugins_url( '/js/custom.js', __FILE__), array('jquery'), '1.0.0', true );
		 }
	}

	function inline() {
		if( ! empty( $this->options['enable_css'] ) && $this->options['enable_css'] == 'inline' ) {
			$this->inline_css();
		}
		if( empty( $this->options['enable_js'] ) ) {
			$this->inline_script();
		}
	}

	function inline_css() { ?>
		<style>
			<?php echo $this->generated_css(); ?>
		</style>
		<?php
	}

	function inline_script() {
		$o = $this->options;
		$expire = ( ! empty( $this->options['expire'] ) ) ? 'expire: "' . $this->options['expire'] . '",' : '';
		$test_mode = ( is_user_logged_in() && ! empty( $this->options['logged-in'] ) ) ? 'logged_in: "' . $this->options['logged-in'] . '"' : '';
		?>
		<script>
			jQuery(window).load(function($) {
				cookie_message({
					<?php echo $expire; ?>
					<?php echo $test_mode; ?>
				});
			});
		</script>
		<?php
	}

	function generated_css() {
		$style = '';
		if( ! empty( $this->options ) ) {
			$style_dir = plugin_dir_path( __FILE__ );
			$style_file = $style_dir . 'css/style.css';
			$style_data = file_get_contents( $style_file );
			$shadow_replacement = ( ! empty( $this->options['enable_shadow'] ) ) ? 'box-shadow: 0 -5px 5px 0 rgba(0,0,0,.1);' : '';

			$style = str_replace(
				array(
					'/*** font-family ***/',
					'/*** background ***/',
					'/*** color ***/'
				),
				array(
					"font-family: " . $this->options['font-family'] . ";",
					"background: " . $this->options['background-color'] . ";",
					"color: " . $this->options['text-color'] . ";"
				),
				$style_data
			);
			
			if( ! empty( $this->options['custom_css'] ) ) {
				$style .= "\n" . $this->options['custom_css'];
			}
		}
		return $style;
	}

	function save_css() {
		if( $this->is_writable() ) {
			if( ! empty( $_GET['page'] ) && $_GET['page'] == 'cookie-message' && ! empty( $_GET['settings-updated'] ) ) {
				$style_dir = plugin_dir_path( __FILE__ );
				$style = $this->generated_css();
				file_put_contents($style_dir . 'css/generated.css', $style);
			}
		}
	}

	function is_writable() {
		$dir_path = plugin_dir_path( __FILE__ );
		$dir_path_css = $dir_path . 'css/';
		$generated_path = $dir_path_css . 'generated.css';
		if( file_exists( $generated_path ) && is_writable( $generated_path ) ) {
			$writable = true;
		} elseif( file_exists( $generated_path ) && ! is_writable( $generated_path ) ) {
			$writable = false;
		} elseif( is_writable( $dir_path_css ) ) {
			$writable = true;
		} else {
			$writable = false;
		}
		return $writable;
	}
}