<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8f9fc">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ── Site Header / Navbar ───────────────────────────────── -->
<header class="site-header" id="site-header">
    <nav class="nav-inner">
        <a href="<?php echo home_url('/'); ?>" class="site-logo">
            <div class="logo-mark">AM</div>
            <span class="logo-text">Akela <span>Mann</span></span>
        </a>

        <div class="main-nav" id="main-nav">

            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => '',
                'fallback_cb'    => function() { ?>
                    <ul>
                        <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                        <li><a href="<?php echo home_url('/#testimonials-section'); ?>">About Us</a></li>
                        <li><a href="<?php echo home_url('/#services-section'); ?>">Services</a></li>
                        <li><a href="<?php echo home_url('/#blog-section'); ?>">Blogs</a></li>
                        <li><a href="<?php echo home_url('/reels'); ?>">Reels</a></li>
                        <li><a href="<?php echo home_url('/videos'); ?>">Videos</a></li>
                        <li><a href="<?php echo home_url('/#site-footer'); ?>">Contact</a></li>
                    </ul>
                <?php }
            ]);
            ?>

        </div>

        <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </nav>
</header>
<!-- ── / Site Header ──────────────────────────────────────── -->
