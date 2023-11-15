<?php
/**
 * Header template.
 * 
 * @package Aqva
 */
?>
<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="container">
        <nav>
            <div class="menu-wrapper">
                <p class="header-btn">Company</p>
                <?php if (have_rows('menu_repitor', 'option')) : ?>
                    <ul class="header-menu">
                        <?php while (have_rows('menu_repitor', 'option')) : the_row(); ?>
                            <?php 
                            $img_url = get_sub_field('menu_repitor_img', 'option');
                            $name = get_sub_field('menu_repitor_name', 'option');
                            $url = get_sub_field('menu_repitor_link', 'option'); 
                            ?>
                            <li class="header-item">
                                <img class="lozad" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $img_url; ?>" alt="<?php echo $name; ?>">
                                <?php if (empty($url)) : ?>
                                    <p><?php echo $name . ' (soon)'; ?></p>
                                <?php else : ?>
                                    <a href="<?php echo $url; ?>"><?php echo $name; ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <button class="button">Log in</button>
        </nav>
    </div>
</header>
