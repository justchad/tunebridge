<?php

namespace Tunebridge\Admin;
/**
 * Contacts management – custom post type & admin UI.
 *
 * @package TuneBridge
 */

namespace TuneBridge;

defined( 'ABSPATH' ) || exit;

class Contacts {

	public static function init() {
		add_action( 'init', [ __CLASS__, 'register_post_type' ] );
		add_action( 'add_meta_boxes', [ __CLASS__, 'register_meta_boxes' ] );
		add_action( 'save_post_tunebridge_contact', [ __CLASS__, 'save_post' ] );
		add_action( 'admin_post_tunebridge_export_csv', [ __CLASS__, 'export_csv' ] );
	}

	public static function register_post_type() {
		$labels = [
			'name'               => __( 'Contacts', 'tunebridge' ),
			'singular_name'      => __( 'Contact', 'tunebridge' ),
			'menu_name'          => __( 'Contacts', 'tunebridge' ),
			'name_admin_bar'     => __( 'Contact', 'tunebridge' ),
			'add_new'            => __( 'Add New', 'tunebridge' ),
			'add_new_item'       => __( 'Add New Contact', 'tunebridge' ),
			'new_item'           => __( 'New Contact', 'tunebridge' ),
			'edit_item'          => __( 'Edit Contact', 'tunebridge' ),
			'view_item'          => __( 'View Contact', 'tunebridge' ),
			'all_items'          => __( 'All Contacts', 'tunebridge' ),
			'search_items'       => __( 'Search Contacts', 'tunebridge' ),
			'not_found'          => __( 'No contacts found.', 'tunebridge' ),
			'not_found_in_trash' => __( 'No contacts found in Trash.', 'tunebridge' ),
		];

		$args = [
			'labels'          => $labels,
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => false,
			'capability_type' => 'post',
			'map_meta_cap'    => true,
			'supports'        => [ 'title', 'editor', 'custom-fields' ],
			'menu_icon'       => 'dashicons-id',
			'show_in_rest'    => true,
			'rewrite'         => false,
		];

		register_post_type( 'tunebridge_contact', $args );
	}

