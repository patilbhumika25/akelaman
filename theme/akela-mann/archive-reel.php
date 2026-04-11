<?php get_header(); ?>

<section class="page-hero">
    <div class="container">
        <div class="section-tag">Short Videos</div>
        <h1 class="section-title">Reels &amp; <span>Shorts</span></h1>
        <div class="breadcrumb"><a href="<?php echo home_url('/'); ?>">Home</a> → Reels</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="text-center" data-aos="fade-up" style="margin-bottom:48px;">
            <p class="section-subtitle" style="margin-bottom:0;">Bite-sized moments of comfort, wisdom, and connection. Watch, share, and know you are not alone.</p>
        </div>

        <div class="reels-grid">
            <?php
            $reels_q = new WP_Query(['post_type' => 'reel', 'posts_per_page' => 12]);
            if ($reels_q->have_posts()):
                while ($reels_q->have_posts()): $reels_q->the_post();
                    $embed = get_post_meta(get_the_ID(), '_embed_url', true);
                    $dur   = get_post_meta(get_the_ID(), '_duration', true);
            ?>
            <div class="reel-item" data-aos="fade-up" data-aos-delay="100" data-src="<?php echo esc_url($embed); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" data-price="Free Session">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('reel-thumb', ['class' => 'reel-bg-img']); ?>
                <?php else: ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hero.png" class="reel-bg-img" alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
                <div class="reel-play">
                    <div class="reel-play-btn">▶</div>
                </div>
                <div class="reel-info-layer">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/about.png" class="reel-thumb-small" alt="Thumbnail">
                    <div class="reel-info-text">
                        <div class="reel-title-sm"><?php the_title(); ?></div>
                        <div class="reel-subtitle-sm">Free Session</div>
                    </div>
                </div>
                <?php if ($dur): ?>
                <div style="position:absolute;top:8px;right:8px;background:rgba(0,0,0,0.7);color:#fff;padding:2px 8px;border-radius:4px;font-size:0.75rem;z-index:4;"><?php echo esc_html($dur); ?></div>
                <?php endif; ?>
            </div>
            <?php endwhile; wp_reset_postdata();
            else:
            // Placeholder reels
            $placeholder_reels = [
                ['You Are Enough', '0:45', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'Free Session'],
                ['The Weight of Silence', '1:12', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '₹ 500.00'],
                ['Finding Light', '0:58', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'Free Session'],
                ['Community Heals', '2:01', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '₹ 949.00'],
                ['Breathe Through It', '1:30', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'Free Session'],
                ['Morning Affirmations', '0:52', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '₹ 199.00'],
                ['The Practice of Presence', '1:18', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'Free Session'],
                ['Not Broken, Just Tired', '2:05', 'https://www.youtube.com/embed/dQw4w9WgXcQ', '₹ 499.00'],
            ];
            foreach ($placeholder_reels as $i => [$title, $dur, $src, $price]):
                $imgs = ['hero.png','about.png','services.png','blog1.png','blog2.png','blog3.png'];
            ?>
            <div class="reel-item" data-aos="fade-up" data-aos-delay="100" data-src="<?php echo $src; ?>" data-title="<?php echo $title; ?>" data-price="<?php echo $price; ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $imgs[$i % 6]; ?>" class="reel-bg-img" alt="<?php echo $title; ?>">
                <div class="reel-play">
                    <div class="reel-play-btn">▶</div>
                </div>
                <div class="reel-info-layer">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $imgs[($i + 1) % 6]; ?>" class="reel-thumb-small" alt="Thumbnail">
                    <div class="reel-info-text">
                        <div class="reel-title-sm"><?php echo $title; ?></div>
                        <div class="reel-subtitle-sm"><?php echo $price; ?></div>
                    </div>
                </div>
                <div style="position:absolute;top:8px;right:8px;background:rgba(0,0,0,0.7);color:#fff;padding:2px 8px;border-radius:4px;font-size:0.75rem;z-index:4;"><?php echo $dur; ?></div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reels = document.querySelectorAll('.reel-item');
    const modal = document.getElementById('reel-modal');
    const closeBtn = document.getElementById('modal-close');
    const iframe = document.getElementById('modal-video-frame');

    reels.forEach(reel => {
        reel.addEventListener('click', () => {
            const src = reel.getAttribute('data-src');
            if(src) {
                iframe.src = src + (src.indexOf('?') > -1 ? '&' : '?') + 'autoplay=1';
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        });
    });

    const closeModal = () => {
        if (modal) modal.style.display = 'none';
        if (iframe) iframe.src = '';
        document.body.style.overflow = '';
    };

    closeBtn?.addEventListener('click', closeModal);
    modal?.addEventListener('click', (e) => {
        if(e.target === modal) closeModal();
    });
});
</script>

<?php get_footer(); ?>
