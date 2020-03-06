<?php
/**
 * Minimalist-Posts-Pages-Meta
 *
 * The Minimalist-Posts-Pages-Meta is a plugin to create a widget displaying posts & pages metadata.
 *
 * @package   Minimalist_Posts_Pages_Meta
 * @link      https://github.com/ArmandPhilippot/minimalist-posts-pages-meta
 * @author    Armand Philippot <contact@armandphilippot.com>
 * @see       https://www.armandphilippot.com
 *
 * @copyright 2020 Armand Philippot
 * @license   GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Posts & Pages Meta
 * Plugin URI:  https://github.com/ArmandPhilippot/minimalist-posts-pages-meta
 * Description: Display posts & pages metadata as a widget.
 * Version:     1.0.0
 * Author:      Armand Philippot
 * Author URI:  https://www.armandphilippot.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Tags:        widget, posts, pages, metadata
 * Text Domain: Minimalist-Posts-Pages-Meta
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MINIMALIST_POSTS_PAGES_META_VERSION', '1.0.0' );

/**
 * Load text domain files
 *
 * @since 1.0.0
 */
function minimalist_posts_pages_meta_load_plugin_textdomain() {
	load_plugin_textdomain( 'Minimalist-Posts-Pages-Meta', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'minimalist_posts_pages_meta_load_plugin_textdomain' );

/**
 * Class used to implement a Minimalist-Posts-Pages-Meta Widget
 *
 * @since 1.0.0
 */
class Minimalist_Posts_Pages_Meta extends WP_Widget {
	/**
	 * Sets up a new Minimalist-Posts-Pages-Meta widget instance width id, name & description.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'widget_minimalist_posts_pages_meta',
			'description' => __( 'Display posts & pages metadata as a widget.', 'Minimalist-Posts-Pages-Meta' ),
		);
		parent::__construct(
			'minimalist-posts-pages-meta',
			__( 'Posts & Pages Meta', 'Minimalist-Posts-Pages-Meta' ),
			$widget_options
		);

		add_action(
			'widgets_init',
			function() {
				register_widget( 'Minimalist_Posts_Pages_Meta' );
			}
		);
	}

	/**
	 * Outputs the content for the current instance
	 *
	 * @since 1.0.0
	 *
	 * @param array $args HTML to display the widget title class and widget content class.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$title         = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Metadata', 'Minimalist-Posts-Pages-Meta' );
		$title         = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$posts         = ( ! empty( $instance['posts'] ) ) ? wp_strip_all_tags( $instance['posts'] ) : '';
		$pages         = ( ! empty( $instance['pages'] ) ) ? wp_strip_all_tags( $instance['pages'] ) : '';
		$published     = ( ! empty( $instance['published'] ) ) ? wp_strip_all_tags( $instance['published'] ) : '';
		$updated       = ( ! empty( $instance['updated'] ) ) ? wp_strip_all_tags( $instance['updated'] ) : '';
		$author        = ( ! empty( $instance['post-publisher'] ) ) ? wp_strip_all_tags( $instance['post-publisher'] ) : '';
		$author_link   = ( ! empty( $instance['post-publisher-link'] ) ) ? wp_strip_all_tags( $instance['post-publisher-link'] ) : '';
		$reading_time  = ( ! empty( $instance['reading-time'] ) ) ? wp_strip_all_tags( $instance['reading-time'] ) : '';
		$categories    = ( ! empty( $instance['categories'] ) ) ? wp_strip_all_tags( $instance['categories'] ) : '';
		$tags          = ( ! empty( $instance['tags'] ) ) ? wp_strip_all_tags( $instance['tags'] ) : '';
		$comments_link = ( ! empty( $instance['comments-link'] ) ) ? wp_strip_all_tags( $instance['comments-link'] ) : '';

		$publication_date  = get_the_date( get_option( 'date_format' ) );
		$modification_date = get_the_modified_date( get_option( 'date_format' ) );
		$num_comments      = get_comments_number();
		global $post;
		$post_content = $post->post_content;

		if ( ! function_exists( 'minimalist_time_to_read_post' ) ) {
			/**
			 * Calculate an estimated time to read the content.
			 *
			 * @since 1.0.0
			 *
			 * @param string $content The post or page content.
			 * @return int Estimated reading time in minutes.
			 */
			function minimalist_time_to_read_post( $content ) {
				$words_per_minute = 200;
				$stripped_content = wp_strip_all_tags( strip_shortcodes( $content ) );
				$word_count       = str_word_count( $stripped_content );
				$reading_time     = floor( $word_count / $words_per_minute );

				return $reading_time;
			}
		}

		if ( '1' === $posts && is_single() ) {
			echo wp_kses_post( $args['before_widget'] );
			if ( ! empty( $title ) ) {
				echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );
			}
			echo '<ul>';
			if ( '' !== $publication_date && '1' === $published ) {
				echo '<li>' . esc_html__( 'Published on', 'Minimalist-Posts-Pages-Meta' ) . ' <time itemprop="datePublished" datetime="' . get_the_date( 'c' ) . '">' . get_the_date( get_option( 'date_format' ) ) . '</time></li>';
			}
			if ( '' !== $modification_date && $publication_date !== $modification_date && '1' === $updated ) {
				echo '<li>' . esc_html__( 'Updated on', 'Minimalist-Posts-Pages-Meta' ) . ' <time itemprop="dateModified" datetime="' . esc_html( get_the_modified_date( 'c' ) ) . '">' . esc_html( $modification_date ) . '</time></li>';
			}
			if ( '' !== $post_content && '1' === $reading_time ) {
				echo '<li>' . esc_html__( 'Reading estimated at', 'Minimalist-Posts-Pages-Meta' ) . ' ';
				printf(
					// translators: %s Number.
					esc_html( _n( '%s minute', '%s minutes', minimalist_time_to_read_post( $post_content ), 'Minimalist-Posts-Pages-Meta' ) ),
					esc_html( number_format_i18n( minimalist_time_to_read_post( $post_content ) ) )
				);
				echo '</li>';
			}
			if ( '1' === $author || '1' === $author_link ) {
				echo '<li>';
				echo esc_html__( 'By', 'Minimalist-Posts-Pages-Meta' ) . ' ';
				if ( '1' === $author_link ) {
					the_author_posts_link();
				} else {
					the_author();
				}
				echo '</li>';
			}
			if ( '1' === $categories ) {
				$post_categories  = get_the_category();
				$categories_count = count( $post_categories );
				echo '<li>';
				printf(
					// translators: %s Category or categories name.
					esc_html( _n( 'Category: %s', 'Categories: %s', $categories_count, 'Minimalist-Posts-Pages-Meta' ) ),
					wp_kses_data( get_the_category_list( ', ' ) )
				);
				echo '</li>';
			}
			if ( '1' === $tags ) {
				$post_tags  = get_the_tags();
				$tags_count = ( ! empty( $post_tags ) ) ? count( $post_tags ) : '';
				if ( $tags_count > 0 && '' !== $post_tags ) {
					echo '<li>';
					printf(
						// translators: %s Tag or tags name.
						esc_html( _n( 'Tag: %s', 'Tags: %s', $tags_count, 'Minimalist-Posts-Pages-Meta' ) ),
						wp_kses_data( get_the_tag_list( '', ', ', '' ) )
					);
					echo '</li>';
				}
			}
			if ( '1' === $comments_link ) {
				if ( ( $num_comments > 0 && ! comments_open() ) || comments_open() ) {
					echo '<li>';
					comments_popup_link(
						// translators: Display when 0 comments.
						__( 'Leave a comment', 'Minimalist-Posts-Pages-Meta' ),
						// translators: Display when 1 comment.
						__( '1 comment', 'Minimalist-Posts-Pages-Meta' ),
						// translators: %s Number of comments.
						__( '% comments', 'Minimalist-Posts-Pages-Meta' )
					);
					echo '</li>';
					echo '<meta itemprop="interactionCount" content="UserComments:' . esc_html( get_comments_number() ) . '" />';
				}
			}

			echo '</ul>';
			echo wp_kses_post( $args['after_widget'] );
		} elseif ( '1' === $pages && ( is_page() && ! is_front_page() ) ) {
			echo wp_kses_post( $args['before_widget'] );
			if ( ! empty( $title ) ) {
				echo wp_kses_post( $args['before_title'] ) . esc_html( $title ) . wp_kses_post( $args['after_title'] );
			}
			echo '<ul>';

			if ( '' !== $publication_date && '1' === $published ) {
				echo '<li>' . esc_html__( 'Published on', 'Minimalist-Posts-Pages-Meta' ) . ' <time itemprop="datePublished" datetime="' . get_the_date( 'c' ) . '">' . get_the_date( get_option( 'date_format' ) ) . '</time></li>';
			}
			if ( '' !== $modification_date && $publication_date !== $modification_date && '1' === $updated ) {
				echo '<li>' . esc_html__( 'Updated on', 'Minimalist-Posts-Pages-Meta' ) . ' <time itemprop="dateModified" datetime="' . esc_html( get_the_modified_date( 'c' ) ) . '">' . esc_html( $modification_date ) . '</time></li>';
			}
			if ( '' !== $post_content && '1' === $reading_time ) {
				echo '<li>' . esc_html__( 'Reading estimated at', 'Minimalist-Posts-Pages-Meta' ) . ' ';
				printf(
					// translators: %s Number.
					esc_html( _n( '%s minute', '%s minutes', minimalist_time_to_read_post( $post_content ), 'Minimalist-Posts-Pages-Meta' ) ),
					esc_html( number_format_i18n( minimalist_time_to_read_post( $post_content ) ) )
				);
				echo '</li>';
			}
			if ( '1' === $author || '1' === $author_link ) {
				echo '<li>';
				echo esc_html__( 'By', 'Minimalist-Posts-Pages-Meta' ) . ' ';
				if ( '1' === $author_link ) {
					the_author_posts_link();
				} else {
					the_author();
				}
				echo '</li>';
			}
			if ( '1' === $comments_link ) {
				if ( ( $num_comments > 0 && ! comments_open() ) || comments_open() ) {
					echo '<li>';
					comments_popup_link( __( 'Leave a comment', 'Minimalist-Posts-Pages-Meta' ), __( '1 comment', 'Minimalist-Posts-Pages-Meta' ), __( '% comments', 'Minimalist-Posts-Pages-Meta' ) );
					echo '</li>';
					echo '<meta itemprop="interactionCount" content="UserComments:' . esc_html( get_comments_number() ) . '" />';
				}
			}

			echo '</ul>';
			echo wp_kses_post( $args['after_widget'] );
		}
	}

	/**
	 * Outputs the options form in the admin
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance The widget options.
	 */
	public function form( $instance ) {
		include 'partials/minimalist-posts-pages-meta-admin.php';
	}

	/**
	 * Processing widget options on save
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user.
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                        = $old_instance;
		$instance['title']               = sanitize_text_field( $new_instance['title'] );
		$instance['posts']               = ( ! empty( $new_instance['posts'] ) ) ? wp_strip_all_tags( $new_instance['posts'] ) : '';
		$instance['pages']               = ( ! empty( $new_instance['pages'] ) ) ? wp_strip_all_tags( $new_instance['pages'] ) : '';
		$instance['published']           = ( ! empty( $new_instance['published'] ) ) ? wp_strip_all_tags( $new_instance['published'] ) : '';
		$instance['updated']             = ( ! empty( $new_instance['updated'] ) ) ? wp_strip_all_tags( $new_instance['updated'] ) : '';
		$instance['post-publisher']      = ( ! empty( $new_instance['post-publisher'] ) ) ? wp_strip_all_tags( $new_instance['post-publisher'] ) : '';
		$instance['post-publisher-link'] = ( ! empty( $new_instance['post-publisher-link'] ) ) ? wp_strip_all_tags( $new_instance['post-publisher-link'] ) : '';
		$instance['reading-time']        = ( ! empty( $new_instance['reading-time'] ) ) ? wp_strip_all_tags( $new_instance['reading-time'] ) : '';
		$instance['categories']          = ( ! empty( $new_instance['categories'] ) ) ? wp_strip_all_tags( $new_instance['categories'] ) : '';
		$instance['tags']                = ( ! empty( $new_instance['tags'] ) ) ? wp_strip_all_tags( $new_instance['tags'] ) : '';
		$instance['comments-link']       = ( ! empty( $new_instance['comments-link'] ) ) ? wp_strip_all_tags( $new_instance['comments-link'] ) : '';

		return $instance;
	}
}
$minimalist_posts_pages_meta = new Minimalist_Posts_Pages_Meta();
