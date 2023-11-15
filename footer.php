<?php
/**
 * Footer template.
 * 
 * @package Aqva
 */
?>
<footer>
    <div class="container">
        <div class="banner">
            <div data-background-image='<? echo get_template_directory_uri(); ?>/assets/img/background/grid.png' class="banner-grid lozad"></div>
            <div data-background-image='<? echo get_template_directory_uri(); ?>/assets/img/svg/mail-svg.svg' class="mail svg lozad"></div>
            <div class="banner-content">
                <p class="banner-title">
                    Subscribe for a newsletter
                </p>
                <p class="banner-subtitle">
                    Share your email so we can send you latest </br>LaFinteca news
                </p>
                <form method="POST" class="form">
                    <label>
                        <input type="email" name="email" class="input" placeholder="Email">
                    </label>
                    <label>
                        <input type="submit" class="send-form " value="Submit">
                    </label>
                </form>
            </div>
            <div style="background-image: url(data:image/gif;base64,R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==) ;" data-background-image='<? echo get_template_directory_uri(); ?>/assets/img/svg/hand-svg.svg' class="hand svg lozad"></div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>