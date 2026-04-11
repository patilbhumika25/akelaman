<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

<section class="page-hero">
    <div class="container">
        <div class="section-tag"><?php the_category(' · '); ?> · <?php echo get_the_date('d M Y'); ?></div>
        <h1 class="section-title" style="max-width:800px;margin:0 auto 16px;"><?php the_title(); ?></h1>
        <div class="breadcrumb"><a href="<?php echo home_url('/'); ?>">Home</a> → <a href="<?php echo home_url('/blogs'); ?>">Blogs</a> → <?php the_title(); ?></div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 340px;gap:48px;" class="blog-layout">
            <!-- Article -->
            <article>
                <!-- Image removed as requested -->

                <div style="display:flex;gap:16px;align-items:center;margin-bottom:32px;flex-wrap:wrap;">
                    <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#7c4dbb,#2d1b60);display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;"><?php echo strtoupper(substr(get_the_author(),0,1)); ?></div>
                    <div>
                        <div style="font-weight:600;font-size:0.9rem;"><?php the_author(); ?></div>
                        <div style="font-size:0.8rem;color:var(--text-muted);"><?php echo get_the_date('d M Y'); ?> · <?php echo ceil(str_word_count(strip_tags(get_the_content())) / 200); ?> min read</div>
                    </div>
                </div>

                <div class="post-content" style="max-width:720px;">
                    <?php the_content(); ?>
                </div>

                <!-- Tags -->
                <?php if (has_tag()): ?>
                <div style="margin-top:48px;padding-top:32px;border-top:1px solid rgba(164,123,224,0.1);">
                    <span style="font-size:0.85rem;color:var(--text-muted);">Tags: </span>
                    <?php the_tags('<span style="display:inline-flex;gap:8px;flex-wrap:wrap;">',', ','</span>'); ?>
                </div>
                <?php endif; ?>

                <!-- Navigation -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:40px;">
                    <div><?php previous_post_link('<div class="glass-card" style="text-align:left;"><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:6px;">← Previous</div><div style="font-size:0.9rem;font-family:var(--font-heading);">%link</div></div>'); ?></div>
                    <div><?php next_post_link('<div class="glass-card" style="text-align:right;"><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:6px;">Next →</div><div style="font-size:0.9rem;font-family:var(--font-heading);">%link</div></div>'); ?></div>
                </div>
            </article>

            <!-- Sidebar -->
            <aside>
                <!-- CTA -->
                <div class="glass-card" style="margin-bottom:24px;text-align:center;">
                    <div style="font-size:2.5rem;margin-bottom:12px;">🌙</div>
                    <h4 style="font-family:var(--font-heading);margin-bottom:10px;">Need to Talk?</h4>
                    <p style="font-size:0.88rem;">Book a free session with our compassionate listeners.</p>
                    <a href="<?php echo home_url('/booking'); ?>" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:16px;">Book Now ✨</a>
                </div>

                <!-- Recent Posts -->
                <div class="glass-card">
                    <h4 style="font-family:var(--font-heading);margin-bottom:16px;">Recent Stories</h4>
                    <?php
                    $recent = get_posts(['numberposts' => 4, 'exclude' => [get_the_ID()]]);
                    foreach ($recent as $rp):
                        $thumb = get_the_post_thumbnail_url($rp->ID, 'thumbnail');
                    ?>
                    <a href="<?php echo get_permalink($rp->ID); ?>" style="display:flex;gap:12px;margin-bottom:16px;border-bottom:1px solid rgba(164,123,224,0.1);padding-bottom:16px;text-decoration:none;">
                        <div style="min-width:60px;height:60px;border-radius:8px;overflow:hidden;background:rgba(26,26,62,0.5);">
                            <?php 
                            $rp_img = get_post_meta($rp->ID, '_akela_post_image', true);
                            if ($rp_img): ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/blog/<?php echo esc_attr($rp_img); ?>" style="width:60px;height:60px;object-fit:cover;" alt="">
                            <?php elseif ($thumb): ?>
                            <img src="<?php echo esc_url($thumb); ?>" style="width:60px;height:60px;object-fit:cover;" alt="">
                            <?php endif; ?>
                        </div>
                        <div>
                            <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);line-height:1.3;"><?php echo esc_html($rp->post_title); ?></div>
                            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px;"><?php echo get_the_date('d M Y', $rp); ?></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </aside>
        </div>
    </div>
</section>

<style>
.post-content p { color: var(--text-muted); font-size:1rem; line-height:1.8; margin-bottom:1.5rem; }
.post-content h2,
.post-content h3 { font-family:var(--font-heading); margin:2rem 0 1rem; }
.post-content blockquote { border-left:4px solid var(--accent-purple); padding:16px 24px; margin:24px 0; background:rgba(124,77,187,0.08); border-radius:0 8px 8px 0; font-style:italic; }
.post-content a { color:var(--accent-lavender); }
@media(max-width:768px) { .blog-layout { grid-template-columns:1fr !important; } }
</style>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
