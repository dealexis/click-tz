<?php

add_action( 'init', function () {
	register_taxonomy( 'genre', [ 'movie' ], [
		'labels'       => [
			'name'          => esc_html__( 'Genres', 'test' ),
			'singular_name' => esc_html__( 'Genre', 'test' ),
		],
		'hierarchical' => true,
	] );

	register_taxonomy( 'country', [ 'movie' ], [

		'labels'       => [
			'name'          => esc_html__( 'Countries', 'test' ),
			'singular_name' => esc_html__( 'Country', 'test' ),
		],
		'hierarchical' => true,
	] );

	register_taxonomy( 'year', [ 'movie' ], [

		'labels'       => [
			'name'          => esc_html__( 'Years', 'test' ),
			'singular_name' => esc_html__( 'Year', 'test' ),
		],
		'hierarchical' => false,
		'meta_box_cb'  => 'post_categories_meta_box',
	] );

	register_taxonomy( 'actor', [ 'movie' ], [
		'label'        => '',
		'labels'       => [
			'name'          => esc_html__( 'Actors', 'test' ),
			'singular_name' => esc_html__( 'Actor', 'test' ),
		],
		'hierarchical' => false,
		'meta_box_cb'  => 'post_categories_meta_box',
	] );
} );