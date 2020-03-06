<?php
/**
 * Provide an admin-facing view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package Minimalist_Posts_Pages_Meta
 * @link    https://github.com/ArmandPhilippot/minimalist-posts-pages-meta
 *
 * @since   1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$minimalist_widget_title  = ! empty( $instance['title'] ) ? $instance['title'] : '';
$minimalist_posts         = ! empty( $instance['posts'] ) ? $instance['posts'] : '';
$minimalist_pages         = ! empty( $instance['pages'] ) ? $instance['pages'] : '';
$minimalist_published     = ! empty( $instance['published'] ) ? $instance['published'] : '';
$minimalist_updated       = ! empty( $instance['updated'] ) ? $instance['updated'] : '';
$minimalist_author        = ! empty( $instance['post-publisher'] ) ? $instance['post-publisher'] : '';
$minimalist_author_link   = ! empty( $instance['post-publisher-link'] ) ? $instance['post-publisher-link'] : '';
$minimalist_reading_time  = ! empty( $instance['reading-time'] ) ? $instance['reading-time'] : '';
$minimalist_categories    = ! empty( $instance['categories'] ) ? $instance['categories'] : '';
$minimalist_tags          = ! empty( $instance['tags'] ) ? $instance['tags'] : '';
$minimalist_comments_link = ! empty( $instance['comments-link'] ) ? $instance['comments-link'] : '';
?>
<p>
	<label
		for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo esc_html__( 'Title:', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<input class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
		type="text" value="<?php echo esc_attr( $minimalist_widget_title ); ?>" />
</p>
<p>
	<?php esc_html_e( 'Display on:', 'Minimalist-Posts-Pages-Meta' ); ?>
	<label for="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>">
		<?php echo esc_html__( 'Posts', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_posts, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'pages' ) ); ?>">
		<?php echo esc_html__( 'Pages', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'pages' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pages' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_pages, 1, true ); ?> />
</p>
<p>
	<?php esc_html_e( 'Options to display:', 'Minimalist-Posts-Pages-Meta' ); ?>
</p>
<p>
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'published' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_published, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>">
		<?php echo esc_html__( 'Display publication date', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<br />
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'updated' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'updated' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_updated, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'updated' ) ); ?>">
		<?php echo esc_html__( 'Display update date (if different from publication date)', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<br />
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'post-publisher' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post-publisher' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_author, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'post-publisher' ) ); ?>">
		<?php echo esc_html__( 'Display the author', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<br />
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'post-publisher-link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post-publisher-link' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_author_link, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'post-publisher-link' ) ); ?>">
		<?php echo esc_html__( 'Display the author page link', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<br />
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'reading-time' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'reading-time' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_reading_time, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'reading-time' ) ); ?>">
		<?php echo esc_html__( 'Display reading time', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<br />
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categories' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_categories, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>">
		<?php echo esc_html__( 'Display categories (posts only)', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<br />
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_tags, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>">
		<?php echo esc_html__( 'Display tags (posts only)', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
	<br />
	<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'comments-link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comments-link' ) ); ?>" type="checkbox" value="1" <?php checked( $minimalist_comments_link, 1, true ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'comments-link' ) ); ?>">
		<?php echo esc_html__( 'Display comments number & link', 'Minimalist-Posts-Pages-Meta' ); ?>
	</label>
</p>
