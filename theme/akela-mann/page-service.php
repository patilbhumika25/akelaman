<?php
/* Template Name: Service Page */
get_header();
?>

<!-- ── HERO SECTION ──────────────────────────────────────── -->
<section class="section-pad hero" style="min-height: 50vh; background: linear-gradient(135deg, #f0edf8, #ffffff); display: flex; align-items: center;">
    <div class="container text-center">
        <?php while (have_posts()) : the_post(); ?>
            <div class="section-tag" data-aos="fade-up">Service</div>
            <h1 class="section-title" data-aos="fade-up" data-aos-delay="50" style="margin-bottom: 24px;"><?php the_title(); ?></h1>
            <div class="content" data-aos="fade-up" data-aos-delay="100" style="max-width: 800px; margin: 0 auto; font-size: 1.25rem; line-height: 1.8; color: var(--text-secondary);">
                <?php the_content(); ?>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" style="margin-top: 48px; display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo home_url('/#booking-section'); ?>" class="btn btn-primary pulsing-btn">Book a Session ✨</a>
                <a href="<?php echo home_url('/'); ?>" class="btn btn-outline">Back to Home</a>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>
