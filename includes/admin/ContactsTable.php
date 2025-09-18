<?php

namespace Tunebridge\Admin;
/**
 * WP_List_Table implementation for TuneBridge Contacts.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( '\\WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Contacts_Table extends \WP_List_Table {

	protected $status_filter = '';

	public function __construct() {
		parent::__construct( [ 'singular' => 'tunebridge_contact', 'plural' => 'tunebridge_contacts', 'ajax' => false ] );
		$this->status_filter = isset( $_GET['tb_status'] ) ? sanitize_text_field( wp_unslash( $_GET['tb_status'] ) ) : '';
	}

	public function get_columns() {
		return [
			'cb'        => '<input type="checkbox" />',
			'title'     => __( 'Name', 'tunebridge' ),
			'status'    => __( 'Status', 'tunebridge' ),
			'email'     => __( 'Email', 'tunebridge' ),
			'instagram' => __( 'Instagram', 'tunebridge' ),
			'spotify'   => __( 'Spotify', 'tunebridge' ),
			'date'      => __( 'Date', 'tunebridge' ),
		];
	}

	protected function get_sortable_columns() {
		return [ 'title' => [ 'title', false ], 'status' => [ 'status', false ], 'date' => [ 'date', false ] ];
	}

	protected function get_bulk_actions() {
		return [
			'trash'        => __( 'Move to Trash', 'tunebridge' ),
			'mark_never'   => __( 'Mark: Never Contacted', 'tunebridge' ),
			'mark_initial' => __( 'Mark: Initial Sent', 'tunebridge' ),
			'mark_follow'  => __( 'Mark: Follow-up', 'tunebridge' ),
			'mark_done'    => __( 'Mark: Completed', 'tunebridge' ),
		];
	}

	public function process_bulk_action() {
		$action = $this->current_action();
		if ( empty( $action ) ) return;
		$ids = isset( $_REQUEST['contact'] ) ? (array) $_REQUEST['contact'] : [];
		$ids = array_map( 'absint', $ids );
		if ( empty( $ids ) ) return;

		switch ( $action ) {
			case 'trash':
				foreach ( $ids as $id ) { if ( current_user_can( 'delete_post', $id ) ) { wp_trash_post( $id ); } }
				break;
			case 'mark_never':
			case 'mark_initial':
			case 'mark_follow':
			case 'mark_done':
				$status_map = [ 'mark_never' => 'never', 'mark_initial' => 'initial', 'mark_follow' => 'follow', 'mark_done' => 'done' ];
				$new_status = isset( $status_map[ $action ] ) ? $status_map[ $action ] : '';
				if ( $new_status ) {
					foreach ( $ids as $id ) { if ( current_user_can( 'edit_post', $id ) ) { update_post_meta( $id, '_tunebridge_status', $new_status ); } }
				}
				break;
		}
	}

	protected function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="contact[]" value="%d" />', absint( $item->ID ) );
	}

	protected function column_title( $item ) {
		$edit_link = get_edit_post_link( $item->ID );
		$title     = get_the_title( $item->ID );
		$view_link = get_permalink( $item->ID );
		$trash_link = get_delete_post_link( $item->ID, '', true );
		$actions = [];
		if ( $edit_link ) { $actions['edit'] = sprintf( '<a href="%s">%s</a>', esc_url( $edit_link ), esc_html__( 'Edit', 'tunebridge' ) ); }
		if ( $trash_link && current_user_can( 'delete_post', $item->ID ) ) { $actions['trash'] = sprintf( '<a href="%s">%s</a>', esc_url( $trash_link ), esc_html__( 'Trash', 'tunebridge' ) ); }
		if ( $view_link ) { $actions['view'] = sprintf( '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>', esc_url( $view_link ), esc_html__( 'View', 'tunebridge' ) ); }
		return sprintf( '<strong><a class="row-title" href="%s">%s</a></strong> %s', esc_url( $edit_link ), esc_html( $title ), $this->row_actions( $actions ) );
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'status':
				$val = get_post_meta( $item->ID, '_tunebridge_status', true );
				$statuses = [ 'never' => __( 'Never Contacted', 'tunebridge' ), 'initial' => __( 'Initial Sent', 'tunebridge' ), 'follow' => __( 'Follow-up', 'tunebridge' ), 'done' => __( 'Completed', 'tunebridge' ) ];
				return isset( $statuses[$val] ) ? esc_html( $statuses[$val] ) : '&mdash;';
			case 'email':
				$email = get_post_meta( $item->ID, '_tunebridge_email', true );
				return $email ? sprintf( '<a href="%1$s">%2$s</a>', esc_url( 'mailto:' . $email ), esc_html( $email ) ) : '&mdash;';
			case 'instagram':
				$ig = get_post_meta( $item->ID, '_tunebridge_instagram', true );
				return $ig ? sprintf( '<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>', esc_url( $ig ), esc_html( $ig ) ) : '&mdash;';
			case 'spotify':
				$sp = get_post_meta( $item->ID, '_tunebridge_spotify', true );
				return $sp ? sprintf( '<a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a>', esc_url( $sp ), esc_html( $sp ) ) : '&mdash;';
			case 'date':
				return esc_html( get_the_time( get_option( 'date_format' ), $item ) );
			default:
				return '&mdash;';
		}
	}

	public function prepare_items() {
		$per_page = 20; $current_page = $this->get_pagenum();
		$orderby = isset( $_GET['orderby'] ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : 'date';
		$order   = isset( $_GET['order'] ) ? sanitize_key( wp_unslash( $_GET['order'] ) ) : 'desc';

		$args = [
			'post_type'      => 'tunebridge_contact',
			'post_status'    => [ 'publish', 'draft', 'pending' ],
			'posts_per_page' => $per_page,
			'paged'          => $current_page,
			'orderby'        => $orderby === 'status' ? 'meta_value' : $orderby,
			'order'          => $order,
		];

		$meta_query = [];
		if ( $this->status_filter ) {
			$meta_query[] = [ 'key' => '_tunebridge_status', 'value' => $this->status_filter ];
		}
		if ( ! empty( $meta_query ) ) { $args['meta_query'] = $meta_query; $args['meta_key'] = '_tunebridge_status'; $args['meta_type'] = 'CHAR'; }

		if ( ! empty( $_REQUEST['s'] ) ) { $args['s'] = sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ); }

		$query = new \WP_Query( $args );
		$this->items = $query->posts;
		$this->set_pagination_args( [ 'total_items' =>  (int) $query->found_posts, 'per_page' => $per_page, 'total_pages' => int( $query->max_num_pages ) ] )
		self::_set_headers();
	}

	protected function _set_headers(){
		$this->_column_headers = [ $this->get_columns(), [], $this->get_sortable_columns(), 'title' ];
	}
}
