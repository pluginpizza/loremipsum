<?php
/**
 * Author URI:        https://plugin.pizza/
 * Author:            Plugin Pizza
 * Description:       Lorem ipsum autocomplete for the block editor.
 * Domain Path:       /languages
 * License:           GPLv3+
 * Plugin Name:       Loremipsum
 * Plugin URI:        https://github.com/pluginpizza/loremipsum/
 * Text Domain:       loremipsum
 * Version:           1.0.0
 * Requires PHP:      5.3.0
 * Requires at least: 4.6.0
 * GitHub Plugin URI: pluginpizza/loremipsum
 *
 * @package PluginPizza\LoremIpsum
 */

namespace PluginPizza\LoremIpsum;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Add the inline script.
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_script', 99 );

// Maybe serve a placeholder image.
add_action( 'init', __NAMESPACE__ . '\handle_image_request' );

/**
 * Add the inline script.
 *
 * @return void
 */
function enqueue_script() {

	wp_enqueue_script(
		'loremipsum',
		plugin_dir_url( __FILE__ ) . 'autocompleter.js',
		array(),
		'1.0.0',
		true
	);

	$i18n = get_script_variables();

	wp_localize_script(
		'loremipsum',
		'PluginPizzaLoremIpsum',
		$i18n,
	);
}

/**
 * Returns the script that sets the PluginPizzaLoremIpsum global variable.
 *
 * @return string
 */
