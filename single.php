<?php 
/**
 * Single page our blog.
 * 
 * @package Aqva
 */
?>
<?php get_header(); ?>
<main class="blog">
    <article>
        <div class="container">
            <section class="blog-banner">
                <ul class="breadcrumbs">
                    <li>
                        <a href="/">home</a>
                    </li>
                    <li>
                        <a href="/blog">blog</a>
                    </li>
                    <li>
                        <p><?php the_title(); ?></p>
                    </li>
                </ul>
                <div class="category">
                    <?php $category_id = get_the_category()[0]->term_id; ?>
                    <p><?php echo get_cat_name($category_id); ?></p>
                </div>
                <h1><?php the_title(); ?></h1>
                <div class="date">
                    <time><?php echo get_the_date('d.m.Y'); ?></time>
                    <time><?php echo estimated_reading_time(); ?></time>
                </div>
                <img class="banner-img" decoding="async" src="<?php echo the_post_thumbnail_url('full') ?>" srcset="<?php echo the_post_thumbnail_url('medium'); ?> 1920w , <?php echo the_post_thumbnail_url('thumbnail'); ?> 900w" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
            </section>
            <section class="post-content">
                <?php if (have_rows('single_post')) : ?>
                    <?php while (have_rows('single_post')) : the_row(); ?>
                        <?php if (get_row_layout() == 'content') : ?>
                            <?php the_sub_field('content_item'); ?>
                        <?php elseif (get_row_layout() == 'video') : ?>
                            <div class="video">
                                <iframe class="lozad" width="100%" height="100%" data-src="<?php the_sub_field('video_link'); ?>" title="YouTube video player" loading="lazy" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </section>
            <section class="post-slider">
                <h2>
                    You may be interested
                </h2>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php $wpb_all_query = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 6, 'order' => 'ASC', 'orderby' => 'date')); ?>
                        <?php if ($wpb_all_query->have_posts()) : ?>
                            <?php while ($wpb_all_query->have_posts()) : $wpb_all_query->the_post(); ?>
                                <div class="swiper-slide">
                                    <div class="post-slider__item">
                                        <img class="lozad" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
                                        <div class="post-slider__contet">
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
                                </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </section>
        </div>
    </article>
</main>
<?php get_footer(); ?>