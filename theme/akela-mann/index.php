<?php get_header(); ?>

<?php if (is_home() || is_front_page()): ?>
    <?php // Handled by front-page.php ?>
<?php else: ?>

<section class="page-hero">
    <div class="container">
        <?php if (is_archive()): ?>
            <div class="section-tag">Archive</div>
            <h1 class="section-title"><?php the_archive_title(); ?></h1>
        <?php elseif (is_search()): ?>
            <div class="section-tag">Search</div>
            <h1 class="section-title">Results for: <span>"<?php get_search_query(); ?>"</span></h1>
        <?php else: ?>
            <div class="section-tag">News &amp; Stories</div>
            <h1 class="section-title">All <span>Stories</span></h1>
        <?php endif; ?>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="grid-3">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <div class="blog-card" data-aos="fade-up" data-aos-delay="100">
                <?php 
                $img_name = get_post_meta(get_the_ID(), '_akela_post_image', true);
                if ($img_name): ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/blog/<?php echo esc_attr($img_name); ?>" class="blog-card-img" alt="<?php the_title(); ?>">
                <?php elseif (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('blog-thumb', ['class' => 'blog-card-img']); ?>
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/blog1.png" class="blog-card-img" alt="">
                <?php endif; ?>
                <div class="blog-card-body">
                    <div class="blog-meta">
                        <span><?php echo get_the_date('d M Y'); ?></span> · <?php the_category(', '); ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="read-more">Read Story →</a>
                </div>
            </div>
            <?php endwhile;
            else: ?>
            <div class="glass-card" style="grid-column:1/-1;text-align:center;padding:64px;">
                <div style="font-size:3rem;margin-bottom:16px;">😶</div>
                <h3 style="font-family:var(--font-heading);">Nothing here yet</h3>
                <p>Check back soon — we're adding stories every week.</p>
                <a href="<?php echo home_url('/'); ?>" class="btn btn-primary" style="margin-top:16px;">Go Home</a>
            </div>
            <?php endif; ?>
        </div>
        <div style="margin-top:40px;display:flex;justify-content:center;">
            <?php the_posts_pagination(['prev_text' => '← Prev', 'next_text' => 'Next →']); ?>
        </div>
    </div>
</section>

<?php endif; ?>
<?php get_footer(); ?>
