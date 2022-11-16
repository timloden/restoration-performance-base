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
					__( 'No results found for <em class="searchwp-revised-search-original">%s</em>. Showing results for <em class="searchwp-suggested-revision-query fw-bold">%s</em>', 'searchwp' ),
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


add_filter( 'woocommerce_redirect_single_search_result', 'my_remove_search_redirect', 10 );
function my_remove_search_redirect() {
    return false;	 	 
}

// Add Weight to Entries (posts) within a Specific Category (taxonomy term) in SearchWP.
// @link https://searchwp.com/documentation/knowledge-base/add-weight-category-tag-term/
add_filter( 'searchwp\query\mods', function( $mods ) {
	global $wpdb;

	$bonuses = [];
	$dii_term = get_term_by('name', 'Dynacorn', 'pwb-brand');
	$goodmark_term = get_term_by('name', 'Goodmark', 'pwb-brand');

	if ($dii_term) {
		array_push($bonuses, ['term_id' => $dii_term->term_id, 'weight'  => 1000]);
	}

	if ($goodmark_term) {
		array_push($bonuses, ['term_id' => $goodmark_term->term_id, 'weight'  => 500]);
	}

	$term_mods = [];

	foreach ( $bonuses as $bonus ) {
		$mod = new \SearchWP\Mod();
		$index_alias = $mod->get_foreign_alias();
		$mod->relevance( "IF((
			SELECT {$wpdb->prefix}posts.ID
			FROM {$wpdb->prefix}posts
			LEFT JOIN {$wpdb->prefix}term_relationships ON (
				{$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id
			)
			WHERE {$wpdb->prefix}posts.ID = {$index_alias}.id
				AND {$wpdb->prefix}term_relationships.term_taxonomy_id = {$bonus['term_id']}
			LIMIT 1
		) > 0, {$bonus['weight']}, 0)" );

		$term_mods[] = $mod;
	}

	$mods = array_merge( $mods, $term_mods );

	return $mods;
} );