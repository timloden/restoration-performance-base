<?php
// Override SearchWP's "Did you mean?" output.
class MySearchwpDidYouMean {
	private $args;

	function __construct() {
		// Prevent SearchWP's automatic "Did you mean?" output.
		add_filter( 'searchwp_auto_output_revised_search_query', '__return_false' );

		// Grab the "Did you mean?" arguments to use later.
		add_action( 'searchwp_revised_search_query', function( $args ) {
			$this->args = $args;
		} );

		// Output custom "Did you mean?" message at the top of The Loop.
		add_action( 'loop_start', function() {
			if ( empty( $this->args ) ) {
				return '';
			}

			$phrase_query = str_replace( array( '”', '“' ), '"', SWP()->original_query ); // Accommodate curly quotes.
			echo '<div class="col-12 searchwp-revised-search-notice pb-3">';
			echo wp_kses(
				sprintf(
					// Translators: First placeholder is the quoted search string. Second placeholder is the search string without quotes.
					__( 'No results found for <em class="searchwp-revised-search-original">%s</em>. Showing results for <em class="searchwp-suggested-revision-query font-weight-bold">%s</em>', 'searchwp' ),
					esc_html( $phrase_query ),
					esc_html( str_replace( '"', '', implode( ' ', $this->args['terms'] ) ) )
				),
				array(
					'em' => array(
						'class' => array(),
					),
				)
			);
			echo '</div>';
		} );
	}
}

new MySearchwpDidYouMean();