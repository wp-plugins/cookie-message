<?php
add_filter('register_settings_api_cookie_message', 'cookie_message_settings');

function cookie_message_settings( $options_page ) {
	/*
	$cookie_message = new CookieMessage();
	$not_writable_message = '';
	if( $cookie_message->is_writable() === false ) {
		if( empty( $cookie_message->options['enable_css'] ) ) {
			
				$not_writable_message = '<div id="message" class="error"><p>Files and folders are not writable. Cannot save the generated CSS.</p>';
				$generated_css = $cookie_message->generated_css();
				if( ! empty( $generated_css ) && ! empty( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) {
					$not_writable_message .= '<p>Copy paste the code below to your theme CSS.</p>';
					$not_writable_message .= '<pre><code>' . $generated_css . '</code></pre>';
				}
			
		}
		$not_writable_message .= '</div>';
	}
	*/
	$page_args = array(
		'post_type' => 'post',
		'posts_per_page' => -1
	);
	$options_page['cookie-message'] = array(
		'menu_title' => 'Cookie Message',
		'page_title' => 'Cookie Message',
		'capability' => 'manage_options',
		'option_name' => 'cookie_message',
		//'before_tabs_text' => $not_writable_message . '<h2>Mobile Navigation</h2>',
		'tabs' => array(
			'message' => array(
				'tab_title' => 'Message',
				'tab_description' => '',
				'fields' => array(
					'message' => array(
						'type' => 'tinymce',
						'title' => 'Message',
						'description' => 'Add your cookie message. Include <code>[page]</code> to add a link to a page.'
					),
					'page-id' => array(
						'type' => 'select',
						'title' => 'Page',
						'description' => 'Link to the page in the message. Optional.',
						'get' => 'posts',
						'args' => $page_args,
						'empty' => 'No page selected'
					),
					'page-text' => array(
						'type' => 'text',
						'title' => 'Page text',
						'description' => 'Text in the page link.'
					),
					'accept-text' => array(
						'type' => 'text',
						'title' => 'Accept text',
						'description' => 'Accept button label text.'
					),
					'expire' => array(
						'type' => 'select',
						'title' => 'Message expiration',
						'description' => 'How long the message will be gone after closing it.',
						'choices' => array(
							'' => 'No expiration',
							'one_day' => '1 day',
							'one_week' => '1 week',
							'one_month' => '1 month',
							'one_year' => '1 year'
						),
					),
				),
			),
			'style' => array(
				'tab_title' => 'Style',
				'tab_description' => '',
				'fields' => array(
					'enable_css' => array(
						'type' => 'select',
						'choices' => array(
							'' => 'File',
							'inline' => 'Inline',
							'inactive' => 'Disabled',
						),
						'title' => 'CSS',
						'description' => '<code>File</code> is strongly recomended. Only use <code>Inline</code>if your files are not writable.'
					),
					'background-color' => array(
						'type' => 'colorpicker',
						'title' => 'Background color',
						'description' => 'The background color of your mobile navigation.',
						'default' => '#ffc'
					),
					'text-color' => array(
						'type' => 'colorpicker',
						'title' => 'Text color',
						'description' => 'The background color of your mobile navigation.',
						'default' => '#333'
					),
					'font-family' => array(
						'type' => 'text',
						'title' => 'Font family',
						'description' => 'Font family to be used.'
					),
					'custom_css' => array(
						'type' => 'textarea',
						'title' => 'Custom CSS',
						'size' => 10,
						'description' => 'If CSS is active, it will include the custom CSS in this field.'
					),
				),
			),
			'advanced' => array(
				'fields' => array(
					'enable_js' => array(
						'type' => 'select',
						'choices' => array(
							'' => 'Active',
							'inactive' => 'Inactive',
						),
						'title' => 'Javascript',
						'description' => 'If the JS is not active the menu might not work.'
					),
					'logged-in' => array(
						'type' => 'select',
						'title' => 'Message when logged in',
						'description' => 'Turn on or off the message when user logged in.',
						'choices' => array(
							'' => 'Like not logged in',
							'enabled' => 'Enabled',
							'disabled' => 'Disabled'
						),
					),
				),
			)
		),
	);
	return $options_page;
}