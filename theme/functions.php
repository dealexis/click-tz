<?php

add_filter( 'the_content', function ( $text ) {
	if ( ! is_singular( 'movie' ) ) {
		return $text;
	}

	return $text . get_template_part( 'templates/movie', 'content' );
} );