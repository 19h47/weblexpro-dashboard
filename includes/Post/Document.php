<?php // phpcs:ignore
/**
 * Class Document
 *
 * @package WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Post;

/**
 * Document class
 */
class Document {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
		add_action( 'admin_head', array( $this, 'css' ) );
		add_action( 'manage_document_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );

		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ), 10, 1 );
		add_filter( 'bulk_post_updated_messages', array( $this, 'bulk_updated_messages' ), 10, 2 );
		add_filter( 'manage_document_posts_columns', array( $this, 'add_custom_columns' ) );
	}


	/**
	 * CSS
	 *
	 * @return bool
	 */
	public function css() : bool {
		global $typenow;

		if ( 'document' !== $typenow ) {
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

		unset( $columns['date'] );

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['thumbnail'] = __( 'Thumbnail', 'weblexprodashboard' );
			}

			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param string $column_name The column name.
	 * @param int    $post_id The ID of the post.
	 * @link https://developer.wordpress.org/reference/hooks/manage_post-post_type_posts_custom_column/
	 *
	 * @return void
	 */
	public function render_custom_columns( string $column_name, int $post_id ) : void {
		switch ( $column_name ) {
			case 'thumbnail':
				$thumbnail = get_the_post_thumbnail( $post_id, 'medium' );
				$html      = '—';

				if ( $thumbnail ) {
					$html  = '<a href="' . esc_attr( get_edit_post_link( $post_id ) ) . '">';
					$html .= $thumbnail;
					$html .= '</a>';
				}

				echo wp_kses_post( $html );

				break;
		}
	}


	/**
	 * Updated messages
	 *
	 * @param array $messages Post updated messages. For defaults see $messages declarations above.
	 * @return array $message
	 * @link https://developer.wordpress.org/reference/hooks/post_updated_messages/
	 * @access public
	 */
	public function updated_messages( array $messages ) : array {
		global $post;

		$post_ID     = isset( $post_ID ) ? (int) $post_ID : 0;
		$preview_url = get_preview_post_link( $post );

		/* translators: Publish box date format, see https://secure.php.net/date */
		$scheduled_date = date_i18n( __( 'M j, Y @ H:i' ), strtotime( $post->post_date ) );

		$view_link_html = sprintf(
			' <a href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'View document', 'weblexprodashboard' )
		);

		$scheduled_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'Preview document', 'weblexprodashboard' )
		);

		$preview_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( $preview_url ),
			__( 'Preview document', 'weblexprodashboard' )
		);

		$messages['document'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Document updated.', 'weblexprodashboard' ) . $view_link_html,
			2  => __( 'Custom field updated.', 'weblexprodashboard' ),
			3  => __( 'Custom field deleted.', 'weblexprodashboard' ),
			4  => __( 'Document updated.', 'weblexprodashboard' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Document restored to revision from %s.', 'weblexprodashboard' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore
			6  => __( 'Document published.', 'weblexprodashboard' ) . $view_link_html,
			7  => __( 'Document saved.', 'weblexprodashboard' ),
			8  => __( 'Document submitted.', 'weblexprodashboard' ) . $preview_link_html,
			9  => sprintf( __( 'Document scheduled for: %s.', 'weblexprodashboard' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_link_html, // phpcs:ignore
			10 => __( 'Document draft updated.', 'weblexprodashboard' ) . $preview_link_html,
		);

		return $messages;
	}


	/**
	 * Bulk updated messages
	 *
	 * @param array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
	 * @param array $bulk_counts Array of item counts for each message, used to build internationalized strings.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/bulk_post_updated_messages/
	 *
	 * @return array $bulk_counts
	 */
	public function bulk_updated_messages( array $bulk_messages, array $bulk_counts ) : array {
		$bulk_messages['document'] = array(
			/* translators: %s: Number of documents. */
			'updated'   => _n( '%s document updated.', '%s documents updated.', $bulk_counts['updated'], 'weblexprodashboard' ),
			'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 document not updated, somebody is editing it.', 'weblexprodashboard' ) :
				/* translators: %s: Number of documents. */
				_n( '%s document not updated, somebody is editing it.', '%s documents not updated, somebody is editing them.', $bulk_counts['locked'], 'weblexprodashboard' ),
			/* translators: %s: Number of documents. */
			'deleted'   => _n( '%s document permanently deleted.', '%s document permanently deleted.', $bulk_counts['deleted'], 'weblexprodashboard' ),
			/* translators: %s: Number of documents. */
			'trashed'   => _n( '%s document moved to the Trash.', '%s document moved to the Trash.', $bulk_counts['trashed'], 'weblexprodashboard' ),
			/* translators: %s: Number of documents. */
			'untrashed' => _n( '%s document restored from the Trash.', '%s document restored from the Trash.', $bulk_counts['untrashed'], 'weblexprodashboard' ),
		);

		return $bulk_messages;
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register() : void {
		$labels = array(
			'name'                     => _x( 'Documents', 'document type generale name', 'weblexprodashboard' ),
			'singular_name'            => _x( 'Document', 'document type singular name', 'weblexprodashboard' ),
			'add_new'                  => _x( 'Add New', 'document type', 'weblexprodashboard' ),
			'add_new_item'             => __( 'Add New Document', 'weblexprodashboard' ),
			'edit_item'                => __( 'Edit Document', 'weblexprodashboard' ),
			'new_item'                 => __( 'New Document', 'weblexprodashboard' ),
			'view_items'               => __( 'View Documents', 'weblexprodashboard' ),
			'view_item'                => __( 'View Document', 'weblexprodashboard' ),
			'search_items'             => __( 'Search Documents', 'weblexprodashboard' ),
			'not_found'                => __( 'No Documents found.', 'weblexprodashboard' ),
			'not_found_in_trash'       => __( 'No Documents found in Trash.', 'weblexprodashboard' ),
			'parent_item_colon'        => __( 'Parent Document:', 'weblexprodashboard' ),
			'all_items'                => __( 'All Documents', 'weblexprodashboard' ),
			'archives'                 => __( 'Document Archives', 'weblexprodashboard' ),
			'attributes'               => __( 'Document Attributes', 'weblexprodashboard' ),
			'insert_into_item'         => __( 'Insert into document', 'weblexprodashboard' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this document', 'weblexprodashboard' ),
			'featured_image'           => _x( 'Featured Image', 'document', 'weblexprodashboard' ),
			'set_featured_image'       => _x( 'Set featured image', 'document', 'weblexprodashboard' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'document', 'weblexprodashboard' ),
			'use_featured_image'       => _x( 'Use as featured image', 'document', 'weblexprodashboard' ),
			'items_list_navigation'    => __( 'Documents list navigation', 'weblexprodashboard' ),
			'items_list'               => __( 'Documents list', 'weblexprodashboard' ),
			'item_published'           => __( 'Document published.', 'weblexprodashboard' ),
			'item_published_privately' => __( 'Document published privately.', 'weblexprodashboard' ),
			'item_reverted_to_draft'   => __( 'Document reverted to draft.', 'weblexprodashboard' ),
			'item_scheduled'           => __( 'Document scheduled.', 'weblexprodashboard' ),
			'item_updated'             => __( 'Document updated.', 'weblexprodashboard' ),
		);

		$rewrite = array(
			'slug'       => 'documents',
			'with_front' => true,
		);

		$args = array(
			'label'               => __( 'Document', 'weblexprodashboard' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail', 'editor' ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-media-document',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'show_in_rest'        => true,
			'show_in_graphql'     => true,
			'taxonomies'          => array(),
		);

		register_post_type( 'document', $args );
	}
}
