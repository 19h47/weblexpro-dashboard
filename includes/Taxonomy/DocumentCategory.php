<?php // phpcs:ignore
/**
 * Class DocumentCategory
 *
 * PHP version 8.0.0
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Taxonomy;

/**
 * DocumentCategory
 */
class DocumentCategory {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ) );
		add_action( 'admin_head', array( $this, 'css' ) );

		add_action( 'manage_document_category_custom_column', array( $this, 'render_custom_columns' ), 10, 3 );
		add_filter( 'manage_edit-document_category_columns', array( $this, 'add_custom_columns' ) );
	}


	/**
	 * CSS
	 *
	 * @return bool
	 */
	public function css() : bool {
		global $typenow, $taxonomy;

		if ( 'document' !== $typenow && 'document_category' !== $taxonomy ) {
			return false;
		}

		?>
		<style>
			.fixed .column-thumbnail {
				vertical-align: top;
				width: 80px;
			}

			.column-thumbnail a {
				display: block;
			}
			.column-thumbnail a img {
				display: inline-block;
				vertical-align: middle;
				width: 80px;
				height: 80px;
				object-fit: contain;
				object-position: center;
				overflow: hidden;
			}
		</style>
		<?php

		return true;
	}


	/**
	 * Add custom columns
	 *
	 * @param array $columns Array of columns.
	 * @return array $new_columns
	 * @link https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
	 */
	public function add_custom_columns( array $columns ) : array {
		$new_columns = array();

		unset( $columns['description'] );
		unset( $columns['slug'] );

		foreach ( $columns as $key => $value ) {
			if ( 'name' === $key ) {
				$new_columns['thumbnail'] = __( 'Thumbnail', 'weblexpro-dashboard' );
			}

			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param string $string Custom column output. Default empty.
	 * @param string $column_name Name of the column.
	 * @param int    $term_id Term ID.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/manage_this-screen-taxonomy_custom_column/
	 *
	 * @return void
	 */
	public function render_custom_columns( string $string, string $column_name, int $term_id ) : void {
		switch ( $column_name ) {
			case 'thumbnail':
				$thumbnail = get_field( 'image', 'term_' . $term_id );
				$html      = '—';

				if ( $thumbnail ) {
					$html  = '<a href="' . esc_attr( get_edit_term_link( $term_id, 'document_category', 'document' ) ) . '"';
					$html .= '>';
					$html .= wp_get_attachment_image( $thumbnail );
					$html .= '</a>';
				}

				echo wp_kses_post( $html );

				break;
		}
	}


	/**
	 * Register custom taxonomy
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_taxonomy/
	 *
	 * @return void
	 */
	public function register() : void {

		$labels = array(
			'name'                       => _x( 'Categories', 'document category general name', 'weblexpro-dashboard' ),
			'singular_name'              => _x( 'Category', 'document category singular name', 'weblexpro-dashboard' ),
			'search_items'               => __( 'Search Categories', 'weblexpro-dashboard' ),
			'all_items'                  => __( 'All Categories', 'weblexpro-dashboard' ),
			'popular_items'              => __( 'Popular Categories', 'weblexpro-dashboard' ),
			'edit_item'                  => __( 'Edit Category', 'weblexpro-dashboard' ),
			'view_item'                  => __( 'View Category', 'weblexpro-dashboard' ),
			'update_item'                => __( 'Update Category', 'weblexpro-dashboard' ),
			'add_new_item'               => __( 'Add New Category', 'weblexpro-dashboard' ),
			'new_item_name'              => __( 'New Category Name', 'weblexpro-dashboard' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'weblexpro-dashboard' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'weblexpro-dashboard' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'weblexpro-dashboard' ),
			'not_found'                  => __( 'No categories found.', 'weblexpro-dashboard' ),
			'no_terms'                   => __( 'No categories', 'weblexpro-dashboard' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'weblexpro-dashboard' ),
			'items_list'                 => __( 'Categories list', 'weblexpro-dashboard' ),
			/* translators: Document category heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'document category', 'weblexpro-dashboard' ),
			'back_to_items'              => __( '&larr; Back to Categories', 'weblexpro-dashboard' ),
		);

		$args = array(
			'labels'             => $labels,
			'hierarchical'       => true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
		);

		register_taxonomy( 'document_category', array( 'document' ), $args );
	}
}
