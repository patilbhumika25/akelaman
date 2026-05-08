<?php
/* Template Name: Service Page */
get_header();
?>

<!-- ── HERO SECTION ──────────────────────────────────────── -->
<section class="section-pad hero" style="min-height: 100vh; background: linear-gradient(135deg, #f8f6ff 0%, #ffffff 100%); display: flex; align-items: center; position: relative; overflow: hidden;">
    <!-- Abstract shape for background -->
    <div style="position: absolute; top: -10%; right: -5%; width: 40%; height: 60%; background: rgba(124, 77, 187, 0.03); border-radius: 50%; filter: blur(80px); z-index: 0;"></div>
    
    <div class="container relative" style="z-index: 1;">
        <?php while (have_posts()) : the_post(); 
            $details = akela_get_service_details(basename(get_permalink()));
        ?>
            <div class="grid-2" style="align-items: flex-start; gap: 64px;">
                <div data-aos="fade-right">
                    <div class="section-tag" style="color: #7c4dbb;"><?php echo esc_html($details['tag']); ?></div>
                    <h1 class="section-title" style="font-size: clamp(3rem, 5vw, 4.5rem); line-height: 1.1; margin-bottom: 24px; color: #7c4dbb;">
                        <?php the_title(); ?>
                    </h1>
                    <div class="content" style="font-size: 1.2rem; line-height: 1.8; color: #444; margin-bottom: 32px; max-width: 600px;">
                        <?php the_content(); ?>
                    </div>
                    
                    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                        <a href="<?php echo home_url('/#booking-section'); ?>" class="btn btn-primary pulsing-btn" style="padding: 16px 40px; font-size: 1.1rem; background: var(--accent-orange); border:none;">
                            Book a Session ✨
                        </a>
                        <a href="<?php echo home_url('/'); ?>" class="btn btn-outline" style="padding: 16px 40px; font-size: 1.1rem; border-color: #7c4dbb; color: #7c4dbb;">
                            Back to Home
                        </a>
                    </div>
                </div>
                
                <div data-aos="fade-left" style="background: #fff; padding: 48px; border-radius: 32px; box-shadow: 0 30px 90px rgba(124, 77, 187, 0.12); border: 1px solid rgba(124, 77, 187, 0.08);">
                    <h3 style="margin-bottom: 24px; font-family: var(--font-heading); color: #7c4dbb; font-size: 1.8rem;">What to Expect</h3>
                    <ul style="list-style: none; padding: 0;">
                        <?php foreach ($details['benefits'] as $b): ?>
                        <li style="display: flex; gap: 16px; align-items: flex-start; margin-bottom: 20px; font-size: 1.15rem; color: #555;">
                            <span style="color: #7c4dbb; font-size: 1.4rem; line-height: 1;">✔</span> 
                            <span><?php echo esc_html($b); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid #f0f0f0; display: flex; align-items: center; gap: 20px;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #f4f1ff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💬</div>
                        <div>
                            <p style="margin: 0; font-weight: 700; color: #333; font-size: 1.1rem;">Personalized Support</p>
                            <p style="margin: 0; font-size: 0.95rem; color: #777;">Tailored to your emotional needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <!-- Scroll indicator -->
    <div style="position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); text-align: center; color: #7c4dbb; opacity: 0.6;">
        <span style="display: block; font-size: 0.7rem; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 12px; font-weight: 700;">Discover More</span>
        <div style="width: 1px; height: 50px; background: linear-gradient(to bottom, #7c4dbb, transparent); margin: 0 auto;"></div>
    </div>
</section>

<!-- Additional "Features" Section -->
<section class="section-pad" style="background: #fafafa; border-top: 1px solid #eee;">
    <div class="container">
        <div class="text-center" style="margin-bottom: 64px;" data-aos="fade-up">
            <div class="section-tag" style="color: #7c4dbb;">Core Values</div>
            <h2 class="section-title">Why Choose <span><?php the_title(); ?></span></h2>
        </div>
        <div class="grid-3">
            <?php 
            $i = 0;
            foreach ($details['values'] as [$icon, $title, $text]): 
            ?>
            <div class="glass-card text-center" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>" style="padding: 48px 32px; background: #fff;">
                <div style="font-size: 3.5rem; margin-bottom: 24px;"><?php echo $icon; ?></div>
                <h4 style="margin-bottom: 16px; font-size: 1.4rem; color: #7c4dbb;"><?php echo esc_html($title); ?></h4>
                <p style="font-size: 1rem; line-height: 1.6;"><?php echo esc_html($text); ?></p>
            </div>
            <?php 
            $i++;
            endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