	public static function render() {
		if ( ! current_user_can( 'view_tunebridge' ) ) {
			wp_die( esc_html__( 'You do not have permission to view this page.', 'tunebridge' ) );
		}
		// Ensure table class present.
		if ( ! class_exists( __NAMESPACE__ . '\\Contacts_Table' ) ) {
			require_once TUNEBRIDGE_PLUGIN_DIR . 'includes/class-contacts-table.php';
		}
		$table = new Contacts_Table();

		if ( isset( $_POST['_tb_contacts_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_tb_contacts_nonce'] ) ), 'tb_contacts_bulk' ) ) {
			$table->process_bulk_action();
		}

		$table->prepare_items();

		$statuses = [
			''        => __( 'All Statuses', 'tunebridge' ),
			'never'   => __( 'Never Contacted', 'tunebridge' ),
			'initial' => __( 'Initial Sent', 'tunebridge' ),
			'follow'  => __( 'Follow-up', 'tunebridge' ),
			'done'    => __( 'Completed', 'tunebridge' ),
		];
		$current_status = isset( $_GET['tb_status'] ) ? sanitize_text_field( wp_unslash( $_GET['tb_status'] ) ) : '';

		\\TuneBridge\\load_template_part( 'contacts/list.php', [
			'table'          => $table,
			'statuses'       => $statuses,
			'current_status' => $current_status,
		] );
	}

	public static function register_meta_boxes() {
		add_meta_box(
			'tunebridge_contact_details',
			__( 'Contact Details', 'tunebridge' ),
			[ __CLASS__, 'render_meta_box' ],
			'tunebridge_contact',
			'normal',
			'default'
		);
	}

	public static function render_meta_box( $post ) {
		$fields = [
			'status'     => get_post_meta( $post->ID, '_tunebridge_status', true ),
			'email'      => get_post_meta( $post->ID, '_tunebridge_email', true ),
			'phone'      => get_post_meta( $post->ID, '_tunebridge_phone', true ),
			'instagram'  => get_post_meta( $post->ID, '_tunebridge_instagram', true ),
			'twitter'    => get_post_meta( $post->ID, '_tunebridge_twitter', true ),
			'spotify'    => get_post_meta( $post->ID, '_tunebridge_spotify', true ),
		];
		$statuses = [
			'never'   => __( 'Never Contacted', 'tunebridge' ),
			'initial' => __( 'Initial Sent', 'tunebridge' ),
			'follow'  => __( 'Follow-up', 'tunebridge' ),
			'done'    => __( 'Completed', 'tunebridge' ),
		];
		\\TuneBridge\\load_template_part( 'contacts/meta-box.php', [
			'fields'   => $fields,
			'statuses' => $statuses,
			'post'     => $post,
		] );
	}

	public static function save_post( $post_id ) {
		if ( ! isset( $_POST['tunebridge_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tunebridge_contact_nonce'] ) ), 'tunebridge_save_contact' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_tunebridge_contacts', $post_id ) ) {
			return;
		}
		$fields = [
			'_tunebridge_status'    => sanitize_text_field( $_POST['tunebridge_status'] ?? '' ),
			'_tunebridge_email'     => sanitize_email( $_POST['tunebridge_email'] ?? '' ),
			'_tunebridge_phone'     => sanitize_text_field( $_POST['tunebridge_phone'] ?? '' ),
			'_tunebridge_instagram' => esc_url_raw( $_POST['tunebridge_instagram'] ?? '' ),
			'_tunebridge_twitter'   => esc_url_raw( $_POST['tunebridge_twitter'] ?? '' ),
			'_tunebridge_spotify'   => esc_url_raw( $_POST['tunebridge_spotify'] ?? '' ),
		];
		foreach ( $fields as $meta_key => $value ) {
			update_post_meta( $post_id, $meta_key, $value );
		}
	}

	public static function export_csv() {
		if ( ! current_user_can( 'export_tunebridge_contacts' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'tunebridge' ) );
		}
		if ( ! isset( $_GET['_tb_export_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_tb_export_nonce'] ) ), 'tb_export_csv' ) ) {
			wp_die( esc_html__( 'Invalid request.', 'tunebridge' ) );
		}

		$status = isset( $_GET['tb_status'] ) ? sanitize_text_field( wp_unslash( $_GET['tb_status'] ) ) : '';
		$search = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';

		$args = [
			'post_type'      => 'tunebridge_contact',
			'post_status'    => [ 'publish', 'draft', 'pending' ],
			'posts_per_page' => -1,
			's'              => $search,
		];
		if ( $status ) {
			$args['meta_query'] = [ [ 'key' => '_tunebridge_status', 'value' => $status ] ];
		}
		$q = new \WP_Query( $args );

		$filename = 'tunebridge-contacts-' . date_i18n( 'Ymd-His' ) . '.csv';
		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		$out = fopen( 'php://output', 'w' );
		fputcsv( $out, [ 'ID', 'Name', 'Status', 'Email', 'Phone', 'Instagram', 'Twitter', 'Spotify', 'Date' ] );

		$labels = [
			'never'   => __( 'Never Contacted', 'tunebridge' ),
			'initial' => __( 'Initial Sent', 'tunebridge' ),
			'follow'  => __( 'Follow-up', 'tunebridge' ),
			'done'    => __( 'Completed', 'tunebridge' ),
		];

		if ( $q->have_posts() ) {
			foreach ( $q->posts as $p ) {
				$st = get_post_meta( $p->ID, '_tunebridge_status', true );
				$em = get_post_meta( $p->ID, '_tunebridge_email', true );
				$ph = get_post_meta( $p->ID, '_tunebridge_phone', true );
				$ig = get_post_meta( $p->ID, '_tunebridge_instagram', true );
				$tw = get_post_meta( $p->ID, '_tunebridge_twitter', true );
				$sp = get_post_meta( $p->ID, '_tunebridge_spotify', true );
				fputcsv( $out, [ $p->ID, wp_strip_all_tags( get_the_title( $p ) ), isset( $labels[$st] ) ? $labels[$st] : $st, $em, $ph, $ig, $tw, $sp, get_the_time( 'Y-m-d H:i:s', $p ) ] );
			}
		}
		fclose( $out ); exit;
	}
}
