<?php
/**
 * Functions template.
 * 
 * @package Aqva
 */

// Register style && scripts //

function aqva_enqueue_scripts()
{
    wp_register_style('style-css', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'), 'all');
    wp_register_style('single-css', get_template_directory_uri() . '/assets/style/single.css', [], filemtime(get_template_directory() . '/assets/style/single.css'), 'all');
	wp_register_style('swiper-css', get_template_directory_uri() . '/assets/style/swiper.css', [], filemtime(get_template_directory() . '/assets/style/swiper.css'), 'all');
	wp_register_style('archive-css', get_template_directory_uri() . '/assets/style/archive.css', [], filemtime(get_template_directory() . '/assets/style/archive.css'), 'all');
    
    wp_register_script('lozad-js', get_template_directory_uri() . '/assets/js/lozad.min.js', [], filemtime(get_template_directory() . '/assets/js/lozad.min.js'), true);
    wp_register_script('main-js', get_template_directory_uri() . '/assets/js/main.js', ['lozad-js'], filemtime(get_template_directory() . '/assets/js/main.js'), true);
    wp_register_script('swiper-js', get_template_directory_uri() . '/assets/js/swiper.js', ['lozad-js'], filemtime(get_template_directory() . '/assets/js/swiper.js'), true);
	wp_register_script('swiper-setup-js', get_template_directory_uri() . '/assets/js/setup.js', ['lozad-js'], filemtime(get_template_directory() . '/assets/js/setup.js'), true);

	wp_enqueue_script('lozad-js');
    wp_enqueue_script('main-js');

    wp_enqueue_style('style-css');
	if(is_singular('post')){
		wp_enqueue_style('swiper-css');
		wp_enqueue_style('single-css');
		wp_enqueue_script('swiper-js');
		wp_enqueue_script('swiper-setup-js');
	}elseif(is_page_template('archive.php')){
		wp_enqueue_style('archive-css');
	}
	wp_localize_script('main-js', 'ajax_obj', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'aqva_enqueue_scripts');


// Add title
function aqva_title_setup() {
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'aqva_title_setup');


add_filter('aioseo_schema_disable', 'aioseo_disable_schema_products');
function aioseo_disable_schema_products($disabled)
{
	return true;
	return $disabled;
}

add_theme_support('post-thumbnails');



function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
	if ('dns-prefetch' == $relation_type) {

		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

		$urls = array_diff($urls, array($emoji_svg_url));
	}

	return $urls;
}

add_action('wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 20);
function mywptheme_child_deregister_styles()
{
	wp_dequeue_style('classic-theme-styles');
}

//Remove Gutenberg Block Library CSS from loading on the frontend
function smartwp_remove_wp_block_library_css()
{
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style'); 
}
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100);

function my_deregister_scripts()
{
	wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'my_deregister_scripts');

add_filter('big_image_size_threshold', '__return_false');
function true_supported_image_sizes($sizes)
{
	return array('thumbnail', 'medium', 'large');
}
add_filter('intermediate_image_sizes', 'true_supported_image_sizes');


function estimated_reading_time() {
    $post_id = get_the_ID();

    $flexible_content = get_field('single_post', $post_id);

    $total_word_count = 0;
    $words_per_minute = 200;

    if ($flexible_content) {
        while (have_rows('single_post', $post_id)) {
            the_row();

            if (get_row_layout() == 'content') {
                $text_content = get_sub_field('content_item');
                $total_word_count += str_word_count(strip_tags($text_content));
            }
        }
    }

    $reading_time = ceil($total_word_count / $words_per_minute);

    echo $reading_time . ' min to read';
}



function filter_posts()
{
    $category = $_POST['category'];

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'orderby' => 'date',
    );

    if ($category != 'all') {
        $args['cat'] = $category;
    }

    $all_query = new WP_Query($args);

    ob_start();

    if ($all_query->have_posts()) {
        while ($all_query->have_posts()) {
            $all_query->the_post(); ?>
            <div class="archive-post__item">
                <img class="lozad" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
                <div class="archive-post__contet">
                    <div class="category">
                        <?php $category = get_the_category()[0]->term_id; ?>
                        <p><?php echo get_cat_name($category); ?></p>
                    </div>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <div class="date">
                        <time><?php echo get_the_date('d.m.Y'); ?></time>
                        <time><?php echo estimated_reading_time(); ?></time>
                    </div>
                </div>
            </div>
        <?php }
        wp_reset_postdata();
    }

    $output = ob_get_clean();
    echo $output;
    wp_die();
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');
