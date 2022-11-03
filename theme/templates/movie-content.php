<div class="container">
    <div class="row">
		<?php if ( $cost = get_field( 'cost' ) ): ?>
            <span class="label label-default"><span class="glyphicon glyphicon glyphicon-euro" aria-hidden="true"></span>
        <?php
        echo $cost;
        ?>
    </span>
		<?php endif; ?>

		<?php if ( $release_date = get_field( 'release_date' ) ): ?>
            <span class="label label-default"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
        <?php
        echo $release_date;
        ?>
    </span>
		<?php endif; ?>
    </div>

    <div class="row">
		<?php
		$post_id = get_the_ID();
		$genre   = get_the_terms( $post_id, 'genre' );
		if ( is_array( $genre ) ) {
			foreach ( $genre as $item ) {
				echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>' . $item->name;
			}
		}

		$country = get_the_terms( $post_id, 'country' );
		if ( is_array( $country ) ) {
			foreach ( $country as $item ) {
				echo '<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>' . $item->name;
			}
		}
		?>
    </div>
</div>