function get_script_variables() {

	global $content_width;

	if ( empty( $content_width ) ) {
		$content_width = 640;
	}

	$vars = array(
		'svg'          => esc_url( add_query_arg( 'loremipsum', 'svg', home_url() ) ),
		'contentWidth' => absint( $content_width ),
		'headings'     => array(
			'short'  => array(
				'Lorem ipsum dolor sit amet',
				'Suspendisse id arcu imperdiet',
				'Mauris convallis eleifend ante',
				'Donec eleifend purus accumsan',
				'Fusce venenatis libero feugiat',
			),
			'medium' => array(
				'Aliquam facilisis urna a semper vulputate duis lacus neque eleifend',
				'Pellentesque habitant morbi tristique senectus et netus et malesuada fames',
				'Maecenas nunc massa pellentesque sit amet metus et vehicula interdum orci',
				'Nam lobortis ullamcorper posuere vivamus dictum lacus non libero cursus',
				'Pellentesque suscipit varius sapien a sodales nam turpis dui pretium turpis',
			),
			'long'   => array(
				'Nulla efficitur imperdiet metus a pharetra ipsum auctor vulputate mauris lobortis lorem felis, eu vulputate velit convallis non',
				'Ut ullamcorper nunc est varius sollicitudin erat venenatis sit amet pharetra elementum purus, id euismod est rhoncus ac',
				'Curabitur eget imperdiet ante, at vehicula enim mauris congue enim ac finibus dignissim placerat risus sit amet magna molestie',
				'Maecenas ac tellus eget tellus venenatis elementum ac ac tellus mauris et luctus mi nulla vehicula odio tristique pellentesque viverra',
				'Morbi leo tellus, imperdiet eget enim ut suscipit pretium dolor donec non pretium arcu nunc ultrices volutpat tincidunt curabitur egestas',
			),
		),
		'heading'      => array(
			'Phasellus ac Arcu Semper Lobortis',
			'Nam at Augue Tempor in Condimentum Dolor',
			'Mauris Lacinia Mauris et Gravida Imperdiet',
			'Duis Vitae Lorem ut Eros Rutrum ac Tempus',
			'Proin at Metus vel Neque Feugiat Interdum',
			'Curabitur Euismod Nibh ac Risus Porta',
			'Donec Donvallis Magna Eget',
			'Maecenas Euismod Risus',
			'Non Ipsum Eget ut Velit Eleifend Ornare',
			'Phasellus ex Nisl et Euismod Cursus',
		),
		'sentence'     => array(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'Nunc eu enim maximus neque ornare ornare et non lacus.',
			'Nam bibendum turpis quis odio faucibus faucibus.',
			'Nam rutrum tortor eu purus varius, ut consequat augue mattis.',
			'Curabitur efficitur urna pellentesque, tempor mauris nec, vehicula erat.',
			'Donec malesuada dolor ut urna vehicula at scelerisque tellus iaculis.',
			'Cras pulvinar nunc eget libero auctor, sed malesuada quam feugiat.',
			'Etiam ultrices tellus nec nisi sollicitudin faucibus rhoncus ligula aliquet.',
			'Suspendisse sit amet magna vel mi venenatis vehicula sed iaculis arcu.',
			'Nullam accumsan arcu at sapien tristique, at suscipit neque ullamcorper.',
		),
		'paragraph'    => array(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim est, lacinia ut risus lobortis, posuere pulvinar tortor. Etiam mollis in erat vitae egestas. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum efficitur tortor ante, nec congue leo dictum id. Ut ornare rhoncus rhoncus. Praesent tristique tempor justo ac efficitur. Nulla quis neque vulputate, scelerisque quam eu, ornare diam. Quisque tincidunt accumsan eleifend. Nam porttitor ante et massa scelerisque, at luctus justo pharetra. Fusce nec maximus magna. Mauris vehicula tortor in justo ornare, nec tempus eros blandit.',
			'Duis tincidunt non magna ut lacinia. Quisque vitae metus turpis. Phasellus non lorem in lacus facilisis maximus sit amet a nibh. Sed sed varius tortor. Duis a molestie diam. Vivamus ac metus maximus, consequat enim ac, faucibus nulla. Aenean faucibus tortor ac ante sodales, sed tristique sapien varius.',
			'Praesent semper nisi nec congue porttitor. Donec ullamcorper sodales erat. Duis pellentesque elit orci, tempus pulvinar metus tincidunt ut. Cras dignissim sagittis neque, vitae hendrerit ante vehicula eu. Integer vehicula fermentum pulvinar. Duis commodo hendrerit velit a consectetur. Sed accumsan nulla mauris, a sodales libero porta sed. Pellentesque iaculis mauris dui, nec pulvinar enim porta vitae. Ut vel maximus dui, non finibus nulla. Donec non tortor sed erat lobortis viverra vitae interdum diam. Quisque vel ultricies sapien, non lobortis ligula. Duis pellentesque justo ac quam consequat, sit amet dignissim metus vehicula.',
			'Nulla rutrum tincidunt hendrerit. Maecenas consectetur massa nec nibh scelerisque, ut sollicitudin ante finibus. Nunc quis magna sit amet velit lacinia imperdiet. Aenean interdum ut lacus eget molestie. Donec quis bibendum felis. Curabitur lacinia arcu rhoncus, efficitur velit et, dignissim sapien. Vivamus vestibulum nisi iaculis porta laoreet.',
			'Suspendisse a interdum metus, et laoreet est. Cras sed accumsan odio. Aenean porta nulla quis metus pulvinar imperdiet. Pellentesque et finibus enim. Nullam id nulla ac risus vulputate iaculis. Nunc porttitor volutpat mi a malesuada. Sed tincidunt sapien lobortis, molestie justo ut, placerat dui. Quisque ornare, justo id viverra imperdiet, orci lorem ultricies dolor, in pretium ipsum sapien eu est. Etiam viverra lectus orci, in sollicitudin turpis molestie laoreet. Integer et vestibulum eros.',
			'Morbi gravida porttitor elementum. Ut venenatis urna vitae elementum pulvinar. Vivamus egestas luctus neque, eu fermentum sem sollicitudin dictum. Integer at volutpat leo, a imperdiet nibh. Donec sodales quam et pulvinar fermentum. Quisque auctor sagittis pretium. Aliquam laoreet mauris at ante viverra, in dictum risus imperdiet. Fusce et dignissim est. Integer euismod viverra euismod. Sed congue nulla eu consequat fringilla. Aenean fringilla libero eu orci volutpat pulvinar. Maecenas efficitur varius rhoncus. Fusce vitae sem sed odio blandit lacinia vel ut neque. Vivamus ex nunc, sagittis eget enim non, facilisis lobortis orci.',
			'Quisque ornare elementum mi dapibus elementum. Nam hendrerit sem quis facilisis convallis. Vestibulum nulla est, dignissim elementum lacus ut, porttitor venenatis turpis. Ut lobortis ex magna, id bibendum lectus laoreet quis. Morbi quis neque at urna aliquam suscipit. Sed quis rutrum arcu. Fusce scelerisque at tortor quis aliquet. Nam gravida eget sem in pulvinar. Integer rutrum vehicula diam, quis malesuada eros blandit nec. Cras faucibus non nulla aliquam volutpat. Fusce efficitur iaculis consectetur.',
			'Praesent rhoncus orci a libero convallis tincidunt. Ut vitae arcu tincidunt, tristique eros quis, suscipit tortor. Donec varius sollicitudin ante, eget porta nulla blandit vitae. Suspendisse a enim quis ante condimentum tristique vel ut nisl. Cras velit mi, maximus ac orci non, dignissim iaculis ante. Pellentesque sed augue vitae erat condimentum varius vel sit amet enim. Etiam in scelerisque nisi, non luctus est. Suspendisse consectetur interdum est, id bibendum nunc suscipit non. Proin bibendum condimentum mi, eu tristique diam ornare ut. Donec a ultrices felis. Nunc fermentum dictum nulla et mattis. Etiam sit amet porta ligula.',
			'Donec dictum ligula mi, eget auctor augue placerat at. Fusce sit amet sem placerat, placerat quam suscipit, faucibus tellus. Duis sodales egestas ipsum, sed malesuada leo consectetur sed. Aenean sit amet lacinia tortor. Suspendisse nunc sapien, auctor sit amet finibus vel, dignissim ac purus. Morbi in sagittis libero, at gravida tellus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras non eros sed lacus mattis varius ut id magna.',
		),
		'completers'   => array(
			'default' => array(
				'options' => array(
					array(
						'id'    => 1,
						'name'  => __( 'Paragraph', 'loremipsum' ),
						'value' => 'paragraph',
						'icon'  => 'm9.99609 14v-.2251l.00391.0001v6.225h1.5v-14.5h2.5v14.5h1.5v-14.5h3v-1.5h-8.50391c-2.76142 0-5 2.23858-5 5 0 2.7614 2.23858 5 5 5z',
					),
					array(
						'id'    => 1,
						'name'  => __( 'Sentence', 'loremipsum' ),
						'value' => 'sentence',
						'icon'  => 'M12.9 6h-2l-4 11h1.9l1.1-3h4.2l1.1 3h1.9L12.9 6zm-2.5 6.5l1.5-4.9 1.7 4.9h-3.2z',
					),
					array(
						'id'    => 2,
						'name'  => __( 'Heading 2', 'loremipsum' ),
						'value' => 'heading',
						'level' => 2,
						'icon'  => 'M9 11.1H5v-4H3v10h2v-4h4v4h2v-10H9v4zm8 4c.5-.4.6-.6 1.1-1.1.4-.4.8-.8 1.2-1.3.3-.4.6-.8.9-1.3.2-.4.3-.8.3-1.3 0-.4-.1-.9-.3-1.3-.2-.4-.4-.7-.8-1-.3-.3-.7-.5-1.2-.6-.5-.2-1-.2-1.5-.2-.4 0-.7 0-1.1.1-.3.1-.7.2-1 .3-.3.1-.6.3-.9.5-.3.2-.6.4-.8.7l1.2 1.2c.3-.3.6-.5 1-.7.4-.2.7-.3 1.2-.3s.9.1 1.3.4c.3.3.5.7.5 1.1 0 .4-.1.8-.4 1.1-.3.5-.6.9-1 1.2-.4.4-1 .9-1.6 1.4-.6.5-1.4 1.1-2.2 1.6v1.5h8v-2H17z',
					),
					array(
						'id'    => 3,
						'name'  => __( 'Heading 3', 'loremipsum' ),
						'value' => 'heading',
						'level' => 3,
						'icon'  => 'M9 11H5V7H3v10h2v-4h4v4h2V7H9v4zm11.3 1.7c-.4-.4-1-.7-1.6-.8v-.1c.6-.2 1.1-.5 1.5-.9.3-.4.5-.8.5-1.3 0-.4-.1-.8-.3-1.1-.2-.3-.5-.6-.8-.8-.4-.2-.8-.4-1.2-.5-.6-.1-1.1-.2-1.6-.2-.6 0-1.3.1-1.8.3s-1.1.5-1.6.9l1.2 1.4c.4-.2.7-.4 1.1-.6.3-.2.7-.3 1.1-.3.4 0 .8.1 1.1.3.3.2.4.5.4.8 0 .4-.2.7-.6.9-.7.3-1.5.5-2.2.4v1.6c.5 0 1 0 1.5.1.3.1.7.2 1 .3.2.1.4.2.5.4s.1.4.1.6c0 .3-.2.7-.5.8-.4.2-.9.3-1.4.3s-1-.1-1.4-.3c-.4-.2-.8-.4-1.2-.7L13 15.6c.5.4 1 .8 1.6 1 .7.3 1.5.4 2.3.4.6 0 1.1-.1 1.6-.2.4-.1.9-.2 1.3-.5.4-.2.7-.5.9-.9.2-.4.3-.8.3-1.2 0-.6-.3-1.1-.7-1.5z',
					),
					array(
						'id'    => 4,
						'name'  => __( 'Heading 4', 'loremipsum' ),
						'value' => 'heading',
						'level' => 4,
						'icon'  => 'M20 13V7h-3l-4 6v2h5v2h2v-2h1v-2h-1zm-2 0h-2.8L18 9v4zm-9-2H5V7H3v10h2v-4h4v4h2V7H9v4z',
					),
					array(
						'id'          => 3,
						'name'        => __( 'Image (Landscape)', 'loremipsum' ),
						'value'       => 'image',
						'orientation' => 'landscape',
						'icon'        => 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 4.5h14c.3 0 .5.2.5.5v8.4l-3-2.9c-.3-.3-.8-.3-1 0L11.9 14 9 12c-.3-.2-.6-.2-.8 0l-3.6 2.6V5c-.1-.3.1-.5.4-.5zm14 15H5c-.3 0-.5-.2-.5-.5v-2.4l4.1-3 3 1.9c.3.2.7.2.9-.1L16 12l3.5 3.4V19c0 .3-.2.5-.5.5z',
					),
					array(
						'id'          => 3,
						'name'        => __( 'Image (Portrait)', 'loremipsum' ),
						'value'       => 'image',
						'orientation' => 'portrait',
						'icon'        => 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 4.5h14c.3 0 .5.2.5.5v8.4l-3-2.9c-.3-.3-.8-.3-1 0L11.9 14 9 12c-.3-.2-.6-.2-.8 0l-3.6 2.6V5c-.1-.3.1-.5.4-.5zm14 15H5c-.3 0-.5-.2-.5-.5v-2.4l4.1-3 3 1.9c.3.2.7.2.9-.1L16 12l3.5 3.4V19c0 .3-.2.5-.5.5z',
					),
					array(
						'id'          => 3,
						'name'        => __( 'Image (Square)', 'loremipsum' ),
						'value'       => 'image',
						'orientation' => 'square',
						'icon'        => 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 4.5h14c.3 0 .5.2.5.5v8.4l-3-2.9c-.3-.3-.8-.3-1 0L11.9 14 9 12c-.3-.2-.6-.2-.8 0l-3.6 2.6V5c-.1-.3.1-.5.4-.5zm14 15H5c-.3 0-.5-.2-.5-.5v-2.4l4.1-3 3 1.9c.3.2.7.2.9-.1L16 12l3.5 3.4V19c0 .3-.2.5-.5.5z',
					),
				),
			),
			'heading' => array(
				'options' => array(
					array(
						'id'    => 1,
						'name'  => __( 'Short', 'loremipsum' ),
						'value' => 'short',
						'icon'  => 'M6 5V18.5911L12 13.8473L18 18.5911V5H6Z',
					),
					array(
						'id'    => 2,
						'name'  => __( 'Medium', 'loremipsum' ),
						'value' => 'medium',
						'icon'  => 'M6 5V18.5911L12 13.8473L18 18.5911V5H6Z',
					),
					array(
						'id'    => 3,
						'name'  => __( 'Long', 'loremipsum' ),
						'value' => 'long',
						'icon'  => 'M6 5V18.5911L12 13.8473L18 18.5911V5H6Z',
					),
				),
			),
		),
	);

	/**
	 * Allows filtering the lorem ipsum variables array.
	 *
	 * @var array
	 */
	$vars = apply_filters( 'pluginpizza_loremipsum_options', $vars );

	return $vars;
}

