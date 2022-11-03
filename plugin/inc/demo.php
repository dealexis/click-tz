<?php

function setup_terms(): void {
	$genres    = explode( ', ', 'Action, Adventure, Comedy, Drama, Fantasy, Horror' );
	$actors    = explode( ', ', 'Robert De Niro, Jack Nicholson, Marlon Brando, Denzel Washington, Katharine Hepburn, Humphrey Bogart, Meryl Streep, Daniel Day' );
	$countries = explode( ', ', 'Russia, China, USA, France, Germany' );

	foreach ( $genres as $genre ) {
		if ( is_array( term_exists( sanitize_title( $genre ), 'genre' ) ) ) {
			continue;
		}

		wp_insert_term( $genre, 'genre' );
	}

	foreach ( $actors as $actor ) {
		if ( is_array( term_exists( sanitize_title( $actor ), 'actor' ) ) ) {
			continue;
		}

		wp_insert_term( $actor, 'actor' );
	}

	foreach ( $countries as $country ) {
		if ( is_array( term_exists( sanitize_title( $country ), 'country' ) ) ) {
			continue;
		}

		wp_insert_term( $country, 'country' );
	}

	for ( $year = 1980; $year < 2022; $year ++ ) {
		if ( is_array( term_exists( $year, 'year' ) ) ) {
			continue;
		}

		wp_insert_term( $year, 'year' );
	}
}

function setup_acf(): void {
	if ( function_exists( 'acf_add_local_field_group' ) ):
		acf_add_local_field_group( array(
			'key'                   => 'group_636394eea964c',
			'title'                 => 'Movie',
			'fields'                => array(
				array(
					'key'               => 'field_636394eea7081',
					'label'             => 'Price',
					'name'              => 'cost',
					'aria-label'        => '',
					'type'              => 'number',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'min'               => '',
					'max'               => '',
					'placeholder'       => '',
					'step'              => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_63639e0da7082',
					'label'             => 'Release date',
					'name'              => 'release_date',
					'aria-label'        => '',
					'type'              => 'date_picker',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'display_format'    => 'd/m/Y',
					'return_format'     => 'd/m/Y',
					'first_day'         => 1,
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'movie',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
			'show_in_rest'          => 0,
		) );

	endif;
}

function setup_movies(): void {
	$movies = '2001: A Space Odyssey (1968) Film. Science fiction.
The Godfather (1972) Film. Thrillers.
Citizen Kane (1941) Film.
Jeanne Dielman, 23, Quai du Commerce, 1080 Bruxelles (1975) Film.
Raiders of the Lost Ark (1981) Film.
La Dolce Vita (1960) Film.
Seven Samurai (1954) Film.
In the Mood for Love (2000) Film.';

	include_once ABSPATH . 'wp-admin/includes/post.php  ';
	foreach ( explode( "\r\n", $movies ) as $movie ) {
		if ( empty( $post_id = post_exists( $movie, '', '', 'movie', 'publish' ) ) ) {
			$post_id = wp_insert_post( [
				'post_title'  => sanitize_text_field( $movie ),
				'post_status' => 'publish',
				'post_author' => 1,
				'post_type'   => 'movie',
			] );
		}

		if ( is_wp_error( $post_id ) ) {
			continue;
		}

		foreach ( [ 'genre', 'country', 'year', 'actor' ] as $tax ) {
			$taxonomy = get_terms( array(
				'taxonomy'   => $tax,
				'hide_empty' => false,
			) );

			if ( ! empty( $taxonomy ) && is_array( $taxonomy ) ) {
				shuffle( $taxonomy );

				$random_term = array_slice( $taxonomy, 0, 1 );
				$term        = current( $random_term );

				if ( $term instanceof WP_Term ) {
					wp_set_object_terms( $post_id, '', $tax );
					wp_set_object_terms( $post_id, $term->term_id, $tax );
				}
			}
		}

		$price = random_int( 10000, 100000 );
		update_field( 'cost', $price, $post_id );

		$start     = strtotime( "11 September 1980" );
		$end       = strtotime( "22 July 2022" );
		$timestamp = mt_rand( $start, $end );
		$date      = date( "d/m/Y", $timestamp );
		update_field( 'release_date', $date, $post_id );

	}
}

add_action( 'template_redirect', function () {
	global $wp;
	if ( ! ( $wp instanceof WP ) || ! isset( $wp->query_vars['pagename'] ) || $wp->query_vars['pagename'] !== 'run_demo' ) {
		return;
	}

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
		die( 'install acf' );
	}

	setup_acf();
	setup_terms();
	setup_movies();

	die( 'movies were added' );
} );