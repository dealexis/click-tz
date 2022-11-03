<?php

add_action( 'init', function () {

	register_post_type( 'movie', [
		'label'       => null,
		'labels'      => [
			'name'          => esc_html__( 'Movies', 'test' ),
			'singular_name' => esc_html__( 'Movie', 'test' ),
		],
		'public'      => true,
		'show_ui'     => true,
		'has_archive' => true,
		'menu_icon'   => 'dashicons-format-video'
	] );

} );