/**
 * Maybe serve a placeholder image.
 *
 * @return void|string
 */
function handle_image_request() {

	if ( ! $_SERVER || empty( $_SERVER['REQUEST_METHOD'] ) ) {
		return;
	}

	if ( 'GET' !== $_SERVER['REQUEST_METHOD'] ) {
		return;
	}

	// phpcs:disable WordPress.Security.NonceVerification.Recommended

	if ( ! isset( $_GET['loremipsum'] ) ) {
		return;
	}

	global $content_width;

	$width  = empty( $content_width ) ? 640 : $content_width;
	$width  = empty( $_GET['w'] ) ? $width : absint( $_GET['w'] );
	$height = ceil( $content_width / 4 * 3 );
	$height = empty( $_GET['h'] ) ? $height : absint( $_GET['h'] );

	// phpcs:enable WordPress.Security.NonceVerification.Recommended

	header( 'Content-Type: image/svg+xml' );

	printf(
		'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%2$d" viewBox="0 0 %1$d %2$d" preserveAspectRatio="meet" aria-hidden="true" focusable="false"><rect width="100%%" height="100%%" fill="#000" opacity="0.1" /><path vector-effect="non-scaling-stroke" d="M%1$d %2$d 0 0" stroke="currentColor" opacity="0.25"></path></svg>',
		absint( $width ),
		absint( $height )
	);

	exit;
}
