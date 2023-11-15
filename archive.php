<?php 
/**
 * Archive page for our blog.
 * 
 * Template Name: Blog.
 * 
 * @package Aqva
 */
?>
<?php get_header(); ?>
<main class="archive">
    <article>
        <div class="container">
            <section class="archive-wrapper">
                <ul class="breadcrumbs">
                    <li>
                        <a href="/">home</a>
                    </li>
                    <li>
                        <p href="/blog">blog</p>
                    </li>
                </ul>
                <div class="archive-wrapper__title">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
                <div class="category-filters">
                    <button class="filter-button active" data-category="all">Show All</button>
                    <?php
                    $categories = get_categories();
                    foreach ($categories as $category) {
                        echo '<button class="filter-button" data-category="' . $category->term_id . '">' . $category->name . '</button>';
                    }
                    ?>
                </div>
            </section>
            <section class="archive-post">
                <?php $all_query = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1, 'order' => 'DESC', 'orderby' => 'date')); ?>
                <?php if ($all_query->have_posts()) : ?>
                    <?php while ($all_query->have_posts()) : $all_query->the_post(); ?>
                        <div class="archive-post__item">
                            <img class="lozad" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
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
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </section>
        </div>
    </article>
</main>
<?php get_footer(); ?>