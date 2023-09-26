<?php // phpcs:ignore
/**
 * Class Offer
 *
 * @package    WordPress
 * @subpackage WebLexProDashboard
 */

namespace WebLexProDashboard\Post;

use Timber\{ Timber };

/**
 * Offer class
 */
class Offer {


	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
		add_action( 'admin_head', array( $this, 'css' ) );
		add_action( 'manage_offer_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );

		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ), 10, 1 );
		add_filter( 'bulk_post_updated_messages', array( $this, 'bulk_updated_messages' ), 10, 2 );
		add_filter( 'manage_offer_posts_columns', array( $this, 'add_custom_columns' ) );
	}


	/**
	 * CSS
	 *
	 * @return bool
	 */
	public function css(): bool {
		global $typenow;

		if ( 'offer' !== $typenow ) {
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
				object-fit: cover;
				object-position: center;
				overflow: hidden;
				border-radius: 5px;
			}

			.fixed .column-color {
				vertical-align: top;
				width: 80px;
			}

			.column-color a {
				display: block;
				height: 80px;
				width: 80px;
				border-radius: 5px;
			}
		</style>
		<?php

		return true;
	}


	/**
	 * Add custom columns
	 *
	 * @param  array $columns Array of columns.
	 * @return array $new_columns
	 * @link   https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
	 */
	public function add_custom_columns( array $columns ): array {
		$new_columns = array();

		unset( $columns['date'] );

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				// $new_columns['thumbnail']        = __( 'Thumbnail', 'weblexpro-dashboard' );
				$new_columns['color'] = __( 'Color', 'weblexpro-dashboard' );
			}

			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param string $column_name The column name.
	 * @param int    $post_id     The ID of the post.
	 * @link  https://developer.wordpress.org/reference/hooks/manage_post-post_type_posts_custom_column/
	 *
	 * @return void
	 */
	public function render_custom_columns( string $column_name, int $post_id ): void {
		$color = get_field( 'color', $post_id );

		switch ( $column_name ) {
			case 'color':
				$html = '—';

				if ( $color ) {
					$html = Timber::compile(
						'admin/column-color.html.twig',
						array(
							'url'        => get_edit_post_link( $post_id ),
							'attributes' => array(
								'style' => "background-color: $color;",
								'title' => get_the_title( $post_id ),
							),
						)
					);
				}

				echo wp_kses_post( $html );

				break;

			case 'thumbnail':
				$thumbnail = get_post_thumbnail_id( $post_id );
				$html      = '—';

				if ( $thumbnail ) {
					$html = Timber::compile(
						'admin/column-thumbnail.html.twig',
						array(
							'url'        => get_edit_post_link( $post_id ),
							'attributes' => array(
								'title' => get_the_title( $post_id ),
							),
							'thumbnail'  => $thumbnail,
						)
					);
				}

				echo wp_kses_post( $html );

				break;
		}
	}


	/**
	 * Updated messages
	 *
	 * @param  array $messages Post updated messages. For defaults see $messages declarations above.
	 * @return array $message
	 * @link   https://developer.wordpress.org/reference/hooks/post_updated_messages/
	 * @access public
	 */
	public function updated_messages( array $messages ): array {
		global $post;

		$post_ID     = isset( $post_ID ) ? (int) $post_ID : 0;
		$preview_url = get_preview_post_link( $post );

		/* translators: Publish box date format, see https://secure.php.net/date */
		$scheduled_date = date_i18n( __( 'M j, Y @ H:i', 'weblexpro-dashboard' ), strtotime( $post->post_date ) );

		$view_link_html = sprintf(
			' <a href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'View Offer', 'weblexpro-dashboard' )
		);

		$scheduled_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( get_permalink( $post_ID ) ),
			__( 'Preview Offer', 'weblexpro-dashboard' )
		);

		$preview_link_html = sprintf(
			' <a target="_blank" href="%1$s">%2$s</a>',
			esc_url( $preview_url ),
			__( 'Preview Offer', 'weblexpro-dashboard' )
		);

		$messages['offer'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Offer updated.', 'weblexpro-dashboard' ) . $view_link_html,
			2 => __( 'Custom field updated.', 'weblexpro-dashboard' ),
			3 => __( 'Custom field deleted.', 'weblexpro-dashboard' ),
			4 => __( 'Offer updated.', 'weblexpro-dashboard' ),
			/* translators: %s: date and time of the revision */
        	5  => isset( $_GET['revision'] ) ? sprintf( __( 'Offer restored to revision from %s.', 'weblexpro-dashboard' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore
		6     => __( 'Offer published.', 'weblexpro-dashboard' ) . $view_link_html,
		7     => __( 'Offer saved.', 'weblexpro-dashboard' ),
		8     => __( 'Offer submitted.', 'weblexpro-dashboard' ) . $preview_link_html,
        	9  => sprintf( __( 'Offer scheduled for: %s.', 'weblexpro-dashboard' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_link_html, // phpcs:ignore
		10    => __( 'Offer draft updated.', 'weblexpro-dashboard' ) . $preview_link_html,
		);

		return $messages;
	}


	/**
	 * Bulk updated messages
	 *
	 * @param array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
	 * @param array $bulk_counts   Array of item counts for each message, used to build internationalized strings.
	 *
	 * @see https://developer.wordpress.org/reference/hooks/bulk_post_updated_messages/
	 *
	 * @return array $bulk_counts
	 */
	public function bulk_updated_messages( array $bulk_messages, array $bulk_counts ): array {
		$bulk_counts_updated   = $bulk_counts['updated'];
		$bulk_counts_locked    = $bulk_counts['locked'];
		$bulk_counts_deleted   = $bulk_counts['deleted'];
		$bulk_counts_trashed   = $bulk_counts['trashed'];
		$bulk_counts_untrashed = $bulk_counts['untrashed'];

		$bulk_messages['offer'] = array(
			/* translators: %s: Number of offers. */
			'updated'   => _n( '%s offer updated.', '%s offers updated.', $bulk_counts_updated, 'weblexpro-dashboard' ),
			'locked'    => ( 1 === $bulk_counts_locked ) ? __( '1 offer not updated, somebody is editing it.', 'weblexpro-dashboard' ) :
			/* translators: %s: Number of offers. */
			_n( '%s offer not updated, somebody is editing it.', '%s offers not updated, somebody is editing them.', $bulk_counts_locked, 'weblexpro-dashboard' ),
			/* translators: %s: Number of offers. */
			'deleted'   => _n( '%s offer permanently deleted.', '%s offer permanently deleted.', $bulk_counts_deleted, 'weblexpro-dashboard' ),
			/* translators: %s: Number of offers. */
			'trashed'   => _n( '%s offer moved to the Trash.', '%s offer moved to the Trash.', $bulk_counts_trashed, 'weblexpro-dashboard' ),
			/* translators: %s: Number of offers. */
			'untrashed' => _n( '%s offer restored from the Trash.', '%s offer restored from the Trash.', $bulk_counts_untrashed, 'weblexpro-dashboard' ),
		);

		return $bulk_messages;
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register(): void {
		$labels = array(
			'name'                     => _x( 'Offers', 'offer type generale name', 'weblexpro-dashboard' ),
			'singular_name'            => _x( 'Offer', 'offer type singular name', 'weblexpro-dashboard' ),
			'add_new'                  => _x( 'Add New', 'offer type', 'weblexpro-dashboard' ),
			'add_new_item'             => __( 'Add New Offer', 'weblexpro-dashboard' ),
			'edit_item'                => __( 'Edit Offer', 'weblexpro-dashboard' ),
			'new_item'                 => __( 'New Offer', 'weblexpro-dashboard' ),
			'view_items'               => __( 'View Offers', 'weblexpro-dashboard' ),
			'view_item'                => __( 'View Offer', 'weblexpro-dashboard' ),
			'search_items'             => __( 'Search Offers', 'weblexpro-dashboard' ),
			'not_found'                => __( 'No Offers found.', 'weblexpro-dashboard' ),
			'not_found_in_trash'       => __( 'No Offers found in Trash.', 'weblexpro-dashboard' ),
			'parent_item_colon'        => __( 'Parent Offer:', 'weblexpro-dashboard' ),
			'all_items'                => __( 'All Offers', 'weblexpro-dashboard' ),
			'archives'                 => __( 'Offer Archives', 'weblexpro-dashboard' ),
			'attributes'               => __( 'Offer Attributes', 'weblexpro-dashboard' ),
			'insert_into_item'         => __( 'Insert into offer', 'weblexpro-dashboard' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this offer', 'weblexpro-dashboard' ),
			'featured_image'           => _x( 'Featured Image', 'offer', 'weblexpro-dashboard' ),
			'set_featured_image'       => _x( 'Set featured image', 'offer', 'weblexpro-dashboard' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'offer', 'weblexpro-dashboard' ),
			'use_featured_image'       => _x( 'Use as featured image', 'offer', 'weblexpro-dashboard' ),
			'items_list_navigation'    => __( 'Offers list navigation', 'weblexpro-dashboard' ),
			'items_list'               => __( 'Offers list', 'weblexpro-dashboard' ),
			'item_published'           => __( 'Offer published.', 'weblexpro-dashboard' ),
			'item_published_privately' => __( 'Offer published privately.', 'weblexpro-dashboard' ),
			'item_reverted_to_draft'   => __( 'Offer reverted to draft.', 'weblexpro-dashboard' ),
			'item_scheduled'           => __( 'Offer scheduled.', 'weblexpro-dashboard' ),
			'item_updated'             => __( 'Offer updated.', 'weblexpro-dashboard' ),
		);

		$rewrite = array(
			'with_front' => true,
		);

		$args = array(
			'label'               => __( 'Offer', 'weblexpro-dashboard' ),
			'description'         => __( 'Offer Description', 'weblexpro-dashboard' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'taxonomies'          => array( 'offer_category' ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
		);

		register_post_type( 'offer', $args );
	}
}
