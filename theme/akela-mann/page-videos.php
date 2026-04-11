<?php get_header(); ?>

<section class="page-hero">
    <div class="container">
        <div class="section-tag">Watch &amp; Learn</div>
        <h1 class="section-title">Videos &amp; <span>Talks</span></h1>
        <div class="breadcrumb"><a href="<?php echo home_url('/'); ?>">Home</a> → Videos</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="text-center" data-aos="fade-up" style="margin-bottom:48px;">
            <p class="section-subtitle" style="margin-bottom:0;">Full-length documentaries, talks, panel discussions, and guided sessions on loneliness and healing.</p>
        </div>

        <div class="videos-grid">
            <?php
            $videos_q = new WP_Query(['post_type' => 'video', 'posts_per_page' => 9]);
            if ($videos_q->have_posts()):
                while ($videos_q->have_posts()): $videos_q->the_post();
                    $embed = get_post_meta(get_the_ID(), '_embed_url', true);
            ?>
            <div class="video-card" data-aos="fade-up" data-aos-delay="100">
                <div class="video-embed">
                    <iframe src="<?php echo esc_url($embed); ?>" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen loading="lazy"></iframe>
                </div>
                <div class="video-meta">
                    <h4><?php the_title(); ?></h4>
                    <p style="font-size:0.85rem;"><?php the_excerpt(); ?></p>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata();
            else:
            $placeholder_videos = [
                ['Why Loneliness is a Public Health Crisis', '2024 • Talk', 'https://www.youtube.com/embed/n3Xv_g3g-mA'],
                ['The Science of Loneliness', '2023 • Documentary', 'https://www.youtube.com/embed/HEXWRTEbj1I'],
                ['How to Make Friends as an Adult', '2024 • Workshop', 'https://www.youtube.com/embed/q_C_ge3O0-U'],
                ['Loneliness in the Age of Social Media', '2024 • Panel', 'https://www.youtube.com/embed/wbPM_q7fFdE'],
                ['Finding Community After Loss', '2023 • Talk', 'https://www.youtube.com/embed/UKyf_F2t8jI'],
                ['Guided Meditation for Loneliness', '2024 • Practice', 'https://www.youtube.com/embed/YRPh_GaiL8s'],
            ];
            foreach ($placeholder_videos as [$title, $meta, $src]):
            ?>
            <div class="video-card" data-aos="fade-up" data-aos-delay="100">
                <div class="video-embed">
                    <iframe src="<?php echo $src; ?>" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen loading="lazy"></iframe>
                </div>
                <div class="video-meta">
                    <h4><?php echo $title; ?></h4>
                    <p style="font-size:0.82rem;color:var(--text-muted);"><?php echo $meta; ?></p>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-pad-sm" style="background:linear-gradient(135deg,#f0edf8,#ffffff);">
    <div class="container text-center">
        <h2 class="section-title">Want to Host a Live Session?</h2>
        <p class="section-subtitle">We run live webinars and Q&amp;A sessions every month. Reserve your spot.</p>
        <a href="<?php echo home_url('/booking'); ?>" class="btn btn-primary">Reserve a Spot →</a>
    </div>
</section>

<?php get_footer(); ?>
